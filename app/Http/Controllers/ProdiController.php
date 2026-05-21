<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public function index()
    {
        $prodis = Prodi::withCount('mahasiswas')->orderBy('jenjang')->orderBy('nama')->paginate(20);
        return view('prodi.index', compact('prodis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode'    => 'required|string|max:10|unique:prodis,kode',
            'nama'    => 'required|string|max:100',
            'jenjang' => 'required|in:D3,S1,S2,S3',
        ], [
            'kode.required'    => 'Kode prodi wajib diisi.',
            'kode.unique'      => 'Kode prodi sudah ada.',
            'nama.required'    => 'Nama prodi wajib diisi.',
            'jenjang.required' => 'Jenjang wajib dipilih.',
        ]);

        Prodi::create($validated);

        return redirect()->route('prodi.index')
                         ->with('success', 'Program studi berhasil ditambahkan.');
    }

    public function update(Request $request, Prodi $prodi)
    {
        $validated = $request->validate([
            'kode'    => 'required|string|max:10|unique:prodis,kode,' . $prodi->id,
            'nama'    => 'required|string|max:100',
            'jenjang' => 'required|in:D3,S1,S2,S3',
        ]);

        $prodi->update($validated);

        return redirect()->route('prodi.index')
                         ->with('success', 'Program studi berhasil diperbarui.');
    }

    public function destroy(Prodi $prodi)
    {
        if ($prodi->mahasiswas()->exists()) {
            return redirect()->route('prodi.index')
                             ->with('error', 'Tidak dapat menghapus prodi yang masih memiliki mahasiswa.');
        }

        $prodi->delete();

        return redirect()->route('prodi.index')
                         ->with('success', 'Program studi berhasil dihapus.');
    }
}
