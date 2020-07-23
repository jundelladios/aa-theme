<?php

/**
 * Theme Social Media Customizer
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package AA_Project
 */

function aa_social_media_customizer( $wp_customize ) {

	global $aaproject;

	$sectionID = "social_customizer";
	
	$wp_customize->add_section( $sectionID, array(
		'title' => 'Social Media'
	));
	
	// Facebook
    $wp_customize->add_setting( $sectionID . '_facebook', array(
        'default' => null,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( $sectionID . '_facebook', array(
        'type' => 'text',
        'section' => $sectionID,
		'label' => __( 'Facebook Link', $aaproject['context'] ),
		'description' => '<span class="icon-facebook"></span> Enter your facebook link here.'
	) );

	$wp_customize->add_setting( $sectionID . '_facebook_txt', array(
        'default' => null,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( $sectionID . '_facebook_txt', array(
        'type' => 'text',
        'section' => $sectionID,
        'label' => __( 'Facebook Text', $aaproject['context'] )
	) );

	
	// Twitter
	$wp_customize->add_setting( $sectionID . '_twitter', array(
        'default' => null,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( $sectionID . '_twitter', array(
        'type' => 'text',
        'section' => $sectionID,
		'label' => __( 'Twitter Link', $aaproject['context'] ),
		'description' => '<span class="icon-twitter"></span> Enter your twitter link here.'
	) );

	$wp_customize->add_setting( $sectionID . '_twitter_txt', array(
        'default' => null,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( $sectionID . '_twitter_txt', array(
        'type' => 'text',
        'section' => $sectionID,
        'label' => __( 'Twitter Text', $aaproject['context'] )
	) );

	// Instagram
	$wp_customize->add_setting( $sectionID . '_instagram', array(
        'default' => null,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( $sectionID . '_instagram', array(
        'type' => 'text',
        'section' => $sectionID,
		'label' => __( 'Instagram Link', $aaproject['context'] ),
		'description' => '<span class="icon-instagram-square"></span> Enter your instagram link here.'
	) );
	
	$wp_customize->add_setting( $sectionID . '_instagram_txt', array(
        'default' => null,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( $sectionID . '_instagram_txt', array(
        'type' => 'text',
        'section' => $sectionID,
        'label' => __( 'Instagram Text', $aaproject['context'] )
	) );

}
add_action( 'customize_register', 'aa_social_media_customizer' );