$(function () {
    'use strict';
    // Start Navbar Menu

    //Togell Active Class in Menu
    $(".navbar_menu li:first-child").addClass("active");

    $(".navbar_menu li").click(function () {
        $(this).addClass("active").siblings().removeClass("active");
    });
    // Fixed navbar
    $(window).scroll(function () {
        if ($(window).scrollTop() >= 80) {
            $(".navbar").addClass("fixed");

        } else {
            $(".navbar").removeClass("fixed");

        }
    });

    // Menu Fore Desck Top


    // Button Togell To Show and Hide Menu
    $(".navbar_button").click(function () {
        $(".navbar_overlay").fadeIn();
        $(".navbar_menu").animate({
            left: 0 //Change
        }, 500);

    });

    // Overlay Click To  Hide Menu
    $(".navbar_overlay").click(function () {
        $(this).fadeOut("slow");
        $(".navbar_menu").animate({
            left: -260 //Change
        }, 500);

    });
    $(" .navbar_overlay").children().click(function (e) {
        e.stopPropagation();
    });


    // Hiden Menu in Mobile By Using Esc Button
    if ($(window).width() <= 992) {
        $(document).keydown(function (e) {
            if (e.keyCode == 27)
                $(".navbar_menu").fadeOut("slow");
        });
    }



    //End Navbar Menu
    // Start Header  Slider
    // =06= Start header_slider
    $('.testmonial_slider-js').slick({
        dots: false,
        arrows: false,
        // rtl: true,
        autoplay: true,
        autoplaySpeed: 2000,
        speed: 300,
        slidesToShow: 1,
        adaptiveHeight: true
    });
    // =06= End header_slider

        // =06= Start header_slider
        $('.header_slider-js').slick({
            dots: false,
            arrows: true,
            // rtl: true,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            adaptiveHeight: true
        });
        // =06= End header_slider

    /*Start Search Button */
    $(".search_form i").click(function () {
        $(".search_form").toggleClass("active");
    });
    /*End Search Button */


    // End Header Slider
    /*======= Backgrounds ======*/
    $("[data-src]").each(function () {
        var backgroundImage = $(this).attr("data-src");
        $(this).css("background-image", "url(" + backgroundImage + ")");
    });





    //Button Go to Top Hidden and Show
    $(window).scroll(function () {

        var buttonUp = $(".go_up-js");

        if ($(window).scrollTop() >= 400) {
            buttonUp.fadeIn(1000);
        } else {
            buttonUp.fadeOut(1000);

        }


    });

    $(".advanced_search-js").on('click', function () {
        $(".advanced_search-details").slideToggle(400);
    });
        
    //Button Click To Scroll to top
    $(".go_up-js").on('click', function () {
        $('html,body').animate({
            scrollTop: 0
        }, 1000)
    });

    $(".dropdown_link ").click(function () {
        $(".navbar_dropdown-menu").slideToggle(800);
    });





    /**Start Webiner Slider **/
    $('.project_slider-js').slick({
        dots: true,
        //        rtl:true,
        arrows: false,
       
        autoplay: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplaySpeed: 2000,

        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                infinite: true,
                //        dots: true
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
    /**End Webiner Slider **/



    /**Start Article Slider **/
    $('.article_slider-js').slick({
        dots: false,
        //        rtl:true,
        arrows: false,
        autoplay: true,
       
        autoplay: true,
        autoplaySpeed: 2000,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                infinite: true,
                //        dots: true
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
    /**End Article Slider **/

    /**Start Our Company Slider **/
    $('.our_company-slider').slick({
        dots: false,
        //        rtl:true,
        arrows: true,
       
        speed: 300,
        slidesToShow: 6,
        slidesToScroll: 1,
        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 1,
                infinite: true,
                //        dots: true
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
    /**End Our Company Slider **/


    /**Start our_client-slider   Slider **/
    $('.our_client-slider').slick({
        dots: false,
        // rtl: true,
        arrows: true,
       
        speed: 300,
        slidesToShow: 6,
        slidesToScroll: 1,
        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 1,
                infinite: true,
                //        dots: true
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
    /**End our_client-slider   **/

});