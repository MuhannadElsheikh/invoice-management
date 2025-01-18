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
                <h4 class="content-title mb-0 my-auto">الفواتير </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة
                    الفواتير</span>
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
                @can('اضافة فاتورة ')
                    <a class="modal-effect btn btn-primary btn-sm-8 " href="{{ route('invoice.create') }}">إضافة
                        فاتورة</a>
                @endcan
                @can('تصدير اكسيل ')
                    <a href="{{ url('export_invoices') }}" class="modal-effect btn btn-primary btn-sm-8">تصدير إكسل</a>
                @endcan
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
                                @canany(['تعديل فاتورة ', 'طباعة فاتورة', 'تغير حالة الدفع ', 'حذف فاتورة ', 'ارشفة
                                    فاتورة'])
                                    <th class="wd-25p border-bottom-0">العمليات </th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->invoice_number }}</td>
                                    <td> {{ $item->invoice_date }}</td>
                                    <td>{{ $item->due_date }}</td>
                                    <td>{{ $item->product }}</td>
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
                                    @canany(['تعديل فاتورة ', 'طباعة فاتورة', 'تغير حالة الدفع ', 'حذف فاتورة ', 'ارشفة
                                        فاتورة'])
                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary" data-toggle="dropdown"
                                                    id="dropdownMenuButton" type="button" style="width: 100px; height:40px;">
                                                    العمليات </button>
                                                <div class="dropdown-menu tx-13">
                                                    @can('تعديل فاتورة ')
                                                        <a
                                                            href="{{ route('invoice.edit', ['invoice' => $item->id]) }}"class=" modal-effect btn-sm edit-section-btn btn btn-success w-100">تعديل</a><br>
                                                    @endcan

                                                    @can('حذف فاتورة ')
                                                        <form action="{{ route('invoice.destroy', ['invoice' => $item->id]) }}"
                                                            method="post"
                                                            onsubmit="return confirm('هل أنت متأكد من حذف هذه الفاتورة؟')"
                                                            class=" modal-effect btn-sm edit-section-btn btn btn-danger w-100">
                                                            @csrf @method('DELETE')
                                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                                            <button type="submit"
                                                                class="btn-sm edit-section-btn btn btn-danger">حذف</button>
                                                        </form>
                                                    @endcan

                                                    @can('ارشفة فاتورة')
                                                        <form action="{{ route('invoice.destroy', ['invoice' => $item->id]) }}"
                                                            method="post"
                                                            onsubmit="return confirm('هل أنت متأكد من ارشفة هذه الفاتورة؟')"
                                                            class=" modal-effect btn-sm btn btn-primary w-100">
                                                            @csrf @method('DELETE')
                                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                                            <input type="hidden" name="id_page" value="2">
                                                            <button type="submit" class="btn-sm btn btn-primary">نقل الى
                                                                الارشيف</button>
                                                        </form>
                                                    @endcan



                                                    @can('تغير حالة الدفع ')
                                                        <a
                                                            href="{{ route('invoice.show', ['invoice' => $item->id]) }}"class=" modal-effect btn-sm edit-section-btn btn w-100 btn-warning">حالة
                                                            الدفع</a>
                                                    @endcan
                                                    @can('طباعة فاتورة')
                                                        <a
                                                            href="{{ url('print', ['invoice' => $item->id]) }}"class=" modal-effect btn-sm edit-section-btn btn w-100 btn-success">
                                                            طباعة </a>
                                                    @endcan


                                                </div>
                                            </div>
                                        </td>
                                    @endcanany

                                </tr>
                            @endforeach


                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <!--/div-->


    </div>
    <!-- row closed -->
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
