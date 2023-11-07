<?php

namespace App\Http\Livewire;

use App\Models\Denomination;
use App\Models\Product;
use Livewire\Component;
use App\Models\Movements;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use DB;
use Exception;
use App\Models\Sale;
use App\Models\SaleDetails;
use Illuminate\Support\Facades\Auth;

class Sales extends Component
{
    public $total, $itemsQuantity, $efectivo, $change;

    public function mount()
    {
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
    }

    public function render()
    {
       
        return view('livewire.sales.sales', [
            'denominations' => Denomination::orderBy('value', 'desc')->get(),
            'cart' => Cart::getContent()->sortBy('name'),
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }


    public function ACash($value)
    {
        $this->efectivo += ($value == 0 ? $this->total : $value);
        $this->change = ($this->efectivo - $this->total);
    }


    protected $listeners = [
        'scan-code' => 'ScanCode',
        'removeItem'=> 'removeItem',
        'clearCart' => 'clearCart',
        'saveSale' => 'saveSale',
        'newchange' => 'Newchange',
    ];




    public function ScanCode($barcode, $cant = 1)
    {
         
        
        $product = Product::where('barcode', $barcode)->first();

        
        if ($product == null) {
           $this->emit('scan-notfound', 'El producto no fue encontrado');
        } else {
           if($this->InCart($product->id)){
                $this->increaseQty($product->id);
                return;
           }

           if ($product->stock < 1) {
            $this->emit('no-stock', 'Stock Insuficiente');
            return;

           }

           Cart::add($product->id, $product->name, $product->pricev, $cant, $product->image);

           $this->total = Cart::getTotal();
           $this->itemsQuantity = Cart::getTotalQuantity();

           $this->emit('scan-ok', 'Producto Agregado');

        }
        
    }

    public function InCart($producid)
    {
       $exist = Cart::get($producid);

       if ($exist) {
        return true;
       }
       else {
        return false;
       }

    }
    
    public function increaseQty($productid,$cant = 1)
    {
      $title = '';

      $product = Product::find($productid);
      $exist = Cart::get($productid);

      if ($exist) {
        $title = 'Cantidad Actualizada';
        
       }
       else {
        $title = 'Producto Agregado';
      
       }

       if($exist){
        if($product->stock < ($cant + $exist->quantity)){
            $this->emit('no-stock', 'Stock insuficiente');
            return;
        }
       }

       Cart::add($product->id, $product->name, $product->pricev, $cant, $product->image);

       $this->total = Cart::getTotal();
       $this->itemsQuantity = Cart::getTotalQuantity();
       $this->emit('scan-ok', $title);



    }

    public function updateQty($productid, $cant = 1)
    {
        $title = '';

        $product = Product::find($productid);
        $exist = Cart::get($productid);

      if ($exist) {
        $title = 'Cantidad Actualizada';
        
       }
       else {
        $title = 'Producto Agregado';
        
       }

       if($exist){
        if($product->stock < $cant){
            $this->emit('no-stock', 'Stock insuficiente');
            return;
        }
       }

       $this->removeItem($productid);
       
       if ($cant > 0) {
        Cart::add($product->id, $product->name, $product->pricev, $cant, $product->image);
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', $title);

       }
       //pisoble else
       






    }

    public function removeItem($productid)
    {
        Cart::remove($productid);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Producto Eliminado');
       
    }

    public function decreaseQty($productid)
    {
       $item = Cart::get($productid);
       Cart::remove($productid);

       $newQty = ($item->quantity) - 1;
       if ($newQty > 0) {
        Cart::add($item->id, $item->name, $item->price, $newQty, $item->attributes[0]);
       } 

       $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Cantidad Actualizada');

    }


    public function clearCart()
    {
        Cart::clear();

        $this->efectivo = 0;
        $this->change = 0;
        $this->efectivo = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Carrito Vacio');
    }

    public function saveSale()
    {
       if($this->total <= 0){
        $this->emit('sale-error', 'Agrega Productos a la venta');
        return;

       }

       if($this->efectivo <= 0){
        $this->emit('sale-error', 'Ingrese el efectivo');
        return;

       }

       if($this->total > $this->efectivo){
        $this->emit('sale-error', 'El efectivo debe ser mayor o igual total');
        return;

       } 
       


       DB::beginTransaction();


       try {
        $sale = Sale::create([
            'total' => $this->total,
            'items' => $this->itemsQuantity,
            'cash' => $this->efectivo,
            'change' => $this->change,
            'user_id' => Auth()->user()->id,
            'customer_id' => 1,
        ]); 

        if ($sale) {
            $items = Cart::getContent();

            foreach($items as $item){

                $oldmovent = Movements::where('product_id', '=', $item->id)->orderBy('created_at', 'desc')->first();

                SaleDetails::create([
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'product_id' => $item->id,
                    'sale_id' => $sale->id,
                ]);

                Movements::create([
                    'price' => $oldmovent['price'],
                    'priceu' => $oldmovent['price'],
                    'quantity' => $item->quantity,
                    'available' => $oldmovent['available']-$item->quantity,
                    'total' => $oldmovent['total']-($oldmovent['price']*$item->quantity),
                    'product_id' => $item->id,
                    'type' => 'SALIDA',
                ]);


                //update Stock

                $product = Product::find($item->id);
                $product->stock =  $product->stock - $item->quantity;
                $product->save();
            }
        }
        DB::commit();
        Cart::clear();

        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('sale-ok', 'Venta Registrada');
        $this->emit('print-ticket', $sale->id);

       }
       catch (Exception $e) {
        DB::rollback();
        $this->emit('sale-error', $e->getMessage());
       }

    }

    public function printTicket($sale)
    {
        return Redirect::to("print://$sale->id");
    }

    public function Newchange()
    {
        $this->efectivo = 0;
        $this->change = 0;
    }







}
