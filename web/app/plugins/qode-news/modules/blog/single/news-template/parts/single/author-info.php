<?php
	$author_info_box = esc_attr(bridge_qode_options()->getOptionValue('blog_author_info'));
	$author_id = esc_attr(get_the_author_meta('ID'));

?>
<?php if($author_info_box === 'yes') { ?>
	<div class="qode-author-description">
		<div class="qode-author-description-inner">
			<div class="qode-author-description-content">
				<div class="qode-author-description-image">
					<a itemprop="url" href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" title="<?php the_title_attribute(); ?>" target="_self">
						<?php echo bridge_qode_kses_img(get_avatar(get_the_author_meta( 'ID' ), 150)); ?>
					</a>
				</div>
				<div class="qode-author-description-text-holder">
					<h5 class="qode-author-name vcard author">
						<span><?php esc_html_e('About the Author','qode-news');?></span> /
						<a itemprop="url" href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" title="<?php the_title_attribute(); ?>" target="_self">
							<span>
							<?php
								if(get_the_author_meta('first_name') != "" || get_the_author_meta('last_name') != "") {
									echo esc_html(get_the_author_meta('first_name')) . " " . esc_html(get_the_author_meta('last_name'));
								} else {
									echo esc_html(get_the_author_meta('display_name'));
								}
							?>
							</span>
						</a>
					</h5>
                    <p itemprop="email" class="qode-author-email"><?php echo sanitize_email(get_the_author_meta('email')); ?></p>
					<?php if(get_the_author_meta('description') != "") { ?>
						<div class="qode-author-text">
							<p itemprop="description"><?php echo esc_html(get_the_author_meta('description')); ?></p>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>