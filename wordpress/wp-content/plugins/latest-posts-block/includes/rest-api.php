<?php
function latest_posts_block_rest_api_init() {
    register_rest_route('latest-posts-block/v1', '/posts/', array(
        'methods' => 'GET',
        'callback' => 'latest_posts_block_get_posts',
        'permission_callback' => '__return_true',
    ));
}
add_action('rest_api_init', 'latest_posts_block_rest_api_init');

function latest_posts_block_get_posts($request) {
    $numberOfPosts = $request->get_param('numberOfPosts') ?: 5;
    $recent_posts = wp_get_recent_posts(array(
        'numberposts' => $numberOfPosts,
        'post_status' => 'publish',
    ));

    $posts_data = array();
    foreach ($recent_posts as $post) {
        $post_id = $post['ID'];
        $posts_data[] = array(
            'title' => get_the_title($post_id),
            'excerpt' => get_the_excerpt($post_id),
            'image' => get_the_post_thumbnail_url($post_id, 'thumbnail'),
        );
    }

    return rest_ensure_response($posts_data);
}

