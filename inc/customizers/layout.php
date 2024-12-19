<?php

/**
 * Theme Layout Customizer
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package AA_Project
 */

function aa_layout_customizer( $wp_customize ) {

    global $aaproject;

    $sectionID = "layout_customizer";
    
    $wp_customize->add_section( $sectionID, array(
		'title' => __( 'Layout', 'american-accennts-theme' )
    ));
    
    $wp_customize->add_setting( $sectionID . '_gutter_spacing_desktop', array(
        'default' => 50,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( $sectionID . '_gutter_spacing_desktop', array(
        'type' => 'text',
        'section' => $sectionID,
        'label' => __( 'Gutter Spacing Desktop', 'american-accennts-theme' ),
        'description' => 'Spacing from top and bottom on each containers to make them consistent.'
    ) );

    $wp_customize->add_setting( $sectionID . '_gutter_spacing_mobile', array(
        'default' => 30,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( $sectionID . '_gutter_spacing_mobile', array(
        'type' => 'text',
        'section' => $sectionID,
        'label' => __( 'Gutter Spacing Tablet/Mobile', 'american-accennts-theme' )
    ) );
}
add_action( 'customize_register', 'aa_layout_customizer' );