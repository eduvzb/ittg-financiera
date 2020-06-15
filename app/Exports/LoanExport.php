<?php

namespace App\Exports;

use App\Models\Loan;
use App\Models\Client;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class LoanExport implements FromView
{
    use Exportable;
    
    public function view():View
    {
        $loans = Loan::with('Client')->get();
        return view('loans.exports',[
            'loans' => $loans
        ]);
    }
}
