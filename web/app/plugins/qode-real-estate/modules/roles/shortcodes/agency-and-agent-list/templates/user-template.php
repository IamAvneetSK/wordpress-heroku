<?php $users = $all_users['users'];
if (is_array($users) && count($users)) {
	foreach ($users as $user) { ?>
		<?php
		$user_item_class = is_array($user['social_icons']) && count($user['social_icons']) ? 'qodef-user-has-social' : 'qodef-user-no-social';
		?>
	<li class="qodef-aal-item qodef-item-space <?php echo esc_attr($user_item_class); ?>">
		<div class="qodef-aal-item-inner">
			<div class="qodef-aal-image">
				<?php print bridge_qode_get_module_part($user['image']);?>
			</div>
			<div class="qodef-aal-item-content">
				<?php if($enable_link == 'yes') { ?>
					<a href="<?php echo esc_url($user['link']);?>" target="_self">
				<?php } ?>
				<h5 class="qodef-aal-item-title"><?php echo esc_html($user['name']);?></h5>
				<?php if($enable_link == 'yes') { ?>
					</a>
				<?php } ?>
                <h6 class="qodef-aal-item-position"><?php echo esc_html($user['position']);?></h6>
				<?php if ( is_array($user['social_icons']) && count($user['social_icons']) ) { ?>
					<div class="qodef-aal-item-social">
						<?php foreach ($user['social_icons'] as $social_icon) {
							print bridge_qode_get_module_part($social_icon);
						} ?>
					</div>
				<?php } ?>
			</div>
            <?php if($enable_link == 'yes') { ?>
                <a class="qodef-aal-user-link" href="<?php echo esc_url($user['link']);?>" target="_self"></a>
            <?php } ?>
		</div>
	</li>
	
<?php } 
} ?>