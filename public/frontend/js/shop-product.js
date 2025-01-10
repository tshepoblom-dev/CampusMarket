(function ($) {
    "use strict";

    $(document).on("change", '.price_order_by', function () {
        $("#product_type").val(this.value);
        filterSearchJob();

    });

    $(document).on('click', '.page-item .page-link', function (e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        filterSearchJob(page);
    });

    function filterSearchJob(page = null) {
        const product_type = $("#product_type").val();
        let url = window.location.origin + "" + window.location.pathname;
        let action = url + "?page=" + page + "&filter_by=" + product_type;
        $.ajax({
            url: action,
            type: "GET",
            dataType: "json",
            success: function (data) {

                console.log(data);
                if (data.status == true) {
                    $("#loadProducts").html(data.products);
                    $(".show_count").html(data.total)
                }

            },
            error: function (data) {
                // console.log(data);
            }

        })
    }

}(jQuery));

