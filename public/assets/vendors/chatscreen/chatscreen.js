
(function($) {
    'use strict';

    // Main Navigation
    $( '.hamburger-menu' ).on( 'click', function() {
        $(this).toggleClass('close');
        $('.site-branding').toggleClass('hide');
        $('.site-navigation').toggleClass('show');
        $('.site-header').toggleClass('no-shadow');
    });

    // Scroll to Next Section
    $( '.scroll-down' ).click(function() {
        $( 'html, body' ).animate({
            scrollTop: $( '.scroll-down' ).offset().top + 100
        }, 800 );
    });
})(jQuery);


//Button
$(function(){
    $("#android-img").on({

        //mouseenter: function(){
            //$(this).attr('src','images/android_a.png');
        //},

        //mouseleave: function(){
            //$(this).attr('src','images/android.png');
        //},

        mousedown: function(){
            $(this).attr('src','../../../assets/img/android_a.png');
        },

        mouseup: function(){
            $(this).attr('src','../../../assets/img/android.png');
        },

        touchstart: function(){
            $(this).attr('src','../../../assets/img/android_a.png');
        },

        touchend: function(){
            $(this).attr('src','../../../assets/img/android.png');
        },

    });

    $("#apple-img").on({

        //mouseenter: function(){
            //$(this).attr('src','images/apple_a.png');
        //},

        //mouseleave: function(){
            //$(this).attr('src','images/apple.png');
        //},

        mousedown: function(){
            $(this).attr('src','../../../assets/img/apple_a.png');
        },

        mouseup: function(){
            $(this).attr('src','../../../assets/img/apple.png');
        },

        touchstart: function(){
            $(this).attr('src','../../../assets/img/apple_a.png');
        },

        touchend: function(){
            $(this).attr('src','../../../assets/img/apple.png');
        },

    });
    
});
