@extends('layouts.master')
@section('title', 'قائمة الفواتير')

@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">
                    / الفواتير المدفوعة جزئيا</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <!-- row opened -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0"> رقم الفاتورة </th>
                                <th class="wd-20p border-bottom-0">تاريخ الفاتورة </th>
                                <th class="wd-15p border-bottom-0"> تاريخ الاستحقاق</th>
                                <th class="wd-10p border-bottom-0">المنتج</th>
                                <th class="wd-10p border-bottom-0">القسم</th>
                                <th class="wd-10p border-bottom-0">الخصم</th>
                                <th class="wd-10p border-bottom-0">نسبة الضريبة </th>
                                <th class="wd-10p border-bottom-0">قيمة الضريبة</th>
                                <th class="wd-10p border-bottom-0">الإجمالي </th>
                                <th class="wd-10p border-bottom-0">الحالة</th>
                                <th class="wd-25p border-bottom-0">ملاحظات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($chart_echart as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->invoice_number }}</td>
                                    <td> {{ $item->invoice_date }}</td>
                                    <td>{{ $item->due_date }}</td>
                                    <td>{{ $item->productData->product_name ?? '—' }}</td>

                                    <td><a
                                            href="{{ url('invoicedetalls') }}/{{ $item->id }}">{{ $item->section->section_name }}</a>
                                    </td>
                                    <td>{{ $item->discount }}</td>
                                    <td>{{ $item->rate_vat }}</td>
                                    <td>{{ $item->value_vat }} </td>
                                    <td>{{ $item->total }}</td>
                                    <td>
                                        @if ($item->value_status == 1)
                                            <span class="text-success">{{ $item->status }}</span>
                                        @elseif ($item->value_status == 2)
                                            <span class="text-danger">{{ $item->status }}</span>
                                        @else
                                            <span class="text-warning">{{ $item->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->note }}</td>


                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/div-->


    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
@endsection
