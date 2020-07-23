<?php

/**
 * Editor Block
 *
 * @package Kinslow_System
 */

global $aaproject;

use Carbon_Fields\Field;
use Carbon_Fields\Block;

Block::make( __( 'Editor' ) )
->set_category( 'sample_editor', __( 'American Accents', $aaproject['context'] ), $aaproject['block_icon'] )
->set_inner_blocks( false )
->add_fields( array(
    Field::make( 'text', 'content', __( 'Content', $aaproject['context'] ) ),
    Field::make( 'color', 'color', __( 'Text Color', $aaproject['context'] ) )
) )
->set_preview_mode( false )
->set_render_callback( function( $fields, $attributes, $inner_blocks ) {
    ?>
    <p style="color: <?php echo $fields['color']; ?>"><?php echo $fields['content']; ?></p>
    <?php
} );