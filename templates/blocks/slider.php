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
->set_category( 'aa_homepage', __( 'American Accents Homepage', $aaproject['context'] ), 'dashicons-home' )
->set_inner_blocks( false )
->set_preview_mode( false )
->add_fields( array(
    Field::make( 'complex', 'slides', __( 'American Accents Sliders.' ) )
    ->set_collapsed( true )
    ->add_fields( array(
        Field::make( 'image', 'image', 'Slide Image' )->set_width( 30 ),
        Field::make( 'rich_text', 'content', 'Slide Content' )->set_width( 70 ),
        Field::make( 'text', 'button', 'Button Text' )->set_width( 50 ),
        Field::make( 'text', 'link', 'URL' )->set_width( 50 )
    ))
    ->set_header_template( 'Slide <%- $_index+1 %>' )
))
->set_render_callback( function( $fields, $attributes, $inner_blocks ) {
    if( $fields['slides'] ):
    ?>
    <div class="slider-module <?php $attributes ? $attributes['className'] : ''; ?>">
        
    </div>
    <?php
    endif;
});