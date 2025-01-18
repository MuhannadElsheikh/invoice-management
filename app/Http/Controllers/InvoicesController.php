<?php

namespace App\Http\Controllers;


use App\Models\Section;
use App\Models\Invoices;
use Illuminate\Http\Request;
use App\Exports\InvoicesExport;
use App\Models\Invoices_detalis;
use Illuminate\Support\Facades\DB;
use App\Models\Invoices_attchments;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use Maatwebsite\Excel\Facades\Excel;
use App\Notifications\Invoice_add;
use Illuminate\Support\Facades\Notification;

class InvoicesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:قائمة الفواتير', ['only' => ['index']]);
        $this->middleware('permission:اضافة فاتورة ', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل فاتورة ', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف فاتورة ', ['only' => ['destroy']]);
        $this->middleware('permission:الفواتير المدفوعة ', ['only' => ['chart_flot']]);
        $this->middleware('permission:الفواتير الغير المدفوعة', ['only' => ['chart_chartjs']]);
        $this->middleware('permission:الفواتيرالمدفوعة جزئيا ', ['only' => ['chart_echart']]);
        $this->middleware('permission:الفواتير المؤرشفة ', ['only' => ['archive']]);
        $this->middleware('permission:تغير حالة الدفع ', ['only' => ['show']]);
        $this->middleware('permission:طباعة فاتورة', ['only' => ['print']]);
    }


    public function index()
    {
        $invoices = Invoices::all();
        return view('invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();
        return view('invoice.addinvoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Invoices $invoices)
    {
        Invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product' => 'منتج',
            'section_id' => $request->section_id,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
        ]);

        $invoice_id = Invoices::latest()->first()->id;
        Invoices_detalis::create([
            'invoices_id' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => 'منتج',
            'section' => $request->section_id,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user' => Auth::user()->name
        ]);

        if ($request->has('pic')) {
            $file =  $request->file('pic');
            $filename = $file->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            Invoices_attchments::create([
                'file_name' => $filename,
                'invoices_id' => $invoice_id,
                'invoice_number' => $invoice_number,
                'create_by' => Auth::user()->name,
            ]);
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);


        }



        $users = User::where('id', '!=', auth()->user()->id)->get();


        Notification::send($users, new Invoice_add($invoice_id));

        return redirect()->back()->with('success', 'تم إنشاء القاتورة بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $stuts = Invoices::where('id', $id)->first();
        $section = Section::all();
        return view('invoice.stuts', compact('stuts', 'section'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoices = Invoices::where('id', $id)->first();
        $sections = Section::all();
        return view('invoice.edit_invoice', compact('invoices', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $invoices = Invoices::where('id', $request->id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product' => 'منتج',
            'section_id' => $request->section_id,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
        ]);
        $details = Invoices_detalis::where('invoices_id', $request->id)->first();

        if ($details) {
            // إذا كانت التفاصيل موجودة، نقوم بتحديثها
            $details->update([
                'invoices_id' => $request->id,
                'invoice_number' => $request->invoice_number,
                'product' => 'منتج',
                'section' => $request->section_id,
                'status' => 'غير مدفوعة',
                'value_status' => 2,
                'note' => $request->note,
                'user' => Auth::user()->name,
            ]);
        }
        return redirect()->route('invoice.index')->with('success', 'تم تحديث الفاتورة  بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $invoices = Invoices::where('id', $id)->first();
        $attchment = Invoices_attchments::where('invoices_id', $id)->first();
        $id_page = $request->id_page;
        if ($id_page != 2) {

            if ($attchment && !empty($attchment->invoice_number)) {
                $directoryPath = public_path("Attachments/" . $attchment->invoice_number);

                // تحقق إذا كان المجلد موجودًا
                if (File::exists($directoryPath)) {
                    // حذف المجلد
                    File::deleteDirectory($directoryPath);
                }
            }
            $invoices->forceDelete();
            return redirect()->route('invoice.index')->with('success', 'تم حذف الفاتورة  بنجاح.');
        } else {
            $invoices->delete();
            return redirect()->route('invoice.index')->with('success', 'تم ارشفة الفاتورة  بنجاح.');
        }
    }

    public function getProducts($id)
    {

        $products = DB::table('products')->where('section_id', $id)->pluck('product_name', 'id');
        dd($products);
        return response()->json($products);
    }

    public function chart_flot()
    {
        $chart_flot = Invoices::where('value_status', 1)->get();
        return  view('invoice.chart_flot', compact('chart_flot'));
    }

    public function chart_chartjs()
    {
        $chart_chartjs = Invoices::where('value_status', 2)->get();
        return view('invoice.chart_chartjs', compact('chart_chartjs'));
    }

    public function chart_echart()
    {
        $chart_echart = Invoices::where('value_status', 3)->get();
        return  view('invoice.chart_echart', compact('chart_echart'));
    }


    public function archive()
    {
        $archive = Invoices::onlyTrashed()->get();
        return  view('invoice.archive', compact('archive'));
    }

    public function update_stats($id, Request $request)
    {
        $invoices = Invoices::findOrfail($id);
        if ($request->status === 'مدفوعة') {

            $invoices->update([
                'value_status' => 1,
                'status' => $request->status,
                'bayment_date' => $request->bayment_date
            ]);
            Invoices_detalis::create([
                'invoices_id' => $request->id,
                'invoice_number' => $request->invoice_number,
                'product' => 'منتج',
                'section' => $request->section_id,
                'status' => $request->status,
                'value_status' => 1,
                'note' => $request->note,
                'user' => Auth::user()->name,
                'bayment_date' => $request->bayment_date

            ]);
        } else {
            $invoices->update([
                'value_status' => 3,
                'status' => $request->status,
                'bayment_date' => $request->bayment_date
            ]);
            Invoices_detalis::create([
                'invoices_id' => $request->id,
                'invoice_number' => $request->invoice_number,
                'product' => 'منتج',
                'section' => $request->section_id,
                'status' => $request->status,
                'value_status' => 3,
                'note' => $request->note,
                'user' => Auth::user()->name,
                'bayment_date' => $request->bayment_date

            ]);
        }
        return redirect()->route('invoice.index')->with('success', 'تم تحديث حالة الفاتورة  بنجاح.');
    }

    public function archive_updata(Request $request)
    {
        $id = $request->id;
        Invoices::withTrashed()->where('id', $id)->restore();
        return redirect()->route('invoice.index')->with('success', 'تم استرجاع الفاتورة  بنجاح.');
    }


    public function archive_delete(Request $request)
    {
        $id = $request->id;
        $result = Invoices::withTrashed()->where('id', $id)->first();
        $attchment = Invoices_attchments::where('invoices_id', $id)->first();
        if ($attchment && !empty($attchment->invoice_number)) {
            $directoryPath = public_path("Attachments/" . $attchment->invoice_number);

            // تحقق إذا كان المجلد موجودًا
            if (File::exists($directoryPath)) {
                // حذف المجلد
                File::deleteDirectory($directoryPath);
            }
        }
        $result->forceDelete();
        return redirect()->route('invoice.index')->with('success', 'تم استرجاع الفاتورة  بنجاح.');
    }

    public function print($id)
    {
        $invoices = Invoices::where('id', $id)->first();
        return view('invoice.print_invoices', compact('invoices'));
    }

    public function export()
    {
        return Excel::download(new InvoicesExport, 'users.xlsx');
    }

    public function report()
    {
        return view('report.index');
    }

    public function search_invoices(Request $request)
    {



        $radio = $request->radio;
        if ($radio == 1) {
            if ($request->type && empty($request->start_at) && empty($request->end_at)) {
                $type = $request->type;
                $invoices = Invoices::select('*')->where('status', $type)->get();
                return view('report.index', compact('type', 'invoices'));
            } else {
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;
                $invoices = Invoices::whereBetween('invoice_date', [$start_at, $end_at])->where('status', $type)->get();
                return view('report.index', compact('type', 'invoices', 'end_at', 'start_at'));
            }
        } else {
            $invoices = Invoices::select('*')->where('invoice_number', $request->invoice_namber)->get();
            return view('report.index', compact('invoices'));
        }
    }

    public function mark_all(Request $request)
    {
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();
        return back();
    }

}
