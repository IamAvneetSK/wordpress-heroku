<?php 
$videolink = get_post_meta( get_the_ID(), "qode_album_video_link_meta", true );
if ($videolink !== ''): ?>
	<h2 class="qode-latest-video-holder-title"><?php esc_html_e('Latest Video', 'qode-music'); ?></h2>
	<div class="qode-latest-video">
	<?php	
		$embed     = wp_oembed_get( $videolink );
		print $embed;
	?>
	</div>
<?php endif; ?>