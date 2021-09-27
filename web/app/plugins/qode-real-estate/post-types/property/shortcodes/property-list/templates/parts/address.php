<?php
$cities = qodef_re_get_property_taxonomy('property-city');
if(!empty($cities)) {
    $city_name = $cities[0]->name;
}
$counties = qodef_re_get_property_taxonomy('property-county');
if(!empty($counties)) {
    $county_name = $counties[0]->name;
}
$zip_code = get_post_meta(get_the_ID(), 'qodef_property_zip_code_meta', true);
$country = get_post_meta(get_the_ID(), 'qodef_property_address_country_meta', true);
?>
<div class="qodef-item-address">
    <?php if(!empty($cities)) { ?>
        <span class="qodef-item-city"><?php echo esc_html($city_name); ?></span>
        <span class="qodef-item-dash">&ndash;</span>
    <?php } ?>
    <?php if(!empty($counties)) { ?>
        <span class="qodef-item-city"><?php echo esc_html($county_name); ?></span>
<!--        <span class="qodef-item-comma">&#44;</span>-->
    <?php } ?>
<!--    <span class="qodef-item-city">--><?php //echo esc_html($country); ?><!--</span>-->
<!--    <span class="qodef-item-city">--><?php //echo esc_html($zip_code); ?><!--</span>-->
</div>
