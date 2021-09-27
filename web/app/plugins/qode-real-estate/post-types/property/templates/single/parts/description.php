<?php
    $attachment = get_post_meta(get_the_ID(), 'qodef_property_attachment_meta', true);
?>
<div class="qodef-property-description qodef-property-label-items-holder">
    <div class="qodef-property-description-label qodef-property-label-style">
        <h5>
            <?php esc_html_e('Description', 'qode-real-estate'); ?>
        </h5>
    </div>
    <div class="qodef-property-description-items qodef-property-items-style clearfix">
        <?php the_content(); ?>
        <?php if(!empty($attachment)) { ?>
            <div class="qodef-property-attachment">
                <a href="<?php echo esc_url($attachment); ?>" download target="_blank">
                    <span class="qodef-attachment-label"><?php esc_html_e('Download Prospect', 'qode-real-estate'); ?></span>
                    <span class="qodef-attachment-icon"><span class="arrow_carrot-down" aria-hidden="true"></span></span>
                </a>
            </div>
        <?php } ?>

    </div>
</div>