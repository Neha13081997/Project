<script>
    $(document).ready(function() {

        renderStepForm("{{ route('admin.post.stepForm',1) }}", 'step1Section', userObj.post_id);

        $('.navTab').on('click', function(e) {
            e.preventDefault();

            var $this = $(this);

            var tabRoute = $this.attr('href');
            var tabId = $this.attr('data-tab-type');

            renderStepForm(tabRoute, tabId, userObj.post_id);
        });

        //Back button
        $(document).on('click', ".back-tab", function(e) {
            e.preventDefault();

            var $this = $(this);

            var tabPrevRoute = $this.attr('data-prev-step-route');
            var post_id = $this.attr('data-post-id');
            var tabNumber = $this.parents('form').attr('data-step-form-no');

            tabNumber = parseInt(tabNumber) - 1;

            var prevtabId = 'step' + tabNumber + 'Section';

            console.log(tabPrevRoute);
            console.log(post_id);
            renderStepForm(tabPrevRoute, prevtabId, post_id);
        });

        $(document).on('submit', '.step-form', function(e) {
            e.preventDefault();

            $(".submitBtn").attr('disabled', true);
            $('.validation-error-block').remove();
            $(".card-disabled").css('display', 'block');

            var formData = new FormData(this);
            var stepFormNo = $(this).attr('data-step-form-no');
            formData.append('step_no', stepFormNo);

            // Check if `post_id` exists in userObj
            if (userObj.post_id) {
                formData.append('post_id', userObj.post_id);
            }

            // Append description for stepFormNo 2
            if (stepFormNo == 2) {
                formData.append('description', $('#hidden-input').val());
            }

            // Determine action URL and method type based on post_id presence
            var actionUrl = userObj.post_id ?
                "{{ route('admin.post.update', ':id') }}".replace(':id', userObj.post_id) :
                "{{ route('admin.post.store') }}";
            console.log(actionUrl);
            var methodType = userObj.post_id ? 'PUT' : 'POST';

            // Set up AJAX headers, including CSRF token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    ...(methodType === 'PUT' && {
                        'X-HTTP-Method-Override': 'PUT'
                    })
                }
            });

            // Send AJAX request
            $.ajax({
                type: 'POST', // Use POST, but override to PUT if necessary
                url: actionUrl,
                dataType: 'json',
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    handleSuccessResponse(response);
                },
                error: function(response) {
                    handleErrorResponse(response);
                },
                complete: function() {
                    $(".submitBtn").attr('disabled', false);
                    $(".card-disabled").css('display', 'none');
                }
            });
        });

        function handleSuccessResponse(response) {
            if (response.success) {
                toasterAlert('success', response.message);
                $('.step-form')[0].reset();

                if (response.nextStep > 4) {
                    setTimeout(function() {
                        window.location.href = "{{ route('admin.post.index') }}";
                    }, 2000);
                }

                var $nextTab = $('.nav-link[data-step="' + response.nextStep + '"]');
                $nextTab.removeClass('disabled').tab('show');

                var tabRoute = $nextTab.attr('href');
                var tabId = $nextTab.attr('data-tab-type');

                if (response.post_id) {
                    userObj.post_id = response.post_id;
                }

                renderStepForm(tabRoute, tabId, userObj.post_id);
            }
        }

        function handleErrorResponse(response) {
            if (response.responseJSON.error_type === 'something_error') {
                toasterAlert('error', response.responseJSON.error);
            } else {
                $.each(response.responseJSON.errors, function(key, item) {
                    var errorLabel = `<span class="validation-error-block">${item[0]}</span>`;
                    if (/^\w+\.\d+\.\w+$/.test(key)) {
                        var keys = key.split('.');
                        var transformedKey = `${keys[0]}[${keys[1]}][${keys[2]}]`;
                        $(errorLabel).insertAfter(`input[name='${transformedKey}']`);
                    } else {
                        $(errorLabel).insertAfter(`input[name='${key}']`);
                    }
                });
            }
        }


        // Start Step Form 
        // @if(isset($post_id))
        //         $(document).on('submit', '.step-form', function(e) {
        //         e.preventDefault();

        //         $(".submitBtn").attr('disabled', true);
        //         $('.validation-error-block').remove();

        //         $(".card-disabled").css('display', 'block');

        //         var formData = new FormData(this);
        //         var stepFormNo = $(this).attr('data-step-form-no');
        //         formData.append('step_no',stepFormNo);
        //         formData.append('post_id',userObj.post_id);

        //         if(stepFormNo == 2){
        //             formData.append('description',$('#hidden-input').val());
        //         }
        //         var actionUrl = "{{ route('admin.post.update', $post_id) }}";
        //         if(stepFormNo){
        //             $.ajaxSetup({
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                 }
        //             });

        //             $.ajax({
        //                 type: 'Post',
        //                 url: actionUrl,
        //                 dataType: 'json',
        //                 contentType: false,
        //                 processData: false,
        //                 data: formData,
        //                 headers: {
        //                     'X-HTTP-Method-Override': 'PUT' // Spoof the HTTP method
        //                 },
        //                 success: function (response) {
        //                     console.log(response);
        //                     $(".card-disabled").css('display', 'none');

        //                     $(".submitBtn").attr('disabled', false);
        //                     if(response.success) {
        //                         toasterAlert('success',response.message);

        //                         $('.step-form')[0].reset();

        //                         if(response.nextStep > 4){
        //                             setTimeout(function() {
        //                                 window.location.href = "{{ route('admin.post.index') }}";
        //                             }, 2000);
        //                         }

        //                         var $nextTab = $('.nav-link[data-step="'+response.nextStep+'"]');

        //                         $nextTab.removeClass('disabled');
        //                         // Trigger the next tab
        //                         $nextTab.tab('show');

        //                         var tabRoute = $nextTab.attr('href');
        //                         var tabId = $nextTab.attr('data-tab-type');

        //                         if(response.post_id){
        //                             userObj.post_id = response.post_id;
        //                             renderStepForm(tabRoute,tabId,userObj.post_id);
        //                         }else{
        //                             renderStepForm(tabRoute,tabId);
        //                         }

        //                     }
        //                 },
        //                 error: function (response) {
        //                     console.log(response);
        //                     $(".card-disabled").css('display', 'none');

        //                     $(".submitBtn").attr('disabled', false);
        //                     if(response.responseJSON.error_type == 'something_error'){
        //                         toasterAlert('error',response.responseJSON.error);
        //                     } else {
        //                         var errorLabelTitle = '';
        //                         $.each(response.responseJSON.errors, function (key, item) {
        //                             errorLabelTitle = '<span class="validation-error-block">'+item[0]+'</sapn>';

        //                             if (/^\w+\.\d+\.\w+$/.test(key)) {

        //                                 var keys = key.split('.');

        //                                 var transformedKey = keys[0]+'['+keys[1]+']'+'['+keys[2]+']';

        //                                 $(errorLabelTitle).insertAfter("input[name='"+transformedKey+"']");

        //                             }else{
        //                                 $(errorLabelTitle).insertAfter("input[name='"+key+"']");
        //                             }

        //                         });
        //                     }
        //                 },
        //                 complete: function(res){
        //                     $(".submitBtn").attr('disabled', false);
        //                 }
        //             });
        //         }

        //     });

        // @else

        //     $(document).on('submit', '.step-form', function(e) {
        //         e.preventDefault();

        //         $(".submitBtn").attr('disabled', true);

        //         $('.validation-error-block').remove();

        //         $(".card-disabled").css('display', 'block');

        //         var formData = new FormData(this);

        //         var stepFormNo = $(this).attr('data-step-form-no');
        //         formData.append('step_no',stepFormNo);
        //         formData.append('post_id',userObj.post_id);
        //         if(stepFormNo == 2){
        //             formData.append('description',$('#hidden-input').val());
        //         }
        //         var actionUrl = "{{ route('admin.post.store') }}";

        //         if(stepFormNo){
        //             $.ajax({
        //                 type: 'post',
        //                 url: actionUrl,
        //                 dataType: 'json',
        //                 contentType: false,
        //                 processData: false,
        //                 data: formData,
        //                 success: function (response) {
        //                     $(".card-disabled").css('display', 'none');

        //                     $(".submitBtn").attr('disabled', false);
        //                     if(response.success) {
        //                         toasterAlert('success',response.message);

        //                         $('.step-form')[0].reset();

        //                         if(response.nextStep > 4){
        //                             setTimeout(function() {
        //                                 window.location.href = "{{ route('admin.post.index') }}";
        //                             }, 2000);
        //                         }

        //                         var $nextTab = $('.nav-link[data-step="'+response.nextStep+'"]');

        //                         $nextTab.removeClass('disabled');
        //                         // Trigger the next tab
        //                         $nextTab.tab('show');

        //                         var tabRoute = $nextTab.attr('href');
        //                         var tabId = $nextTab.attr('data-tab-type');

        //                         console.log(response);

        //                         if(response.post_id){
        //                             userObj.post_id = response.post_id;

        //                             renderStepForm(tabRoute,tabId,userObj.post_id);
        //                         }else{
        //                             renderStepForm(tabRoute,tabId);
        //                         }
        //                     }
        //                 },
        //                 error: function (response) {
        //                     // console.log(response);
        //                     $(".card-disabled").css('display', 'none');

        //                     $(".submitBtn").attr('disabled', false);
        //                     if(response.responseJSON.error_type == 'something_error'){
        //                         toasterAlert('error',response.responseJSON.error);
        //                     } else {
        //                         var errorLabelTitle = '';
        //                         $.each(response.responseJSON.errors, function (key, item) {
        //                             errorLabelTitle = '<span class="validation-error-block">'+item[0]+'</sapn>';

        //                             if (/^\w+\.\d+\.\w+$/.test(key)) {

        //                                 var keys = key.split('.');

        //                                 var transformedKey = keys[0]+'['+keys[1]+']'+'['+keys[2]+']';

        //                                 $(errorLabelTitle).insertAfter("input[name='"+transformedKey+"']");

        //                             }else{
        //                                 $(errorLabelTitle).insertAfter("input[name='"+key+"']");
        //                             }

        //                         });
        //                     }
        //                 },
        //                 complete: function(res){
        //                     $(".submitBtn").attr('disabled', false);
        //                 }
        //             });
        //         }

        //     });

        // @endif
        //End Step Form
    });

    // quill editor
    function initializeQuill() {
        var quill = new Quill("#snow-editor", {
            theme: "snow",
            modules: {
                toolbar: [
                    [{
                        font: []
                    }, {
                        size: []
                    }],
                    ["bold", "italic", "underline", "strike"],
                    [{
                        header: [!1, 1, 2, 3, 4, 5, 6]
                    }, "blockquote", "code-block"],
                    [{
                        list: "ordered"
                    }, {
                        list: "bullet"
                    }, {
                        indent: "-1"
                    }, {
                        indent: "+1"
                    }],
                    ["direction", {
                        align: []
                    }],
                    ["clean"]
                ]
            }
        });

        quill.on('text-change', function() {
            var content = quill.root.innerHTML;
            $('#hidden-input').val(content);
        });
    }

    // initialize dropify
    function initializeDropify() {
        $('.dropify').dropify();
        $('.dropify-errors-container').remove();
        $('.dropify-wrapper').find('.dropify-clear').hide();
        /*$('.dropify-clear').click(function(e) {
            e.preventDefault();
            var elementName = $(this).siblings('input[type=file]').attr('id');
            if (elementName == 'company-logo') {
                
            }
        });*/

    }
    // get the form
    function renderStepForm(tabRoute, tabId, post_id = null) {
        console.log(post_id);
        console.log(tabRoute);
        $('.tab-content').html('');

        $(".card-disabled").css('display', 'block');

        $.ajax({
            type: 'GET',
            url: tabRoute,
            data: {
                post_id: post_id
            },
            success: function(response) {

                $(".card-disabled").css('display', 'none');

                $('.tab-content').html(response.html);

                // Activate the tab pane after loading its content
                $('.navTab[data-tab-type="' + tabId + '"]').tab('show');

                if ($('#snow-editor').length > 0) {
                    initializeQuill();
                }

                initializeDropify();

            },
            error: function(xhr, status, error) {
                // console.log(xhr,status,error);
                $(".card-disabled").css('display', 'none');

                if (xhr.responseJSON.error_type == 'something_error') {
                    toasterAlert('error', xhr.responseJSON.error);
                }
            }
        });
    }
</script>