<?php

function transform_image($value, $post_id, $field) {

  if (empty($value)) {
    return $value;
  }

  if ($field['return_format'] === 'id') {
    return $value;
  } else if ($field['return_format'] === 'array') {
    return [
      'id'            => $value['id'],
      'title'         => $value['title'],
      'width'         => $value['width'],
      'height'        => $value['height'],
      'mimeType'      => $value['mime_type'],
      'alt'           => $value['alt'],
      'caption'       => $value['caption'],
      'description'   => $value['description'],
      'aspectRatio'   => get_aspect_ratio($value['width'], $value['height']),
      'orientation'   => get_orientation($value['width'], $value['height']),
      'src'           => $value['url'],
      'srcset'        => wp_get_attachment_image_srcset($value['id']),
    ];
  } else {
    return $value;
  }
}

function get_aspect_ratio($w, $h) {
  if (!$w || !$h) return;
  $gcd = function ($w, $h) use (&$gcd) {
    return ($w % $h) ? $gcd($h, $w % $h) : $h;
  };
  $g = $gcd($w, $h);
  return $w / $g . ':' . $h / $g;
}

function get_orientation($w, $h) {
  return $w > $h ? 'landscape' : 'portrait';
}

add_filter('acf/format_value/type=image', 'transform_image', 20, 3);
