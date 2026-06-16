<?php

namespace App\Livewire\Supplier;

use App\Models\SupplierProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class SupplierDocumentLibrary extends Component
{
    use WithFileUploads;

    #[Layout('layouts.supplier')]

    public bool $isUploadModalOpen = false;
    public string $selectedField = '';
    public string $selectedFieldLabel = '';

    public $uploaded_file;
    public string $associated_product_ref = '';

    protected $rules = [
        'uploaded_file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        'associated_product_ref' => 'nullable|string|max:100',
    ];

    public function getDocumentMapProperty(): array
    {
        return [
            'file_sales_contract' => ['label' => 'Sales Sourcing Contract', 'folder' => 'supplier_docs/contracts', 'icon' => 'gavel'],
            'file_commercial_invoice' => ['label' => 'Commercial Invoice', 'folder' => 'supplier_docs/invoices', 'icon' => 'receipt_long'],
            'file_packing_list' => ['label' => 'Packing List Manifest', 'folder' => 'supplier_docs/packing_lists', 'icon' => 'inventory_2'],
            'file_certificate_of_origin' => ['label' => 'Certificate of Origin', 'folder' => 'supplier_docs/origins', 'icon' => 'public'],
            'file_test_analysis_report' => ['label' => 'Test Analysis Report', 'folder' => 'supplier_docs/analysis', 'icon' => 'biotech'],
            'supplier_invoice' => ['label' => 'Supplier Invoice', 'folder' => 'supplier_docs/supplier_invoices', 'icon' => 'account_balance_wallet'],
            'proforma_invoice' => ['label' => 'Proforma Invoice', 'folder' => 'supplier_docs/proforma_invoices', 'icon' => 'request_quote'],
            'file_bill_of_lading' => ['label' => 'Bill of Lading Copy', 'folder' => 'supplier_docs/lading', 'icon' => 'local_shipping'],
            'file_insurance_certificate' => ['label' => 'Maritime Insurance Certificate', 'folder' => 'supplier_docs/insurance', 'icon' => 'verified_user'],
            'file_product_spec_sheet' => ['label' => 'Product Specification Sheet', 'folder' => 'supplier_docs/specs', 'icon' => 'assignment'],
            'product_manufacturing_certifications' => ['label' => 'Product Manufacturing Certifications', 'folder' => 'supplier_docs/certification', 'icon' => 'workspace_premium'],
            'returns_warranty_policy' => ['label' => 'Returns & Warranty Policy Log', 'folder' => 'supplier_docs/warranty', 'icon' => 'assignment_return'],
            'file_others' => ['label' => 'Other Supporting Documents', 'folder' => 'supplier_docs/others', 'icon' => 'note_add'],
        ];
    }

    public function openUploadModal(string $field)
    {
        $map = $this->documentMap;
        if (!array_key_exists($field, $map))
            return;

        $this->selectedField = $field;
        $this->selectedFieldLabel = $map[$field]['label'];
        $this->reset(['uploaded_file', 'associated_product_ref']);
        $this->isUploadModalOpen = true;
    }

    public function closeUploadModal()
    {
        $this->isUploadModalOpen = false;
        $this->reset(['selectedField', 'selectedFieldLabel', 'uploaded_file', 'associated_product_ref']);
    }

    public function appendDocument()
    {
        $this->validate();

        $supplier = Auth::guard('supplier')->user();
        $map = $this->documentMap;

        if (!array_key_exists($this->selectedField, $map))
            return;

        $folderPath = $map[$this->selectedField]['folder'];
        $savedFilePath = $this->uploaded_file->store($folderPath, 'public');

        $currentStack = $supplier->{$this->selectedField} ?? [];
        if (!is_array($currentStack)) {
            $currentStack = [];
        }

        $currentStack[] = [
            'file_path' => $savedFilePath,
            'product_ref' => filled($this->associated_product_ref) ? $this->associated_product_ref : null,
        ];

        $supplier->update([
            $this->selectedField => $currentStack
        ]);

        $this->closeUploadModal();
        session()->flash('success', "Document added to your library successfully.");
    }

    /**
     * Remove a targeted file element from a specific JSON array stack index entirely.
     */
    public function removeDocument(string $field, int $index)
    {
        $map = $this->documentMap;
        if (!array_key_exists($field, $map))
            return;

        $supplier = Auth::guard('supplier')->user();
        $currentStack = $supplier->{$field} ?? [];

        if (isset($currentStack[$index])) {
            // 1. Purge the actual physical file path asset completely from storage disk
            if (isset($currentStack[$index]['file_path'])) {
                Storage::disk('public')->delete($currentStack[$index]['file_path']);
            }

            // 2. Remove element node from the associative structure array block
            unset($currentStack[$index]);

            // 3. Re-index array sequences to fix sequential array formatting keys for Eloquent JSON serialization
            $currentStack = array_values($currentStack);

            // 4. Persist updated changes
            $supplier->update([
                $field => !empty($currentStack) ? $currentStack : null
            ]);

            session()->flash('success', "Document asset removed from your library history successfully.");
        }
    }

    public function render()
    {
        return view('livewire.supplier.supplier-document-library', [
            'supplier' => Auth::guard('supplier')->user()
        ]);
    }
}
