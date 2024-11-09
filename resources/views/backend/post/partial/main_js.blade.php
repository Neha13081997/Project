<script>
      $(document).ready(function() {
        renderStepForm("{{ route('admin.post.stepForm',1) }}",'step1Section',userObj.id);

        $('.navTab').on('click', function(e) {
            e.preventDefault();
    
            var $this = $(this);
    
            var tabRoute = $this.attr('href');
            var tabId = $this.attr('data-tab-type');
    
            renderStepForm(tabRoute,tabId,userObj.id);
    
        });

         //Back button
         $(document).on('click',".back-tab",function(e){
            e.preventDefault();

            var $this = $(this);

            var tabPrevRoute = $this.attr('data-prev-step-route');

            var tabNumber = $this.parents('form').attr('data-step-form-no');

            tabNumber = parseInt(tabNumber) - 1;
            
            var prevtabId = 'step'+tabNumber+'Section';

            renderStepForm(tabPrevRoute,prevtabId,userObj.id);

        });
       
        // Start Step Form 
        @if(isset($user_id))
                $(document).on('submit', '.step-form', function(e) {
                e.preventDefault();
               
                $(".submitBtn").attr('disabled', true);
                $('.validation-error-block').remove();

                $(".card-disabled").css('display', 'block');

                var formData = new FormData(this);
                var stepFormNo = $(this).attr('data-step-form-no');

                formData.append('step_no',stepFormNo);
                formData.append('post_id',userObj.id);
                formData.append('user_id',userObj.user_id);
               
                if(stepFormNo == 2){
                    formData.append('description',$('#hidden-input').val());
                }
               
                var actionUrl = "{{ route('admin.post.update', $post_id) }}";
                console.log(actionUrl);
                if(stepFormNo){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                   
                    $.ajax({
                        type: 'PUT',
                        url: actionUrl,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        data: formData,
                        // headers: {
                        //     'X-HTTP-Method-Override': 'PUT' // Spoof the HTTP method
                        // },
                        success: function (response) {
                            console.log(response);
                            $(".card-disabled").css('display', 'none');

                            $(".submitBtn").attr('disabled', false);
                            if(response.success) {
                                toasterAlert('success',response.message);

                                $('.step-form')[0].reset();

                                if(response.nextStep > 4){
                                    setTimeout(function() {
                                        window.location.href = "{{ route('admin.post.index') }}";
                                    }, 2000);
                                }

                                var $nextTab = $('.nav-link[data-step="'+response.nextStep+'"]');
                               
                                $nextTab.removeClass('disabled');
                                // Trigger the next tab
                                $nextTab.tab('show');

                                var tabRoute = $nextTab.attr('href');
                                var tabId = $nextTab.attr('data-tab-type');
                                
                                if(response.user_id){
                                    userObj.user_id = response.user_id;
                                    userObj.id = response.post_id;
                                    renderStepForm(tabRoute,tabId,userObj.user_id);
                                }else{
                                    renderStepForm(tabRoute,tabId);
                                }
                                
                            }
                        },
                        error: function (response) {
                            console.log(response);
                            $(".card-disabled").css('display', 'none');

                            $(".submitBtn").attr('disabled', false);
                            if(response.responseJSON.error_type == 'something_error'){
                                toasterAlert('error',response.responseJSON.error);
                            } else {
                                var errorLabelTitle = '';
                                $.each(response.responseJSON.errors, function (key, item) {
                                    errorLabelTitle = '<span class="validation-error-block">'+item[0]+'</sapn>';

                                    if (/^\w+\.\d+\.\w+$/.test(key)) {
                                        
                                        var keys = key.split('.');

                                        var transformedKey = keys[0]+'['+keys[1]+']'+'['+keys[2]+']';
                                        
                                        $(errorLabelTitle).insertAfter("input[name='"+transformedKey+"']");

                                    }else{
                                        $(errorLabelTitle).insertAfter("input[name='"+key+"']");
                                    }

                                });
                            }
                        },
                        complete: function(res){
                            $(".submitBtn").attr('disabled', false);
                        }
                    });
                }
                
            });

        @else

            $(document).on('submit', '.step-form', function(e) {
                e.preventDefault();
               
                $(".submitBtn").attr('disabled', true);

                $('.validation-error-block').remove();

                $(".card-disabled").css('display', 'block');

                var formData = new FormData(this);
              
                var stepFormNo = $(this).attr('data-step-form-no');
                formData.append('step_no',stepFormNo);
                formData.append('user_id',userObj.id);
                
                if(stepFormNo == 2){
                    formData.append('description',$('#hidden-input').val());
                }

                var actionUrl = "{{ route('admin.post.store') }}";
                
                if(stepFormNo){

                    $.ajax({
                        type: 'post',
                        url: actionUrl,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function (response) {
                            $(".card-disabled").css('display', 'none');

                            $(".submitBtn").attr('disabled', false);
                            if(response.success) {
                                toasterAlert('success',response.message);

                                $('.step-form')[0].reset();

                                if(response.nextStep > 4){
                                    setTimeout(function() {
                                        window.location.href = "{{ route('admin.post.index') }}";
                                    }, 2000);
                                }

                                var $nextTab = $('.nav-link[data-step="'+response.nextStep+'"]');

                                $nextTab.removeClass('disabled');
                                // Trigger the next tab
                                $nextTab.tab('show');

                                var tabRoute = $nextTab.attr('href');
                                var tabId = $nextTab.attr('data-tab-type');
                                
                                console.log(response);

                                if(response.user_id){
                                    userObj.id = response.user_id;

                                    renderStepForm(tabRoute,tabId,userObj.id);
                                }else{
                                    renderStepForm(tabRoute,tabId);
                                }
                            }
                        },
                        error: function (response) {
                            // console.log(response);
                            $(".card-disabled").css('display', 'none');

                            $(".submitBtn").attr('disabled', false);
                            if(response.responseJSON.error_type == 'something_error'){
                                toasterAlert('error',response.responseJSON.error);
                            } else {
                                var errorLabelTitle = '';
                                $.each(response.responseJSON.errors, function (key, item) {
                                    errorLabelTitle = '<span class="validation-error-block">'+item[0]+'</sapn>';

                                    if (/^\w+\.\d+\.\w+$/.test(key)) {
                                        
                                        var keys = key.split('.');

                                        var transformedKey = keys[0]+'['+keys[1]+']'+'['+keys[2]+']';
                                        
                                        $(errorLabelTitle).insertAfter("input[name='"+transformedKey+"']");

                                    }else if(key == 'password'){
                                        var elementItem = $("input[name='"+key+"']").parent();    
                                        $(errorLabelTitle).insertAfter(elementItem);

                                    }else if(key == 'total_employees'/*|| key == 'founding_year'*/){

                                        var elementItem = $("select[name='"+key+"']").siblings('span');    
                                        
                                        $(errorLabelTitle).insertAfter(elementItem);

                                    }else{
                                        $(errorLabelTitle).insertAfter("input[name='"+key+"']");
                                    }

                                });
                            }
                        },
                        complete: function(res){
                            $(".submitBtn").attr('disabled', false);
                        }
                    });
                }
                
            });

        @endif
        //End Step Form
    });

    // quill editor
    function initializeQuill(){
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
    function initializeDropify(){
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
    function renderStepForm(tabRoute,tabId,user_id=null){
        $('.tab-content').html('');
        
        $(".card-disabled").css('display', 'block');
    
        $.ajax({
            type: 'GET',
            url: tabRoute,
            data:{user_id:user_id},
            success: function(response) {
    
                $(".card-disabled").css('display', 'none');
                
                $('.tab-content').html(response.html);
    
                // Activate the tab pane after loading its content
                $('.navTab[data-tab-type="' + tabId + '"]').tab('show');
    
                // $(".select2").select2();
    
                // $('#founding_year').datepicker({
                //     format: "yyyy",
                //     viewMode: "years",
                //     minViewMode: "years",
                //     autoclose: true,
                //     endDate: new Date(),
                // });

                if ($('#snow-editor').length > 0) {
                    initializeQuill();
                }

                initializeDropify();
                
            },
            error: function(xhr, status, error) {
                // console.log(xhr,status,error);
                $(".card-disabled").css('display', 'none');
    
                if(xhr.responseJSON.error_type == 'something_error'){
                    toasterAlert('error',xhr.responseJSON.error);
                } 
            }
        });
    }

</script>