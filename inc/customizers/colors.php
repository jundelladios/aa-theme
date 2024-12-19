<?php

/**
 * Theme Colors Customizer
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package AA_Project
 */

function aa_colors_customizer( $wp_customize ) {

    global $aaproject;

    $sectionID = "colors_customizer";
    
    $wp_customize->add_section( $sectionID, array(
		'title' => __( 'Theme Colors', 'american-accennts-theme' )
	));

    $theme_colors = array();

    $theme_colors[] = array(
        'id' => $sectionID.'_primary',
        'default' => '#1f4385',
        'label' => 'Primary Color'
    );

    $theme_colors[] = array(
        'id' => $sectionID.'_secondary',
        'default' => '#383838',
        'label' => 'Secondary Color'
    );

    $theme_colors[] = array(
        'id' => $sectionID.'_tertiary',
        'default' => '#9EB2D6',
        'label' => 'Tertiary Color'
    );

    $theme_colors[] = array(
        'id' => $sectionID.'_light',
        'default' => '#ffffff',
        'label' => 'Light Color'
    );

    $theme_colors[] = array(
        'id' => $sectionID.'_dark',
        'default' => '#222222',
        'label' => 'Dark Color'
    );

    $theme_colors[] = array(
        'id' => $sectionID.'_darkv2',
        'default' => '#383838',
        'label' => 'Dark Light Color'
    );

    aa_customizer_color_loaders( $theme_colors, $wp_customize, $sectionID );    
    
}
add_action( 'customize_register', 'aa_colors_customizer' );