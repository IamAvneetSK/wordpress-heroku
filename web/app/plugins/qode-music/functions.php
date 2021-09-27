<?php

if(!function_exists('qode_music_load_css')) {
	function qode_music_load_css() {
        wp_enqueue_style('qode_music_script', plugins_url('/assets/css/music.min.css', __FILE__), array(), '');
        wp_enqueue_style('qode_music_responsive_script', plugins_url('/assets/css/music-responsive.min.css', __FILE__), array(), '');
	}

	add_action('wp_enqueue_scripts', 'qode_music_load_css');
}

if(!function_exists('qode_music_load_js')) {
    function qode_music_load_js() {
        wp_enqueue_script('qode_music_jplayer', plugins_url('/assets/js/plugins/jquery.jplayer.min.js', __FILE__), array('jquery'), '', true);
        wp_enqueue_script('qode_music_jplayer_playlist', plugins_url('/assets/js/plugins/jplayer.playlist.min.js', __FILE__), array('jquery'), '', true);
        wp_enqueue_script('qode_music_script', plugins_url('/assets/js/music.js', __FILE__), array('jquery','bridge-default','qode_music_jplayer'), '', true);
    }

    add_action('wp_enqueue_scripts', 'qode_music_load_js', 40);
}