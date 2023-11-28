<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\abonos;
use App\Models\Sale;

class AbonosV extends Component
{
    
    use WithPagination;

    public $name, $search, $image, $selected_id, $pageTitle, $componentName, $save, $invoice, $abono, $id_sale, $abonado;
    public $pagination = 3;

    public function mount()
    {
        
        $this->componentName = 'Abonos';
        $this->pageTitle = 'Listado';
        
    }
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }



    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = abonos::where('numero_recibo', 'like', '%'. $this->search. '%')->paginate($this->pagination);
        }
        else {
            $data = abonos::orderBy('id', 'desc')->paginate($this->pagination);
        }

        if (strlen($this->invoice) > 2) {
            $this->save = Sale::where('invoice', 'like', '%'. $this->invoice. '%')->where('status','=','PENDING')->first();
            if ($this->save) {
                $this->abonado = abonos::where('sale_id', '=', $this->save->id)
                    ->latest()->first();
            }
            
           
        }
        else{
            $this->save = null;
            $this->abonado = null;
        }
        return view('livewire.abonos.abonos', ['data' => $data])
        ->extends('layouts.theme.app')
        ->section('content'); 

        
    }

    public function Store() {
        $rules = [
            'abono' => 'required'
        ];
        $messages = [
            'abono.required' => 'Colocar el Abono',
        ];

        $this->validate($rules, $messages);
    

        
        if (Sale::find($this->save->id)) {
            $sale = Sale::find($this->save->id);
        } else {
            $this->emit('category-delete', 'Venta No Encontrada');
        }

        //validacion de abonos anteriores
        $valid = abonos::where('sale_id', '=', $this->save->id)
                    ->latest()->first();
                   
        if ($valid) {

            

            if ($valid->saldo+$this->abono >= $sale->total) {
                $tipo = 'PAGADO';
               
                $sale->update([
                    'status' => 'PAID',
                    
                ]);
            } 
            else {
                $tipo = 'CREDITO';
                
            }

            $abono = abonos::create([
                'numero_recibo' => $sale->invoice,
                'tipo_pago' => $tipo,
                'monto_abono' => $this->abono,
                'saldo' => $valid->saldo+$this->abono,
                'sale_id' => $sale->id,
                'user_id' => Auth()->user()->id,
            ]);
            

        } else {
            if ($this->abono >= $sale->total) {
                $tipo = 'PAGADO';
               
                $sale->update([
                    'status' => 'PAID',
                    
                ]);
            }
            else{
                $tipo = 'CREDITO';
            }
            $abono = abonos::create([
                'numero_recibo' => $sale->invoice,
                'tipo_pago' => $tipo,
                'monto_abono' => $this->abono,
                'saldo' => $this->abono,
                'sale_id' => $sale->id,
                'user_id' => Auth()->user()->id,
            ]);
        }

        $this->resetIU();
        $this->emit('category-update', 'Abono agregado');
        
        
        
    }

    
    public function resetIU()
    {
        $this->save = null;
        $this->invoice = '';
        $this->abono = '';
        $this->search = '';
        $this->selected_id = 0;
    }
}
