<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'profile_photo',
        'expertise_area',
        'is_active',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    // Role constants
    const ROLE_ADMIN = 'admin';
    const ROLE_AGRONOMIST = 'agronomist';
    const ROLE_FARMER = 'farmer';
    const ROLE_RESEARCHER = 'researcher';

    /**
     * Check if user has a specific role
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is agronomist
     */
    public function isAgronomist()
    {
        return $this->role === self::ROLE_AGRONOMIST;
    }

    /**
     * Check if user is farmer
     */
    public function isFarmer()
    {
        return $this->role === self::ROLE_FARMER;
    }

    /**
     * Get all available roles
     */
    public static function getRoles()
    {
        return [
            self::ROLE_ADMIN => 'Administrator',
            self::ROLE_AGRONOMIST => 'Agronomist',
            self::ROLE_FARMER => 'Farmer',
            self::ROLE_RESEARCHER => 'Researcher',
        ];
    }

    /**
     * Get the inquiries for the user.
     */
    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    /**
     * Get the guides created by the user.
     */
    public function guides()
    {
        return $this->hasMany(Guide::class, 'created_by');
    }
}
