<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AA_PROJECT
 */
global $aaproject;
?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				aa_posted_on();
				aa_posted_by();
				?>
			</div>
		<?php endif; ?>
	</div>
	<?php aa_post_thumbnail(); ?>
	<div class="entry-content">
		<?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'american-accennts-theme' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'american-accennts-theme' ),
			'after'  => '</div>',
		) );
		?>
	</div>

	<div class="entry-footer">
		<?php aa_entry_footer(); ?>
	</div>
</div>