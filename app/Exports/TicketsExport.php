<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TicketsExport implements FromQuery, WithHeadings, WithMapping, WithEvents
{
    protected $query;
    protected $startDate;
    protected $endDate;

    public function __construct($query, $startDate = null, $endDate = null)
    {
        $this->query = $query;
        // Jika filter kosong, ambil tanggal dari data tiket pertama dan terakhir
        $this->startDate = $startDate ?? \App\Models\Ticket::min('waktu_mulai');
        $this->endDate = $endDate ?? \App\Models\Ticket::max('waktu_mulai');
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        // jarak baris untuk judul periode di atas
        return [
            ["LAPORAN GANGGUAN TIKET"],
            ["Periode: " . \Carbon\Carbon::parse($this->startDate)->format('d/m/Y') . " s/d " . \Carbon\Carbon::parse($this->endDate)->format('d/m/Y')],
            [],
            ["No. Tiket", "Pelanggan", "Kategori", "Status", "Prioritas", "Penginput", "Waktu Lapor"]
        ];
    }

    public function map($ticket): array
    {
        return [
            $ticket->ticket_number,
            $ticket->customer->nama_pelanggan,
            $ticket->category->nama_kategori,
            $ticket->status,
            $ticket->priority,
            $ticket->user->name,
            \Carbon\Carbon::parse($ticket->waktu_mulai)->format('d/m/Y H:i'),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Merge cell untuk judul laporan agar rapi di tengah
                $event->sheet->mergeCells('A1:G1');
                $event->sheet->mergeCells('A2:G2');

                $event->sheet->getStyle('A1:A2')->getFont()->setBold(true);
                $event->sheet->getStyle('A4:G4')->getFont()->setBold(true);
                $event->sheet->getStyle('A4:G4')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('E2E8F0');
            },
        ];
    }
}