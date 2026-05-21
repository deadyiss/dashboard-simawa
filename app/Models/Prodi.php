<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $fillable = ['kode', 'nama', 'jenjang'];

    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class);
    }

    public function getLabelAttribute(): string
    {
        return "[{$this->jenjang}] {$this->nama}";
    }
}
