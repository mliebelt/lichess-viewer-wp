<?php
/*
Plugin Name: Lichess PGN Viewer
Description: Shortcode to embed Lichess PGN Viewer
Version: 1.0
Author: Your Name
*/

function lpgnv_enqueue_scripts() {
    wp_enqueue_script('lichess-pgn-viewer', plugin_dir_url(__FILE__) . 'js/lichess-pgn-viewer.js', array(), null, true);
    wp_enqueue_style('lichess-pgn-viewer', plugin_dir_url(__FILE__) . 'css/lichess-pgn-viewer.css');
    wp_enqueue_style('lichess-pgn-viewer-custom', plugin_dir_url(__FILE__) . 'css/lichess-pgn-viewer-custom.css');
}
add_action('wp_enqueue_scripts', 'lpgnv_enqueue_scripts');

function lpgnv_shortcode($atts, $content = null) {
    $attributes = shortcode_atts(
        array(
            'fen' => '',
            'showmoves' => 'right',
            'showplayers' => 'true',
            'initialply' => '0',
            'showcontrols' => 'true',
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

    $output = "<div id='$id'></div>";
    $output .= "<script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof LichessPgnViewer !== 'undefined') {
            var viewer = LichessPgnViewer.default || LichessPgnViewer;
                        viewer(document.getElementById('$id'), " . json_encode($config) . ")
            } else {
                console.error('LichessPgnViewer is not defined');
            }
        });
    </script>";

    return $output;
}
add_shortcode('lpgnv', 'lpgnv_shortcode');
