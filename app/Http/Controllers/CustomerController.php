<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
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

        $customer = Customer::create($request->all());

        // NOTIFIKASI UNTUK SEMUA ADMIN
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'PELANGGAN BARU',
                'message' => auth()->user()->name . " mendaftarkan pelanggan: " . $customer->nama_pelanggan,
                'type' => 'activity'
            ]);
        }

        return back()->with('success', 'Data pelanggan berhasil ditambahkan!');
    }

    public function destroy(Customer $customer)
    {
        if ($customer->tickets()->count() > 0) {
            return back()->with('error', 'Pelanggan tidak bisa dihapus karena memiliki riwayat gangguan.');
        }

        $custName = $customer->nama_pelanggan;
        $customer->delete();

        // NOTIFIKASI UNTUK SEMUA ADMIN
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'PELANGGAN DIHAPUS',
                'message' => auth()->user()->name . " menghapus data pelanggan: " . $custName,
                'type' => 'activity'
            ]);
        }

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

        $customer->update($request->all());

        return back()->with('success', 'Data pelanggan berhasil diperbarui!');
    }
}