<?php
/**
 * AA Project functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package AA_PROJECT
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function aa_system_setup() {

	global $aaproject;

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Top Header', 'american-accennts-theme' ),
	) );

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 250,
		'width'       => 250,
		'flex-width'  => true,
		'flex-height' => true,
	) );
}
add_action( 'after_setup_theme', 'aa_system_setup' );

/**
 * Initialize Carbon Fields
 */

function carbon_fields_init() {
	\Carbon_Fields\Carbon_Fields::boot();
}
add_action( 'after_setup_theme', 'carbon_fields_init' );


/**
 * Footer Widgets
 */
function aa_footer_widget() {
    register_sidebar( array(
        'name' => 'Footer Column 1',
        'id' => 'aa_footer_1',
        'before_widget' => '<div class="aa-widget-wrap">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="aa-widget-title h-line">',
        'after_title' => '</h4>',
	) );
	
	register_sidebar( array(
        'name' => 'Footer Column 2',
        'id' => 'aa_footer_2',
        'before_widget' => '<div class="aa-widget-wrap">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="aa-widget-title h-line">',
        'after_title' => '</h4>',
	) );


	register_sidebar( array(
        'name' => 'Footer Column 3',
        'id' => 'aa_footer_3',
        'before_widget' => '<div class="aa-widget-wrap">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="aa-widget-title h-line">',
        'after_title' => '</h4>',
	) );

	register_sidebar( array(
        'name' => 'Footer Column 4',
        'id' => 'aa_footer_4',
        'before_widget' => '<div class="aa-widget-wrap d-flex align-items-center justify-content-center">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="aa-widget-title h-line">',
        'after_title' => '</h4>',
	) );


	register_sidebar( array(
        'name' => 'Printable Header',
        'id' => 'aa_printable_header',
        'before_widget' => '<div class="aa-widget-wrap d-flex align-items-center justify-content-center">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="aa-widget-title h-line">',
        'after_title' => '</h4>',
	) );

	register_sidebar( array(
        'name' => 'Printable Footer',
        'id' => 'aa_printable_footer',
        'before_widget' => '<div class="aa-widget-wrap d-flex align-items-center justify-content-center">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="aa-widget-title h-line">',
        'after_title' => '</h4>',
	) );
}
add_action( 'widgets_init', 'aa_footer_widget' );

/**
 * Register Social Media Widget.
 * 
 */

add_action( 'widgets_init', 'aa_register_widgets' ); 
function aa_register_widgets() {
    register_widget( new Wordpress\Widgets\SocialMediaWidgetClass );
}

/**
 * 
 * Header Menu
 * 
 */
function aa_header_top_menu() {
	ob_start();
	$walker = new Wordpress\Menu\MenuWithDescriptionClass;
	?>
	<nav class="nav-menu">
		<?php 
		wp_nav_menu( array(
			'theme_location' => 'menu-1',
			'menu_id'        => 'main-menu',
			'menu_class' => 'list-unstyled mb-0',
			'walker' => $walker
		) );
		?>
	</nav>
	<?php
	$html = ob_get_clean();
	return $html;
}


/**
 * 
 * Social Media Header
 * 
 */

function aa_social_media_header() {
	ob_start();
	?>
	<div class="container position-relative">
		<div class="social-media-header">
			<ul class="list-unstyled social-header mb-0">
				<?php if( get_theme_mod( 'social_customizer_facebook' ) ): ?>
					<li class="social-header-item"><a href="<?php echo get_theme_mod( 'social_customizer_facebook' ); ?>" title="Facebook" target="_blank"><span class="social-icon-header icon-facebook-square"></span></a>
				<?php endif; ?>
				<?php if( get_theme_mod( 'social_customizer_twitter' ) ): ?>
					<li class="social-header-item"><a href="<?php echo get_theme_mod( 'social_customizer_twitter' ); ?>" title="Twitter" target="_blank"><span class="social-icon-header icon-twitter-square"></span></a>
				<?php endif; ?>
				<?php if( get_theme_mod( 'social_customizer_instagram' ) ): ?>
					<li class="social-header-item"><a href="<?php echo get_theme_mod( 'social_customizer_instagram' ); ?>" title="Instagram" target="_blank"><span class="social-icon-header icon-instagram-square"></span></a>
				<?php endif; ?>
			</ul>
		</div>
	</div>
	<?php
	$html = ob_get_clean();
	return $html;
}

/**
 * 
 * Header Tagline
 * 
 */

function aa_header_tagline() {
	ob_start();
	?>
	<?php if( get_theme_mod( 'header_customizer_tagline' ) ): ?>
		<p class="text-center text-uppercase text-light mb-0 h-tagline"><?php echo get_theme_mod( 'header_customizer_tagline' ); ?></p>
	<?php endif; ?>
	<?php
	$html = ob_get_clean();
	return $html;
}

/**
 * Submenu Shortcode
 */
function aa_ac_shortcode( $attributes ) {
	$attrs = shortcode_atts( array(
		'id' => null
	), $attributes );
	
	return apply_filters('the_content', get_post_field('post_content', $attrs['id']));
}
add_shortcode( 'sc-content', 'aa_ac_shortcode' );

// get image alt
function aa_image_alt( $img ) {

	if( !$img ) return null;

	return get_post_meta( $img, '_wp_attachment_image_alt', true );

}

// handler
function __e( $value ) {
	if( isset( $value ) ) return $value;
	else return null;
}