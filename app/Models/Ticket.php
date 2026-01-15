<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
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

    // Relasi ke User (Petugas)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}