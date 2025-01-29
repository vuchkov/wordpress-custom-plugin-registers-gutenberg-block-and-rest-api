<?php
function latest_posts_block_register_block() {
    // Register the block script
    wp_register_script(
        'latest-posts-block',
        plugins_url('build/index.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-api-fetch'),
        filemtime(plugin_dir_path(__FILE__) . 'build/index.js')
    );

    // Register the block
    register_block_type('latest-posts-block/main', array(
        'editor_script' => 'latest-posts-block',
        'render_callback' => 'latest_posts_block_render',
        'attributes' => array(
            'numberOfPosts' => array(
                'type' => 'number',
                'default' => 5,
            ),
        ),
    ));
}
add_action('init', 'latest_posts_block_register_block');

// Render callback function
function latest_posts_block_render($attributes) {
    $numberOfPosts = $attributes['numberOfPosts'];
    $recent_posts = wp_get_recent_posts(array(
        'numberposts' => $numberOfPosts,
        'post_status' => 'publish',
    ));

    if (empty($recent_posts)) {
        return '<p>No posts found.</p>';
    }

    $output = '<div class="latest-posts-block">';
    foreach ($recent_posts as $post) {
        $post_id = $post['ID'];
        $post_title = get_the_title($post_id);
        $post_excerpt = get_the_excerpt($post_id);
        $post_image = get_the_post_thumbnail_url($post_id, 'thumbnail');

        $output .= '<div class="latest-post">';
        if ($post_image) {
            $output .= '<img src="' . esc_url($post_image) . '" alt="' . esc_attr($post_title) . '" />';
        }
        $output .= '<h3>' . esc_html($post_title) . '</h3>';
        $output .= '<p>' . esc_html($post_excerpt) . '</p>';
        $output .= '</div>';
    }
    $output .= '</div>';

    return $output;
}

