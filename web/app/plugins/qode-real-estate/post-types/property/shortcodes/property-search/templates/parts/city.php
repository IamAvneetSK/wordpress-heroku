<?php
$city_enabled = isset($enable_city) && $enable_city === 'yes';
$cities = qodef_re_get_taxonomy_list('property-city');
?>
<?php if($city_enabled) { ?>
    <div class="qodef-search-bottom-part qodef-search-city-section">
        <select id="qodef-search-city" name="qodef-search-city">
            <option value=""><?php esc_html_e('All Locations', 'qode-real-estate') ?></option>
            <?php foreach($cities as $key => $city) { ?>
                <option value="<?php echo esc_attr($key); ?>"><?php echo esc_html($city); ?></option>
            <?php } ?>
        </select>
    </div>
<?php } ?>