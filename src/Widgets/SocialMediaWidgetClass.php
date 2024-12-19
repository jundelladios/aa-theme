<?php 

/**
 * Class for Social Media Widget
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package AA_Project
 */

namespace Wordpress\Widgets;

class SocialMediaWidgetClass extends \WP_Widget {

    public function __construct() {
		// actual widget processes
		$widget_options = array( 
			'classname' => 'aa_social_media_widget',
			'description' => 'American Accents Theme Social Media Widget',
		);
		parent::__construct( 'aa_social_media_widget', 'Social Media', $widget_options );
    }

    public function widget( $args, $instance ) {
		// outputs the content of the widget
		$title = apply_filters( 'widget_title', $instance[ 'title' ] );
		echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title'];
		?>
		<ul class="list-unstyled social-media-footer">
			<?php if( get_theme_mod( 'social_customizer_facebook' ) ): ?>
				<li class="social-footer-item"><a href="<?php echo get_theme_mod( 'social_customizer_facebook' ); ?>" target="_blank"><span class="social-icon-footer icon-facebook"></span> <?php echo get_theme_mod( 'social_customizer_facebook_txt' ); ?></a></li>
			<?php endif; ?>
			<?php if( get_theme_mod( 'social_customizer_twitter' ) ): ?>
				<li class="social-footer-item"><a href="<?php echo get_theme_mod( 'social_customizer_twitter' ); ?>" target="_blank"><span class="social-icon-footer icon-twitter"></span> <?php echo get_theme_mod( 'social_customizer_twitter_txt' ); ?></a></li>
			<?php endif; ?>
			<?php if( get_theme_mod( 'social_customizer_instagram' ) ): ?>
				<li class="social-footer-item"><a href="<?php echo get_theme_mod( 'social_customizer_instagram' ); ?>" target="_blank"><span class="social-icon-footer icon-instagram-square"></span> <?php echo get_theme_mod( 'social_customizer_instagram_txt' ); ?></a></li>
			<?php endif; ?>
		</ul>
		<?php
		echo $args['after_widget'];
    }

    public function form( $instance ) {
		// outputs the options form in the admin
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat title" />
			<small>You can edit social media content from Appearance > Customizer > Social Media</small>
		</p>
		<?php
    }

    public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = $old_instance;
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		return $instance;
    }

}