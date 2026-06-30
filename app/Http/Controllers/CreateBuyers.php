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
        // 1. Precise validation checking against only active database fields
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'buyer_ref_number' => 'required|string|max:100|unique:buyer_profiles,buyer_ref_number',
            'company_icon_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'company_name' => 'required|string|max:255',
            'company_registration_number' => 'nullable|string|max:100',
            'vat_tax_id_number' => 'nullable|string|max:100',
            'nature_of_business' => 'nullable|string|max:255',
            'company_website' => 'nullable|string|max:255',
            'country_of_registration' => 'required|string|max:255',
            'year_established' => 'nullable|integer|min:1800|max:' . date('Y'),
            'password' => 'nullable|string|min:6',

            // Representative details
            'rep_full_name' => 'required|string|max:255',
            'rep_position' => 'required|string|max:255',
            'rep_nationality' => 'nullable|string|max:100',
            'rep_id_passport_number' => 'nullable|string|max:100',
            'rep_mobile_whatsapp' => 'required|string|max:50',
            'rep_email' => 'required|email|max:255',
            'office_address' => 'nullable|string',

            // --- REFACTORED COMPLIANCE ASSET FILE VALIDATIONS ---
            'company_reg_doc' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'id_card' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',

            // Social Media Channel Form Parameters
            'social_twitter' => 'nullable|string|max:100',
            'social_facebook' => 'nullable|string|max:100',
            'social_instagram' => 'nullable|string|max:100',
            'social_threads' => 'nullable|string|max:100',
            'social_linkedin' => 'nullable|string|max:100',
        ]);

        // 2. Process documents cleanly as array wrappers without metadata tracking keys
        $processedFiles = [];
        $fileFieldsMap = [
            'company_reg_doc' => 'buyer_docs/registration',
            'id_card' => 'buyer_docs/identification',
        ];

        foreach ($fileFieldsMap as $field => $storagePath) {
            if ($request->hasFile($field) && $request->file($field)->isValid()) {
                $savedPath = $request->file($field)->store($storagePath, 'public');
                $processedFiles[$field] = [
                    [
                        'file_path' => $savedPath,
                    ]
                ];
            } else {
                $processedFiles[$field] = null;
            }
        }

        // Clean and process nested social media dictionary data blocks
        $socialChannels = array_filter([
            'twitter' => $request->input('social_twitter'),
            'facebook' => $request->input('social_facebook'),
            'instagram' => $request->input('social_instagram'),
            'threads' => $request->input('social_threads'),
            'linkedin' => $request->input('social_linkedin'),
        ]);

        $iconPath = $request->hasFile('company_icon_path')
            ? $request->file('company_icon_path')->store('buyer_icons', 'public')
            : null;

        $passwordString = $request->filled('password')
            ? Hash::make($request->input('password'))
            : Hash::make('glutobuyer');

        // 3. Save and persist cleanly to database structure
        BuyerProfile::create([
            'user_id' => $validated['user_id'] ?? null,
            'buyer_ref_number' => $validated['buyer_ref_number'],
            'company_icon_path' => $iconPath,
            'company_name' => $validated['company_name'],
            'company_registration_number' => $validated['company_registration_number'],
            'social_media' => !empty($socialChannels) ? $socialChannels : null,
            'vat_tax_id_number' => $validated['vat_tax_id_number'],
            'nature_of_business' => $validated['nature_of_business'],
            'company_website' => $validated['company_website'],
            'country_of_registration' => $validated['country_of_registration'],
            'year_established' => $validated['year_established'],
            'password' => $passwordString,

            // Representative coordinates mapping
            'rep_full_name' => $validated['rep_full_name'],
            'rep_position' => $validated['rep_position'],
            'rep_nationality' => $validated['rep_nationality'],
            'rep_id_passport_number' => $validated['rep_id_passport_number'],
            'rep_mobile_whatsapp' => $validated['rep_mobile_whatsapp'],
            'rep_email' => $validated['rep_email'],
            'office_address' => $validated['office_address'],

            // Refactored document entries fields
            'company_reg_doc' => $processedFiles['company_reg_doc'],
            'id_card' => $processedFiles['id_card'],
        ]);

        return redirect()->route('admin.buyers.manage')
            ->with('success', "Buyer profile card for '{$validated['company_name']}' has been registered cleanly into the system network.");
    }
}
