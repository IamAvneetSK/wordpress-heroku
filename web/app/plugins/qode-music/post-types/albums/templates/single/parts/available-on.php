<?php
	$stores = get_post_meta(get_the_ID(), 'qode_album_stores', true);
?>
<?php if(is_array($stores) && count($stores) > 0): ?>
	<div class="qode-single-album-stores-holder">
		<h2 class="qode-single-album-stores-title"><?php esc_html_e('Available On', 'qode-music'); ?></h2>
		<div class="qode-single-album-stores clearfix">
			<?php
			foreach($stores as $store) : ?>
				<span class="qode-single-album-store">
					<?php if($store['qode_album_store_link'] != '') : ?>
						<a class="qode-single-album-store-link" href="<?php echo esc_url($store['qode_album_store_link']); ?>" target = "_blank">
							<?php echo qode_music_single_stores_names_and_images($store['qode_album_store_name'], $store_type); ?>
						</a>
					<?php else: ?>
						<?php echo qode_music_single_stores_names_and_images($store['qode_album_store_name'], $store_type); ?>
					<?php endif; ?>
				</span>
				<?php
			endforeach;
			?>
		</div>
	</div>
<?php endif; ?>