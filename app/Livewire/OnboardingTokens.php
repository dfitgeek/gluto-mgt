<?php

namespace App\Livewire;

use App\Models\RegistrationOnboardingToken;
use App\Models\User;
use App\Models\SupplierOnboardingToken;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

class OnboardingTokens extends Component
{
    // Form property bound for creating a new token
    public ?int $selectedUserId = null;

    /**
     * Generate a brand new token mapped to a specific user.
     */
    public function generateToken()
    {
        $this->validate([
            'selectedUserId' => 'required|exists:users,id'
        ]);

        $user = User::findOrFail($this->selectedUserId);
        $tokenString = Str::random(40);

        RegistrationOnboardingToken::create(['user_id' => $user->id, 'token' => $tokenString, 'expires_at' => now()->addHours(48), 'is_used' => false, 'used_at' => null,]);

        $this->reset('selectedUserId');
        session()->flash('success', 'Onboarding credentials generated successfully.');
    }

    /**
     * Terminate and purge an onboarding token record out of the vault.
     */
    public function deleteToken(int $tokenId)
    {
        $token = RegistrationOnboardingToken::findOrFail($tokenId);
        $token->delete();

        session()->flash('success', 'Onboarding token track removed permanently.');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        // Pull all tokens with their respective parent user profiles attached
        $tokens = RegistrationOnboardingToken::all();

        // Pull users who don't already have an active onboarding token row

        $availableUsers = auth()->check() ? User::where('id', auth()->id())->get() : collect();

        return view('livewire.onboarding-tokens', [
            'tokens' => $tokens,
            'availableUsers' => $availableUsers
        ]);
    }
}
