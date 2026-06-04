<?php

namespace App\Livewire;

use App\Models\RegistrationOnboardingToken;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

class UserCreateSupplierProfile extends Component
{
    public string $token;
    public User $targetUser;

    #[Layout('layouts.guest')]

    public function mount(string $token)
    {
        $this->token = $token;

        // Query the relation table
        $onboardingToken = RegistrationOnboardingToken::with('user')
            ->where('token', $token)
            ->where('is_used', false)
            ->first();

        // Enforce structural security walls instantly
        if (!$onboardingToken || $onboardingToken->isExpired()) {
            abort(403, 'This registration token is invalid, has expired, or has already been used.');
        }

        // Hydrate the layout view target
        $this->targetUser = $onboardingToken->user;
    }

    public function render()
    {
        return view('livewire.user-create-supplier-profile');
    }
}
