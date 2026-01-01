<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RentalReportExport implements WithMultipleSheets
{
    protected $rentals;
    protected $stats;

    public function __construct($rentals, $stats)
    {
        $this->rentals = $rentals;
        $this->stats = $stats;
    }

    public function sheets(): array
    {
        return [
            new RentalDataSheet($this->rentals),
            new RentalStatsSheet($this->stats),
        ];
    }
}

class RentalDataSheet implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $rentals;

    public function __construct($rentals)
    {
        $this->rentals = $rentals;
    }

    public function collection()
    {
        return $this->rentals;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Pelanggan',
            'Email',
            'Mobil',
            'Nomor Polisi',
            'Tanggal Sewa',
            'Tanggal Kembali',
            'Lama Sewa (Hari)',
            'Total Bayar',
            'Status',
        ];
    }

    public function map($rental): array
    {
        return [
            $rental->id,
            $rental->user->name,
            $rental->user->email,
            $rental->car->nama,
            $rental->car->nopol,
            \Carbon\Carbon::parse($rental->tanggal_sewa)->format('d/m/Y'),
            \Carbon\Carbon::parse($rental->tanggal_dikembalikan)->format('d/m/Y'),
            $rental->lama_sewa,
            'Rp ' . number_format($rental->total_bayar, 0, ',', '.'),
            ucfirst($rental->status_transaksi),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Data Rental';
    }
}

class RentalStatsSheet implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected $stats;

    public function __construct($stats)
    {
        $this->stats = $stats;
    }

    public function collection()
    {
        return collect([
            ['Total Rental', $this->stats['total_rentals']],
            ['Total Pendapatan', 'Rp ' . number_format($this->stats['total_revenue'], 0, ',', '.')],
            ['Rental Aktif', $this->stats['active_rentals']],
            ['Rental Selesai', $this->stats['completed_rentals']],
            ['Rata-rata Lama Sewa', number_format($this->stats['avg_rental_duration'], 1) . ' Hari'],
            ['Mobil Terfavorit', $this->stats['most_rented_car'] ? $this->stats['most_rented_car']->car->nama . ' (' . $this->stats['most_rented_car']->rental_count . ' kali)' : 'Tidak ada data'],
            ['Customer Terbaik', $this->stats['top_customer'] ? $this->stats['top_customer']->user->name . ' (' . $this->stats['top_customer']->rental_count . ' rental)' : 'Tidak ada data'],
        ]);
    }

    public function headings(): array
    {
        return [
            'Statistik',
            'Nilai',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Statistik';
    }
}
