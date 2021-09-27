<div class="qode-album-track-list <?php echo esc_attr($alb_skin); ?>" id="<?php echo esc_attr($random_id); ?>">
<?php
	$i = 1;
	foreach($tracks as $track): ?>
		<div class="qode-album-track" data-track-order="<?php echo esc_attr($i); ?>">
			<<?php echo esc_attr($title_tag) ?> class="qode-at-title">
				<?php if(isset($track['title']) && $track['title'] != '') : ?>
					<span class="qode-at-number"><?php echo esc_attr($i).'. '; ?></span><?php echo esc_attr($track['title']); ?>
				<?php endif; ?>
			</<?php echo esc_attr($title_tag) ?>>
			<span class="qode-at-time"><?php echo esc_attr($track['track_time']); ?></span>
			<a class="qode-at-play-button">
				<audio preload="metadata" src="<?php echo esc_url($track['track_file']); ?>"></audio>
				<i class="arrow_triangle-right qode-at-play-icon"></i><i class="icon_pause qode-at-pause-icon"></i>
			</a>
			<span class="qode-at-video-button-holder">
				<?php if(isset($track['video_link']) && $track['video_link'] != '') : ?>
					<a class="qode-at-video-button" href="<?php echo esc_url($track['video_link']); ?>" data-rel="prettyPhoto" >
						<i class="fa fa-video-camera"></i>
					</a>
				<?php endif; ?>
			</span>
			<span class="qode-at-download-holder">
				<?php if(isset($track['free_download']) && $track['free_download'] == 'yes') : ?>
					<a href="<?php echo esc_url($track['track_file']); ?>" class="qode-at-download" download><i class="fa fa-download"></i></a>
				<?php endif; ?>
			</span>
		</div>
<?php
		$i++;
	endforeach;
?>
</div>