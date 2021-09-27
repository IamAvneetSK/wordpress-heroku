<?php
$id = get_the_ID();
$property_id = get_post_meta(get_the_ID(), 'qodef_property_id_meta', true);

$cities = qodef_re_get_property_taxonomy('property-city');
if (!empty($cities)) {
    $city_name = $cities[0]->name;
}

$counties = qodef_re_get_property_taxonomy('property-county');
if (!empty($counties)) {
    $county_name = $counties[0]->name;
}

$price = qodef_re_get_real_estate_item_price();

$featured_image = get_the_post_thumbnail_url();

if (!empty($featured_image)) {
    $styles['qodef-item-featured-image'][] = 'background-image: url(' . $featured_image . ')';
}

?>
<div class="qodef-pls-item">
    <div
        class="qodef-item-featured-image" <?php bridge_qode_inline_style($styles['qodef-item-featured-image']); ?>></div>
    <div class="qodef-item-info-holder">
        <div class="qodef-item-title-address">
            <h4 class="qodef-property-id-title">
                <a itemprop="url" href="<?php echo get_permalink(); ?>" target="<?php echo esc_attr("_self"); ?>">
                    <?php echo esc_attr($property_id . ' ' . get_the_title()); ?>
                </a>
            </h4>
            <h6 class="qodef-property-address">
                <?php if (!empty($cities)) { ?>
                    <span class="qodef-item-city"><?php echo esc_html($city_name); ?></span>
                    <span class="qodef-item-dash">&ndash;</span>
                <?php } ?>
                <?php if (!empty($counties)) { ?>
                    <span class="qodef-item-city"><?php echo esc_html($county_name); ?></span>
                <?php } ?>
            </h6>
        </div>
    <span class="qodef-property-price">
       <?php echo qodef_re_get_real_estate_price_html($price); ?>
    </span>
    </div>
</div>