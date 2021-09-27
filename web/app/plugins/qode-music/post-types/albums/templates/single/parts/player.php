<?php 
    $id = get_the_ID();

    $tracks = get_post_meta($id, 'qode_album_tracks', true);

    //render player only if it has tracks

    if( is_array( $tracks ) && count($tracks) > 0 ) {

        $album_skin_single = get_post_meta($id, 'qode_album_skin_meta', true);
        $album_skin_global = bridge_qode_options()->getOptionValue('album_skin');

        $skin = $album_skin_single;

        if ($album_skin_single == '') {
            $skin = $album_skin_global;
        }

        $args = array(
            'type' => 'compact',
            'album' => $id,
            'bg_color' => '',
            'skin' => $skin,
        );

        echo bridge_qode_execute_shortcode('qode_album_player', $args);
    }
?>