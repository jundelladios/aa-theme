<?php

/**
 * ATF Slider Module Block
 *
 * @package AA_PROJECT
 */

global $aaproject;

use Carbon_Fields\Field;
use Carbon_Fields\Block;

Block::make( __( 'Slider' ) )
->set_category( 'aa_blocks', __( 'American Accents', 'american-accennts-theme' ), 'dashicons-home' )
->set_inner_blocks( false )
->add_fields( array(
    Field::make( 'html', 'cmenuhtml' )
    ->set_html( '<h2>American Accent Slides</h2>' ),
    Field::make( 'text', 'autoplayinterval', 'Autoplay Interval (ms)' )->set_width( 33.33 )->set_default_value( 5000 ),
    Field::make( 'complex', 'slides', __( '' ) )
    ->set_collapsed( true )
    ->set_layout( 'tabbed-horizontal' )
    ->add_fields( array(
        Field::make( 'image', 'image', 'Slide Image' )->set_width( 30 ),
        Field::make( 'rich_text', 'content', 'Slide Content' )->set_width( 70 ),
        Field::make( 'text', 'button', 'Button Text' )->set_width( 50 ),
        Field::make( 'text', 'link', 'URL' )->set_width( 50 ),
        Field::make( 'text', 'content_width', 'Content Width (px)' )->set_width( 33.33 )->set_default_value( 380 ),
        Field::make( 'select', 'alignment', 'Content Alignment' )->set_width( 33.33 )
        ->add_options( array(
            'start' => 'Left',
            'center' => 'Center',
            'end' => 'Right',
        ) )->set_default_value( 'start' ),
        Field::make( 'text', 'css_class', 'Slide Item CSS class' )->set_width( 33.33 )->set_default_value( '' ),
        Field::make( 'textarea', 'embed_code', 'Embed Code' )
    ))
    ->set_header_template( 'Slide <%- $_index+1 %>' )
))
->set_render_callback( function( $fields, $attributes, $inner_blocks ) {
    if( $fields['slides'] ):
        $moduleid = "slider-block-module-" . uniqid();
        $slideindex = 0;
    ?>
    <div class="slider-module <?php echo $attributes ? $attributes['className'] : ''; ?> <?php echo $moduleid; ?>">
        <div class="slider-wrap slider-module-js-slick">
            <?php foreach( $fields['slides'] as $slide ): ?>
                <?php 
                    $image = wp_get_attachment_image_src( $slide['image'], '1599' );
                    $alt = get_the_title( $slide['image'] );
                    $maxwidth = isset( $slide['content_width'] ) ? (int) $slide['content_width'] : 0;
                ?>
                <?php if( $image && $image[0] ): ?>
                    <div class="slider-item slideindex<?php echo $slideindex; ?> <?php echo isset( $slide['css_class'] ) ? $slide['css_class'] : ""; ?>">

                        <div class="slide-bg ">

                            <img src="<?php echo $image[0]; ?>" alt="<?php echo $alt; ?>" />

                            <div class="slide-container-wrap">
                                <?php if( isset( $slide['embed_code'] ) ): echo $slide['embed_code']; endif; ?>
                                <div class="d-flex align-items-center justify-content-<?php echo isset( $slide['alignment'] ) ? $slide['alignment'] : "start"; ?>" >
                                    <div class="slider-content" style="<?php echo $maxwidth > 0 ? "max-width:" . $maxwidth . 'px' : "" ?>">
                                        <?php if( $slide['content'] ): ?>
                                        <div class="content-wrap">
                                            <?php echo $slide['content']; ?>
                                        </div>
                                        <?php endif; ?>

                                        <?php if( $slide['button'] ): ?>
                                        <div class="button-wrap">
                                            <a class="btn btn-primary btn-slide" href="<?php echo $slide['link'] ? $slide['link'] : '#'; ?>"><?php echo $slide['button']; ?></a>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>
            <?php $slideindex++; endforeach; ?>
        </div>
    </div>

    <script>
        jQuery(document).ready( function($) {
            $('.<?php echo $moduleid; ?> .slider-module-js-slick').slick({
                prevArrow: `<button type="button" class="slick-indicator slick-prev"><span class="rotate-left icon icon-arrow-right"></span></button>`,
                nextArrow: `<button type="button" class="slick-indicator slick-next"><span class="icon icon-arrow-right"></span></button>`,
                dots: true,
                infinite: false,
                <?php
                    $interval = (int) $fields['autoplayinterval'];
                    if( $interval ) {
                        echo 'autoplay: true, autoplaySpeed: '.$interval.',';
                    }
                ?>
            });
        });
    </script>
    <?php
    endif;
});