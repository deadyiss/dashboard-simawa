@extends('layouts.app')

@section('title', 'Detail Mahasiswa')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right" style="font-size:9px"></i>
    <a href="{{ route('mahasiswa.index') }}">Mahasiswa</a>
    <i class="fa-solid fa-chevron-right" style="font-size:9px"></i>
    <span>Detail</span>
@endsection

@section('content')
<div style="max-width:680px">
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="card-title">
                    <i class="fa-solid fa-id-card" style="color:var(--denim-500);margin-right:8px"></i>
                    Detail Mahasiswa
                </h2>
                <p class="text-sm text-muted mt-1">Informasi lengkap data mahasiswa</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('mahasiswa.kartu', $mahasiswa) }}" target="_blank"
                   class="btn btn-secondary btn-sm" title="Cetak Kartu Mahasiswa">
                    <i class="fa-solid fa-print"></i> Kartu
                </a>
                <a href="{{ route('mahasiswa.edit', $mahasiswa) }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-pencil"></i> Edit
                </a>
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
        </div>

        {{-- Profile header --}}
        <div style="padding:28px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:20px">
            <div style="width:72px;height:72px;background:linear-gradient(135deg,var(--denim-400),var(--denim-700));border-radius:18px;display:grid;place-items:center;font-size:26px;font-weight:800;color:#fff;flex-shrink:0">
                {{ strtoupper(substr($mahasiswa->nama_lengkap, 0, 1)) }}
            </div>
            <div>
                <h2 style="font-size:20px;font-weight:800;color:var(--text-primary);letter-spacing:-.3px">
                    {{ $mahasiswa->nama_lengkap }}
                </h2>
                <div class="flex items-center gap-2" style="margin-top:6px;flex-wrap:wrap">
                    <span class="badge badge-blue font-mono">
                        <i class="fa-solid fa-hashtag" style="font-size:10px;margin-right:3px"></i>
                        {{ $mahasiswa->npm }}
                    </span>
                    <span class="badge badge-{{ $mahasiswa->status_color }}">
                        {{ $mahasiswa->status_label }}
                    </span>
                    @if($mahasiswa->angkatan)
                        <span class="badge badge-gray font-mono">
                            <i class="fa-solid fa-calendar" style="font-size:10px;margin-right:3px"></i>
                            {{ $mahasiswa->angkatan }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body">

            {{-- Prodi --}}
            @if($mahasiswa->prodi)
            <div style="background:var(--surface-2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:16px;margin-bottom:16px">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-10">
                        <div>
                            <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--denim-600)">Program Studi</p>
                            <p style="font-size:15px;font-weight:700;color:var(--text-primary);margin-top:3px">{{ $mahasiswa->prodi->nama }}</p>
                        </div>
                        <div>
                            <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--denim-600)">Jenjang</p>
                            <span class="badge badge-blue" style="margin-top:3px;font-size:13px">{{ $mahasiswa->prodi->jenjang }}</span>
                        </div>
                    </div>
                    <div style="width:44px;height:44px;background:var(--denim-100);border-radius:11px;display:grid;place-items:center;color:var(--denim-600);font-size:18px">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                </div>
            </div>
            @endif

            {{-- Contact grid --}}
            <div class="grid grid-2" style="gap:12px;margin-bottom:12px">
                @foreach([
                    ['Email', $mahasiswa->email, 'fa-solid fa-envelope'],
                    ['Telepon', $mahasiswa->telepon, 'fa-solid fa-phone'],
                ] as [$label, $val, $icon])
                <div style="background:var(--surface-2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:16px">
                    <div class="flex items-center gap-8" style="margin-bottom:6px">
                        <i class="{{ $icon }}" style="color:var(--denim-500);font-size:12px"></i>
                        <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--denim-600)">{{ $label }}</p>
                    </div>
                    <p style="font-size:14px;font-weight:600;color:var(--text-primary)">{{ $val }}</p>
                </div>
                @endforeach
            </div>

            {{-- Alamat --}}
            <div style="background:var(--surface-2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:16px;margin-bottom:16px">
                <div class="flex items-center gap-8" style="margin-bottom:6px">
                    <i class="fa-solid fa-location-dot" style="color:var(--denim-500);font-size:12px"></i>
                    <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--denim-600)">Alamat</p>
                </div>
                <p style="font-size:14px;font-weight:500;color:var(--text-primary);line-height:1.6">{{ $mahasiswa->alamat }}</p>
            </div>

            {{-- Timestamps --}}
            <div class="grid grid-2" style="gap:12px;margin-bottom:20px">
                @foreach([
                    ['Ditambahkan', $mahasiswa->created_at->isoFormat('dddd, D MMMM Y · HH:mm'), 'fa-solid fa-clock'],
                    ['Diperbarui',  $mahasiswa->updated_at->isoFormat('dddd, D MMMM Y · HH:mm'),  'fa-solid fa-rotate'],
                ] as [$label, $val, $icon])
                <div style="padding:12px 16px;border:1px solid var(--border);border-radius:var(--radius-sm)">
                    <div class="flex items-center gap-6" style="margin-bottom:4px">
                        <i class="{{ $icon }}" style="color:var(--text-muted);font-size:11px"></i>
                        <p style="font-size:11px;color:var(--text-muted);font-weight:600">{{ $label }}</p>
                    </div>
                    <p style="font-size:12.5px;color:var(--text-secondary);font-weight:500">{{ $val }}</p>
                </div>
                @endforeach
            </div>

            {{-- Delete --}}
            <div style="padding-top:20px;border-top:1px solid var(--border)">
                <form id="del-show-{{ $mahasiswa->id }}" action="{{ route('mahasiswa.destroy', $mahasiswa) }}" method="POST" style="display:none">
                    @csrf @method('DELETE')
                </form>
                <button type="button" class="btn btn-danger btn-sm"
                        onclick="confirmDelete('del-show-{{ $mahasiswa->id }}', '{{ addslashes($mahasiswa->nama_lengkap) }}')">
                    <i class="fa-solid fa-trash"></i> Hapus Data Ini
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
