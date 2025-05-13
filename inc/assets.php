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

    // Enqueue Stylesheets
    wp_enqueue_style( 'bootstrap-theme-css', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css', array(), $aaproject['version'], null );
    wp_enqueue_style( 'theme-main', get_template_directory_uri() . '/assets/css/style.css', array(), $aaproject['version'], null );

    /** inline css */
    ob_start();
    echo file_get_contents( get_template_directory() . "/style.css" );
    echo file_get_contents( get_template_directory() . "/assets/libs/slick.min.css" );
    $fontURL = 'https://fonts.googleapis.com/css2?family=' . get_theme_mod( 'font_customizer_font_style', reset( $aa_google_fonts ) ) . ':ital,wght@0,400;0,900;1,400;1,900&display=swap';
    $data = wp_remote_get( $fontURL );
    if( !is_wp_error( $data  )) {
        echo wp_remote_retrieve_body( $data );
    }
    // iconmoon inline
    echo file_get_contents( get_template_directory_uri() . '/assets/iconmoon/style.css' );
    $cssinline = ob_get_clean();
    // fix icomoon font url
    $cssinline = str_replace('fonts/icomoon', get_template_directory_uri() . '/assets/iconmoon/fonts/icomoon', $cssinline );
    wp_add_inline_style( 'theme-main', $cssinline );
    /** end inline css */

    // Enqueue Scripts in footer
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

// /** remove wp emoji */
// /**
//  * Disable the emoji's
//  */
// function disable_emojis() {
//     remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
//     remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
//     remove_action( 'wp_print_styles', 'print_emoji_styles' );
//     remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
//     remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
//     remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
//     remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
//     add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
//     add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
//    }
//    add_action( 'init', 'disable_emojis' );
   
//    /**
//     * Filter function used to remove the tinymce emoji plugin.
//     * 
//     * @param array $plugins 
//     * @return array Difference betwen the two arrays
//     */
//    function disable_emojis_tinymce( $plugins ) {
//     if ( is_array( $plugins ) ) {
//     return array_diff( $plugins, array( 'wpemoji' ) );
//     } else {
//     return array();
//     }
//    }
   
//    /**
//     * Remove emoji CDN hostname from DNS prefetching hints.
//     *
//     * @param array $urls URLs to print for resource hints.
//     * @param string $relation_type The relation type the URLs are printed for.
//     * @return array Difference betwen the two arrays.
//     */
//    function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
//     if ( 'dns-prefetch' == $relation_type ) {
//     /** This filter is documented in wp-includes/formatting.php */
//     $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
   
//    $urls = array_diff( $urls, array( $emoji_svg_url ) );
//     }
   
//    return $urls;
// }