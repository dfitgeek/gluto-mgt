<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CreateBuyers extends Component
{
    #[Layout('layouts.admin')]

    public ?int $userId = null;
    public ?User $targetUser = null;

    public function mount()
    {
        // Optional: Check if a query parameter provides a specific user ID to bind to
        $this->userId = request()->query('user_id');
        if ($this->userId) {
            $this->targetUser = User::find($this->userId);
        }
    }

    public function render()
    {
        return view('livewire.create-buyers');
    }
}
