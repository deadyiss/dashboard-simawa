<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class MahasiswaExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize,
    WithTitle
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection(): Collection
    {
        return Mahasiswa::with('prodi')
            ->search($this->filters['search'] ?? null)
            ->filterProdi($this->filters['prodi'] ?? null)
            ->filterStatus($this->filters['status'] ?? null)
            ->filterAngkatan($this->filters['angkatan'] ?? null)
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'NPM',
            'Nama Lengkap',
            'Program Studi',
            'Jenjang',
            'Angkatan',
            'Status',
            'Email',
            'Telepon',
            'Alamat',
            'Tanggal Daftar',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->npm,
            $row->nama_lengkap,
            $row->prodi?->nama ?? '-',
            $row->prodi?->jenjang ?? '-',
            $row->angkatan ?? '-',
            $row->status_label,
            $row->email,
            $row->telepon,
            $row->alamat,
            $row->created_at->format('d/m/Y'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF1E4694'],
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Data Mahasiswa';
    }
}
