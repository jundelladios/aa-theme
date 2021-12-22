<?php
/**
 * Register Custom Blocks found at /templates/blocks/
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package AA_Project
 */
function aa_blocks_loader( $files = array(), $repository = '/templates/blocks/' ) {
    if( $files ) {
        foreach( $files as $file ) {
            require get_template_directory() . $repository . $file . '.php';
        }
    }
}

add_action( 'carbon_fields_register_fields', 'aa_blocks_lists' );

function aa_blocks_lists() {

    aa_blocks_loader( array(
        'submenu',
        'slider',
        'submenuv2',
        'blurb',
        'backtotop',
        'products',
        'accordion',
        'content',
        'accordion-secondary',
        'columns'
    ) );
    
}