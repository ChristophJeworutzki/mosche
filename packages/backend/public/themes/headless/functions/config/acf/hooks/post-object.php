<?php

function transform_post_object($value, $post_id, $field) {

  if (empty($value)) {
    return $value;
  }
  
  if ($field['return_format'] === 'object')  {
    return array(
      'id'            => $value->ID,
      'post_type'     => $value->post_type,
      'slug'          => $value->post_name,
      'title'         => $value->post_title,
      'status'        => $value->post_status,
    );
  } else {
    return $value;
  }

}

add_filter('acf/format_value/type=post_object', 'transform_post_object', 20, 3);