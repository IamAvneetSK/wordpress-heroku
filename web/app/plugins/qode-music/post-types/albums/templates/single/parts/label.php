<?php
	$labels   = wp_get_post_terms(get_the_ID(), 'qode-album-label');
	$label_names = array();

if(is_array($labels) && count($labels)) :
	foreach($labels as $label) {
		$label_names[] = $label->name;
	}

	?>
	<div class="qode-album-details qode-album-labels">
		<p>
			<span><?php 
	            if (count($labels) > 1) { 
	                esc_html_e('Labels:', 'qode-music');
	            } else {
	                esc_html_e('Label:', 'qode-music');
	            } ?>
	        </span>
			<span>
				<?php echo esc_html(implode(', ', $label_names)); ?>
			</span>
		</p>
	</div>
<?php endif; ?>