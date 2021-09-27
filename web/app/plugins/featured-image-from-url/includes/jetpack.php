<?php

define('FIFU_JETPACK_SIZES', serialize(array(75, 100, 150, 240, 320, 500, 640, 800, 1024, 1280, 1600)));

function fifu_resize_jetpack_image_size($size, $url) {
    $size = (int) $size;
    return "{$url}?w={$size}&resize={$size}";
}

function fifu_jetpack_get_set($url, $is_slider) {
    $quality = $is_slider ? 1.25 : 1;
    $set = '';
    $count = 0;
    foreach (unserialize(FIFU_JETPACK_SIZES) as $i)
        $set .= (($count++ != 0) ? ', ' : '') . fifu_resize_jetpack_image_size($i * $quality, $url) . ' ' . $i . 'w';
    return $set;
}

function fifu_jetpack_blocked($url) {
    if (fifu_is_photon_url($url))
        return true;

    $blocklist = array('amazon-adsystem.com', 'sapo.io', 'unsplash.com', 'i.guim.co.uk', 's.yimg.com', 's1.yimg.com', 'www.washingtonpost.com', 'pbs.twimg.com', 'www.aljazeera.com', 'image.influenster.com', 'api.screenshotmachine.com', 'rackcdn.com', 'm.media-amazon.com', 'images-na.ssl-images-amazon.com', 'googleusercontent.com', 'drive.google.com');
    foreach ($blocklist as $domain) {
        if (strpos($url, $domain) !== false)
            return true;
    }
    return false;
}

function fifu_is_photon_url($url) {
    $list = array('i0.wp.com', 'i1.wp.com', 'i2.wp.com', 'i3.wp.com');
    foreach ($list as $domain) {
        if (strpos($url, $domain) !== false)
            return true;
    }
    return false;
}

function fifu_jetpack_photon_url($url, $args) {
    if (fifu_is_photon_url($url))
        return $url;
    $url = fifu_remove_cdn_prefix($url);
    $image_url_parts = wp_parse_url($url);
    if (!is_array($image_url_parts) || empty($image_url_parts['host']) || empty($image_url_parts['path']))
        return $url;
    $subdomain = abs(crc32($url) % 4);
    $host = $image_url_parts['host'];
    $path = $image_url_parts['path'];
    $photon_url = "https://i{$subdomain}.wp.com/{$host}{$path}";
    if ($args)
        return add_query_arg($args, $photon_url);
    return $photon_url;
}

function fifu_remove_cdn_prefix($url) {
    if (strpos($url, '%3A%2F%2F') !== false)
        $url = urldecode($url);

    $aux = preg_split('/[\/=]https:\/\//', $url);
    if (sizeof($aux) > 1)
        return 'https://' . $aux[1];

    $aux = preg_split('/[\/=]http:\/\//', $url);
    if (sizeof($aux) > 1)
        return 'http://' . $aux[1];

    return $url;
}

