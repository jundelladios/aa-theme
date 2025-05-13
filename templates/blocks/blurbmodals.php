<?php

/**
 * Columns Module Block
 *
 * @package AA_PROJECT
 */

global $aaproject;

use Carbon_Fields\Field;
use Carbon_Fields\Block;

Block::make( __( 'Blurb with Modal' ) )
->set_category( 'aa_blocks', __( 'American Accents', 'american-accennts-theme' ), 'dashicons-home' )
->set_inner_blocks( false )
->add_fields( array(
    Field::make( 'html', 'columnshtml' )
    ->set_html( '<h2>Blurb with Modal</h2>' ),
    Field::make( 'text', 'aacol', __( 'Default Column' ) )->set_width( 25 )->set_default_value( '6' ),
    Field::make( 'text', 'aacolxl', __( 'Column XL' ) )->set_width( 25 )->set_default_value( '5' ),
    Field::make( 'text', 'aacollg', __( 'Column LG' ) )->set_width( 25 )->set_default_value( '4' ),
    Field::make( 'text', 'aacolmd', __( 'Column MD' ) )->set_width( 25 )->set_default_value( '3' ),
    Field::make( 'text', 'aacolsm', __( 'Column SM' ) )->set_width( 25 )->set_default_value( '2' ),
    Field::make( 'text', 'aacolxs', __( 'Column XS' ) )->set_width( 25 )->set_default_value( '2' ),
    Field::make( 'text', 'colgap', __( 'Column Gap' ) )->set_width( 50 )->set_default_value( '20px' ),

    Field::make( 'checkbox', 'showtitle', __( 'Show Title?' ) )->set_width( 25 )->set_default_value( 1 ),
    Field::make( 'checkbox', 'modalenabled', __( 'Enable Modal Preview' ) )->set_width( 25 )->set_default_value( 1 ),
    Field::make( 'checkbox', 'emailenabled', __( 'Enable Email' ) )->set_width( 25 )->set_default_value( 1 ),
    Field::make( 'checkbox', 'printenabled', __( 'Enable Print' ) )->set_width( 25 )->set_default_value( 1 ),
    Field::make( 'checkbox', 'shareenabled', __( 'Enable Share' ) )->set_width( 25 )->set_default_value( 1 ),
    Field::make( 'checkbox', 'downloadenabled', __( 'Enable Download' ) )->set_width( 25 )->set_default_value( 1 ),


    Field::make( 'text', 'modalmaintitle', __( 'Modal Main Title' ) )->set_width( 50 ),
    Field::make( 'text', 'modalsubtitle', __( 'Modal Sub-Title' ) )->set_width( 50 ),


    Field::make( 'complex', 'colentry', __( 'Blurb Items' ) )
    ->set_collapsed( true )
    ->set_layout( 'tabbed-horizontal' )
    ->add_fields( array(
        Field::make( 'text', 'title', 'Blurb Title' )->set_width( 30 ),
        Field::make( 'text', 'modaltitle', 'Modal Blurb Title' )->set_width( 30 ),
        Field::make( 'text', 'printtitle', 'Printable Title' )->set_width( 30 ),
        Field::make( 'image', 'image', 'Blurb Image' )->set_width( 30 ),
        Field::make( 'rich_text', 'content', 'Blurb Content' )->set_width( 70 ),
        Field::make( 'text', 'css_class', 'Blurb Item CSS class' )->set_width( 33.33 )->set_default_value( '' )
    ))
    ->set_header_template( 'Blurb (<%- $_index+1 %>) | <%- title %>' )
))
->set_render_callback( function( $fields, $attributes, $inner_blocks ) {
    ob_start();

    $moduleid = wp_unique_id( 'blurb_module_' );

    $entryReusableModal = [];

    ?>
        <div
        data-module-id="<?php echo $moduleid; ?>"
        class="<?php echo $attributes ? $attributes['className'] : ''; ?>"
        >
            <div 
            class="aa-grid 
            aa-grid-<?php echo $fields['aacol']; ?> 
            aa-grid-<?php echo $fields['aacolxl']; ?>-xl
            aa-grid-<?php echo $fields['aacollg']; ?>-lg
            aa-grid-<?php echo $fields['aacolmd']; ?>-md
            aa-grid-<?php echo $fields['aacolsm']; ?>-sm
            aa-grid-<?php echo $fields['aacolxs']; ?>-xs
            blurbmodalmodule
            "
            <?php if($fields['colgap']): ?>
                style="column-gap:<?php echo $fields['colgap']; ?>;"
            <?php endif; ?>
            >
                <?php 
                    $firstindexer = 0;
                    foreach( $fields['colentry'] as $col ): 
                    
                    $image = wp_get_attachment_image_src( $col['image'], 'full' );
                    $alt = aa_image_alt( $col['image'] );
                    
                    $entryReusableModal[] = array(
                        '_modal_image' => $image[0],
                        '_modal_image_alt' => $alt,
                        '_modal_print_title' => $col['printtitle'],
                        '_modal_label' => strip_tags($col['content'])
                    );

                    ?>
                    <div class="position-relative scwrap">
                        <?php if(isset($image[0])): ?>
                        <div class="mb-3 cursor-pointer" data-modal-trigger="<?php echo $firstindexer; ?>">
                            <img src="<?php echo $image[0]; ?>" alt="<?php echo $alt; ?>" />
                        </div>
                        <?php endif; ?>
                        <div class="text-center blurbcontent">
                            <?php if($col['title'] && $fields['showtitle']): ?>
                                <h5 class="blurbtitle mb-1"><?php echo $col['title']; ?></h5>
                            <?php endif; ?>
                            <?php echo $col['content']; ?>
                        </div>
                    </div>
                <?php 
                $firstindexer++;
                endforeach; ?>
            </div>
        </div>

        

        <?php if($fields['modalenabled']): ?>
        
            <?php 
                if( function_exists('americanAccentsReusableModalContent')):
                echo americanAccentsReusableModalContent( 
                    $moduleid, 
                    $entryReusableModal, 
                    [
                        'modal_title' => $fields['modalmaintitle'],
                        'modal_subtitle' => $fields['modalsubtitle'],
                        'download_file_name' => $fields['modalmaintitle'] . ' ' . $fields['modalsubtitle']
                    ]
                ); 
                endif;
            ?>

        <?php endif; ?>


    <?php
    $html = ob_get_clean();
    echo apply_filters( 'the_content', $html );
});