<script>
    $(function() {

        "use strict";
        /// updateOutput

        var updateOutput = function() {
            let menuItems = JSON.stringify($('#nestable').nestable('serialize'));
            let action = "{{ route('menu.item') }}"
            $.ajax({
                url: action,
                type: "GET",
                data: {
                    menuItems: menuItems
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.status == true) {
                        toastr["success"](data.message);

                    } else {
                        toastr["error"](data.message);
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });

        };
        $('.dd').nestable({
            maxDepth: 3
        }).on('change', updateOutput);


        $('.menu-change').on('change', function(e) {
            e.preventDefault();
            $('.menu-change').not(this).prop('checked', false);
            if ($(this).is(":checked")) {
                $(this).closest('form').submit();
            }
        });

        if ($(".default-checked").is(":checked")) {
            $('#menu-form').submit();
        }


        $(document).on('click', '.edit-menu-item', function() {

            let id = $(this).data('id');
            let action = baseUrl + "/dashboard/menu/menu-item-edit/" + id;

            $.ajax({
                url: action,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    if (data.status == true) {
                        // console.log(data);
                        $("#menuItemId").val(data.menuItem.id)
                        $("#menuItemName").val(data.menuItem.title)

                        $(".custom-field").html("");
                        if (data.menuItem.menu_type == "custom") {
                            $(".custom-field").html(`
                           <div class="form-inner mb-3">
                                <label> {{ translate('Custom Link') }} <span>*</span></label>
                                <input type="text" class="username-input" id="custom_link" value ="${data.menuItem.target}" name="custom_link"
                                placeholder="https://">
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" ${data.menuItem.new_tap==1 ? "checked":""} id="newTap1"
                                    name="new_tap">
                                <label class="form-check-label" for="newTap1"> {{ translate('Open In New Window') }}?</label>
                            </div>
                        `)
                        }
                    }

                },
                error: function(data) {
                    // console.log(data);
                }
            })
        })

        // delete menu

        $(document).on('click', '.delete', function(e) {
            e.preventDefault();

            let id = $(this).data('id');
            let action = baseUrl + "/dashboard/menu/menu-item-delete/" + id;

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
                            // console.log(data);

                            if (data.status === true) {
                                toastr["success"](`${data.message}`);
                                // $(self).closest('.accordion-item').remove();

                                location.reload();

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


        //add-menu


        $(document).on('click', '.add-menu', function(e) {

            e.preventDefault();

            let self = $(this);

            let parent = self.parent().parent();
            let formCheck = $(parent).find('.form-check');
            let n = $(formCheck).find(':checkbox:checked').length;

            let type = $(parent).find("#menu_type").val();
            let menuId = {{ $selectedMenu }};
            let array = $(parent).find(':checkbox:checked');
            let ids = [];
            for (let i = 0; i < n; i++) {
                ids[i] = array.eq(i).val();
            }


            let name = "";
            let custom_link = "";
            let new_tap = "";

            if (type == "custom") {

                name = $("#custom_menu_name").val();
                custom_link = $("#custom_link").val();
                new_tap = $("#newTap").val();
                if (name == "") {
                    $(".text-danger").html('Custom name is require')
                } else if (name !== "") {
                    addMenuItem(menuId, ids = "", type, name, custom_link, new_tap);
                }

            } else {
                if (ids.length === 0) {
                    return false;
                } else {
                    addMenuItem(menuId, ids, type, name = null, custom_link = null, new_tap =
                        null)
                }
            }

        })


        //checked-all-item

        $(document).on('click', '.checked-all-item', function(e) {

            let parent = $(this).closest('.accordion-body');
            parent = $(parent).find('.form-check')

            if (this.checked) {
                $($(parent).find(':checkbox')).each(function() {
                    this.checked = true;
                });
            } else {
                $($(parent).find(':checkbox')).each(function() {
                    this.checked = false;
                });
            }
        });


        // save data

        $('.add-form').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let formData = new FormData(form[0]);
            let lang = $("#lang").val();
            formData.append('lang', lang);
            let action = form.attr('action');
            $.ajax({
                type: "POST",
                url: action,
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    // console.log(data);
                    if (data.status == false) {
                        printErrorMsg(data.errors);
                    } else if (data.status == true) {

                        $(".modal").modal("hide");
                        toastr["info"](`${data.message}`);
                        if (data.hasOwnProperty('url')) {
                            $(form)[0].reset();
                            location.replace(`${data.url}`)
                        }
                        if (data.hasOwnProperty('menu')) {

                            location.reload();


                        }


                    }
                },
                error: function(data) {
                    console.log(data);
                    toastr["error"](`${data.message}`);

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
            $.each(msg, function(key, value) {
                $('.' + key + '_err').text(value).fadeIn().delay(30000).fadeOut("slow");
            });
        }

        function addMenuItem(menuId, ids, type, custom_name, custom_link, new_tap) {

            $.ajax({
                type: "get",
                data: {
                    menuId: menuId,
                    ids: ids,
                    type: type,
                    custom_name: custom_name,
                    custom_link: custom_link,
                    new_tap: new_tap,
                },
                url: "{{ route('add.menu') }}",
                success: function(data) {
                    // console.log(data);
                    if (data.status == true) {
                        toastr["success"](data.message);
                        location.reload();
                    } else {
                        console.log(data);
                        toastr["error"](data.message);
                    }


                },
            })

        }
    }(jQuery));
</script>
