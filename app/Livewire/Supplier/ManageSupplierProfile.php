<?php

namespace App\Livewire\Supplier;

use App\Models\SupplierProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManageSupplierProfile extends Component
{
    use WithFileUploads;

    #[Layout('layouts.supplier')]

    // Form Binding Attributes (Company Details)
    public string $company_name = '';
    public string $reg_number = '';
    public ?int $year_established = null;
    public string $email_address = '';
    public string $phone_telephone = '';
    public ?string $whatsapp_contact = null;
    public string $type_of_business = '';
    public string $nature_of_business = '';
    public ?string $website = null;
    public string $address = '';

    // Social Channels Structural Binding Group
    public ?string $social_twitter = null;
    public ?string $social_facebook = null;
    public ?string $social_instagram = null;
    public ?string $social_threads = null;
    public ?string $social_linkedin = null;

    // Directorship Node Binding Attributes
    public ?string $names_of_board_directors = null;
    public ?string $director_position_title = null;
    public ?string $director_email = null;

    // Authorized Representative Metadata Attributes
    public string $rep_legal_name = '';
    public string $rep_position_title = '';
    public string $rep_email = '';
    public string $rep_phone_number = '';

    // Commercial Terms & Logistics Parameters
    public ?string $categorization_of_products = null;
    public ?string $overall_moqs = null;
    public ?string $customization_options = null;
    public ?string $production_capacity = null;
    public ?string $pricing_structure_type = null;
    public ?string $payment_terms = null;
    public string $currency_accepted = 'Naira';
    public ?string $shipping_methods_available = null;
    public bool $ability_to_provide_samples = false;

    // Compliance Flags
    public bool $declares_gmo_free = false;
    public bool $declares_gluten_free = false;
    public bool $declares_non_irradiated = false;
    public bool $declares_no_nanomaterials = false;
    public bool $complies_haccp_gmp = false;

    // Account Password Operations Gateway Elements
    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    // Temporary storage for brand logo modifications
    public $new_company_icon;
    public ?string $current_icon_path = null;

    // System Read-Only Metrics
    public string $supplier_ref_number = '';
    public string $status_label = '';

    public function mount()
    {
        // Hydrate details cleanly out of the active multi-auth guard profile session model instance
        $supplier = Auth::guard('supplier')->user();

        $this->company_name = $supplier->company_name;
        $this->reg_number = $supplier->reg_number;
        $this->year_established = $supplier->year_established;
        $this->email_address = $supplier->email_address;
        $this->phone_telephone = $supplier->phone_telephone;
        $this->whatsapp_contact = $supplier->whatsapp_contact;
        $this->type_of_business = $supplier->type_of_business;
        $this->nature_of_business = $supplier->nature_of_business;
        $this->website = $supplier->website;
        $this->address = $supplier->address;
        $this->current_icon_path = $supplier->company_icon_path;
        $this->supplier_ref_number = $supplier->supplier_ref_number;
        $this->status_label = $supplier->status_label;

        // Extract social array parameters safely
        $socials = $supplier->social_media;
        if (is_array($socials)) {
            $this->social_twitter = $socials['twitter'] ?? null;
            $this->social_facebook = $socials['facebook'] ?? null;
            $this->social_instagram = $socials['instagram'] ?? null;
            $this->social_threads = $socials['threads'] ?? null;
            $this->social_linkedin = $socials['linkedin'] ?? null;
        }

        // Directorship mappings
        $this->names_of_board_directors = $supplier->names_of_board_directors;
        $this->director_position_title = $supplier->director_position_title;
        $this->director_email = $supplier->director_email;

        // Representative details mapping
        $this->rep_legal_name = $supplier->rep_legal_name;
        $this->rep_position_title = $supplier->rep_position_title;
        $this->rep_email = $supplier->rep_email;
        $this->rep_phone_number = $supplier->rep_phone_number;

        // Logistics terms mappings
        $this->categorization_of_products = $supplier->categorization_of_products;
        $this->overall_moqs = $supplier->overall_moqs;
        $this->customization_options = $supplier->customization_options;
        $this->production_capacity = $supplier->production_capacity;
        $this->pricing_structure_type = $supplier->pricing_structure_type;
        $this->payment_terms = $supplier->payment_terms;
        $this->currency_accepted = $supplier->currency_accepted;
        $this->shipping_methods_available = $supplier->shipping_methods_available;
        $this->ability_to_provide_samples = (bool) $supplier->ability_to_provide_samples;

        // Compliance status flags
        $this->declares_gmo_free = (bool) $supplier->declares_gmo_free;
        $this->declares_gluten_free = (bool) $supplier->declares_gluten_free;
        $this->declares_non_irradiated = (bool) $supplier->declares_non_irradiated;
        $this->declares_no_nanomaterials = (bool) $supplier->declares_no_nanomaterials;
        $this->complies_haccp_gmp = (bool) $supplier->complies_haccp_gmp;
    }

    /**
     * Parse, validate, and execute general corporate profile update sequences.
     */
    public function updateProfile()
    {
        $supplier = Auth::guard('supplier')->user();

        $validated = $this->validate([
            'company_name' => 'required|string|max:255',
            'reg_number' => 'required|string|max:100',
            'year_established' => 'nullable|integer|min:1800|max:' . date('Y'),
            'email_address' => 'required|email|max:255|unique:supplier_profiles,email_address,' . $supplier->id,
            'phone_telephone' => 'required|string|max:50',
            'whatsapp_contact' => 'nullable|string|max:50',
            'type_of_business' => 'required|string|max:100',
            'nature_of_business' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'required|string',

            // Directorship validation tracks
            'names_of_board_directors' => 'nullable|string',
            'director_position_title' => 'nullable|string|max:255',
            'director_email' => 'nullable|email|max:255',

            // Representative fields validation tracks
            'rep_legal_name' => 'required|string|max:255',
            'rep_position_title' => 'required|string|max:255',
            'rep_email' => 'required|email|max:255|unique:supplier_profiles,rep_email,' . $supplier->id,
            'rep_phone_number' => 'required|string|max:50',

            // Capabilities details validations
            'categorization_of_products' => 'nullable|string|max:255',
            'overall_moqs' => 'nullable|string|max:255',
            'customization_options' => 'nullable|string',
            'production_capacity' => 'nullable|string|max:255',
            'pricing_structure_type' => 'nullable|string|max:100',
            'payment_terms' => 'nullable|string',
            'currency_accepted' => 'required|string|max:50',
            'shipping_methods_available' => 'nullable|string|max:255',

            // Social channels strings
            'social_twitter' => 'nullable|string|max:100',
            'social_facebook' => 'nullable|string|max:100',
            'social_instagram' => 'nullable|string|max:100',
            'social_threads' => 'nullable|string|max:100',
            'social_linkedin' => 'nullable|string|max:100',

            // Brand icon upload asset stream validation parameters
            'new_company_icon' => 'nullable|image|max:2048',
        ]);

        // Process corporate brand icon updating
        if ($this->new_company_icon) {
            if ($supplier->company_icon_path) {
                Storage::disk('public')->delete($supplier->company_icon_path);
            }
            $this->current_icon_path = $this->new_company_icon->store('supplier_icons', 'public');
        }

        // Pack structural social channel arrays nodes
        $socialChannelsArray = array_filter([
            'twitter' => $this->social_twitter,
            'facebook' => $this->social_facebook,
            'instagram' => $this->social_instagram,
            'threads' => $this->social_threads,
            'linkedin' => $this->social_linkedin,
        ]);

        // Persist records directly inside the targeted Supplier Profile database table row
        $supplier->update([
            'company_name' => $this->company_name,
            'reg_number' => $this->reg_number,
            'year_established' => $this->year_established,
            'email_address' => $this->email_address,
            'phone_telephone' => $this->phone_telephone,
            'whatsapp_contact' => $this->whatsapp_contact,
            'type_of_business' => $this->type_of_business,
            'nature_of_business' => $this->nature_of_business,
            'website' => $this->website,
            'address' => $this->address,
            'company_icon_path' => $this->current_icon_path,
            'social_media' => !empty($socialChannelsArray) ? $socialChannelsArray : null,
            'names_of_board_directors' => $this->names_of_board_directors,
            'director_position_title' => $this->director_position_title,
            'director_email' => $this->director_email,
            'rep_legal_name' => $this->rep_legal_name,
            'rep_position_title' => $this->rep_position_title,
            'rep_email' => $this->rep_email,
            'rep_phone_number' => $this->rep_phone_number,
            'categorization_of_products' => $this->categorization_of_products,
            'overall_moqs' => $this->overall_moqs,
            'customization_options' => $this->customization_options,
            'production_capacity' => $this->production_capacity,
            'pricing_structure_type' => $this->pricing_structure_type,
            'payment_terms' => $this->payment_terms,
            'currency_accepted' => $this->currency_accepted,
            'shipping_methods_available' => $this->shipping_methods_available,
            'ability_to_provide_samples' => $this->ability_to_provide_samples,
            'declares_gmo_free' => $this->declares_gmo_free,
            'declares_gluten_free' => $this->declares_gluten_free,
            'declares_non_irradiated' => $this->declares_non_irradiated,
            'declares_no_nanomaterials' => $this->declares_no_nanomaterials,
            'complies_haccp_gmp' => $this->complies_haccp_gmp,
        ]);

        session()->flash('success', 'Corporate business profile options updated successfully.');
    }

    /**
     * Intercept, crosscheck, and securely hash a replacement supplier access password key.
     */
    public function updateSecurityPassword()
    {
        $supplier = Auth::guard('supplier')->user();

        $this->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'new_password.confirmed' => 'The brand new password confirmation mapping sequence does not match.'
        ]);

        // Guard against brute force credential matching deviations
        if (!Hash::check($this->current_password, $supplier->password)) {
            $this->addError('current_password', 'The current account secure password you provided is incorrect.');
            return;
        }

        // Commit newly updated hashed string into database layer stores
        $supplier->update([
            'password' => Hash::make($this->new_password)
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        session()->flash('success', 'Security dashboard credential login token was rotated cleanly.');
    }

    public function render()
    {
        return view('livewire.supplier.manage-supplier-profile');
    }
}
