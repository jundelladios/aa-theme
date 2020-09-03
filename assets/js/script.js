( function( $ ) {

    $( document ).ready( function() {

        var mediaQ = {
            md: window.matchMedia("only screen and (max-width: 767px)").matches,
            lg: window.matchMedia("only screen and (max-width: 991px)").matches,
            sm: window.matchMedia("only screen and (max-width: 575px)").matches
        }

        // Header and Navigation ( works on lg only or tablet/mobile )
        mediaQ.lg && $( 'header #mobile_toggle_js' ).click( function() {
            var headerNav = $( 'header .nav-menu' );
            headerNav.slideToggle( function() {
                // if hidden
                if( headerNav.is(':hidden') ) {
                    // reset all toggles
                    $( 'header .aa-submenu-module' ).slideUp();
                    $( 'header .aa-submenu-module #gitemwrap' ).slideUp();
                    $( 'header .aa-submenu-module .ptitle' ).removeClass( 'open' );
                    $( 'header .nav-menu li a' ).removeClass( 'open' );
                }
            });
        });

        mediaQ.lg && $( 'header .aa-submenu-module' ).hide();
        mediaQ.lg && $( 'header .aa-submenu-module #gitemwrap' ).hide();

        mediaQ.lg && $( 'header .nav-menu li a[href="#"]').click( function() {
            var child = $( this ).parent().children( '.aa-submenu-module' );
            if( child.length ) {
                $( this ).toggleClass( 'open' );
                child.slideToggle( 300 );
                return false;
            }
        });

        // for submenu module
        mediaQ.lg && $( 'header .aa-submenu-module .ptitle' ).click( function() {
            $(this).toggleClass( 'open' );
            $(this).parent().children( '#gitemwrap' ).slideToggle();
            return false;
        });
        
    });

} )( jQuery );