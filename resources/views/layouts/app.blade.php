<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — SiMawa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* ═══════════════════════════════════════════
           DESIGN TOKENS — LIGHT MODE
        ══════════════════════════════════════════ */
        :root {
            --denim-950: #0a1628;
            --denim-900: #0f2044;
            --denim-800: #152d5e;
            --denim-700: #1a3a78;
            --denim-600: #1e4694;
            --denim-500: #2458b8;
            --denim-400: #3a70d4;
            --denim-300: #6b9de8;
            --denim-200: #a8c4f4;
            --denim-100: #dce9fc;
            --denim-50:  #f0f6ff;

            --sidebar-w: 260px;
            --header-h:  64px;

            --text-primary:   #0f172a;
            --text-secondary: #475569;
            --text-muted:     #94a3b8;
            --border:         #e2e8f0;
            --bg:             #f8fafc;
            --surface:        #ffffff;
            --surface-2:      #f1f5f9;
            --shadow-sm:  0 1px 3px rgba(0,0,0,.08),0 1px 2px rgba(0,0,0,.06);
            --shadow-md:  0 4px 6px -1px rgba(0,0,0,.08),0 2px 4px -2px rgba(0,0,0,.06);
            --shadow-lg:  0 10px 15px -3px rgba(0,0,0,.1),0 4px 6px -4px rgba(0,0,0,.06);
            --radius:    12px;
            --radius-sm: 8px;
        }

        /* ═══════════════════════════════════════════
           DARK MODE OVERRIDES
        ══════════════════════════════════════════ */
        [data-theme="dark"] {
            --text-primary:   #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted:     #64748b;
            --border:         #1e3050;
            --bg:             #0a1628;
            --surface:        #0f2044;
            --surface-2:      #152d5e;
            --denim-50:       #0d1a38;
            --denim-100:      #152d5e;
            --shadow-sm:  0 1px 3px rgba(0,0,0,.3),0 1px 2px rgba(0,0,0,.2);
            --shadow-md:  0 4px 6px -1px rgba(0,0,0,.3),0 2px 4px -2px rgba(0,0,0,.2);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text-primary);
            display: flex;
            min-height: 100vh;
            font-size: 14px;
            line-height: 1.6;
            transition: background .3s, color .3s;
        }

        /* ── SIDEBAR ─────────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: linear-gradient(180deg, var(--denim-900) 0%, var(--denim-950) 100%);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            border-right: 1px solid rgba(255,255,255,.06);
        }

        .sidebar-brand {
            padding: 22px 24px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--denim-400), var(--denim-600));
            border-radius: 10px;
            display: grid; place-items: center;
            font-size: 18px; color: #fff;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(36,88,184,.4);
        }

        .brand-text strong { display:block; font-size:16px; font-weight:800; color:#fff; letter-spacing:-.3px; }
        .brand-text span   { font-size:11px; color:var(--denim-300); font-weight:400; }

        .sidebar-nav { flex:1; padding:20px 12px; overflow-y:auto; }

        .nav-section-label {
            font-size:10px; font-weight:700; text-transform:uppercase;
            letter-spacing:1.2px; color:var(--denim-300); opacity:.6;
            padding:0 12px; margin-bottom:8px; margin-top:16px;
        }
        .nav-section-label:first-child { margin-top:0; }

        .nav-item {
            display:flex; align-items:center; gap:12px;
            padding:10px 14px; border-radius:var(--radius-sm);
            color:rgba(255,255,255,.65);
            text-decoration:none; font-size:13.5px; font-weight:500;
            transition:all .2s; margin-bottom:2px; position:relative;
        }
        .nav-item:hover { background:rgba(255,255,255,.08); color:#fff; }
        .nav-item.active {
            background:linear-gradient(135deg,var(--denim-500),var(--denim-700));
            color:#fff; box-shadow:0 4px 12px rgba(36,88,184,.35);
        }
        .nav-item.active::before {
            content:''; position:absolute; left:0; top:50%; transform:translateY(-50%);
            width:3px; height:60%; background:var(--denim-200); border-radius:0 3px 3px 0;
        }
        .nav-item i { width:18px; text-align:center; font-size:14px; }

        .sidebar-footer {
            padding:16px 24px;
            border-top:1px solid rgba(255,255,255,.08);
        }
        .sidebar-footer p { font-size:11px; color:rgba(255,255,255,.3); text-align:center; }

        /* ── MAIN ────────────────────────────────── */
        .main-wrapper {
            margin-left:var(--sidebar-w);
            flex:1; display:flex; flex-direction:column; min-height:100vh;
        }

        /* ── TOPBAR ──────────────────────────────── */
        .topbar {
            height:var(--header-h);
            background:var(--surface);
            border-bottom:1px solid var(--border);
            display:flex; align-items:center; justify-content:space-between;
            padding:0 28px;
            position:sticky; top:0; z-index:50;
            box-shadow:var(--shadow-sm);
            transition:background .3s, border-color .3s;
        }
        .topbar-left h1 { font-size:17px; font-weight:700; color:var(--text-primary); letter-spacing:-.3px; }
        .breadcrumb {
            display:flex; align-items:center; gap:6px;
            font-size:12px; color:var(--text-muted); margin-top:1px;
        }
        .breadcrumb a { color:var(--denim-500); text-decoration:none; }
        .breadcrumb a:hover { text-decoration:underline; }

        .topbar-right { display:flex; align-items:center; gap:8px; }

        /* Dark mode toggle */
        .theme-toggle {
            width:36px; height:36px; border-radius:var(--radius-sm);
            background:var(--surface-2); border:1px solid var(--border);
            display:grid; place-items:center;
            color:var(--text-secondary); cursor:pointer;
            transition:all .2s; font-size:15px;
        }
        .theme-toggle:hover { background:var(--denim-100); color:var(--denim-600); }

        .avatar {
            width:36px; height:36px;
            background:linear-gradient(135deg,var(--denim-400),var(--denim-700));
            border-radius:50%; display:grid; place-items:center;
            color:#fff; font-size:13px; font-weight:700;
        }

        /* ── CONTENT ─────────────────────────────── */
        .content { flex:1; padding:28px; }

        /* ── CARD ────────────────────────────────── */
        .card {
            background:var(--surface);
            border-radius:var(--radius);
            border:1px solid var(--border);
            box-shadow:var(--shadow-sm);
            overflow:hidden;
            transition:background .3s, border-color .3s;
        }
        .card-header {
            padding:18px 24px;
            border-bottom:1px solid var(--border);
            display:flex; align-items:center; justify-content:space-between; gap:12px;
        }
        .card-title { font-size:15px; font-weight:700; color:var(--text-primary); letter-spacing:-.2px; }
        .card-body { padding:24px; }

        /* ── BUTTONS ─────────────────────────────── */
        .btn {
            display:inline-flex; align-items:center; gap:7px;
            padding:9px 18px; border-radius:var(--radius-sm);
            font-family:inherit; font-size:13.5px; font-weight:600;
            cursor:pointer; border:none; text-decoration:none;
            transition:all .2s; white-space:nowrap;
        }
        .btn-primary {
            background:linear-gradient(135deg,var(--denim-500),var(--denim-700));
            color:#fff; box-shadow:0 3px 10px rgba(36,88,184,.3);
        }
        .btn-primary:hover {
            background:linear-gradient(135deg,var(--denim-400),var(--denim-600));
            box-shadow:0 5px 14px rgba(36,88,184,.4); transform:translateY(-1px);
        }
        .btn-secondary {
            background:var(--surface-2); color:var(--text-secondary);
            border:1px solid var(--border);
        }
        .btn-secondary:hover { background:var(--border); color:var(--text-primary); }
        .btn-success { background:#d1fae5; color:#065f46; border:1px solid #a7f3d0; }
        .btn-success:hover { background:#a7f3d0; }
        .btn-warning { background:#fef3c7; color:#92400e; border:1px solid #fde68a; }
        .btn-warning:hover { background:#fde68a; }
        .btn-danger  { background:#fee2e2; color:#b91c1c; border:1px solid #fecaca; }
        .btn-danger:hover  { background:#fecaca; }
        .btn-sm { padding:6px 12px; font-size:12.5px; }
        .btn-icon { padding:7px; border-radius:var(--radius-sm); }

        /* ── FORM ────────────────────────────────── */
        .form-group { margin-bottom:20px; }
        .form-label { display:block; font-size:13px; font-weight:600; color:var(--text-primary); margin-bottom:6px; }
        .form-label .req { color:#ef4444; margin-left:2px; }
        .form-control {
            width:100%; padding:10px 14px;
            border:1.5px solid var(--border); border-radius:var(--radius-sm);
            font-family:inherit; font-size:14px;
            color:var(--text-primary); background:var(--surface);
            transition:border-color .2s, box-shadow .2s, background .3s; outline:none;
        }
        .form-control:focus { border-color:var(--denim-400); box-shadow:0 0 0 3px rgba(36,88,184,.12); }
        .form-control.is-invalid { border-color:#f87171; }
        textarea.form-control { resize:vertical; min-height:90px; }
        .invalid-feedback { font-size:12px; color:#dc2626; margin-top:4px; display:flex; align-items:center; gap:4px; }
        .form-hint { font-size:12px; color:var(--text-muted); margin-top:4px; }

        /* ── TABLE ───────────────────────────────── */
        .table-wrapper { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; font-size:13.5px; }
        thead th {
            background:var(--surface-2); padding:12px 16px;
            text-align:left; font-size:11px; font-weight:700;
            text-transform:uppercase; letter-spacing:.8px;
            color:var(--denim-600); border-bottom:2px solid var(--border); white-space:nowrap;
        }
        tbody td { padding:14px 16px; border-bottom:1px solid var(--border); vertical-align:middle; }
        tbody tr:last-child td { border-bottom:none; }
        tbody tr:hover td { background:var(--surface-2); }

        /* ── STATUS BADGES ───────────────────────── */
        .badge {
            display:inline-flex; align-items:center;
            padding:3px 10px; border-radius:99px; font-size:11.5px; font-weight:600;
        }
        .badge-blue   { background:var(--denim-100); color:var(--denim-700); }
        .badge-green  { background:#d1fae5; color:#065f46; }
        .badge-amber  { background:#fef3c7; color:#92400e; }
        .badge-red    { background:#fee2e2; color:#b91c1c; }
        .badge-gray   { background:var(--surface-2); color:var(--text-muted); }

        /* ── PAGINATION ──────────────────────────── */
        .pagination-wrapper {
            padding:16px 24px; border-top:1px solid var(--border);
            display:flex; align-items:center; justify-content:space-between; gap:12px;
        }
        .pagination-info { font-size:12.5px; color:var(--text-muted); }
        .pagination { display:flex; gap:4px; }
        .pagination a,.pagination span {
            display:inline-flex; align-items:center; justify-content:center;
            width:32px; height:32px; border-radius:var(--radius-sm);
            font-size:13px; font-weight:500; text-decoration:none; transition:all .15s;
        }
        .pagination a { color:var(--text-secondary); border:1px solid var(--border); }
        .pagination a:hover { background:var(--denim-50); border-color:var(--denim-200); color:var(--denim-600); }
        .pagination span.active { background:linear-gradient(135deg,var(--denim-500),var(--denim-700)); color:#fff; border:1px solid transparent; }
        .pagination span.disabled { color:var(--text-muted); border:1px solid var(--border); opacity:.5; }

        /* ── SEARCH / FILTER ─────────────────────── */
        .search-box { position:relative; }
        .search-box i { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:13px; }
        .search-box input { padding-left:36px !important; }

        /* ── EMPTY STATE ─────────────────────────── */
        .empty-state { text-align:center; padding:56px 24px; color:var(--text-muted); }
        .empty-state .empty-icon {
            width:72px; height:72px; background:var(--denim-50); border-radius:50%;
            display:grid; place-items:center; font-size:28px; color:var(--denim-300);
            margin:0 auto 16px;
        }
        .empty-state h3 { font-size:15px; font-weight:700; color:var(--text-primary); margin-bottom:4px; }
        .empty-state p  { font-size:13px; margin-bottom:20px; }

        /* ── GRID ────────────────────────────────── */
        .grid { display:grid; gap:20px; }
        .grid-4 { grid-template-columns:repeat(4,1fr); }
        .grid-3 { grid-template-columns:repeat(3,1fr); }
        .grid-2 { grid-template-columns:repeat(2,1fr); }
        @media(max-width:1100px){ .grid-4{ grid-template-columns:repeat(2,1fr); } }
        @media(max-width:700px) { .grid-4,.grid-2,.grid-3{ grid-template-columns:1fr; } }

        /* ── UTILS ───────────────────────────────── */
        .flex { display:flex; }
        .items-center { align-items:center; }
        .justify-between { justify-content:space-between; }
        .flex-wrap { flex-wrap:wrap; }
        .gap-2 { gap:8px; }
        .gap-3 { gap:12px; }
        .mt-1 { margin-top:4px; }
        .mt-4 { margin-top:16px; }
        .mb-4 { margin-bottom:16px; }
        .text-sm { font-size:12.5px; }
        .text-muted { color:var(--text-muted); }
        .font-mono { font-family:'JetBrains Mono',monospace; }
        .w-full { width:100%; }
        .truncate { white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }

        /* ════════════════════════════════════════════
           TOAST SYSTEM
        ═════════════════════════════════════════ */
        #toast-container {
            position:fixed; top:20px; right:20px;
            display:flex; flex-direction:column; gap:10px;
            z-index:9999; pointer-events:none;
        }
        .toast {
            display:flex; align-items:center; gap:12px;
            padding:14px 18px; border-radius:var(--radius);
            background:var(--surface); box-shadow:var(--shadow-lg);
            border:1px solid var(--border);
            font-size:13.5px; font-weight:600; color:var(--text-primary);
            min-width:280px; max-width:380px;
            pointer-events:all;
            transform:translateX(110%);
            transition:transform .35s cubic-bezier(.34,1.56,.64,1), opacity .3s;
            opacity:0;
        }
        .toast.show { transform:translateX(0); opacity:1; }
        .toast-icon { width:32px; height:32px; border-radius:8px; display:grid; place-items:center; flex-shrink:0; font-size:14px; }
        .toast-success .toast-icon { background:#d1fae5; color:#059669; }
        .toast-error   .toast-icon { background:#fee2e2; color:#dc2626; }
        .toast-warning .toast-icon { background:#fef3c7; color:#d97706; }
        .toast-info    .toast-icon { background:var(--denim-100); color:var(--denim-600); }

        /* ════════════════════════════════════════════
           DELETE MODAL
        ═════════════════════════════════════════ */
        .modal-overlay {
            position:fixed; inset:0;
            background:rgba(0,0,0,.45);
            backdrop-filter:blur(4px);
            display:grid; place-items:center;
            z-index:9000;
            opacity:0; pointer-events:none;
            transition:opacity .25s;
        }
        .modal-overlay.show { opacity:1; pointer-events:all; }
        .modal-box {
            background:var(--surface); border-radius:var(--radius);
            box-shadow:var(--shadow-lg); border:1px solid var(--border);
            padding:32px; width:100%; max-width:400px; margin:20px;
            transform:scale(.92) translateY(8px);
            transition:transform .3s cubic-bezier(.34,1.56,.64,1);
            text-align:center;
        }
        .modal-overlay.show .modal-box { transform:scale(1) translateY(0); }
        .modal-delete-icon {
            width:64px; height:64px; border-radius:50%;
            background:#fee2e2; display:grid; place-items:center;
            font-size:26px; color:#dc2626; margin:0 auto 20px;
        }
        .modal-box h3 { font-size:17px; font-weight:800; color:var(--text-primary); margin-bottom:8px; }
        .modal-box p  { font-size:13.5px; color:var(--text-secondary); line-height:1.6; margin-bottom:24px; }
        .modal-actions { display:flex; gap:10px; justify-content:center; }
    </style>
    @stack('styles')
</head>
<body>

<!-- ══ TOAST CONTAINER ══════════════════════════════════ -->
<div id="toast-container"></div>

<!-- ══ DELETE MODAL ═════════════════════════════════════ -->
<div id="delete-modal" class="modal-overlay" onclick="if(event.target===this)closeDeleteModal()">
    <div class="modal-box">
        <div class="modal-delete-icon"><i class="fa-solid fa-trash-can"></i></div>
        <h3>Hapus Data?</h3>
        <p id="modal-message">Tindakan ini tidak dapat dibatalkan.</p>
        <div class="modal-actions">
            <button class="btn btn-secondary" onclick="closeDeleteModal()">
                <i class="fa-solid fa-xmark"></i> Batal
            </button>
            <button class="btn btn-danger" onclick="submitDelete()">
                <i class="fa-solid fa-trash-can"></i> Ya, Hapus
            </button>
        </div>
    </div>
</div>

<!-- ══ SIDEBAR ══════════════════════════════════════════ -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="fa-solid fa-graduation-cap"></i></div>
        <div class="brand-text">
            <strong>SiMawa</strong>
            <span>Sistem Informasi Mahasiswa</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <p class="nav-section-label">Menu Utama</p>

        <a href="{{ route('dashboard') }}"
           class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high"></i> Dashboard
        </a>

        <a href="{{ route('mahasiswa.index') }}"
           class="nav-item {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i> Data Mahasiswa
        </a>

        <p class="nav-section-label">Master Data</p>

        <a href="{{ route('prodi.index') }}"
           class="nav-item {{ request()->routeIs('prodi.*') ? 'active' : '' }}">
            <i class="fa-solid fa-building-columns"></i> Program Studi
        </a>

        <p class="nav-section-label">Lainnya</p>

        <a href="{{ route('about') }}"
           class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
            <i class="fa-solid fa-circle-info"></i> About
        </a>
    </nav>

    <div class="sidebar-footer">
        <p>SiMawa &copy; {{ date('Y') }} · Laravel 12</p>
    </div>
</aside>

<!-- ══ MAIN ══════════════════════════════════════════════ -->
<div class="main-wrapper">

    <header class="topbar">
        <div class="topbar-left">
            <h1>@yield('title', 'Dashboard')</h1>
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Home</a>
                @yield('breadcrumb')
            </div>
        </div>
        <div class="topbar-right">
            <button class="theme-toggle" onclick="toggleTheme()" title="Toggle Dark Mode" id="theme-btn">
                <i class="fa-solid fa-moon" id="theme-icon"></i>
            </button>
            <div class="avatar">A</div>
        </div>
    </header>

    <main class="content">
        @yield('content')
    </main>
</div>

<!-- ══ SCRIPTS ═══════════════════════════════════════════ -->
<script>
/* ── DARK MODE ─────────────────────────────────────── */
(function () {
    const saved = localStorage.getItem('simawa-theme') || 'light';
    setTheme(saved, false);
})();

function setTheme(theme, animate) {
    document.documentElement.setAttribute('data-theme', theme);
    const icon = document.getElementById('theme-icon');
    if (icon) {
        icon.className = theme === 'dark' ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
    }
    if (animate !== false) localStorage.setItem('simawa-theme', theme);
}

function toggleTheme() {
    const current = document.documentElement.getAttribute('data-theme');
    setTheme(current === 'dark' ? 'light' : 'dark');
}

/* ── TOAST ─────────────────────────────────────────── */
function showToast(message, type = 'success') {
    const icons = {
        success: 'fa-circle-check',
        error:   'fa-triangle-exclamation',
        warning: 'fa-circle-exclamation',
        info:    'fa-circle-info',
    };
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <div class="toast-icon"><i class="fa-solid ${icons[type] || icons.info}"></i></div>
        <span>${message}</span>`;
    document.getElementById('toast-container').appendChild(toast);
    requestAnimationFrame(() => { requestAnimationFrame(() => toast.classList.add('show')); });
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 350);
    }, 4000);
}

/* ── SHOW SESSION TOASTS ───────────────────────────── */
@if(session('success'))
    document.addEventListener('DOMContentLoaded', () =>
        showToast(@json(session('success')), 'success'));
@endif
@if(session('error'))
    document.addEventListener('DOMContentLoaded', () =>
        showToast(@json(session('error')), 'error'));
@endif

/* ── DELETE MODAL ──────────────────────────────────── */
let _deleteForm = null;

function confirmDelete(formId, name) {
    _deleteForm = document.getElementById(formId);
    document.getElementById('modal-message').innerHTML =
        `Anda akan menghapus data <strong>${name}</strong>.<br>Tindakan ini tidak dapat dibatalkan.`;
    document.getElementById('delete-modal').classList.add('show');
}

function closeDeleteModal() {
    document.getElementById('delete-modal').classList.remove('show');
    _deleteForm = null;
}

function submitDelete() {
    if (_deleteForm) _deleteForm.submit();
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeDeleteModal();
});
</script>

@stack('scripts')
</body>
</html>
