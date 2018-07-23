(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id))
        return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
var viewport_width = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
var viewport_height = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
var PPOFixed = {
    mainMenu:function(){
        var msie6 = jQuery.browser == 'msie' && jQuery.browser.version < 7;
        if (!msie6) {
            var top = jQuery('.ppo_menu').offset().top - parseFloat(jQuery('.ppo_menu').css('margin-top').replace(/auto/, 0));
            jQuery(window).scroll(function(event){
                if (jQuery(this).scrollTop() >= top){
                    var wpadminbar_height = 0;
                    if(jQuery(this).width() > 583){
                        wpadminbar_height = jQuery('#wpadminbar').outerHeight(true);
                    }
                    jQuery('.ppo_menu').css({
                        'top':wpadminbar_height - 1
                    }).addClass('fixed');
                } else {
                    jQuery('.ppo_menu').css({
                        'top':0
                    }).removeClass('fixed');
                }
            });
        }
    },
    columns: function (col) {
        var summaries = jQuery(col);
        summaries.each(function (i) {
            var summary = jQuery(summaries[i]);
            var next = summaries[i + 1];
            var margin_top = jQuery('#wpadminbar').outerHeight(true);

            summary.scrollToFixed({
                marginTop: margin_top,
                limit: function () {
                    var limit = 0;
                    if (next) {
                        limit = jQuery(next).offset().top - jQuery(this).outerHeight(true) - 10;
                    } else if(jQuery("#home_slider").length > 0) {
                        limit = jQuery('#home_slider').offset().top - jQuery(this).outerHeight(true) - 10;
                    } else {
                        limit = jQuery('#footer').offset().top - jQuery(this).outerHeight(true) - 10;
                    }
                    return limit;
                },
                zIndex: 998
            });
        });
    }
};
jQuery.noConflict();
jQuery(document).ready(function ($) {
    if(is_fixed_menu){
        PPOFixed.mainMenu();
    }
    PPOFixed.columns(".project-hl");
    PPOFixed.columns(".project-list-widget");
    if(viewport_width > 991 && jQuery(".sidebar").height() < jQuery(".sidebar").prev().height()){
        PPOFixed.columns(jQuery(".sidebar .widget").get(jQuery(".sidebar .widget").length - 1));
    }
    PPOFixed.columns(".vc_wp_custommenu.menu-fixed");

    if(viewport_width > 991){
        jQuery("#sliderA").excoloSlider();
    }

//    fakewaffle.responsiveTabs(['xs', 'sm']);

    // Menu mobile
    jQuery(".menu-mobile").simpleSidebar({
        settings: {
            opener: "#menu",
            wrapper: "#wrapper",
            animation: {
                easing: "easeOutQuint"
            }
        },
        sidebar: {
            align: "left",
            width: 200,
            closingLinks: '.btn-close-menu'
        },
        mask: {
            //STYLE holds all CSS rules. Use this feature to stylize the mask.
            style: {
                //Default options.
                backgroundColor: 'transparent', //if you do not want any color use 'transparent'.
                opacity: 0.5, //if you do not want any opacity use 0.
                filter: 'Alpha(opacity=50)' //IE8 and earlier - If you do not want any opacity use 0.
                        //You can add more options.
            }
        }
    });

    jQuery('#boxTab a, #myTab a').click(function (e) {
        e.preventDefault();
        jQuery("#category").html(jQuery("#categories-" + jQuery(this).data('id')).html());
        jQuery(this).tab('show');
    });
    
    if(jQuery("#accordion").length > 0){
        jQuery( "#accordion" ).accordion({
            collapsible: true,
            heightStyle: "content"
        });
    }

    // Feedback Carousel
    if(jQuery(".recent-feedback-carousel-widget").length > 0){
        jQuery(".recent-feedback-carousel-widget .owl-carousel").owlCarousel({
            autoplay: true,
            autoplayHoverPause: true,
            loop: true,
            margin: 0,
            nav: true,
            navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            dots: false,
            responsiveClass: true,
            items: 1
        });
    }
    
    // User Carousel
    if(jQuery(".carousel-users-widget").length > 0){
        jQuery(".carousel-users-widget .owl-carousel").owlCarousel({
            autoplay: true,
            autoplayHoverPause: true,
            loop: true,
            margin: 30,
            nav: true,
            navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            dots: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    margin: 0
                },
                420: {
                    items: 2
                },
                600: {
                    items: 3
                },
                992: {
                    items: 4
                },
                1199: {
                    items: 5
                }
            }
        });
    }
    
    // Supplier Carousel
    if(jQuery(".carousel-suppliers-widget").length > 0){
        jQuery(".carousel-suppliers-widget .owl-carousel").owlCarousel({
            autoplay: true,
            autoplayHoverPause: true,
            loop: true,
            margin: 30,
            nav: true,
            navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            dots: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    margin: 0
                },
                420: {
                    items: 2
                },
                600: {
                    items: 3
                },
                992: {
                    items: 4
                },
                1199: {
                    items: 5
                }
            }
        });
    }
    
    // Partner Carousel
    if(jQuery(".partner-carousel-widget").length > 0){
        jQuery(".partner-carousel-widget .owl-carousel").owlCarousel({
            autoplay: true,
            autoplayHoverPause: true,
            loop: true,
            margin: 30,
            nav: true,
            navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            dots: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    margin: 0
                },
                420: {
                    items: 2
                },
                600: {
                    items: 3
                },
                992: {
                    items: 4
                },
                1199: {
                    items: 5
                }
            }
        });
    }
    
    // Compare posts
    if(jQuery(".compare-products").length > 0){
        jQuery(".compare-products .owl-carousel").owlCarousel({
            autoplay: false,
            autoplayHoverPause: true,
            loop: false,
            margin: 30,
            nav: true,
            navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            dots: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    margin: 0
                },
                575: {
                    items: 2
                },
                1199: {
                    items: 4
                }
            }
        });
    }
    
    // Product Carousel
    if(jQuery(".carousel-products-widget").length > 0){
        jQuery(".carousel-products-widget .owl-carousel").owlCarousel({
            autoplay: false,
            autoplayHoverPause: true,
            loop: true,
            margin: 30,
            nav: true,
            navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            dots: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    margin: 0
                },
                575: {
                    items: 2
                },
                1199: {
                    items: 4
                }
            }
        });
    }
    if(jQuery(".carousel-products-widget-2").length > 0){
        jQuery(".carousel-products-widget-2 .owl-carousel").owlCarousel({
            autoplay: false,
            autoplayHoverPause: true,
            loop: true,
            margin: 30,
            nav: true,
            navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            dots: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    margin: 0
                },
                575: {
                    items: 2
                },
                1199: {
                    items: 3
                }
            }
        });
    }
    
    // Project Carousel
    if(jQuery(".carousel-projects-widget").length > 0){
        jQuery(".carousel-projects-widget .owl-carousel").owlCarousel({
            autoplay: false,
            autoplayHoverPause: true,
            loop: true,
            margin: 30,
            nav: true,
            navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            dots: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    margin: 0
                },
                575: {
                    items: 2
                },
                1199: {
                    items: 4
                }
            }
        });
    }
    
    // Product Gallery
    if(jQuery(".product-gallery").length > 0){
        jQuery(".product-gallery .owl-carousel").owlCarousel({
            autoplay: true,
            autoplayHoverPause: true,
            loop: true,
            margin: 0,
            nav: true,
            navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            dots: false,
            responsiveClass: true,
            items: 1
        });
    }
    
    // Scroll to top
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 120) {
            jQuery("#scrollToTop").fadeIn();
        } else {
            jQuery("#scrollToTop").fadeOut();
        }
    });
    jQuery("#scrollToTop").click(function () {
        jQuery('body,html').animate({
            scrollTop: 0
        }, 400);
        return false;
    });
    
    // Popup
    if(show_popup && TFunc.getCookie('t-popup') !== '1'){
        setTimeout(function (){
            jQuery("#myModal").modal();
            TFunc.setCookie('t-popup', 1, 60 * 60 * 1000 * 24, '/', '', ''); // 24 hours
        }, 2 * 1000); // seconds
    }
    
    jQuery(".own-avatar").append('<span class="toolbox"><a class="hotline" href="tel:' + hotline + '"></a><a class="website" href="' + website + '"></a></span>');
    
    // Dang tin
    jQuery('form#formPost input[type="file"]').change(function(){
        toastr.options.closeButton = true;
        toastr.options.positionClass = "toast-top-center";
        var _file = jQuery(this).get(0);
        if(_file.files.length > 8) {
            toastr.error("Số lượng tối đa là 08 ảnh!", '', {timeOut: 5000});
        } else {
            var valid_size = true;
            for(i = 0; i < _file.files.length; i++){
                if((_file.files[i].size / 1024) / 1024 > 1){
                    valid_size = false;
                }
            }
            if(!valid_size){
                toastr.error("Dung lượng mỗi ảnh không được quá 1MB", '', {timeOut: 5000});
            }
        }
    });
    jQuery('form#formPost #start_time, form#formPost #end_time').change(function(){
        jQuery(this).val(function(index, value) {
            return value.replace(/\s/g, "").replace(/[-]/g, "/");
        });
    });
    jQuery('form#formPost').submit(function(){
        toastr.options.closeButton = true;
        toastr.options.positionClass = "toast-top-center";
        var _file = jQuery('form#formPost input[type="file"]').get(0);
        if(_file.files.length > 8) {
            toastr.error("Số lượng tối đa là 08 ảnh!", '', {timeOut: 5000});
        } else {
            var valid_size = true;
            for(i = 0; i < _file.files.length; i++){
                if((_file.files[i].size / 1024) / 1024 > 1){
                    valid_size = false;
                }
            }
            if(!valid_size){
                toastr.error("Dung lượng mỗi ảnh không được quá 1MB", '', {timeOut: 5000});
            } else {
                return true;
            }
        }
        return false;
    });
});