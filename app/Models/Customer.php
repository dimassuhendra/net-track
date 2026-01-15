<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['customer_id', 'nama_pelanggan', 'layanan', 'alamat', 'kontak'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}