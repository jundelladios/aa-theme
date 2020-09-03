<?php

/**
 * Submenu Module Block
 *
 * @package AA_PROJECT
 */

global $aaproject;

use Carbon_Fields\Field;
use Carbon_Fields\Block;

$notice = 'You have to publish this post first, then refresh the page.';
if( isset( $_GET['post'] ) ) {
    $notice = 'Use this shortcode for menu description - [american-accents-submenu menuid="' . $_GET['post']  . '"]';
}

Block::make( __( 'Sub Menus' ) )
->set_category( 'aa_submenu', __( 'American Accents Submenus', $aaproject['context'] ), 'dashicons-menu' )
->set_inner_blocks( false )
->add_fields( array(
    Field::make( 'complex', 'column', $notice )
    ->set_layout( 'tabbed-horizontal' )
    ->set_collapsed( true )
    ->set_max(4)
    ->add_fields( array(
        Field::make( 'complex', 'submenus', __( 'Submenus', $aaproject['context'] ) )
        ->set_collapsed( true )
        ->add_fields( array(
            Field::make( 'text', 'ptitle', 'Menu Group Title' )->set_width( 50 ),
            Field::make( 'text', 'psubtext', 'Menu Grou Subtitle' )->set_width( 50 ),
            Field::make( 'complex', 'gitems', __( 'Menu Group Items', $aaproject['context'] ) )
            ->set_collapsed( true )
            ->add_fields( array(
                Field::make( 'text', 'stitle', 'Menu Group Item Title' ),
                Field::make( 'complex', 'items', __( 'Submenu Items', $aaproject['context'] ) )
                ->set_collapsed( true )
                ->add_fields( array(
                    Field::make( 'text', 'text', 'Menu Link Text' )->set_width( 50 ),
                    Field::make( 'text', 'link', 'Menu Link URL' )->set_width( 50 ),
                    Field::make( 'text', 'attrs', 'Menu Attributes ( Separated by comma "," ) | ex: target="blank",download' )->set_width( 50 )
                ) )
                ->set_header_template( 'Menu Link Item <%- $_index+1 %>' )
            ))
            ->set_header_template( 'Menu Group Item <%- $_index+1 %>' )
        ) )
        ->set_header_template( '<%- ptitle %>' )
    ))
    ->set_header_template( 'Menu Column <%- $_index+1 %>' )
) )
->set_preview_mode( false )
->set_render_callback( function( $fields, $attributes, $inner_blocks ) {
    if( $fields['column'] ):
    ?>
    <div class="aa-submenu-module <?php echo $attributes ? $attributes['className'] : ''; ?>">
        <div class="row">
            <?php $grids = 12/count( $fields['column'] ); ?>
            <?php foreach( $fields['column'] as $column ): ?>
                <div class="col-md-<?php echo $grids; ?>">
                    <div id="<?php echo $column['_id']; ?>" class="menu-col-item-wrap">
                        <?php if( $column['submenus'] ): ?>
                            <?php foreach( $column['submenus'] as $submenus ): ?>

                                <div id="<?php echo $submenus['_id']; ?>" class="submenus-wrap">
                                
                                    <?php if( $submenus['ptitle'] ): ?>
                                            <strong class="ptitle d-block"><?php echo $submenus['ptitle']; ?>
                                                <?php if( $submenus['psubtext'] ): ?>
                                                    <span class="psubtext"><?php echo $submenus['psubtext']; ?></span>
                                                <?php endif; ?>
                                            </strong>
                                    <?php endif; ?>

                                    <div class="grouped-menu-items-wrap" id="gitemwrap">
                                        <?php if( $submenus['gitems'] ): ?>
                                            <?php foreach( $submenus['gitems'] as $gitems ): ?>
                                                <div id="<?php echo $gitems['_id']; ?>" class="grouped-menu-item-child-list">
                                                    <?php if( $gitems['stitle'] ): ?><strong class="stitle d-block"><?php echo $gitems['stitle']; ?></strong><?php endif; ?>
                                                    <?php if( $gitems['items'] ): ?>
                                                        <ul class="list-unstyled link-ul-item">
                                                            <?php foreach( $gitems['items'] as $item ): ?>
                                                                <?php 
                                                                    $link = $item['link'] ? $item['link'] : '#';
                                                                    $attrs = null;
                                                                    if( $item['attrs'] ) {
                                                                        $split = explode( ",", $item['attrs'] );
                                                                        $attrs = join( " ", $split );
                                                                        $attrs .= " ";
                                                                    }
                                                                ?>
                                                                <?php if( $item['text'] ): ?>
                                                                    <li id="<?php echo $item['_id']; ?>" class="link-item"><a class="link-item-anchor" <?php echo $attrs; ?> href="<?php echo $link; ?>"><?php echo $item['text']; ?></a></li>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    endif;
} );