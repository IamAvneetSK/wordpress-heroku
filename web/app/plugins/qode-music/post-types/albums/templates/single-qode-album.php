<?php
	get_header();
	get_template_part( 'title' );
	get_template_part( 'slider' );
	qode_music_single_album();
	get_footer();
?>