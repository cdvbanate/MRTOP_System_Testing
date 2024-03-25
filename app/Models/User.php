<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;


    const ROLE_ADMIN = 'ADMIN';
    const ROLE_EDITOR = 'LMS ADMIN';
    const ROLE_USER = 'USER';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     const ROLES =[
        self::ROLE_ADMIN => 'ADMIN',
        self::ROLE_EDITOR => 'LMS ADMIN',
        // self::ROLE_USER => 'User',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
       return $this->isAdmin() || $this->isEditor();
    }


    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isEditor(){
        
        return $this->role === self::ROLE_EDITOR;

    }

    public function isUser(){
        $this->role === self::ROLE_USER;
    }
   

    protected $fillable = [
        'name',
        'email',
        'password',
        'region_name',
        'province_name',
        'institution_name',
        'role',


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
}
