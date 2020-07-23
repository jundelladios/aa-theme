<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package American_Vanity
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class();?>>
<div id="aa-page" class="aa-site">
    <header>
        <?php echo aa_social_media_header(); ?>
        <div id="logo" class="gt text-center">
            <?php echo aa_site_logo(); ?>
            <?php echo aa_header_tagline(); ?>
        </div>
        <div id="nav">
            <div class="container">
                <div class="d-flex align-items-center">
                    <?php echo aa_header_top_menu(); ?>
                    <div class="search-form">
                        <form action="/">
                            <input type="text" name="search" placeholder="Search" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="aa-content" class="aa-site-content">