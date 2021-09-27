<?php

include_once 'const.php';
include_once 'helpers.php';
require_once 'functions.php';

//load lib
require_once 'lib/shortcode-interface.php';

//load shortcodes inteface
require_once 'lib/shortcode-loader.php';
require_once 'lib/shortcode-functions.php';

//load post-post-types
require_once 'lib/post-type-interface.php';
require_once 'post-types/post-types-functions.php';
require_once 'post-types/post-types-register.php'; //this has to be loaded last


//load custom styles
if(!function_exists('qode_music_load_custom_styles')) {
    function qode_music_load_custom_styles() {
        require_once 'assets/custom-styles/music.php';
    }
    add_action('after_setup_theme','qode_music_load_custom_styles');
}