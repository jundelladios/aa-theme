<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package AA_Project
 */

// adding custom attribute for wp images
add_filter( 'wp_get_attachment_image_attributes', 'aa_change_attachment_image_markup' );
function aa_change_attachment_image_markup($attributes) {
	if( $attributes['src'] ) {
		$image = \Api\Media::getImageByURL($attributes['src']);
		$proxy = $attributes['src'];
		if( function_exists( 'aa_image_proxy' ) && $image ) {
			$proxy = aa_image_proxy($image['src']);

			if( !isset( $attributes['data-srcset'] ) && $proxy ) {
				$attributes['data-srcset'] = $proxy;
			}

			if( !isset( $attributes['data-src'] ) ) {
				$attributes['data-src'] = $image['finalsrc'];
			}

			if( !isset( $attributes['data-sizes'] ) ) {
				$attributes['data-sizes'] = 'auto';
			}

			if( !isset( $attributes['data-aspectratio'] ) ) {
				$attributes['data-aspectratio'] = $image['width'].'/'.$image['height'];
			}
			
			if( !isset( $attributes['width'] ) ) {
				$attributes['width'] = $image['width'];
			}
			
			if( !isset( $attributes['height'] ) ) {
				$attributes['height'] = $image['height'];
			}

			$attributes['src'] = $image['finalsrc'];

		}
		
	}

	$attributes['class'] .= ' lazyload lz-blur';

	return $attributes;
}

// wp images with srcset
add_filter('the_content','aa_wp_make_response_image_srcsets');
function aa_wp_make_response_image_srcsets($the_content) {
	if(!$the_content) { return; }
	libxml_use_internal_errors(true);
	$post = new DOMDocument();
    $post->loadHTML(
		mb_convert_encoding(
			$the_content, 
			'HTML-ENTITIES', 
			defined(DB_CHARSET) ? DB_CHARSET : 'UTF-8'
		)
	);
    $imgs = $post->getElementsByTagName('img');
	foreach( $imgs as $img ) {
		$src = $img->getAttribute('src');
		$img->setAttribute('class', $img->getAttribute('class') . ' lazyload lz-blur');
		$image = \Api\Media::getImageByURL($src);
		if( function_exists( 'aa_image_proxy' ) && $image ) {
			$proxy = aa_image_proxy($image['src']);
			if( !$img->hasAttribute('data-srcset') ) {
				$img->setAttribute('data-srcset', $proxy);
			}
			if( !$img->hasAttribute('data-src') ) {
				$img->setAttribute('data-src', $image['finalsrc']);
			}
			if( !$img->hasAttribute('data-sizes') ) {
				$img->setAttribute('data-sizes', 'auto');
			}
			if( !$img->hasAttribute('data-aspectratio') ) {
				$img->setAttribute('data-aspectratio', $image['width'].'/'.$image['height']);
			}
			if( !$img->hasAttribute('width') ) {
				$img->setAttribute('width', $image['width']);
			}
			if( !$img->hasAttribute('height') ) {
				$img->setAttribute('height', $image['height']);
			}
			$img->setAttribute('src', $image['finalsrc']);
		}
	}
	return $post->saveHTML();
}


add_filter('media_send_to_editor', 'aa_inserted_image_div', 10, 3 );

function aa_inserted_image_div( $html, $send_id, $attachment )
{
	return str_replace('<img', '<img data-editor="true" ', $html);
}

function aa_site_logo_v2() {

	$custom_logo_id = get_theme_mod( 'custom_logo' );

	$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );

	ob_start();

	?>

	<div class="site-logo faux-heading">

		<a href="<?php echo home_url(); ?>" class="custom-logo-link" rel="home">

		<?php 
		
		if ( has_custom_logo() ) {
			?>

			<?php aa_lazyimg([
				'src' => $logo[0],
				'alt' => get_bloginfo('name')
			]); ?>

			<?php

		} else {

			echo '<h1>' . get_bloginfo('name') . '</h1>';

		}
		
		?>

		</a>

	</div>

	<?php

	$html = ob_get_clean();

	return $html;

}

function aa_site_logo( $args = array(), $echo = true ) {
    global $aaproject;
	$logo       = get_custom_logo();
	$site_title = get_bloginfo( 'name' );
	$contents   = '';
	$classname  = '';
	$defaults = array(
		'logo'        => '%1$s<span class="screen-reader-text d-none">%2$s</span>',
		'logo_class'  => 'site-logo',
		'title'       => '<a href="%1$s">%2$s</a>',
		'title_class' => 'site-title',
		'heading_wrap'   => '<h1 class="%1$s">%2$s</h1>',
		'logo_wrap' => '<div class="%1$s faux-heading">%2$s</div>'
	);
	$args = wp_parse_args( $args, $defaults );
	/**
	 * Filters the arguments for `aa_site_logo()`.
	 *
	 * @param array  $args     Parsed arguments.
	 * @param array  $defaults Function's default arguments.
	 */
	$args = apply_filters( $aaproject['logo_args'], $args, $defaults );
	if ( has_custom_logo() ) {
		$contents  = sprintf( $args['logo'], $logo, esc_html( $site_title ) );
		$classname = $args['logo_class'];
		$wrap = 'logo_wrap';
	} else {
		$contents  = sprintf( $args['title'], esc_url( get_home_url( null, '/' ) ), esc_html( $site_title ) );
		$classname = $args['title_class'];
		$wrap = 'heading_wrap';
	}
	$html = sprintf( $args[ $wrap ], $classname, $contents );
	/**
	 * Filters the arguments for `aa_site_logo()`.
	 *
	 * @param string $html      Compiled html based on our arguments.
	 * @param array  $args      Parsed arguments.
	 * @param string $classname Class name based on current view, home or single.
	 * @param string $contents  HTML for site title or logo.
	 */
	$html = apply_filters( $aaproject['logo'], $html, $args, $classname, $contents );
	if ( ! $echo ) {
		return $html;
	}
	echo $html; 
}

/**
 * Prints HTML with meta information for the current post-date/time.
 */
function aa_posted_on() {
	global $aaproject;
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}
	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() )
	);
	$posted_on = sprintf(
		/* translators: %s: post date. */
		esc_html_x( 'Posted on %s', 'post date', $aaproject['context'] ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);
	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
}

/**
 * Prints HTML with meta information for the current author.
 */
function aa_posted_by() {
	global $aaproject;
	$byline = sprintf(
		/* translators: %s: post author. */
		esc_html_x( 'by %s', 'post author', $aaproject['context'] ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);
	echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
}


/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function aa_entry_footer() {
	global $aaproject;
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', $aaproject['context'] ) );
		if ( $categories_list ) {
			/* translators: 1: list of categories. */
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', $aaproject['context'] ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', $aaproject['context'] ) );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', $aaproject['context'] ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', $aaproject['context'] ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
		echo '</span>';
	}
	edit_post_link(
		sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Edit <span class="screen-reader-text">%s</span>', $aaproject['context'] ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		),
		'<span class="edit-link">',
		'</span>'
	);
}

/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function aa_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}
	if ( is_singular() ) :
		?>
		<div class="post-thumbnail">
			<?php the_post_thumbnail(); ?>
			<a href="#go-to-content" id="gotocontent"><div class="screen-reader-text">scroll down</div></a>
		</div><!-- .post-thumbnail -->
	<?php else : ?>
	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
		<?php
		the_post_thumbnail( 'post-thumbnail', array(
			'alt' => the_title_attribute( array(
				'echo' => false,
			) ),
		) );
		?>
	</a>
	<?php
	endif; // End is_singular().
}

function get_post_id_by_name( $post_name, $post_type = 'post' ) {
    $post_ids = get_posts(array(
        'name'   => $post_name,
        'post_type'   => $post_type,
        'numberposts' => 1,
        'fields' => 'ids'
    ));
    return array_shift( $post_ids );
}