<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class ManageAdmin extends Component
{
    use WithPagination;

    #[Layout('layouts.admin')] // Explicit Layout Definer

    // Modal Control Flags
    public bool $isEditModalOpen = false;
    public ?int $selectedUserId = null;

    // Binding Form Arrays Matrices
    public string $name = '';
    public string $username = '';
    public string $email = '';
    public string $usertype = '';
    public string $newPassword = '';

    public function openEditModal(int $userId)
    {
        if (Auth::user()->usertype !== 'superadmin') {
            session()->flash('error', 'Action Restricted. Superadmin validation clearance failed.');
            return;
        }

        $user = User::findOrFail($userId);
        $this->selectedUserId = $user->id;

        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->usertype = $user->usertype;
        $this->newPassword = '';

        $this->isEditModalOpen = true;
    }

    public function closeEditModal()
    {
        $this->isEditModalOpen = false;
        $this->reset(['selectedUserId', 'name', 'username', 'email', 'usertype', 'newPassword']);
    }

    public function saveAdminChanges()
    {
        if (Auth::user()->usertype !== 'superadmin') {
            abort(403, 'Unauthorized.');
        }

        $user = User::findOrFail($this->selectedUserId);

        $this->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'usertype' => ['required', Rule::in(['superadmin', 'operationsadmin', 'financialofficer', 'staff'])],
            'newPassword' => 'nullable|string|min:8',
        ]);

        $payload = [
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'usertype' => $this->usertype,
        ];

        if (filled($this->newPassword)) {
            $payload['password'] = Hash::make($this->newPassword);
        }

        $user->update($payload);

        $this->closeEditModal();
        session()->flash('success', "Account registries for @{$user->username} have been successfully updated.");
    }

    public function render()
    {
        if (Auth::user()->usertype !== 'superadmin') {
            return <<<'HTML'
                <div class="bg-white mx-auto my-12 p-8 border border-red-200 border-dashed rounded-[2rem] max-w-xl text-center">
                    <span class="text-[48px] text-red-500 animate-pulse material-symbols-outlined">gpp_bad</span>
                    <h3 class="mt-2 font-bold text-neutral-900 text-sm">Access Restriced</h3>
                    <p class="mt-1 text-neutral-500 text-xs">This master dashboard ledger view is restricted exclusively to authenticated active Superadmin users.</p>
                </div>
            HTML;
        }

        return view('livewire.admin.manage-admin', [
            'admins' => User::latest()->paginate(10)
        ]);
    }
}
