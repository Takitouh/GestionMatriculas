<?php

namespace App\Models;

use App\Notifications\AccountActivationNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function estudiante()
    {
        return $this->hasOne(Estudiante::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Personaliza el correo enviado por el Password Broker.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new AccountActivationNotification($token));
    }
}