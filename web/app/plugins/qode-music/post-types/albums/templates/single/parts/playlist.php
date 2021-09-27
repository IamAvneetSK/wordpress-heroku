<h3 class="qode-tracks-holder-title"><?php esc_html_e('Tracklist', 'qode-music'); ?></h3>
<?php 
    $id = get_the_ID();

    $album_skin_single = get_post_meta( $id, 'qode_album_skin_meta', true );
	$album_skin_global = bridge_qode_options()->getOptionValue('album_skin');

	$skin = $album_skin_single;

	if($album_skin_single == ''){
		$skin = $album_skin_global;
	}

	/*$skin = ($skin == 'light') ? 'dark' : 'light';*/

    $args = array(
			'album'		=> $id,
			'album_skin'		=> $skin
	);

    echo bridge_qode_execute_shortcode('qode_album', $args);
?>