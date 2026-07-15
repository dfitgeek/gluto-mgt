<?php

namespace App\Http\Controllers;

use App\Models\SupplierProfile;
use App\Models\RegistrationOnboardingToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserSaveSupplierProfile extends Controller
{
    /**
     * Parse, validate, and persist the complete multi-file array-structured dataset.
     */
    public function store(Request $request, string $token)
    {
        // 1. Authenticate token using the configuration model
        $onboardingToken = RegistrationOnboardingToken::with('user')
            ->where('token', $token)
            ->where('is_used', false)
            ->first();

        if (!$onboardingToken || $onboardingToken->isExpired()) {
            abort(403, 'This registration link has expired, is invalid, or was already used.');
        }

        $user = $onboardingToken->user;

        // 2. Strict mapping constraints validation covering all 10 document upload tracks
        $validated = $request->validate([
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

            'password' => 'required|string|min:8|confirmed',
            'names_of_board_directors' => 'nullable|string',
            'director_position_title' => 'nullable|string|max:255',
            'director_email' => 'nullable|email|max:255',

            'rep_legal_name' => 'required|string|max:255',
            'rep_position_title' => 'nullable|string|max:255',
            'rep_email' => 'required|email|max:255',
            'rep_phone_number' => 'required|string|max:50',

            'categorization_of_products' => 'nullable|string|max:255',
            'overall_moqs' => 'nullable|string|max:255',
            'customization_options' => 'nullable|string',
            'manufacturing_locations' => 'nullable|string',
            'production_capacity' => 'nullable|string|max:255',
            'pricing_structure_type' => 'nullable|string|max:100',
            'currency_accepted' => 'required|string|max:50',
            'shipping_methods_available' => 'nullable|string|max:255',
            'payment_terms' => 'nullable|string',

            'social_twitter' => 'nullable|string|max:100',
            'social_facebook' => 'nullable|string|max:100',
            'social_instagram' => 'nullable|string|max:100',
            'social_threads' => 'nullable|string|max:100',
            'social_linkedin' => 'nullable|string|max:100',

            // All Document Assets Validation Rulesets
            'company_icon_path' => 'nullable|image|max:2048',
            'file_sales_contract' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_commercial_invoice' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_packing_list' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_certificate_of_origin' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_test_analysis_report' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_bill_of_lading' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_insurance_certificate' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_product_spec_sheet' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'product_manufacturing_certifications' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'returns_warranty_policy' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_others' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'supplier_invoice' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'proforma_invoice' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',

            // Complementary Product Reference Inputs Matrix Validations
            'file_sales_contract_prod_ref' => 'nullable|string|max:100',
            'file_commercial_invoice_prod_ref' => 'nullable|string|max:100',
            'file_packing_list_prod_ref' => 'nullable|string|max:100',
            'file_certificate_of_origin_prod_ref' => 'nullable|string|max:100',
            'file_test_analysis_report_prod_ref' => 'nullable|string|max:100',
            'file_bill_of_lading_prod_ref' => 'nullable|string|max:100',
            'file_insurance_certificate_prod_ref' => 'nullable|string|max:100',
            'file_product_spec_sheet_prod_ref' => 'nullable|string|max:100',
            'product_manufacturing_certifications_prod_ref' => 'nullable|string|max:100',
            'returns_warranty_policy_prod_ref' => 'nullable|string|max:100',
            'file_others_prod_ref' => 'nullable|string|max:100',
            'supplier_invoice_prod_ref' => 'nullable|string|max:100',
            'proforma_invoice_prod_ref' => 'nullable|string|max:100',

            'declaration_authorized_person' => 'required|string|max:255',
            'declaration_title' => 'required|string|max:255',
            'declaration_signature_path' => 'required|image|max:2048',
            'supplier_ref_number' => 'required|string|max:100|unique:supplier_profiles,supplier_ref_number',
        ]);

        // 3. Document/File Upload Processing Engine Loop into structured arrays
        $processedFiles = [];
        $fileFields = [
            'file_sales_contract' => 'supplier_docs/contracts',
            'file_commercial_invoice' => 'supplier_docs/invoices',
            'file_packing_list' => 'supplier_docs/packing_lists',
            'file_certificate_of_origin' => 'supplier_docs/origins',
            'file_test_analysis_report' => 'supplier_docs/analysis',
            'file_bill_of_lading' => 'supplier_docs/lading',
            'file_insurance_certificate' => 'supplier_docs/insurance',
            'file_product_spec_sheet' => 'supplier_docs/specs',
            'product_manufacturing_certifications' => 'supplier_docs/certification',
            'returns_warranty_policy' => 'supplier_docs/warranty',
            'file_others' => 'supplier_docs/others',
            'supplier_invoice' => 'supplier_docs/supplier_invoices',
            'proforma_invoice' => 'supplier_docs/proforma_invoices',
        ];

        foreach ($fileFields as $field => $folder) {
            if ($request->hasFile($field) && $request->file($field)->isValid()) {
                $savedPath = $request->file($field)->store($folder, 'public');

                $prodRefInput = $request->input($field . '_prod_ref');
                $productRef = !empty($prodRefInput) ? $prodRefInput : null;

                // Build a nested array object list to align with Model array casts
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

        // Processing standalone image path files (Non-json)
        $iconPath = $request->hasFile('company_icon_path') ? $request->file('company_icon_path')->store('supplier_icons', 'public') : null;
        $signaturePath = $request->hasFile('declaration_signature_path') ? $request->file('declaration_signature_path')->store('supplier_signatures', 'public') : null;

        $socials = array_filter([
            'twitter' => $request->input('social_twitter'),
            'facebook' => $request->input('social_facebook'),
            'instagram' => $request->input('social_instagram'),
            'threads' => $request->input('social_threads'),
            'linkedin' => $request->input('social_linkedin'),
        ]);

        // dd($validated['customization_options']);

        $supplier = SupplierProfile::create([
            'user_id' => $user->id,
            'supplier_ref_number' => $validated['supplier_ref_number'],
            'status_label' => 'Unverified Supplier',

            'company_icon_path' => $iconPath,
            'company_name' => $validated['company_name'],
            'address' => $validated['address'],
            'phone_telephone' => $validated['phone_telephone'],
            'email_address' => $validated['email_address'],
            'website' => $validated['website'],
            'whatsapp_contact' => $validated['whatsapp_contact'],
            'social_media' => !empty($socials) ? $socials : null,
            'reg_number' => $validated['reg_number'],
            'type_of_business' => $validated['type_of_business'],
            'nature_of_business' => $validated['nature_of_business'],
            'year_established' => $validated['year_established'],
            'names_of_board_directors' => $validated['names_of_board_directors'],
            'director_position_title' => $validated['director_position_title'],
            'director_email' => $validated['director_email'],
            'password' => Hash::make($validated['password']),

            'rep_legal_name' => $validated['rep_legal_name'],
            'rep_position_title' => $validated['rep_position_title'],
            'rep_email' => $validated['rep_email'],
            'rep_phone_number' => $validated['rep_phone_number'],

            'categorization_of_products' => $validated['categorization_of_products'],
            'overall_moqs' => $validated['overall_moqs'],
            // 'customization_options' => $validated['customization_options'],
            'ability_to_provide_samples' => $request->has('ability_to_provide_samples'),
            'manufacturing_locations' => $validated['manufacturing_locations'],
            'production_capacity' => $validated['production_capacity'],
            'pricing_structure_type' => $validated['pricing_structure_type'],
            'payment_terms' => $validated['payment_terms'],
            'currency_accepted' => $validated['currency_accepted'],
            'shipping_methods_available' => $validated['shipping_methods_available'],

            // Structural Multi-Document Array Assignment Mappings
            'file_sales_contract' => $processedFiles['file_sales_contract'],
            'file_commercial_invoice' => $processedFiles['file_commercial_invoice'],
            'file_packing_list' => $processedFiles['file_packing_list'],
            'file_certificate_of_origin' => $processedFiles['file_certificate_of_origin'],
            'file_test_analysis_report' => $processedFiles['file_test_analysis_report'],
            'file_bill_of_lading' => $processedFiles['file_bill_of_lading'],
            'file_insurance_certificate' => $processedFiles['file_insurance_certificate'],
            'file_product_spec_sheet' => $processedFiles['file_product_spec_sheet'],
            'product_manufacturing_certifications' => $processedFiles['product_manufacturing_certifications'],
            'returns_warranty_policy' => $processedFiles['returns_warranty_policy'],
            'file_others' => $processedFiles['file_others'],
            'supplier_invoice' => $processedFiles['supplier_invoice'],
            'proforma_invoice' => $processedFiles['proforma_invoice'],

            'lead_source' => 'Supplier Portal Self-Registration Link',
            'date_of_initial_contact' => now()->format('Y-m-d'),

            'declares_gmo_free' => $request->has('declares_gmo_free'),
            'declares_gluten_free' => $request->has('declares_gluten_free'),
            'declares_non_irradiated' => $request->has('declares_non_irradiated'),
            'declares_no_nanomaterials' => $request->has('declares_no_nanomaterials'),
            'complies_haccp_gmp' => $request->has('complies_haccp_gmp'),

            'declaration_authorized_person' => $validated['declaration_authorized_person'],
            'declaration_title' => $validated['declaration_title'],
            'declaration_signature_path' => $signaturePath,
        ]); //[cite: 5]

        // 5. Invalidate the tracking onboarding token
        $onboardingToken->update([
            'is_used' => true,
            'used_at' => now(),
        ]); //[cite: 5]

        try {
            \App\Services\NotificationMailService::notifyNewSupplierRegistration($supplier);
            return redirect()->route('supplier.login')->with('success', 'Corporate verification documentation submitted successfully. Our internal compliance panel will review your credentials within 48 hours.'); //[cite: 5]
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Supplier registration email failed: ' . $e->getMessage());
            return redirect()->route('supplier.login')->with('warning', 'Corporate verification documentation submitted successfully, but we experienced an issue dispatching the welcome email to your inbox.'); //[cite: 5]
        }
    }
}
