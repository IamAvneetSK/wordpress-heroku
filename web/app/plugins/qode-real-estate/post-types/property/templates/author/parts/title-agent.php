<?php
$agent_name = get_user_meta($author->ID, 'first_name', true) . ' ' . get_user_meta($author->ID, 'last_name', true);
$agent_position = get_user_meta($author->ID, 'qodef_agent_position', true);
?>
<div class="qodef-re-author-title-holder">
	<h1 class="qodef-re-author-description">
		<?php echo esc_html($agent_position); ?>
	</h1>
	<h3 class="qodef-re-author-title">
        <?php echo esc_html($agent_name); ?>
    </h3>
</div>