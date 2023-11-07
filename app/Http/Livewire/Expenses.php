<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Denomination;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Movements;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use DB;
use Exception;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\PurchaseDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Expenses extends Component
{
    public $total, $itemsQuantity, $efectivo, $change, $search, $pagination, $customer_id, $pay, $invoice, $newpp = [], $a, $i;
    
    public function mount()
    {
        $this->a = 0;
        
        //obtener sesion existente
        $sesion = Session::get('info');
        
        //validar sesion existente
        if ($sesion) {
            //existe que la sesion pertenece a compras - limpiar
            if ($sesion == 'purchase') {
                Cart::clear();
                Session::put('info', 'sale');
            } 
            //no existe crear sesion pero para ventas
            else {
                Session::put('info', 'sale');
            }
            
           
        }
        //crear la sesion si no existe
        else {
            Session::put('info', 'sale');
        }
        
        $this->efectivo = 0;
        $this->change = 0;
        $this->pagination = 3;
        $this->customer_id = 'Elegir';
        $this->pay = 'Elegir';
        /* $cond = Cart::getContent()->sortBy('name');
        $cond = reset($cond);
        dd($cond[array_key_first($cond)]->attributes[1]); */
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
        
       
        return view('livewire.expenses.expenses', [
            'products' => $products,
            'cart' => Cart::getContent()->sortBy('name'),
            'customers' =>  Customer::orderBy('name', 'desc')->get(),
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

       if($exist){
        if($product->stock < $cant){
            $this->emit('no-stock', 'Stock insuficiente');
            return;
        }
       }


       $this->removeItem($productid);

       if ($price != null) {
            $newPrice = $price;
        } else {
            $newPrice = $product->pricev;
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

    public function saveSale()
    {
        
        $qty = 0;

       if($this->total <= 0){
        $this->emit('sale-error', 'Agrega Productos a la venta');
        return;

       }
       if ($this->customer_id == 'Elegir') {
        $this->emit('sale-error', 'Elegir un cliente');
        return;
       }
       if ($this->pay == 'Elegir') {
        $this->emit('sale-error', 'Elegir metodo de pago');
        return;
       }

      

       

    


       DB::beginTransaction();


       try {
        $sale = Sale::create([
            'total' => $this->total,
            'items' => $this->itemsQuantity,
            'cash' => $this->total,
            'change' => 0,
            'pay' => $this->pay,
            'iva' => $this->total*0.13,
            'user_id' => Auth()->user()->id,
            'customer_id' =>  $this->customer_id,
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
                    'sald' => $oldmovent['price']*$item->quantity,
                    'product_id' => $item->id,
                    'user_id' => Auth()->user()->id,
                    'type' => 'SALIDA',
                ]);

                //update Stock

                $product = Product::find($item->id);
                $product->stock =  $product->stock - $item->quantity;
                $product->save();
                $qty = $item->quantity;

                
                //proceso PEPS
                /* $peps = PurchaseDetails::where('available', '>', 0)->where('product_id', '=', $product->id)
                ->orderBy('created_at', 'asc')->get();

                foreach ($peps as $i) {
                    if($qty > 0){
                        if ($qty > $i->available) {
                            $purchase = PurchaseDetails::find($i->id);
                            $qty -= $i->available;
                            $purchase->available = 0;
                            $purchase->save();
                        }
                        elseif ($qty == $i->available) {
                            $purchase = PurchaseDetails::find($i->id);
                            $qty = 0;
                            $purchase->available = 0;
                            $purchase->save();
                        }
                        else{
                            $purchase = PurchaseDetails::find($i->id);
                            $purchase->available -= $qty;
                            $purchase->save();
                            $qty = 0;
                        }
                    }
                } */

                


                


                
                
            }
        }
        DB::commit();
        Cart::clear();

        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Venta Registrada');
        //$this->emit('print-ticket', $sale->id);

        
        
       

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

    public function UpdatePrice()
    {

        foreach ($this->newpp as $data) {
            $product = Product::find($data['id']);
            
            $product->update([
                'price' => $data['priceold'],
            ]);
        }

        $this->emit('product-update', 'Precios actualizados');
    }


    public function clearCart2()
    {
        Cart::clear();

        $this->efectivo = 0;
        $this->change = 0;
        $this->efectivo = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
       
    }
}
