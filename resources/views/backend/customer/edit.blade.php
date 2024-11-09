@extends('layouts.admin')
@section('title', 'Update Customer')

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
                    <li class="breadcrumb-item active">Update</li>
                </ol>
            </div>
            <h4 class="page-title">Update Customer</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form name="editCustomerForm" id="editCustomerForm" method="post">
                    @csrf
                    @method('PUT')
                    @include('backend.customer._form')
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">@lang('global.pleaseSelect')</option>
                                <option value="1" {{ $user->status == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $user->status == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <ul class="list-inline wizard mb-0">
                        <li class="next list-inline-item float-end">
                            <button type="submit" class="btn btn-primary submitBtn">@lang('global.update')</button>
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
    $(document).on('submit', '#editCustomerForm', function(e) {
        e.preventDefault();

        $(".submitBtn").attr('disabled', true);

        $('.validation-error-block').remove();

        $(".loader-div").css('display', 'block');

        var formData = new FormData(this);

        var actionUrl = "{{ route('admin.customer.update',$user->id) }}";


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
                    $('#editCustomerForm')[0].reset();

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