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

  $magazines = get_posts([
    'post_type'        => 'magazine',
    'numberposts'      => -1,
    'orderby'          => 'menu_order',
    'order'            => 'ASC',
  ]);

  return [
    'index'       => get_field('index', 'options'),
    'about'       => get_field('about', 'options'),
    'contact'     => get_field('contact', 'options'),
    'services'    => flat_post($services),
    'clients'     => flat_post($clients),
    'magazines'   => flat_post($magazines),
  ];
}

function flat_post($posts) {
  $flat = [];
  foreach ($posts as $key => $post) {
    array_push($flat, [
      'id' => $post->ID,
      'title' => $post->post_title,
      'slug' => $post->post_name,
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
