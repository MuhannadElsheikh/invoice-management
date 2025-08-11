@extends('layouts.master')
@section('title', 'معاينة الفواتير')

@section('css')
    <style>
        @media print {
            #print_button {
                display: none;
            }
        }
    </style>
    <!-- Internal Data table css -->

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ معاينة
                    الفواتير</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <!-- row opened -->

    <div class="row row-sm">
        <div class="col-xl-12  col-md-12">
            <div class="main-content-body-invoice " id="print">
                <div class="card card-invoice">
                    <div class="card-body">
                        <div class="invoice-header">
                            <h2 class="invoice-title">فاتورة تحصبل</h2>
                            <div class="billed-from">
                                <h5>شركة الامين للتحصيل </h5>
                                <p>هاتف : 0597214986 <br>
                                    ايميل : muhannad@gmail.com</p>
                            </div>
                        </div>
                        <div class="col-md">
                            <label class="tx-gray-600">معلومات الفاتورة </label>
                            <p class="invoice-info-row"><span>رقم الفاتورة </span>
                                <span>{{ $invoices->invoice_number }}</span>
                            </p>

                            <p class="invoice-info-row"><span>تاريخ الاصدار </span>
                                <span>{{ $invoices->invoice_date }}</span>
                            </p>

                            <p class="invoice-info-row"><span>تاريخ الاستحقاق </span>
                                <span>{{ $invoices->due_date }}</span>
                            </p>

                            <p class="invoice-info-row"><span>القسم </span>
                                <span>{{ $invoices->section->section_name }}</span>
                            </p>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border mb-0 text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th class="wd-20p">#</th>
                                        <th class="wd-40p">المنتج</th>
                                        <th class="tx-center">مبلغ التحصيل </th>
                                        <th class="tx-right">مبلغ العمولة </th>
                                        <th class="tx-right">الاجمالي </th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td class="tx-12">{{ $invoices->productData->product_name }}</td>
                                        <td class="tx-center">{{ number_format($invoices->amount_collection, 2) }}</td>
                                        <td class="tx-right">{{ number_format($invoices->amount_commission, 2) }}</td>
                                        @php
                                            $total = $invoices->amount_collection + $invoices->amount_commission;
                                        @endphp
                                        <td class="tx-right">{{ number_format($total, 2) }}</td>

                                    </tr>
                                    <tr>
                                        <td class="valign-middle" colspan="2" rowspan="4">
                                            <div class="invoice-notes">
                                                <label class="main-content-label  tx-13">#</label>
                                            </div>
                                        </td>
                                        <td class="tx-right">الاجمالي </td>
                                        <td class="tx-right" colspan="2">{{ number_format($total, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">تسبة الضريبة </td>
                                        <td class="tx-right" colspan="2">{{ $invoices->rate_vat }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">قيمة الخصم </td>
                                        <td class="tx-right" colspan="2">{{ number_format($invoices->discount, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right"> الاجمالي شامل الضريبة </td>
                                        <td class="tx-right" colspan="2">{{ number_format($invoices->total, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr class="mg-b-40">






                        <button class="byn btn-danger float-left mt-3 mr-2 " id="print_button" onclick="printDiv()">طباعة
                        </button>
                    </div>
                </div>
                <!--/div-->

            </div>
        </div>
    </div>
    <!-- row closed -->
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script>
        function printDiv() {
            var printContents = document.getElementById('print').innerHTML;
            var orginalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = orginalContents;
            location.reload();
        }
    </script>

@endsection
