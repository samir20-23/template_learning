<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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

    // Add these relationships for the dashboard
    public function documents()
    {
        return $this->hasMany(Document::class, 'user_id');
    }

    public function validations()
    {
        return $this->hasMany(Validation::class, 'validated_by');
    }
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isApprenant()
    {
        return $this->role === 'Apprenant' || $this->role === 'User' ;        
    }
    public function isFormateur()
    {
        return $this->role === 'Formateur';
    }
    public function isUser()
    {
        return $this->role === 'User';
    }
}
