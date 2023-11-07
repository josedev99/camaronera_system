<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Categories extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $search, $image, $selected_id, $pageTitle, $componentName;
    public $pagination = 3;

    public function mount()
    {
        
        $this->componentName = 'Categorias';
        $this->pageTitle = 'Listado';
        
    }
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }



    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = Category::where('name', 'like', '%'. $this->search. '%')->paginate($this->pagination);
        }
        else {
            $data = Category::orderBy('id', 'desc')->paginate($this->pagination);
        }
        
        return view('livewire.category.categories', ['categories' => $data])
        ->extends('layouts.theme.app')
        ->section('content'); 

        
    }

    public function Edit($id)
    {
        $record = Category::find($id);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->emit('show-modal', 'show modal');

    }

    public function Store()
    {
        $rules = [
            'name' => 'required|unique:categories|min:3'
        ];
        $messages = [
            'name.required' => 'Escribir el nombre',
            'name.unique' => 'Esta categoria existe',
            'name.min' => 'Debe tener minimo 3 caracteres',
        ];

        $this->validate($rules, $messages);

        $category = Category::create([
            'name' => $this->name,
            
        ]);

        $custom_filename;
        if ($this->image) {
            $custom_filename = uniqid(). '_.' .$this->image->extension();
            $this->image->storeAs('public/categories', $custom_filename);
            $category->image = $custom_filename;
            $category->save();
        }

        $this->resetIU();
        $this->emit('category-add', 'Categoria regsitrada');
    }

    public function Update()
    {
        $rules = [
            'name' => "required|unique:categories,name,{$this->selected_id}|min:3"
        ];
        $messages = [
            'name.required' => 'Escribir el nombre',
            'name.unique' => 'Esta categoria existe',
            'name.min' => 'Debe tener minimo 3 caracteres',
        ];

        $this->validate($rules, $messages);


        $category = Category::find($this->selected_id);
        $category->update([
            'name' => $this->name,

        ]);

        if ($this->image) { 
            $custom_filename = uniqid(). '_.' .$this->image->extension();
            $this->image->storeAs('public/categories', $custom_filename);
            $imagenold = $category->image;
            $category->image = $custom_filename;
            $category->save();

            if ($imagenold == "noimg.png") {
                $imagenold = null;
            }

            if ($imagenold != null) {
                if (file_exists('storage/categories/'.$imagenold)) {
                    unlink('storage/categories/'.$imagenold);
                }
            }
        }

        $this->resetIU();
        $this->emit('category-update', 'Categoria actualizada');



    }

    protected $listeners = [
        'deleterow' => 'Destroy'
    ];

    public function Destroy(Category $category)
    {
        //$category = Category::find($id);

        $imagenold = $category->image;
        //para evitar borrar noimg
        if ($imagenold == "noimg.png") {
            $imagenold = null;
        }
        $category->delete();

        if ($imagenold != null) {
            if (file_exists('storage/categories/'.$imagenold)) {
                unlink('storage/categories/'.$imagenold);
            }
        }

        $this->resetIU();
        $this->emit('category-delete', 'Categoria Eliminada');

    }


    public function resetIU()
    {
        $this->name = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
    }
}
