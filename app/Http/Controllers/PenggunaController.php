<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengguna::query();

        // Pencarian berdasarkan Nama Lengkap atau ID Pengguna
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('Nama_Lengkap', 'like', '%' . $search . '%')
                  ->orWhere('ID_Pengguna', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan Role (Misal: Admin, Gudang, dll)
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('Role', $request->kategori);
        }

        // Urutkan berdasarkan ID_Pengguna terbaru dan batasi 5 data per halaman
        $pengguna = $query->latest('ID_Pengguna')->paginate(5);

        // Mengarah ke folder views/master/pengguna/index.blade.php
        return view('master.pengguna.index', compact('pengguna'));
    }

    public function create() {}

    public function store(Request $request)
    {
        // Validasi input data pengguna
        $request->validate([
            'Nama_Lengkap' => 'required|string|max:50',
            'Role' => 'required|string|max:15',
            'Kata_Sandi' => 'required|string|min:6',
            'Email' => 'required|email|max:255|unique:pengguna,Email',
            'Status_Aktif' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $data = $request->all();
        // Enkripsi password sebelum disimpan ke database
        $data['Kata_Sandi'] = Hash::make($request->Kata_Sandi);

        Pengguna::create($data);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambah!');
    }

    public function edit(string $id) {}

    public function update(Request $request, string $id)
    {
        $pengguna = Pengguna::findOrFail($id);

        // Validasi input update data pengguna
        $request->validate([
            'Nama_Lengkap' => 'required|string|max:50',
            'Role' => 'required|string|max:15',
            'Email' => 'required|email|max:255|unique:pengguna,Email,' . $id . ',ID_Pengguna',
            'Status_Aktif' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $data = $request->all();

        // Jika form password diisi, enkripsi baru. Jika kosong, pakai password lama.
        if ($request->filled('Kata_Sandi')) {
            $data['Kata_Sandi'] = Hash::make($request->Kata_Sandi);
        } else {
            unset($data['Kata_Sandi']);
        }

        $pengguna->update($data);

        return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil diubah!');
    }

    public function destroy(string $id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $pengguna->delete();

        return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil dihapus!');
    }
}