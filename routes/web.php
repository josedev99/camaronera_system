<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Categories;
use App\Http\Livewire\Products;
use App\Http\Livewire\Denominations;
use App\Http\Livewire\Sales;
use App\Http\Livewire\Roles;
use App\Http\Livewire\Permissions;
use  App\Http\Livewire\Assigner;
use  App\Http\Livewire\Users;
use  App\Http\Livewire\Cashout;
use  App\Http\Livewire\Reports;
use  App\Http\Livewire\Purchases;
use  App\Http\Livewire\Providers;
use  App\Http\Livewire\Customers;
use  App\Http\Livewire\Expenses;
use  App\Http\Livewire\Dash;
use  App\Http\Livewire\SalesC;
use  App\Http\Livewire\Home;

use App\Http\Controllers\ExportController;
use App\Http\Livewire\Compras;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', Home::class)->name('home')->middleware('permission:dash');



Route::middleware(['auth'])->group(function () {
        

        Route::group(['middleware' => ['role:ADMINISTRADOR']], function ()  
        { 
        
        Route::get('permissions', Permissions::class)->middleware('permission:permission_index');
        Route::get('assign', Assigner::class)->middleware('permission:assign_index');
        Route::get('users', Users::class)->middleware('permission:user_index');
        Route::get('roles', Roles::class)->middleware('permission:rol_index');
        //individuval  Route::get('categories', Categories::class)->middeware('role:ADMIN);
        });
        
        
       Route::get('dash', Dash::class)->middleware('permission:sale_index');
        
        Route::get('categories', Categories::class)->middleware('permission:category_index');;
        Route::get('denominations', Denominations::class)->middleware('permission:denomination_index');;
        Route::get('products', Products::class)->middleware('permission:product_index');;
        Route::get('sales', Expenses::class)->middleware('permission:sale_index');
        Route::get('ventas', SalesC::class);
       
        Route::get('cashout', Cashout::class)->middleware('permission:cashout_index');;
        Route::get('reports', Reports::class)->middleware('permission:report_index');;

        Route::get('purchases', Purchases::class)->middleware('permission:sale_index');;
        Route::get('providers', Providers::class)->middleware('permission:sale_index');;
        Route::get('customers', Customers::class)->middleware('permission:sale_index');;

        //reportepdf
        Route::get('report/pdf/{user}/{type}/{product}/{fi}/{ff}', [ExportController::class, 'reportPDF'])->middleware('permission:pdf');;
        Route::get('report/pdf/{user}/{type}/{product}', [ExportController::class, 'reportPDF'])->middleware('permission:pdf');;
        //reporteexcel

        Route::get('report/excel/{user}/{type}/{product}/{fi}/{ff}', [ExportController::class, 'ReporteExcel'])->middleware('permission:excel');;
        Route::get('report/excel/{user}/{type}/{product}', [ExportController::class, 'ReporteExcel'])->middleware('permission:excel');;

});


//Routas para compra
Route::get('compras',Compras::class)->middleware('permission:sale_index');


