<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    const TYPE_SUPER_ADMIN = 'superadmin';
    const TYPE_OPERATIONS_ADMIN = 'operationsadmin';
    const TYPE_STAFF = 'staff';
    const TYPE_BUYER = 'buyer';
    const TYPE_SUPPLIER = 'supplier';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'usertype',
        'username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Helper checks to use throughout your backend
     */
    public function isSuperAdmin(): bool
    {
        return $this->usertype === self::TYPE_SUPER_ADMIN;
    }

    public function isOperationsAdmin(): bool
    {
        return $this->usertype === self::TYPE_OPERATIONS_ADMIN;
    }

    public function isStaff(): bool
    {
        return $this->usertype === self::TYPE_STAFF;
    }

    // Quick check to see if they are part of the management team at all
    public function isManagement(): bool
    {
        return in_array($this->usertype, [
            self::TYPE_SUPER_ADMIN,
            self::TYPE_OPERATIONS_ADMIN,
            self::TYPE_STAFF
        ]);
    }
}
