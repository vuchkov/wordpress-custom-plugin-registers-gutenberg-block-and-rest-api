<?php
/*
Plugin Name: Latest Posts Block
Description: A custom Gutenberg block to display the latest posts.
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/block-registration.php';
require_once plugin_dir_path(__FILE__) . 'includes/rest-api.php';

