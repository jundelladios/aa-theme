<?php

/**
 * Accordion Block
 *
 * @package AA_PROJECT
 */

global $aaproject;

use Carbon_Fields\Field;
use Carbon_Fields\Block;

Block::make( __( 'Content' ) )
->set_category( 'aa_blocks', __( 'American Accents', 'american-accennts-theme' ), 'dashicons-home' )
->set_inner_blocks( false )
->add_fields( array(
    Field::make( 'html', 'contenthtml' )
    ->set_html( '<h2>Content</h2>' ),
    Field::make( 'rich_text', 'acc_content', 'Accordion Content' )
))
->set_render_callback( function( $fields, $attributes, $inner_blocks ) {
    ob_start();
    if(is_admin()) {
        echo "";
        return "";
    }
    ?>
    <div class="content-module <?php echo $attributes ? $attributes['className'] : ''; ?>">
        <?php echo $fields['acc_content']; ?>
        
    </div>
    <?php
    $html = ob_get_clean();
    echo $html;
});