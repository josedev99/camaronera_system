<?php

namespace App\Http\Livewire;

use App\Models\Denomination;
use App\Models\Provider;
use App\Models\Product;
use App\Models\Movements;
use Livewire\Component;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use DB;
use Exception;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Purchases extends Component
{
    public $total, $itemsQuantity, $efectivo, $change, $search, $pagination, $provider_id, $pay, $invoice, $newpp = [], $a, $i;
    
    public function mount()
    {
        $this->a = 0;

        //obtener sesion existente
        $sesion = Session::get('info');
        

        //validar sesion existente
        if ($sesion) {
            //existe que la sesion pertenece a ventas - limpiar
            if ($sesion == 'sale') {
                Cart::clear();
                Session::put('info', 'purchase');
            } 
            //no existe crear sesion pero para compras
            else {
                Session::put('info', 'purchase');
            }
            
           
        }
        //crear la sesion si no existe
        else {
            Session::put('info', 'purchase');
        }

        $this->efectivo = 0;
        $this->change = 0;
        $this->pagination = 3;
        $this->provider_id = 'Elegir';
        $this->pay = 'Elegir';
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $products = Product::join('categories as c', 'c.id', 'products.category_id')->select('products.*', 'c.name as category')
            ->where('products.name', 'like', '%'.$this->search.'%')
            ->orWhere('products.barcode', 'like', '%'.$this->search.'%')
            ->orWhere('c.name', 'like', '%'.$this->search.'%')
            ->orderBy('products.name', 'asc')
            ->take($this->pagination)->get();
        }
        else {
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
            ->select('products.*', 'c.name as category')
            ->orderBy('products.name', 'asc')
            ->take($this->pagination)->get();
        }
       
        return view('livewire.purchases.purchases', [
            'products' => $products,
            'cart' => Cart::getContent()->sortBy('name'),
            'providers' =>  Provider::orderBy('name', 'desc')->get(),
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

           Cart::add($product->id, $product->name, $product->cost, $cant, $product->image);

           $this->total = Cart::getTotal();
           $this->itemsQuantity = Cart::getTotalQuantity();

           $this->emit('scan-ok', 'Producto Agregado');

        }
        
    }

    public function AddProduct($id, $cant = 1)
    {
         
        
        $product = Product::where('id', $id)->first();

        
        if ($product == null) {
           $this->emit('scan-notfound', 'El producto no fue encontrado');
        } else {
           if($this->InCart($product->id)){
                $this->increaseQty($product->id);
                return;
           }


           Cart::add($product->id, $product->name, $product->cost, $cant, $product->image);

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

       

       Cart::add($product->id, $product->name, $exist->price, $cant, $product->image);

       $this->total = Cart::getTotal();
       $this->itemsQuantity = Cart::getTotalQuantity();
       $this->emit('scan-ok', $title);



    }

    public function updateQty($productid, $cant = 1, $price = null)
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


       $this->removeItem($productid);
       if ($price != null) {
            $newPrice = $price;
        } else {
            $newPrice = $product->cost;
        }

       if ($cant > 0) {
        Cart::add($product->id, $product->name, $newPrice, $cant, $product->image);
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

       if($item == null){
        return;
       }

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

    public function savePurchase()
    {
        $i = 0;
        $data = [];
        $oldmovent = [];

       if($this->total <= 0){
        $this->emit('sale-error', 'Agrega Productos a la venta');
        return;

       }
       if ($this->provider_id == 'Elegir') {
        $this->emit('sale-error', 'Elegir un proveedor');
        return;
       }
       if ($this->pay == 'Elegir') {
        $this->emit('sale-error', 'Elegir metodo de pago');
        return;
       }

       

    


       DB::beginTransaction();


       try {
        $purchase = Purchase::create([
            'total' => $this->total,
            'items' => $this->itemsQuantity,
            'invoice' => $this->invoice = $this->invoice != null ? $this->invoice : null,
            'pay' => $this->pay,
            'iva' => $this->total*0.13,
            'user_id' => Auth()->user()->id,
            'provider_id' =>  $this->provider_id,
        ]);

        if ($purchase) {
            $items = Cart::getContent();

            foreach($items as $item){

                //validar si existen registros de compras anterior
                $valid = Movements::where('product_id', '=', $item->id)
                ->where(function($query) {
                    $query->where('type', '=', 'COMPRA')
                                ->orWhere('type', '=', 'NUEVO');})
               
                ->selectRaw("SUM(sald) as total_sum")
                ->selectRaw("SUM(quantity) as available_sum")
                ->groupBy('product_id')
                ->get()->toArray();

                $valid2 = Movements::where('product_id', '=', $item->id)
                ->where('type', '=', 'SALIDA')
                ->selectRaw("SUM(sald) as total_sum")
                ->selectRaw("SUM(quantity) as available_sum")
                ->groupBy('product_id')
                ->get()->toArray();

                if ($valid2 != []) {
                    $valid[0]['available_sum'] -= $valid2[0]['available_sum'];
                }
                

               
                
                $oldmovent = Movements::where('product_id', '=', $item->id)->orderBy('created_at', 'desc')->first();
                
                
                

                //validacion para si es primera compra del producto
                if ($valid == []) {
                    PurchaseDetails::create([
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'available' => $item->quantity,
                        'total' => $item->price*$item->quantity,
                        'product_id' => $item->id,
                        'purchase_id' => $purchase->id, 
                    ]);
                    Movements::create([
                        'price' => $item->price,
                        'priceu' => $item->price,
                        'quantity' => $item->quantity,
                        'available' => $item->quantity,
                        'total' => $item->price*$item->quantity,
                        'sald' => $item->price*$item->quantity,
                        'product_id' => $item->id,
                        'user_id' => Auth()->user()->id,
                        'type' => 'COMPRA',
                    ]);
    
                    //update Stock
    
                    $product = Product::find($item->id);
                    $product->stock =  $product->stock + $item->quantity;
                    $product->cost =  $item->price;
                    $product->price =  $item->price;
                    $product->pricev =  number_format($item->price+($item->price*($product->percentage/100)),2);
                    $product->save();
                    array_push($data, ["id" => $product->id, "pricenew" => $item->price, "price" => $product->pricev,"priceold" => number_format($item->price+($item->price*($product->percentage/100)),2), "name" => $product->name, "promedio" =>$item->price]);

                } else {
                    $product = Product::find($item->id);
                    $promedio = (($product->price*$valid[0]['available_sum'])+($item->price*$item->quantity))/($valid[0]['available_sum']+$item->quantity);
                   
                    PurchaseDetails::create([
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'available' => $item->quantity,
                        'total' => $item->price*$item->quantity,
                        'product_id' => $item->id,
                        'purchase_id' => $purchase->id,
                    ]); 

                    Movements::create([
                        'price' => $promedio,
                        'priceu' => $item->price,
                        'quantity' => $item->quantity,
                        'available' => $item->quantity+$oldmovent['available'],
                        'total' => ($item->price*$item->quantity)+$oldmovent['total'],
                        'sald' => $item->price*$item->quantity,
                        'product_id' => $item->id,
                        'user_id' => Auth()->user()->id,
                        'type' => 'COMPRA',
                    ]);
    
                    //update Stock

                    array_push($data, ["id" => $product->id, "pricenew" => $item->price, "price" => $product->pricev,"priceold" => number_format($promedio+($promedio*($product->percentage/100)), 2), "name" => $product->name, "promedio" =>$promedio]);

                   
                   
                    
                    
                    $product->stock =  $product->stock + $item->quantity;
                    $product->cost =  $item->price;
                    
                    $product->price = $promedio;
                    $product->pricev = number_format($promedio+($promedio*($product->percentage/100)), 2);
                    $product->save();

                } 
                
                

                //productos con precios nuevos - posible cambio
                
                
                
            }
        }
        DB::commit();
        Cart::clear();

        $this->efectivo = 0; 
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Compra Registrada');

        if ($data != []) {
            
            $this->newpp = $data;
            $this->emit('modal-show', 'Existen');
        }
        
       

       }
       catch (Exception $e) {
        DB::rollback();
        $this->emit('sale-error', $e->getMessage());
       }

       

    }

    

    public function Newchange()
    {
        $this->efectivo = 0;
        $this->change = 0;
    }

    public function UpdatePrice()
    {

        foreach ($this->newpp as $data) {
            $product = Product::find($data['id']);
            
            $product->update([
                'pricev' => $data['priceold'],
            ]);
        }

        $this->emit('product-update', 'Precios actualizados');
    }

}
