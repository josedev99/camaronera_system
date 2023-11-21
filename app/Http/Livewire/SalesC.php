<?php

namespace App\Http\Livewire;

use App\Models\abonos;
use App\Models\Sale;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Exception;
use DB;

class SalesC extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $search, $image, $selected_id, $pageTitle, 
    $componentName, $total, $customer, $pay, $type_invoice, $invoice, $items, $pond, $grams, $show;
    public $pagination = 3;

    public function mount()
    {

        $this->componentName = 'Ventas';
        $this->pay = 'Elegir';
        $this->pond = 'Elegir';
        $this->type_invoice = 'Elegir';
        $this->pageTitle = 'Listado';
    }
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {

        if (strlen($this->search) > 0) {
            $data = Sale::where('invoice', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        } else {
            $data = Sale::orderBy('id', 'desc')->paginate($this->pagination);
        }

        return view('livewire.ventas.ventas', ['data' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Edit($id)
    {
        $record = Sale::find($id);
        $this->invoice = $record->invoice;
        $this->type_invoice = $record->type_invoice;
        $this->customer = $record->customer;
        $this->total = $record->total;
        $this->items = $record->items;
        $this->pond = $record->pond;
        $this->grams = $record->grams;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->emit('show-modal', 'show modal');
    }

    public function Store()
    {
        $rules = [
            'invoice' => 'required|min:4',
            'type_invoice' => 'required|not_in:Elegir',
            'customer' => 'required|min:4',
            'total' => 'required',
            'items' => 'required',
            'pond' => 'required|not_in:Elegir',
            'grams' => 'required',
            'pay' => 'required|not_in:Elegir',

        ];
        $messages = [
            'name.required' => 'Escribir el nombre',
            'name.unique' => 'Esta categoria existe',
            'name.min' => 'Debe tener minimo 3 caracteres',
        ];

        $this->validate($rules, $messages);
       

        

        
            $sale = Sale::create([
                'invoice' => $this->invoice,
                'type_invoice' => $this->type_invoice,
                'customer' => $this->customer,
                'total' => $this->total,
                'iva' => $this->total*0.13,
                'items' => $this->items,
                'grams' => $this->grams,
                'pond' => $this->pond,
                'pay' => $this->pay,
                'status' => ($this->pay == 'CREDITO') ? 'PENDING' : 'PAID',
                'user_id' => Auth()->user()->id,
    
    
            ]);
    
            $custom_filename;
            if ($this->image) {
                $custom_filename = uniqid() . '_.' . $this->image->extension();
                $this->image->storeAs('public/invoices', $custom_filename);
                $sale->image = $custom_filename;
                $sale->save();
            }

           

          

        $this->resetIU();
        $this->emit('category-add', 'Venta Registrada');
    }

    public function Show($id) {
        $this->show = Sale::find($id);
        $this->emit('show-modal', 'show modal');
    }

    public function Update()
    {
        $rules = [
            'invoice' => 'required|min:4',
            'type_invoice' => 'required|not_in:Elegir',
            'customer' => 'required|min:4',
            'total' => 'required',
            'items' => 'required',
            'pond' => 'required|not_in:Elegir',
            'grams' => 'required',
        ];
        $messages = [
            
        ];

        $this->validate($rules, $messages);


        $sale = Sale::find($this->selected_id);
        $sale->update([
            'invoice' => $this->invoice,
            'type_invoice' => $this->type_invoice,
            'customer' => $this->customer,
            'total' => $this->total,
            'iva' => $this->total*0.13,
            'invoice' => $this->invoice,
            'items' => $this->items,
            'grams' => $this->grams,
            'pond' => $this->pond,
            'user_id' => Auth()->user()->id,

        ]);

        if ($this->image) {
            $custom_filename = uniqid() . '_.' . $this->image->extension();

            $this->image->storeAs('public/invoices', $custom_filename);
            $imagenold = $sale->image;
            $sale->image = $custom_filename;
            $sale->save();
            
            

            if ($imagenold == "noimg.png") {
                $imagenold = null;
            }

            if ($imagenold != null) {
                if (file_exists('storage/invoices/' . $imagenold)) {
                    unlink('storage/invoices/' . $imagenold);
                }
            }
        }

        $this->resetIU();
        $this->emit('category-update', 'Venta actualizada');
    }

    protected $listeners = [
        'deleterow' => 'Destroy'
    ];

    public function Destroy(Sale $sale)
    {
        //$sale = Sale::find($id);

        $imagenold = $sale->image;
        //para evitar borrar noimg
        if ($imagenold == "noimg.png") {
            $imagenold = null;
        }
        $sale->delete();

        if ($imagenold != null) {
            if (file_exists('storage/invoices/' . $imagenold)) {
                unlink('storage/invoices/' . $imagenold);
            }
        }

        $this->resetIU();
        $this->emit('category-delete', 'Venta Eliminada');
    }


    public function resetIU()
    {
        $this->invoice = '';
        $this->type_invoice = 'Elegir';
        $this->customer = '';
        $this->total = '';
        $this->items = '';
        $this->pond = 'Elegir';
        $this->grams = '';
        $this->pay = 'Elegir';

        $this->image = null;
        $this->search = '';
        $this->show = null;
        $this->selected_id = 0;
    }
}
