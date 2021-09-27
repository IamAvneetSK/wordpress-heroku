<?php if(have_posts()): while(have_posts()) : the_post(); ?>
		<div class="container">
		    <div class="container_inner default_template_holder clearfix">
				<?php do_action('bridge_qode_action_after_container_inner_open'); ?>
		    	<?php if(post_password_required()) {
	                echo get_the_password_form();
	            } else {
	                //album single html
	                ?>
	            <div class="qode-album-comprehensive <?php echo 'qode-album-' . $album_skin; ?>">
	                <div class="two_columns_50_50 background_color_sidebar grid2 clearfix">
						<div class="column1">
							<div class="column_inner">
								<?php
								//get album featured image
								qode_music_get_cpt_single_module_template_part('templates/single/parts/image','albums');
								//get album player
								qode_music_get_cpt_single_module_template_part('templates/single/parts/player','albums');

								?>

								<?php
                                //get album tracks
                                qode_music_get_cpt_single_module_template_part('templates/single/parts/tracks','albums');
                                ?>

								<?php
								//get album available on
								qode_music_get_cpt_single_module_template_part('templates/single/parts/available-on','albums','', array('store_type' => $store_type));

								?>

							</div>
						</div>
						<div class="column2">
							<div class="column_inner">
								<div class="qode-about-album-holder">
									<?php
									//get about album
									qode_music_get_cpt_single_module_template_part('templates/single/parts/about','albums');
									?>
								</div>
								<div class="qode-album-details-holder">
									<?php
									//get album artist
									qode_music_get_cpt_single_module_template_part('templates/single/parts/artist','albums');

									//get album label
									qode_music_get_cpt_single_module_template_part('templates/single/parts/label','albums');

									//get album date
									qode_music_get_cpt_single_module_template_part('templates/single/parts/date','albums');

									//get album genre
									qode_music_get_cpt_single_module_template_part('templates/single/parts/genre','albums');

									//get album people
									qode_music_get_cpt_single_module_template_part('templates/single/parts/people','albums');
									?>
								</div>

								<div class="qode-lyrics-holder">
									<?php
										//get lyrics
									qode_music_get_cpt_single_module_template_part('templates/single/parts/lyrics','albums');
									?>
								</div>

								<?php
								//get album review
								qode_music_get_cpt_single_module_template_part('templates/single/parts/album-review','albums');
								?>

								<?php
								//get album review
								qode_music_get_cpt_single_module_template_part('templates/single/parts/follow_and_share','albums');
								?>

							</div>
						</div>
					</div>
					<div class="qode-latest-video-holder">
						<?php
						//get album latest video
						qode_music_get_cpt_single_module_template_part('templates/single/parts/latest-video','albums');
						?>
					</div>
				</div>
	            <?php }  
					//load comments
					qode_music_get_cpt_single_module_template_part('templates/single/parts/comments', 'albums');
	            ?>
	        </div>
	    </div>
	    <div class="qode-album-navigation-holder <?php if($album_skin != '') { echo 'qode-album-' . $album_skin;} ?>">
			<?php
				//get navigation
				qode_music_get_cpt_single_module_template_part('templates/single/parts/navigation','albums','',$params);
			?>
		</div>
<?php
	endwhile;
	endif;
?>