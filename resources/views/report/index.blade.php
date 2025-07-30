@extends('layouts.master')
@section('title', ' تقارير الفواتير ')
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css" rel="stylesheet">
@endsection

@section('css')
    <!--  Owl-carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">التقارير </h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/تقارير الفواتير </span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <form action="{{ route('search_invoices') }}" method="post" role="search" autocapitalize="off">
                    @csrf

                    <div class="col-lg-3">
                        <label class="rdiobox">
                            <input checked type="radio" name="radio" value="1" id="type_div"><span>بحث بنوع
                                الفاتورة </span>
                        </label>
                    </div>

                    <div class="col-lg-3">
                        <label class="rdiobox">
                            <input type="radio" name="radio" value="2"><span>بحث برقم الفاتورة </span>
                        </label>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 mg-t-20 mg-lg-t-0" id="type">
                            <p class="mg-b-10">تجديد نوع الفاتورة </p><select class="form-control select2 " name="type"
                                required>
                                <option value="{{ $type ?? 'حدد نوع الفواتير ' }}" selected>
                                    {{ $type ?? 'حدد نوع الفواتير ' }}
                                </option>
                                <option value="">الكل</option>
                                <option value="مدفوعة">الفواتير المدفوعة </option>
                                <option value="غير مدفوعة">الفواتير غير المدفوعة </option>
                                <option value="مدغوعة جزئيا">الفواتير المدفوعة جزئيا</option>
                            </select>
                        </div>

                        <div class="col-lg-3 mg-t-20 mg-lg-t-0" id="invoice_namber">
                            <p class="mg-b-10">البحث برقم الفاتورة </p>
                            <input type="text" name="invoice_namber" id="invoice_namber" class="form-control">
                        </div>

                        <div class="col-lg-3" id="start_at">
                            <label for="">من تاريخ </label>
                            <div class="input-group">
                                <div class="input-group-prepend">

                                </div><input type="text" class="form-control fc-datepicker" value="{{ $start_at ?? '' }}"
                                    name="start_at" placeholder="YYYY-MM-DD">
                            </div>
                        </div>

                        <div class="col-lg-3" id="end_at">
                            <label for="">إلى تاريخ </label>
                            <div class="input-group">
                                <div class="input-group-prepend">

                                </div><input type="text" class="form-control fc-datepicker" value="{{ $end_at ?? '' }}"
                                    name="end_at" placeholder="YYYY-MM-DD">
                            </div>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-sm-1 col-md-1">
                            <button class="btn btn-primary btn-block">ابحث</button>
                        </div>
                    </div><br>
                </form>






                <div class="card-body">
                    <div class="table-responsive">
                        @if (isset($invoices))
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



                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                        @elseif(isset($message))
                        <p class="text-danger">{{ $message }}</p>

                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize datepicker
            $('.fc-datepicker').flatpickr({
                dateFormat: 'Y-m-d'
            });

            //الازرار
            $('#invoice_namber').hide();

            $('input[type="radio"]').click(function() {
                if ($(this).attr('id') == 'type_div') {
                    $('#invoice_namber').hide();
                    $('#type').show();
                    $('#start_at').show();
                    $('#end_at').show();
                } else {
                    $('#invoice_namber').show();
                    $('#type').hide();
                    $('#start_at').hide();
                    $('#end_at').hide();
                }
            })
        });
    </script>
@endsection
