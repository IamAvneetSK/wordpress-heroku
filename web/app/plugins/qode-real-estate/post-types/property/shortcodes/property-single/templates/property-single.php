<div class="qodef-psg-shortcode clearfix">
    <div class="qodef-psg-gallery">
        <?php
        $i = 0;
        foreach ($image_ids as $image_id) {
            if ($i < 2) {
                $img_url = wp_get_attachment_image_src($image_id, 'full');
                $img_desc = get_post_meta($image_id, '_wp_attachment_image_alt', true);

                if ($img_url !== '') { ?>
                    <img class="qodef-psg-gallery-image" src="<?php echo esc_url($img_url[0]); ?>"
                         alt="<?php echo esc_attr($img_desc); ?>"/>
                <?php }
                $i++;
            }
        } ?>
    </div>
    <div class="qodef-psg-content">

        <?php if (!empty($price) || $price !== 0) { ?>

            <h2 class="qodef-psg-price">
                <span><?php echo qodef_re_get_real_estate_price_html($price); ?></span>
            </h2>

        <?php }
        if (!empty($title)) { ?>

            <h3 class="qodef-psg-full-address">
	            <a itemprop="url" class="qodef-psg-link" href="<?php echo get_permalink($property_id); ?>" target="_self">
                    <span><?php echo esc_attr($property_id_meta . ' ' . $title); ?></span>
	            </a>
            </h3>

        <?php }
        if (!empty($property_size)) { ?>

            <div class="qodef-psg-info qodef-psg-property-size">
                <h6 class="qodef-psg-info-label"><?php esc_html_e('Property size:', 'qode-real-estate') ?></h6>
                <h6 class="qodef-psg-info-value"><?php echo qodef_re_get_real_estate_size_html($property_size) . ' ' . $size_label; ?></h6>
            </div>

        <?php }
        if (!empty($structure)) { ?>

            <div class="qodef-psg-info qodef-psg-structure">
                <h6 class="qodef-psg-info-label"><?php esc_html_e('Structure:', 'qode-real-estate') ?></h6>
                <h6 class="qodef-psg-info-value"><?php echo esc_html($structure); ?></h6>
            </div>

        <?php }
        if (!empty($accommodation)) { ?>

            <div class="qodef-psg-info qodef-psg-accommodation">
                <h6 class="qodef-psg-info-label"><?php esc_html_e('Accommodation:', 'qode-real-estate') ?></h6>
                <h6 class="qodef-psg-info-value"><?php echo esc_html($accommodation); ?></h6>
            </div>

        <?php }
        if (!empty($heating)) { ?>

            <div class="qodef-psg-info qodef-psg-heating">
                <h6 class="qodef-psg-info-label"><?php esc_html_e('Heating:', 'qode-real-estate') ?></h6>
                <h6 class="qodef-psg-info-value"><?php echo esc_html($heating); ?></h6>
            </div>

        <?php } ?>
    </div>
</div>