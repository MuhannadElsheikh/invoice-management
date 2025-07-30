@extends('layouts.master')
@section('title', 'تعديل فاتورة')

@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تغير حالة فاتورة</span>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ url('update_stats') }}/{{ $stuts->id }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col">
                                <input type="hidden" name="id" value="{{ $stuts->id }}">
                                <label for="invoice_number">رقم الفاتورة</label>
                                <input type="text" class="form-control" id="invoice_number" name="invoice_number"
                                    required value="{{ $stuts->invoice_number }}"readonly>
                            </div>

                            <div class="col">
                                <label for="invoice_date">تاريخ الفاتورة</label>
                                <input type="text" class="form-control datepicker" id="invoice_date" name="invoice_date"
                                    placeholder="YYYY-MM-DD" readonly value="{{ $stuts->invoice_date }}">
                            </div>

                            <div class="col">
                                <label for="due_date">تاريخ الاستحقاق</label>
                                <input type="text" class="form-control datepicker" id="due_date" name="due_date"
                                    placeholder="YYYY-MM-DD" value="{{ $stuts->due_date }}" readonly>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="section_id">القسم</label>
                                <select name="section_id" id="section_id" class="form-control select2" readonly>
                                    @foreach ($section as $sectio)
                                        <option value="{{ $sectio->id }}"
                                            {{ $stuts->section_id == $sectio->id ? 'selected' : '' }}>
                                            {{ $sectio->section_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label for="product">المنتج</label>
                                <select name="product" id="product" class="form-control " value="{{ $stuts->product }}"
                                    readonly>

                                </select>
                            </div>

                            <div class="col">
                                <label for="amount_collection">مبلغ التحصيل</label>
                                <input type="text" class="form-control" id="amount_collection" name="amount_collection"
                                    value="{{ $stuts->amount_collection }}"
                                    oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/(\..*?)\..*/, '$1');"
                                    readonly>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="amount_commission">مبلغ العمولة</label>
                                <input type="text" class="form-control" id="amount_commission"
                                    name="amount_commission"value="{{ $stuts->amount_commission }}"
                                    oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/(\..*?)\..*/, '$1');"
                                    readonly>
                            </div>

                            <div class="col">
                                <label for="discount">الخصم</label>
                                <input type="text" class="form-control" id="discount" name="discount"
                                    value="{{ $stuts->discount }}"
                                    oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/(\..*?)\..*/, '$1');"readonly>
                            </div>

                            <div class="col">
                                <label for="rate_vat">نسبة ضريبة القيمة المضافة</label>
                                <select class="form-control" id="rate_vat" name="rate_vat" readonly>
                                    <option value="{{ $stuts->rate_vat }}">{{ $stuts->rate_vat }}% </option>
                                    <option value="5">5%</option>
                                    <option value="10">10%</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="value_vat">قيمة الضريبة المضافة</label>
                                <input type="text" class="form-control" id="value_vat" name="value_vat" readonly>
                            </div>

                            <div class="col">
                                <label for="total">الإجمالي شامل الضريبة</label>
                                <input type="text" class="form-control" id="total" name="total" readonly>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="note">ملاحظات</label>
                                <textarea class="form-control" id="note" name="note" rows="3"readonly></textarea>
                            </div>
                        </div>


                        <div class="row mt-3">
                            <div class="col">
                                <label for="status"> حالة الدفع</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="{{ $stuts->status }}">{{ $stuts->status }} </option>
                                    <option value="مدفوعة ">مدفوعة </option>
                                    <option value="مدغوعة جزئيا">مدغوعة جزئيا</option>
                                </select>
                            </div>

                            <div class="col">
                                <label for="bayment_date">تاريخ تغيير الحالة</label>
                                <input type="text" class="form-control datepicker" id="bayment_date"
                                    name="bayment_date" placeholder="YYYY-MM-DD" required
                                    value="{{ $stuts->bayment_date }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-primary">حفظ البيانات</button>
                        </div>
                    </form>
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
            $('.datepicker').flatpickr({
                dateFormat: 'Y-m-d'
            });

            // Calculate VAT and total
            $('#rate_vat, #amount_commission, #discount').on('input', function() {
                calculateVAT();
            });
        });
        $('select[name="section_id"]').on('change', function() {
            var SectionId = $(this).val();

            if (SectionId) {
                $.ajax({
                    url: "{{ URL::to('section') }}/" + SectionId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log(data); // تحقق من البيانات المستلمة
                        if (data.message) {
                            console.log(data.message); // في حالة وجود رسالة خطأ من الـ Controller
                        } else {
                            $('select[name="product"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="product"]').append(
                                    '<option value="' + key + '">' + value + '</option>'
                                );
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error: " + error); // تحقق من أي أخطاء في الاتصال
                    }
                });

            }
        });



        function calculateVAT() {
            var discount = parseFloat($('#discount').val()) || 0;
            var amount_commission = parseFloat($('#amount_commission').val()) || 0;
            var rate_vat = parseFloat($('#rate_vat').val()) || 0;

            if (amount_commission < discount) {
                alert('الخصم لا يمكن أن يكون أكبر من مبلغ العمولة');
                return;
            }

            var amount_after_discount = amount_commission - discount;
            var vat_value = (amount_after_discount * rate_vat) / 100;
            var total = amount_after_discount + vat_value;

            $('#value_vat').val(vat_value.toFixed(2));
            $('#total').val(total.toFixed(2));
        }
    </script>
@endsection
