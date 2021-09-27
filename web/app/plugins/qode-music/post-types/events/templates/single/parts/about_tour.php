<?php if (get_the_content() != ''): ?>
<div class="qode-event-item qode-event-info qode-event-content-holder">
    <h2 class='qode-event-section-title'><?php esc_html_e('About Tour', 'qode-music'); ?></h2>
    <div class="qode-event-item qode-event-info-content qode-event-single-content">
   		<?php the_content(); ?>
	</div>
</div>
<?php endif; ?>