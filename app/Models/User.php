<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Spatie\Activitylog\LogOptions;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    use LogsActivity;

    const ROLE_ADMIN = 'ADMIN';
    const ROLE_EDITOR = 'LMS ADMIN';
    const ROLE_USER = 'REGIONAL ADMIN';
     const ROLES =[
        self::ROLE_ADMIN => 'ADMIN',
        self::ROLE_EDITOR => 'LMS ADMIN',
        self::ROLE_USER => 'REGIONAL ADMIN',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
       return $this->isAdmin() || $this->isEditor() || $this->isRegional();
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isEditor(){
        
        return $this->role === self::ROLE_EDITOR;
    }

    public function isRegional(){
        return $this->role === self::ROLE_USER;
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly($this->fillable);
        // Chain fluent methods for configuration options
    }

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
