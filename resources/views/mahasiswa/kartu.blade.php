<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Mahasiswa — {{ $mahasiswa->nama_lengkap }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <style>
        * { box-sizing:border-box; margin:0; padding:0; }

        body {
            font-family:'Plus Jakarta Sans', sans-serif;
            background:#e8eef7;
            min-height:100vh;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            gap:24px;
            padding:40px;
        }

        .print-actions {
            display:flex; gap:10px;
        }

        .btn {
            display:inline-flex; align-items:center; gap:8px;
            padding:10px 20px; border-radius:8px;
            font-family:inherit; font-size:14px; font-weight:600;
            cursor:pointer; border:none; text-decoration:none; transition:all .2s;
        }

        .btn-primary {
            background:linear-gradient(135deg,#2458b8,#1a3a78);
            color:#fff; box-shadow:0 3px 10px rgba(36,88,184,.3);
        }
        .btn-primary:hover { transform:translateY(-1px); box-shadow:0 5px 14px rgba(36,88,184,.4); }

        .btn-secondary {
            background:#fff; color:#475569; border:1px solid #e2e8f0;
        }
        .btn-secondary:hover { background:#f1f5f9; }

        /* ── KARTU ───────────────────────────────── */
        .kartu {
            width: 340px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(15,32,68,.25), 0 4px 16px rgba(15,32,68,.1);
            position: relative;
        }

        /* Header */
        .kartu-header {
            background: linear-gradient(135deg, #0f2044 0%, #1e4694 60%, #3a70d4 100%);
            padding: 22px 24px 28px;
            position: relative;
            overflow: hidden;
        }

        .kartu-header::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 140px; height: 140px;
            border-radius: 50%;
            background: rgba(255,255,255,.05);
        }
        .kartu-header::after {
            content: '';
            position: absolute;
            bottom: -30px; left: -20px;
            width: 100px; height: 100px;
            border-radius: 50%;
            background: rgba(255,255,255,.04);
        }

        .univ-row {
            display: flex; align-items: center; gap: 10px;
            position: relative; z-index: 1;
        }

        .univ-logo {
            width: 38px; height: 38px;
            background: rgba(255,255,255,.15);
            border-radius: 10px;
            display: grid; place-items: center;
            font-size: 18px; color: #fff;
            flex-shrink: 0;
        }

        .univ-name strong {
            display: block; font-size: 11px; font-weight: 800;
            color: #fff; letter-spacing: .3px; line-height: 1.2;
        }

        .univ-name span {
            font-size: 9.5px; color: rgba(255,255,255,.6); font-weight: 400;
        }

        .kartu-label {
            position: relative; z-index: 1;
            margin-top: 14px;
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 2px;
            color: rgba(255,255,255,.5);
        }

        /* Body */
        .kartu-body {
            background: #fff;
            padding: 20px 24px;
        }

        .photo-row {
            display: flex; align-items: flex-start; gap: 16px;
            margin-bottom: 16px;
        }

        .photo {
            width: 68px; height: 80px;
            background: linear-gradient(135deg, #dce9fc, #a8c4f4);
            border-radius: 10px;
            display: grid; place-items: center;
            font-size: 28px; font-weight: 800;
            color: #1e4694;
            flex-shrink: 0;
            border: 2px solid #dce9fc;
        }

        .name-block {
            flex: 1;
            padding-top: 4px;
        }

        .name-block h2 {
            font-size: 14.5px; font-weight: 800;
            color: #0f172a; letter-spacing: -.3px; line-height: 1.3;
            margin-bottom: 6px;
        }

        .npm-chip {
            display: inline-flex; align-items: center; gap: 5px;
            background: #0f2044; color: #fff;
            padding: 4px 10px; border-radius: 6px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 11.5px; font-weight: 500;
        }

        /* Info table */
        .info-table {
            border-top: 1.5px solid #e2e8f0;
            padding-top: 14px;
            display: flex; flex-direction: column; gap: 10px;
        }

        .info-row {
            display: flex; align-items: flex-start; gap: 10px;
        }

        .info-icon {
            width: 24px; height: 24px;
            background: #f0f6ff;
            border-radius: 6px;
            display: grid; place-items: center;
            color: #1e4694; font-size: 10px;
            flex-shrink: 0;
        }

        .info-label {
            font-size: 9.5px; font-weight: 700;
            text-transform: uppercase; letter-spacing: .6px;
            color: #94a3b8;
        }

        .info-value {
            font-size: 12.5px; font-weight: 600;
            color: #0f172a; line-height: 1.2;
        }

        /* Status chip */
        .status-aktif   { background:#d1fae5; color:#065f46; }
        .status-cuti    { background:#fef3c7; color:#92400e; }
        .status-lulus   { background:#dbeafe; color:#1e40af; }
        .status-dropout { background:#fee2e2; color:#991b1b; }
        .status-chip {
            display:inline-flex; align-items:center;
            padding:3px 9px; border-radius:99px;
            font-size:10.5px; font-weight:700;
        }

        /* Footer strip */
        .kartu-footer {
            background: #0f2044;
            padding: 10px 24px;
            display: flex; align-items: center; justify-content: space-between;
        }

        .kartu-footer p {
            font-size: 9px; color: rgba(255,255,255,.4);
            font-weight: 500; letter-spacing: .3px;
        }

        /* ── PRINT ───────────────────────────────── */
        @media print {
            body {
                background: none;
                display: block;
                padding: 0;
            }

            .print-actions { display: none !important; }

            .kartu {
                box-shadow: none;
                border: 1px solid #ccc;
                border-radius: 12px;
                margin: 0 auto;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

{{-- Print actions (hidden when printing) --}}
<div class="print-actions">
    <button class="btn btn-primary" onclick="window.print()">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
        Cetak Kartu
    </button>
    <a class="btn btn-secondary" href="{{ route('mahasiswa.show', $mahasiswa) }}">← Kembali</a>
</div>

{{-- KARTU --}}
<div class="kartu">

    {{-- Header --}}
    <div class="kartu-header">
        <div class="univ-row">
            <div class="univ-logo">🎓</div>
            <div class="univ-name">
                <strong>Sistem Informasi Mahasiswa</strong>
                <span>SiMawa · Laravel 12</span>
            </div>
        </div>
        <p class="kartu-label">Kartu Tanda Mahasiswa</p>
    </div>

    {{-- Body --}}
    <div class="kartu-body">
        <div class="photo-row">
            <div class="photo">{{ strtoupper(substr($mahasiswa->nama_lengkap, 0, 1)) }}</div>
            <div class="name-block">
                <h2>{{ $mahasiswa->nama_lengkap }}</h2>
                <div class="npm-chip">
                    # {{ $mahasiswa->npm }}
                </div>
            </div>
        </div>

        <div class="info-table">
            @if($mahasiswa->prodi)
            <div class="info-row">
                <div class="info-icon">🏛</div>
                <div>
                    <p class="info-label">Program Studi</p>
                    <p class="info-value">{{ $mahasiswa->prodi->jenjang }} — {{ $mahasiswa->prodi->nama }}</p>
                </div>
            </div>
            @endif

            @if($mahasiswa->angkatan)
            <div class="info-row">
                <div class="info-icon">📅</div>
                <div>
                    <p class="info-label">Angkatan</p>
                    <p class="info-value">{{ $mahasiswa->angkatan }}</p>
                </div>
            </div>
            @endif

            <div class="info-row">
                <div class="info-icon">📊</div>
                <div>
                    <p class="info-label">Status</p>
                    <span class="status-chip status-{{ $mahasiswa->status }}">
                        {{ $mahasiswa->status_label }}
                    </span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon">✉</div>
                <div>
                    <p class="info-label">Email</p>
                    <p class="info-value">{{ $mahasiswa->email }}</p>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon">📱</div>
                <div>
                    <p class="info-label">Telepon</p>
                    <p class="info-value" style="font-family:'JetBrains Mono',monospace">{{ $mahasiswa->telepon }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="kartu-footer">
        <p>Dicetak: {{ now()->isoFormat('D MMM Y') }}</p>
        <p>SiMawa · Sistem Informasi Mahasiswa</p>
    </div>
</div>

</body>
</html>
