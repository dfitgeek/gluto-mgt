<?php

namespace App\Http\Controllers;

use App\Models\BuyerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CreateBuyers extends Controller
{
    /**
     * Parse, validate, and store a newly provisioned multi-step Buyer Profile card.
     */
    public function store(Request $request)
    {
        // 1. Precise execution checking against all database columns
        $validated = $request->validate([
            'user_id'                     => 'nullable|exists:users,id',
            'buyer_ref_number'            => 'required|string|max:100|unique:buyer_profiles,buyer_ref_number',
            'company_name'                => 'required|string|max:255',
            'company_registration_number' => 'nullable|string|max:100',
            'vat_tax_id_number'           => 'nullable|string|max:100',
            'nature_of_business'          => 'nullable|string|max:255',
            'company_website'             => 'nullable|string|max:255',
            'country_of_registration'     => 'required|string|max:255',
            'year_established'            => 'nullable|integer|min:1800|max:' . date('Y'),
            'password'                    => 'nullable|string|min:6',

            // Representative details
            'rep_full_name'          => 'required|string|max:255',
            'rep_position'           => 'required|string|max:255',
            'rep_nationality'        => 'nullable|string|max:100',
            'rep_id_passport_number' => 'nullable|string|max:100',
            'rep_mobile_whatsapp'    => 'required|string|max:50',
            'rep_email'              => 'required|email|max:255',
            'office_address'         => 'nullable|string',

            // --- STRATEGIC ASSET FILE VALIDATIONS ---
            'file_sales_contract'        => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_commercial_invoice'    => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_packing_list'          => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_certificate_of_origin' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_test_analysis_report'  => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_bill_of_lading'        => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_insurance_certificate' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_product_spec_sheet'    => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_others'                => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',

            // Companion Document Metadata Reference Inputs
            'file_sales_contract_prod_ref'        => 'nullable|string|max:100',
            'file_commercial_invoice_prod_ref'    => 'nullable|string|max:100',
            'file_packing_list_prod_ref'          => 'nullable|string|max:100',
            'file_certificate_of_origin_prod_ref' => 'nullable|string|max:100',
            'file_test_analysis_report_prod_ref'  => 'nullable|string|max:100',
            'file_bill_of_lading_prod_ref'        => 'nullable|string|max:100',
            'file_insurance_certificate_prod_ref' => 'nullable|string|max:100',
            'file_product_spec_sheet_prod_ref'    => 'nullable|string|max:100',
            'file_others_prod_ref'                => 'nullable|string|max:100',
        ]);

        // 2. Process documentation arrays frame into structured multidimensional objects arrays
        $processedFiles = [];
        $fileFieldsMap = [
            'file_sales_contract'        => 'buyer_docs/contracts',
            'file_commercial_invoice'    => 'buyer_docs/invoices',
            'file_packing_list'          => 'buyer_docs/packing_lists',
            'file_certificate_of_origin' => 'buyer_docs/origins',
            'file_test_analysis_report'  => 'buyer_docs/analysis',
            'file_bill_of_lading'        => 'buyer_docs/lading',
            'file_insurance_certificate' => 'buyer_docs/insurance',
            'file_product_spec_sheet'    => 'buyer_docs/specs',
            'file_others'                => 'buyer_docs/others',
        ];

        foreach ($fileFieldsMap as $field => $storagePath) {
            if ($request->hasFile($field) && $request->file($field)->isValid()) {
                $savedPath = $request->file($field)->store($storagePath, 'public');
                $prodRefInput = $request->input($field . '_prod_ref');

                $processedFiles[$field] = [
                    [
                        'file_path'   => $savedPath,
                        'product_ref' => !empty($prodRefInput) ? $prodRefInput : null
                    ]
                ];
            } else {
                $processedFiles[$field] = null;
            }
        }

        // 3. Fallback credential password hashing checks
        $passwordString = $request->filled('password')
            ? Hash::make($request->input('password'))
            : Hash::make('glutobuyer');

        // 4. Save and persist everything to your buyer_profiles table database structure
        BuyerProfile::create([
            'user_id'                     => $validated['user_id'] ?? null,
            'buyer_ref_number'            => $validated['buyer_ref_number'],
            'company_name'                => $validated['company_name'],
            'company_registration_number' => $validated['company_registration_number'],
            'vat_tax_id_number'           => $validated['vat_tax_id_number'],
            'nature_of_business'          => $validated['nature_of_business'],
            'company_website'             => $validated['company_website'],
            'country_of_registration'     => $validated['country_of_registration'],
            'year_established'            => $validated['year_established'],
            'password'                    => $passwordString,

            // Representative coordinates mapping
            'rep_full_name'          => $validated['rep_full_name'],
            'rep_position'           => $validated['rep_position'],
            'rep_nationality'        => $validated['rep_nationality'],
            'rep_id_passport_number' => $validated['rep_id_passport_number'],
            'rep_mobile_whatsapp'    => $validated['rep_mobile_whatsapp'],
            'rep_email'              => $validated['rep_email'],
            'office_address'         => $validated['office_address'],

            // Array serialized documentation attachments
            'file_sales_contract'        => $processedFiles['file_sales_contract'],
            'file_commercial_invoice'    => $processedFiles['file_commercial_invoice'],
            'file_packing_list'          => $processedFiles['file_packing_list'],
            'file_certificate_of_origin' => $processedFiles['file_certificate_of_origin'],
            'file_test_analysis_report'  => $processedFiles['file_test_analysis_report'],
            'file_bill_of_lading'        => $processedFiles['file_bill_of_lading'],
            'file_insurance_certificate' => $processedFiles['file_insurance_certificate'],
            'file_product_spec_sheet'    => $processedFiles['file_product_spec_sheet'],
            'file_others'                => $processedFiles['file_others'],
        ]);

        return redirect()->route('admin.suppliers.manage')
            ->with('success', "Buyer profile card for '{$validated['company_name']}' has been registered cleanly into the system network.");
    }
}
