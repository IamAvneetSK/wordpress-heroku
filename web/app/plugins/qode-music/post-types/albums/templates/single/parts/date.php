<?php 
	$release_date = get_post_meta(get_the_ID(), 'qode_album_release_date', true);
	if ($release_date !== '') {
		?>
		<div class="qode-album-details qode-album-date">
			<p>
				<span><?php esc_html_e('Release Date:', 'qode-music'); ?></span>
				<span><?php print date_i18n( 'F d, Y' , strtotime( $release_date ) ); ?></span>
			</p>
		</div>

		<?php
	}
	    ?>