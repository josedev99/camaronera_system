<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use App\Models\User;
use DB;

class Permissions extends Component
{
    use WithPagination;

    public $name, $search, $selected_id, $pageTitle, $componentName;
    public $pagination = 3;

    public function mount()
    {
        
        $this->componentName = 'Permisos';
        $this->pageTitle = 'Listado';
        
    }
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = Permission::where('name', 'like', '%'. $this->search. '%')->paginate($this->pagination);
        }
        else {
            $data = Permission::orderBy('id', 'desc')->paginate($this->pagination);
        }

        return view('livewire.permissions.permissions', ['permissions' => $data])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Edit($id)
    {
        $record = Permission::find($id);
        $this->name = $record->name;
        $this->selected_id = $record->id;

        $this->emit('show-modal', 'show modal');

    }

    public function Store()
    {
        $rules = [
            'name' => 'required|unique:permissions|min:3'
        ];
        $messages = [
            'name.required' => 'Escribir el nombre',
            'name.unique' => 'Este Permiso existe',
            'name.min' => 'Debe tener minimo 3 caracteres',
        ];

        $this->validate($rules, $messages);

        $permission = Permission::create([
            'name' => $this->name,
            
        ]);

        $permission->save();

      

        $this->resetIU();
        $this->emit('permission-add', 'Permiso regsitrado');
    }

    public function Update()
    {
        $rules = [
            'name' => "required|unique:permissions,name,{$this->selected_id}|min:3"
        ];
        $messages = [
            'name.required' => 'Escribir el nombre',
            'name.unique' => 'Este Permiso existe',
            'name.min' => 'Debe tener minimo 3 caracteres',
        ];

        $this->validate($rules, $messages);


        $permission = Permission::find($this->selected_id);
        $permission->update([
            'name' => $this->name,

        ]);


        $this->resetIU();
        $this->emit('permission-update', 'Permiso actualizado');



    }

    protected $listeners = [
        'deleterow' => 'Destroy'
    ];

    public function Destroy($id)
    {
        //$permission = Permission::find($id);

        $permission = Permission::find($id)->getRoleNames()->count();
        if($permission > 0){
            $this->emit('permission-error', 'No se puede eliminar el permiso tiene permisos asociados');
            return;
        }


        Permission::find($id)->delete();
        $this->resetIU();
        $this->emit('permission-delete', 'Permiso Eliminado');

    }


    public function resetIU()
    {
        $this->name = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
