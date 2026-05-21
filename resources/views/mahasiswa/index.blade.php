@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right" style="font-size:9px"></i>
    <span>Mahasiswa</span>
@endsection

@section('content')

{{-- ── FILTER BAR ─────────────────────────────────────── --}}
<div class="card" style="margin-bottom:16px">
    <div class="card-body" style="padding:16px 20px">
        <form method="GET" action="{{ route('mahasiswa.index') }}">
            <div class="flex flex-wrap items-center gap-2">

                {{-- Search --}}
                <div class="search-box" style="flex:1;min-width:200px">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" class="form-control"
                           placeholder="Cari NPM, nama, email…"
                           value="{{ $filters['search'] }}" style="width:100%">
                </div>

                {{-- Prodi filter --}}
                <select name="prodi" class="form-control" style="width:190px">
                    <option value="">Semua Prodi</option>
                    @foreach($prodis->groupBy('jenjang') as $jenjang => $list)
                        <optgroup label="{{ $jenjang }}">
                            @foreach($list as $p)
                                <option value="{{ $p->id }}" {{ $filters['prodi'] == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>

                {{-- Status filter --}}
                <select name="status" class="form-control" style="width:140px">
                    <option value="">Semua Status</option>
                    @foreach(\App\Models\Mahasiswa::statusList() as $key => $def)
                        <option value="{{ $key }}" {{ $filters['status'] === $key ? 'selected' : '' }}>
                            {{ $def['label'] }}
                        </option>
                    @endforeach
                </select>

                {{-- Angkatan filter --}}
                <select name="angkatan" class="form-control" style="width:130px">
                    <option value="">Semua Angkatan</option>
                    @foreach($angkatans as $thn)
                        <option value="{{ $thn }}" {{ $filters['angkatan'] == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>

                @if(array_filter($filters))
                    <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fa-solid fa-xmark"></i> Reset
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- ── MAIN TABLE CARD ────────────────────────────────── --}}
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fa-solid fa-users" style="color:var(--denim-500);margin-right:8px"></i>
            Daftar Mahasiswa
            @if($mahasiswas->total() > 0)
                <span class="badge badge-blue" style="margin-left:8px">{{ $mahasiswas->total() }}</span>
            @endif
        </h2>
        <div class="flex items-center gap-2">
            {{-- Export buttons --}}
            <a href="{{ route('mahasiswa.export.excel', $filters) }}" class="btn btn-success btn-sm">
                <i class="fa-solid fa-file-excel"></i> Excel
            </a>
            <a href="{{ route('mahasiswa.export.pdf', $filters) }}" class="btn btn-danger btn-sm" style="background:#fee2e2;color:#b91c1c;border-color:#fecaca">
                <i class="fa-solid fa-file-pdf"></i> PDF
            </a>
            <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i> Tambah
            </a>
        </div>
    </div>

    @if($mahasiswas->isEmpty())
        <div class="empty-state">
            <div class="empty-icon"><i class="fa-solid fa-user-slash"></i></div>
            @if(array_filter($filters))
                <h3>Tidak ada hasil</h3>
                <p>Tidak ada mahasiswa yang cocok dengan filter yang dipilih</p>
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary btn-sm">Reset Filter</a>
            @else
                <h3>Belum ada data mahasiswa</h3>
                <p>Mulai dengan menambahkan mahasiswa pertama</p>
                <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-plus"></i> Tambah Mahasiswa
                </a>
            @endif
        </div>
    @else
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NPM</th>
                        <th>Nama Lengkap</th>
                        <th>Program Studi</th>
                        <th>Angkatan</th>
                        <th>Status</th>
                        <th>Kontak</th>
                        <th style="text-align:center;width:120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mahasiswas as $i => $mhs)
                    <tr>
                        <td class="text-muted text-sm">{{ $mahasiswas->firstItem() + $i }}</td>
                        <td><span class="badge badge-blue font-mono">{{ $mhs->npm }}</span></td>
                        <td>
                            <div style="font-weight:600">{{ $mhs->nama_lengkap }}</div>
                            <div class="text-sm text-muted truncate" style="max-width:160px">{{ $mhs->alamat }}</div>
                        </td>
                        <td>
                            @if($mhs->prodi)
                                <div style="font-size:13px;font-weight:600">{{ $mhs->prodi->nama }}</div>
                                <span class="badge badge-blue" style="font-size:10px;padding:2px 7px;margin-top:2px">{{ $mhs->prodi->jenjang }}</span>
                            @else
                                <span class="text-muted text-sm">—</span>
                            @endif
                        </td>
                        <td class="font-mono text-sm">{{ $mhs->angkatan ?? '—' }}</td>
                        <td>
                            <span class="badge badge-{{ $mhs->status_color }}">{{ $mhs->status_label }}</span>
                        </td>
                        <td>
                            <div style="font-size:13px">{{ $mhs->email }}</div>
                            <div class="font-mono text-sm text-muted">{{ $mhs->telepon }}</div>
                        </td>
                        <td>
                            <div class="flex items-center gap-1" style="justify-content:center">
                                <a href="{{ route('mahasiswa.show', $mhs) }}"
                                   class="btn btn-secondary btn-sm btn-icon" title="Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('mahasiswa.kartu', $mhs) }}"
                                   class="btn btn-secondary btn-sm btn-icon" title="Cetak Kartu" target="_blank">
                                    <i class="fa-solid fa-id-card"></i>
                                </a>
                                <a href="{{ route('mahasiswa.edit', $mhs) }}"
                                   class="btn btn-secondary btn-sm btn-icon" title="Edit">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>

                                {{-- Hidden delete form --}}
                                <form id="del-{{ $mhs->id }}" action="{{ route('mahasiswa.destroy', $mhs) }}" method="POST" style="display:none">
                                    @csrf @method('DELETE')
                                </form>
                                <button type="button"
                                        class="btn btn-danger btn-sm btn-icon"
                                        title="Hapus"
                                        onclick="confirmDelete('del-{{ $mhs->id }}', '{{ addslashes($mhs->nama_lengkap) }}')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($mahasiswas->hasPages())
        <div class="pagination-wrapper">
            <p class="pagination-info">
                Menampilkan {{ $mahasiswas->firstItem() }}–{{ $mahasiswas->lastItem() }} dari {{ $mahasiswas->total() }} mahasiswa
            </p>
            <div class="pagination">
                @if($mahasiswas->onFirstPage())
                    <span class="disabled"><i class="fa-solid fa-chevron-left" style="font-size:10px"></i></span>
                @else
                    <a href="{{ $mahasiswas->previousPageUrl() }}"><i class="fa-solid fa-chevron-left" style="font-size:10px"></i></a>
                @endif

                @foreach($mahasiswas->getUrlRange(1, $mahasiswas->lastPage()) as $page => $url)
                    @if($page == $mahasiswas->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($mahasiswas->hasMorePages())
                    <a href="{{ $mahasiswas->nextPageUrl() }}"><i class="fa-solid fa-chevron-right" style="font-size:10px"></i></a>
                @else
                    <span class="disabled"><i class="fa-solid fa-chevron-right" style="font-size:10px"></i></span>
                @endif
            </div>
        </div>
        @else
        <div class="pagination-wrapper">
            <p class="pagination-info">Menampilkan {{ $mahasiswas->count() }} mahasiswa</p>
        </div>
        @endif
    @endif
</div>
@endsection