<?php

/**
 * Wordpress Theme Customizer
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package AA_Project
 */

 /**
 * WP Customizer color loaders.
 */

function aa_customizer_color_loaders( $theme_colors, $wp_customize, $sectionID ) {

    global $aaproject;

	foreach( $theme_colors as $color ) {

		$wp_customize->add_setting( $color['id'], array(
            'default' => $color['default'],
            'transport' => 'refresh'
        ) );

        $wp_customize->add_control(
            new WP_Customize_Color_Control( $wp_customize, $color['id'], array(
                'label' => __( $color['label'], $aaproject['context'] ),
                'section' => $sectionID,
                'settings' => $color['id']
            ) ) 
        );
	}
}

require get_template_directory() . '/inc/customizers/header.php';

require get_template_directory() . '/inc/customizers/footer.php';

require get_template_directory() . '/inc/customizers/typography.php';

require get_template_directory() . '/inc/customizers/layout.php';

require get_template_directory() . '/inc/customizers/social.php';

function aa_inline_styles() {
    global $aa_google_fonts;
    ob_start(); ?>
    html, body { font-family: '<?php echo str_replace('+', ' ', get_theme_mod( 'font_customizer_font_style', reset( $aa_google_fonts ) )); ?>', sans-serif; }
    header { background: <?php echo get_theme_mod( 'header_customizer_bg', '#383838' ); ?>; }
    header #logo img { width: <?php echo get_theme_mod( 'header_customizer_logo', 355 ); ?>px; }
    header .h-tagline { font-size: <?php echo get_theme_mod( 'header_customizer_tagsize', 18 ); ?>px; ; }
    footer { background: <?php echo get_theme_mod( 'footer_customizer_bg', '#1f4385' ); ?>; }
    footer .aa-widget-title { 
        color: <?php echo get_theme_mod( 'footer_customizer_header_color', '#ffffff' ); ?>;
        font-size: <?php echo get_theme_mod( 'footer_customizer_header_text_desktop', 18 ); ?>px;
    }
    footer .aa-widget-title:after {
        background: <?php echo get_theme_mod( 'footer_customizer_header_color', '#ffffff' ); ?>;
    }
    footer,
    footer .social-icon-footer { 
        color: <?php echo get_theme_mod( 'footer_customizer_text_color', '#ffffff' ); ?>;
        font-size: <?php echo get_theme_mod( 'footer_customizer_body_text_desktop', 16 ); ?>px;
    }
    footer a,
    footer .social-icon-footer:before {
        color: <?php echo get_theme_mod( 'footer_customizer_link_color', '#ffffff' ); ?>;
    }
    footer a:hover,
    footer a:hover .social-icon-footer:before {
        color: <?php echo get_theme_mod( 'footer_customizer_link_hover_color', '#ffffff' ); ?>;
    }
    .gt {
        padding-top: <?php echo get_theme_mod( 'layout_customizer_gutter_spacing_desktop', 50 ); ?>px;
        padding-bottom: <?php echo get_theme_mod( 'layout_customizer_gutter_spacing_desktop', 50 ); ?>px;
    }
    @media screen and (max-width: 767px) {
        .gt {
            padding-top: <?php echo get_theme_mod( 'layout_customizer_gutter_spacing_mobile', 30 ); ?>px;
            padding-bottom: <?php echo get_theme_mod( 'layout_customizer_gutter_spacing_mobile', 30 ); ?>px;
        }
        header #logo img { width: <?php echo get_theme_mod( 'header_customizer_logo_mobile', 118 ); ?>px; }
        header .h-tagline { font-size: <?php echo get_theme_mod( 'header_customizer_tagsize_mobile', 10 ); ?>px; ; }
        footer {
            font-size: <?php echo get_theme_mod( 'footer_customizer_body_text_mobile', 14 ); ?>px;
        }
        footer .aa-widget-title { 
            font-size: <?php echo get_theme_mod( 'footer_customizer_header_text_mobile', 18 ); ?>px;
        }
    }
    <?php
    $html = ob_get_clean();
    return $html;
}