<?php

/**
 * Theme Footer Customizer
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package AA_Project
 */

function aa_footer_customizer( $wp_customize ) {

    global $aaproject;

	$sectionID = "footer_customizer";
	
	$wp_customize->add_section( $sectionID, array(
		'title' => __( 'Footer', 'american-accennts-theme' )
	));
	
    $theme_colors = array();

    $theme_colors[] = array(
        'id' => $sectionID.'_bg',
        'default' => '#1F4385',
        'label' => 'Footer Background'
    );

    $theme_colors[] = array(
        'id' => $sectionID.'_header_color',
        'default' => '#FFFFFF',
        'label' => 'Footer Header Color'
    );

    $theme_colors[] = array(
        'id' => $sectionID.'_text_color',
        'default' => '#9EB2D6',
        'label' => 'Text Color'
    );

    $theme_colors[] = array(
        'id' => $sectionID.'_link_color',
        'default' => '#9EB2D6',
        'label' => 'Link Color'
    );

    $theme_colors[] = array(
        'id' => $sectionID.'_link_hover_color',
        'default' => '#FFFFFF',
        'label' => 'Link Hover Color'
    );

    aa_customizer_color_loaders( $theme_colors, $wp_customize, $sectionID );

    // Footer Header
    
    $wp_customize->add_setting( $sectionID . '_header_text_desktop', array(
        'default' => 18,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( $sectionID . '_header_text_desktop', array(
        'type' => 'text',
        'section' => $sectionID,
        'label' => __( 'Header Text Desktop', 'american-accennts-theme' )
    ) );

    $wp_customize->add_setting( $sectionID . '_header_text_mobile', array(
        'default' => 18,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( $sectionID . '_header_text_mobile', array(
        'type' => 'text',
        'section' => $sectionID,
        'label' => __( 'Header Text Mobile', 'american-accennts-theme' )
    ) );

    // Footer Text

    $wp_customize->add_setting( $sectionID . '_body_text_desktop', array(
        'default' => 16,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( $sectionID . '_body_text_desktop', array(
        'type' => 'text',
        'section' => $sectionID,
        'label' => __( 'Body Text Desktop', 'american-accennts-theme' )
    ) );

    $wp_customize->add_setting( $sectionID . '_body_text_mobile', array(
        'default' => 14,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( $sectionID . '_body_text_mobile', array(
        'type' => 'text',
        'section' => $sectionID,
        'label' => __( 'Body Text Mobile', 'american-accennts-theme' )
    ) );
    
    
}
add_action( 'customize_register', 'aa_footer_customizer' );