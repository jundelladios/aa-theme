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
        <div class="header-nav-wrap">
            <div id="nav">
                <div class="container header-container position-relative">
                    <div class="d-flex align-items-center">
                            <div class="mobile-menu-wrap">
                                <span class="mobile-menu" id="mobile_toggle_js">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </span>
                            </div>
                            <?php echo aa_header_top_menu(); ?>
                        <div class="search-form">
                            <form action="/">
                                <div class="fgroup">
                                    <input type="text" class="search-input" name="search" placeholder="Search" style="width: 100%;" />
                                    <button type="submit" class="search-btn"><span class="icon-search"></span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="aa-content" class="aa-site-content">