<?php

/*
 |--------------------------------------------------------------------------
 | Admin
 |--------------------------------------------------------------------------
 */

/*  Update Permalink Structure */
update_option('permalink_structure', '/%postname%/');

/*  Disable Gutenberg for posts */
add_filter('use_block_editor_for_post', '__return_false', 10);

/*  Disable Gutenberg for post types */
add_filter('use_block_editor_for_post_type', '__return_false', 10);

/* Inject Admin Scripts */
function custom_admin_scripts() {
  wp_enqueue_style('custom_admin_style', get_template_directory_uri(__FILE__) . '/assets/css/admin.css', []);
  wp_enqueue_script('custom_admin_script', get_template_directory_uri(__FILE__) . '/assets/js/admin.js', []);
}

/* Inject Login Scripts */
function custom_login_scripts() {
  wp_enqueue_style('custom_login_style', get_template_directory_uri(__FILE__) . '/assets/css/login.css', []);
  wp_enqueue_script('custom_login_script', get_template_directory_uri(__FILE__) . '/assets/js/login.js', []);
}

/* Disable Default Dashboard Widgets */
function disable_default_dashboard_widgets() {
  global $wp_meta_boxes;
  unset($wp_meta_boxes['settings_page_menu_editor']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_widget']);
}

/* Disable all the Nags & Notifications */
function remove_core_updates() {
  global $wp_version;
  return (object) array('last_checked' => time(), 'version_checked' => $wp_version);
}

/* Remove from Sidebar */
function remove_menu() {
  remove_menu_page('index.php');
  remove_menu_page('edit.php');
  remove_menu_page('edit.php?post_type=page');
  remove_menu_page('edit-comments.php');
}

/* Remove from and add to Adminbar */
function custom_admin_bar_menu($wp_admin_bar) {
  $wp_admin_bar->remove_node('wp-logo');
  $wp_admin_bar->remove_node('site-name');
  $wp_admin_bar->remove_node('updates');
  $wp_admin_bar->remove_node('comments');
  $wp_admin_bar->remove_node('new-content');
  $wp_admin_bar->remove_node('view');
  $wp_admin_bar->remove_node('language');
  $args = array(
    'id'    => sanitize_title(get_bloginfo('name')),
    'title' => get_bloginfo('name'),
    'href'  => env('APP_URL'),
    'meta'  => [
      'target' => '_blank',
    ]
  );
  $wp_admin_bar->add_node($args);
}

/* Extend Upload Mime Types */
function extend_upload_mimes($mime_types) {
  $mime_types['svg'] = 'image/svg+xml';
  return $mime_types;
}

/* Fix SVG */
function fix_wp_get_attachment_image_svg($image, $attachment_id, $size, $icon) {
  if (is_array($image) && preg_match('/\.svg$/i', $image[0]) && $image[1] <= 1) {
    if (is_array($size)) {
      $image[1] = $size[0];
      $image[2] = $size[1];
    } elseif (($xml = simplexml_load_file($image[0])) !== false) {
      $attr = $xml->attributes();
      $viewbox = explode(' ', $attr->viewBox);
      $image[1] = isset($attr->width) && preg_match('/\d+/', $attr->width, $value) ? (int) $value[0] : (count($viewbox) == 4 ? (int) $viewbox[2] : null);
      $image[2] = isset($attr->height) && preg_match('/\d+/', $attr->height, $value) ? (int) $value[0] : (count($viewbox) == 4 ? (int) $viewbox[3] : null);
    } else {
      $image[1] = $image[2] = null;
    }
  }
  return $image;
}

/* Add Filters */
add_filter('pre_site_transient_update_core', 'remove_core_updates');
add_filter('pre_site_transient_update_plugins', 'remove_core_updates');
add_filter('pre_site_transient_update_themes', 'remove_core_updates');
add_filter('upload_mimes', 'extend_upload_mimes');
add_filter('wp_get_attachment_image_src', 'fix_wp_get_attachment_image_svg', 10, 4);  /* the hook */

/* Add Actions */
add_action('admin_enqueue_scripts', 'custom_admin_scripts', 1);
add_action('login_enqueue_scripts', 'custom_login_scripts', 1);
add_action('admin_menu', 'remove_menu');
add_action('admin_bar_menu', 'custom_admin_bar_menu', 999);
add_action('wp_dashboard_setup', 'disable_default_dashboard_widgets', 999);

/* Remove Actions */
remove_action('welcome_panel', 'wp_welcome_panel');
remove_action('try_gutenberg_panel', 'wp_try_gutenberg_panel');
remove_action('wp_head', 'wp_generator');
