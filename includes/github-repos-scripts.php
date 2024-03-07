<?php

function mgr_add_scripts()
{
    wp_enqueue_style('mgr-main-style', plugins_url() . '/Github-repos-by-username/css/style.css');
    wp_enqueue_script('mgr-main-script', plugins_url() . '/Github-repos-by-username/js/main.js');
}

add_action('wp_enqueue_scripts', 'mgr_add_scripts');
