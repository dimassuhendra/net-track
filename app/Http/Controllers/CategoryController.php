<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('tickets')->get();
        return view('category-index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:categories,nama_kategori|max:255',
        ]);

        $category = Category::create($request->all());

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'KATEGORI DITAMBAHKAN',
                'message' => auth()->user()->name . " telah menambah kategori baru: " . $category->nama_kategori,
                'type' => 'activity'
            ]);
        }
        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function destroy(Category $category)
    {
        if ($category->tickets()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena sudah digunakan.');
        }

        $categoryName = $category->nama_kategori;
        $category->delete();

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'KATEGORI DIHAPUS',
                'message' => auth()->user()->name . " telah menghapus kategori: " . $categoryName,
                'type' => 'activity'
            ]);
        }
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}