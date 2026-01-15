<?php
namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TicketsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $start_date, $end_date;

    public function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function query()
    {
        return Ticket::with(['customer', 'category'])
            ->whereBetween('waktu_mulai', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59']);
    }

    public function headings(): array
    {
        return ['No Tiket', 'Pelanggan', 'Kategori', 'Status', 'Waktu Mulai', 'Waktu Selesai', 'Durasi (Menit)'];
    }

    public function map($ticket): array
    {
        $durasi = $ticket->waktu_selesai ? $ticket->waktu_mulai->diffInMinutes($ticket->waktu_selesai) : '-';
        return [
            $ticket->ticket_number,
            $ticket->customer->nama_pelanggan,
            $ticket->category->nama_kategori,
            $ticket->status,
            $ticket->waktu_mulai,
            $ticket->waktu_selesai,
            $durasi
        ];
    }
}