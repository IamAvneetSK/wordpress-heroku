<?php
$property_bedrooms = isset($property_bedrooms) && !empty($property_bedrooms) ? $property_bedrooms : 0;
$property_bathrooms = isset($property_bathrooms) && !empty($property_bathrooms) ? $property_bathrooms : 0;
?>
<div class="qodef-filter-section qodef-filter-section-12 qodef-section-spec">
    <div class="qodef-filter-specification-holder clearfix">
        <div class="qodef-quantity-buttons quantity">
            <label for="qodef-specification-bedrooms"><?php esc_html_e('Bedrooms', 'qode-real-estate'); ?></label>
            <span class="qodef-quantity-wrapper">
                <span class="qodef-spec-quantity-minus icon_minus-06"></span>
                <input type="text" id="qodef-specification-bedrooms" class="input-text qty text qodef-spec-quantity-input" data-step="1" data-min="0" data-max="10" name="qodef-specification-bedrooms" value="<?php echo esc_attr($property_bedrooms); ?>" title="<?php esc_attr_e( 'Property bedrooms', 'qode-real-estate' ) ?>" size="2" />
                <span class="qodef-spec-quantity-plus icon_plus"></span>
            </span>
        </div>
        <div class="qodef-quantity-buttons quantity">
            <label for="qodef-specification-bathrooms"><?php esc_html_e('Bathrooms', 'qode-real-estate'); ?></label>
            <span class="qodef-quantity-wrapper">
                <span class="qodef-spec-quantity-minus icon_minus-06"></span>
                <input id="qodef-specification-bathrooms" type="text" class="input-text qty text qodef-spec-quantity-input" data-step="1" data-min="0" data-max="10" name="qodef-specification-bathrooms" value="<?php echo esc_attr($property_bathrooms); ?>" title="<?php esc_attr_e( 'Property bathrooms', 'qode-real-estate' ) ?>" size="2" />
                <span class="qodef-spec-quantity-plus icon_plus"></span>
            </span>
        </div>
    </div>
</div>