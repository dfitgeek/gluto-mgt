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

    protected array $rules = [
        'uploaded_file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // Max 5MB
    ];

    /**
     * Blueprint of active compliance JSON fields from the migration.
     */
    public function getDocumentMapProperty(): array
    {
        return [
            'company_reg_doc' => ['label' => 'Company Registration Document', 'folder' => 'buyer_docs/registration', 'icon' => 'gavel'],
            'id_card' => ['label' => 'Representative Identity Card / Passport', 'folder' => 'buyer_docs/identification', 'icon' => 'badge'],
        ];
    }

    public function openUploadModal(string $field)
    {
        $map = $this->documentMap;
        if (!array_key_exists($field, $map)) {
            return;
        }

        $this->selectedField = $field;
        $this->selectedFieldLabel = $map[$field]['label'];
        $this->reset('uploaded_file');
        $this->isUploadModalOpen = true;
    }

    public function closeUploadModal()
    {
        $this->isUploadModalOpen = false;
        $this->reset(['selectedField', 'selectedFieldLabel', 'uploaded_file']);
    }

    /**
     * Append a fresh document entry globally to the target JSON array stack.
     */
    public function appendDocument()
    {
        $this->validate();

        $buyer = Auth::guard('buyer')->user();
        $map = $this->documentMap;

        if (!array_key_exists($this->selectedField, $map)) {
            return;
        }

        $folderPath = $map[$this->selectedField]['folder'];
        $savedFilePath = $this->uploaded_file->store($folderPath, 'public');

        $currentStack = $buyer->{$this->selectedField} ?? [];
        if (!is_array($currentStack)) {
            $currentStack = [];
        }

        // Appends file paths uniformly without product tracking keys
        $currentStack[] = [
            'file_path' => $savedFilePath,
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
        if (!array_key_exists($field, $map)) {
            return;
        }

        $buyer = Auth::guard('buyer')->user();
        $currentStack = $buyer->{$field} ?? [];

        if (isset($currentStack[$index])) {
            if (isset($currentStack[$index]['file_path'])) {
                Storage::disk('public')->delete($currentStack[$index]['file_path']);
            }

            unset($currentStack[$index]);
            $currentStack = array_values($currentStack); // Reset sequential keys

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
