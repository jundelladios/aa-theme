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
    <script src="<?php echo get_template_directory_uri() . '/assets/js/lazysizes.js'; ?>" async></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<?php wp_head(); ?>
	
	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-K5867W7');</script>
<!-- End Google Tag Manager -->
	
	<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-245654905-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-245654905-1');
</script>
	
	<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-8BS2XG0994"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-8BS2XG0994');
</script>
</head>
<body <?php body_class();?>>
<div id="aa-page" class="aa-site">
    <header>
        <?php echo aa_social_media_header(); ?>
        <div id="logo" class="gt text-center">
            <?php echo aa_site_logo_v2(); ?>
            <?php echo aa_header_tagline(); ?>
        </div>
        <div class="desktop header-nav-wrap">
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
                            <form action="<?php echo get_home_url(); ?>/product/search">
                                <div class="fgroup">
                                    <input type="text" class="search-input" value="<?php echo get_query_var('q'); ?>" name="q" placeholder="Search Product" style="width: 100%;" />
                                    <button type="submit" class="search-btn"><span class="icon-search"></span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mobile header-nav-wrap">
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
                            <form action="<?php echo get_home_url(); ?>/product/search">
                                <div class="fgroup">
                                    <input type="text" class="search-input" value="<?php echo get_query_var('q'); ?>" name="q" placeholder="Search Product" style="width: 100%;" />
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