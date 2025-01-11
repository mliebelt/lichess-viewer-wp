<?php
/*
Plugin Name: Lichess PGN Viewer
Description: Shortcode to embed Lichess PGN Viewer
Version: 1.0.1
Author: Your Name
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
            'showmoves' => 'right',
            'showplayers' => 'true',
            'initialply' => '0',
            'showcontrols' => 'true',
            'boardstyle' => '',
        ),
        $atts
    );

    $id = 'lpgnv-' . uniqid();

    $config = array(
        'pgn' => $content,
        'fen' => $attributes['fen'],
        'showMoves' => $attributes['showmoves'],
        'showPlayers' => $attributes['showplayers'] === 'true',
        'initialPly' => intval($attributes['initialply']),
        'showControls' => $attributes['showcontrols'] === 'true',
    );

    // Add a custom class based on the boardstyle attribute
    $boardClass = $attributes['boardstyle'] ? ' lpv-board-' . esc_attr($attributes['boardstyle']) : '';

    $output = "<div id='$id' class='lpv{$boardClass}'></div>";
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
