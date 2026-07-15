<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AdminSettings extends Component
{
    #[Layout('layouts.admin')] // Explicit Layout Definer

    // Form inputs properties bindings
    public string $name = '';
    public string $username = '';
    public string $email = '';
    public string $usertype = '';

    // Security verification password fields
    public string $currentPassword = '';
    public string $newPassword = '';

    public function mount()
    {
        /** @var User $user */
        $user = Auth::user();

        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->usertype = $user->usertype;
    }

    public function updateProfile()
    {
        /** @var User $user */
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
        ];

        // Privilege barrier: Only superadmin or operationsadmin can change user types
        if (in_array($user->usertype, ['superadmin', 'operationsadmin'])) {
            $rules['usertype'] = ['required', Rule::in(['superadmin', 'operationsadmin', 'financialofficer', 'staff'])];
        }

        if (filled($this->newPassword)) {
            $rules['currentPassword'] = 'required|string';
            $rules['newPassword'] = 'string|min:8';
        }

        $this->validate($rules);

        if (filled($this->newPassword)) {
            if (!Hash::check($this->currentPassword, $user->password)) {
                $this->addError('currentPassword', 'The current password provided is incorrect.');
                return;
            }
            $user->password = Hash::make($this->newPassword);
        }

        $user->name = $this->name;
        $user->username = $this->username;
        $user->email = $this->email;

        if (in_array($user->usertype, ['superadmin', 'operationsadmin'])) {
            $user->usertype = $this->usertype;
        }

        $user->save();

        $this->reset(['currentPassword', 'newPassword']);
        session()->flash('success', 'Your profile configuration metrics have been cleanly updated.');
    }

    public function render()
    {
        return view('livewire.admin.admin-settings');
    }
}
