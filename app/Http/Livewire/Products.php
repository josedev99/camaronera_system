<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Movements;
use Livewire\Component;
use App\Models\Product;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Products extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $search, $image, $selected_id, $pageTitle, $componentName, $barcode, $cost, $price, $stock, $alerts, $category_id, $percentage;
    public $pagination = 3;

    public function mount()
    {
        
        $this->componentName = 'Productos';
        $this->pageTitle = 'Listado';
        $this->category_id = 'Elegir';
        
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = Product::join('categories as c', 'c.id', 'products.category_id')->select('products.*', 'c.name as category')
            ->where('products.name', 'like', '%'.$this->search.'%')
            ->orWhere('products.barcode', 'like', '%'.$this->search.'%')
            ->orWhere('c.name', 'like', '%'.$this->search.'%')
            ->orderBy('products.name', 'asc')
            ->paginate($this->pagination);
        }
        else {
            $data = Product::join('categories as c', 'c.id', 'products.category_id')
            ->select('products.*', 'c.name as category')
            ->orderBy('products.name', 'asc')
            ->paginate($this->pagination);
        }
        
        return view('livewire.products.product', ['products' => $data, 'categories' => Category::orderBy('name', 'asc')->get()])
        ->extends('layouts.theme.app')
        ->section('content'); 
    }

    public function Edit($id) 
    {
        $record = Product::find($id);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->barcode = $record->barcode;
        $this->percentage = $record->percentage;
        $this->price = $record->pricev;
        
        $this->alerts = $record->alerts;
        $this->category_id = $record->category_id;

        $this->image = null;

        $this->emit('show-modal', 'show modal');

    }

    public function Store()
    {
        $rules = [
            'name' => 'required|unique:products|min:3',
            'barcode' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alerts' => 'required',
            'percentage' => 'required',
            'category_id' => 'required|not_in:Elegir',
        ];
        $messages = [
            'name.required' => 'Escribir el nombre',
            'name.unique' => 'Este producto existe',
            'name.min' => 'Debe tener minimo 3 caracteres',
            'barcode.required' => 'Escribir el codigo de barras',
            'price.required' => 'Asignar el precio',
            'stock.required' => 'Asiganr el stock',
            'alerts.required' => 'Asignar el inv. min',
            'category_id.required' => 'Elegir la categoria',
            'category_id.not_in' => 'Selecione una categoria',
            'percentage.required' => 'Asignar un porcentaje',
        ];

        $this->validate($rules, $messages);

        $product = Product::create([
            'name' => $this->name,
            'barcode' => $this->barcode,
            'cost' => 0.01,
            'price' => $this->price,
            'pricev' => $this->price,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'percentage' => $this->percentage,
            'category_id' => $this->category_id,
            
        ]); 

        if($this->stock != 0){
            Movements::create([
                'price' => $this->price,
                'priceu' => $this->price,
                'quantity' => $this->stock,
                'available' => $this->stock,
                'total' => $this->price*$this->stock,
                'sald' => $this->price*$this->stock,
                'product_id' => $product->id,
                'user_id' => Auth()->user()->id,
                'type' => 'NUEVO',
            ]);
    
        }

       
        
        if ($this->image) {
            $custom_filename = uniqid(). '_.' .$this->image->extension();
            $this->image->storeAs('public/products', $custom_filename);
            $product->image = $custom_filename;
            $product->save();
        }

        $this->resetIU();

       
        $this->emit('product-add', 'Producto regsitrado');
        
    }

    public function Update()
    {
        $rules = [
            'name' => "required|unique:products,name,{$this->selected_id}|min:3",
            'barcode' => 'required',
            'price' => 'required',
            'alerts' => 'required',
            'percentage' => 'required',
            'category_id' => 'required|not_in:Elegir',
        ];
        $messages = [
            'name.required' => 'Escribir el nombre',
            'name.unique' => 'Este producto existe',
            'name.min' => 'Debe tener minimo 3 caracteres',
            'barcode.required' => 'Escribir el codigo de barras',
            'price.required' => 'Asignar el precio',
            'alerts.required' => 'Asignar el inv. min',
            'category_id.required' => 'Elegir la categoria',
            'category_id.not_in' => 'Selecione una categoria',
            'percentage.required' => 'Asignar un porcentaje',
        ];

        $this->validate($rules, $messages);


        $product = Product::find($this->selected_id);
        $product->update([
            'name' => $this->name,
            'barcode' => $this->barcode,
            'pricev' => $this->price,
            'alerts' => $this->alerts,
            'percentage' => $this->percentage,
            'category_id' => $this->category_id,
        ]);

        if ($this->image) {
            $custom_filename = uniqid(). '_.' .$this->image->extension();
            $this->image->storeAs('public/products', $custom_filename);
            $imagenold = $product->image;
            $product->image = $custom_filename;
            $product->save();

            if ($imagenold == "noimg.png") {
                $imagenold = null;
            }

            if ($imagenold != null) {
                if (file_exists('storage/products/'.$imagenold)) {
                    unlink('storage/products/'.$imagenold);
                }
            }
        }

        $this->resetIU();
        $this->emit('product-update', 'Producto actualizado');



    }

    protected $listeners = [
        'deleterow' => 'Destroy'
    ];

    public function Destroy(Product $product)
    {
       
        $imagenold = $product->image;
        //para evitar borrar noimg
        if ($imagenold == "noimg.png") {
            $imagenold = null;
        }

        $product->delete();

        if ($imagenold != null) {
            if (file_exists('storage/products/'.$imagenold)) {
                unlink('storage/products/'.$imagenold);
            }
        }

        $this->resetIU();
        $this->emit('product-delete', 'Producto Eliminado');

    }





    public function resetIU()
    {
        $this->name = '';
        $this->barcode = '';
        $this->price = '';
        $this->alerts = '';
        $this->stock = '';
        $this->percentage = '';
        $this->category_id = 'Elegir';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
