<?php

/**
 * SASS PHP GENERATOR
 */

use ScssPhp\ScssPhp\Compiler;

function aa_css_generator_customizer() {

	global $aa_google_fonts;

	$compiler = new Compiler();
 
	$source_scss = get_stylesheet_directory() . '/assets/sass/style.scss';

	$scssContents = file_get_contents($source_scss);

	$import_path = get_stylesheet_directory() . '/assets/scss';

	$compiler->addImportPath($import_path);

	$variables = [
		'$colors_customizer_primary' => get_theme_mod('colors_customizer_primary', '#1f4385'),
		'$colors_customizer_secondary' => get_theme_mod('colors_customizer_secondary', '#383838'),
		'$colors_customizer_tertiary' => get_theme_mod('colors_customizer_tertiary', '#9EB2D6'),
		'$colors_customizer_light' => get_theme_mod('colors_customizer_light', '#ffffff'),
		'$colors_customizer_dark' => get_theme_mod('colors_customizer_dark', '#222222'),
		'$colors_customizer_darkv2' => get_theme_mod('colors_customizer_darkv2', '#383838'),
		'$font_customizer_font_style' => str_replace('+', ' ', get_theme_mod( 'font_customizer_font_style', reset( $aa_google_fonts ) )) . ', sans-serif',
		'$header_customizer_bg' => get_theme_mod( 'header_customizer_bg', '#383838' ),
		'$header_customizer_logo' => get_theme_mod( 'header_customizer_logo', 355 ),
		'$header_customizer_tagsize' => get_theme_mod( 'header_customizer_tagsize', 18 ),
		'$footer_customizer_bg' => get_theme_mod( 'footer_customizer_bg', '#1f4385' ),
		'$footer_customizer_header_color' => get_theme_mod( 'footer_customizer_header_color', '#ffffff' ),
		'$footer_customizer_header_text_desktop' => get_theme_mod( 'footer_customizer_header_text_desktop', 18 ),
		'$footer_customizer_text_color' => get_theme_mod( 'footer_customizer_text_color', '#ffffff' ),
		'$footer_customizer_body_text_desktop' => get_theme_mod( 'footer_customizer_body_text_desktop', 16 ),
		'$footer_customizer_link_color' => get_theme_mod( 'footer_customizer_link_color', '#ffffff' ),
		'$footer_customizer_link_hover_color' => get_theme_mod( 'footer_customizer_link_hover_color', '#ffffff' ),
		'$layout_customizer_gutter_spacing_desktop' => get_theme_mod( 'layout_customizer_gutter_spacing_desktop', 50 ),
		'$layout_customizer_gutter_spacing_mobile' => get_theme_mod( 'layout_customizer_gutter_spacing_mobile', 30 ),
		'$header_customizer_logo_mobile' => get_theme_mod( 'header_customizer_logo_mobile', 118 ),
		'$header_customizer_tagsize_mobile' => get_theme_mod( 'header_customizer_tagsize_mobile', 10 ),
		'$footer_customizer_body_text_mobile' => get_theme_mod( 'footer_customizer_body_text_mobile', 14 ),
		'$footer_customizer_header_text_mobile' => get_theme_mod( 'footer_customizer_header_text_mobile', 18 )
	];		

	$compiler->setVariables($variables);

	$css = $compiler->compile($scssContents);

	return $css;

}

add_action('customize_save_after', function() {

	// on customizer saved

	$target_css = get_stylesheet_directory() . '/assets/css/style.css';

	$css = aa_css_generator_customizer();

	if (!empty( $css ) && is_string( $css )) {

		file_put_contents($target_css, $css);

	}

});


if (is_customize_preview()) {

	// on customizer preview

	add_action('wp_head', function() {

		$css = aa_css_generator_customizer();
		
		if (!empty($css) && is_string($css)) {
			echo '<style type="text/css">' . $css . '</style>';
		}
		
	});
}