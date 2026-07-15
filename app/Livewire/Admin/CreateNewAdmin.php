<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CreateNewAdmin extends Component
{
    #[Layout('layouts.admin')] // Explicit Layout Definer

    public string $name = '';
    public string $username = '';
    public string $email = '';
    public string $usertype = 'staff';
    public string $password = '';

    public function createAdmin()
    {
        // Role Check Barrier Guard Rule
        if (Auth::user()->usertype !== 'superadmin') {
            abort(403, 'Access Restricted. Active Superadmin permissions are required.');
        }

        $this->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'usertype' => ['required', Rule::in(['superadmin', 'operationsadmin', 'financialofficer', 'staff'])],
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'usertype' => $this->usertype,
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['name', 'username', 'email', 'usertype', 'password']);
        session()->flash('success', 'A new back-office user identity has been safely registered.');
    }

    public function render()
    {
        if (Auth::user()->usertype !== 'superadmin') {
            return <<<'HTML'
                <div class="bg-white mx-auto my-12 p-8 border border-red-200 border-dashed rounded-[2rem] max-w-xl text-center">
                    <span class="text-[48px] text-red-500 animate-pulse material-symbols-outlined">gpp_bad</span>
                    <h3 class="mt-2 font-bold text-neutral-900 text-sm">Privilege Boundary Restriction</h3>
                    <p class="mt-1 text-neutral-500 text-xs">This specific console component can only be operated by active Superadmin context holders.</p>
                </div>
            HTML;
        }

        return view('livewire.admin.create-new-admin');
    }
}
