<script>
    $(function() {
        "use strict";
        $(".meta-keyward").select2({
            tags: true,
            placeholder: "Meta keyward",
            width: "100%"
        });
        $('.seo-page-checkbox').on('change', function() {

            if ($(this).is(":checked")) {
                $(".seo-content").show();
            } else {
                $(".seo-content").hide();
            }
        })
        $('.seo-page-checkbox').trigger('change');

        $(".add-element").draggable({
            helper: function(event, ui) {
                return $(this).clone().removeClass("add-element").addClass("draggable-element")
                    .appendTo(".active_widget_list")
                    .css({
                        "zIndex": 5,

                    }).show();
            },

            cursor: "move",
            containment: "document"
        });

        $(".active_widget_list").droppable({
            accept: ".add-element",
            drop: function(event, ui) {
                let slug = $(this).find('.ui-draggable').data('slug');
                let pageId = $(this).find('.ui-draggable').data('page-id');
                let widgetName = $(this).find('.ui-draggable').data('widget-name');
                let action = baseUrl + "/dashboard/pages/add-widget-page/" + slug;

                $.ajax({
                    url: action,
                    method: 'get',
                    data: {
                        pageId,
                        widgetName
                    },
                    success: function(data) {
                        if (data.status == true) {
                            $(".active_widget_list").append(`${data.content}`);
                            toastr["success"](`${data.message}`);
                        }
                        codeRichEditor();
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });


            }

        }).sortable({
            placeholder: "placeholder",
            cursor: "move",
            stop: function(event, ui) {
                let item = $(this).find('.accordion-item')
                let content = [];
                $.each(item, function(key, val) {
                    let slug = $(val).find('.widget-slug').val();
                    let code = $(val).data('code');
                    content.push({
                        [code]: slug
                    });
                })

                let pageId = $("#pageId").val();
                let action = baseUrl + "/dashboard/pages/widget-sorted-by-page";
                $.ajax({
                    url: action,
                    method: 'get',
                    data: {
                        pageId,
                        content
                    },
                    dataType: 'json',
                    success: function(data) {

                        console.log(data);
                        if (data.status == false) {
                            toastr["error"](`${data.message}`);
                        } else if (data.status == true) {
                            toastr["info"](`${data.message}`);

                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        });

        $(document).on('click', '.collapsed-action-btn', function(e) {

            e.preventDefault();
            let parent = $(this).closest('.accordion-item');;
            $(parent).find(".accordion-collapse").toggleClass("show");
        })

        $(document).on('submit', '.form', function(e) {

            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);
            let action = form.data('action');
            let lang=  $("#lang").val();
             formData.append('lang', lang);


            // console.log(formData);

            $.ajax({
                type: "POST",
                url: action,
                data: formData,
                dataType: "json",
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    console.log(data);

                    if (data.status == false) {
                        toastr["error"](`${data.message}`);
                    } else if (data.status == true) {
                        toastr["info"](`${data.message}`);
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            })

        })

        $(document).on('click', '.add-testimonials-btn', function(e) {
            e.preventDefault();
            let key1 = $(this).closest('form').find(".testimonials-area .content").length;
            let parent = $(this).closest('form').find(".testimonials-area");
            key1++;

            let html =
                `<div class="row align-items-center content">
                    <div class="col-sm-11">
                        <div class="row">
                            <div class="col-sm-3 mb-2">
                                <div class="form-inner">
                                    <label>{{ translate('Name') }}</label>
                                    <input type="text" class="username-input"
                                        placeholder="{{ translate('Enter Name') }}"
                                        name="content[0][testimonials][${key1}][testimonial_name]"
                                        >
                                </div>
                            </div>
                            <div class="col-sm-4 mb-2">
                                <div class="form-inner">
                                    <label> {{ translate('Designation') }}</label>
                                    <input type="text" class="username-input"
                                        placeholder="{{ translate('Enter Designation') }}"

                                        name="content[0][testimonials][${key1}][testimonial_designations]">

                                </div>
                            </div>

                            <div class="col-sm-5 mb-2">
                                <div class="form-inner">
                                    <label>{{ translate('Image') }}</label>
                                    <div class="d-flex align-items-center">
                                        <input type="file" class="username-input widget-image-upload"
                                            name="image" data-folder="/uploads/testimonials/">

                                        <input type="hidden"
                                            name="content[0][testimonials][${key1}][img]"
                                            id="old_file"
                                            >


                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2">
                                <div class="form-inner">
                                    <label>{{ translate('Description') }}</label>
                                    <textarea name="content[0][testimonials][${key1}][testimonial_descriptions]"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1 text-center">
                        <button class="remove-information remove text-danger border-0">
                            <i class="bi  bi-trash"></i>
                        </button>
                    </div>
                </div>`
            $('.testimonials-area').append(html);
        });

        $(document).on('click', '.add-fun-facts-btn', function(e) {

            e.preventDefault();

            let key2 = $(this).closest('form').find(".fun-facts-area .content").length;
            let parent = $(this).closest('form').find(".fun-facts-area");

            key2++;


            let html =
                `<div class="row align-items-center content">
                    <div class="col-sm-11">
                        <div class="row">
                            <div class="col-sm-4 mb-2">
                                <div class="form-inner">
                                    <label>{{ translate('Title') }}</label>
                                    <input type="text" class="username-input"
                                        placeholder="{{ translate('Enter Title') }}"
                                        name="content[0][fun_facts][${key2}][title]"
                                        value="{{ isset($fun_fact['title']) ? $fun_fact['title'] : '' }}">
                                </div>
                            </div>
                            <div class="col-sm-3 mb-2">
                                <div class="form-inner">
                                    <label> {{ translate('Number Count') }}</label>
                                    <input type="text" class="username-input"
                                        placeholder="{{ translate('Enter Number Count') }}"
                                        value="{{ isset($fun_fact['number_count']) ? $fun_fact['number_count'] : '' }}"
                                        name="content[0][fun_facts][${key2}][number_count]">

                                </div>
                            </div>

                            <div class="col-sm-5 mb-2">
                                <div class="form-inner">
                                    <label>{{ translate('Icon') }}</label>
                                    <div class="d-flex align-items-center">
                                        <input type="file" class="username-input widget-image-upload"
                                            name="image" data-folder="/uploads/fun_facts/">

                                        <input type="hidden"
                                            name="content[0][fun_facts][${key2}][img]"
                                            id="old_file"
                                            value="{{ isset($fun_fact['img']) ? $fun_fact['img'] : '' }}">

                                        @if (isset($fun_fact['img']))
                                            <div class="ms-2">
                                                <img height="50" width="auto"
                                                    src="{{ asset('uploads/fun_facts/' . $fun_fact['img']) }}"
                                                    alt="">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-1 text-center">
                        <button class="remove-information remove text-danger border-0">
                            <i class="bi  bi-trash"></i>
                        </button>
                    </div>
                </div>`

            $('.fun-facts-area').append(html);
        });

        $(document).on('click', '.add-features-btn', function(e) {

            e.preventDefault();

            let key3 = $(this).closest('form').find(".features-area .content").length;
            let parent = $(this).closest('form').find(".features-area");

            key3++;


            let html = `
                <div class="row align-items-center content">
                    <div class="col-sm-11">
                        <div class="row">
                            <div class="col-sm-5 mb-2">
                                <div class="form-inner">
                                    <label>{{ translate('Name') }}</label>
                                    <input type="text" class="username-input"
                                        placeholder="{{ translate('Enter Name') }}"
                                        name="content[0][features][${key3}][name]">
                                </div>
                            </div>
                            <div class="col-sm-7 mb-2">
                                <div class="form-inner">
                                    <label>{{ translate('Icon') }}</label>

                                    <div class="d-flex">
                                        <input type="file" class="username-input widget-image-upload"
                                            name="image" data-folder="/uploads/features/">
                                        <input type="hidden" name="content[0][features][${key3}][img]"
                                            id="old_file">

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2">
                                <div class="form-inner">
                                    <label>{{ translate('Short Description') }}</label>
                                    <textarea class="form-control" name="content[0][features][${key3}][descriptions]">   </textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-1 text-center">
                        <button class="remove-information remove text-danger border-0">
                            <i class="bi  bi-trash"></i>
                        </button>
                    </div>
                </div>`

            parent.append(html);
        });

        $(document).on('click', '.add-procedures-btn', function(e) {

            let key4 = $(this).closest('form').find(".procedures-area .content").length;
            let parent = $(this).closest('form').find(".procedures-area");

            key4++;
            e.preventDefault();

            let html =
                `<div class="row align-items-center content">
                    <div class="col-sm-11">
                        <div class="row">
                            <div class="col-sm-5 mb-2">
                                <div class="form-inner">

                                    <label>{{ translate('Name') }}</label>
                                    <input type="text" class="username-input"
                                        placeholder="{{ translate('Enter Name') }}"
                                        name="content[0][procedures][${key4}][name]"
                                        value="{{ isset($procedure['name']) ? $procedure['name'] : '' }}">
                                </div>
                            </div>
                            <div class="col-sm-7 mb-2">
                                <div class="form-inner">
                                    <label>{{ translate('Image') }}</label>
                                    <div class="d-flex align-items-center">
                                        <input type="file" class="username-input widget-image-upload"
                                            name="image" data-folder="/uploads/procedures/">

                                        <input type="hidden"
                                            name="content[0][procedures][${key4}][img]"
                                            id="old_file"
                                            value="{{ isset($procedure['img']) ? $procedure['img'] : '' }}">

                                        @if (isset($procedure['img']))
                                            <div class="ms-2">
                                                <img height="50" width="auto"
                                                    src="{{ asset('uploads/procedures/' . $procedure['img']) }}"
                                                    alt="">
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>


                            <div class="col-sm-5 mb-2">
                                <div class="form-inner">
                                    <label>{{ translate('Button Text') }}</label>
                                    <input type="text" class="username-input"
                                        placeholder="{{ translate('Enter Button Text') }}"
                                        name="content[0][procedures][${key4}][button_text]"
                                        value="{{ isset($procedure['button_text']) ? $procedure['button_text'] : '' }}">
                                </div>
                            </div>
                            <div class="col-sm-7 mb-2">
                                <div class="form-inner">
                                    <label>{{ translate('Button Url') }}</label>
                                    <input type="text" class="username-input"
                                        placeholder="{{ translate('Button Url') }}"
                                        name="content[0][procedures][${key4}][button_url]"
                                        value="{{ isset($procedure['button_url']) ? $procedure['button_url'] : '' }}">
                                </div>
                            </div>
                            <div class="col-sm-12 mb-4">
                                <div class="form-inner">
                                    <label>{{ translate('Description') }}</label>
                                    <textarea rows="6" name="content[0][procedures][${key4}][description]"> {!! isset($procedure['description']) ? clean($procedure['description']) : '' !!}  </textarea>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-sm-1 text-center">
                        <button class="remove-information remove text-danger border-0">
                            <i class="bi  bi-trash"></i>
                        </button>
                    </div>
                </div>`

            parent.append(html);
        });

        $(document).on('click', '.add-faqs-btn', function(e) {
            e.preventDefault();
            let key5 = $(this).closest('form').find(".faqs-area .content").length;
            let parent = $(this).closest('form').find(".faqs-area");
            key5++;

            let html =
                `<div class="row align-items-center content">
                    <div class="col-sm-11">
                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <div class="form-inner">
                                    <label>{{ translate('Question') }}</label>
                                    <input type="text" class="username-input"
                                        placeholder="{{ translate('Enter Question') }}"
                                        name="content[0][faqs][${key5}][title]"
                                        >
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2">
                                <div class="form-inner">
                                    <label>{{ translate('Answer') }}</label>
                                    <textarea class="summernote" name="content[0][faqs][${key5}][description]"> </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <button class="remove-information remove text-danger border-0">
                            <i class="bi  bi-trash"></i>
                        </button>
                    </div>
                </div>`
            parent.append(html);
            codeRichEditor();
        });

        $(document).on("click", '.remove-information', function(e) {
            e.preventDefault();
            let self = $(this).closest('.content').remove();

        })
        //status Inactive

        $(document).on('change', '.status-change', function(e) {
            e.preventDefault();
            let action = $(this).data('action');
            $.ajax({
                url: action,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    if (data.status === true) {
                        toastr["success"](`${data.message}`);

                    } else if (data.status == false) {
                        toastr["error"](`${data.message}`);
                    }

                },
                error: function(data) {
                    console.log(data);
                }
            });

        });
        $(document).on('click', '.delete-action', function(e) {
            e.preventDefault();
            let self = $(this);
            let id = self.data('id');
            let action = baseUrl + "/dashboard/pages/widget-delete-by-page/" + id;

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: action,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data) {
                            if (data.status === true) {
                                toastr["success"](`${data.message}`);
                                $(self).closest('.accordion-item').remove();

                            } else if (data.status == false) {
                                toastr["error"](`${data.message}`);
                            }

                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    Swal.fire(
                        'Cancelled',
                        'Your file is safe :)',
                        'error'
                    )
                }
            })

        });


        $(document).on('click', '.add-phone-btn', function(e) {
            e.preventDefault();

            let key = $(this).closest('form').find(".phone-area .content").length;
            let parent = $(this).closest('form').find(".phone-area");

            key++;

            let html =
                `<div class="row align-items-center content">
                    <div class="col-sm-11">
                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <div class="form-inner">
                                    <input type="text" class="username-input"
                                        placeholder="{{ translate('Enter Number') }}"
                                        name="content[0][phone][${key}][phone_number]"
                                        >
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-1">
                        <button class="remove-information remove text-danger border-0">
                            <i class="bi  bi-trash"></i>
                        </button>
                    </div>
                </div>`
            parent.append(html);


        })
        $(document).on('click', '.add-email-btn', function(e) {
            e.preventDefault();

            let key = $(this).closest('form').find(".email-area .content").length;
            let parent = $(this).closest('form').find(".email-area");

            key++;

            let html =
                `<div class="row align-items-center content">
                    <div class="col-sm-11">
                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <div class="form-inner">
                                    <input type="email" class="username-input"
                                        placeholder="{{ translate('Enter Email') }}"
                                        name="content[0][email][${key}][email_name]"
                                        >
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-1">
                        <button class="remove-information remove text-danger border-0">
                            <i class="bi  bi-trash"></i>
                        </button>
                    </div>
                </div>`
            parent.append(html);


        })



        $(document).on('click', '.add-working-btn', function(e) {
            e.preventDefault();
            let sliderkey = $(this).closest('form').find(".location-area.content").length;
            let parent = $(this).closest('form').find(".location-area");

            sliderkey++;

            let html = `<div class="row align-items-center content">
                <div class="col-sm-11">
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <div class="form-inner">
                                <label>{{ translate('Title') }}</label>
                                <input type="text" class="username-input"
                                    placeholder="{{ translate('Enter Main Title') }}"
                                    name="content[0][slider][${sliderkey}][title]"
                                    >
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="form-inner">
                                <label> {{ translate('Sub Title') }}</label>
                                <input type="text" class="username-input"
                                    placeholder="{{ translate('Enter Sub Title') }}"

                                    name="content[0][slider][${sliderkey}][sub_title]">

                            </div>
                        </div>

                        <div class="col-sm-4 mb-3">
                            <div class="form-inner">
                                <label>{{ translate('Button Text') }}</label>
                                <input type="text" class="username-input"
                                    placeholder="{{ translate('Enter Button Text') }}"
                                    name="content[0][slider][${sliderkey}][button_text]"
                                    >
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="form-inner">
                                <label>{{ translate('Button Url') }}</label>
                                <input type="text" class="username-input"
                                    placeholder="{{ translate('Button Url') }}"
                                    name="content[0][slider][${sliderkey}][button_url]"
                                    >
                            </div>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <div class="form-inner">
                                <label>{{ translate('Image') }}</label>
                                <div class="d-flex">
                                    <input type="file" class="username-input widget-image-upload" name="image" data-folder="/uploads/sliders/">
                                   <input type="hidden" name="content[0][slider][${sliderkey}][img]" id="old_file">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <div class="form-inner">
                                <label>{{ translate('Description') }}</label>
                                <textarea rows="4" name="content[0][slider][${sliderkey}][description]"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-1 text-center">
                    <button class="remove-information remove text-danger border-0">
                        <i class="bi  bi-trash"></i>
                    </button>
                </div>
            </div>`

            $('.location-area').append(html);
        });




        //=================== widget  image  upload ===============

        $(document).on("change", '.widget-image-upload', function() {
            widgetOption(this);

        });

        // ===================  themOption  read file ====================

        function widgetOption(self) {

            if (self.files && self.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {

                    let action = "{{ route('pages.image.upload') }}";
                    let old_file = $(self).parent().find("#old_file").val();
                    let folder = $(self).data('folder');

                    $.ajax({
                        url: action,
                        type: 'POST',
                        data: {
                            'image': e.target.result,
                            'old_file': old_file,
                            'folder': folder
                        },
                        dataType: "json",
                        success: function(data) {
                            // console.log(data);
                            if (data.status === true) {
                                $(self).parent().find("#old_file").val(data.image_name);
                            }
                        },
                        error: function(data) {
                            // console.log(data);
                        }
                    })


                };

                reader.readAsDataURL(self.files[0]);
            }
        }

        $(document).on("mouseenter", '.note-editor', function(event) {
            $(".active_widget_list").sortable("disable");
        });
        $(document).on("mouseleave", '.note-editor', function(event) {
            $(".active_widget_list").sortable("enable");
        });

        function codeRichEditor() {

            $(".summernote").summernote({

                placeholder: "Write here..",
                height: 320,
                toolbar: [
                    ['style', ['style']],
                    ['fontsize', ['fontsize']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['hr','link']],
                ],
                lineHeights: ['0.5', '1.0', '1.1', '1.2', '1.3', '1.4'],
                fontSizes: ['8', '9', '10', '11', '12', '13', '14', '15', '16', '18', '24', '36', '48',
                    '64', '82', '150'
                ],
                styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5','h6'],
            })

        }
    }(jQuery));
</script>
