<?php

namespace App\Livewire\Admin;

use App\Models\SupplierProfile; // Adjust based on your model name
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;


class CreateSupplier extends Component {
    use WithFileUploads;

    #[Layout('layouts.admin')]

    // Wizard Step Controller Property managed via Alpine on blade
    public string $activeTab = 'company';

    // Form Schema Properties
    public string $status_label = 'Unverified Supplier';
    public $supplier_ref_number;

    // 1. Supplier Company Information
    public $company_icon_path;
    public $company_name;
    public $address;
    public $phone_telephone;
    public $email_address;
    public $website;
    public $whatsapp_contact;
    public $social_media;
    public $reg_number;
    public string $type_of_business = '';
    public $nature_of_business;
    public $year_established;

    // 2. Authorized Representative Details
    public $rep_legal_name;
    public $rep_position_title;
    public $rep_email;
    public $rep_phone_number;

    // #[Validate('required|string|max:255')]

    // 3. Capabilities & Overall Commercial Terms
    public $categorization_of_products;
    public $overall_moqs;
    public $production_capacity;
    public $currency_accepted = 'USD';
    public $shipping_methods_available;
    public bool $ability_to_provide_samples = false;
    public $payment_terms;

    // 4. Onboarding Document Attachments
    public $file_sales_contract;
    public $file_commercial_invoice;
    public $file_packing_list;
    public $file_product_spec_sheet;
    public $file_test_analysis_report;

    // #[Validate('required|company_name')]

    // 5. Compliance & Metadata
    public bool $declares_gmo_free = false;
    public bool $declares_gluten_free = false;
    public bool $complies_haccp_gmp = false;
    public bool $declares_non_irradiated = false;
    public $lead_source = 'Direct Organic Registration Form';

    public function mount()
    {
        $this->activeTab = 'company';
        // Securely pre-generate tracking tokens
        $this->supplier_ref_number = 'SUP-' . strtoupper(bin2hex(random_bytes(2))) . '-' . rand(1000, 9999);
    }

    public function saveSupplier()
    {

        // dd('ff');


        // Enforce validations matching your exact inputs (Max: 5MB per document attachment)
        $this->validate([
            // Required Strings
            'company_name' => 'required|string|max:255',
            'email_address' => 'required|email|max:255',
            'phone_telephone' => 'required|string',
            'reg_number' => 'required|string',
            // 'rep_legal_name' => 'required|string',
            // 'rep_email' => 'required|email',
            'rep_phone_number' => 'required|string',

            // Reusable Document Vault Acceptable Extensions (pdf, docx, image formats)
            'company_icon_path'         => 'nullable|image|max:2048', // 2MB Max for Icons
            'file_sales_contract'       => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'file_commercial_invoice'   => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'file_packing_list'         => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'file_product_spec_sheet'   => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'file_test_analysis_report' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);




        // Process File Execution Pipeline & Storage Assignments
        $storedIcon             = $this->company_icon_path ? $this->company_icon_path->store('supplier_icons', 'public') : null;
        $storedSalesContract    = $this->file_sales_contract ? $this->file_sales_contract->store('supplier_docs/contracts', 'public') : null;
        $storedInvoice          = $this->file_commercial_invoice ? $this->file_commercial_invoice->store('supplier_docs/invoices', 'public') : null;
        $storedPackingList      = $this->file_packing_list ? $this->file_packing_list->store('supplier_docs/packing_lists', 'public') : null;
        $storedSpecSheet        = $this->file_product_spec_sheet ? $this->file_product_spec_sheet->store('supplier_docs/specs', 'public') : null;
        $storedAnalysisReport   = $this->file_test_analysis_report ? $this->file_test_analysis_report->store('supplier_docs/analysis', 'public') : null;

        // Persist data directly into your database schema mapping
        SupplierProfile::create([
            'supplier_ref_number' => $this->supplier_ref_number,
            'status_label'        => $this->status_label,

            // 1. Company General Details
            'company_icon_path' => $storedIcon,
            'company_name'      => $this->company_name,
            'address'           => $this->address,
            'phone_telephone'   => $this->phone_telephone,
            'email_address'     => $this->email_address,
            'website'           => $this->website,
            'whatsapp_contact'  => $this->whatsapp_contact,
            'social_media'      => $this->social_media,
            'reg_number'        => $this->reg_number,
            'type_of_business'  => $this->type_of_business,
            'nature_of_business'=> $this->nature_of_business,
            'year_established'  => $this->year_established,

            // 2. Rep Details
            'rep_legal_name'     => $this->rep_legal_name,
            'rep_position_title' => $this->rep_position_title,
            'rep_email'          => $this->rep_email,
            'rep_phone_number'   => $this->rep_phone_number,

            // 3. Logistics Capabilities
            'categorization_of_products' => $this->categorization_of_products,
            'overall_moqs'               => $this->overall_moqs,
            'production_capacity'        => $this->production_capacity,
            'currency_accepted'          => $this->currency_accepted,
            'shipping_methods_available' => $this->shipping_methods_available,
            'ability_to_provide_samples' => $this->ability_to_provide_samples,
            'payment_terms'              => $this->payment_terms,

            // 4. Generated Storage Path Links Mapping
            'file_sales_contract'       => $storedSalesContract,
            'file_commercial_invoice'   => $storedInvoice,
            'file_packing_list'         => $storedPackingList,
            'file_product_spec_sheet'   => $storedSpecSheet,
            'file_test_analysis_report' => $storedAnalysisReport,

            // 5. Declarations Checklist Properties
            'declares_gmo_free'         => $this->declares_gmo_free,
            'declares_gluten_free'      => $this->declares_gluten_free,
            'complies_haccp_gmp'        => $this->complies_haccp_gmp,
            'declares_non_irradiated'   => $this->declares_non_irradiated,
            'lead_source'               => $this->lead_source,
        ]);

        session()->flash('success', 'Supplier Account Log generated successfully!');
        return $this->redirectRoute('admin.dashboard', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.create-supplier');
    }
}
