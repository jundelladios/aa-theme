<?php

/**
 * Columns Module Block
 *
 * @package AA_PROJECT
 */

global $aaproject;

use Carbon_Fields\Field;
use Carbon_Fields\Block;

Block::make( __( 'Column Content Module' ) )
->set_category( 'aa_blocks', __( 'American Accents', $aaproject['context'] ), 'dashicons-home' )
->set_inner_blocks( false )
->add_fields( array(
    Field::make( 'html', 'columnshtml' )
    ->set_html( '<h2>American Accent Column Content</h2>' ),
    Field::make( 'text', 'aacol', __( 'Default Column' ) )->set_width( 25 )->set_default_value( '6' ),
    Field::make( 'text', 'aacolxl', __( 'Column XL' ) )->set_width( 25 )->set_default_value( '5' ),
    Field::make( 'text', 'aacollg', __( 'Column LG' ) )->set_width( 25 )->set_default_value( '4' ),
    Field::make( 'text', 'aacolmd', __( 'Column MD' ) )->set_width( 25 )->set_default_value( '3' ),
    Field::make( 'text', 'aacolsm', __( 'Column SM' ) )->set_width( 25 )->set_default_value( '2' ),
    Field::make( 'text', 'aacolxs', __( 'Column XS' ) )->set_width( 25 )->set_default_value( '2' ),
    Field::make( 'complex', 'colentry', __( '' ) )
    ->set_collapsed( true )
    ->set_layout( 'tabbed-horizontal' )
    ->add_fields( array(
        Field::make( 'rich_text', 'col_content', 'Column Content' ),
    ))
    ->set_header_template( 'Content <%- $_index+1 %>' )
))
->set_render_callback( function( $fields, $attributes, $inner_blocks ) {
    ob_start();
    ?>
        <div 
        class="aa-grid 
        aa-grid-<?php echo $fields['aacol']; ?> 
        aa-grid-<?php echo $fields['aacolxl']; ?>-xl
        aa-grid-<?php echo $fields['aacollg']; ?>-lg
        aa-grid-<?php echo $fields['aacolmd']; ?>-md
        aa-grid-<?php echo $fields['aacolsm']; ?>-sm
        aa-grid-<?php echo $fields['aacolxs']; ?>-xs
        <?php echo $attributes ? $attributes['className'] : ''; ?>
        "
        >
            <?php foreach( $fields['colentry'] as $col ): ?>
                <div class="aacolitem">
                    <div class="aacolitemwrap">
                        <?php echo $col['col_content']; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php
    $html = ob_get_clean();
    echo $html;
});