<?php
/**
 * Load Assets to Frontend
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package AA_Project
 */

function aa_load_assets() {

    global $aa_google_fonts;

    global $aaproject;
    
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    wp_dequeue_style( 'wp-block-library' );

    // Enqueue Stylesheets
    wp_enqueue_style( 'bootstrap-theme-css', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css', array(), $aaproject['version'], null );
    wp_enqueue_style( 'theme-main', get_template_directory_uri() . '/assets/css/style.css', array(), $aaproject['version'], null );
    wp_enqueue_style( 'theme-css', get_template_directory_uri() . '/style.css', array(), $aaproject['version'], null );
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=' . get_theme_mod( 'font_customizer_font_style', reset( $aa_google_fonts ) ) . ':ital,wght@0,400;0,900;1,400;1,900&display=swap', array(), null, null );
    wp_enqueue_style( 'theme-icons', get_template_directory_uri() . '/assets/iconmoon/style.css', array(), $aaproject['version'], null );
    wp_enqueue_style( 'slick-slider', get_template_directory_uri() . '/assets/libs/slick.min.css', array(), $aaproject['version'], null );

    // remove media element wp
    wp_deregister_script('wp-mediaelement');
    wp_deregister_style('wp-mediaelement');

    // Enqueue Scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'boostrap-theme-js', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.bundle.min.js', array('jquery'), $aaproject['version'], true );
    wp_enqueue_script( 'theme-js', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), $aaproject['version'], true );
    wp_enqueue_script( 'slick-slider', get_template_directory_uri() . '/assets/libs/slick.min.js', array('jquery'), $aaproject['version'], true );
}
add_action( 'wp_enqueue_scripts', 'aa_load_assets' );


function aa_deregister_scripts_footer(){
    wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'aa_deregister_scripts_footer' );