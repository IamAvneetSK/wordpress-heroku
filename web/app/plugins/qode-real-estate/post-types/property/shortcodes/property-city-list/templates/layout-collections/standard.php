<div class="qodef-pcl-item-image">
    <?php echo qodef_re_get_taxonomy_featured_image($id, 'property_city_featured_image'); ?>
</div>
<div class="qodef-pcl-item-content">
    <div class="qodef-pcl-item-content-outer">
        <div class="qodef-pcl-item-content-inner">
            <<?php echo esc_attr( $title_tag ) ?> class="qodef-pcl-item-title-country-count">
                <span class="qodef-pcl-item-title">
                    <?php echo esc_html($name); ?>
                </span>
                -
                <span class="qodef-pcl-item-county">
                    <?php echo esc_html(qodef_re_get_taxonomy_name_from_id($county)); ?>
                </span>
                <span class="qodef-pcl-item-count">
                    (<?php echo esc_html($count); ?>)
                </span>
            </<?php echo esc_attr( $title_tag ) ?>>
        </div>
    </div>
</div>