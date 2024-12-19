<?php

/**
 * Back to Top Block
 *
 * @package AA_PROJECT
 */

global $aaproject;

use Carbon_Fields\Field;
use Carbon_Fields\Block;

Block::make( __( 'Back to Top Module' ) )
->set_category( 'aa_blocks', __( 'American Accents', 'american-accennts-theme' ), 'dashicons-home' )
->set_inner_blocks( false )
->add_fields( array(
    Field::make( 'html', 'cmenuhtml' )
    ->set_html( '<h2>American Accents Back to Top Module</h2><p>Automatically shows back to top button on scroll.</p>' )
))
->set_render_callback( function( $fields, $attributes, $inner_blocks ) {
    ?>
    <a href="javascript:void(0)" class="back_to_top">
        <span class="icon-topscroll icon"></span>
    </a>
    <?php
});