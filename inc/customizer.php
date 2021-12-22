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

require get_template_directory() . '/inc/customizers/colors.php';