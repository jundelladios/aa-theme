<?php
/**
 * global variables for this theme
 */
require get_template_directory() . '/inc/vars.php';
/**
 * PHP Libraries
 */
require get_template_directory() . '/vendor/autoload.php';
/**
 * custom template tags for this theme
 */
require get_template_directory() . '/inc/template-tags.php';
/**
 * Register Custom Blocks
 */
require get_template_directory() . '/inc/register-blocks.php';
/**
 * theme hooks and functions
 */
require get_template_directory() . '/inc/theme.php';
/**
 * wp theme customizer
 */
require get_template_directory() . '/inc/customizer.php';
/**
 * load assets for this theme
 */
require get_template_directory() . '/inc/assets.php';
/**
 * admin settings of the theme
 */
require get_template_directory() . '/admin/admin.php';

/**
 * php scss
 */
require get_template_directory() . '/inc/scss.inc.php';


require get_template_directory() . '/reusables.php';


require get_template_directory() . '/performance.php';