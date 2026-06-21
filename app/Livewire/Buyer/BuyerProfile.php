<?php

namespace App\Livewire\Buyer;

use App\Models\BuyerProfile as BuyerProfileModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class BuyerProfile extends Component
{
    use WithFileUploads;

    #[Layout('layouts.buyer')]

    // Form Binding Attributes (Company Details)
    public string $company_name = '';
    public ?string $company_registration_number = null;
    public ?string $vat_tax_id_number = null;
    public ?string $nature_of_business = null;
    public ?string $company_website = null;
    public string $country_of_registration = '';
    public ?int $year_established = null;

    // Social Channels Structural Binding Group
    public ?string $social_twitter = null;
    public ?string $social_facebook = null;
    public ?string $social_instagram = null;
    public ?string $social_threads = null;
    public ?string $social_linkedin = null;

    // Authorized Representative Details
    public string $rep_full_name = '';
    public string $rep_position = '';
    public ?string $rep_nationality = null;
    public ?string $rep_id_passport_number = null;
    public string $rep_mobile_whatsapp = '';
    public string $rep_email = '';
    public ?string $office_address = null;

    // Account Password Operations
    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    // Brand logo modifications properties
    public $new_company_icon;
    public ?string $current_icon_path = null;

    // System Read-Only Metrics
    public string $buyer_ref_number = '';
    public string $status_label = '';

    public function mount()
    {
        $buyer = Auth::guard('buyer')->user();

        $this->company_name = $buyer->company_name;
        $this->company_registration_number = $buyer->company_registration_number;
        $this->vat_tax_id_number = $buyer->vat_tax_id_number;
        $this->nature_of_business = $buyer->nature_of_business;
        $this->company_website = $buyer->company_website;
        $this->country_of_registration = $buyer->country_of_registration;
        $this->year_established = $buyer->year_established;
        $this->current_icon_path = $buyer->company_icon_path;
        $this->buyer_ref_number = $buyer->buyer_ref_number;
        $this->status_label = $buyer->status_label;

        // Parse social media JSON mapping safely
        $socials = $buyer->social_media;
        if (is_array($socials)) {
            $this->social_twitter = $socials['twitter'] ?? null;
            $this->social_facebook = $socials['facebook'] ?? null;
            $this->social_instagram = $socials['instagram'] ?? null;
            $this->social_threads = $socials['threads'] ?? null;
            $this->social_linkedin = $socials['linkedin'] ?? null;
        }

        // Representative values hydration
        $this->rep_full_name = $buyer->rep_full_name;
        $this->rep_position = $buyer->rep_position;
        $this->rep_nationality = $buyer->rep_nationality;
        $this->rep_id_passport_number = $buyer->rep_id_passport_number;
        $this->rep_mobile_whatsapp = $buyer->rep_mobile_whatsapp;
        $this->rep_email = $buyer->rep_email;
        $this->office_address = $buyer->office_address;
    }

    /**
     * Process general profile update sequences.
     */
    public function updateProfile()
    {
        $buyer = Auth::guard('buyer')->user();

        $validated = $this->validate([
            'company_name' => 'required|string|max:255',
            'company_registration_number' => 'nullable|string|max:100',
            'vat_tax_id_number' => 'nullable|string|max:100',
            'nature_of_business' => 'nullable|string|max:255',
            'company_website' => 'nullable|url|max:255',
            'country_of_registration' => 'required|string|max:255',
            'year_established' => 'nullable|integer|min:1800|max:' . date('Y'),

            // Representative details
            'rep_full_name' => 'required|string|max:255',
            'rep_position' => 'required|string|max:255',
            'rep_nationality' => 'nullable|string|max:100',
            'rep_id_passport_number' => 'nullable|string|max:100',
            'rep_mobile_whatsapp' => 'required|string|max:50',
            'rep_email' => 'required|email|max:255|unique:buyer_profiles,rep_email,' . $buyer->id,
            'office_address' => 'nullable|string',

            // Social channels
            'social_twitter' => 'nullable|string|max:100',
            'social_facebook' => 'nullable|string|max:100',
            'social_instagram' => 'nullable|string|max:100',
            'social_threads' => 'nullable|string|max:100',
            'social_linkedin' => 'nullable|string|max:100',

            // Brand image upload
            'new_company_icon' => 'nullable|image|max:2048',
        ]);

        // Process company logo storage replacement
        if ($this->new_company_icon) {
            if ($buyer->company_icon_path) {
                Storage::disk('public')->delete($buyer->company_icon_path);
            }
            $this->current_icon_path = $this->new_company_icon->store('buyer_icons', 'public');
        }

        // Pack structural social channel arrays nodes
        $socialChannelsArray = array_filter([
            'twitter' => $this->social_twitter,
            'facebook' => $this->social_facebook,
            'instagram' => $this->social_instagram,
            'threads' => $this->social_threads,
            'linkedin' => $this->social_linkedin,
        ]);

        $buyer->update([
            'company_name' => $this->company_name,
            'company_registration_number' => $this->company_registration_number,
            'vat_tax_id_number' => $this->vat_tax_id_number,
            'nature_of_business' => $this->nature_of_business,
            'company_website' => $this->company_website,
            'country_of_registration' => $this->country_of_registration,
            'year_established' => $this->year_established,
            'company_icon_path' => $this->current_icon_path,
            'social_media' => !empty($socialChannelsArray) ? $socialChannelsArray : null,
            'rep_full_name' => $this->rep_full_name,
            'rep_position' => $this->rep_position,
            'rep_nationality' => $this->rep_nationality,
            'rep_id_passport_number' => $this->rep_id_passport_number,
            'rep_mobile_whatsapp' => $this->rep_mobile_whatsapp,
            'rep_email' => $this->rep_email,
            'office_address' => $this->office_address,
        ]);

        session()->flash('success', 'Corporate business profile options updated successfully.');
    }

    /**
     * Change password credentials securely.
     */
    public function updateSecurityPassword()
    {
        $buyer = Auth::guard('buyer')->user();

        $this->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($this->current_password, $buyer->password)) {
            $this->addError('current_password', 'The current account secure password you provided is incorrect.');
            return;
        }

        $buyer->update([
            'password' => Hash::make($this->new_password)
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        session()->flash('success', 'Workspace account password modified cleanly.');
    }

    public function render()
    {
        return view('livewire.buyer.buyer-profile');
    }
}
