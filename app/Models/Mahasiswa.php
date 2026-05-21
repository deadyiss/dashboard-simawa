<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'prodi_id',
        'npm',
        'nama_lengkap',
        'alamat',
        'email',
        'telepon',
        'status',
        'angkatan',
    ];

    protected $casts = [
        'angkatan' => 'integer',
    ];

    /* ── Relations ─────────────────────────────── */

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    /* ── Helpers ───────────────────────────────── */

    public static function statusList(): array
    {
        return [
            'aktif'   => ['label' => 'Aktif',   'color' => 'green'],
            'cuti'    => ['label' => 'Cuti',    'color' => 'amber'],
            'lulus'   => ['label' => 'Lulus',   'color' => 'blue'],
            'dropout' => ['label' => 'Dropout', 'color' => 'red'],
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statusList()[$this->status]['label'] ?? ucfirst($this->status);
    }

    public function getStatusColorAttribute(): string
    {
        return self::statusList()[$this->status]['color'] ?? 'gray';
    }

    /* ── Scopes ────────────────────────────────── */

    public function scopeSearch($query, ?string $search)
    {
        return $query->when($search, fn($q) =>
            $q->where('npm', 'like', "%{$search}%")
              ->orWhere('nama_lengkap', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
        );
    }

    public function scopeFilterProdi($query, ?string $prodi)
    {
        return $query->when($prodi, fn($q) => $q->where('prodi_id', $prodi));
    }

    public function scopeFilterStatus($query, ?string $status)
    {
        return $query->when($status, fn($q) => $q->where('status', $status));
    }

    public function scopeFilterAngkatan($query, ?string $angkatan)
    {
        return $query->when($angkatan, fn($q) => $q->where('angkatan', $angkatan));
    }
}
