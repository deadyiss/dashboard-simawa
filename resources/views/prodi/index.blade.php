@extends('layouts.app')

@section('title', 'Program Studi')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right" style="font-size:9px"></i>
    <span>Program Studi</span>
@endsection

@section('content')
<div class="grid" style="grid-template-columns:1fr 360px;gap:20px;align-items:start">

    {{-- ── TABLE ──────────────────────────────── --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                <i class="fa-solid fa-building-columns" style="color:var(--denim-500);margin-right:8px"></i>
                Daftar Program Studi
                <span class="badge badge-blue" style="margin-left:8px">{{ $prodis->total() }}</span>
            </h2>
        </div>

        @if($prodis->isEmpty())
            <div class="empty-state">
                <div class="empty-icon"><i class="fa-solid fa-building-columns"></i></div>
                <h3>Belum ada program studi</h3>
                <p>Tambahkan program studi pertama melalui form di samping</p>
            </div>
        @else
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Program Studi</th>
                            <th style="text-align:center">Jenjang</th>
                            <th style="text-align:center">Mahasiswa</th>
                            <th style="text-align:center;width:100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prodis as $prodi)
                        <tr>
                            <td><span class="badge badge-blue font-mono">{{ $prodi->kode }}</span></td>
                            <td style="font-weight:600">{{ $prodi->nama }}</td>
                            <td style="text-align:center">
                                <span class="badge badge-gray">{{ $prodi->jenjang }}</span>
                            </td>
                            <td style="text-align:center;font-weight:700;color:var(--denim-600)">
                                {{ $prodi->mahasiswas_count }}
                            </td>
                            <td>
                                <div class="flex items-center gap-1" style="justify-content:center">
                                    {{-- Edit trigger --}}
                                    <button type="button"
                                            class="btn btn-secondary btn-sm btn-icon"
                                            title="Edit"
                                            onclick="openEditModal({{ $prodi->id }}, '{{ addslashes($prodi->kode) }}', '{{ addslashes($prodi->nama) }}', '{{ $prodi->jenjang }}')">
                                        <i class="fa-solid fa-pencil"></i>
                                    </button>

                                    {{-- Delete --}}
                                    @if($prodi->mahasiswas_count == 0)
                                        <form id="del-prodi-{{ $prodi->id }}"
                                              action="{{ route('prodi.destroy', $prodi) }}" method="POST" style="display:none">
                                            @csrf @method('DELETE')
                                        </form>
                                        <button type="button"
                                                class="btn btn-danger btn-sm btn-icon"
                                                title="Hapus"
                                                onclick="confirmDelete('del-prodi-{{ $prodi->id }}', '{{ addslashes($prodi->nama) }}')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @else
                                        <span class="btn btn-secondary btn-sm btn-icon"
                                              title="Tidak bisa dihapus (ada mahasiswa)"
                                              style="opacity:.4;cursor:not-allowed">
                                            <i class="fa-solid fa-lock"></i>
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($prodis->hasPages())
            <div class="pagination-wrapper">
                <p class="pagination-info">{{ $prodis->total() }} program studi</p>
                <div class="pagination">
                    @if(!$prodis->onFirstPage())
                        <a href="{{ $prodis->previousPageUrl() }}"><i class="fa-solid fa-chevron-left" style="font-size:10px"></i></a>
                    @endif
                    @foreach($prodis->getUrlRange(1, $prodis->lastPage()) as $page => $url)
                        @if($page == $prodis->currentPage())
                            <span class="active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                    @if($prodis->hasMorePages())
                        <a href="{{ $prodis->nextPageUrl() }}"><i class="fa-solid fa-chevron-right" style="font-size:10px"></i></a>
                    @endif
                </div>
            </div>
            @endif
        @endif
    </div>

    {{-- ── FORM PANEL ──────────────────────────── --}}
    <div style="display:flex;flex-direction:column;gap:16px">

        {{-- Add Form --}}
        <div class="card" id="form-tambah">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fa-solid fa-plus" style="color:var(--denim-500);margin-right:8px"></i>
                    Tambah Program Studi
                </h2>
            </div>
            <div class="card-body">
                <form action="{{ route('prodi.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Kode <span class="req">*</span></label>
                        <input type="text" name="kode"
                               class="form-control font-mono @error('kode') is-invalid @enderror"
                               value="{{ old('kode') }}" placeholder="S1-TI" maxlength="10"
                               style="text-transform:uppercase">
                        @error('kode')<p class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>@enderror
                        <p class="form-hint">Contoh: S1-TI, D3-AK, S2-MN</p>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Program Studi <span class="req">*</span></label>
                        <input type="text" name="nama"
                               class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama') }}" placeholder="Teknik Informatika">
                        @error('nama')<p class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jenjang <span class="req">*</span></label>
                        <select name="jenjang" class="form-control @error('jenjang') is-invalid @enderror">
                            @foreach(['D3','S1','S2','S3'] as $j)
                                <option value="{{ $j }}" {{ old('jenjang','S1') === $j ? 'selected' : '' }}>{{ $j }}</option>
                            @endforeach
                        </select>
                        @error('jenjang')<p class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-full" style="justify-content:center">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                    </button>
                </form>
            </div>
        </div>

        {{-- Edit Modal (inline panel) --}}
        <div class="card" id="form-edit" style="display:none;border:2px solid var(--denim-400)">
            <div class="card-header" style="background:var(--denim-50)">
                <h2 class="card-title" style="color:var(--denim-700)">
                    <i class="fa-solid fa-pencil" style="margin-right:8px"></i>
                    Edit Program Studi
                </h2>
                <button onclick="closeEditPanel()" class="btn btn-secondary btn-sm btn-icon">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="card-body">
                <form id="edit-form" action="" method="POST">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label class="form-label">Kode <span class="req">*</span></label>
                        <input type="text" id="edit-kode" name="kode"
                               class="form-control font-mono" maxlength="10" style="text-transform:uppercase">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama <span class="req">*</span></label>
                        <input type="text" id="edit-nama" name="nama" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jenjang <span class="req">*</span></label>
                        <select id="edit-jenjang" name="jenjang" class="form-control">
                            <option>D3</option><option>S1</option><option>S2</option><option>S3</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-full" style="justify-content:center">
                        <i class="fa-solid fa-floppy-disk"></i> Perbarui
                    </button>
                </form>
            </div>
        </div>

        {{-- Info --}}
        <div class="card">
            <div class="card-body" style="padding:16px">
                <p style="font-size:12px;color:var(--text-muted);line-height:1.6">
                    <i class="fa-solid fa-circle-info" style="color:var(--denim-400);margin-right:5px"></i>
                    Program studi yang memiliki mahasiswa terdaftar <strong>tidak dapat dihapus</strong>.
                    Hapus atau pindahkan mahasiswanya terlebih dahulu.
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openEditModal(id, kode, nama, jenjang) {
    document.getElementById('form-edit').style.display = 'block';
    document.getElementById('edit-form').action = `/prodi/${id}`;
    document.getElementById('edit-kode').value = kode;
    document.getElementById('edit-nama').value = nama;
    document.getElementById('edit-jenjang').value = jenjang;
    document.getElementById('form-edit').scrollIntoView({ behavior:'smooth' });
}
function closeEditPanel() {
    document.getElementById('form-edit').style.display = 'none';
}
</script>
@endpush
@endsection