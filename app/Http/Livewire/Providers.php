<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Provider;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Providers extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $search, $selected_id, $pageTitle, $componentName, $nit,
    $contact,
    $phone,
    $email,
    $address, $pagination;
    

    public function mount()
    {
        
        $this->componentName = 'Proveedores';
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
            $data = Provider::where('name', 'like', '%'. $this->search. '%')->paginate($this->pagination);
        }
        else {
            $data = Provider::orderBy('id', 'desc')->paginate($this->pagination);
        }
        
        return view('livewire.providers.providers', ['providers' => $data])
        ->extends('layouts.theme.app')
        ->section('content'); 

        
    }

    public function Edit($id)
    {
        $record = Provider::find($id);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->nit = $record->nit;
        $this->contact = $record->contact;
        $this->phone = $record->phone;
        $this->email = $record->email;
        $this->address = $record->address;

        $this->emit('show-modal', 'show modal');

    }

    public function Store()
    {
        $rules = [
            'name' => 'required|unique:providers|min:3',
            'nit' => 'required|min:14',
            'contact' => 'required:min:5',
            'phone' => 'nullable|min:8',
            'email' => 'nullable|email',
            'address' => 'nullable|min:8',
        ];
        $messages = [
            'name.required' => 'Escribir el nombre',
            'name.unique' => 'Este proveedor existe',
            'name.min' => 'Debe tener minimo 3 caracteres',
            'nit.required' => 'Escribir el NIT',
            'nit.min' => 'Debe ingresar un NIT invalido',
            'contact.required' => 'Es necesario el nombre del contacto',
            'contact.min' => 'Debe ingresar un nombre de 5 caracteres',
            'phone.min' => 'Debe ingresar un telefono de 8 caracteres',
            'email.email' => 'Debe ingresar un correo valido',
            'address.min' => 'Debe ingresar una direccion de 8 caracteres',

        ];

        $this->validate($rules, $messages);

        $provider = Provider::create([
            'name' => $this->name,
            'nit' => $this->nit,
            'contact' => $this->contact,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
        ]);

        

        $this->resetIU();
        $this->emit('provider-add', 'Proveedor regsitrado');
    }

    public function Update()
    {
        $rules = [
            'name' => "required|unique:providers,name,{$this->selected_id}|min:3",
            'nit' => 'required|min:14',
            'contact' => 'required:min:5',
            'phone' => 'nullable|min:8',
            'email' => 'nullable|email',
            'address' => 'nullable|min:8',
        ];
        $messages = [
            'name.required' => 'Escribir el nombre',
            'name.unique' => 'Esta categoria existe',
            'name.min' => 'Debe tener minimo 3 caracteres',
            'nit.required' => 'Escribir el NIT',
            'nit.min' => 'Debe ingresar un NIT valido',
            'contact.required' => 'Es necesario el nombre del contacto',
            'contact.min' => 'Debe ingresar un nombre de 5 caracteres',
            'phone.min' => 'Debe ingresar un telefono de 8 caracteres',
            'email.email' => 'Debe ingresar un correo valido',
            'address.min' => 'Debe ingresar una direccion de 8 caracteres',
        ];

        $this->validate($rules, $messages);


        $provider = Provider::find($this->selected_id);
        $provider->update([
            'name' => $this->name,
            'nit' => $this->nit,
            'contact' => $this->contact,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,

        ]);

        

        $this->resetIU();
        $this->emit('provider-update', 'Proveedor actualizado');



    }

    protected $listeners = [
        'deleterow' => 'Destroy'
    ];

    public function Destroy(Provider $provider)
    {
        //$provider = Provider::find($id);

        $provider->delete();

        $this->resetIU();
        $this->emit('provider-delete', 'Proveedor Eliminado');

    }


    public function resetIU()
    {
        $this->name = '';
        $this->nit = '';
        $this->contact = '';
        $this->phone = '';
        $this->email = '';
        $this->address = '';
        $this->search = '';
        $this->selected_id = 0;
    }
}
