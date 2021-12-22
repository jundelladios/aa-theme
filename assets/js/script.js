( function( $ ) {

    var scriptState = {
        isMobile: false
    }

    window.mediaQ = {
        md: window.matchMedia("only screen and (max-width: 767px)").matches,
        lg: window.matchMedia("only screen and (max-width: 991px)").matches,
        sm: window.matchMedia("only screen and (max-width: 575px)").matches
    }
    
    $( document ).ready( function() {

        scriptState.isMobile = window.mediaQ.lg;

        function mediaQset() {
            window.mediaQ = {
                md: window.matchMedia("only screen and (max-width: 767px)").matches,
                lg: window.matchMedia("only screen and (max-width: 991px)").matches,
                sm: window.matchMedia("only screen and (max-width: 575px)").matches
            }

            if( scriptState.isMobile != window.mediaQ.lg ) {
                scriptState.isMobile = window.mediaQ.lg;
            }
        }

        // reactive mediaQ
        $(window).on('load resize', mediaQset);

        // Header and Navigation ( works on lg only or tablet/mobile )

        $(document).on('click', 'header .mobile #mobile_toggle_js', function() {
            var headerNav = $( 'header .mobile .nav-menu' );
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

        $( 'header .mobile .nav-menu li a[href="#"]').click( function() {
            var child = $( this ).parent().children( '.aa-submenu-module' );
            if( child.length ) {
                $( this ).toggleClass( 'open' );
                child.slideToggle( 300 );
                return false;
            }
        });

        // for submenu module
        $( 'header .mobile .aa-submenu-module .ptitle' ).click( function() {
            $(this).toggleClass( 'open' );
            $(this).parent().children( '#gitemwrap' ).slideToggle();
            return false;
        });

        $(window).scroll( function() {
            var scroll = $(window).scrollTop();
            if(scroll > 1000) {
                $('.back_to_top:not(.inmodal)').addClass('show');
            } else {
                $('.back_to_top:not(.inmodal)').removeClass('show');
            }
        });

        $('[data-modal-scroll]').scroll( function() {
            var scroll = $(this).scrollTop();
            var getbtotop = $(this).find('.back_to_top');
            if(getbtotop.length) {
                if(scroll > 1000) {
                    getbtotop.addClass('show');
                } else {
                    getbtotop.removeClass('show');
                }
            }
        });
        
        $('.back_to_top').click( function() {
            var elemToScroll = $(this).data('elem');
            var scrollElem = $('html, body');
            if(elemToScroll) {
                scrollElem = $(elemToScroll);
            }
            scrollElem.animate({ scrollTop: 0 }, ($('html').height()-($('html').height()-500)));
            return false;
        });



        var _theaccmodule = {
            accordion: function($elem) {
                if( $elem.hasClass('show') ) {
                    $elem.removeClass('show');
                    this.setHashLink(null);
                } else {
                    $elem.addClass('show');
                    this.setHashLink($elem.data('id'));
                }
                this.content($elem.data('accordion'));
            },
            content: function(accordion) {
                var content = $(`[data-accordion-content="${accordion}"]`);
                if( content.hasClass('show') ) {
                    content.slideUp();
                    content.removeClass('show');
                } else {
                    content.slideDown();
                    content.addClass('show');
                }
            },
            setHashLink(hash) {
                if(hash) {
                    window.history.pushState({}, '', `#${hash}`);
                } else {
                    window.history.pushState(null, null, ' ');
                }
            },
            initaccordion: function() {
                var hash = window.location.hash.replace('#', '');
                var elem = $(`[data-id="${hash}"]`);
                if( elem.length ) {
                    this.accordion($(`[data-id="${hash}"]`));
                    $('html, body').stop().animate({
                        scrollTop: elem.offset().top
                    }, 500, 'swing');
                }
            }
        }

        _theaccmodule.initaccordion();
        // accordion module starts here.
        $(document).on('click', '[data-accordion]', function() {
            _theaccmodule.accordion($(this));
            return false;
        });

    });
    

} )( jQuery );


function handleImage(e) {
    try {
        var fallback = e.target.getAttributeNode('fallback').value;
        if( fallback ) {
            e.target.src = fallback;
            e.target.removeAttribute('data-src');
            e.target.removeAttribute('srcset');
            e.target.classList.remove("lazyload");
            e.target.classList.remove("lazyloading");
            e.target.classList.remove("lazyloaded");
        }
    } catch($e) { return; }
}

function handleBackgrounds(e) {
    try {
        var parentNode = e.target.parentNode.parentNode;
        var isbg = parentNode.hasAttribute('data-bgset');
        var bgfallback = parentNode.getAttributeNode('fallback').value;
        if(isbg && bgfallback) {
            parentNode.classList.remove("lazyload");
            parentNode.classList.remove("lazyloading");
            parentNode.classList.remove("lazyloaded");
            parentNode.removeAttribute('data-bgset');
            parentNode.style.backgroundImage = 'url(' + bgfallback + ')';
            parentNode.classList.add("bg-cover");
        }
    } catch($e) {
        return;
    }
}


document.addEventListener('error', function(e){
    if(e.target.nodeName == 'IMG') {
        handleImage(e);
        handleBackgrounds(e);
    }
}, true);