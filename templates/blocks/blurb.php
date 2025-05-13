<?php

/**
 * Page Blurb Module Block
 *
 * @package AA_PROJECT
 */

global $aaproject;

use Carbon_Fields\Field;
use Carbon_Fields\Block;

Block::make( __( 'Blurb Module' ) )
->set_category( 'aa_blocks', __( 'American Accents', 'american-accennts-theme' ), 'dashicons-home' )
->set_inner_blocks( false )
->add_fields( array(
    Field::make( 'html', 'cmenuhtml' )
    ->set_html( '<h2>American Accent Blurbs</h2>' ),
    Field::make( 'text', 'title', __( 'Blurb Main Title' ) )->set_default_value( 'Page Blurb Title' ),
    Field::make( 'text', 'btxt', __( 'Blurb Button Text' ) )->set_width( 50 )->set_default_value( 'Learn More' ),
    Field::make( 'text', 'burl', __( 'Blurb Button URL' ) )->set_width( 50 )->set_default_value( '#' ),
    Field::make( 'color', 'bgcolor', __( 'Background Color' ) )->set_width( 33.33 )->set_default_value( '#383838' ),
    Field::make( 'color', 'tcolor', __( 'Title Color' ) )->set_width( 33.33 )->set_default_value( '#929292' ),
    Field::make( 'color', 'svgcolor', __( 'SVG Color' ) )->set_width( 33.33 )->set_default_value( '#ffffff' ),
    Field::make( 'complex', 'blurbs', __( '' ) )
    ->set_collapsed( true )
    ->set_layout( 'tabbed-horizontal' )
    ->add_fields( array(
        Field::make( 'image', 'image', 'Blurb Image' )->set_width( 30 ),
        Field::make( 'rich_text', 'content', 'Blurb Content' )->set_width( 70 ),
        Field::make( 'text', 'css_class', 'Blurb Item CSS class' )->set_width( 33.33 )->set_default_value( '' )
    ))
    ->set_header_template( 'Blurb (<%- $_index+1 %>) | <%- title %>' )
))
->set_render_callback( function( $fields, $attributes, $inner_blocks ) {
    ?>
    <div class="aa-page-blurb-module  <?php echo $attributes ? $attributes['className'] : ''; ?>" style="background: <?php echo $fields['bgcolor']; ?>">
        <div class="container gt">

            <?php if( $fields['title'] ): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="title text-center">
                        <h3 style="color: <?php echo $fields['tcolor']; ?>; background: <?php echo $fields['bgcolor']; ?>"><?php echo $fields['title']; ?></h3>
                        <span class="divider" style="border: 1px solid <?php echo $fields['tcolor']; ?>;"></span>
                    </div>
                </div>
            </div>
            <?php endif; ?>


            <div class="row blurb-items-wrap gt">
                <?php foreach( $fields['blurbs'] as $blurbs ): 
                    $image = wp_get_attachment_image_src( $blurbs['image'], '64' );
                    $alt = aa_image_alt( $blurbs['image'] );
                ?>
                    <div class="blurb-item col-md-4 text-center <?php echo $blurbs['css_class']; ?>">
                        <div class="blurb-item-content-wrap">
                            <?php if( $blurbs['image'] ): ?>
                                <div class="img-wrap">
                                    <img src="<?php echo $image[0]; ?>" alt="<?php echo $alt; ?>" />
                                </div>
                            <?php endif; ?>    
                            <?php if ( $blurbs['content'] ): ?>
                                <div class="content-wrap">
                                    <?php echo $blurbs['content']; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php if( $fields['btxt'] ): ?>
            <div class="row">
                <div class="col-md-12 text-center">
                    <a href="<?php echo $fields['burl'] ? $fields['burl'] : "#"; ?>" class="btn btn-default">
                        <?php echo $fields['btxt']; ?>
                    </a>                    
                </div>
            </div>
            <?php endif; ?>

        </div>

        <div class="svg" style="background: <?php echo $fields['svgcolor']; ?>;"></div>
    </div>
    <?php
});