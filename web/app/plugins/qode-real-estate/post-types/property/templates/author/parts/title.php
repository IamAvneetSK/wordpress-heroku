<?php
$author_name = get_user_meta($author->ID, 'first_name', true) . ' ' . get_user_meta($author->ID, 'last_name', true);
?>
<div class="qodef-re-author-title-holder">
	<h1 class="qodef-re-author-description qodef-author-role">
		<?php echo esc_html($role); ?>
	</h1>
	<h3 class="qodef-re-author-title">
        <?php echo esc_html($author_name); ?>
    </h3>
</div>