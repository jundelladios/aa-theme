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
	if( $attributes['src'] && !is_admin() ) {

		$excludesLazyload = explode(',', preg_replace("/\r|\n/", "", carbon_get_theme_option('aa_admin_settings_nolazyloadlists')));
    	$isExcludeLazyload = array_search($attributes['src'], $excludesLazyload);

		$srcset = \Api\Media::imageproxy($attributes['src']);
		$imgurl = \Api\Media::imageURLCDN($attributes['src']);

		if( carbon_get_theme_option('aa_admin_settings_cdnproxy') && !is_int($isExcludeLazyload) ) {

			if( !isset( $attributes['data-srcset'] ) ) {
				$attributes['data-srcset'] = $srcset;
			}

			if( !isset( $attributes['data-sizes'] ) ) {
				$attributes['data-sizes'] = 'auto';
			}

			$attributes['class'] .= ' lazyload lz-blur';

			$attributes['src'] = "data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%200%200'%3E%3C/svg%3E";
			
		} else {

			$imgdetails = wpdb_image_attachment_details($attributes['src']);
			if($imgdetails) {
				$attributes['width'] = $imgdetails['width'];
				$attributes['height'] = $imgdetails['height'];
				$attributes['alt'] = $imgdetails['alt'];
			}

			$attributes['loading'] = "eager";

			$attributes['src'] = $imgurl;
		}

	}

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
		
		$excludesLazyload = explode(',', preg_replace("/\r|\n/", "", carbon_get_theme_option('aa_admin_settings_nolazyloadlists')));
    	$isExcludeLazyload = array_search($src, $excludesLazyload);

		$srcset = \Api\Media::imageproxy($src);

		$imgurl = \Api\Media::imageURLCDN($src);

		if( carbon_get_theme_option('aa_admin_settings_cdnproxy') && !is_int($isExcludeLazyload) && !is_admin() ) {
			if( !$img->hasAttribute('data-srcset') ) {
				$img->setAttribute('data-srcset', $srcset);
			}
			if( !$img->hasAttribute('data-sizes') ) {
				$img->setAttribute('data-sizes', 'auto');
			}

			$img->setAttribute('class', $img->getAttribute('class')." lazyload lz-blur");

			$img->setAttribute('src', "data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%200%200'%3E%3C/svg%3E");

		} else {

			$imgdetails = wpdb_image_attachment_details($img->getAttribute('src'));
			if($imgdetails) {
				$img->setAttribute('width', $imgdetails['width']);
				$img->setAttribute('height', $imgdetails['height']);
				$img->setAttribute('alt', $imgdetails['alt']);
			}
			
			$img->setAttribute('loading', "eager");

			$img->setAttribute('src', $imgurl);

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
		esc_html_x( 'Posted on %s', 'post date', 'american-accennts-theme' ),
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
		esc_html_x( 'by %s', 'post author', 'american-accennts-theme' ),
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
		$categories_list = get_the_category_list( esc_html__( ', ', 'american-accennts-theme' ) );
		if ( $categories_list ) {
			/* translators: 1: list of categories. */
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'american-accennts-theme' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'american-accennts-theme' ) );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'american-accennts-theme' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'american-accennts-theme' ),
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
				__( 'Edit <span class="screen-reader-text">%s</span>', 'american-accennts-theme' ),
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


function aa_global_settings_head() {

	ob_start();
	
	$cdn = carbon_get_theme_option('aa_admin_settings_cdnproxy');

	$apibase = home_url();

	?>

	<script type="text/javascript">
		window.AA_JS_OBJ = {
			API_BASE: '<?php echo $apibase; ?>',
			IMAGE_CDN: '<?php echo "$cdn"; ?>',
			HOME_URL: '<?php echo home_url(); ?>',
			IMG_PRELOADER: "data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%200%200'%3E%3C/svg%3E",
			SRCSET: function($url) {
				<?php if( $cdn ): ?>
					var imagecdnproxy = $url.replace('<?php echo home_url(); ?>', '<?php echo $cdn; ?>');
					return `
					${imagecdnproxy}?width=400 600w,
					${imagecdnproxy}?width=600 800w,
					${imagecdnproxy}?width=800 1600w,
					${imagecdnproxy}?width=1600 1900w,
					${imagecdnproxy} 2050w
					`;
				<?php else: ?>
					return $url;
				<?php endif; ?>
			},
			CDNSRCMIN: function($url) {
				<?php if( $cdn ): ?>
				return `data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%200%200'%3E%3C/svg%3E`;
				<?php else: ?>
				return $url;
				<?php endif; ?>
			},
			CDNSRC: function($url) {
				<?php if( $cdn ): ?>
				return `data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%200%200'%3E%3C/svg%3E`;
				<?php else: ?>
				return $url;
				<?php endif; ?>
			}
		};
	</script>

	<?php

	$html = ob_get_clean();

	echo $html;

}

add_action('wp_head', 'aa_global_settings_head');