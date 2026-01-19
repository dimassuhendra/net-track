<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CategoryObserver
{
    public function created(Category $category)
    {
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'Kategori Ditambahkan',
                'message' => auth()->user()->name . " menambahkan kategori baru: {$category->nama_kategori}",
                'type' => 'activity'
            ]);
        }
    }
}