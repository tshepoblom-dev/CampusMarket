(function ($) {
    "use strict";

    //================= preloader js

    jQuery(window).on('load', function () {
        $(".preloader").delay(1600).fadeOut("slow");
    });

    //================= niceSelect js

    $('select').niceSelect();

    // wow animate
    setTimeout(myGreeting, 1800);
    function myGreeting() {
        var wow = new WOW(
            {
                boxClass: 'wow',
                animateClass: 'animated',
                offset: 0,          // distance to the element when triggering the animation (default is 0)
                mobile: true,       // trigger animations on mobile devices (default is true)
                live: true,       // act on asynchronously loaded content (default is true)
                callback: function (box) {
                    // the callback is fired every time an animation is started
                    // the argument that is passed in is the DOM node being animated
                },
                scrollContainer: null,    // optional scroll container selector, otherwise use window,
                resetAnimation: true,     // reset animation on end (default is true)
            }
        );
        wow.init();
    }

    //============== scroll Js

    window.addEventListener('scroll', function () {
        const header = document.querySelector('header.style-1, header.style-2, header.style-3');
        header.classList.toggle("sticky", window.scrollY > 0);
    });

    //============== Class Added & Class Remove Js

    $('.search-btn').on("click", function () {
        $('.mobile-search').addClass('slide');
    });

    $('.search-cross-btn').on("click", function () {
        $('.mobile-search').removeClass('slide');
    });

    //============== Scroll Js

    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 300) {
            $('.scroll-btn').addClass('show');
        } else {
            $('.scroll-btn').removeClass('show');
        }
    });
    $('.scroll-btn').on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, '300');
    });



    //============== Mobile-menu Js

    $('.mobile-menu-btn').on("click", function () {
        $('.main-menu').addClass('show-menu');
    });

    $('.menu-close-btn').on("click", function () {
        $('.main-menu').removeClass('show-menu');
    });

    //============== Dropdown-icon

    $('.dropdown-icon').on('click', function () {
        $(this).toggleClass('active').next('ul').slideToggle();
        $(this).parent().siblings().children('ul').slideUp();
        $(this).parent().siblings().children('.active').removeClass('active');
    });



    var toggleIcon = document.querySelectorAll('.sidebar-menu-icon')
    var closeIcon = document.querySelectorAll('.cross-icon')
    var searchWrap = document.querySelectorAll('.menu-toggle-btn-full-shape')

    toggleIcon.forEach((element) => {
        element.addEventListener('click', () => {
            document.querySelectorAll('.menu-toggle-btn-full-shape').forEach((el) => {
                el.classList.add('show-sidebar')
            })
        })
    })

    closeIcon.forEach((element) => {
        element.addEventListener('click', () => {
            document.querySelectorAll('.menu-toggle-btn-full-shape').forEach((el) => {
                el.classList.remove('show-sidebar')
            })
        })
    })

    window.onclick = function (event) {
        // Menu Toggle button sidebar
        searchWrap.forEach((el) => {
            if (event.target === el) {
                el.classList.remove('show-sidebar')
            }
        })
    }

    //========== Home-1 Banner Js

    var heroSliderTwo = new Swiper('.banner1', {
        slidesPerView: 1,
        speed: 1500,
        loop: true,
        spaceBetween: 10,
        loop: true,
        centeredSlides: true,
        roundLengths: true,
        parallax: true,
        effect: 'fade',
        navigation: false,
        fadeEffect: {
            crossFade: true,
        },

        autoplay: {
            delay: 4000
        },
        pagination: {
            el: ".hero-one-pagination",
            clickable: true,

        }
    });


    //============ Category Slider

    var swiper = new Swiper(".category1-slider", {
        slidesPerView: 1,
        speed: 1000,
        spaceBetween: 30,
        loop: true,
        autoplay: true,
        roundLengths: true,
        autoplay: {
            delay: 2500, // Autoplay duration in milliseconds
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.category-prev1',
            prevEl: '.category-next1',
        },

        breakpoints: {
            280: {
                slidesPerView: 1
            },
            440: {
                slidesPerView: 2
            },
            576: {
                slidesPerView: 2
            },
            768: {
                slidesPerView: 3
            },
            992: {
                slidesPerView: 5
            },
            1200: {
                slidesPerView: 6
            },
            1400: {
                slidesPerView: 7
            },

        }

    });


    //============ Category2 Slider



    var swiper = new Swiper(".category2-slider", {
        slidesPerView: 1,
        speed: 1000,
        spaceBetween: 30,
        loop: true,
        autoplay: true,
        roundLengths: true,
        pagination: false,
        navigation: {
            nextEl: '.category-prev2',
            prevEl: '.category-next2',
        },

        breakpoints: {
            280: {
                slidesPerView: 1
            },
            380: {
                slidesPerView: 2
            },
            540: {
                slidesPerView: 3
            },
            576: {
                slidesPerView: 3
            },
            768: {
                slidesPerView: 4
            },
            992: {
                slidesPerView: 5
            },
            1200: {
                slidesPerView: 6
            },
            1400: {
                slidesPerView: 7
            },
        }
    });

    //============== upcoming

    var swiper = new Swiper(".upcoming-slider", {
        slidesPerView: 1,
        speed: 1000,
        spaceBetween: 24,
        loop: true,
        roundLengths: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: 'true',
        },
        navigation: {
            nextEl: '.coming-prev1',
            prevEl: '.coming-next1',
        },

        breakpoints: {
            280: {
                slidesPerView: 1
            },
            480: {
                slidesPerView: 1
            },
            768: {
                slidesPerView: 2
            },
            992: {
                slidesPerView: 2
            },
            1200: {
                slidesPerView: 3
            },

        }

    });
    var swiper = new Swiper(".upcoming-slider2", {
        slidesPerView: 1,
        speed: 1000,
        spaceBetween: 24,
        loop: true,
        roundLengths: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: 'true',
        },
        navigation: {
            nextEl: '.coming-prev2',
            prevEl: '.coming-next2',
        },

        breakpoints: {
            280: {
                slidesPerView: 1,
                pagination: false
            },
            480: {
                slidesPerView: 1,
                pagination: false
            },
            768: {
                slidesPerView: 2,
                pagination: false
            },
            992: {
                slidesPerView: 2
            },
            1200: {
                slidesPerView: 3
            },

        }
    });


    var swiper = new Swiper(".upcoming-slider3", {
        slidesPerView: 1,
        speed: 1000,
        spaceBetween: 24,
        loop: true,
        roundLengths: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: 'true',
        },
        navigation: {
            nextEl: '.coming-prev3',
            prevEl: '.coming-next3',
        },

        breakpoints: {
            280: {
                slidesPerView: 1
            },
            480: {
                slidesPerView: 1
            },
            768: {
                slidesPerView: 2
            },
            992: {
                slidesPerView: 2
            },
            1200: {
                slidesPerView: 3
            },

        }
    });

    // blog-slider-slider1

    var swiper = new Swiper(".blog-slider", {
        slidesPerView: 2,
        speed: 1000,
        spaceBetween: 24,
        loop: true,
        roundLengths: true,
        navigation: {
            nextEl: '.blog-prev1',
            prevEl: '.blog-next1',
        },

        breakpoints: {
            280: {
                slidesPerView: 1
            },
            480: {
                slidesPerView: 1
            },
            768: {
                slidesPerView: 2
            },
            992: {
                slidesPerView: 2
            },
            1200: {
                slidesPerView: 3
            },

        }

    });

    // testimonial-slider

    var swiper = new Swiper(".testimonial-slider", {
        slidesPerView: 1,
        speed: 1000,
        spaceBetween: 24,
        loop: true,
        roundLengths: true,
        autoplay: {
            delay: 2500, // Autoplay duration in milliseconds
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.testi-prev1',
            prevEl: '.testi-next1',
        },

        breakpoints: {
            280: {
                slidesPerView: 1
            },
            480: {
                slidesPerView: 1,
                autoplay: true,
            },
            768: {
                slidesPerView: 1
            },
            992: {
                slidesPerView: 2
            },
            1200: {
                slidesPerView: 3
            },

        }
    });
    var swiper = new Swiper(".testimonial-slider2", {
        slidesPerView: 1,
        speed: 1000,
        spaceBetween: 24,
        loop: true,
        roundLengths: true,
        navigation: {
            nextEl: '.testi-prev2',
            prevEl: '.testi-next2',
        },

        breakpoints: {
            280: {
                slidesPerView: 1
            },
            480: {
                slidesPerView: 1,
                autoplay: true,
            },
            768: {
                slidesPerView: 1
            },
            992: {
                slidesPerView: 2
            },
            1200: {
                slidesPerView: 3
            },

        }
    });

    // slick slider
    $('#slick1').slick({
        rows: 2,
        dots: true,
        arrows: false,
        infinite: true,
        speed: 300,
        slidesToShow: 6,
        slidesToScroll: 6,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    arrows: false,
                    slidesToShow: 5
                }
            },
            {
                breakpoint: 991,
                settings: {
                    arrows: false,
                    slidesToShow: 4
                }
            },
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 576,
                settings: {
                    arrows: false,
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 350,
                settings: {
                    arrows: false,
                    slidesToShow: 1
                }
            }
        ]
    });

    var thumbslider = new Swiper(".slider-thumb", {
        spaceBetween: 15,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
    });
    var swiper2 = new Swiper(".thumb-big", {
        spaceBetween: 10,
        thumbs: {
            swiper: thumbslider,
        },
    });

    //Quantity
    $('.quantity__minus').on("click",function (e) {
        e.preventDefault();
        var input = $(this).siblings('.quantity__input');
        var value = parseInt(input.val());
        if (value > 1) {
            value--;
        }
        input.val(value.toString().padStart(2, '0'));

        var pregular = $(this).closest('.purchase-form').find('.pregular_price').val();
        var psale = $(this).closest('.purchase-form').find('.psale_price').val();
        var mainPrice = $(this).closest('.purchase-form').find('.mainPrice');
        var sprice = $(this).closest('.purchase-form').find('.sprice');
        var rprice = $(this).closest('.purchase-form').find('.rprice');

        if (psale) {
            var mprice = (psale * value);
            mainPrice.val(mprice);

            var ssprice = (psale * value);
            sprice.text(ssprice);

            var rrprice = (pregular * value);
            rprice.text(rrprice);
        } else {
            var mprice = (pregular * value);
            mainPrice.val(mprice);

            var ssprice = (pregular * value);
            sprice.text(ssprice);
        }
    });
    $('.quantity__plus').on("click",function (e) {
        e.preventDefault();
        var input = $(this).siblings('.quantity__input');
        var value = parseInt(input.val());

        value++;
        input.val(value.toString().padStart(2, '0'));

        var pregular = $(this).closest('.purchase-form').find('.pregular_price').val();
        var psale = $(this).closest('.purchase-form').find('.psale_price').val();
        var mainPrice = $(this).closest('.purchase-form').find('.mainPrice');
        var sprice = $(this).closest('.purchase-form').find('.sprice');
        var rprice = $(this).closest('.purchase-form').find('.rprice');
        console.log(psale);
        if (psale) {
            var mprice = (psale * value);
            mainPrice.val(mprice);

            var ssprice = (psale * value);
            sprice.text(ssprice);

            var rrprice = (pregular * value);
            rprice.text(rrprice);
        } else {
            var mprice = (pregular * value);
            mainPrice.val(mprice);

            var ssprice = (pregular * value);
            sprice.text(ssprice);
        }
    });


    // timer start
    function makeTimer() {
        var limit = $('#live_limit').val();
        for (let i = 0; i < limit; i++) {

            var endTime = $('#timer' + i).data("live-end-date");
            // var endTime = new Date("July 20, 2023 00:00:00");
            var endTime = (Date.parse(endTime)) / 1000; //replace these two lines with the unix timestamp from the server
            var now = new Date();
            var now = (Date.parse(now) / 1000);
            var timeLeft = endTime - now;
            var days = Math.floor(timeLeft / 86400);
            var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
            // var Xmas95 = new Date('December 25, 1995 23:15:30');
            // console.log(Xmas95);
            // console.log(Date.parse(timeLeft * 1000));
            // var hour = Xmas95.getHours();
            // console.log(hour);
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

            $("#timer" + i + " #days" + i).html(days);
            $("#timer" + i + " #hours" + i).html(hours);
            $("#timer" + i + " #minutes" + i).html(minutes);
            $("#timer" + i + " #seconds" + i).html(seconds);
        }
        var upcoming_limit = $('#upcoming_limit').val();
        for (let h = 0; h < upcoming_limit; h++) {

            var upcoming_startTime = $('#upcoming' + h).data("upcoming-start-date");

            var upcoming_startTime = (Date.parse(upcoming_startTime)) / 1000; //replace these two lines with the unix timestamp from the server
            var upcoming_now = new Date();
            var upcoming_now = (Date.parse(upcoming_now) / 1000);
            var upcoming_timeLeft = upcoming_startTime - upcoming_now;
            var upcoming_days = Math.floor(upcoming_timeLeft / 86400);
            var upcoming_hours = Math.floor((upcoming_timeLeft - (upcoming_days * 86400)) / 3600);

            var upcoming_minutes = Math.floor((upcoming_timeLeft - (upcoming_days * 86400) - (upcoming_hours * 3600)) / 60);
            var upcoming_seconds = Math.floor((upcoming_timeLeft - (upcoming_days * 86400) - (upcoming_hours * 3600) - (upcoming_minutes * 60)));
            if (upcoming_hours < "10") {
                upcoming_hours = "0" + upcoming_hours;
            }
            if (upcoming_minutes < "10") {
                upcoming_minutes = "0" + upcoming_minutes;
            }
            if (upcoming_seconds < "10") {
                upcoming_seconds = "0" + upcoming_seconds;
            }

            $("#upcoming" + h + " #upcoming_days" + h).html(upcoming_days);
            $("#upcoming" + h + " #upcoming_hours" + h).html(upcoming_hours);
            $("#upcoming" + h + " #upcoming_minutes" + h).html(upcoming_minutes);
            $("#upcoming" + h + " #upcoming_seconds" + h).html(upcoming_seconds);
        }

    }
    setInterval(function () {
        makeTimer();
    }, 1000);
    // timer end

    // count-down-timer
    var setEndDate1 = $("#countdown-timer-1").text();
    var setEndDate2 = $("#countdown-timer-2").text();
    var setEndDate3 = $("#countdown-timer-3").text();
    var setEndDate4 = $("#countdown-timer-4").text();
    var setEndDate5 = $("#countdown-timer-5").text();
    var setEndDate6 = $("#countdown-timer-6").text();
    var setEndDate7 = $("#countdown-timer-7").text();
    var setEndDate8 = $("#countdown-timer-8").text();
    var setEndDate9 = $("#countdown-timer-9").text();

    function startCountDownDate(dateVal) {
        var countDownDate = new Date(dateVal).getTime();
        return countDownDate;
    }

    function countDownTimer(start, targetDOM) {
        // Get todays date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = start - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // add 0 at the beginning if days, hours, minutes, seconds values are less than 10
        days = (days < 10) ? "0" + days : days;
        hours = (hours < 10) ? "0" + hours : hours;
        minutes = (minutes < 10) ? "0" + minutes : minutes;
        seconds = (seconds < 10) ? "0" + seconds : seconds;

        // Output the result in an element with countdown-timer-x"
        var el_up = document.getElementById(targetDOM);
        if (el_up) {
            document.querySelector("#" + targetDOM).textContent = days + "D : " + hours + "H : " + minutes + "M : " + seconds + "S ";
        }


        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval();
            // document.querySelector("#" + targetDOM).textContent = "EXPIRED";
        }
    }

    var cdd1 = startCountDownDate(setEndDate1);
    var cdd2 = startCountDownDate(setEndDate2);
    var cdd3 = startCountDownDate(setEndDate3);
    var cdd4 = startCountDownDate(setEndDate4);
    var cdd5 = startCountDownDate(setEndDate5);
    var cdd6 = startCountDownDate(setEndDate6);
    var cdd7 = startCountDownDate(setEndDate7);
    var cdd8 = startCountDownDate(setEndDate8);
    var cdd9 = startCountDownDate(setEndDate9);

    setInterval(function () { countDownTimer(cdd1, "countdown-timer-1"); }, 1000);
    setInterval(function () { countDownTimer(cdd2, "countdown-timer-2"); }, 1000);
    setInterval(function () { countDownTimer(cdd3, "countdown-timer-3"); }, 1000);
    setInterval(function () { countDownTimer(cdd4, "countdown-timer-4"); }, 1000);
    setInterval(function () { countDownTimer(cdd5, "countdown-timer-5"); }, 1000);
    setInterval(function () { countDownTimer(cdd6, "countdown-timer-6"); }, 1000);
    setInterval(function () { countDownTimer(cdd7, "countdown-timer-7"); }, 1000);
    setInterval(function () { countDownTimer(cdd8, "countdown-timer-8"); }, 1000);
    setInterval(function () { countDownTimer(cdd9, "countdown-timer-9"); }, 1000);

    // password-hide and show

    const togglePassword = document.querySelector('#togglePassword');

    const password = document.querySelector('#password');

    if (togglePassword) {
        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye / eye slash icon
            this.classList.toggle('bi-eye');
        });
    }


    // confirm-password
    const togglePassword2 = document.getElementById('togglePassword2');

    const password2 = document.querySelector('#password2');

    if (togglePassword2) {
        togglePassword2.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password2.getAttribute('type') === 'password' ? 'text' : 'password';
            password2.setAttribute('type', type);
            // toggle the eye / eye slash icon
            this.classList.toggle('bi-eye');
        });
    }

    // Odometer Counter
    $(".counter-item").each(function () {
        $(this).isInViewport(function (status) {
            if (status === "entered") {
                for (var i = 0; i < document.querySelectorAll(".odometer").length; i++) {
                    var el = document.querySelectorAll('.odometer')[i];
                    el.innerHTML = el.getAttribute("data-odometer-final");
                }
            }
        });
    });

    $(".counter-single").each(function () {
        $(this).isInViewport(function (status) {
            if (status === "entered") {
                for (var i = 0; i < document.querySelectorAll(".odometer").length; i++) {
                    var el = document.querySelectorAll('.odometer')[i];
                    el.innerHTML = el.getAttribute("data-odometer-final");
                }
            }
        });
    });

    // Magnific Popup video
    $('.popup-youtube').magnificPopup({
        type: 'iframe'
    });

    // timer start
    // Coming Soon Countdown

    $('[data-countdown]').each(function () {
        var $deadline = new Date($(this).data('countdown')).getTime();

        var $dataDays = $(this).children('[data-days]');
        var $dataHours = $(this).children('[data-hours]');
        var $dataMinutes = $(this).children('[data-minutes]');
        var $dataSeconds = $(this).children('[data-seconds]');

        var x = setInterval(function () {

            var now = new Date().getTime();
            var t = $deadline - now;

            var days = Math.floor(t / (1000 * 60 * 60 * 24));
            var hours = Math.floor(t % (1000 * 60 * 60 * 24) / (1000 * 60 * 60));
            var minutes = Math.floor(t % (1000 * 60 * 60) / (1000 * 60));
            var seconds = Math.floor(t % (1000 * 60) / (1000));

            $dataDays.html(`${days} <br> <span>Days</span>`);
            $dataHours.html(`${hours} <br> <span>Hrs</span>`);
            $dataMinutes.html(`${minutes} <br> <span>Mins</span>`);
            $dataSeconds.html(`${seconds} <br> <span>Secs</span>`);

            if (t <= 0) {
                clearInterval(x);
                $dataDays.html('00');
                $dataHours.html('00');
                $dataMinutes.html('00');
                $dataSeconds.html('00');
            }

        }, 1000);
    })
    // timer end
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload").on('change', function () {
        readURL(this);
    });

    // Csrf Token Loaded
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Get State by dropdown
    $('.country_id').on('change', function () {
        var country_id = this.value;
        console.log('country_id changed: ' + country_id);
        if (country_id) {
            $(".state_id").empty();
            $.ajax({
                url: "/location/get/state",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: "POST",
                data: {
                    country_id: country_id,
                },
                dataType: 'json',
                success: function (res) {
                    $('.state_id').append('<option value="">' + res.option + '</option>');
                    $.each(res.states, function (key, value) {
                        $(".state_id").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                    $('.state_id').niceSelect('update');
                }
            });
        }
    });

    // Get City by dropdown
    $('.state_id').on('change', function () {
        var state_id = this.value;
        console.log('country_id changed: ' + country_id);
        if (state_id) {
            $(".city_id").empty();
            $.ajax({
                url: "/location/get/city",
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
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
                    $('.city_id').niceSelect('update');
                }
            });
        }
    });

    $(function () {
        $('.deposit_submit').on('change', function () {
            $('#deposit_form').submit();
        });
    });

    // Get Shipping State by dropdown
    $('.shipping_country_id').on('change', function () {
        var shipping_country_id = this.value;
        if (shipping_country_id) {
            $(".shipping_state_id").empty();
            $.ajax({
                url: "/location/get/state",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: "POST",
                data: {
                    country_id: shipping_country_id,
                },
                dataType: 'json',
                success: function (res) {
                    $('.shipping_state_id').append('<option value="">' + res.option + '</option>');
                    $.each(res.states, function (key, value) {
                        $(".shipping_state_id").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                    $('.shipping_state_id').niceSelect('update');
                }
            });
        }
    });

    // Get Shipping City by dropdown
    $('.shipping_state_id').on('change', function () {
        var state_id = this.value;
        if (state_id) {
            $(".shipping_city_id").empty();
            $.ajax({
                url: "/location/get/city",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: "POST",
                data: {
                    state_id: state_id,
                },
                dataType: 'json',
                success: function (res) {
                    $('.shipping_city_id').html('<option value="">' + res.option + '</option>');
                    $.each(res.city, function (key, value) {
                        $(".shipping_city_id").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                    $('.shipping_city_id').niceSelect('update');
                }
            });
        }
    });

    $(function () {
        $('.deposit_submit').on('change', function () {
            $('#deposit_form').submit();
        });
    });

    $(function () {
        $('.paginate_filter').on('change', function () {
            $(this).closest('form').submit();
        });
    });


    $(function () {
        $('.payment-methods .payment-list li').on('click', function () {
            $('.payment-methods .payment-list li').removeClass('active'); // Remove active class from all list items
            if ($(this).hasClass('wallet-payment')) {
                if (!$("#strip-payment").hasClass('d-none')) {
                    $("#strip-payment").addClass("d-none");
                }
                $(this).addClass('active'); // Add active class to the clicked list item
            }
            else if ($(this).hasClass('razorpay')) {
                if (!$("#strip-payment").hasClass('d-none')) {
                    $("#strip-payment").addClass("d-none");
                }
                $(this).addClass('active'); // Add active class to the clicked list item
            }
            else if ($(this).hasClass('paypal')) {
                if (!$("#strip-payment").hasClass('d-none')) {
                    $("#strip-payment").addClass("d-none");
                }
                $(this).addClass('active'); // Add active class to the clicked list item
            }
            else if ($(this).hasClass('stripe')) {
                if ($("#strip-payment").hasClass('d-none')) {
                    $("#strip-payment").removeClass("d-none");
                }
                $(this).addClass('active'); // Add active class to the clicked list item
            }
            else {
                if ($("#strip-payment").hasClass('d-none')) {
                    $("#strip-payment").removeClass("d-none");
                }
            }
        });
    });



    // For Service Select
    $('.select-wrap').on('click', function () {
        $(this).addClass('selected').siblings().removeClass('selected');
    })
    //===== Add ballance


    $(function () {
        $('.choose-payment-mathord .payment-method-section .custom-radio').on('click', function () {
            $('.choose-payment-mathord .payment-method-section .custom-radio').removeClass('active'); // Remove active class from all list items
            if ($(this).hasClass('stripe')) {
                $('#StripePayment').show();
                $('#OfflinePayment').hide();
                $(this).addClass('active'); // Add active class to the clicked list item
            }
            else if ($(this).hasClass('paypal')) {
                $('#OfflinePayment').hide();
                $('#StripePayment').hide();
                $(this).addClass('active'); // Add active class to the clicked list item
            }
            else if ($(this).hasClass('razorpay')) {
                $('#OfflinePayment').hide();
                $('#StripePayment').hide();
                $(this).addClass('active'); // Add active class to the clicked list item
            }
            else if ($(this).hasClass('pay-with-card')) {
                $('#OfflinePayment').hide();
                $('#StripePayment').hide();
                $(this).addClass('active'); // Add active class to the clicked list item
            }
            else if ($(this).hasClass('offline')) {
                $('#OfflinePayment').hide();
                $('#StripePayment').hide();
                $(this).addClass('active'); // Add active class to the clicked list item
            }
            else {
                $('#StripePayment').hide();
                $('#OfflinePayment').hide();
            }
        });
    });

    $("input:radio[name=fixed_price]").click(function () {
        var fixed_price = $(this).val();
        if (fixed_price == 'other_amount') {
            $('#OtherPrice').show();
            $('#OtherPrice #modal_other_amount').prop('required', true);
        } else {
            $('#OtherPrice #modal_other_amount').prop('required', false);
            $('#OtherPrice').hide();
            $('.modal_amount_main').text(fixed_price);
            $('.modal_amount_main_val').val(fixed_price);
            // var tax_rate = $('#taxRate').val();
            // var tax_amount = (fixed_price / 100 ) * tax_rate;
            $('.modal_tax_amount').text(0);
            $('.modal_tax_amount_val').val(0);
            var total_amount = (parseFloat(fixed_price) + parseFloat(0));
            $('.modal_total_amount').text(total_amount);
            $('.modal_total_amount_val').val(total_amount);
        }

        $("#modal_other_amount").bind('keyup', function () {
            var fixed_price = $(this).val();
            $('.modal_amount_main').text(fixed_price);
            $('.modal_amount_main_val').val(fixed_price);
            // var tax_rate = $('#taxRate').val();
            // var tax_amount = (fixed_price / 100 ) * tax_rate;
            $('.modal_tax_amount').text(0);
            $('.modal_tax_amount_val').val(0);
            if (fixed_price) {
                var total_amount = (parseFloat(fixed_price) + parseFloat(0));
                $('.modal_total_amount').text(total_amount);
                $('.modal_total_amount_val').val(total_amount);
            } else {
                $('.modal_total_amount').text(0);
                $('.modal_total_amount_val').val(0);
            }
        });

    });
    // Auto slash of Expiry Date
    var card_date = document.getElementById('stripe_card_expiry');
    var card_date_modal = document.getElementById('modal_stripe_card_expiry');

    function checkValue(str, max) {
        if (str.charAt(0) !== '0' || str == '00') {
            var num = parseInt(str);
            if (isNaN(num) || num <= 0 || num > max) num = 1;
            str = num > parseInt(max.toString().charAt(0))
                && num.toString().length == 1 ? '0' + num : num.toString();
        };
        return str;
    };
    if (card_date) {
        card_date.addEventListener('input', function (e) {
            this.type = 'text';
            var input = this.value;
            if (/\D\/$/.test(input)) input = input.substr(0, input.length - 1);
            var values = input.split('/').map(function (v) {
                return v.replace(/\D/g, '')
            });
            if (values[0]) values[0] = checkValue(values[0], 12);
            if (values[1]) values[1] = checkValue(values[1], 50);
            var output = values.map(function (v, i) {
                return v.length == 2 && i < 2 ? v + '/' : v;
            });
            this.value = output.join('').substr(0, 5);
        });
    }
    if (card_date_modal) {
        card_date_modal.addEventListener('input', function (e) {
            this.type = 'text';
            var input = this.value;
            if (/\D\/$/.test(input)) input = input.substr(0, input.length - 1);
            var values = input.split('/').map(function (v) {
                return v.replace(/\D/g, '')
            });
            if (values[0]) values[0] = checkValue(values[0], 12);
            if (values[1]) values[1] = checkValue(values[1], 50);
            var output = values.map(function (v, i) {
                return v.length == 2 && i < 2 ? v + '/' : v;
            });
            this.value = output.join('').substr(0, 5);
        });
    }


    // language change
    if ($('#change-lang').length > 0) {
        $('#change-lang li .dropdown-item').each(function () {
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


    $(document).ready(function () {
        $(".commnt-reply").click(function (e) {
            var comId = $(this).data('comment_id');
            $('#replyModal').modal("show");
            $('#replyModal #parent_id').val(comId);
        });
    });

    $(document).ready(function () {
        $('#shippingCheckbox').change(function () {
            $("#shippingBox").toggleClass("d-none");
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

    $(document).ready(function () {
        $('.register-form button[type="submit"]').click(function () {
            var val = $(".register-form #terms_policy").is(':checked');
            if (val == true) {
                $(".register-form .terms_policy").hide();
            } else {
                $(".register-form .terms_policy").show();
            }
        });
    });

}(jQuery));

