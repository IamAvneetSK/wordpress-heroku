<?php
/*
Plugin Name: Qode Music
Description: Plugin that adds music features to our theme
Author: Qode Themes
Version: 2.1.1
*/

include_once 'load.php';

add_action('after_setup_theme', array(QodeMusic\CPT\PostTypesRegister::getInstance(), 'register'));

if(!function_exists('qode_music_activation')) {
	/**
	 * Triggers when plugin is activated. It calls flush_rewrite_rules
	 * and defines qode_music_action_core_on_activate action
	 */
	function qode_music_activation() {
		do_action('qode_music_action_core_on_activate');

		QodeMusic\CPT\PostTypesRegister::getInstance()->register();
		flush_rewrite_rules();
	}

	register_activation_hook(__FILE__, 'qode_music_activation');
}

if(!function_exists('qode_music_text_domain')) {
	/**
	 * Loads plugin text domain so it can be used in translation
	 */
	function qode_music_text_domain() {
		load_plugin_textdomain('qode-music', false, QODE_MUSIC_REL_PATH.'/languages');
	}

	add_action('plugins_loaded', 'qode_music_text_domain');
}