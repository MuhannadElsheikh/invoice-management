@extends('layouts.master')
@section('title', 'تفاصيل الفاتورة ')


@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">قائمة الفواير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تفاضيل الفاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened --> @if (session('success'))
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
    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">
            <div class="card" id="basic-alert">
                <div class="card-body">

                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-1">
                                <div class=" tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                            <li class="nav-item"><a href="#tab1" class="nav-link active"
                                                    data-toggle="tab">معلومات الفاتورة </a></li>
                                            <li class="nav-item"><a href="#tab2" class="nav-link" data-toggle="tab">
                                                    حلات الدفع</a></li>
                                            <li class="nav-item"><a href="#tab3" class="nav-link" data-toggle="tab">
                                                    المرفقات</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">رقم الفاتورة </th>
                                                        <td>{{ $invoice->invoice_number }}</td>
                                                        <th scope="row">تاريخ الاصدار </th>
                                                        <td>{{ $invoice->invoice_date }}</td>
                                                        <th scope="row"> تاريخ الاستحقاق </th>
                                                        <td>{{ $invoice->due_date }}</td>
                                                        <th scope="row"> القسم </th>
                                                        <td>{{ $invoice->section->section_name }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th scope="row"> المنتج</th>
                                                        <td>{{ $invoice->product }}</td>
                                                        <th scope="row"> مبلغ التحصيل </th>
                                                        <td>{{ $invoice->amount_collection }}</td>
                                                        <th scope="row"> مبلغ العمولة </th>
                                                        <td>{{ $invoice->amount_commission }}</td>
                                                        <th scope="row"> الخصم </th>
                                                        <td>{{ $invoice->discount }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th scope="row"> نسبة الخصم</th>
                                                        <td>{{ $invoice->rate_vat }}%</td>
                                                        <th scope="row"> قيمة الخصم </th>
                                                        <td>{{ $invoice->value_vat }}</td>
                                                        <th scope="row"> الإجمالي </th>
                                                        <td>{{ $invoice->total }}</td>
                                                        <th scope="row"> الحالة الحالية </th>
                                                        @if ($invoice->value_status === 1)
                                                            <td><span
                                                                    class=" badge-success badge-pill badge">{{ $invoice->status }}</span>
                                                            </td>
                                                        @elseif ($invoice->value_status === 2)
                                                            <td><span
                                                                    class=" badge-danger badge-pill badge">{{ $invoice->status }}</span>
                                                            </td>
                                                        @else
                                                            <td><span
                                                                    class=" badge-warnig badge-pill badge">{{ $invoice->status }}</span>
                                                            </td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">ملاحظات </th>
                                                        <td>{{ $invoice->note }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="tab2">
                                            <table class="table table-striped ">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>رقم الفاتورة </th>
                                                        <th>تاريخ الانشاء</th>
                                                        <th>حالة الدفع</th>
                                                        <th>المستخدم</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($detalis as $item)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $item->invoice_number }}</td>
                                                            <td>{{ $item->created_at }}</td>
                                                            @if ($item->value_status === 1)
                                                                <td><span
                                                                        class=" badge-success badge-pill badge">{{ $invoice->status }}</span>
                                                                </td>
                                                            @elseif ($item->value_status === 2)
                                                                <td><span
                                                                        class=" badge-danger badge-pill badge">{{ $invoice->status }}</span>
                                                                </td>
                                                            @else
                                                                <td><span
                                                                        class=" badge-warning badge-pill badge">{{ $invoice->status }}</span>
                                                                </td>
                                                            @endif
                                                            <td>{{ $item->user }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="tab3">
                                            <div class="row mt-3">
                                                <div class="col">
                                                    <label>المرفقات</label> @can('اضافة مرفق ')
                                                    <form action="{{url('invoicedetalls')}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="invoice_id"
                                                            value="{{ $item->id }}">
                                                        <input type="hidden" name="invoice_number"
                                                            value="{{ $item->invoice_number }}">
                                                        <input type="file" name="pic" class="dropify"
                                                            accept=".pdf,.jpeg,.jpg,.png" data-height="70">
                                                        <input type="submit" value="رفع مرفق "
                                                            class="btn btn-outline-info btn-sm">
                                                    </form>     @endcan
                                                    <p class="text-danger mt-2">* صيغة المرفق: pdf, jpeg, jpg, png</p>
                                                </div>
                                            </div>
                                            <table class="table table-striped ">
                                                <thead>
                                                    <tr>
                                                        <th># </th>
                                                        <th>رقم الفاتورة </th>
                                                        <th>اسم الملف</th>
                                                        <th>العملبات </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($attchments as $x)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $x->invoice_number }}</td>
                                                            <td>{{ $x->file_name }}</td>
                                                            <td><a href="{{ url('view_file') }}/{{ $x->invoice_number }}/{{ $x->file_name }}"
                                                                    class="btn btn-outline-success btn-sm"
                                                                    role="button">عرض</a>
                                                                <a href="{{ url('print_file') }}/{{ $x->invoice_number }}/{{ $x->file_name }}"
                                                                    class="btn btn-outline-info btn-sm" role="button">تحميل
                                                                </a>
                                                                @can( 'حذف  مرفق ')
                                                                <button class=" btn-sm btn btn-outline-danger"
                                                                    data-toggle="modal"
                                                                    data-file_name="{{ $x->file_name }}"
                                                                    data-invoice_number="{{ $x->invoice_number }}"
                                                                    data-file_id="{{ $x->id }}"
                                                                    data-target="#delete_file"
                                                                    data-bs-target="#deleteModal">
                                                                    حذف
                                                                </button>    @endcan
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="delete_file" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog " role="document">
                                <div class="modal-content modal-content-demo ">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalLabel ">تاكيد الحذف </h6>
                                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <form action="{{ url('detalis') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <p class="text-center">
                                            <h5 style="color: red">هل انت متأكد من حذف المرفق</h5>
                                            </p>
                                            <input type="hidden" name="file_id" id="file_id" value="">
                                            <input type="hidden" name="file_name" id="file_name" value="">
                                            <input type="hidden" name="invoice_number" id="invoice_number"
                                                value="">

                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn  btn-danger" type="submit">حذف</button>
                                            <button class="btn  btn-default" data-dismiss="modal">إلغاء</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main-content closed -->
    @endsection
    @section('js')
        <!-- Internal Select2 js-->
        <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>

        <!--- Tabs JS-->
        <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
        <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

        <script>
            $('#delete_file').on('show.bs.modal', function(e) {

                var button = $(e.relatedTarget);
                var file_id = button.data('file_id')
                var invoice_number = button.data('invoice_number')
                var file_name = button.data('file_name')
                var modal = $(this)


                modal.find('.modal-body #file_id').val(file_id);
                modal.find('.modal-body #invoice_number').val(invoice_number);
                modal.find('.modal-body #file_name').val(file_name);
            })
        </script>
    @endsection
