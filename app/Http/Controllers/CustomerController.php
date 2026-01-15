<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        // Mengambil pelanggan dengan hitungan tiket mereka (histori)
        $customers = Customer::withCount('tickets')->latest()->get();
        return view('customer-index', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|unique:customers,customer_id',
            'nama_pelanggan' => 'required',
            'layanan' => 'required',
            'kontak' => 'nullable',
            'alamat' => 'nullable',
        ]);

        Customer::create($request->all());

        return back()->with('success', 'Data pelanggan berhasil ditambahkan!');
    }

    public function destroy(Customer $customer)
    {
        if ($customer->tickets()->count() > 0) {
            return back()->with('error', 'Pelanggan tidak bisa dihapus karena memiliki riwayat gangguan.');
        }

        $customer->delete();
        return back()->with('success', 'Data pelanggan berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'customer_id' => 'required|unique:customers,customer_id,' . $id,
            'nama_pelanggan' => 'required',
            'layanan' => 'required',
            'kontak' => 'nullable',
            'alamat' => 'nullable',
        ]);

        $customer->update([
            'customer_id' => $request->customer_id,
            'nama_pelanggan' => $request->nama_pelanggan,
            'layanan' => $request->layanan,
            'kontak' => $request->kontak,
            'alamat' => $request->alamat,
        ]);

        return back()->with('success', 'Data pelanggan berhasil diperbarui!');
    }
}