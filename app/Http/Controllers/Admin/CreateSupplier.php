<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupplierProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateSupplier extends Controller
{
    public function index()
    {
        return view('admin.create-supplier');
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'reg_number' => 'required|string|max:100',
            'year_established' => 'nullable|integer|min:1800|max:' . date('Y'),
            'email_address' => 'required|email|max:255',
            'phone_telephone' => 'required|string|max:50',
            'whatsapp_contact' => 'nullable|string|max:50',
            'type_of_business' => 'nullable|string|max:100',
            'nature_of_business' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'address' => 'required|string',

            'names_of_board_directors' => 'nullable|string',
            'director_position_title' => 'nullable|string|max:255',
            'director_email' => 'nullable|email|max:255',

            'rep_legal_name' => 'required|string|max:255',
            'rep_position_title' => 'nullable|string|max:255',
            'rep_email' => 'required|email|max:255',
            'rep_phone_number' => 'required|string|max:50',

            'categorization_of_products' => 'nullable|string|max:255',
            'overall_moqs' => 'nullable|string|max:255',
            'production_capacity' => 'nullable|string|max:255',
            'currency_accepted' => 'required|string|max:50',
            'shipping_methods_available' => 'nullable|string|max:255',
            'pricing_structure_type' => 'nullable|string|max:100',
            'manufacturing_locations' => 'nullable|string',
            'payment_terms' => 'nullable|string',

            'social_twitter' => 'nullable|string|max:100',
            'social_facebook' => 'nullable|string|max:100',
            'social_instagram' => 'nullable|string|max:100',
            'social_threads' => 'nullable|string|max:100',
            'social_linkedin' => 'nullable|string|max:100',

            // --- STRATEGIC ASSET VALIDATION TRACKS ---
            'company_icon_path' => 'nullable|image|max:2048',
            'file_sales_contract' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_commercial_invoice' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_packing_list' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_product_spec_sheet' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_test_analysis_report' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'product_manufacturing_certifications' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'returns_warranty_policy' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'declaration_signature_path' => 'nullable|image|max:2048',
            'file_others' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'supplier_invoice' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'proforma_invoice' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',

            // Product Reference Mappings for Json Attachment Fields
            'file_sales_contract_prod_ref' => 'nullable|string|max:100',
            'file_commercial_invoice_prod_ref' => 'nullable|string|max:100',
            'file_packing_list_prod_ref' => 'nullable|string|max:100',
            'file_product_spec_sheet_prod_ref' => 'nullable|string|max:100',
            'file_test_analysis_report_prod_ref' => 'nullable|string|max:100',
            'product_manufacturing_certifications_prod_ref' => 'nullable|string|max:100',
            'returns_warranty_policy_prod_ref' => 'nullable|string|max:100',
            'supplier_invoice_prod_ref' => 'nullable|string|max:100',
            'proforma_invoice_prod_ref' => 'nullable|string|max:100',

            'declaration_authorized_person' => 'nullable|string|max:255',
            'declaration_title' => 'nullable|string|max:255',
            'supplier_ref_number' => 'required|string|max:100|unique:supplier_profiles,supplier_ref_number',
            'assigned_manager' => 'nullable|string|max:255',
            'lead_source' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        // 2. PROCESS FILE UPLOAD ENGINE WITH STRUCTURAL JSON OBJECT PACKAGING
        $processedFiles = [];
        $fileFields = [
            'file_sales_contract' => 'supplier_docs/contracts',
            'file_commercial_invoice' => 'supplier_docs/invoices',
            'file_packing_list' => 'supplier_docs/packing_lists',
            'file_product_spec_sheet' => 'supplier_docs/specs',
            'file_test_analysis_report' => 'supplier_docs/analysis',
            'product_manufacturing_certifications' => 'supplier_docs/certification',
            'returns_warranty_policy' => 'supplier_docs/warranty',
            'file_others' => 'supplier_docs/others',
            'supplier_invoice' => 'supplier_docs/supplier_invoices',
            'proforma_invoice' => 'supplier_docs/proforma_invoices',
        ];

        foreach ($fileFields as $field => $storagePath) {
            if ($request->hasFile($field) && $request->file($field)->isValid()) {
                $savedPath = $request->file($field)->store($storagePath, 'public');

                // Fetch dynamic product reference companion input string if available, fallback to null
                $prodRefInput = $request->input($field . '_prod_ref');
                $productRef = !empty($prodRefInput) ? $prodRefInput : null;

                // Structure metadata array package to meet Model Cast boundaries
                $processedFiles[$field] = [
                    [
                        'file_path' => $savedPath,
                        'product_ref' => $productRef
                    ]
                ];
            } else {
                $processedFiles[$field] = null;
            }
        }

        // Standard standalone system images paths processing (Non-json fields)
        $iconPath = $request->hasFile('company_icon_path') ? $request->file('company_icon_path')->store('supplier_icons', 'public') : null;
        $signaturePath = $request->hasFile('declaration_signature_path') ? $request->file('declaration_signature_path')->store('supplier_signatures', 'public') : null;

        // 3. Process and merge the social media inputs into a clean JSON array string
        $socialChannels = array_filter([
            'twitter' => $request->input('social_twitter'),
            'facebook' => $request->input('social_facebook'),
            'instagram' => $request->input('social_instagram'),
            'threads' => $request->input('social_threads'),
            'linkedin' => $request->input('social_linkedin'),
        ]);

        // 4. Save and persist the record model mapping directly
        SupplierProfile::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'supplier_ref_number' => $validated['supplier_ref_number'],
            'status_label' => 'Unverified Supplier',

            'company_icon_path' => $iconPath,
            'company_name' => $validated['company_name'],
            'reg_number' => $validated['reg_number'],
            'year_established' => $validated['year_established'],
            'email_address' => $validated['email_address'],
            'phone_telephone' => $validated['phone_telephone'],
            'whatsapp_contact' => $validated['whatsapp_contact'],
            'type_of_business' => $validated['type_of_business'],
            'nature_of_business' => $validated['nature_of_business'],
            'website' => $validated['website'],
            'address' => $validated['address'],
            'social_media' => !empty($socialChannels) ? $socialChannels : null,
            'names_of_board_directors' => $validated['names_of_board_directors'],
            'director_position_title' => $validated['director_position_title'],
            'director_email' => $validated['director_email'],

            'rep_legal_name' => $validated['rep_legal_name'],
            'rep_position_title' => $validated['rep_position_title'],
            'rep_email' => $validated['rep_email'],
            'rep_phone_number' => $validated['rep_phone_number'],

            'categorization_of_products' => $validated['categorization_of_products'],
            'overall_moqs' => $validated['overall_moqs'],
            'production_capacity' => $validated['production_capacity'],
            'currency_accepted' => $validated['currency_accepted'],
            'shipping_methods_available' => $validated['shipping_methods_available'],
            'pricing_structure_type' => $validated['pricing_structure_type'],
            'manufacturing_locations' => $validated['manufacturing_locations'],
            'ability_to_provide_samples' => $request->has('ability_to_provide_samples'),
            'payment_terms' => $validated['payment_terms'],

            // --- STRATEGIC ASSIGNMENT OF ENCODED METADATA ARRAYS ---
            'file_sales_contract' => $processedFiles['file_sales_contract'],
            'file_commercial_invoice' => $processedFiles['file_commercial_invoice'],
            'file_packing_list' => $processedFiles['file_packing_list'],
            'file_product_spec_sheet' => $processedFiles['file_product_spec_sheet'],
            'file_test_analysis_report' => $processedFiles['file_test_analysis_report'],
            'product_manufacturing_certifications' => $processedFiles['product_manufacturing_certifications'],
            'returns_warranty_policy' => $processedFiles['returns_warranty_policy'],
            'file_others' => $processedFiles['file_others'],
            'supplier_invoice' => $processedFiles['supplier_invoice'],
            'proforma_invoice' => $processedFiles['proforma_invoice'],

            'assigned_manager' => $validated['assigned_manager'],
            'lead_source' => $validated['lead_source'] ?? 'Admin Dashboard Manual Entry',
            'date_of_initial_contact' => now()->format('Y-m-d'),
            'declaration_authorized_person' => $validated['declaration_authorized_person'],
            'declaration_title' => $validated['declaration_title'],
            'declaration_signature_path' => $signaturePath,

            'declares_gmo_free' => $request->has('declares_gmo_free'),
            'declares_gluten_free' => $request->has('declares_gluten_free'),
            'complies_haccp_gmp' => $request->has('complies_haccp_gmp'),
            'declares_non_irradiated' => $request->has('declares_non_irradiated'),
        ]);

        return redirect()->route('admin.suppliers.manage')->with('success', 'New supplier profile cataloged successfully with document references.');
    }
}
