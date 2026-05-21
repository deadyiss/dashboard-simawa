@extends('layouts.app')

@section('title', 'Edit Mahasiswa')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right" style="font-size:9px"></i>
    <a href="{{ route('mahasiswa.index') }}">Mahasiswa</a>
    <i class="fa-solid fa-chevron-right" style="font-size:9px"></i>
    <span>Edit</span>
@endsection

@section('content')
<div style="max-width:760px">
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="card-title">
                    <i class="fa-solid fa-user-pen" style="color:var(--denim-500);margin-right:8px"></i>
                    Edit Data Mahasiswa
                </h2>
                <p class="text-sm text-muted mt-1">
                    <strong>{{ $mahasiswa->nama_lengkap }}</strong>
                    <span class="badge badge-blue font-mono" style="margin-left:6px">{{ $mahasiswa->npm }}</span>
                    <span class="badge badge-{{ $mahasiswa->status_color }}" style="margin-left:4px">{{ $mahasiswa->status_label }}</span>
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('mahasiswa.show', $mahasiswa) }}" class="btn btn-secondary btn-sm">
                    <i class="fa-solid fa-eye"></i>
                </a>
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('mahasiswa.update', $mahasiswa) }}" method="POST">
                @csrf
                @method('PUT')

                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--denim-600);margin-bottom:16px;padding-bottom:8px;border-bottom:1px solid var(--border)">
                    <i class="fa-solid fa-id-card" style="margin-right:6px"></i>Identitas Mahasiswa
                </p>

                <div class="grid grid-2">
                    <div class="form-group">
                        <label for="npm" class="form-label">NPM <span class="req">*</span></label>
                        <input type="text" id="npm" name="npm"
                               class="form-control font-mono @error('npm') is-invalid @enderror"
                               value="{{ old('npm', $mahasiswa->npm) }}" maxlength="20">
                        @error('npm')<p class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label for="angkatan" class="form-label">Angkatan</label>
                        <input type="number" id="angkatan" name="angkatan"
                               class="form-control font-mono @error('angkatan') is-invalid @enderror"
                               value="{{ old('angkatan', $mahasiswa->angkatan) }}"
                               min="2000" max="{{ date('Y') }}">
                        @error('angkatan')<p class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="req">*</span></label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap"
                           class="form-control @error('nama_lengkap') is-invalid @enderror"
                           value="{{ old('nama_lengkap', $mahasiswa->nama_lengkap) }}" maxlength="100">
                    @error('nama_lengkap')<p class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>@enderror
                </div>

                <div class="grid grid-2">
                    <div class="form-group">
                        <label for="prodi_id" class="form-label">Program Studi</label>
                        <select id="prodi_id" name="prodi_id"
                                class="form-control @error('prodi_id') is-invalid @enderror">
                            <option value="">— Pilih Program Studi —</option>
                            @foreach($prodis->groupBy('jenjang') as $jenjang => $list)
                                <optgroup label="Jenjang {{ $jenjang }}">
                                    @foreach($list as $p)
                                        <option value="{{ $p->id }}"
                                            {{ old('prodi_id', $mahasiswa->prodi_id) == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('prodi_id')<p class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">Status <span class="req">*</span></label>
                        <select id="status" name="status"
                                class="form-control @error('status') is-invalid @enderror">
                            @foreach(\App\Models\Mahasiswa::statusList() as $key => $def)
                                <option value="{{ $key }}" {{ old('status', $mahasiswa->status) === $key ? 'selected' : '' }}>
                                    {{ $def['label'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')<p class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>@enderror
                    </div>
                </div>

                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--denim-600);margin:8px 0 16px;padding-bottom:8px;border-bottom:1px solid var(--border)">
                    <i class="fa-solid fa-address-book" style="margin-right:6px"></i>Informasi Kontak
                </p>

                <div class="grid grid-2">
                    <div class="form-group">
                        <label for="email" class="form-label">Email <span class="req">*</span></label>
                        <input type="email" id="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $mahasiswa->email) }}">
                        @error('email')<p class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label for="telepon" class="form-label">Telepon <span class="req">*</span></label>
                        <input type="text" id="telepon" name="telepon"
                               class="form-control font-mono @error('telepon') is-invalid @enderror"
                               value="{{ old('telepon', $mahasiswa->telepon) }}" maxlength="20">
                        @error('telepon')<p class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamat" class="form-label">Alamat <span class="req">*</span></label>
                    <textarea id="alamat" name="alamat" rows="3"
                              class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $mahasiswa->alamat) }}</textarea>
                    @error('alamat')<p class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>@enderror
                </div>

                <div class="flex items-center gap-3" style="margin-top:8px">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Perbarui Data
                    </button>
                    <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
