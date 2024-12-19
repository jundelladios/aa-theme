<?php
/**
 * AA Project Global Variables
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package AA_PROJECT
 */

function american_accent_theme_global_vars_init() {
    global $aaproject, $aa_google_fonts;
    $aaproject = array(
        'context' => 'aa_system',
        'logo_args' => 'aa_logo_args',
        'logo' => 'aa_logo',
        'block_icon' => 'laptop',
        'dev' => 'jundell@ad-ios.com',
        'version' => wp_get_theme()->get('Version')
    );
    
    /**
     * Google Fonts
     */
    $aa_google_fonts = array(
        'Roboto' => 'Roboto',
        'Montserrat' => 'Montserrat',
        'Open+Sans' => 'Open Sans',
        'Raleway' => 'Raleway'
    );
}
add_action('init', 'american_accent_theme_global_vars_init');