<?php
function mi_tema_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo');

    // Soporte para el editor de bloques
    add_theme_support('align-wide');
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    add_editor_style('style.css');

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

function mi_tema_widgets_init() {
    $zonas = [
        'footer-1' => 'Pie de página - Columna 1',
        'footer-2' => 'Pie de página - Columna 2',
        'footer-3' => 'Pie de página - Columna 3',
    ];

    foreach ($zonas as $id => $nombre) {
        register_sidebar([
            'name'          => $nombre,
            'id'            => $id,
            'description'   => 'Widgets que aparecen en el pie de página.',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]);
    }
}
add_action('widgets_init', 'mi_tema_widgets_init');