<?php
function mi_tema_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    register_nav_menus(['primary' => 'Menú principal']);
}
add_action('after_setup_theme', 'mi_tema_setup');

function mi_tema_scripts() {
    wp_enqueue_style(
        'mi-tema-style',
        get_stylesheet_uri(),
        [],
        filemtime(get_stylesheet_directory() . '/style.css')
    );
}
add_action('wp_enqueue_scripts', 'mi_tema_scripts');