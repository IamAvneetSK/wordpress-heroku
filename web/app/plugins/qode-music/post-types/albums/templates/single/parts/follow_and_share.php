<?php if(bridge_qode_options()->getOptionValue('enable_social_share') == 'yes') : ?>
<div class="qode-album-follow-share-holder">
    <h2 class='qode-album-follow-share-holder-title'><?php esc_html_e('Share', 'qode-music'); ?></h2>
    <div class="qode-album-follow-share">
     	<?php echo bridge_core_get_social_share_html() ?>
    </div>
</div>
<?php endif; ?>