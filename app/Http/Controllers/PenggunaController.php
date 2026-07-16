<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengguna::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('Nama_Lengkap', 'like', '%' . $search . '%')
                  ->orWhere('ID_Pengguna', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('Status_Aktif', $request->status);
        }

        $pengguna = $query->latest('ID_Pengguna')->paginate(5);

        return view('master.pengguna.index', compact('pengguna'));
    }

    public function create() {}

    public function store(Request $request)
    {
        $request->validate([
            'Nama_Lengkap' => 'required|string|max:50',
            'Role' => 'required|string|max:15',
            'Kata_Sandi' => 'required|string|min:6',
            'Email' => 'required|email|max:255|unique:pengguna,Email',
            'Status_Aktif' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $data = $request->all();
        $data['Kata_Sandi'] = Hash::make($request->Kata_Sandi);

        Pengguna::create($data);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambah!');
    }

    public function edit(string $id) {}

    public function update(Request $request, string $id)
    {
        $pengguna = Pengguna::findOrFail($id);

        $request->validate([
            'Nama_Lengkap' => 'required|string|max:50',
            'Role' => 'required|string|max:15',
            'Email' => 'required|email|max:255|unique:pengguna,Email,' . $id . ',ID_Pengguna',
            'Status_Aktif' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $data = $request->all();

        if ($request->filled('Kata_Sandi')) {
            $data['Kata_Sandi'] = Hash::make($request->Kata_Sandi);
        } else {
            unset($data['Kata_Sandi']);
        }

        $pengguna->update($data);

        return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil diubah!');
    }

    public function destroy(int $id)
    {
        if (Auth::id() == $id) {
            return redirect()->back()->with('error', 'Tidak Bisa Menghapus Akun Sendiri!');
        }

        $pengguna = Pengguna::findOrFail($id);
        $pengguna->update([
            'Status_Aktif' => 'Tidak Aktif'
        ]);
        $pengguna->delete();

        return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil dinonaktifkan dan dihapus!');
    }
}
