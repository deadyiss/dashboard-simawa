@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

@php
$statusDef = \App\Models\Mahasiswa::statusList();
$statusColors = [
    'aktif'   => ['bg'=>'#d1fae5','text'=>'#059669','icon'=>'fa-user-check'],
    'cuti'    => ['bg'=>'#fef3c7','text'=>'#d97706','icon'=>'fa-user-clock'],
    'lulus'   => ['bg'=>'#dbeafe','text'=>'#2563eb','icon'=>'fa-user-graduate'],
    'dropout' => ['bg'=>'#fee2e2','text'=>'#dc2626','icon'=>'fa-user-minus'],
];
@endphp

{{-- ── TOP STAT CARDS ────────────────────────────────── --}}
<div class="grid grid-4" style="margin-bottom:20px">

    <div class="card" style="border-top:3px solid var(--denim-500)">
        <div class="card-body" style="padding:20px 24px">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm text-muted" style="font-weight:700;text-transform:uppercase;letter-spacing:.8px">Total</p>
                <div style="width:42px;height:42px;background:var(--denim-100);border-radius:10px;display:grid;place-items:center;color:var(--denim-600);font-size:17px">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <p style="font-size:34px;font-weight:800;color:var(--denim-700);letter-spacing:-1.5px;line-height:1">{{ number_format($totalMahasiswa) }}</p>
            <p class="text-sm text-muted mt-1">Mahasiswa terdaftar</p>
        </div>
    </div>

    <div class="card" style="border-top:3px solid #10b981">
        <div class="card-body" style="padding:20px 24px">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm text-muted" style="font-weight:700;text-transform:uppercase;letter-spacing:.8px">Baru</p>
                <div style="width:42px;height:42px;background:#d1fae5;border-radius:10px;display:grid;place-items:center;color:#059669;font-size:17px">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
            </div>
            <p style="font-size:34px;font-weight:800;color:#059669;letter-spacing:-1.5px;line-height:1">{{ number_format($mahasiswaBaru) }}</p>
            <p class="text-sm text-muted mt-1">Bulan {{ now()->isoFormat('MMMM') }}</p>
        </div>
    </div>

    {{-- Status aktif --}}
    <div class="card" style="border-top:3px solid #2563eb">
        <div class="card-body" style="padding:20px 24px">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm text-muted" style="font-weight:700;text-transform:uppercase;letter-spacing:.8px">Aktif</p>
                <div style="width:42px;height:42px;background:#dbeafe;border-radius:10px;display:grid;place-items:center;color:#2563eb;font-size:17px">
                    <i class="fa-solid fa-user-check"></i>
                </div>
            </div>
            <p style="font-size:34px;font-weight:800;color:#2563eb;letter-spacing:-1.5px;line-height:1">{{ number_format($statusCounts['aktif'] ?? 0) }}</p>
            <p class="text-sm text-muted mt-1">Mahasiswa aktif</p>
        </div>
    </div>

    {{-- Lulus --}}
    <div class="card" style="border-top:3px solid #7c3aed">
        <div class="card-body" style="padding:20px 24px">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm text-muted" style="font-weight:700;text-transform:uppercase;letter-spacing:.8px">Lulus</p>
                <div style="width:42px;height:42px;background:#ede9fe;border-radius:10px;display:grid;place-items:center;color:#7c3aed;font-size:17px">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
            </div>
            <p style="font-size:34px;font-weight:800;color:#7c3aed;letter-spacing:-1.5px;line-height:1">{{ number_format($statusCounts['lulus'] ?? 0) }}</p>
            <p class="text-sm text-muted mt-1">Sudah lulus</p>
        </div>
    </div>
</div>

{{-- ── STATUS BREAKDOWN + PRODI ──────────────────────── --}}
<div class="grid" style="grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px">

    {{-- Status Breakdown --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-chart-pie" style="color:var(--denim-500);margin-right:8px"></i>Sebaran Status</h2>
        </div>
        <div class="card-body" style="display:flex;flex-direction:column;gap:12px">
            @foreach($statusDef as $key => $def)
            @php $count = $statusCounts[$key] ?? 0; $pct = $totalMahasiswa > 0 ? round(($count / $totalMahasiswa) * 100) : 0; $c = $statusColors[$key]; @endphp
            <div>
                <div class="flex items-center justify-between" style="margin-bottom:6px">
                    <div class="flex items-center gap-2">
                        <div style="width:28px;height:28px;background:{{ $c['bg'] }};border-radius:7px;display:grid;place-items:center;color:{{ $c['text'] }};font-size:12px">
                            <i class="fa-solid {{ $c['icon'] }}"></i>
                        </div>
                        <span style="font-size:13.5px;font-weight:600;color:var(--text-primary)">{{ $def['label'] }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span style="font-size:13px;font-weight:700;color:var(--text-primary)">{{ number_format($count) }}</span>
                        <span class="text-sm text-muted">({{ $pct }}%)</span>
                    </div>
                </div>
                <div style="height:6px;background:var(--surface-2);border-radius:99px;overflow:hidden">
                    <div style="height:100%;width:{{ $pct }}%;background:{{ $c['text'] }};border-radius:99px;transition:width .6s ease"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Top Prodi --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-building-columns" style="color:var(--denim-500);margin-right:8px"></i>Top Program Studi</h2>
            <a href="{{ route('prodi.index') }}" class="btn btn-secondary btn-sm">Kelola</a>
        </div>
        <div class="card-body" style="display:flex;flex-direction:column;gap:10px">
            @forelse($perProdi as $i => $prodi)
            @php $pct = $totalMahasiswa > 0 ? round(($prodi->mahasiswas_count / $totalMahasiswa) * 100) : 0; @endphp
            <div>
                <div class="flex items-center justify-between" style="margin-bottom:5px">
                    <div class="flex items-center gap-2">
                        <span style="width:20px;height:20px;background:var(--denim-{{ $i===0?'500':($i===1?'400':($i===2?'300':'200')) }});border-radius:5px;display:grid;place-items:center;color:#fff;font-size:10px;font-weight:700">{{ $i+1 }}</span>
                        <span style="font-size:13px;font-weight:600;color:var(--text-primary)">{{ $prodi->nama }}</span>
                        <span class="badge badge-blue" style="font-size:10px;padding:2px 7px">{{ $prodi->jenjang }}</span>
                    </div>
                    <span style="font-size:13px;font-weight:700;color:var(--text-primary)">{{ $prodi->mahasiswas_count }}</span>
                </div>
                <div style="height:5px;background:var(--surface-2);border-radius:99px;overflow:hidden">
                    <div style="height:100%;width:{{ $pct }}%;background:var(--denim-400);border-radius:99px;transition:width .6s ease"></div>
                </div>
            </div>
            @empty
            <p class="text-sm text-muted" style="text-align:center;padding:20px 0">Belum ada data prodi</p>
            @endforelse
        </div>
    </div>
</div>

{{-- ── LATEST TABLE + QUICK ACTIONS ─────────────────── --}}
<div class="grid" style="grid-template-columns:1fr 300px;gap:20px">

    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-clock-rotate-left" style="color:var(--denim-500);margin-right:8px"></i>Mahasiswa Terbaru</h2>
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary btn-sm">Lihat Semua <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        @if($latestMahasiswa->isEmpty())
            <div class="empty-state" style="padding:40px">
                <div class="empty-icon"><i class="fa-solid fa-users"></i></div>
                <h3>Belum ada data</h3>
                <p>Tambahkan mahasiswa pertama</p>
                <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i> Tambah</a>
            </div>
        @else
            <div class="table-wrapper">
                <table>
                    <thead><tr><th>NPM</th><th>Nama</th><th>Prodi</th><th>Status</th><th>Angkatan</th></tr></thead>
                    <tbody>
                        @foreach($latestMahasiswa as $mhs)
                        <tr>
                            <td><span class="badge badge-blue font-mono">{{ $mhs->npm }}</span></td>
                            <td>
                                <div style="font-weight:600">{{ $mhs->nama_lengkap }}</div>
                                <div class="text-sm text-muted">{{ $mhs->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="text-sm text-muted">{{ $mhs->prodi?->nama ?? '—' }}</td>
                            <td>
                                <span class="badge badge-{{ $mhs->status_color }}">{{ $mhs->status_label }}</span>
                            </td>
                            <td class="font-mono text-sm">{{ $mhs->angkatan ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div style="display:flex;flex-direction:column;gap:16px">
        <div class="card">
            <div class="card-header"><h2 class="card-title">Aksi Cepat</h2></div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:10px">
                <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary w-full" style="justify-content:center">
                    <i class="fa-solid fa-user-plus"></i> Tambah Mahasiswa
                </a>
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary w-full" style="justify-content:center">
                    <i class="fa-solid fa-list"></i> Semua Data
                </a>
                <a href="{{ route('mahasiswa.export.excel') }}" class="btn btn-success w-full" style="justify-content:center">
                    <i class="fa-solid fa-file-excel"></i> Export Excel
                </a>
                <a href="{{ route('mahasiswa.export.pdf') }}" class="btn btn-danger w-full" style="justify-content:center">
                    <i class="fa-solid fa-file-pdf"></i> Export PDF
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h2 class="card-title">Info Sistem</h2></div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:10px">
                @foreach([['Laravel','12','fa-brands fa-laravel','#ef4444'],['PHP',phpversion(),'fa-brands fa-php','#7c3aed'],['DB',config('database.default'),'fa-solid fa-database','#0ea5e9'],['Tanggal',now()->isoFormat('D MMM Y'),'fa-solid fa-calendar','#10b981']] as [$label,$val,$icon,$color])
                <div style="display:flex;align-items:center;gap:10px">
                    <div style="width:30px;height:30px;background:var(--surface-2);border-radius:7px;display:grid;place-items:center;color:{{ $color }};font-size:12px;flex-shrink:0">
                        <i class="{{ $icon }}"></i>
                    </div>
                    <div>
                        <p style="font-size:10px;color:var(--text-muted);font-weight:700;text-transform:uppercase;letter-spacing:.5px">{{ $label }}</p>
                        <p style="font-size:13px;font-weight:600;color:var(--text-primary)">{{ $val }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection