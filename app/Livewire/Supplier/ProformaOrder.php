<?php

namespace App\Livewire\Supplier;

use App\Models\BuyerOrder;
use App\Models\SupplierProduct;
use App\Models\SupplierProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProformaOrder extends Component
{
    use WithFileUploads;

    #[Layout('layouts.supplier')]

    public bool $isInvoiceModalOpen = false;
    public ?int $activeOrderId = null;
    public $invoice_file;

    protected array $rules = [
        'invoice_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
    ];

    public function openInvoiceModal(int $orderId)
    {
        $this->activeOrderId = $orderId;
        $this->reset('invoice_file');
        $this->isInvoiceModalOpen = true;
    }

    public function closeInvoiceModal()
    {
        $this->isInvoiceModalOpen = false;
        $this->reset(['activeOrderId', 'invoice_file']);
    }

    public function uploadInvoice()
    {
        $this->validate();

        $supplier = Auth::guard('supplier')->user(); // model instance
        $supplierId = $supplier->id;

        // Safe Fallback Guard: Secure checks against either the direct ID or product reference maps
        $myProductRefs = SupplierProduct::where('supplier_profile_id', $supplierId)
            ->pluck('product_ref')
            ->toArray();

        $order = BuyerOrder::where('id', $this->activeOrderId)
            ->where(function ($query) use ($supplierId, $myProductRefs) {
                $query->where('supplier_profile_id', $supplierId)
                    ->orWhereIn('prod_ref', $myProductRefs);
            })
            ->firstOrFail();

        $meta = $order->payment_meta ?? [];
        if (!is_array($meta)) {
            $meta = [];
        }

        if (isset($meta['supplier_invoice'])) {
            Storage::disk('public')->delete($meta['supplier_invoice']);
        }

        $savedPath = $this->invoice_file->store('supplier_invoices', 'public');
        $meta['supplier_invoice'] = $savedPath;

        $order->update([
            'payment_meta' => $meta,
            'order_progress' => $order->order_progress === 'Unprocessed order' ? 'Processed Buyer' : $order->order_progress
        ]);

        $this->closeInvoiceModal();
        session()->flash('success', "Commercial invoice successfully dispatched to Order reference #{$order->order_ref_number}.");
    }

    public function render()
    {
        $supplier = Auth::guard('supplier')->user(); // model instance
        $supplierInfo = $supplier->id;

        // dd($supplierInfo);

        // 1. Gather product refs to capture older records that don't have the new supplier_profile_id column mapped yet
        $myProductRefs = SupplierProduct::where('supplier_profile_id', $supplierInfo)
            ->pluck('product_ref')
            ->toArray();

        // 2. Query both fields so it catches old rows AND perfectly fetches new incoming entries
        $associatedOrders = BuyerOrder::where('supplier_profile_id', $supplierInfo)
            ->orWhereIn('prod_ref', $myProductRefs)
            ->latest()
            ->get();

        return view('livewire.supplier.proforma-order', [
            'orders' => $associatedOrders
        ]);
    }
}
