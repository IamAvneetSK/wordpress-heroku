<?php 
	$people = get_post_meta(get_the_ID(), 'qode_album_people', true);
	if ($people !== '') {
		?>
		<div class="qode-album-details qode-album-people">
			<p>
				<span><?php esc_html_e('People:', 'qode-music'); ?></span>
				<span><?php echo esc_attr($people); ?></span>
			</p>
		</div>

		<?php
	}
	    ?>