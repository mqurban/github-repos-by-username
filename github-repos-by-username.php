<?php
/*
Plugin Name: Github Repos by Username
Plugin URI: http://www.jonbishop.com
Description: A simple plugin that displays a list of Github repositories for a specified username.
Version: 1.0
Author: Muhammad Qurban
Author URI: http://www.mqurban.com
License: GPL2
*/

if (!defined('ABSPATH')) {
    exit;
}

// Include Scripts

require_once(plugin_dir_path(__FILE__) . '/includes/github-repos-scripts.php');

// Include Class
require_once(plugin_dir_path(__FILE__) . '/includes/github-repos-class.php');

// Register Widget 
function register_github_repos()
{
    register_widget('WP_My_Github_Repos');
}

add_action('widgets_init', 'register_github_repos');
