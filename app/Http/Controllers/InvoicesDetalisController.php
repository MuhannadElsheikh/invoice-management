<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Invoices;
use Illuminate\Http\Request;
use App\Models\Invoices_detalis;
use Illuminate\Support\Facades\DB;
use App\Models\Invoices_attchments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class InvoicesDetalisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $invoice = Invoices::where('id', $id)->first();
        $detalis = Invoices_detalis::where('invoices_id', $id)->get();
        $attchments = Invoices_attchments::where('invoices_id', $id)->get();

        DB::table('notifications')
        ->where('data->invoice_id', $id)
        ->update(['read_at' => now()]);
        return view('invoice.invoices_detalis', compact('invoice', 'detalis', 'attchments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->has('pic')) {
            $file =  $request->file('pic');
            $filename = $file->getClientOriginalName();
            $invoice_number=$request->invoice_number;
            $invoice_id=$request->invoice_id;

            Invoices_attchments::create([
                'file_name'=> $filename,
                'invoices_id'=>$invoice_id,
                'invoice_number'=>$invoice_number,
                'create_by'=>Auth::user()->name,
            ]);

            $imageName= $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/'.$invoice_number),$imageName);
        }


        return back()->with('success', 'تم رفع المرفق بنجاح.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Invoices_detalis $invoices_detalis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoices_detalis $invoices_detalis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

$invoice= Invoices_attchments::findOrfail($request->file_id);
$invoice->delete();
$filePath = public_path('Attachments/' .$request->invoice_number . '/' .$request->file_name);

// التحقق من وجود الصورة في المسار
if (File::exists($filePath)) {
    // حذف الصورة
    File::delete($filePath);
}


        return redirect()->back();
    }

    public function print_file($file_name, $invoice_number)
    {
         // بناء المسار الصحيح
         $file_path = public_path("Attachments/$file_name/$invoice_number");
         return response()->download($file_path);
    }


    public function open_file($file_name, $invoice_number)
    {
         // بناء المسار الصحيح
         $file_path = public_path("Attachments/$file_name/$invoice_number");
         return response()->file($file_path);
    }

}

