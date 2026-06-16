<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class SupplierLogin extends Component
{
    #[Layout('layouts.guest')]

    // Form inputs bound straight to your representative tracking columns
    #[Rule('required|email', message: 'Please provide a valid representative email address.')]
    public string $rep_email = '';

    #[Rule('required|string', message: 'Password parameter cannot be left blank.')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Authenticate the supplier using the rep_email column against the supplier guard.
     */
    public function login()
    {
        // 1. Fire input schema validations
        $this->validate();

        // 2. Map login inputs to the custom rep_email database field array structure
        $credentials = [
            'rep_email' => $this->rep_email,
            'password' => $this->password,
        ];

        // 3. Process authentication check directly inside your dedicated 'supplier' session guard
        if (Auth::guard('supplier')->attempt($credentials, $this->remember)) {

            // Defend against session fixation security breaches
            session()->regenerate();

            session()->flash('success', 'Authentication successful! Welcome to your Gluto supplier dashboard.');

            // Smooth navigate straight onto the supplier dashboard panel workspace
            return $this->redirectRoute('supplier.dashboard', navigate: true);
        }

        // 4. Fallback validation drop on failure
        throw ValidationException::withMessages([
            'rep_email' => 'The provided representative credentials do not match our registered sourcing records.',
        ]);
    }

    public function render()
    {
        return view('livewire.supplier-login');
    }
}
