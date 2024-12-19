<?php

/**
 * Submenu Module Block
 *
 * @package AA_PROJECT
 */

global $aaproject;

use Carbon_Fields\Field;
use Carbon_Fields\Block;

// $notice = 'You have to publish this post first, then refresh the page.';
// if( isset( $_GET['post'] ) ) {
//     if(!is_array($_GET['post'])) {
//         $notice = '<p>Use this shortcode for menu description - [american-accents-submenu menuid="' . $_GET['post']  . '"]</p>';
//         if( function_exists( 'aa_app_suffix' ) ) {
//             $adminLink = admin_url( 'admin.php?page=' . aa_app_suffix() );
//             $notice .= "<p><a href=\"{$adminLink}categories\" target=\"_blank\">Click Here</a> to choose product category then paste the reference ID.</p>";
//         }
//     }
// }

Block::make( __( 'Category Menus' ) )
->set_category( 'aa_blocks', __( 'American Accents', 'american-accennts-theme' ), 'dashicons-menu' )
->set_inner_blocks( false )
->add_fields( array(
    // Field::make( 'html', 'cmenuhtml' )
    // ->set_html( '<h2>Category Menu</h2>'. $notice ),
    Field::make( 'checkbox', 'submenu_tags_link', __( 'Enable submenu tags link?', 'american-accents-theme' ) ),
    Field::make( 'text', 'submenu_shop_all_text', __( 'Shop ALL Text', 'american-accents-theme' ) ),
    Field::make( 'text', 'submenu_shop_all_link', __( 'Shop ALL Link', 'american-accents-theme' ) ),
    Field::make( 'complex', 'column', '' )
    ->set_layout( 'tabbed-horizontal' )
    ->set_max(4)
    ->add_fields( array(
        Field::make( 'complex', 'rowmenu', __( 'Reference Rows', 'american-accennts-theme' ) )
        ->add_fields( array(
            Field::make( 'text', 'cat_ref', 'Enter Category REF ID' )
        ))
    ))
    ->set_header_template( 'Menu Column <%- $_index+1 %>' )
))
->set_render_callback( function( $fields, $attributes, $inner_blocks ) {

    if( function_exists( 'aa_sc_category' ) ) {
        ob_start();
        $submenutaglink = (int) $fields['submenu_tags_link'];
        ?>
        <div class="aa-submenu-module <?php echo $attributes ? $attributes['className'] : ''; ?>">
            <div class="row">
                <?php $grids = 12/count( $fields['column'] ); ?>
                <?php foreach( $fields['column'] as $column ): ?>
                    <div class="col-lg-<?php echo $grids; ?>">
                        <?php if( $column['rowmenu'] ): ?>
                            <?php foreach( $column['rowmenu'] as $rowmenu ): ?>
                                <?php echo '[aa_sc_category ref_id="' . $rowmenu['cat_ref'] . '" submenutag='.$submenutaglink.']'; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php if($fields['submenu_shop_all_text']): ?>
            <div class="row shop-all-text-menu">
                <div class="col-lg-12 d-flex justify-content-end">
                    <a href="<?php echo $fields['submenu_shop_all_link'] ?? '#'; ?>" class="shop-all-link text-uppercase font-weight-bold mr-3"><?php echo $fields['submenu_shop_all_text']; ?></a>
                </div>
            </div>
            <?php endif; ?>

        </div>
        <?php
        $html = ob_get_clean();
        echo $html;
    }
});