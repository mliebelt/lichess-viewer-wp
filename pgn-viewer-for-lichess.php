<?php
/*
Plugin Name: pgn-viewer-for-lichess
Description: Shortcode to embed Lichess PGN Viewer into WordPress
Version: 1.1.1
Author: mliebelt
License: GPL-3.0-or-later
*/

/* Reocmmendation of WordPress plugin team */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define('LPGNV_VERSION', '1.1.1'); // Define constant at the top of your file

function lpgnv_enqueue_scripts() {
    wp_enqueue_script('lichess-pgn-viewer', plugin_dir_url(__FILE__) . 'js/lichess-pgn-viewer.js', array(), LPGNV_VERSION, true);
    wp_enqueue_style('lichess-pgn-viewer', plugin_dir_url(__FILE__) . 'css/lichess-pgn-viewer.css', array(), LPGNV_VERSION);
    wp_enqueue_style('lichess-pgn-viewer-custom', plugin_dir_url(__FILE__) . 'css/lichess-pgn-viewer-custom.css', array(), LPGNV_VERSION);
}

function lpgnv_block_assets() {
    wp_enqueue_style(
        'lpgnv-editor-style',
        plugins_url('css/editor.css', __FILE__),
        array(),
        LPGNV_VERSION
    );

    wp_enqueue_script(
        'lpgnv-editor',
        plugins_url('js/index.js', __FILE__),
        array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-components'),
        LPGNV_VERSION,
        true
    );
}

function lpgnv_cleanup_pgn($content) {
    // Decode HTML entities
    $content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    // Convert smart quotes to straight quotes and handle ellipsis
    $content = preg_replace(
        array('/\x{201C}|\x{201D}/u', '/\x{2018}|\x{2019}/u', '/\x{2026}/u'),
        array('"', "'", '...'),
        $content
    );

    // Clean up common issues
    $search = [
        '…', '...', '&#8230;', '&#8201;', '&#8221;', '&#8220;', '&#8222;', '"', '"',
        "\r\n", "\n", "\r", '<br />', '<br>', '<p>', '</p>', '&nbsp;'
    ];
    $replace = [
        '...', '...', '...', '"', '"', '"', '"', '"', '"',
        ' ', ' ', ' ', '', '', '', '', ' '
    ];
    $content = str_replace($search, $replace, $content);

    return trim(preg_replace('/\s+/', ' ', $content));
}

function lpgnv_shortcode($atts, $content = null) {
    // Ensure scripts and styles are enqueued
    lpgnv_enqueue_scripts();

    // Ensure content is not empty
    if (empty($content)) {
        return 'No PGN content provided.';
    }

    // Clean up the PGN content
    $content = lpgnv_cleanup_pgn($content);

    $attributes = shortcode_atts(
        array(
            'fen' => '',
            'showclocks' => 'true',
            'showmoves' => 'auto',
            'showcontrols' => 'true',
            'scrolltomove' => 'true',
            'keyboardtomove' => 'true',
            'boardstyle' => '',
            'initialply' => '0',
            'orientation' => '',
            'theme' => 'dark',
        ),
        $atts
    );

    $id = 'lpgnv-' . uniqid();

    $config = array(
        'pgn' => $content,
        'fen' => $attributes['fen'] ?: null,
        'showClocks' => $attributes['showclocks'] === 'true',
        'showMoves' => $attributes['showmoves'] === 'false' ? false : $attributes['showmoves'],
        'showControls' => $attributes['showcontrols'] === 'true',
        'scrollToMove' => $attributes['scrolltomove'] === 'true',
        'keyboardToMove' => $attributes['keyboardtomove'] === 'true',
        'initialPly' => intval($attributes['initialply']),
        'orientation' => $attributes['orientation'] ?: null,
        'theme' => $attributes['theme'] ?: 'dark'
    );

    // Remove null values from config
    $config = array_filter($config, function($value) { return $value !== null; });

    // Add a custom class based on the boardstyle attribute
    $boardClass = $attributes['boardstyle'] ? ' lpv-board-' . esc_attr($attributes['boardstyle']) : '';
    $theme = isset($atts['theme']) ? $atts['theme'] : 'dark';
    $theme_class = 'lpv-theme-' . sanitize_html_class($theme);

    $output = "<div id='$id' class='lpv{$boardClass} {$theme_class}'></div>";
    $output .= "<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof LichessPgnViewer !== 'undefined') {
            var viewer = LichessPgnViewer.default || LichessPgnViewer;
            viewer(document.getElementById('$id'), " . wp_json_encode($config, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ");
        } else {
            console.error('LichessPgnViewer is not defined');
        }
    });
    </script>";

    return $output;
}
add_shortcode('lpgnv', 'lpgnv_shortcode');

add_action('enqueue_block_editor_assets', 'lpgnv_block_assets');

// Register the block
function lpgnv_register_block() {
    if (function_exists('register_block_type')) {
        register_block_type('lichess-pgn-viewer/block-editor', array(
            'editor_script' => 'lpgnv-editor',
            'render_callback' => 'lpgnv_render_block'
        ));
    }
}
add_action('init', 'lpgnv_register_block');

// Block render callback
function lpgnv_render_block($attributes, $content) {
    return lpgnv_shortcode($attributes, $attributes['pgn'] ?? '');
}
