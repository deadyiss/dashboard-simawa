<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Mahasiswa — Export PDF</title>
    <style>
        * { box-sizing:border-box; margin:0; padding:0; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size:11px; color:#1e293b; background:#fff; }

        .header {
            background: #0f2044;
            color: #fff;
            padding: 16px 24px;
            margin-bottom: 20px;
        }
        .header h1 { font-size: 17px; font-weight: bold; letter-spacing: -.3px; }
        .header p  { font-size: 10px; color: #a8c4f4; margin-top:3px; }

        .meta {
            padding: 0 24px;
            margin-bottom: 16px;
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            color: #64748b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 24px;
            width: calc(100% - 48px);
        }

        thead th {
            background: #1e4694;
            color: #fff;
            padding: 8px 10px;
            text-align: left;
            font-size: 9.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10.5px;
            vertical-align: top;
        }

        tbody tr:nth-child(even) td { background: #f8fafc; }

        .npm { font-family: monospace; font-size: 10px; font-weight: bold; }

        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-aktif   { background: #d1fae5; color: #065f46; }
        .badge-cuti    { background: #fef3c7; color: #92400e; }
        .badge-lulus   { background: #dbeafe; color: #1e40af; }
        .badge-dropout { background: #fee2e2; color: #991b1b; }

        .footer {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            padding: 8px 24px;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
        }

        .filters {
            padding: 0 24px 14px;
            display: flex;
            gap: 12px;
            font-size: 10px;
            color: #64748b;
        }
        .filter-chip {
            background: #f0f6ff;
            color: #1e4694;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>📋 Data Mahasiswa — SiMawa</h1>
    <p>Diekspor pada {{ now()->isoFormat('dddd, D MMMM Y · HH:mm') }}</p>
</div>

@php
    $activeFilters = array_filter($filters);
@endphp

@if($activeFilters)
<div class="filters">
    <span style="font-weight:bold;color:#0f172a">Filter aktif:</span>
    @if($filters['search'])<span class="filter-chip">Cari: {{ $filters['search'] }}</span>@endif
    @if($filters['status'])<span class="filter-chip">Status: {{ ucfirst($filters['status']) }}</span>@endif
    @if($filters['angkatan'])<span class="filter-chip">Angkatan: {{ $filters['angkatan'] }}</span>@endif
</div>
@endif

<div class="meta">
    <span>Total: <strong>{{ $mahasiswas->count() }} mahasiswa</strong></span>
    <span>SiMawa · Sistem Informasi Mahasiswa</span>
</div>

<table>
    <thead>
        <tr>
            <th style="width:30px">No</th>
            <th>NPM</th>
            <th>Nama Lengkap</th>
            <th>Program Studi</th>
            <th style="width:55px">Angkatan</th>
            <th style="width:55px">Status</th>
            <th>Email</th>
            <th>Telepon</th>
        </tr>
    </thead>
    <tbody>
        @forelse($mahasiswas as $i => $mhs)
        <tr>
            <td style="text-align:center;color:#94a3b8">{{ $i + 1 }}</td>
            <td class="npm">{{ $mhs->npm }}</td>
            <td><strong>{{ $mhs->nama_lengkap }}</strong></td>
            <td>
                @if($mhs->prodi)
                    {{ $mhs->prodi->nama }}
                    <span style="font-size:9px;color:#64748b">({{ $mhs->prodi->jenjang }})</span>
                @else
                    <span style="color:#94a3b8">—</span>
                @endif
            </td>
            <td style="text-align:center;font-family:monospace">{{ $mhs->angkatan ?? '—' }}</td>
            <td><span class="badge badge-{{ $mhs->status }}">{{ $mhs->status_label }}</span></td>
            <td>{{ $mhs->email }}</td>
            <td style="font-family:monospace">{{ $mhs->telepon }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="8" style="text-align:center;padding:24px;color:#94a3b8">Tidak ada data</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    <span>SiMawa — Sistem Informasi Mahasiswa</span>
    <span>{{ now()->format('d/m/Y H:i') }}</span>
</div>

</body>
</html>
