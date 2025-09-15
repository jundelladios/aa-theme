<?php

add_action('template_redirect', function () {
  ob_start('aa_end_output_buffering');
});

function aa_end_output_buffering( $output ) {
  if( is_user_logged_in() ) {
    return $output;
  }

  // $defer_exceptions = array(
  //   // '#american-accents.*\.js.*#i'
  // );

  // $output = preg_replace_callback(
  //   '#<script([^>]+src=["\']([^"\']+)["\'][^>]*)>#is',
  //   function ($matches) use ($defer_exceptions) {
  //     $attrs = $matches[1];
  //     $src = $matches[2];

  //     // Check if src matches any exception pattern
  //     foreach ($defer_exceptions as $pattern) {
  //       if (preg_match($pattern, $src)) {
  //         return "<script{$attrs}>"; // do not defer
  //       }
  //     }

  //     // If not excepted, add defer if not already present
  //     if (stripos($attrs, ' defer') === false) {
  //       $attrs .= ' defer';
  //     }
  //     return "<script{$attrs}>";
  //   },
  //   $output
  // );


  // Get all <link> tags with rel="stylesheet" and href ending with .css, excluding those matching exclusion patterns
  $exclusions = [
    '#iconmoon.*\.css.*#i',
  ];

  // Add data-optimize="1" to all <link rel="stylesheet" ...> tags whose href matches any of these patterns
  if (preg_match_all('#<link\s+[^>]*rel=["\']stylesheet["\'][^>]*href=["\']([^"\']+\.css[^"\']*)["\'][^>]*>#i', $output, $matches)) {
    $css_links = $matches[0];
    $hrefs = $matches[1];

    foreach ($css_links as $i => $link_match) {
      $full_tag = $link_match;
      $href = $hrefs[$i];

      // Check if this link matches any exclusion pattern
      $should_optimize = false;
      foreach ($exclusions as $pattern) {
        if (preg_match($pattern, $href)) {
          $should_optimize = true;
          break;
        }
      }
      if ($should_optimize) {
        // Add data-optimize="1" if not already present
        if (strpos($full_tag, 'data-optimize="1"') === false) {
          // Insert before the closing '>'
          if (substr($full_tag, -2) === '/>') {
            $new_tag = substr($full_tag, 0, -2) . ' data-optimize="1" />';
          } else {
            $new_tag = substr($full_tag, 0, -1) . ' data-optimize="1">';
          }
          $output = str_replace($full_tag, $new_tag, $output);
        }
      }
    }
  }

  // // Find all <link> tags with rel="stylesheet" and .css href
  // Also include Google Fonts <link rel="stylesheet" ...> tags for optimization
  if (preg_match_all('#<link\s+[^>]*rel=["\']stylesheet["\'][^>]*href=["\']([^"\']+\.css[^"\']*|https://fonts\.googleapis\.com/[^"\']*)["\'][^>]*>#i', $output, $matches, PREG_OFFSET_CAPTURE)) {
    $css_links = $matches[0];
    $hrefs = $matches[1];

    foreach ($css_links as $i => $link_match) {
      $full_tag = $link_match[0];
      $href = $hrefs[$i][0];

      // Check exclusions (but always include Google Fonts)
      $is_google_fonts = (stripos($href, 'fonts.googleapis.com/') !== false);
      $excluded = false;
      if (!$is_google_fonts) {
        foreach ($exclusions as $pattern) {
          if (preg_match($pattern, $href)) {
            $excluded = true;
            break;
          }
        }
      }
      if ($excluded) {
        continue;
      }

      // Add/replace media="print" and onload="this.media='all'"
      // Remove any existing media attribute
      $new_tag = preg_replace('#\smedia=["\'][^"\']*["\']#i', '', $full_tag);
      // Remove any existing onload attribute
      $new_tag = preg_replace('#\sonload=["\'][^"\']*["\']#i', '', $new_tag);

      // Insert media="print" and onload="this.media=\'all\'" before the closing '>'
      if (substr($new_tag, -2) === '/>') {
        $new_tag = substr($new_tag, 0, -2) . ' media="print" onload="this.media=\'all\'" />';
      } else {
        $new_tag = substr($new_tag, 0, -1) . ' media="print" onload="this.media=\'all\'" />';
      }

      // Replace in output
      $output = str_replace($full_tag, $new_tag, $output);
    }
  }

  
  // Inline all <link rel="stylesheet" ... .css> tags whose href matches any regex in $inline_patterns
  $inline_patterns = array(
    '#aa-theme(?!.*iconmoon).*\.css.*#i',
  );
  if (preg_match_all('#<link\s+[^>]*rel=["\']stylesheet["\'][^>]*href=["\']([^"\']+\.css[^"\']*)["\'][^>]*>#i', $output, $matches)) {
    $css_links = $matches[0];
    $hrefs = $matches[1];

    foreach ($css_links as $i => $full_tag) {
      $href = $hrefs[$i];

      // Check if this href matches any inline pattern
      $should_inline = false;
      foreach ($inline_patterns as $pattern) {
        if (preg_match($pattern, $href)) {
          $should_inline = true;
          break;
        }
      }
      if (!$should_inline) {
        continue;
      }

      // Try to resolve the file path from the href
      $css_content = '';
      $template_dir_uri = get_template_directory_uri();
      $template_dir = get_template_directory();
      $site_url = get_site_url();
      $home_url = home_url();

      $file_path = '';
      if (strpos($href, $template_dir_uri) === 0) {
        $file_path = $template_dir . str_replace('\\', '/', substr($href, strlen($template_dir_uri)));
      } elseif (strpos($href, $site_url) === 0) {
        $file_path = ABSPATH . ltrim(str_replace($site_url, '', $href), '/');
      } elseif (strpos($href, $home_url) === 0) {
        $file_path = ABSPATH . ltrim(str_replace($home_url, '', $href), '/');
      } elseif (strpos($href, '/') === 0) {
        $file_path = ABSPATH . ltrim($href, '/');
      }

      // Remove query parameter from file path if present
      $file_path = preg_replace('/\?.*$/', '', $file_path);

      if ($file_path && file_exists($file_path)) {
        $css_content = file_get_contents($file_path);
      }

      if ($css_content) {
        // Minify CSS (basic)
        $css_content = preg_replace('!/\*.*?\*/!s', '', $css_content);
        $css_content = preg_replace('/\s+/', ' ', $css_content);
        $css_content = trim($css_content);

        $inline_tag = '<style>' . $css_content . '</style>';
        $output = str_replace($full_tag, $inline_tag, $output);
      }
    }
  }


  return $output;
}