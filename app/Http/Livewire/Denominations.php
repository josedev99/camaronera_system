<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Denomination;

class Denominations extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $type, $search, $image, $value, $selected_id, $pageTitle, $componentName;
    public $pagination = 3;

    public function mount()
    {
        
        $this->componentName = 'Denominaciones';
        $this->pageTitle = 'Listado';
        
    }
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = Denomination::where('type', 'like', '%'. $this->search. '%')->paginate($this->pagination);
        }
        else {
            $data = Denomination::orderBy('id', 'desc')->paginate($this->pagination);
        }
        
        return view('livewire.denominations.denomination', ['denominations' => $data])
        ->extends('layouts.theme.app')
        ->section('content'); 
    }


    public function Edit($id)
    {
        $record = Denomination::find($id);
        $this->type = $record->type;
        $this->value = $record->value;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->emit('show-modal', 'show modal');

    }

    public function Store()
    {
        $rules = [
            'type' => 'required|min:3',
            'value' => 'required'
        ];
        $messages = [
            'type.required' => 'Seleccionar el tipo de pago',
            'type.min' => 'Seleccionar el tipo de pago',
            'value.required' => 'Escribir el valor',
        ];

        $this->validate($rules, $messages);

        $denomination = Denomination::create([
            'type' => $this->type,
            'value' => $this->value,
            
        ]);

        $custom_filename;
        if ($this->image) {
            $custom_filename = uniqid(). '_.' .$this->image->extension();
            $this->image->storeAs('public/denominations', $custom_filename);
            $denomination->image = $custom_filename;
            $denomination->save();
        }

        $this->resetIU();
        $this->emit('denomination-add', 'Denominacion regsitrada');
    }

    public function Update()
    {
        $rules = [
            'type' => "required|min:3",
            'value.required' => 'Escribir el valor',
        ];
        $messages = [
            'type.required' => 'Seleccionar el tipo de pago',
            'type.min' => 'Seleccionar el tipo de pago',
            'value.required' => 'Escribir el valor',
            
        ];

        $this->validate($rules, $messages);


        $denomination = Denomination::find($this->selected_id);
        $denomination->update([
            'type' => $this->type,
            'value' => $this->value,
        ]);

        if ($this->image) {
            $custom_filename = uniqid(). '_.' .$this->image->extension();
            $this->image->storeAs('public/denominations', $custom_filename);
            $imagenold = $denomination->image;
            $denomination->image = $custom_filename;
            $denomination->save();

            if ($imagenold == "noimg.png") {
                $imagenold = null;
            }

            if ($imagenold != null) {
                if (file_exists('storage/denominations/'.$imagenold)) {
                    unlink('storage/denominations/'.$imagenold);
                }
            }
        }

        $this->resetIU();
        $this->emit('denomination-update', 'Denominacion actualizada');



    }

    protected $listeners = [
        'deleterow' => 'Destroy'
    ];

    public function Destroy(Denomination $denomination)
    {
        //$denomination = Denomination::find($id);

        $imagenold = $denomination->image;
        //para evitar borrar noimg
        if ($imagenold == "noimg.png") {
            $imagenold = null;
        }
        $denomination->delete();

        if ($imagenold != null) {
            if (file_exists('storage/denominations'.$imagenold)) {
                unlink('storage/denominations/'.$imagenold);
            }
        }

        $this->resetIU();
        $this->emit('denomination-delete', 'Categoria Eliminada');

    }


    public function resetIU()
    {
        $this->type = 'no';
        $this->value = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
    }
}
