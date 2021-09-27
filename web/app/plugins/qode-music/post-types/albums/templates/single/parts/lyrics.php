<?php
	$lyrics = get_post_meta(get_the_ID(), 'qode_album_tracks', true);
?>
<?php if(is_array($lyrics) && count($lyrics) > 0): ?>
	<div class="qode-lyrics-holder-inner">
		<h2 class="qode-lyrics-holder-title"><?php esc_html_e('Available Lyrics', 'qode-music'); ?></h2>
		<div class="qode-accordion-holder clearfix qode-accordion qode-initial">
			<?php foreach($lyrics as $lyrics) :
					if ($lyrics['qode_album_track_title'] !== '' && $lyrics['qode_album_track_lyrics'] !== ''): ?>
						<h4 class="clearfix qode-title-holder">
							<span class="qode-accordion-mark qode-left-mark">
								<span class="qode-accordion-mark-icon">
									<span class="fa fa-angle-up"></span>
									<span class="fa fa-angle-down"></span>
								</span>
							</span>
							<span class="qode-tab-title">
								<span class="qode-tab-title-inner">
									<?php echo esc_attr($lyrics['qode_album_track_title'])?>
								</span>
							</span>
						</h4>
						<div class="qode-accordion-content">
							<div class="qode-accordion-content-inner">
									<p><?php echo nl2br($lyrics['qode_album_track_lyrics']); ?></p>
							</div>
						</div>
			<?php endif;
					endforeach; ?>
		</div>
	</div>
<?php endif; ?>
