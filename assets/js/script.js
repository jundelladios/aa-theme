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
                    $elem.trigger('aa_accordion_hide');
                } else {
                    $elem.addClass('show');
                    this.setHashLink($elem.data('id'));
                    $elem.trigger('aa_accordion_show');
                }
                this.content($elem.data('accordion'), $elem);
            },
            content: function(accordion, $elem) {
                var content = $(`[data-accordion-content="${accordion}"]`);
                if( content.hasClass('show') ) {
                    content.slideUp(400, function() {
                        $elem.trigger('aa_accordion_hide_done');
                    });
                    content.removeClass('show');
                } else {
                    content.slideDown(400, function() {
                        $elem.trigger('aa_accordion_show_done');
                    });
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


        // download files api attributes
        $(document).on('click', '[api-zip-files]', function() {

            const zipbtn = $(this);

            zipbtn.css({ opacity: 0.5 });
            
            var files = $(this).attr('api-zip-files');
            var output = $(this).attr('api-zip-download') || 'downloads.zip';

            files = files.split(',');

            if(!files.length) { return; }

            jQuery.ajax({
                url: '/wp-json/v1/download/archive',
                type: 'POST',
                cache:false,
                data: { 
                    files: files,
                    output_filename: output
                },
                xhrFields:{
                    responseType: 'blob'
                },
                success: function(data){
                    var url = window.URL || window.webkitURL;
                    var file = url.createObjectURL(data);
            
                    var link = document.createElement('a');
                    link.setAttribute('href', file);
                    link.setAttribute('download', output);
                    link.click();
            
                    setTimeout(function(){  
                        link.remove();
                        url.revokeObjectURL(file);
                    }, 1);

                    zipbtn.css({ opacity: 1 });
                },
                error: function() {
                    zipbtn.css({ opacity: 1 });
                }
            });

            return false;

        });

    });


    $(document).on('click', '[api-email-send]', function() {
        var bodycontent = $(this).data(`email-body`);
        var subject = $(this).data('email-subject');
        const emailParam = jQuery.param({
            subject: subject,
            body: bodycontent
        });
    
        window.open(`mailto:?${emailParam}`);
        return false;
    });


    $(document).on('click', '.aa_social_share', function() {
        return JSShare.go($(this)[0]);
    });

    $(document).on('click', '[aa-modal-share]', function() {
        if($('.social-share-modal-module').length) {
            $('.social-share-modal-module').modal('show');
            $('.social-share-modal-module .aa_social_share').attr('data-url', $(this).attr('aa-modal-share'));
        }
        return false;
    });
    

    // check if top header announcement fixed exists
    $(document).on('DOMNodeInserted', function(e) {
        if ( $(e.target).hasClass('bulletinwp-placement-top') && $('.bulletinwp-placement-top').length < 2 ) {
            $('header').before($(e.target).clone().addClass('fixed-duplicate-bulletinwp'));
            $(e.target).css({ opacity: 0 });
        }
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