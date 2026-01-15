<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'customer_id',
        'category_id',
        'user_id',
        'waktu_mulai',
        'waktu_selesai',
        'rincian_masalah',
        'action_taken',
        'status',
        'priority'
    ];

    /**
     * Casting atribut ke tipe data tertentu.
     * Ini akan mengubah string datetime dari DB menjadi objek Carbon secara otomatis.
     */
    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    // Relasi ke Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke User (Petugas/Admin)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}