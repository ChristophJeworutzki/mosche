<?php

function custom_post_type() {

  register_post_type('client', array(
    'label'               => __('Client'),
    'description'         => __(''),
    'labels'              => array(
      'name'                => __('Clients'),
      'singular_name'       => __('Client'),
      'add_new'             => __('Add new Client'),
    ),
    'supports'            => array('title'),
    'taxonomies'          => array(''),
    'hierarchical'        => true,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => false,
    'menu_position'       => 22,
    'menu_icon'           => 'dashicons-admin-users',
    'can_export'          => true,
    'has_archive'         => false,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'capability_type'     => 'post',
    'show_in_rest'        => false,
    'rewrite'             => true
  ));

  register_post_type('magazine', array(
    'label'               => __('Magazine'),
    'description'         => __(''),
    'labels'              => array(
      'name'                => __('Magazines'),
      'singular_name'       => __('Magazin'),
      'add_new'             => __('Add new Magazin'),
    ),
    'supports'            => array('title'),
    'taxonomies'          => array(''),
    'hierarchical'        => true,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => false,
    'menu_position'       => 23,
    'menu_icon'           => 'dashicons-book',
    'can_export'          => true,
    'has_archive'         => false,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'capability_type'     => 'post',
    'show_in_rest'        => false,
    'rewrite'             => true
  ));

  register_post_type('service', array(
    'label'               => __('Service'),
    'description'         => __(''),
    'labels'              => array(
      'name'                => __('Services'),
      'singular_name'       => __('Service'),
      'add_new'             => __('Add new Service'),
    ),
    'supports'            => array('title'),
    'taxonomies'          => array(''),
    'hierarchical'        => true,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => false,
    'menu_position'       => 24,
    'menu_icon'           => 'dashicons-image-filter',
    'can_export'          => true,
    'has_archive'         => false,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'capability_type'     => 'post',
    'show_in_rest'        => false,
    'rewrite'             => true
  ));
}

add_action('init', 'custom_post_type', 0);
