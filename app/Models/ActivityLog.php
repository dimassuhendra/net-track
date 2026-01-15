<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    // Karena nama tabel Anda activity_logs (jamak)
    protected $table = 'activity_logs';

    protected $guarded = [];

    // Casting payload agar otomatis menjadi array saat dipanggil
    protected $casts = [
        'payload' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}