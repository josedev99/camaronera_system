<?php

namespace App\Http\Livewire;

use App\Models\Sale;
use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Users extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $search, $image, $selected_id, $pageTitle, $componentName, $password, $phone, $profile, $status, $email;
    public $pagination = 3;

    public function mount()
    {
        
        $this->componentName = 'Usuarios';
        $this->pageTitle = 'Listado';

        $this->profile = 'EMPLOYEE';
        $this->status = 'ACTIVE';
        
    }
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = User::where('name', 'like', '%'. $this->search. '%')->paginate($this->pagination);
        }
        else {
            $data = User::orderBy('id', 'desc')->paginate($this->pagination);
        }
        
       
        return view('livewire.users.users', ['users' => $data, 'roles' => Role::orderBy('name', 'asc')->get()])
        ->extends('layouts.theme.app')
        ->section('content');
        
       
    }



    public function Edit($id)
    {
        $record = User::find($id);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->phone = $record->phone;
        $this->profile = $record->profile;
        $this->status = $record->status;
        $this->email = $record->email;
        $this->password = '';
        $this->image = null;
        $this->emit('show-modal', 'show modal');

    }

    public function Store()
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|unique:users|email',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:3'
        ];
        $messages = [
            'name.required' => 'Escribir el nombre del usuario',
            'name.min' => 'Debe tener minimo 3 caracteres',

            'email.required' => 'Escribir el correo del usuario',
            'email.unique' => 'Este correo existe',
            'email.email' => 'Esto no es un correo valido',

            'status.required' => 'Seleccionar un estado',
            'status.not_in' => 'Selecione un estado',

            'profile.required' => 'Seleccionar un rol',
            'profile.not_in' => 'Selecione un rol',

            'password.required' => 'Escribir la contraseña del usuario',
            'password.min' => 'La contraseña debe tener minimo 3 caracteres',
        ];

        $this->validate($rules, $messages);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'profile' => $this->profile,
            'status' => $this->status,
            'password' => bcrypt($this->password)
        ]);

        $user->syncRoles($this->profile);

        $custom_filename;
        if ($this->image) {
            $custom_filename = uniqid(). '_.' .$this->image->extension();
            $this->image->storeAs('public/users', $custom_filename);
            $user->image = $custom_filename;
            $user->save();
        }

        $this->resetIU();
        $this->emit('user-add', 'Usuario regsitrado');
    }

    public function Update()
    {
        $rules = [
            'name' => "required|min:3",
            'email' => "required|unique:users,email,{$this->selected_id}|email",
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:3'
        ];
        $messages = [
            'name.required' => 'Escribir el nombre de usuario',
            'name.unique' => 'Este usuario existe',
            'name.min' => 'Debe tener minimo 3 caracteres',

            'email.required' => 'Escribir el correo del usuario',
            'email.unique' => 'Este correo existe',
            'email.email' => 'Esto no es un correo valido',

            'status.required' => 'Seleccionar un estado',
            'status.not_in' => 'Selecione un estado',

            'profile.required' => 'Seleccionar un rol',
            'profile.not_in' => 'Selecione un rol',

            'password.required' => 'Escribir la contraseña del usuario',
            'password.min' => 'La contraseña debe tener minimo 3 caracteres',
        ];

        $this->validate($rules, $messages);


        $user = User::find($this->selected_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'profile' => $this->profile,
            'status' => $this->status,
            'password' => bcrypt($this->password),

        ]);

        $user->syncRoles($this->profile); 

        if ($this->image) {
            $custom_filename = uniqid(). '_.' .$this->image->extension();
            $this->image->storeAs('public/users', $custom_filename);
            $imagenold = $user->image;
            $user->image = $custom_filename;
            $user->save();

            if ($imagenold == "noimg.png") {
                $imagenold = null;
            }

            if ($imagenold != null) {
                if (file_exists('storage/users/'.$imagenold)) {
                    unlink('storage/users/'.$imagenold);
                }
            }
        }

        $this->resetIU();
        $this->emit('user-update', 'Usuario actualizado');



    }

    protected $listeners = [
        'deleterow' => 'Destroy',
        'search' => '$refresh'
    ];

    public function Destroy(User $user)
    {
        //$user = User::find($id);
        if($user){
            $sales = Sale::where('user_id', $user->id)->count();
            if($sales > 0){
                $this->emit('user-wsa', 'Este usuario tiene ventas registradad, no se puede eliminar');
            }else {

                //recordar agregar condicional para no borrar el img disponible
                
                $imagenold = $user->image;
                if ($imagenold == "noimg.png") {
                  $imagenold = null;
                }

               
                $user->delete();
        
                if ($imagenold != null) {
                    if (file_exists('storage/users/'.$imagenold)) {
                        unlink('storage/users/'.$imagenold);
                    }
                }
        
                $this->resetIU();
                $this->emit('user-delete', 'Usuario Eliminado');
            }
        }
        
       
        

    }


    public function resetIU()
    {
        $this->name = '';
        $this->image = null;
        $this->search = '';
        $this->phone = '';
        $this->profile = 'ADMIN';
        $this->status = 'ACTIVE';
        $this->email = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
