<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use App\Models\User;
use DB;

class Assigner extends Component
{
    use WithPagination;

    public $role, $pageTitle, $componentName, $permissions_new=[], $permissions_old=[];
    public $pagination = 3;

    public function mount()
    {
        
        $this->componentName = 'Asignar Permisos';
        $this->role = 'Elegir';
        
    }
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        $permisos = Permission::select('name', 'id', DB::raw("0 as checked"))
        ->orderBy('name', 'asc')
        ->paginate($this->pagination);

        if ($this->role != 'Elegir') {
           $list = Permission::join('role_has_permissions as rp', 'rp.permission_id', 'permissions.id')
           ->where('role_id', $this->role)->pluck('permissions.id')->toArray();
           $this->permissions_old = $list;
        }

        if($this->role != 'Elegir'){
           
            foreach ($permisos as $permiso) {
                $role = Role::find($this->role);
                $thenpermiso = $role->hasPermissionTo($permiso->name);
                if ($thenpermiso){
                    $permiso->checked = 1;
                }
            }
        }

        



        return view('livewire.assign.assign', ['roles' => Role::orderBy('name', 'asc')->get(),
        'permissions' => $permisos])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    


    protected $listeners = [
        'revokeall' => 'RemoveAll'
    ];


    public function RemoveAll()
    {
        if($this->role == 'Elegir'){
            $this->emit('sync-error', 'Selecciona un Rol Valido');
            return;
        }
        $role = Role::find($this->role);
        $role->syncPermissions([0]);
        $this->emit('remove-all', "Se revocaron todos los permisos al role $role->name");
    }

    public function SyncAll()
    {
        if($this->role == 'Elegir'){
            $this->emit('sync-error', 'Selecciona un Rol Valido');
            return;
        }
        $role = Role::find($this->role);
        $permisos = Permission::pluck('id')->toArray();
        $role->syncPermissions($permisos);
        $this->emit('permi', "Se otorgaron todos los permisos al role $role->name");
    }

    public function SyncPermiso($state, $permisionName)
    {
        if($this->role != 'Elegir'){
            $roleName = Role::find($this->role);
            if($state){
                $roleName->givePermissionTo($permisionName);
                $this->emit('permi', "Permiso Asignado Correctamente");

            }
            else{
                $roleName->revokePermissionTo($permisionName);
                $this->emit('permi', "Permiso rovacado correctamente");

            }
        }
        else{
            $this->emit('permi', "Elige un rol valido");
        }
    }

    
}
