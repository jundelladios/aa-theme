<?php

/**
 * Theme Header Customizer
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package AA_Project
 */

function aa_header_customizer( $wp_customize ) {

	global $aaproject;

	$sectionID = "header_customizer";
	
	$wp_customize->add_section( $sectionID, array(
		'title' => 'Header & Navigation'
	));
	
	$wp_customize->add_setting( $sectionID . '_tagline', array(
        'default' => null,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( $sectionID . '_tagline', array(
        'type' => 'text',
        'section' => $sectionID,
		'label' => __( 'Header Tagline', $aaproject['context'] ),
		'description' => '<span>This will be under the logo.</span>'
	) );

	// Tagline

	$wp_customize->add_setting( $sectionID . '_tagsize', array(
        'default' => 18,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( $sectionID . '_tagsize', array(
        'type' => 'number',
        'section' => $sectionID,
		'label' => __( 'Tagline Fontsize (px)', $aaproject['context'] )
	) );


	$wp_customize->add_setting( $sectionID . '_tagsize_mobile', array(
        'default' => 10,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( $sectionID . '_tagsize_mobile', array(
        'type' => 'number',
        'section' => $sectionID,
		'label' => __( 'Tagline Fontsize Mobile (px)', $aaproject['context'] )
	) );


	// Header Background

	$theme_colors = array();

	$theme_colors[] = array(
		'id' => $sectionID.'_bg',
		'default' => '#383838',
		'label' => __('Header Background', $aaproject['context'])
	);

	aa_customizer_color_loaders( $theme_colors, $wp_customize, $sectionID );

	// Logo Size
	$wp_customize->add_setting( $sectionID . '_logo', array(
        'default' => 355,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( $sectionID . '_logo', array(
        'type' => 'number',
        'section' => $sectionID,
		'label' => __( 'Logo Size Desktop (px)', $aaproject['context'] )
	) );

	$wp_customize->add_setting( $sectionID . '_logo_mobile', array(
        'default' => 118,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( $sectionID . '_logo_mobile', array(
        'type' => 'text',
        'section' => $sectionID,
		'label' => __( 'Logo Size Mobile (px)', $aaproject['context'] )
	) );


}
add_action( 'customize_register', 'aa_header_customizer' );