<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TicketsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query; // Menggunakan query yang sudah difilter dari Controller
    }

    public function headings(): array
    {
        return ["No. Tiket", "Pelanggan", "Kategori", "Status", "Prioritas", "Penginput", "Waktu Lapor"];
    }

    public function map($ticket): array
    {
        return [
            $ticket->ticket_number,
            $ticket->customer->nama_pelanggan,
            $ticket->category->nama_kategori,
            $ticket->status,
            $ticket->priority,
            $ticket->user->name, // Menampilkan siapa yang input
            $ticket->waktu_mulai->format('d/m/Y H:i'),
        ];
    }
}