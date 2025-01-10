(function ($) {
    "use strict";

    Dropzone.autoDiscover = false;
    // Csrf Token Loaded
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // language change
    if ($('#lang-change').length > 0) {
        $('#lang-change .dropdown-menu li a').each(function () {
            $(this).on('click', function (e) {
                e.preventDefault();
                var $this = $(this);
                var locale = $this.data('flag');
                $.post('/changelanguage', { locale: locale }, function (res) {
                    console.log(res);
                    location.reload();
                    if (res.output == 'success') {
                        cuteToast({
                            type: "success",
                            message: res.message,
                            img: successAlertImage,
                            timer: 1500
                        });

                    }
                });

            });
        });
    }


    // Product Review status change

    $('.flexSwitchCheckProductReview').on("click", function () {
        var reviewId = $(this).data('product-review-id');
        var status = $(this).data('activations-status');

        changeReviewStatus(status, reviewId);
    });

    function changeReviewStatus(status, reviewId) {
        if (status) {
            console.log(status);
            $.ajax({
                type: 'POST',
                url: "/dashboard/products/review/change/status",
                data: {
                    status: status,
                    reviewId: reviewId
                },
                dataType: 'json',
                cache: false,
                success: (res) => {
                    console.log(res);
                    if (res.output == 'success') {
                        if (res.statusId == 1) {
                            $("#flexSwitchCheckProductReview" + res.revId).prop("checked", true);
                            $("#flexSwitchCheckProductReview" + res.revId).data('activations-status', res.statusId);

                            cuteToast({
                                type: "success",
                                message: res.message,
                                img: successAlertImage,
                                timer: 1500
                            });

                        } else {
                            $("#flexSwitchCheckProductReview" + res.revId).removeAttr('checked');
                            $("#flexSwitchCheckProductReview" + res.revId).data('activations-status', res.statusId);

                            cuteToast({
                                type: "success",
                                message: res.message,
                                img: successAlertImage,
                                timer: 1500
                            });
                        }
                    }
                },
                error: function (xhr) {
                    alert("Something Wrong")
                }
            });
        }
    }

    //admin reply modal
    $('.staticBackdropReview').on("click", function () {
        var review_id = $(this).data('review_id');
        var product_id = $(this).data('product_id');
        $('#review_id').val(review_id);
        $('#product_id').val(product_id);
    });
    // category status change

    $('.flexSwitchCheck').on("click", function () {
        var categoryId = $(this).data('category-id');
        var status = $(this).data('activations-status');
        changePublishingStatus(status, categoryId);
    });

    function changePublishingStatus(status, categoryId) {
        if (status) {
            $.ajax({
                type: 'POST',
                url: "/dashboard/category/change/status",
                data: {
                    status: status,
                    categoryId: categoryId
                },
                dataType: 'json',
                cache: false,
                success: (res) => {

                    if (res.output == 'success') {
                        if (res.statusId == 1) {
                            $("#flexSwitchCheck" + res.catId).prop("checked", true);
                            $("#flexSwitchCheck" + res.catId).data('activations-status', res.statusId);
                            var html = `<button class="eg-btn green-light--btn">` + res.active + `</button>`;
                            $('#statusBlock' + res.catId).html(html);

                            cuteToast({
                                type: "success",
                                message: res.message,
                                img: successAlertImage,
                                timer: 1500
                            });

                        } else {
                            $("#flexSwitchCheck" + res.catId).removeAttr('checked');
                            $("#flexSwitchCheck" + res.catId).data('activations-status', res.statusId);
                            var html = `<button class="eg-btn red-light--btn">` + res.inactive + `</button>`;
                            $('#statusBlock' + res.catId).html(html);

                            cuteToast({
                                type: "success",
                                message: res.message,
                                img: successAlertImage,
                                timer: 1500
                            });
                        }
                    }
                },
                error: function (xhr) {
                    alert("Something Wrong")
                }
            });
        }
    }

    // Products status change

    $('.flexSwitchCheckProduct').on("click", function () {
        var productId = $(this).data('product-id');
        var status = $(this).data('activations-status');
        changePublishingStatusProduct(status, productId);
    });

    function changePublishingStatusProduct(status, productId) {
        if (status) {
            $.ajax({
                type: 'POST',
                url: "/dashboard/products/change/status",
                data: {
                    status: status,
                    productId: productId
                },
                dataType: 'json',
                cache: false,
                success: (res) => {

                    if (res.output == 'success') {
                        if (res.statusId == 1) {
                            $("#flexSwitchCheckProduct" + res.proId).prop("checked", true);
                            $("#flexSwitchCheckProduct" + res.proId).data('activations-status', res.statusId);

                            cuteToast({
                                type: "success",
                                message: res.message,
                                img: successAlertImage,
                                timer: 1500
                            });

                        } else {
                            $("#flexSwitchCheckProduct" + res.proId).removeAttr('checked');
                            $("#flexSwitchCheckProduct" + res.proId).data('activations-status', res.statusId);

                            cuteToast({
                                type: "success",
                                message: res.message,
                                img: successAlertImage,
                                timer: 1500
                            });
                        }
                    }
                },
                error: function (xhr) {
                    alert("Something Wrong")
                }
            });
        }
    }



    // Delete Confirm by sweetalert

    $('.show_confirm').on("click", function (event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
            title: `Are you sure you want to delete this record?`,
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
    });

    // Shipped and Deliver Confirm
    $('.shipped_delivered_confirm').on("click", function (event) {
        var form = $(this).closest("form");
        var status = $(this).data("status");
        event.preventDefault();
        if (status == 2 || status == 4) {
            swal({
                title: `Are you sure you want to shipped this record?`,
                text: "If you shipped this, it will be gone shipped.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        } else if (status == 8) {
            swal({
                title: `Are you sure you want to delivered this record?`,
                text: "If you shipped this, it will be gone delivered.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        }
    });
    // Winner Confirm by sweetalert

    $('.winner_confirm').on("click", function (event) {
        var form = $(this).closest("form");
        var status = $(this).data("status");

        event.preventDefault();
        if (status == 2) {
            swal({
                title: `Are you sure you want to winner return this bid?`,
                text: "If you return winner this, it will be delivered the auctions.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        } else {
            swal({
                title: `Are you sure you want to winner this bid?`,
                text: "If you winner this, it will be delivered the auctions.",
                icon: "success",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        }
    });

    // Bid Closed Confirm by sweetalert

    $('.bids_close').on("click", function (event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
            title: `Are you sure you want to closed this bid?`,
            text: "If you close this, it will be inactive the bid options.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
    });

    // Select 2 with image for language code
    $(document).ready(function () {
        $("#language_code").select2({
            templateResult: formatOptions
        });
    });

    function formatOptions(lang) {
        if (!lang.id) { return lang.text; }

        console.log(lang.element.value);

        var $lang = $(
            '<span ><img sytle="display: inline-block;" src="/assets/img/flags/' + lang.element.value.toLowerCase() + '.png"  /> ' + lang.text + '</span>'
        );

        return $lang;
    }

    // Language status change
    // Csrf Token Loaded

    $('.languageSwitchChange').on("change", function () {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var languageId = $(this).data('language-id');

        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/dashboard/languages/change/status',
            data: { 'status': status, 'languageId': languageId },
            success: function (res) {
                if (res.output == 'success') {
                    if (res.statusId == 1) {
                        cuteToast({
                            type: "success",
                            message: "Active RTL",
                            img: successAlertImage,
                            timer: 1500
                        });

                    } else {
                        cuteToast({
                            type: "success",
                            message: "Deactive RTL",
                            img: successAlertImage,
                            timer: 1500
                        });
                    }
                }
            },
            error: function (xhr) {
                alert("Something Wrong")
            }
        });
    });

    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                var htmlPreview =
                    '<img width="100" src="' + e.target.result + '" />' +
                    '<p>' + input.files[0].name + '</p>';
                var wrapperZone = $(input).parent();
                var previewZone = $(input).parent().parent().find('.preview-zone');
                var boxZone = $(input).parent().parent().find('.preview-zone').find('.box').find('.box-body');

                wrapperZone.removeClass('dragover');
                previewZone.removeClass('hidden');
                boxZone.empty();
                boxZone.append(htmlPreview);
                $('.file-upload .remove-preview').show();
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function reset(e) {
        e.wrap('<form>').closest('form').get(0).reset();
        e.unwrap();
    }

    $(".featues_image").on('change', function () {
        readFile(this);
    });

    $('.file-upload .dropzone-wrapper').on('dragover', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('dragover');
    });

    $('.file-upload .dropzone-wrapper').on('dragleave', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('dragover');
    });

    $('.file-upload .remove-preview').on('click', function () {
        var boxZone = $(this).parents('.file-upload .preview-zone').find('.box-body');
        var previewZone = $(this).parents('.file-upload .preview-zone');
        var dropzone = $(this).parents('.file-upload').find('.featues_image');
        boxZone.empty();
        previewZone.addClass('hidden');
        reset(dropzone);
        $('.file-upload .remove-preview').hide();
    });


    $(document).ready(function () {
        if (window.File && window.FileList && window.FileReader) {
            $("#files").on("change", function (e) {
                var files = e.target.files,
                    filesLength = files.length;
                var boxZone = $('.gallery-preview-zone').find('.box').find('.box-body');
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i]
                    var fileReader = new FileReader();
                    fileReader.onload = (function (e) {
                        var file = e.target;
                        $("<div class=\"img-thumb-wrapper card shadow\">" +
                            "<span class=\"remove\">X</span>" +
                            "<img class=\"img-thumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                            "</div>").appendTo(boxZone);
                        $(".remove").click(function () {
                            $(this).parent(".img-thumb-wrapper").remove();
                        });

                    });
                    fileReader.readAsDataURL(f);
                }
                console.log(files);
            });
        } else {
            alert("Your browser doesn't support to File API")
        }
    });



    $(".pricing-area-schedule").hide();


    $(document).on('change', '.auction_type_select', function (e) {

        e.preventDefault();
        let type = $(this).val();
        $(".pricing-area-schedule").show();

        if (type == 2) {
            $(".auction_type").hide();
            $(".direct_type").show();
            $('.direct_type .price').attr('required', 'required');
            $('.auction_type input').removeAttr('required');
            $('.auction_type select').removeAttr('required');
            $('.auction_schedule').hide();

        } else if (type == 1) {
            $(".direct_type").hide();
            $(".auction_type").show();
            $('.direct_type .price').removeAttr('required');
            $('.auction_type input').attr('required', 'required');
            $('.auction_type select').attr('required', 'required');
            $('.auction_schedule').show();
        }

        console.log($(this).val());


    })



    $(document).on('change', '.auction_schedule_type', function (e) {
        e.preventDefault();
        let type = $(this).val();
        if (type == 2) {
            $(".schedule_start_date").hide();
            $('.schedule_start_date #datepicker').removeAttr('required');
        } else if (type == 1) {
            $(".schedule_start_date").show();
            $('.schedule_start_date #datepicker').attr('required', 'required');
        }
    });

    let productType = $("#product_sale_type").val();
    if (productType !== "") {
        $(".auction_type_select").trigger('change');
        $(".auction_schedule_type").trigger('change');
    }


    // Get State by dropdown
    $('.country_id').on('change', function () {
        var country_id = this.value;
        $(".state_id").empty();
        if (country_id) {
            $.ajax({
                url: "/location/get/state",
                type: "POST",
                data: {
                    country_id: country_id,
                },
                dataType: 'json',
                success: function (res) {
                    $('.state_id').html('<option value="">' + res.option + '</option>');
                    $.each(res.states, function (key, value) {
                        $(".state_id").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                }
            });
        }
    });

    // Get City by dropdown
    $('.state_id').on('change', function () {
        var state_id = this.value;
        $(".city_id").empty();
        if (state_id) {
            $.ajax({
                url: "/location/get/city",
                type: "POST",
                data: {
                    state_id: state_id,
                },
                dataType: 'json',
                success: function (res) {
                    $('.city_id').html('<option value="">' + res.option + '</option>');
                    $.each(res.city, function (key, value) {
                        $(".city_id").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                }
            });
        }
    });


    // merchant status change

    $('.merchantstatus').on("click", function () {
        var merchantId = $(this).data('merchant-id');
        var status = $(this).data('activations-status');
        changeMerchantStatus(status, merchantId);
    });

    function changeMerchantStatus(status, merchantId) {
        if (status) {
            $.ajax({
                type: 'POST',
                url: "/dashboard/merchant/change/status",
                data: {
                    status: status,
                    merchantId: merchantId
                },
                dataType: 'json',
                cache: false,
                success: (res) => {

                    if (res.output == 'success') {
                        if (res.statusId == 1) {
                            $("#flexSwitchMerchant" + res.merId).prop("checked", true);
                            $("#flexSwitchMerchant" + res.merId).data('activations-status', res.statusId);
                            var html = `<button class="eg-btn green-light--btn">` + res.active + `</button>`;
                            $('#statusMerchant' + res.merId).html(html);

                            cuteToast({
                                type: "success",
                                message: res.message,
                                img: successAlertImage,
                                timer: 1500
                            });

                        } else {
                            $("#flexSwitchMerchant" + res.merId).removeAttr('checked');
                            $("#flexSwitchMerchant" + res.merId).data('activations-status', res.statusId);
                            var html = `<button class="eg-btn red-light--btn">` + res.deactive + `</button>`;
                            $('#statusMerchant' + res.merId).html(html);

                            cuteToast({
                                type: "success",
                                message: res.message,
                                img: successAlertImage,
                                timer: 1500
                            });
                        }
                    }
                },
                error: function (xhr) {
                    alert("Something Wrong")
                }
            });
        }
    }


    $('.addRow').on('click', function () {
        addRow();
    });
    function addRow() {
        var row = '<div class="row payment_info">' +
            '<div class="col-lg-6">' +
            '<div class="form-inner">' +
            '<input type="hidden" name="merchant_payment_id[]" value=""></input>' +
            '<label>Type <span class="text-danger">*</span></label>' +
            '<select name="payment_type[]" class="js-example-basic-single payment_type" >' +
            '<option value="">Select Option</option>' +
            '<option value="1">Bank</option>' +
            '<option value="2">Mobile Banking</option>' +
            '<option value="3">Paypal</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-6 select_bank" style="display:none;">' +
            '<div class="form-inner">' +
            '<label>Bank Name</label>' +
            '<input type="text" class="bank_name" name="bank_name[]" placeholder="Enter Bank Name">' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-6 select_bank" style="display:none;">' +
            '<div class="form-inner">' +
            '<label>Bank Account Name</label>' +
            '<input type="text" class="bank_ac_name" name="bank_ac_name[]" placeholder="Enter Bank Account Name">' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-6 select_bank" style="display:none;">' +
            '<div class="form-inner">' +
            '<label>Bank Account Number</label>' +
            '<input type="text" name="bank_ac_number[]" class="bank_ac_number username-input" placeholder="Enter Bank Account Number">' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-6 select_bank" style="display:none;">' +
            '<div class="form-inner mb-35 ">' +
            '<label>Bank Routing Number</label>' +
            '<input type="text" class="bank_routing_number" name="bank_routing_number[]" placeholder="Enter Bank Routing Number">' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-6 select_mobile" style="display:none;">' +
            '<div class="form-inner mb-35 ">' +
            '<label>Mobile Banking Name</label>' +
            '<input type="text" class="mobile_banking_name" name="mobile_banking_name[]" placeholder="Enter Mobile Banking Name">' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-6 select_mobile" style="display:none;">' +
            '<div class="form-inner mb-35 ">' +
            '<label>Mobile Number</label>' +
            '<input type="text" class="mobile_banking_number" name="mobile_banking_number[]" placeholder="Enter Mobile Number">' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-6 select_paypal" style="display:none;">' +
            '<div class="form-inner mb-35 ">' +
            '<label>Paypal Name</label>' +
            '<input type="text" class="paypal_name" name="paypal_name[]" placeholder="Enter Paypal Name">' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-6 select_paypal" style="display:none;">' +
            '<div class="form-inner mb-35 ">' +
            '<label>Paypal Username</label>' +
            '<input type="text" class="paypal_username" name="paypal_username[]" placeholder="Enter Paypal Username">' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-6 select_paypal" style="display:none;">' +
            '<div class="form-inner mb-35 ">' +
            '<label>Paypal Email</label>' +
            '<input type="email" class="paypal_email" name="paypal_email[]" placeholder="Enter Paypal Email">' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-6 select_paypal" style="display:none;">' +
            '<div class="form-inner mb-35 ">' +
            '<label>Paypal Mobile Number</label>' +
            '<input type="text" class="paypal_mobile_number" name="paypal_mobile_number[]" placeholder="Enter Paypal Mobile Number">' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-12" >' +
            '<button style="float: right;" type="button" class="removeRow eg-btn btn--red rounded px-3">' +
            '<i class="bi bi-x"></i>' +
            '</button>' +
            '</div>' +
            '</div>';
        $('#bankDetailsMainContent').append(row);
        $('.js-example-basic-single').select2({
            width: '100%'
        });
    };
    $('#bankDetailsMainContent').on('click', '.removeRow', function () {
        var l = $('#bankDetailsMainContent .payment_info').length;
        if (l == 1) {
            alert('You can not remove last one');
        } else {
            $(this).parent().parent().remove();
        }
    });

    $('#bankDetailsMainContent').delegate('.payment_type', 'change', function () {
        var rows = $(this).parent().parent().parent();
        var payment_type = rows.find('.payment_type :selected').val();
        if (payment_type == 1) {
            rows.find('.select_bank').show();
            rows.find('.select_mobile').hide();
            rows.find('.select_paypal').hide();
        } else if (payment_type == 2) {
            rows.find('.select_bank').hide();
            rows.find('.select_mobile').show();
            rows.find('.select_paypal').hide();
        } else if (payment_type == 3) {
            rows.find('.select_bank').hide();
            rows.find('.select_mobile').hide();
            rows.find('.select_paypal').show();
        } else {
            rows.find('.select_bank').hide();
            rows.find('.select_mobile').hide();
            rows.find('.select_paypal').hide();
        }
    });

    // merchant status change

    $('.customerstatus').on("click", function () {
        var customerId = $(this).data('customer-id');
        var status = $(this).data('activations-status');
        changeCustomerStatus(status, customerId);
    });

    function changeCustomerStatus(status, customerId) {
        if (status) {
            $.ajax({
                type: 'POST',
                url: "/dashboard/customer/change/status",
                data: {
                    status: status,
                    customerId: customerId
                },
                dataType: 'json',
                cache: false,
                success: (res) => {

                    if (res.output == 'success') {
                        if (res.statusId == 1) {
                            $("#flexSwitchCustomer" + res.cusId).prop("checked", true);
                            $("#flexSwitchCustomer" + res.cusId).data('activations-status', res.statusId);
                            var html = `<button class="eg-btn green-light--btn">` + res.active + `</button>`;
                            $('#statusCustomer' + res.cusId).html(html);

                            cuteToast({
                                type: "success",
                                message: res.message,
                                img: successAlertImage,
                                timer: 1500
                            });

                        } else {
                            $("#flexSwitchCustomer" + res.cusId).removeAttr('checked');
                            $("#flexSwitchCustomer" + res.cusId).data('activations-status', res.statusId);
                            var html = `<button class="eg-btn red-light--btn">` + res.deactive + `</button>`;
                            $('#statusCustomer' + res.cusId).html(html);

                            cuteToast({
                                type: "success",
                                message: res.message,
                                img: successAlertImage,
                                timer: 1500
                            });
                        }
                    }
                },
                error: function (xhr) {
                    alert("Something Wrong")
                }
            });
        }
    }



    // Page status change

    $('.flexSwitchCheckPage').on("click", function () {
        var pageId = $(this).data('page-id');
        var status = $(this).data('activations-status');
        changePublishingStatusPage(status, pageId);
    });

    function changePublishingStatusPage(status, pageId) {
        if (status) {
            $.ajax({
                type: 'POST',
                url: "/dashboard/pages/change/status",
                data: {
                    status: status,
                    pageId: pageId
                },
                dataType: 'json',
                cache: false,
                success: (res) => {
                    console.log(res);
                    if (res.output == 'success') {
                        if (res.statusId == 1) {
                            $("#flexSwitchCheckPage" + res.pageId).prop("checked", true);
                            $("#flexSwitchCheckPage" + res.pageId).data('activations-status', res.statusId);
                            var html = `<button class="eg-btn green-light--btn">` + res.active + `</button>`;
                            $('#statusBlockPage' + res.pageId).html(html);

                            cuteToast({
                                type: "success",
                                message: res.message,
                                img: successAlertImage,
                                timer: 1500
                            });

                        } else {
                            $("#flexSwitchCheckPage" + res.pageId).removeAttr('checked');
                            $("#flexSwitchCheckPage" + res.pageId).data('activations-status', res.statusId);
                            var html = `<button class="eg-btn red-light--btn">` + res.inactive + `</button>`;
                            $('#statusBlockPage' + res.pageId).html(html);

                            cuteToast({
                                type: "success",
                                message: res.message,
                                img: successAlertImage,
                                timer: 1500
                            });
                        }
                    }
                },
                error: function (xhr) {
                    alert("Something Wrong")
                }
            });
        }
    }

    // Blog Category status change

    $('.flexSwitchCheckBlogCat').on("click", function () {
        var categoryId = $(this).data('category-id');
        var status = $(this).data('activations-status');
        changePublishingStatusBlogCat(status, categoryId);
    });

    function changePublishingStatusBlogCat(status, categoryId) {
        if (status) {
            $.ajax({
                type: 'POST',
                url: "/dashboard/blogs/category/change/status",
                data: {
                    status: status,
                    categoryId: categoryId
                },
                dataType: 'json',
                cache: false,
                success: (res) => {
                    console.log(res);
                    if (res.output == 'success') {
                        if (res.statusId == 1) {
                            $("#flexSwitchCheckBlogCat" + res.catId).prop("checked", true);
                            $("#flexSwitchCheckBlogCat" + res.catId).data('activations-status', res.statusId);
                            var html = `<button class="eg-btn green-light--btn">` + res.active + `</button>`;
                            $('#statusBlockBlogCat' + res.catId).html(html);

                            cuteToast({
                                type: "success",
                                message: res.message,
                                img: successAlertImage,
                                timer: 1500
                            });

                        } else {
                            $("#flexSwitchCheckBlogCat" + res.catId).removeAttr('checked');
                            $("#flexSwitchCheckBlogCat" + res.catId).data('activations-status', res.statusId);
                            var html = `<button class="eg-btn red-light--btn">` + res.inactive + `</button>`;
                            $('#statusBlockBlogCat' + res.catId).html(html);

                            cuteToast({
                                type: "success",
                                message: res.message,
                                img: successAlertImage,
                                timer: 1500
                            });
                        }
                    }
                },
                error: function (xhr) {
                    alert("Something Wrong")
                }
            });
        }
    }


    // Blog status change

    $('.flexSwitchCheckBlog').on("click", function () {
        var blogId = $(this).data('blog-id');
        var status = $(this).data('activations-status');
        changePublishingStatusBlog(status, blogId);
    });

    function changePublishingStatusBlog(status, blogId) {
        if (status) {
            $.ajax({
                type: 'POST',
                url: "/dashboard/blogs/change/status",
                data: {
                    status: status,
                    blogId: blogId
                },
                dataType: 'json',
                cache: false,
                success: (res) => {
                    console.log(res);
                    if (res.output == 'success') {
                        if (res.statusId == 1) {
                            $("#flexSwitchCheckBlog" + res.blogId).prop("checked", true);
                            $("#flexSwitchCheckBlog" + res.blogId).data('activations-status', res.statusId);

                            cuteToast({
                                type: "success",
                                message: res.message,
                                img: successAlertImage,
                                timer: 1500
                            });

                        } else {
                            $("#flexSwitchCheckBlog" + res.blogId).removeAttr('checked');
                            $("#flexSwitchCheckBlog" + res.blogId).data('activations-status', res.statusId);

                            cuteToast({
                                type: "success",
                                message: res.message,
                                img: successAlertImage,
                                timer: 1500
                            });
                        }
                    }
                },
                error: function (xhr) {
                    alert("Something Wrong")
                }
            });
        }
    }

    // product gallery remove
    $('.exist_remove').on('click', function () {
        var dataId = $(this).attr("data-gellery_id");
        if (dataId) {
            $.ajax({
                type: 'POST',
                url: "/dashboard/products/gallery/remove",
                data: {
                    dataId: dataId
                },
                dataType: 'json',
                cache: false,
                success: (res) => {
                    if (res.output == 'success') {
                        $("#gallery" + res.dataId).hide();

                        cuteToast({
                            type: "success",
                            message: res.message,
                            img: successAlertImage,
                            timer: 1500
                        });

                    }
                },
                error: function (xhr) {
                    alert("Something Wrong")
                }
            });
        }
    });

    // specification row remove
    $('.removeRow').on('click', function () {
        var dataId = $(this).attr("data-spece_id");
        if (dataId) {
            $.ajax({
                type: 'POST',
                url: "/dashboard/products/specification/remove",
                data: {
                    dataId: dataId
                },
                dataType: 'json',
                cache: false,
                success: (res) => {
                    if (res.output == 'success') {
                        // $("#gallery"+ res.dataId).hide();

                        cuteToast({
                            type: "success",
                            message: res.message,
                            img: successAlertImage,
                            timer: 1500
                        });

                    }
                },
                error: function (xhr) {
                    alert("Something Wrong")
                }
            });
        }
    });

    // Blog Category status change

    $('.flexSwitchCheckMethod').on("click", function () {
        var methodId = $(this).data('method-id');
        var status = $(this).data('activations-status');
        changePublishingStatusMethod(status, methodId);
    });

    function changePublishingStatusMethod(status, methodId) {
        if (status) {
            $.ajax({
                type: 'POST',
                url: "/dashboard/payment/methods/change/status",
                data: {
                    status: status,
                    methodId: methodId
                },
                dataType: 'json',
                cache: false,
                success: (res) => {
                    console.log(res);
                    if (res.output == 'success') {
                        if (res.statusId == 1) {
                            $("#flexSwitchCheckMethod" + res.metId).prop("checked", true);
                            $("#flexSwitchCheckMethod" + res.metId).data('activations-status', res.statusId);

                            cuteToast({
                                type: "success",
                                message: res.message,
                                img: successAlertImage,
                                timer: 1500
                            });

                        } else {
                            $("#flexSwitchCheckMethod" + res.metId).removeAttr('checked');
                            $("#flexSwitchCheckMethod" + res.metId).data('activations-status', res.statusId);

                            cuteToast({
                                type: "success",
                                message: res.message,
                                img: successAlertImage,
                                timer: 1500
                            });
                        }
                    }
                },
                error: function (xhr) {
                    alert("Something Wrong")
                }
            });
        }
    }

    $(document).ready(function () {
        $('.status_id').on('change', function () {
            $(this).closest('form').submit();
        });

        $('.method_mode').on('change', function () {
            var method_mode = $(this).val();
            if (method_mode == 1) {
                $(this).val(2);
            } else {
                $(this).val(1);
            }
        });
    });

    $('.editPaymentMethods').on('click', function () {
        var id = $(this).attr("data-method_id");

        $.ajax({
            type: "POST",
            url: "/dashboard/payment/methods/edit",
            data: {
                id: id
            },
            dataType: 'json',
            success: function (res) {
                $('#paymentMethodsModal').modal('show');
                console.log(res.default_logo);
                $('#method_id').val(res.id);
                $('#method_name').val(res.method_name);
                $('#method_mode').val(res.mode);
                if (res.mode == 1) {
                    $('#method_mode').prop('checked', false);
                    $('#method_mode_btn').text('Sandbox');
                    $('#method_mode_btn').removeClass('green-light--btn');
                    $('#method_mode_btn').addClass('orange-light--btn');
                } else {
                    $('#method_mode').prop('checked', true);
                    $('#method_mode_btn').text('Live');
                    $('#method_mode_btn').removeClass('orange-light--btn');
                    $('#method_mode_btn').addClass('green-light--btn');
                }
                if (res.logo) {
                    $('#payment_method_logo').attr('src', '/uploads/payment_methods/' + res.logo);
                } else {
                    $('#payment_method_logo').attr('src', '/uploads/payment_methods/' + res.default_logo);
                }
                if (res.id == 1) {
                    $('#method_key').prop('required', false);
                    $('#method_secret').prop('required', false);
                    $('#method_key_div').hide();
                    $('#method_secret_div').hide();
                    $('#method_mode_div').hide();
                    $('#method_mode_div').removeClass('d-flex');
                    $('#method_key').val('');
                    $('#method_secret').val('');

                    $('#conversion_currency_rate').prop('required', false);
                    $('#method_conversion_rate_div').hide();
                    $('#conversion_currency_rate').val('');
                    $('#conversion_currency_id').val('');
                } else {
                    if (res.id == 4) {
                        $('#conversion_currency_label').text('Rs1 = ');
                        $('#conversion_currency_id').val(28);
                    } else {
                        $('#conversion_currency_id').val(1);
                        $('#conversion_currency_label').text('$1 = ');
                    }
                    $('#method_conversion_rate_div').show();
                    $('#conversion_currency_rate').prop('required', true);
                    $('#conversion_currency_rate').val(res.conversion_currency_rate);
                    $('#method_key_div').show();
                    $('#method_secret_div').show();
                    $('#method_mode_div').addClass('d-flex');
                    $('#method_mode_div').show();
                    $("#method_key").prop('required', true);
                    $("#method_secret").prop('required', true);
                    $('#method_key').val(res.key);
                    $('#method_secret').val(res.secret);
                }
            }
        });
    });

    // meta keyward
    $(".meta-keyward").select2({
        tags: true,
        placeholder: "Meta keyward",
        width: "100%"
    });

    // allow seo option
    $('.seo-page-checkbox').on('change', function () {

        if ($(this).is(":checked")) {
            $(".seo-content").show();
        } else {
            $(".seo-content").hide();
        }
    })

    $('.seo-page-checkbox').trigger('change');

}(jQuery));


function printDiv() {
    var printContents = document.getElementById('printArea').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}
// invoice pdf create
function createPDF(order_id) {
    var element = document.getElementById('printArea');
    html2pdf(element, {
        margin: 0.5,
        padding: 0,
        filename: 'invoice' + order_id + '.pdf',
        image: { type: 'jpeg', quality: 1 },
        html2canvas: { scale: 1, logging: true },
        jsPDF: { unit: 'in', format: 'A4', orientation: 'P' },
        class: createPDF
    });
};
