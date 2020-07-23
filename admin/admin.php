<?php

/**
 * Wp Admin Settings
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package AA_Project
 */

/**
 * Theme Icons Storage
 */
function aa_admin_icon_storage() {
    add_options_page( 'Theme Icons', 'Theme Icons', 'manage_options', 'american-accents-icons', 'aa_admin_icons_page' );
}
add_action( 'admin_menu', 'aa_admin_icon_storage' );

/**
 * Theme Icons Storage Page
 */
function aa_admin_icons_page() {
    require_once( get_template_directory() . '/admin/templates/icons.php' );
}

/**
 * Theme admin assets
 */
function aa_admin_assets() {

    wp_enqueue_style( 'aa-icon-moon-admin', get_template_directory_uri() . '/assets/iconmoon/style.css', false, '1.0.0' );

}

add_action( 'admin_enqueue_scripts', 'aa_admin_assets' );


add_action( 'admin_post_aa_iconmoon_import', 'aa_iconmoon_import' );
function aa_iconmoon_import() {
    $zip = new ZipArchive;
    $res = $zip->open($_FILES['file']['tmp_name']);
    if ($res === TRUE && $zip->locateName('selection.json') !== false && $zip->locateName('style.css') !== false) {
        $zip->extractTo(get_template_directory() . '/assets/iconmoon/');
        $zip->close();
        wp_redirect($_POST['page'] . '&success=1');
    } else {
        wp_redirect($_POST['page'] . '&success=0');
    }
}