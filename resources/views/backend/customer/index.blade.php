@extends('layouts.admin')
@section('title', 'User')

@section('custom_css')
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
<!-- Daterangepicker css -->
<link href="{{ asset('backend/vendor/daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('main-content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">HIPL</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
                <a href="{{ route('admin.customer.create') }}" class="btn btn-primary mb-1">Add</a>
            </div>
            <h4 class="page-title">Customer</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3">
                        <!-- Date Range -->
                        <div class="mb-3">
                            <label class="form-label">Date Range</label>
                            <input type="text" class="form-control date" id="daterange" name="daterange" data-toggle="date-picker" data-cancel-class="btn-warning">
                        </div>
                        <!-- <div class="mb-2"><button class="btn btn-primary" type="submit">@lang('global.submit')</button></div> -->
                    </div>
                </div>
                <div class="table-responsive-sm">
                    {{$dataTable->table(['class' => 'table mb-0', 'style' => 'width:100%;'])}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_js')
<!-- Datatable -->
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

<!-- Daterangepicker Plugin js -->
<script src="{{ asset('backend/vendor/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('backend/vendor/daterangepicker/daterangepicker.js') }}"></script>


<script>
    @can('customer_delete')
    $(document).on("click", ".deleteCusBtn", function() {
        var url = $(this).data('href');
        Swal.fire({
                title: "{{ trans('global.areYouSure') }}",
                text: "{{ trans('global.onceClickedRecordDeleted') }}",
                icon: "warning",
                showDenyButton: true,
                //   showCancelButton: true,  
                confirmButtonText: "{{ trans('global.swl_confirm_button_text') }}",
                denyButtonText: "{{ trans('global.swl_deny_button_text') }}",
            })
            .then(function(result) {
                if (result.isConfirmed) {
                    $('.loader-div').show();
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        dataType: 'json',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                $('.loader-div').hide();

                                $('#customer-table').DataTable().ajax.reload(null, false);
                                toasterAlert('success', response.message);
                            } else {
                                toasterAlert('error', response.error);
                                $('.loader-div').hide();
                            }
                        },
                        error: function(res) {
                            toasterAlert('error', res.responseJSON.error);
                        }
                    });
                }
            });
    });
    @endcan
</script>

<script>
    $(function() {
        var datatableUrl = "{{ route('admin.customer.index') }}";
        $('input[name="daterange"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            params.start_date = start.format('YYYY-MM-DD');
            params.end_date = end.format('YYYY-MM-DD');
        });
        var params = {};
        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
            $('#customer-table').DataTable().ajax.url(datatableUrl+'?'+$.param(params)).draw();
        });
    });
</script>
{!! $dataTable->scripts() !!}
@endsection