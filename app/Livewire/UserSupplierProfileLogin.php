<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class UserSupplierProfileLogin extends Component
{
    #[Layout('layouts.guest')]

    // Real-time properties bound straight to the input form
    #[Rule('required|email', message: 'Please provide a valid corporate email address.')]
    public string $email_address = '';

    #[Rule('required|string', message: 'Password parameter cannot be left blank.')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle the Supplier multi-auth verification check routine sequence.
     */
    public function login()
    {
        // 1. Trigger input validations
        $this->validate();

        // 2. Assemble credentials matching your exact custom database migration columns
        $credentials = [
            'email_address' => $this->email_address, // Scans custom 'email_address' column mapping
            'password' => $this->password,
        ];

        // 3. Dispatch the explicit attempt verification to the 'supplier' guard session frame
        if (Auth::guard('supplier')->attempt($credentials, $this->remember)) {

            // Regenerate the session id to defend against malicious session fixation attacks
            session()->regenerate();

            session()->flash('success', 'Authenticated successfully. Welcome back to your corporate workspace dashboard.');

            // Safely route the verified vendor onto their internal overview control workspace area
            return $this->redirectRoute('admin.suppliers.dashboard', navigate: true);
        }

        // 4. Throw standard validation failure message strings if lookup crashes out
        throw ValidationException::withMessages([
            'email_address' => 'The provided corporate credentials do not match our registered tracking records.',
        ]);
    }

    public function render()
    {
        return view('livewire.user-supplier-profile-login');
    }
}
