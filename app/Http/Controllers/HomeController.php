<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

$invoices=Invoices::count();
$invoices1 =Invoices::where('value_status', 1)->count();
$invoices2 =Invoices::where('value_status', 2)->count();
$invoices3 =Invoices::where('value_status', 3)->count();

if ($invoices > 0) {
    $nespa1 = ($invoices1 / $invoices) * 100;
    $nespa2 = ($invoices2 / $invoices) * 100;
    $nespa3 = ($invoices3 / $invoices) * 100;
} else {
    $nespa1 = $nespa2 = $nespa3 = 0;
}
$chart = Chartjs::build()
->name('barChartTest')
->type('bar')
->size(['width' => 400, 'height' => 200])
->labels(['الفواتير المدفوعة ', 'الفواتير غير المدفوعة ','الفواتير المدفوعة جزئيا'])
->datasets([
    [
        "label" => "الفواتير المدفوعة ",
        'backgroundColor' => ['#b3de6f'],

        'data' => [$nespa1]
    ],
    [
        "label" => "الفواتير غير المدفوعة ",
        'backgroundColor' => ['#ec524b'],
        'data' => [$nespa2]
    ],
    [
        "label" => "الفواتير المدفوعة جزئيا",
        'backgroundColor' => ['#f39233  '],
        'data' => [$nespa3]
    ]
])
->options([
   "scales" => [
       "y" => [
           "beginAtZero" => true
           ]
       ]
]);

return view('home', compact('chart'));


    }
}
