<div class="qode-album" >
	<div class="qode-album-inner" >
		<a class ="qode-album-link" href="<?php echo esc_url($album_link); ?>"></a>
		<div class = "qode-album-image-holder">
		<?php
			echo get_the_post_thumbnail(get_the_ID(),'full');
		?>				
		</div>
		<div class="qode-album-text-overlay">
			<div class="qode-album-text-overlay-inner">
				<div class="qode-album-text-holder">
					<?php 
						echo $artist_html;
					?>
					<p class="qode-album-title">
						<?php echo esc_attr(get_the_title()); ?>
					</p>	
				</div>
			</div>	
		</div>
	</div>
	<?php
	if ($show_stores == 'yes'):
		$stores = get_post_meta(get_the_ID(), 'qode_album_stores', true);
		$stores_links = get_post_meta(get_the_ID(), 'qode_album_store_link', true);
		$i = 0;
	?>
	<?php if(is_array($stores) && count($stores) > 0 && ! empty($stores)): ?>
			<div class="qode-album-stores clearfix">
				<?php
				foreach($stores as $store) : 
					if ( strpos($stores_list, $store['qode_album_store_name']) !== false ): ?>

					<span class="qode-single-album-store">
						<?php if($store['qode_album_store_link'] != '') : ?>
							<a class="qode-single-album-store-link" href="<?php echo esc_url($store['qode_album_store_link']); ?>" target = "_blank">
								<?php echo qode_music_single_stores_names_and_images($store['qode_album_store_name'], 'image'); ?>
							</a>
						<?php else: ?>
							<?php echo qode_music_single_stores_names_and_images($store['qode_album_store_name'], 'image'); ?>
						<?php endif; ?>
					</span>
					<?php
					endif;
					$i++;
				endforeach;
				?>
			</div>
	<?php endif; 
	endif; ?>
</div>