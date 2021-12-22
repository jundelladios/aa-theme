<?php

/**
 * Mosaic Module Block
 *
 * @package AA_PROJECT
 */

global $aaproject;

use Carbon_Fields\Field;
use Carbon_Fields\Block;

Block::make( __( 'Product Module' ) )
->set_category( 'aa_blocks', __( 'American Accents', $aaproject['context'] ), 'dashicons-home' )
->set_inner_blocks( false )
->add_fields( array(
    Field::make( 'html', 'cmenuhtml' )
    ->set_html( '<h2>American Accent Product Module</h2>' ),

    Field::make( 'text', 'pmtitle', __( 'Product Module Title' ) )->set_width( 50 )
                    ->set_default_value( "Enter Title" ),

    Field::make( 'complex', 'mosaics_parent_row', __( '' ) )
    ->set_collapsed( true )
    ->add_fields( array(

        Field::make( 'complex', 'mosaics_parent_col', __( '' ) )
        ->set_collapsed( true )
        ->set_layout( 'tabbed-horizontal' )
        ->add_fields( array(

            Field::make( 'text', 'column_parent', __( 'Enter Column [md, lg, sm]( 1 - 12 )' ) )
            ->set_default_value( 6 )
            ->set_width( 50 ),


            Field::make( 'complex', 'mosaics_child_row', __( '' ) )
            ->set_collapsed( true )
            ->add_fields( array(

                Field::make( 'complex', 'mosaics_child_col', __( '' ) )
                ->set_collapsed( true )
                ->set_layout( 'tabbed-horizontal' ) 
                ->add_fields( array(

                    Field::make( 'text', 'column_child', __( 'Enter Column [md, lg, sm]( 1 - 12 )' ) )
                    ->set_default_value( 6 )
                    ->set_width( 50 ),

                    Field::make( 'text', 'mosaic_item_class', __( 'Mosaic Item Custom Class' ) )
                    ->set_default_value( '' )
                    ->set_width( 50 ),

                    Field::make( 'text', 'colheight', __( 'Column Height' ) )->set_width( 50 )
                    ->set_default_value( 342 ),

                    Field::make( 'image', 'image', __( 'Image' ) )->set_width( 50 ),
                    Field::make( 'image', 'texture_image', __( 'Texture Image' ) )->set_width( 50 ),
                    Field::make( 'image', 'texture_hover_image', __( 'Texture Image Hover' ) )->set_width( 50 ),
                    Field::make( 'color', 'background', __( 'Background Color (Texture image will be top priority.)' ) )
                    ->set_default_value( '#1F4385' )
                    ->set_width( 50 ),

                    Field::make( 'text', 'tname', __( 'Category Text' ) )->set_width( 50 )->set_default_value( 'Category Name' ),
                    Field::make( 'select', 'tlayout', 'Content Alignment' )->set_width( 50 )->set_default_value( 'top_left_text' )
                    ->add_options( array(
                        'top_left_text' => 'Top Left Text',
                        'top_right_text' => 'Top Right Text',
                        'rotate_left_text' => 'Rotated Left Text',
                    ) )->set_default_value( 'start' ),

                    
                    Field::make( 'text', 'shoptext', __( 'Shop Text' ) )->set_width( 50 )->set_default_value( 'Shop Now' )->set_width( 50 ),
                    Field::make( 'text', 'shopurl', __( 'Shop URL' ) )->set_width( 50 )->set_default_value( '#' )->set_width( 50 ),

                    Field::make( 'select', 'shoplayout', 'Shop Layout' )->set_width( 50 )->set_default_value( 'blue_left' )
                    ->set_width( 50 )
                    ->add_options( array(
                        'blue_left' => 'Blue Left',
                        'blue_right' => 'Blue Right',
                        'dark_right' => 'Dark Right',
                    ) )->set_default_value( 'blue_right' ),
                    


                    Field::make( 'textarea', 'text_styling', __( 'Text CSS Styling' ) )
                    ->set_help_text( 'ex: font-size:20px;' )
                    ->set_width( 50 ),
                    
                    Field::make( 'textarea', 'image_styling', __( 'Image CSS Styling' ) )
                    ->set_help_text( 'ex: top:0;bottom:0;' )
                    ->set_width( 50 ),


                ))->set_header_template( '<%- tname %>' )


            ))->set_header_template( 'Mosaic child row <%- $_index+1 %>' )

        ))->set_header_template( 'Mosaic parent column <%- $_index+1 %>' )

        
    ))->set_header_template( 'Mosaic parent row <%- $_index+1 %>' )

))
->set_render_callback( function( $fields, $attributes, $inner_blocks ) {
    ?>
    <div class="aa-mosaic-module gt <?php echo $attributes ? $attributes['className'] : ''; ?>">
        <div class="container">

            <?php if( $fields['pmtitle'] ): ?>
                <div class="row title">
                    <div class="col-md-12">
                        <h3><?php echo $fields['pmtitle']; ?></h3>
                    </div>
                </div>
            <?php endif; ?>

            <?php foreach( $fields['mosaics_parent_row'] as $mosaicParentRow ): ?>

                <div class="mosaic-row row">

                    <?php foreach( $mosaicParentRow['mosaics_parent_col'] as $mosaicParentCol ): ?>
                        
                        <div class="mosaic-col col-<?php echo $mosaicParentCol['column_parent']; ?>">

                            <?php foreach( $mosaicParentCol['mosaics_child_row'] as $mosaicChildRow ): ?>

                                <div class="mosaic-row row">

                                    <?php foreach( $mosaicChildRow['mosaics_child_col'] as $mosaicChildCol ): $product =  $mosaicChildCol; ?>

                                        <div class="mosaic-col col-<?php echo $mosaicChildCol['column_child']; ?> <?php echo $mosaicChildCol['mosaic_item_class']; ?>">

                                            <a href="<?php echo $product['shopurl'] ? $product['shopurl'] : '#'; ?>">

                                            <div class="mosaic-item" style="height: <?php echo (int) $mosaicChildCol['colheight']; ?>px;">

                                                <!-- item starts here -->

                                                <?php if( $product['tname'] ): ?>
                                                    <div class="pname <?php echo $product['tlayout']; ?>" style="<?php echo $product['text_styling']; ?>">
                                                        <span><?php echo $product['tname']; ?></span>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if( $product['image'] ): 
                                                    $pimg = wp_get_attachment_image_src( $product['image'], '500' );
                                                    ?>
                                                    <div class="pimage" style="<?php echo $product['image_styling']; ?>">
                                                        <?php aa_lazyimg([
                                                            'src' => $pimg[0],
                                                            'alt' => aa_image_alt( $product['image'] )
                                                        ]); ?>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if( $product['texture_image'] ): 
                                                    $ptextureimg = wp_get_attachment_image_src( $product['texture_image'], '500' );
                                                    ?>
                                                    <div class="ptextureimage lazyload absolute-full bg-cover-center" <?php aa_lazyBg($ptextureimg[0]); ?>></div>
                                                <?php endif; ?>

                                                <?php if( $product['texture_hover_image'] ): 
                                                    $texture_hover_image = wp_get_attachment_image_src( $product['texture_hover_image'], '500' );
                                                    ?>
                                                    <div class="texture_hover_image lazyload absolute-full bg-cover-center" <?php aa_lazyBg($texture_hover_image[0]); ?>></div>
                                                <?php endif; ?>

                                                <?php if( !$product['texture_hover_image'] && $product['background'] ): ?>
                                                    <div class="background absolute-full" style="background: <?php echo $product['background']; ?>;"></div>
                                                <?php endif; ?>


                                                <?php if( $product['shoptext'] ): ?>
                                                    <div class="shoptext <?php echo $product['shoplayout']; ?>">
                                                        <?php echo $product['shoptext']; ?>
                                                    </div>
                                                <?php endif; ?>

                                                <!-- item ends here -->

                                                </a>

                                            </div>

                                        </div>

                                    <?php endforeach; ?>

                                </div>

                            <?php endforeach; ?>

                        </div>
                        
                    <?php endforeach; ?>

                </div>

            <?php endforeach; ?>
            

        </div>
    </div>
    <?php
});