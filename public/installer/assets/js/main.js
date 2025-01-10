(function ($) {
    "use strict";
    // multistep form start

    $(document).ready(function () {


        var currentStep = 0;
        var $msformFieldsets = $("#msform fieldset");
        var $progressbarLi = $("#progressbar li");
        function updateStep(step) {
            $msformFieldsets.removeClass("active");
            $msformFieldsets.eq(step).addClass("active");
            $progressbarLi.removeClass("processing");
            $progressbarLi.removeClass("active");
            $progressbarLi.eq(step).addClass("processing");
            $progressbarLi.slice(0, step).addClass("active");
        }



        let final = $("#final").val();

        if (final != "final") {
            $msformFieldsets.eq(0).addClass("active");
            $progressbarLi.eq(0).addClass("processing");
        }

        $(".next").click(function (e) {
            e.preventDefault();
            if (currentStep < $msformFieldsets.length - 1) {
                currentStep++;
                updateStep(currentStep);
            }
        });
        $(".prev").click(function (e) {
            e.preventDefault();
            if (currentStep > 0) {
                currentStep--;
                updateStep(currentStep);
            }
        });


        $(".installer-btn").on('click', function () {

            let self = $(this);
            let form = self.closest('form');
            let action = form.attr('action');


            $.ajax({
                type: 'GET',
                url: action,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (data.status == true) {
                        currentStep++;
                        updateStep(currentStep);
                    } else if (data.status == false) {
                        if (data.hasOwnProperty('message')) {
                            $(".server-error-message").html(`${data.message}`).fadeIn().delay(5000).fadeOut("slow");
                        }
                        $(self).addClass("remove");
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            })

        })



        $(".environment-btn").on('click', function () {

            let self = $(this);
            let form = self.closest('form');
            let formdata = new FormData(form[0]);
            let action = form.attr('action');

            $.ajax({
                type: 'POST',
                url: action,
                data: formdata,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    
                       console.log(data);
                    if (data.status == true) {
                        currentStep++;

                        updateStep(currentStep);
                        if (data.hasOwnProperty('url')) {
                            window.location.replace(`${data.url}`);
                        }



                    } else if (data.status == false) {
                        if (data.hasOwnProperty('errors')) {
                            printErrorMsg(data.errors);
                        }
                        if (data.hasOwnProperty('message')) {
                            $(".error-message").html(`${data.message}`).fadeIn().delay(5000).fadeOut("slow");
                        }
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            })
        })


    /** print error message
    * ======== printErrorMsg======
    *
    * @param msg
    *
    */
        function printErrorMsg(msg) {
            $.each(msg, function (key, value) {
                $('.' + key + '_err').text(value).fadeIn().delay(30000).fadeOut("slow");
            });
        }
        function showLoader() {
            $(".loader-installer").show();
        }

        function hideLoader() {
            $(".loader-installer").hide();
        }

        $('.btn-process').on('click', function () {
            $(".btn-ring").show();
            $(".btn-process").prop('disabled', true);
            $(".btn-process").val('disabled');
            $(this).closest('form').submit();
        });
    });
})(jQuery);



