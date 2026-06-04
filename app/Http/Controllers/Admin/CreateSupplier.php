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
        // 1. Enforce validation across all required strings, files, and multi-social arrays
        $validator = \Validator::make($request->all(), [
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

            // Board Directors Fields
            'names_of_board_directors' => 'nullable|string',
            'director_position_title'  => 'nullable|string|max:255',
            'director_email'           => 'nullable|email|max:255',

            // Legal Representative Fields
            'rep_legal_name'     => 'required|string|max:255',
            'rep_position_title' => 'nullable|string|max:255',
            'rep_email'          => 'required|email|max:255',
            'rep_phone_number'   => 'required|string|max:50',

            // Commercial Terms Slots
            'categorization_of_products' => 'nullable|string|max:255',
            'overall_moqs'               => 'nullable|string|max:255',
            'production_capacity'        => 'nullable|string|max:255',
            'currency_accepted'          => 'required|string|max:50',
            'shipping_methods_available' => 'nullable|string|max:255',
            'pricing_structure_type'     => 'nullable|string|max:100',
            'manufacturing_locations'    => 'nullable|string',
            'product_manufacturing_certifications' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'returns_warranty_policy'    => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'payment_terms'              => 'nullable|string',

            // Isolated Segregated Social media input validations checks
            'social_twitter'   => 'nullable|string|max:100',
            'social_facebook'  => 'nullable|string|max:100',
            'social_instagram' => 'nullable|string|max:100',
            'social_threads'   => 'nullable|string|max:100',
            'social_linkedin'  => 'nullable|string|max:100',

            // Attachments
            'company_icon_path'         => 'nullable|image|max:2048',
            'file_sales_contract'       => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_commercial_invoice'   => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_packing_list'         => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_product_spec_sheet'   => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_test_analysis_report' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',

            // Sign-off section checks
            'declaration_authorized_person' => 'nullable|string|max:255',
            'declaration_title'             => 'nullable|string|max:255',
            'declaration_signature_path'    => 'nullable|image|max:2048',

            'supplier_ref_number' => 'required|string|max:100|unique:supplier_profiles,supplier_ref_number',
            'assigned_manager'    => 'nullable|string|max:255',
            'lead_source'         => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            // dd($validator->errors());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        // 2. Process File Upload Arrays frame sequentially to public disks
        $files = [];
        $fileFields = [
            'company_icon_path'           => 'supplier_icons',
            'file_sales_contract'         => 'supplier_docs/contracts',
            'file_commercial_invoice'     => 'supplier_docs/invoices',
            'file_packing_list'           => 'supplier_docs/packing_lists',
            'file_product_spec_sheet'     => 'supplier_docs/specs',
            'file_test_analysis_report'   => 'supplier_docs/analysis',
            'product_manufacturing_certifications'   => 'supplier_docs/certification',
            'returns_warranty_policy'   => 'supplier_docs/warranty',
            'declaration_signature_path'  => 'supplier_signatures'
        ];

        foreach ($fileFields as $field => $path) {
            if ($request->hasFile($field) && $request->file($field)->isValid()) {
                $files[$field] = $request->file($field)->store($path, 'public');
            } else {
                $files[$field] = null;
            }
        }

        // 3. Process and merge the social media inputs into a clean JSON array string
        $socialChannels = array_filter([
            'twitter'   => $request->input('social_twitter'),
            'facebook'  => $request->input('social_facebook'),
            'instagram' => $request->input('social_instagram'),
            'threads'   => $request->input('social_threads'),
            'linkedin'  => $request->input('social_linkedin'),
        ]);

        $jsonSocialMediaString = !empty($socialChannels) ? json_encode($socialChannels) : null;

        // 4. Save and persist the record model mapping directly
        SupplierProfile::create([
            // Enforces direct auth user relationship links, fallback to null for unauthenticated context profiles
            'user_id'             => Auth::check() ? Auth::id() : null,
            'supplier_ref_number' => $validated['supplier_ref_number'],
            'status_label'        => 'Unverified Supplier',

            // 1. General Company Profile Specs
            'company_icon_path'         => $files['company_icon_path'],
            'company_name'              => $validated['company_name'],
            'reg_number'                => $validated['reg_number'],
            'year_established'          => $validated['year_established'],
            'email_address'             => $validated['email_address'],
            'phone_telephone'           => $validated['phone_telephone'],
            'whatsapp_contact'          => $validated['whatsapp_contact'],
            'type_of_business'          => $validated['type_of_business'],
            'nature_of_business'        => $validated['nature_of_business'],
            'website'                   => $validated['website'],
            'address'                   => $validated['address'],
            'social_media'              => $jsonSocialMediaString, // Persisted as clean parsed string data log
            'names_of_board_directors'  => $validated['names_of_board_directors'],
            'director_position_title'   => $validated['director_position_title'],
            'director_email'            => $validated['director_email'],

            // 2. Representative Coordinates
            'rep_legal_name'     => $validated['rep_legal_name'],
            'rep_position_title' => $validated['rep_position_title'],
            'rep_email'          => $validated['rep_email'],
            'rep_phone_number'   => $validated['rep_phone_number'],

            // 3. Operational Logistics Parameters
            'categorization_of_products' => $validated['categorization_of_products'],
            'overall_moqs'               => $validated['overall_moqs'],
            'production_capacity'        => $validated['production_capacity'],
            'currency_accepted'          => $validated['currency_accepted'],
            'shipping_methods_available' => $validated['shipping_methods_available'],
            'pricing_structure_type'     => $validated['pricing_structure_type'],
            'manufacturing_locations'    => $validated['manufacturing_locations'],
            'product_manufacturing_certifications' => $files['product_manufacturing_certifications'],
            'returns_warranty_policy'    => $files['returns_warranty_policy'],
            'ability_to_provide_samples' => $request->has('ability_to_provide_samples'),
            'payment_terms'              => $validated['payment_terms'],

            // 4. File Links Storage Paths mapping
            'file_sales_contract'       => $files['file_sales_contract'],
            'file_commercial_invoice'   => $files['file_commercial_invoice'],
            'file_packing_list'         => $files['file_packing_list'],
            'file_product_spec_sheet'   => $files['file_product_spec_sheet'],
            'file_test_analysis_report' => $files['file_test_analysis_report'],

            // 5. Internal Account Tracker Logs metadata & Signatures
            'assigned_manager'          => $validated['assigned_manager'],
            'lead_source'               => $validated['lead_source'] ?? 'Admin Dashboard Manual Entry',
            'date_of_initial_contact'   => now()->format('Y-m-d'), // Automatically maps straight into your migration tracking column date parameters
            'declaration_authorized_person' => $validated['declaration_authorized_person'],
            'declaration_title'             => $validated['declaration_title'],
            'declaration_signature_path'    => $files['declaration_signature_path'],

            // 6. Direct Checklist Booleans
            'declares_gmo_free'         => $request->has('declares_gmo_free'),
            'declares_gluten_free'      => $request->has('declares_gluten_free'),
            'complies_haccp_gmp'        => $request->has('complies_haccp_gmp'),
            'declares_non_irradiated'   => $request->has('declares_non_irradiated'),
        ]);

        return redirect()->route('admin.suppliers.manage')->with('success', 'New supplier profile cataloged successfully.');
    }
}
