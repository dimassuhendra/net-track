<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Satu user bisa menginput banyak tiket
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }

    public function picTickets()
    {
        return $this->hasMany(Ticket::class, 'pic_id');
    }

}