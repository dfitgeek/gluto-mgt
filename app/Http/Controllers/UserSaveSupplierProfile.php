<?php

namespace App\Http\Controllers;

use App\Models\SupplierProfile;
use App\Models\RegistrationOnboardingToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserSaveSupplierProfile extends Controller
{
    /**
     * Securely parse, validate, and store the extensive supplier onboarding profile dataset.
     */
    public function store(Request $request, string $token)
    {
        // 1. Authenticate token using your actual model relation configuration
        $onboardingToken = RegistrationOnboardingToken::with('user')
            ->where('token', $token)
            ->where('is_used', false)
            ->first();

        if (!$onboardingToken || $onboardingToken->isExpired()) {
            abort(403, 'This registration link has expired, is invalid, or was already used.');
        }

        $user = $onboardingToken->user;

        // 2. Comprehensive validation constraints mapping absolutely all migration fields
        $validated = $request->validate([
            // Step 1: Company Profile
            'company_name'       => 'required|string|max:255',
            'reg_number'         => 'required|string|max:100',
            'year_established'   => 'nullable|integer|min:1800|max:' . date('Y'),
            'email_address'      => 'required|email|max:255',
            'phone_telephone'    => 'required|string|max:50',
            'whatsapp_contact'   => 'nullable|string|max:50',
            'type_of_business'   => 'nullable|string|max:100',
            'nature_of_business' => 'nullable|string|max:255',
            'website'            => 'nullable|string|max:255',
            'address'            => 'required|string',

            // Password and Board of Directors Setup
            'password'                 => 'required|string|min:8|confirmed',
            'names_of_board_directors' => 'nullable|string',
            'director_position_title'  => 'nullable|string|max:255',
            'director_email'           => 'nullable|email|max:255',

            // Step 2: Legal Representative
            'rep_legal_name'     => 'required|string|max:255',
            'rep_position_title' => 'nullable|string|max:255',
            'rep_email'          => 'required|email|max:255',
            'rep_phone_number'   => 'required|string|max:50',

            // Step 3: Terms & Capabilities
            'categorization_of_products' => 'nullable|string|max:255',
            'overall_moqs'               => 'nullable|string|max:255',
            'customization_options'      => 'nullable|string',
            'manufacturing_locations'    => 'nullable|string',
            'production_capacity'        => 'nullable|string|max:255',
            'pricing_structure_type'     => 'nullable|string|max:100',
            'currency_accepted'          => 'required|string|max:50',
            'shipping_methods_available' => 'nullable|string|max:255',
            'payment_terms'              => 'nullable|string',

            // Social Media Fields (Validated independently)
            'social_twitter'   => 'nullable|string|max:100',
            'social_facebook'  => 'nullable|string|max:100',
            'social_instagram' => 'nullable|string|max:100',
            'social_threads'   => 'nullable|string|max:100',
            'social_linkedin'  => 'nullable|string|max:100',

            // Step 4: Core Files Upload Layer (Max 5MB each)
            'company_icon_path'         => 'nullable|image|max:2048',
            'file_sales_contract'       => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_commercial_invoice'   => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_packing_list'         => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_certificate_of_origin'=> 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_test_analysis_report' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_bill_of_lading'       => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_insurance_certificate'=> 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_product_spec_sheet'   => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_others'               => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',

            // Step 5 & 6: Sign-off & System Reference
            'declaration_authorized_person' => 'required|string|max:255',
            'declaration_title'             => 'required|string|max:255',
            'declaration_signature_path'    => 'required|image|max:2048',
            'supplier_ref_number'           => 'required|string|max:100|unique:supplier_profiles,supplier_ref_number',
        ]);

        // 3. Document/File Upload Storage Core Engine Loops
        $filePaths = [];
        $fileFields = [
            'company_icon_path'          => 'supplier_icons',
            'file_sales_contract'        => 'supplier_docs/contracts',
            'file_commercial_invoice'    => 'supplier_docs/invoices',
            'file_packing_list'          => 'supplier_docs/packing_lists',
            'file_certificate_of_origin' => 'supplier_docs/origins',
            'file_test_analysis_report'  => 'supplier_docs/analysis',
            'file_bill_of_lading'        => 'supplier_docs/lading',
            'file_insurance_certificate' => 'supplier_docs/insurance',
            'file_product_spec_sheet'    => 'supplier_docs/specs',
            'file_others'                => 'supplier_docs/others',
            'declaration_signature_path' => 'supplier_signatures'
        ];

        foreach ($fileFields as $field => $folder) {
            if ($request->hasFile($field) && $request->file($field)->isValid()) {
                $filePaths[$field] = $request->file($field)->store($folder, 'public');
            } else {
                $filePaths[$field] = null;
            }
        }

        // 4. Compact social channels into clean associative structures (Model Cast Auto-handles encoding)
        $socials = array_filter([
            'twitter'   => $request->input('social_twitter'),
            'facebook'  => $request->input('social_facebook'),
            'instagram' => $request->input('social_instagram'),
            'threads'   => $request->input('social_threads'),
            'linkedin'  => $request->input('social_linkedin'),
        ]);

        // 5. Persist the SupplierProfile database row mapping
        SupplierProfile::create([
            'user_id'             => $user->id,
            'supplier_ref_number' => $validated['supplier_ref_number'],
            'status_label'        => 'Unverified Supplier', // Baseline verification label

            // 1. Corporate Identity Core details
            'company_icon_path'        => $filePaths['company_icon_path'],
            'company_name'             => $validated['company_name'],
            'address'                  => $validated['address'],
            'phone_telephone'          => $validated['phone_telephone'],
            'email_address'            => $validated['email_address'],
            'website'                  => $validated['website'],
            'whatsapp_contact'         => $validated['whatsapp_contact'],
            'social_media'             => !empty($socials) ? $socials : null,
            'reg_number'               => $validated['reg_number'],
            'type_of_business'         => $validated['type_of_business'],
            'nature_of_business'       => $validated['nature_of_business'],
            'year_established'         => $validated['year_established'],
            'names_of_board_directors' => $validated['names_of_board_directors'],
            'director_position_title'  => $validated['director_position_title'],
            'director_email'           => $validated['director_email'],
            'password'                 => Hash::make($validated['password']), // Securely sets custom account key string

            // 2. Representative fields
            'rep_legal_name'     => $validated['rep_legal_name'],
            'rep_position_title' => $validated['rep_position_title'],
            'rep_email'          => $validated['rep_email'],
            'rep_phone_number'   => $validated['rep_phone_number'],

            // 3. Technical capabilities matrices
            'categorization_of_products' => $validated['categorization_of_products'],
            'overall_moqs'               => $validated['overall_moqs'],
            'customization_options'      => $validated['customization_options'],
            'ability_to_provide_samples' => $request->has('ability_to_provide_samples'),
            'manufacturing_locations'    => $validated['manufacturing_locations'],
            'production_capacity'        => $validated['production_capacity'],
            'product_manufacturing_certifications' => $request->filled('product_manufacturing_certifications') ? $validated['product_manufacturing_certifications'] : null,
            'returns_warranty_policy'    => $request->filled('returns_warranty_policy') ? $validated['returns_warranty_policy'] : null,
            'pricing_structure_type'     => $validated['pricing_structure_type'],
            'payment_terms'              => $validated['payment_terms'],
            'currency_accepted'          => $validated['currency_accepted'],
            'shipping_methods_available' => $validated['shipping_methods_available'],

            // 4. File attachments strings
            'file_sales_contract'        => $filePaths['file_sales_contract'],
            'file_commercial_invoice'    => $filePaths['file_commercial_invoice'],
            'file_packing_list'          => $filePaths['file_packing_list'],
            'file_certificate_of_origin' => $filePaths['file_certificate_of_origin'],
            'file_test_analysis_report'  => $filePaths['file_test_analysis_report'],
            'file_bill_of_lading'        => $filePaths['file_bill_of_lading'],
            'file_insurance_certificate' => $filePaths['file_insurance_certificate'],
            'file_product_spec_sheet'    => $filePaths['file_product_spec_sheet'],
            'file_others'                => $filePaths['file_others'],

            // 5. Tracker labels
            'lead_source'             => 'Supplier Portal Self-Registration Link',
            'date_of_initial_contact' => now()->format('Y-m-d'),

            // 6. Checklist flags
            'declares_gmo_free'         => $request->has('declares_gmo_free'),
            'declares_gluten_free'      => $request->has('declares_gluten_free'),
            'declares_non_irradiated'   => $request->has('declares_non_irradiated'),
            'declares_no_nanomaterials'  => $request->has('declares_no_nanomaterials'),
            'complies_haccp_gmp'        => $request->has('complies_haccp_gmp'),

            // Sign-off
            'declaration_authorized_person' => $validated['declaration_authorized_person'],
            'declaration_title'             => $validated['declaration_title'],
            'declaration_signature_path'    => $filePaths['declaration_signature_path'],
        ]);

        // 6. Burn token track records immediately to force absolute single-use security
        $onboardingToken->update([
            'is_used' => true,
            'used_at' => now(),
        ]);

        return redirect()->route('login')->with('success', 'Corporate verification documentation submitted successfully. Our internal compliance panel will review your credentials within 48 hours.');
    }
}
