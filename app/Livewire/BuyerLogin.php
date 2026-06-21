<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class BuyerLogin extends Component
{
    #[Layout('layouts.guest')]

    #[Rule('required|email', message: 'Please provide your registered representative email address.')]
    public string $rep_email = '';

    #[Rule('required|string', message: 'Password field cannot be left blank.')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Authenticate the enterprise buyer against the unique buyer guard.
     */
    public function login()
    {
        $this->validate();

        $credentials = [
            'rep_email' => $this->rep_email,
            'password' => $this->password,
        ];

        // Process request parameters straight through your custom buyer session guard
        if (Auth::guard('buyer')->attempt($credentials, $this->remember)) {
            session()->regenerate();

            session()->flash('success', 'Authentication complete! Welcome to your Gluto Procurement Dashboard.');

            // Smooth navigate the buyer straight into their workspace dashboard
            return $this->redirectRoute('buyer.dashboard', navigate: true);
        }

        throw ValidationException::withMessages([
            'rep_email' => 'The provided representative credentials do not match our registered enterprise records.',
        ]);
    }

    public function render()
    {
        return view('livewire.buyer-login');
    }
}
