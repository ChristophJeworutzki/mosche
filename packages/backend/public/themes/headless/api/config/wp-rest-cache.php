<?php

/*
|--------------------------------------------------------------------------
| REST API Cache Control
|--------------------------------------------------------------------------
 */

function wp_rest_cache($post_id) {
    if (class_exists('WP_REST_Cache')) {
        WP_REST_Cache::empty_cache();
    }
}

add_action('acf/save_post', 'wp_rest_cache', 99);
add_action('save_post', 'wp_rest_cache', 99);
