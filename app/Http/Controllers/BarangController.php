<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();

        // Pencarian berdasarkan Nama atau ID Barang
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('Nama_Barang', 'like', '%' . $search . '%')
                  ->orWhere('ID_Barang', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan stok
        if ($request->has('stok_status')) {
        if ($request->stok_status == 'menipis') {
            $query->where('Stok_Tersedia', '<=', 15);
        } elseif ($request->stok_status == 'aman') {
            $query->where('Stok_Tersedia', '>', 15);
        }
    }

        $barang = $query->latest('ID_Barang')->paginate(5)->withQueryString();

        return view('master.barang.index', compact('barang'));
    }

    public function create() {}

    public function store(Request $request)
    {
        $request->validate([
            'Nama_Barang' => 'required|string|max:50',
            'Kategori_Barang' => 'required|string|max:50',
            'Stok' => 'required|integer|min:0',
        ]);

        Barang::create($request->all());

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambah!');
    }

    public function edit(string $id) {}

    public function update(Request $request, string $id)
    {
        $request->validate([
            'Nama_Barang' => 'required|string|max:50',
            'Kategori_Barang' => 'required|string|max:50',
            'Stok' => 'required|integer|min:0',
        ]);

        $barang = Barang::findOrFail($id);

        $barang->update($request->all());

        return redirect()->
        route('barang.index')->with('success', 'Data barang berhasil diubah!');
    }

    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil dihapus!');
    }
}
