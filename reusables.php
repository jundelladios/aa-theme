<?php

function americanAccentsReusableModalContent($moduleid, $entries=[], $options=[]) {
    /** 
     * Entry Required Keys
     * _modal_image
     * _modal_image_alt
     * _modal_print_title
     * 
     * 
    */
    $defaults = array(
        'modal_title' => null,
        'modal_subtitle' => null,
        'is_enabled_email' => true,
        'is_enabled_print' => true,
        'is_enabled_download' => true,
        'is_enabled_share' => true,
        'download_file_name' => 'downloads.zip'
    );
    $opt = array_merge($defaults, $options);

    $downloadedfilename = str_replace(' ', '-', $opt['download_file_name']);
    $downloadlists = [];
    ob_start();
    ?>
    <div class="modal zoom-in modalgallerypopup" data-backdrop="static" data-modal-module-id="<?php echo $moduleid; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body pt-3 pb-5">
                    <div class="idea-gallery-info">
                        <?php if($opt['modal_title']): ?>
                        <h5 class="mb-4 modal-title-product font-weight-bold text-uppercase f-text-primary"><?php echo $opt['modal_title']; ?></h5>
                        <?php endif; ?>
                        <div>
                            <?php if(isset($opt['modal_subtitle'])): ?>
                            <h4 class="mb-1 ideagallery-pname font-extra-bold text-uppercase">
                                <?php echo $opt['modal_subtitle']; ?>
                            </h4>
                            <?php endif; ?>

                            <div class="ideagallery-min modal-description slide-modal-title">
                                <?php foreach( $entries as $ent ): ?>
                                    <p><?php echo $ent['_modal_label']; ?></p>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="idea-gallery-main-slider">
                        <div class="carousel-main-wrap">
                            <div class="carousel carousel-idea-main ideagallery slide-main ideagallery-modal-main">

                                <?php 
                                $secondindexer = 0;
                                foreach( $entries as $ent ): 
                                    $downloadlists[] = $ent['_modal_image'];
                                ?>
                                <div class="img-slide-item" data-module-slide-indexer="<?php echo $secondindexer; ?>">
                                    <div class="img-fit-wrap">
                                         <img 
                                         src="<?php echo $ent['_modal_image']; ?>" 
                                         alt="<?php echo $ent['_modal_image_alt']; ?>" 
                                         data-zoom-image="<?php echo $ent['_modal_image']; ?>"
                                         />
                                    </div>

                                    <div class="button-actions mt-3">
                                        <?php if($opt['is_enabled_email']): ?>
                                        <a href="#" 
                                        data-url="<?php echo $ent['_modal_image']; ?>"
                                        data-type="email"
                                        class="btn-action button-light sendemaillinkblurb aa_social_share"><span class="icon mr-1 icon-email"></span> email</a>
                                        <?php endif; ?>
                                        
                                        <?php if($opt['is_enabled_print']): ?>
                                        <a href="#" 
                                        onclick="return printJS({
                                            printable: '<?php echo $ent['_modal_image']; ?>',
                                            documentTitle: `<?php echo $ent['_modal_print_title']; ?>`,
                                            type: 'image',
                                            imageStyle: 'display:block;margin:20px auto;max-height:100%;max-width:100%;',
                                            showModal: true
                                        });"
                                        class="btn-action button-light frontend-desktop-only"><span class="icon mr-1 icon-icon-print"></span> print</a>
                                        <?php endif; ?>
                                        
                                        <?php if($opt['is_enabled_download']): ?>
                                        <a href="<?php echo $ent['_modal_image']; ?>" class="btn-action button-light" target="_blank" rel="nofollow" class="btn-action button-light"><span class="icon mr-1 icon-download-single"></span> download</a>
                                        <?php endif; ?>
                                        
                                        <?php if($opt['is_enabled_share']): ?>
                                        <a href="#" aa-modal-share="<?php echo $ent['_modal_image']; ?>" class="btn-action button-light"><span class="icon mr-1 icon-share"></span> share</a>
                                        <?php endif; ?>

                                    </div>
                                </div>
                                <?php 
                                $secondindexer++;
                                endforeach; 
                                ?>


                            </div>
                        </div>
                    </div>




                    <div class="idea-gallery-carousel mb-2">
                        <div class="carousel-main-wrap">
                            
                            <div class="carousel carousel-idea-thumbnail slide-main product-image-slick ideagallery-modal-thumb" >
                            <?php 
                            $thirdindexer = 0;
                            foreach( $entries as $ent ): 
                            ?>
                                <div class="aa-idea-thumbnail-slide">
                                    <div class="img-slide-item">
                                        <div class="img-fit-wrap p-2">
                                            <img 
                                            src="<?php echo $ent['_modal_image']; ?>"
                                            alt="<?php echo $ent['_modal_image_alt']; ?>"
                                            />
                                        </div>
                                    </div>
                                </div>
                            <?php
                            $thirdindexer++;
                            endforeach; 
                            ?>
                            </div>

                        </div>
                    </div>


                    <div class="idea-scrollbarwrap">
                        <div class="scrollbar-ideagallery-indicator" style="width: 0%;"></div>
                    </div>

                    <?php if($opt['is_enabled_download']): ?>
                    <div class="modal-button-centered text-center mt-5">
                        <a href="#" rel="nofollow" class="btn btn-primary"
                        api-zip-files="<?php echo join(',', $downloadlists); ?>"
                        api-zip-download="<?php echo $downloadedfilename; ?>"
                        >
                            <span class="icon icon-download-archive mr-1"></span>
                            <span class="text">Download All</span>
                        </a>
                    </div>
                    <?php endif; ?>


                </div>

            </div>
        </div>
    </div>


    <script type="text/javascript">
        /* script for <?php echo $moduleid; ?> module */
        jQuery(document).ready( function($) {

            var carouselmain_<?php echo $moduleid; ?> = jQuery(`[data-modal-module-id="<?php echo $moduleid; ?>"] .ideagallery-modal-main`);
            carouselmain_<?php echo $moduleid; ?>.slick({
                autoplay: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                focusOnSelect: true,
                infinite: true,
                asNavFor: `[data-modal-module-id="<?php echo $moduleid; ?>"] .slide-modal-title, [data-modal-module-id="<?php echo $moduleid; ?>"] .ideagallery-modal-thumb`,
                drag: true,
                prevArrow: `<button class="idea-modal-arrow right"><span class="icon idea-arrow icon-arrow-right"></span></button>`,
                nextArrow: `<button class="idea-modal-arrow left rotate-left"><span class="icon idea-arrow icon-arrow-right"></span></button>`,
            });

            var carouselElevateZoom_<?php echo $moduleid; ?> = function() {
                jQuery('.zoomContainer').remove();
                var blurbModalelevateZoomSlick = jQuery('[data-modal-module-id="<?php echo $moduleid; ?>"] .ideagallery-modal-main .slick-active.slick-current [data-zoom-image]');
                blurbModalelevateZoomSlick.elevateZoom({
                    galleryActiveClass: 'elevatezoom-active',
                    cursor: "crosshair",
                    scrollZoom: false,
                    borderSize: 1,
                    borderColour: '#e6e6e6',
                    zoomWindowWidth: 390,
                    zoomWindowHeight: 411,
                    zoomWindowOffetx: 50,
                    zoomWindowOffety: -15,
                    zoomWindowFadeIn: 500,
                    zoomWindowFadeOut: 500,
                    lensFadeIn: 500,
                    lensFadeOut: 500
                });
            }

            
            carouselmain_<?php echo $moduleid; ?>.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
                var countslickslides = jQuery('[data-modal-module-id="<?php echo $moduleid; ?>"] .ideagallery-modal-main .slick-slide:not(.slick-cloned)').length;
                var calc = ( (nextSlide) / (countslickslides-1) ) * 100;
                jQuery('[data-modal-module-id="<?php echo $moduleid; ?>"] .scrollbar-ideagallery-indicator').css({
                    width: `${calc}%`
                });
            });

            // initialize elevate zoom
            $('[data-modal-module-id="<?php echo $moduleid; ?>"]').on('hidden.bs.modal', function () {
                jQuery('.zoomContainer').remove();
            });

            $('[data-modal-module-id="<?php echo $moduleid; ?>"]').on('shown.bs.modal', function () {
                carouselElevateZoom_<?php echo $moduleid; ?>();
            });
            // after change slide elevate zoom refresh
            carouselmain_<?php echo $moduleid; ?>.on('afterChange', function() {
                carouselElevateZoom_<?php echo $moduleid; ?>();
            });

            var carousel_modaldesc_<?php echo $moduleid; ?> = jQuery(`[data-modal-module-id="<?php echo $moduleid; ?>"] .slide-modal-title`);
            carousel_modaldesc_<?php echo $moduleid; ?>.slick({
                autoplay: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                focusOnSelect: true,
                infinite: true,
                dots: false,
                arrows: false,
                draggable: false
            });


            var carousel_thumbs_<?php echo $moduleid; ?> = jQuery(`[data-modal-module-id="<?php echo $moduleid; ?>"] .ideagallery-modal-thumb`);
            carousel_thumbs_<?php echo $moduleid; ?>.slick({
                autoplay: false,
                pauseOnHover: true,
                slidesToShow: 6,
                slidesToScroll: 6,
                dots: false,
                focusOnSelect: true,
                asNavFor: `[data-modal-module-id="<?php echo $moduleid; ?>"] .ideagallery-modal-main, [data-modal-module-id="<?php echo $moduleid; ?>"] .slide-modal-title`,
                drag: false,
                infinite: true,
                prevArrow: `<button class="idea-modal-arrow right"><span class="icon idea-arrow icon-arrow-right-double"></span></button>`,
                nextArrow: `<button class="idea-modal-arrow left rotate-left"><span class="icon idea-arrow icon-arrow-right-double"></span></button>`,
            });
            

            $(`[data-module-id="<?php echo $moduleid; ?>"]`).on('click', `[data-modal-trigger]`, function() {
                var triggerid = $(this).data('modal-trigger');
                var modal = jQuery(`[data-modal-module-id="<?php echo $moduleid; ?>"]`);
                modal.modal('show');

                // resize to avoid layout shift
                carouselmain_<?php echo $moduleid; ?>.slick('resize');
                carousel_modaldesc_<?php echo $moduleid; ?>.slick('resize');
                carousel_thumbs_<?php echo $moduleid; ?>.slick('resize');

                var slickindex = jQuery(`[data-modal-module-id="<?php echo $moduleid; ?>"] .slide-main [data-module-slide-indexer="${triggerid}"]`).data('slick-index');
                carouselmain_<?php echo $moduleid; ?>.slick('slickGoTo', slickindex);
            });

        });
    </script>

    <?php

    $html = ob_get_clean();
    return $html;
}
