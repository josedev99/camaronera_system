<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use App\Models\User;
use DB;

class Roles extends Component
{
    use WithPagination;

    public $name, $search, $selected_id, $pageTitle, $componentName;
    public $pagination = 3;

    public function mount()
    {
        
        $this->componentName = 'Roles';
        $this->pageTitle = 'Listado';
        
    }
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = Role::where('name', 'like', '%'. $this->search. '%')->paginate($this->pagination);
        }
        else {
            $data = Role::orderBy('id', 'desc')->paginate($this->pagination);
        }

        return view('livewire.roles.roles', ['roles' => $data])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Edit($id)
    {
        $record = Role::find($id);
        $this->name = $record->name;
        $this->selected_id = $record->id;

        $this->emit('show-modal', 'show modal');

    }

    public function Store()
    {
        $rules = [
            'name' => 'required|unique:roles|min:3'
        ];
        $messages = [
            'name.required' => 'Escribir el nombre',
            'name.unique' => 'Este rol existe',
            'name.min' => 'Debe tener minimo 3 caracteres',
        ];

        $this->validate($rules, $messages);

        $role = Role::create([
            'name' => $this->name,
            
        ]);

        $role->save();

      

        $this->resetIU();
        $this->emit('role-add', 'Rol regsitrada');
    }

    public function Update()
    {
        $rules = [
            'name' => "required|unique:roles,name,{$this->selected_id}|min:3"
        ];
        $messages = [
            'name.required' => 'Escribir el nombre',
            'name.unique' => 'Este rol existe',
            'name.min' => 'Debe tener minimo 3 caracteres',
        ];

        $this->validate($rules, $messages);


        $role = Role::find($this->selected_id);
        $role->update([
            'name' => $this->name,

        ]);


        $this->resetIU();
        $this->emit('role-update', 'Rol actualizado');



    }

    protected $listeners = [
        'deleterow' => 'Destroy'
    ];

    public function Destroy($id)
    {
        //$role = Role::find($id);

        $permission = Role::find($id)->permissions->count();
        if($permission > 0){
            $this->emit('role-error', 'No se puede eliminar el role tiene permisos asociados');
            return;
        }


        Role::find($id)->delete();
        $this->resetIU();
        $this->emit('role-delete', 'Rol Eliminado');

    }


    public function resetIU()
    {
        $this->name = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }


}
