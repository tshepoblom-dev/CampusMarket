(function ($) {
    "use strict";


    // sidebar toggle area

    $('.sidebar-toggle-button').on("click", function () {
        $('.sidebar-header').toggleClass('slide');
        $('.main-conent-header').toggleClass('slide');
        $('.sidebar-wrapper').toggleClass('slide');
        $('.sidebar-search').toggleClass('slide');
        $('.main-content').toggleClass('slide');
    });


    // textarea summernote


    $('#summernote').summernote({
        height: 200,
        placeholder: "Write here..",
        height: 200,
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
        styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5','h6'],
        lineHeights: ['0.5', '1.0', '1.1', '1.2', '1.3', '1.4'],
        fontSizes: ['8', '9', '10', '11', '12', '13', '14', '15', '16', '18', '24', '36', '48', '64', '82', '150'],
    });
    $('.summernote').summernote({
        placeholder: "Write here..",
        height: 200,
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
        fontSizes: ['8', '9', '10', '11', '12', '13', '14', '15', '16', '18', '24', '36', '48', '64', '82', '150'],
        styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5','h6'],
    });



    // adding input with click
    let index = $('#specifiction_product').length;

    $("#addRow").on("click", function () {

        index++

        let html = `<div class="mb-3 row g-3 inputFormRow">
            <div class="col-md-6">
                <input type="text" name="specifications[${index}][label]" class="m-input" placeholder="Label" autocomplete="off">
            </div>
             <div class="col-md-6 d-flex justify-content-center gap-2">
                <input type="text" name="specifications[${index}][value]" class=" n-input" placeholder="Value" autocomplete="off">
                <button id="removeRow" type="button" class="eg-btn btn--red rounded px-3">
                <i class="bi bi-x"></i></button></div><div class="input-group-append">
            </div>
        </div>`;
        $('#specifiction_product').append(html);
    });

    $(document).on('click', '#removeRow', function () {
        $(this).closest('.inputFormRow').remove();
    });






    // add-file-input

    $("#addRow2").on('click', function () {

        var html = '';
        html += '<div id="inputTypeFile">';
        html += '<div class="mb-3 row g-3">';
        html += '<div class="col-12 d-flex flex-row justify-content-center">';
        html += '<input type="file" name="attachment[]" class=" m-input" placeholder="No File Choosen">';
        html += '<button id="removeRow2" type="button" class="eg-btn btn--red rounded px-3"><i class="bi bi-x"></i></button>';
        html += '</div>';
        html += '<div class="input-group-append">';
        html += '</div>';
        html += '</div>';
        $('#newInputFile').append(html);
    });

    $(document).on('click', '#removeRow2', function () {
        $(this).closest('#inputTypeFile').remove();
    });

    // select2


    $('.js-example-basic-single').select2({
        width: '100%'
    });


    // datepicker
    $(function () {
        $("#datepicker").datetimepicker();
    });
    $(function () {
        $("#datepicker2").datetimepicker();
    });
    $(function () {
        $("#datepicker3").datetimepicker();
    });

    $(function () {
        $("#datepicker4").datetimepicker();
    });


    // timer start
    function makeTimer() {
        var end_date = $("#bid_end_time").val();
        var endTime = new Date(end_date);
        var endTime = (Date.parse(endTime)) / 1000; //replace these two lines with the unix timestamp from the server
        var now = new Date();
        var now = (Date.parse(now) / 1000);
        var timeLeft = endTime - now;
        var days = Math.floor(timeLeft / 86400);
        var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
        var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600)) / 60);
        var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));
        if (hours < "10") {
            hours = "0" + hours;
        }
        if (minutes < "10") {
            minutes = "0" + minutes;
        }
        if (seconds < "10") {
            seconds = "0" + seconds;
        }
        if (endTime < now) {
            hours = "00";
            minutes = "00";
            seconds = "00";
            days = "00";
        }

        $("#timer1 #days1").html(days);
        $("#timer1 #hours1").html(hours);
        $("#timer1 #minutes1").html(minutes);
        $("#timer1 #seconds1").html(seconds);

    }
    setInterval(function () {
        makeTimer();
    }, 1000);
    // timer end


    //color picker with addon

    
    $(function () {
        $('.primary-color').colorpicker();

        $('.primary-color').on('colorpickerChange', function (event) {
            $('.primary-color .fa-square').css('color', event.color.toString());
        });

        $('.secondary-color').colorpicker();

        $('.secondary-color').on('colorpickerChange', function (event) {
            $('.secondary-color .fa-square').css('color', event.color.toString());
        });
    });


    $(document).ready(function () {

        $('#shop_name').blur(function () {
            var error_shop_name = '';
            var shop_name = $('#shop_name').val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "/shop_name_available_check",
                method: "POST",
                data: { shop_name: shop_name, _token: _token },
                success: function (result) {
                    if (result == 0) {
                        $('#error_shop_name').html('<div class="text-success">Shop Name Available</div>');
                        $('#shop_name').removeClass('has-error');
                        $('#saveBtn').attr('disabled', false);
                    }
                    else {
                        $('#error_shop_name').html('<div class="error text-danger">Shop Name not Available. Please try again.</div>');
                        $('#shop_name').addClass('has-error');
                        $('#saveBtn').attr('disabled', 'disabled');
                    }
                }
            })
        });
    });


    let timeZone = $("#timezoneValue").val();
    if (timeZone !== "") {
        $("#time_zone").val(`${timeZone}`).trigger("change");
    }


    $(".editorContainer").each((index, value) => {

        CodeMirror.fromTextArea($(".editorContainer")[index], {
            mode: "javascript",
            lineNumbers: true,
            theme: "dracula",
            extraKeys: { "Ctrl-Space": "autocomplete" }
        });


    })



}(jQuery));
