<?php

/**
 * Theme Fonts Customizer
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package AA_Project
 */

function aa_typography_customizer( $wp_customize ) {

    global $aaproject;

    global $aa_google_fonts;

    $sectionID = "font_customizer";

    $wp_customize->add_section( $sectionID, array(
		'title' => __( 'Fonts', $aaproject['context'] )
    ));
        

    $wp_customize->add_setting( $sectionID . '_font_style', array(
        'default' => reset( $aa_google_fonts ),
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        $sectionID . '_font_style',
        array(
            'settings' => $sectionID . '_font_style',
            'label' => __( 'Choose Font Style', $aaproject['context'] ),
            'description' => 'Fonts styles from google fonts. <a href="https://fonts.google.com/" target="_blank">Google Fonts</a>, If you want to add more font contact <a href="mailto:'.$aaproject['dev'].'" target="_blank">Developer</a>',
            'section' => $sectionID,
            'type' => 'select',
            'choices' => $aa_google_fonts
        )
    ) );


    $wp_customize->add_setting( $sectionID . '_text_desktop', array(
        'default' => 16,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( $sectionID . '_text_desktop', array(
        'type' => 'text',
        'section' => $sectionID,
        'label' => __( 'Body Text Desktop', $aaproject['context'] ),
        'description' => 'Default font size on body text.'
    ) );


    $wp_customize->add_setting( $sectionID . '_text_mobile', array(
        'default' => 14,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( $sectionID . '_text_mobile', array(
        'type' => 'text',
        'section' => $sectionID,
        'label' => __( 'Body Text Mobile', $aaproject['context'] )
    ) );

}
add_action( 'customize_register', 'aa_typography_customizer' );