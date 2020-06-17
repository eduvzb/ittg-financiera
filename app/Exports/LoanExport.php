<?php

namespace App\Exports;

use App\Models\Loan;
use App\Models\Client;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LoanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {   
         $loan = Loan::with('client')
            ->orderBy('id')
            ->get();
            
         return $loan;
    }

    public function map($loan): array
    {
        return [
            $loan->id,
            $loan->client->name,
            $loan->amount,
            $loan->fee,
            $loan->payments_number,
            $loan->pagos_completados,
            $loan->saldo_abonado,
            $loan->saldo_pendiente,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Nombre',
            'Cantidad',
            'Cuota',
            'Número de pagos',
            'Pagos completados',
            'Saldo abonado',
            'Saldo pendiente',
        ];
    }
}
