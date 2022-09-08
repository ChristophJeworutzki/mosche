<?php

function rest_get_gallery(WP_REST_Request $request) {

  $params = $request->get_params();
  $post = get_page_by_path($params['slug'], OBJECT, $params['cpt']);

  if (!$post) return new WP_REST_Response(null, 404);

  $gallery = [];

  $attachments = get_posts([
    'post_type'        => 'attachment',
    'numberposts'      => -1,
    'meta_query'  => array(
      array(
        'key'         => $post->post_type,
        'value'       => $post->ID,
        'compare'     => 'LIKE',
      ),
    ),
  ]);

  foreach ($attachments as $key => $attachment) {
    $value = acf_get_attachment($attachment->ID);
    array_push($gallery, [
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
    ]);
  }

  $results = array(
    'id'             => $post->ID,
    'title'          => $post->post_title,
    'slug'           => $post->post_name,
    'gallery'        => $gallery,
  );

  return $results;
}

add_action('rest_api_init', function () {
  register_rest_route('v1', '/gallery/(?P<cpt>[a-zA-Z0-9-]+)/(?P<slug>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'rest_get_gallery'
  ));
});
