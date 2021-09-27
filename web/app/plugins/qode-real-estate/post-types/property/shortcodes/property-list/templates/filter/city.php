<?php
$city_set = isset($params['property_city']) && $params['property_city'] !== '';
$hide_active_filter = isset($params['hide_active_filter']) && $params['hide_active_filter'] === 'yes';
$cities = qodef_re_get_taxonomy_list('property-city');
?>
<?php if(!$city_set || ($city_set && !$hide_active_filter)) { ?>
<div class="qodef-filter-section qodef-filter-section-3 qodef-section-city">
    <div class="qodef-filter-city-holder" data-default-city="<?php echo esc_attr($params['property_city']); ?>" data-city="<?php echo esc_attr($params['property_city']); ?>">
        <label for="qodef-filter-city"><?php esc_html_e('Choose a location', 'qode-real-estate') ?></label>
        <select id="qodef-filter-city" name="qodef-filter-city" class="qodef-filter-cities">
            <option value=""><?php esc_html_e('All Locations', 'qode-real-estate') ?></option>
            <?php foreach($cities as $key => $city) { ?>
                <option <?php echo esc_attr($params['property_city']) == $key ? 'selected' : ''; ?> value="<?php echo esc_attr($key); ?>"><?php echo esc_html($city); ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<?php } ?>