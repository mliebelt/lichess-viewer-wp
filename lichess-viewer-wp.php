<?php
/*
Plugin Name: lichess-viewer-wp
Description: Shortcode to embed Lichess PGN Viewer
Version: 1.0.3
Author: mliebelt
*/

function lpgnv_enqueue_scripts() {
    wp_enqueue_script('lichess-pgn-viewer', plugin_dir_url(__FILE__) . 'js/lichess-pgn-viewer.js', array(), null, true);
    wp_enqueue_style('lichess-pgn-viewer', plugin_dir_url(__FILE__) . 'css/lichess-pgn-viewer.css');
    wp_enqueue_style('lichess-pgn-viewer-custom', plugin_dir_url(__FILE__) . 'css/lichess-pgn-viewer-custom.css');
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
            viewer(document.getElementById('$id'), " . json_encode($config, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ");
        } else {
            console.error('LichessPgnViewer is not defined');
        }
    });
    </script>";

    return $output;
}
add_shortcode('lpgnv', 'lpgnv_shortcode');
