<?php if(bridge_qode_options()->getOptionValue('enable_social_share') == 'yes'
        && bridge_qode_options()->getOptionValue('enable_social_share_on_event') == 'yes') : ?>
<div class="qode-event-item qode-event-info qode-event-follow-share-holder">
    <h2 class='qode-event-section-title'><?php esc_html_e('Follow and Share', 'qode-music'); ?></h2>
    <div class="qode-event-item qode-event-info-content qode-event-folow-share">
     	<?php echo bridge_core_get_social_share_html() ?>
    </div>
</div>
<?php endif; ?>


