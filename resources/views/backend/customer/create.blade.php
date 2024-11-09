@extends('layouts.admin')
@section('title', 'Create Customer')

@section('custom_css')
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
                    <li class="breadcrumb-item"><a href="{{ route('admin.customer.index') }}">Customer</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
            <h4 class="page-title">Create Customer</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form name="addCustomerForm" id="addCustomerForm" method="post">
                    @csrf
                    @include('backend.customer._form')
                    </div>
                    <ul class="list-inline wizard mb-0">
                        <li class="next list-inline-item float-end">
                            <button type="submit" class="btn btn-primary submitBtn">@lang('global.save')</button>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('custom_js')
<script>
    $(document).on('submit', '#addCustomerForm', function(e) {
        e.preventDefault();

        $(".submitBtn").attr('disabled', true);

        $('.validation-error-block').remove();

        $(".loader-div").css('display', 'block');

        var formData = new FormData(this);

        var actionUrl = "{{ route('admin.customer.store') }}";

        $.ajax({
            type: 'post',
            url: actionUrl,
            dataType: 'json',
            contentType: false,
            processData: false,
            data: formData,
            success: function(response) {
                $(".loader-div").css('display', 'none');

                $(".submitBtn").attr('disabled', false);
                if (response.success) {

                    $('#addCustomerForm')[0].reset();

                    toasterAlert('success', response.message);

                    setTimeout(function() {
                        window.location.href = "{{ route('admin.customer.index') }}";
                    }, 2000);
                }
            },
            error: function(response) {
                // console.log(response);
                $(".loader-div").css('display', 'none');

                $(".submitBtn").attr('disabled', false);
                if (response.responseJSON.error_type == 'something_error') {
                    toasterAlert('error', response.responseJSON.error);
                } else {
                    var errorLabelTitle = '';
                    $.each(response.responseJSON.errors, function(key, item) {
                        errorLabelTitle = '<span class="validation-error-block">' + item[0] + '</sapn>';

                        if (/^\w+\.\d+\.\w+$/.test(key)) {

                            var keys = key.split('.');

                            var transformedKey = keys[0] + '[' + keys[1] + ']' + '[' + keys[2] + ']';

                            // $(errorLabelTitle).insertAfter("input[name='"+transformedKey+"']");
                            // Target both input and select elements
                            if ($("input[name='" + transformedKey + "']").length) {
                                $(errorLabelTitle).insertAfter("input[name='" + transformedKey + "']");
                            } else if ($("select[name='" + transformedKey + "']").length) {
                                $(errorLabelTitle).insertAfter("select[name='" + transformedKey + "']");
                            }

                        } else {
                            // $(errorLabelTitle).insertAfter("input[name='"+key+"']");
                            // Target both input and select elements
                            if ($("input[name='" + key + "']").length) {
                                $(errorLabelTitle).insertAfter("input[name='" + key + "']");
                            } else if ($("select[name='" + key + "']").length) {
                                $(errorLabelTitle).insertAfter("select[name='" + key + "']");
                            }
                        }

                    });
                }
            },
            complete: function(res) {
                $(".submitBtn").attr('disabled', false);
            }
        });


    });
</script>
@endsection