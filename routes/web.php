<?php

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\InvoicesDetalisController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();


Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resources([
    'roles' => RoleController::class,
    'users' => UserController::class,

]);



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('invoice', InvoicesController::class);
Route::resource('section', SectionsController::class);
Route::resource('product', ProductController::class);
// Route::get('/section/{id}', [InvoicesController::class, 'getProducts']);
Route::get('invoicedetalls/{id}', [InvoicesDetalisController::class, 'index']);
Route::post('invoicedetalls', [InvoicesDetalisController::class, 'store']);
Route::post('detalis',[InvoicesDetalisController::class,'destroy'])->name('detalis');
Route::get('view_file/{invoice_number}/{file_name}',[InvoicesDetalisController::class,'open_file']);
Route::get('print_file/{invoice_number}/{file_name}',[InvoicesDetalisController::class,'print_file']);
Route::get('chart-flot',[InvoicesController::class,'chart_flot']);
Route::get('chart-chartjs',[InvoicesController::class,'chart_chartjs']);
Route::get('chart-echart',[InvoicesController::class,'chart_echart']);
Route::get('archive',[InvoicesController::class,'archive']);
Route::put('/update_stats/{id}', [InvoicesController::class, 'update_stats'])->name('update_stats');
Route::delete('/archive_delete/{id}', [InvoicesController::class, 'archive_delete'])->name('archive_delete');
Route::post('/archive_updata/{id}', [InvoicesController::class, 'archive_updata'])->name('archive_updata');
Route::get('/print/{id}', [InvoicesController::class, 'print'])->name('print');
Route::get('export_invoices', [InvoicesController::class, 'export']);

Route::get('invoices_report', [InvoicesController::class, 'report']);
Route::post('search_invoices', [InvoicesController::class, 'search_invoices'])->name('search_invoices');
Route::get('mark_all', [InvoicesController::class, 'mark_all'])->name('mark_all');
Route::get('/get-products/{section_id}', [InvoicesController::class, 'getProducts']);


Route::get('/{page}', [AdminController::class,'index']);
