@extends('layouts.app')

@section('title', 'About')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right" style="font-size:9px"></i>
    <span>About</span>
@endsection

@section('content')
<div style="max-width:700px">

    {{-- Hero Card --}}
    <div class="card" style="background:linear-gradient(135deg,var(--denim-900),var(--denim-700));border:none;margin-bottom:20px;overflow:hidden;position:relative">
        <div style="position:absolute;top:-40px;right:-40px;width:200px;height:200px;background:rgba(255,255,255,.03);border-radius:50%"></div>
        <div style="position:absolute;bottom:-60px;left:-20px;width:160px;height:160px;background:rgba(255,255,255,.03);border-radius:50%"></div>
        <div class="card-body" style="padding:36px;position:relative">
            <div style="display:flex;align-items:center;gap:20px">
                <div style="width:72px;height:72px;background:rgba(255,255,255,.1);backdrop-filter:blur(10px);border-radius:18px;display:grid;place-items:center;font-size:30px;color:#fff;flex-shrink:0;border:1px solid rgba(255,255,255,.15)">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <h1 style="font-size:26px;font-weight:800;color:#fff;letter-spacing:-.5px">SiMawa</h1>
                    <p style="color:var(--denim-200);font-size:14px;margin-top:4px">Sistem Informasi Mahasiswa — v1.0.0</p>
                </div>
            </div>
            <p style="color:rgba(255,255,255,.7);font-size:14px;line-height:1.7;margin-top:20px">
                Aplikasi manajemen data mahasiswa yang dibangun dengan Laravel 12, dirancang untuk
                memudahkan pengelolaan data akademik dengan antarmuka yang bersih dan modern.
            </p>
        </div>
    </div>

    {{-- Tech Stack --}}
    <div class="card" style="margin-bottom:20px">
        <div class="card-header">
            <h2 class="card-title">
                <i class="fa-solid fa-layer-group" style="color:var(--denim-500);margin-right:8px"></i>
                Teknologi yang Digunakan
            </h2>
        </div>
        <div class="card-body">
            <div class="grid grid-2" style="gap:12px">
                @foreach([
                    ['Laravel 12',  'PHP Framework',              'fa-brands fa-laravel',  '#ef4444', '#fee2e2'],
                    ['PHP 8.3+',    'Server-Side Language',       'fa-brands fa-php',      '#7c3aed', '#ede9fe'],
                    ['MySQL',       'Relational Database',         'fa-solid fa-database',  '#0ea5e9', '#e0f2fe'],
                    ['Blade',       'Template Engine',             'fa-solid fa-file-code', '#10b981', '#d1fae5'],
                    ['Font Awesome','Icon Library',                'fa-brands fa-font-awesome','#3b82f6','#dbeafe'],
                    ['Google Fonts','Plus Jakarta Sans',           'fa-brands fa-google',   '#f59e0b', '#fef3c7'],
                ] as [$name, $desc, $icon, $color, $bg])
                <div style="display:flex;align-items:center;gap:12px;padding:14px;border:1px solid var(--border);border-radius:var(--radius-sm);transition:box-shadow .2s" onmouseover="this.style.boxShadow='var(--shadow-md)'" onmouseout="this.style.boxShadow='none'">
                    <div style="width:40px;height:40px;background:{{ $bg }};border-radius:10px;display:grid;place-items:center;color:{{ $color }};font-size:16px;flex-shrink:0">
                        <i class="{{ $icon }}"></i>
                    </div>
                    <div>
                        <p style="font-weight:700;font-size:14px;color:var(--text-primary)">{{ $name }}</p>
                        <p style="font-size:12px;color:var(--text-muted)">{{ $desc }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Features --}}
    <div class="card" style="margin-bottom:20px">
        <div class="card-header">
            <h2 class="card-title">
                <i class="fa-solid fa-star" style="color:var(--denim-500);margin-right:8px"></i>
                Fitur Aplikasi
            </h2>
        </div>
        <div class="card-body">
            <div style="display:flex;flex-direction:column;gap:10px">
                @foreach([
                    'CRUD lengkap untuk data mahasiswa (Create, Read, Update, Delete)',
                    'Pencarian data berdasarkan NPM, nama, dan email',
                    'Validasi data server-side dengan pesan error yang jelas',
                    'Pagination otomatis untuk daftar mahasiswa',
                    'Dashboard dengan statistik dan data terbaru',
                    'Desain responsif dengan tema denim blue yang modern',
                    'Layout admin dengan sidebar navigasi',
                ] as $feature)
                <div style="display:flex;align-items:flex-start;gap:10px;padding:12px;background:var(--denim-50);border-radius:var(--radius-sm)">
                    <i class="fa-solid fa-check" style="color:var(--denim-500);margin-top:2px;flex-shrink:0"></i>
                    <p style="font-size:13.5px;color:var(--text-primary)">{{ $feature }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Footer Info --}}
    <div style="text-align:center;padding:20px;color:var(--text-muted);font-size:12.5px">
        <p>Dibuat oleh Dhea Arimbi Almalita menggunakan Laravel 12</p>
        <p class="mt-1">{{ now()->format('Y') }} · SiMawa</p>
    </div>

</div>
@endsection