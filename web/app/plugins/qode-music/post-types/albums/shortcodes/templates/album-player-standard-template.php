<div class="qode-audio-player-wrapper <?php echo esc_attr($player_classes) ?>"  <?php qode_music_inline_style($player_styles); ?> >
	<div id= "qode-player-<?php echo esc_attr($player_id); ?>" class="jp-jplayer"></div>
	<?php if ($full_width_bg == 'yes'): ?>
		<div class="container_inner">
	<?php endif; ?>
	<div id= "qode-player-container-<?php echo esc_attr($player_id); ?>" class="qode-audio-player-holder" data-album-id="<?php echo esc_attr($album); ?>">
		<div class="qode-audio-player-info-holder">
			<?php if(has_post_thumbnail($album)) : ?>
				<div class="qode-audio-player-image-holder">
					<?php echo get_the_post_thumbnail($album, 'thumbnail') ?>
				</div>
			<?php endif; ?>
			<div class="qode-audio-player-text-holder">
				<h4 class="qode-audio-player-title"></h4>
				<p class="qode-audio-player-album"></p>
			</div>
		</div>
		<div class="qode-audio-player-controls-holder">

			<div class="jp-audio player-box">
				<div class="jp-gui jp-interface">
					<ul class="jp-controls">
						<li <?php qode_music_inline_style($nav_buttons_styles); ?>><a class="jp-previous" href="#"><i class="fa fa-fast-backward"></i></a></li><li <?php qode_music_inline_style($play_button_styles); ?>><a class="jp-play" href="#"><i class="fa fa-play"></i><i class="fa fa-pause"></i></a></li><li <?php qode_music_inline_style($nav_buttons_styles); ?>><a class="jp-next" href="#"><i class="fa fa-fast-forward"></i></a></li>
					</ul>
				</div>
				<div class="jp-type-playlist">
					<div class="jp-playlist">
						<ul class="tracks-list">
							<li></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="qode-audio-player-time-holder">
			<div class="qode-audio-player-progress-holder">
				<div class="jp-audio player-box">
					<div class="jp-gui jp-interface">
						<div class="jp-progress">
							<div class="jp-seek-bar">
								<div class="jp-play-bar"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="qode-audio-player-current-time-holder">
				<div class="jp-audio player-box">
					<div class="jp-gui jp-interface">
						<p class="time-box">
							<span class="jp-current-time"></span>/<span class="jp-duration"></span>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="qode-audio-player-volume-holder">
			<div class="jp-volume-controls">
				<a class="jp-mute" role="button" tabindex="0"><i class="fa fa-volume-up" aria-hidden="true"></i><i class="fa fa-volume-off" aria-hidden="true"></i></a>
				<span class="jp-volume-bar">
					<span class="jp-volume-bar-value"></span>
				</span>
			</div>
		</div>
	</div>
	<?php if ($full_width_bg == 'yes'): ?>
		</div>
	<?php endif; ?>
</div>