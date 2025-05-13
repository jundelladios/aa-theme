<?php

add_filter("breeze_cache_buffer_before_processing", function( $the_content ) {
  if(aa_is_page_editor() || is_admin()) { return $the_content; }

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
    $isExcludeLazyload = in_array($src, $excludesLazyload);

		$srcset = \Api\Media::imageproxy($src);
		$imgurl = \Api\Media::imageURLCDN($src);

    if( !$img->hasAttribute('data-brsrcset') ) {
      $img->setAttribute('data-brsrcset', $srcset);
    }
    if( !$img->hasAttribute('data-brsizes') ) {
      $img->setAttribute('data-brsizes', '
      (min-width: 991px) 1900px,
      (min-width: 768px) 1600px,
      (min-width: 576px) 800px,
      100vw
      ');
    }
    if( !$img->hasAttribute('data-breeze') ) {
      $img->setAttribute('data-breeze', $imgurl);
    }

		if( carbon_get_theme_option('aa_admin_settings_cdnproxy') && !$isExcludeLazyload ) {
			$img->setAttribute('src', "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==");
			$img->setAttribute('loading', "lazy");
      $img->setAttribute('class', $img->getAttribute('class') . ' br-lazy');
		} else {
			$img->setAttribute('src', $imgurl);
			$img->setAttribute('loading', "eager");
		}

		$imgdetails = wpdb_image_attachment_details($img->getAttribute('src'));
		if($imgdetails) {
			if( !$img->hasAttribute('width') ) {
				$img->setAttribute('width', $imgdetails['width']);
			}
			if( !$img->hasAttribute('height') ) {
				$img->setAttribute('height', $imgdetails['height']);
			}
			if( !$img->hasAttribute('alt') ) {
				$img->setAttribute('alt', $imgdetails['alt']);
			}
		}
	}

	
	// background handle
	$finder = new DomXPath($post);
	$styleFinder = "background-image";
	$bgnodes = $finder->query("//*[contains(@style, '$styleFinder')]");
	foreach( $bgnodes as $bg ) {
		preg_match('/background-image\s*:\s*url\(([\'"]?)(.*?)\1\)/i', $bg->getAttribute('style'), $match);
		if( isset( $match[2])) {
			$bgurl = $match[2];
			$imgurl = \Api\Media::imageURLCDN($bgurl);
      $srcset = \Api\Media::imageproxy($src);

			$excludesLazyload = explode(',', preg_replace("/\r|\n/", "", carbon_get_theme_option('aa_admin_settings_nolazyloadlists')));
    	$isExcludeLazyload = in_array($bgurl, $excludesLazyload);
			
			if( carbon_get_theme_option('aa_admin_settings_cdnproxy') ) {
				$bg->setAttribute('style', str_replace( $bgurl, $imgurl, $bg->getAttribute('style')));
			}
			if(!$isExcludeLazyload) {
				$bg->setAttribute('class', $bg->getAttribute('class') . " has_background_image br-lazy");
			}
			$bg->setAttribute('loading', !$isExcludeLazyload ? "lazy" : "eager");
      $bg->setAttribute('data-brsizes', '
      (min-width: 991px) 1900px,
      (min-width: 768px) 1600px,
      (min-width: 576px) 800px,
      100vw
      ');
      $bg->setAttribute('data-bgset', $srcset);
		}
	}

	$content = $post->saveHTML();

  // remove unecessary inlines
  $regex = '/<style\b[^>]*\bid\s*=\s*["\'][^"\']*filebird[^"\']*["\'][^>]*>.*?<\/style>/is';
  $content = preg_replace( $regex, "", $content );

  $regex = '/<style\b[^>]*\bid\s*=\s*["\'][^"\']*classic-theme[^"\']*["\'][^>]*>.*?<\/style>/is';
  $content = preg_replace( $regex, "", $content );
  
  return $content;
});

add_filter( 'wp_get_loading_optimization_attributes', function( $attributes ) {
  unset($attributes['fetchpriority']);
  return $attributes;
});


add_action( 'wp_footer', function() {
  ob_start();
  if(!aa_is_page_editor()) {
    ?>
    <script type="text/javascript" id="american-accents-optimization">
      window.AALazyLoadInstance = new LazyLoad({
        elements_selector: ".br-lazy",
        threshold: 300,
        data_src: "breeze",
        data_srcset: "brsrcset",
        data_sizes: "brsizes",
        data_bg_set: "bgset",
        class_loaded: "br-loaded",
        callback_enter: (element) => {
            console.log("Entered viewport:", element);
        },
        callback_loaded: (element) => {
            console.log("Loaded:", element);
        }
      });
    </script>
    <?php
  }
  echo ob_get_clean();
}, 999 );


add_action( 'wp_enqueue_scripts', function() {
  wp_deregister_style( 'wc-blocks-style' );
  wp_dequeue_style( 'wp-block-library' );
  wp_dequeue_style( 'wp-block-library-theme' );
  wp_dequeue_style( 'wc-blocks-style' );
}, 100 );

remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');