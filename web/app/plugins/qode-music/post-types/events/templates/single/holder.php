<?php if(have_posts()): while(have_posts()) : the_post(); ?>
		<div class="container">
		    <div class="container_inner clearfix">
                <?php if(post_password_required()) {
	                echo get_the_password_form();
	            } else {
	                //event single html
	                ?>
	            <div <?php bridge_qode_class_attribute($holder_class); ?>>
					<div class="two_columns_33_66 background_color_sidebar grid2 clearfix">
					    <div class="column1">
					        <div class="column_inner">
					           <div class="qode-event-image-buy-tickets-holder">
						           	<?php
						                //get event featured image
						                qode_music_get_cpt_single_module_template_part('templates/single/parts/image','events');

									//get event details section
									qode_music_get_cpt_single_module_template_part('templates/single/parts/details', 'events', '', array('date' => $date,'time' => $time,'website' => $website,'organized_by' => $organized_by, 'location' => $location));

						                //get event but tickets section
						                qode_music_get_cpt_single_module_template_part('templates/single/parts/buy_tickets','events','', array('link' => $link, 'target' => $target, 'tickets_status' => $tickets_status));
						            ?>
					           </div>
					        </div>
					    </div>
					    <div class="column2">
					        <div class="column_inner">
					            <div class="qode-event-info-holder">
					                <?php
                                        //get event map section
                                        qode_music_get_cpt_single_module_template_part('templates/single/parts/google_map', 'events', '', array('pin'=>$pin, 'location' => $location ));

						                //get event about tour section
						                qode_music_get_cpt_single_module_template_part('templates/single/parts/about_tour', 'events');

						                //get event follow and share section
						                qode_music_get_cpt_single_module_template_part('templates/single/parts/follow_and_share', 'events');
					                ?>
					            </div>
					        </div>
					    </div>
					</div>
				</div>
	            <?php }
					//load event comments
					qode_music_get_cpt_single_module_template_part('templates/single/parts/comments', 'events');
	             ?>

	        </div>
	    </div>
		<?php

			//load event navigation
			qode_music_get_cpt_single_module_template_part('templates/single/parts/navigation', 'events', '', array('back_to_link' => $back_to_link));

			
		?>
<?php
	endwhile;
	endif;
?>