<?php

namespace App\Http\Controllers;

use App\Models\Category;
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

        Category::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function destroy(Category $category)
    {
        // Cek jika kategori sudah digunakan di tiket, sebaiknya jangan dihapus
        if ($category->tickets()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena sudah memiliki histori laporan.');
        }

        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}