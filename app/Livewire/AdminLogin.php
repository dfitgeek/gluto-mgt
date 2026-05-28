<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AdminLogin extends Component
{
    #[Layout('layouts.guest')]

    // Form Properties
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    // Real-time validation syntax rules
    protected array $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function mount()
    {
        if (Auth::check() && Auth::user()->isManagement()) {
            return $this->redirectRoute('admin.lobby', navigate: true);
        }
    }

    public function login()
    {
        $this->validate();

        // Standard authentication check wrapper
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {

            $user = Auth::user();

            // Guard validation checkpoint: Ensure user is management (superadmin, operationsadmin, staff)
            if ($user->isManagement()) {
                request()->session()->regenerate();

                return redirect()->intended(route('admin.lobby', absolute: false));
                // return $this->redirectRoute('admin.lobby', navigate: true);
            }

            // If a standard buyer or supplier account logs into the admin page, log them out instantly
            Auth::logout();
            session()->flash('error', 'Access Denied: Standard user roles cannot authenticate here.');
            return;
        }

        // Credentials fallback notification failure
        session()->flash('error', 'The provided credentials do not match our administration database logs.');
    }

    public function render()
    {
        return view('livewire.admin-login');
    }
}
