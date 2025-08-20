<?php

function proevent_theme_setup() {
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    add_theme_support( 'title-tag' );

    register_nav_menus( array(
        'primary' => 'Primary Menu',
        'footer'  => 'Footer Menu',
    ) );
}
add_action( 'after_setup_theme', 'proevent_theme_setup' );

function proevent_enqueue_assets() {
    wp_enqueue_style( 'tailwind', get_template_directory_uri() . '/assets/css/tailwind.css', array(), '2.0', 'all' );

    wp_enqueue_style( 'proevent-style', get_stylesheet_uri() );

    wp_enqueue_script( 'proevent-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array(), null, true );
}
add_action( 'wp_enqueue_scripts', 'proevent_enqueue_assets' );

function proevent_enqueue_block_assets() {
    wp_register_script(
        'proevent-blocks-js',
        get_template_directory_uri() . '/build/blocks.js',
        array( 'wp-blocks', 'wp-element', 'wp-editor' ),
        filemtime( get_template_directory() . '/build/blocks.js' ),
        true
    );

    wp_register_style(
        'proevent-blocks-editor-css',
        get_template_directory_uri() . '/build/blocks-editor.css',
        array( 'wp-edit-blocks' ),
        filemtime( get_template_directory() . '/build/blocks-editor.css' )
    );

    wp_register_style(
        'proevent-blocks-style-css',
        get_template_directory_uri() . '/build/blocks-style.css',
        array(),
        filemtime( get_template_directory() . '/build/blocks-style.css' )
    );

    register_block_type( 'proevent/hero-cta', array(
        'editor_script' => 'proevent-blocks-js',
        'editor_style'  => 'proevent-blocks-editor-css',
        'style'         => 'proevent-blocks-style-css',
    ) );

    register_block_type( 'proevent/event-grid', array(
        'editor_script' => 'proevent-blocks-js',
        'editor_style'  => 'proevent-blocks-editor-css',
        'style'         => 'proevent-blocks-style-css',
    ) );
}
add_action( 'init', 'proevent_enqueue_block_assets' );

function proevent_enqueue_styles() {
    wp_enqueue_style(
        'proevent-tailwind',
        get_template_directory_uri() . '/build/style.css',
        array(),
        filemtime( get_template_directory() . '/build/style.css' )
    );
}
add_action( 'wp_enqueue_scripts', 'proevent_enqueue_styles' );


add_filter( 'use_block_editor_for_post_type', function( $use_block_editor, $post_type ) {
    if ( 'event' === $post_type ) {
        return false;
    }
    return $use_block_editor;
}, 10, 2 );

require_once get_template_directory() . '/includes/custom-cpt.php';
require_once get_template_directory() . '/includes/acf-fields.php';
require_once get_template_directory() . '/includes/custom-taxonomies.php';
require_once get_template_directory() . '/includes/theme-settings.php';
require_once get_template_directory() . '/includes/rest-api.php';
?>
