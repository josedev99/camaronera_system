<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Customer;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Customers extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $search, $selected_id, $pageTitle, $componentName, $nit,
    $phone,
    $email,
    $address, $pagination;
    

    public function mount()
    {
        
        $this->componentName = 'Clientes';
        $this->pageTitle = 'Listado';
        $this->pagination = 2;
        
    }
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }



    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = Customer::where('name', 'like', '%'. $this->search. '%')->paginate($this->pagination);
        }
        else {
            $data = Customer::orderBy('id', 'desc')->paginate($this->pagination);
        }
        
        return view('livewire.customers.customers', ['customers' => $data])
        ->extends('layouts.theme.app')
        ->section('content'); 

        
    }

    public function Edit($id)
    {
        $record = Customer::find($id);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->nit = $record->nit;
        $this->phone = $record->phone;
        $this->email = $record->email;
        $this->address = $record->address;

        $this->emit('show-modal', 'show modal');

    }

    public function Store()
    {
        $rules = [
            'name' => 'required|min:3',
            'nit' => 'required|unique:customers|min:9',
            'phone' => 'nullable|min:8',
            'email' => 'nullable|email',
            'address' => 'nullable|min:8',
        ];
        $messages = [
            'name.required' => 'Escribir el nombre',
            'nit.unique' => 'Este cliente existe',
            'name.min' => 'Debe tener minimo 3 caracteres',
            'nit.required' => 'Escribir el DUI',
            'nit.min' => 'Debe ingresar un DUI invalido',
            'phone.min' => 'Debe ingresar un telefono de 8 caracteres',
            'email.email' => 'Debe ingresar un correo valido',
            'address.min' => 'Debe ingresar una direccion de 8 caracteres',

        ];

        $this->validate($rules, $messages);

        $customer = Customer::create([
            'name' => $this->name,
            'nit' => $this->nit,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
        ]);

        

        $this->resetIU();
        $this->emit('customer-add', 'Proveedor regsitrado');
    }

    public function Update()
    {
        $rules = [
            'name' => "required|min:3",
            'nit' => "required|unique:customers,nit,{$this->selected_id}|min:9",
            'phone' => 'nullable|min:8',
            'email' => 'nullable|email',
            'address' => 'nullable|min:8',
        ];
        $messages = [
            'name.required' => 'Escribir el nombre',
            'nit.unique' => 'Este cliente existe',
            'name.min' => 'Debe tener minimo 3 caracteres',
            'nit.required' => 'Escribir el DUI',
            'nit.min' => 'Debe ingresar un DUI invalido',
            'phone.min' => 'Debe ingresar un telefono de 8 caracteres',
            'email.email' => 'Debe ingresar un correo valido',
            'address.min' => 'Debe ingresar una direccion de 8 caracteres',
        ];

        $this->validate($rules, $messages);


        $customer = Customer::find($this->selected_id);
        $customer->update([
            'name' => $this->name,
            'nit' => $this->nit,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,

        ]);

        

        $this->resetIU();
        $this->emit('customer-update', 'Proveedor actualizado');



    }

    protected $listeners = [
        'deleterow' => 'Destroy'
    ];

    public function Destroy(Customer $customer)
    {
        //$customer = Customer::find($id);

        $customer->delete();

        $this->resetIU();
        $this->emit('customer-delete', 'Proveedor Eliminado');

    }


    public function resetIU()
    {
        $this->name = '';
        $this->nit = '';
        $this->phone = '';
        $this->email = '';
        $this->address = '';
        $this->search = '';
        $this->selected_id = 0;
    }
}
