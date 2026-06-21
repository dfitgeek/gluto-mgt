<?php

namespace App\Livewire\Buyer;

use App\Models\BuyerProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class BuyerDocumentLibrary extends Component
{
    use WithFileUploads;

    #[Layout('layouts.buyer')]

    // Modal state properties
    public bool $isUploadModalOpen = false;
    public string $selectedField = '';
    public string $selectedFieldLabel = '';

    // Upload stream bindings
    public $uploaded_file;
    public string $associated_product_ref = '';

    protected array $rules = [
        'uploaded_file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // Max 5MB
        'associated_product_ref' => 'nullable|string|max:100',
    ];

    /**
     * Define the dictionary blueprint of all JSON fields available for expansion.
     */
    public function getDocumentMapProperty(): array
    {
        return [
            'file_sales_contract' => ['label' => 'Sales Sourcing Contract', 'folder' => 'buyer_docs/contracts', 'icon' => 'gavel'],
            'file_commercial_invoice' => ['label' => 'Commercial Invoice Scans', 'folder' => 'buyer_docs/invoices', 'icon' => 'receipt_long'],
            'file_packing_list' => ['label' => 'Packing List Manifest', 'folder' => 'buyer_docs/packing_lists', 'icon' => 'inventory_2'],
            'file_certificate_of_origin' => ['label' => 'Certificate of Origin', 'folder' => 'buyer_docs/origins', 'icon' => 'public'],
            'file_test_analysis_report' => ['label' => 'Test Analysis Report', 'folder' => 'buyer_docs/analysis', 'icon' => 'biotech'],
            'file_bill_of_lading' => ['label' => 'Bill of Lading Copy', 'folder' => 'buyer_docs/lading', 'icon' => 'local_shipping'],
            'file_insurance_certificate' => ['label' => 'Insurance Certificate', 'folder' => 'buyer_docs/insurance', 'icon' => 'verified_user'],
            'file_product_spec_sheet' => ['label' => 'Product Specification Sheet', 'folder' => 'buyer_docs/specs', 'icon' => 'assignment'],
            'file_others' => ['label' => 'Other Supporting Documents', 'folder' => 'buyer_docs/others', 'icon' => 'note_add'],
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

    /**
     * Append a fresh document entry into the target JSON array stack.
     */
    public function appendDocument()
    {
        $this->validate();

        $buyer = Auth::guard('buyer')->user();
        $map = $this->documentMap;

        if (!array_key_exists($this->selectedField, $map))
            return;

        $folderPath = $map[$this->selectedField]['folder'];
        $savedFilePath = $this->uploaded_file->store($folderPath, 'public');

        $currentStack = $buyer->{$this->selectedField} ?? [];
        if (!is_array($currentStack)) {
            $currentStack = [];
        }

        $currentStack[] = [
            'file_path' => $savedFilePath,
            'product_ref' => filled($this->associated_product_ref) ? $this->associated_product_ref : null,
        ];

        $buyer->update([
            $this->selectedField => $currentStack
        ]);

        $this->closeUploadModal();
        session()->flash('success', "New document entry successfully uploaded.");
    }

    /**
     * Delete an individual entry element node from a targeted JSON stack array.
     */
    public function removeDocument(string $field, int $index)
    {
        $map = $this->documentMap;
        if (!array_key_exists($field, $map))
            return;

        $buyer = Auth::guard('buyer')->user();
        $currentStack = $buyer->{$field} ?? [];

        if (isset($currentStack[$index])) {
            if (isset($currentStack[$index]['file_path'])) {
                Storage::disk('public')->delete($currentStack[$index]['file_path']);
            }

            unset($currentStack[$index]);
            $currentStack = array_values($currentStack); // Reset sequence indices keys

            $buyer->update([
                $field => !empty($currentStack) ? $currentStack : null
            ]);

            session()->flash('success', "Document reference purged from history ledger vault successfully.");
        }
    }

    public function render()
    {
        return view('livewire.buyer.buyer-document-library', [
            'buyer' => Auth::guard('buyer')->user()
        ]);
    }
}
