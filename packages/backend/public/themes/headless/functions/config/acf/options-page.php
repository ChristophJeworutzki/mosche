<?php

/* Add ACF Options Page
------------------------------------*/
if (function_exists('acf_add_options_page')) {

  acf_add_options_page(array(
    'page_title'    => __('Index'),
    'menu_title'    => __('Index'),
    'menu_slug'     => 'index',
    'icon_url'      => 'dashicons-format-gallery',
    'capability'    => 'edit_posts',
    'redirect'      => false,
    'position'      => 20,
  ));

  acf_add_options_page(array(
    'page_title'    => __('Info'),
    'menu_title'    => __('Info'),
    'menu_slug'     => 'info',
    'icon_url'      => 'dashicons-info',
    'capability'    => 'edit_posts',
    'redirect'      => false,
    'position'      => 21,
  ));
}
