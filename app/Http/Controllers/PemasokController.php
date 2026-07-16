<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemasok;

class PemasokController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemasok::query();
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('Nama_Pemasok', 'like', '%' . $search . '%')
                  ->orWhere('ID_Pemasok', 'like', '%' . $search . '%');
            });
        }
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('Kategori_Pemasok', $request->kategori);
        }
        $pemasok = $query->latest('ID_Pemasok')->paginate(5)->withQueryString();

        return view('master.pemasok.index', compact('pemasok'));
    }

    public function create() {}

    public function store(Request $request)
    {
        $request->validate([
            'Nama_Pemasok' => 'required|string|max:50',
            'Kontak_Pemasok' => 'required|string|max:15',
            'Kategori_Pemasok' => 'required|in:EXTERNAL,INTERNAL (DIVISI VULKANISIR)',
        ]);

        Pemasok::create($request->all());

        return redirect()->route('pemasok.index')->with('success', 'Pemasok berhasil ditambah!');
    }

    public function edit(string $id) {}

    public function update(Request $request, string $id)
    {
        $request->validate([
            'Nama_Pemasok' => 'required|string|max:50',
            'Kontak_Pemasok' => 'required|string|max:15',
            'Kategori_Pemasok' => 'required|in:INTERNAL (DIVISI VULKANISIR),EXTERNAL',
        ]);

        $pemasok = Pemasok::findOrFail($id);

        $pemasok->update($request->all());

        return redirect()->route('pemasok.index')->with('success', 'Data pemasok berhasil diubah!');
    }

    public function destroy(string $id)
    {
        $pemasok = Pemasok::findOrFail($id);
        $pemasok->delete();

        return redirect()->route('pemasok.index')->with('success', 'Data Pemasok berhasil dihapus!');
    }
}
