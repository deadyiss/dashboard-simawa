<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /* ── Helpers ───────────────────────────────── */

    private function getFilters(Request $request): array
    {
        return [
            'search'   => $request->get('search'),
            'prodi'    => $request->get('prodi'),
            'status'   => $request->get('status'),
            'angkatan' => $request->get('angkatan'),
        ];
    }

    private function buildQuery(array $filters)
    {
        return Mahasiswa::with('prodi')
            ->search($filters['search'])
            ->filterProdi($filters['prodi'])
            ->filterStatus($filters['status'])
            ->filterAngkatan($filters['angkatan'])
            ->latest();
    }

    /* ── CRUD ──────────────────────────────────── */

    public function index(Request $request)
    {
        $filters    = $this->getFilters($request);
        $mahasiswas = $this->buildQuery($filters)->paginate(10)->withQueryString();
        $prodis     = Prodi::orderBy('jenjang')->orderBy('nama')->get();
        $angkatans  = Mahasiswa::selectRaw('angkatan')->whereNotNull('angkatan')
                               ->distinct()->orderByDesc('angkatan')->pluck('angkatan');

        return view('mahasiswa.index', compact('mahasiswas', 'filters', 'prodis', 'angkatans'));
    }

    public function create()
    {
        $prodis = Prodi::orderBy('jenjang')->orderBy('nama')->get();
        return view('mahasiswa.create', compact('prodis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prodi_id'     => 'nullable|exists:prodis,id',
            'npm'          => 'required|string|max:20|unique:mahasiswas,npm',
            'nama_lengkap' => 'required|string|max:100',
            'alamat'       => 'required|string',
            'email'        => 'required|email|unique:mahasiswas,email',
            'telepon'      => 'required|string|max:20',
            'status'       => 'required|in:aktif,cuti,lulus,dropout',
            'angkatan'     => 'nullable|integer|min:2000|max:' . date('Y'),
        ], $this->messages());

        Mahasiswa::create($validated);

        return redirect()->route('mahasiswa.index')
                         ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function show(Mahasiswa $mahasiswa)
    {
        $mahasiswa->load('prodi');
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        $prodis = Prodi::orderBy('jenjang')->orderBy('nama')->get();
        return view('mahasiswa.edit', compact('mahasiswa', 'prodis'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validated = $request->validate([
            'prodi_id'     => 'nullable|exists:prodis,id',
            'npm'          => 'required|string|max:20|unique:mahasiswas,npm,' . $mahasiswa->id,
            'nama_lengkap' => 'required|string|max:100',
            'alamat'       => 'required|string',
            'email'        => 'required|email|unique:mahasiswas,email,' . $mahasiswa->id,
            'telepon'      => 'required|string|max:20',
            'status'       => 'required|in:aktif,cuti,lulus,dropout',
            'angkatan'     => 'nullable|integer|min:2000|max:' . date('Y'),
        ], $this->messages());

        $mahasiswa->update($validated);

        return redirect()->route('mahasiswa.index')
                         ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')
                         ->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    /* ── Export CSV (native — tidak butuh package) ── */

    public function exportExcel(Request $request)
    {
        $filters    = $this->getFilters($request);
        $mahasiswas = $this->buildQuery($filters)->get();
        $filename   = 'mahasiswa_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($mahasiswas) {
            $file = fopen('php://output', 'w');

            // BOM UTF-8 agar Excel membaca karakter Indonesia dengan benar
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header kolom
            fputcsv($file, [
                'No',
                'NPM',
                'Nama Lengkap',
                'Program Studi',
                'Jenjang',
                'Angkatan',
                'Status',
                'Email',
                'Telepon',
                'Alamat',
                'Tanggal Daftar',
            ], ';'); // pakai semicolon agar Excel langsung terbaca per kolom

            foreach ($mahasiswas as $i => $mhs) {
                fputcsv($file, [
                    $i + 1,
                    $mhs->npm,
                    $mhs->nama_lengkap,
                    $mhs->prodi?->nama ?? '-',
                    $mhs->prodi?->jenjang ?? '-',
                    $mhs->angkatan ?? '-',
                    $mhs->status_label,
                    $mhs->email,
                    $mhs->telepon,
                    $mhs->alamat,
                    $mhs->created_at->format('d/m/Y'),
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /* ── Export PDF (butuh barryvdh/laravel-dompdf) ─ */

    public function exportPdf(Request $request)
    {
        $filters    = $this->getFilters($request);
        $mahasiswas = $this->buildQuery($filters)->get();
        $filename   = 'mahasiswa_' . now()->format('Ymd_His') . '.pdf';

        $pdf = Pdf::loadView('exports.mahasiswa-pdf', compact('mahasiswas', 'filters'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }

    /* ── Kartu ─────────────────────────────────────── */

    public function kartu(Mahasiswa $mahasiswa)
    {
        $mahasiswa->load('prodi');
        return view('mahasiswa.kartu', compact('mahasiswa'));
    }

    /* ── Validation messages ────────────────────────── */

    private function messages(): array
    {
        return [
            'npm.required'          => 'NPM wajib diisi.',
            'npm.unique'            => 'NPM sudah terdaftar.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'alamat.required'       => 'Alamat wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email sudah terdaftar.',
            'telepon.required'      => 'Nomor telepon wajib diisi.',
            'status.required'       => 'Status wajib dipilih.',
            'status.in'             => 'Status tidak valid.',
            'angkatan.integer'      => 'Angkatan harus berupa tahun.',
            'angkatan.min'          => 'Angkatan tidak valid.',
            'angkatan.max'          => 'Angkatan tidak boleh melebihi tahun ini.',
        ];
    }
}
