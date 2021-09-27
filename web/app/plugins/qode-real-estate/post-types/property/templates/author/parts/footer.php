<?php
$social_networks = bridge_qode_get_user_custom_fields($author->ID);

if(is_array($social_networks) && !empty($social_networks)) {
?>
<div class="qodef-re-author-footer qodef-author-social">
    <p class="qodef-re-social-label">
        <?php esc_html_e('Follow me on', 'qode-real-estate') ?>
    </p>
    <?php if (is_array($social_networks) && count($social_networks)) { ?>
        <div class="qodef-contact-social-icons clearfix">
            <?php foreach ($social_networks as $network) { ?>
                <a itemprop="url" href="<?php echo esc_url($network['link']) ?>" target="_blank">
                    <?php echo bridge_qode_icon_collections()->renderIcon($network['class'], 'font_awesome'); ?>
                </a>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<?php }