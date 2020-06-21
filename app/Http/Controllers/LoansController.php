<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Client;
use App\Models\Payment;
use Carbon\Carbon;

use App\Exports\LoanExport;
use Maatwebsite\Excel\Facades\Excel;

class LoansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = Loan::with('client')->orderBy('id')->get();
        return response()->json($loans);
    }

    public function exportExcel()
    {
        return Excel::download(new LoanExport, 'resumen-pagos.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $loan = new Loan();
        $loan->client_id = $request->client_id;
        $loan->amount = $request->amount;
        $loan->payments_number = $request->payments_number;
        $loan->fee = $request->fee;
        $loan->ministry_date = $request->ministry_date;
        $loan->due_date = $request->due_date;
        $loan->finished = 0;
        $loan->save();
        $date = Carbon::createFromDate($loan->ministry_date); //Guarda la fecha en la varible date
        
        $count = 0;
        while($count < $loan->payments_number)
        {
            $date->addDay(); //Incrementa un día a la fecha date
            if($date->isWeekday()) //Verificar si date es día de semana
            {
                $payment = new Payment();
                $payment->client_id = $loan->client_id;
                $payment->loan_id = $loan->id;
                $payment->number = $count+1;
                $payment->amount = $loan->fee;
                $payment->received_amount = 0;
                $payment->payment_date = $date;
                $payment->save();
                $count++;
            }
        }
        return response()->json(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $loan = Loan::with('client')->find($id);
        return response()->json($loan);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $loan = Loan::find($id);
        $saldoAbonado = $loan->saldoAbonado;
       
        if( $saldoAbonado > 0){
            return response()->json(false)
                ->withError('Error','No puede editar un prestamo que tenga pagos registrados.');
        }
        else{ //Editar el prestamo

            $loan->client_id = $request->client_id;
            $loan->amount = $request->amount;
            $loan->payments_number = $request->payments_number;
            $loan->fee = $request->fee;
            $loan->ministry_date = $request->ministry_date;
            $loan->due_date = $request->due_date;
            $loan->finished = 0;
            $loan->save();

            //Borrar payments
            Payment::where('loan_id',$id)->delete();

            $date = Carbon::createFromDate($loan->ministry_date); //Guarda la fecha en la varible date
            $count = 0;
            while($count < $loan->payments_number)
            {
                $date->addDay(); //Incrementa un día a la fecha date
                if($date->isWeekday()) //Verifica si date es día de semana
                {
                    $payment = new Payment();
                    $payment->client_id = $loan->client_id;
                    $payment->loan_id = $loan->id;
                    $payment->number = $count+1;
                    $payment->amount = $loan->fee;
                    $payment->received_amount = 0;
                    $payment->payment_date = $date;
                    $payment->save();
                    $count++;
                }
            }
            return response()->json(true);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loan = Loan::find($id);
        foreach($loan->payments as $payment)
        {
            $payment->delete();
        }
        $loan->delete();
        return response()->json(true);
    }

    public function fillSelectClient ()
    {
        $clients = Client::select('id','name')->get();
        return response()->json($clients);
    }
}
