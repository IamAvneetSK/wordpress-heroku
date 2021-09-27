<?php
$min_price = isset($property_min_price) && !empty($property_min_price) ? $property_min_price : 0;
$max_price = isset($property_max_price) && !empty($property_max_price) ? $property_max_price : qodef_re_get_property_max_price_value();
$price_label = bridge_qode_options()->getOptionValue('property_price_label');
$price_label = $price_label != '' ? $price_label : esc_html('$');
?>
<div class="qodef-filter-section qodef-filter-section-5 qodef-section-price">
    <div class="qodef-filter-price-holder" data-price-label-setting="<?php echo esc_attr($price_label); ?>" data-max-price-setting="<?php echo esc_attr(qodef_re_get_property_max_price_value()); ?>">
        <div class="qodef-range-slider-response-holder">
            <span><?php echo esc_html__('Price range', 'qode-real-estate') . ': '; ?></span>
            <span id="qodef-min-price-label"><?php esc_html_e('From', 'qode-real-estate'); ?></span>
            <span id="qodef-min-price-value" data-min-price="<?php echo esc_attr($min_price); ?>"><?php echo esc_html($price_label) . esc_html($min_price); ?></span>
            <span id="qodef-max-price-label"><?php esc_html_e('to', 'qode-real-estate'); ?></span>
            <span id="qodef-max-price-value" data-max-price="<?php echo esc_attr($max_price); ?>"><?php echo esc_html($price_label) . esc_html($max_price); ?></span>
        </div>
        <div class="qodef-range-slider-wrapper">
            <div class="qodef-range-slider"></div>
        </div>
    </div>
</div>