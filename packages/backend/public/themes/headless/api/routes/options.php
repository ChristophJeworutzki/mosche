<?php

function rest_get_options(WP_REST_Request $request) {

  $services = get_posts([
    'post_type'        => 'service',
    'numberposts'      => -1,
    'orderby'          => 'menu_order',
    'order'            => 'ASC',
  ]);

  $clients = get_posts([
    'post_type'        => 'client',
    'numberposts'      => -1,
    'orderby'          => 'menu_order',
    'order'            => 'ASC',
  ]);

  $projects = get_posts([
    'post_type'        => 'project',
    'numberposts'      => -1,
    'orderby'          => 'menu_order',
    'order'            => 'ASC',
  ]);

  return [
    'index'       => [
      'collection' => get_field('collection', 'options')
    ],
    'about'       => get_field('about', 'options'),
    'contact'     => get_field('contact', 'options'),
    'services'    => reduce_post($services),
    'clients'     => reduce_post($clients),
    'projects'    => reduce_post($projects),
  ];
}

function reduce_post($posts) {
  $flat = [];
  foreach ($posts as $key => $post) {
    array_push($flat, [
      'id' => $post->ID,
      'title' => $post->post_title,
      'slug' => $post->post_name,
      'collection' => get_field('collection', $post->ID)
    ]);
  }
  return $flat;
}

add_action('rest_api_init', function () {
  register_rest_route('v1', '/options', array(
    'methods' => 'GET',
    'callback' => 'rest_get_options'
  ));
});
