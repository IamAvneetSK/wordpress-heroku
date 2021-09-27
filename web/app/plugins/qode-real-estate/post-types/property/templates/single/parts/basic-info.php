<?php
$property_size = get_post_meta(get_the_ID(), 'qodef_property_size_meta', true);

$property_structure = get_post_meta(get_the_ID(), 'qodef_property_bedrooms_meta', true);
$property_structure_label = $property_structure == 1 ? esc_html__('Bedroom', 'qode-real-estate') : esc_html__('Bedrooms', 'qode-real-estate');

$property_accommodation = get_post_meta(get_the_ID(), 'qodef_property_accommodation_meta', true);

$property_heating = get_post_meta(get_the_ID(), 'qodef_property_heating_meta', true);

$assocciated_user_type = get_post_meta(get_the_ID(), 'qodef_property_contact_info_meta', true);
?>
<div class="qodef-property-basic-info-holder">
    <div class="qodef-property-basic-info-outer">
        <div class="qodef-property-basic-info-inner-left clearfix">
            <div class="qodef-property-param">
                <span class="qodef-property-content">
                    <span class="qodef-property-label">
                        <?php esc_html_e('Property size:', 'qode-real-estate'); ?>
                    </span>
                    <span class="qodef-property-value">
                       <?php echo qodef_re_get_real_estate_size_html($property_size); ?>
                    </span>
                </span>
            </div>
            <div class="qodef-property-param">
                <span class="qodef-property-content">
                    <span class="qodef-property-label">
                        <?php esc_html_e('Structure:', 'qode-real-estate'); ?>
                    </span>
                    <span class="qodef-property-value">
                       <?php echo esc_html($property_structure) . ' ' . $property_structure_label; ?>
                    </span>
                </span>
            </div>
            <div class="qodef-property-param">
                <span class="qodef-property-content">
                    <span class="qodef-property-label">
                        <?php esc_html_e('Accommodation:', 'qode-real-estate'); ?>
                    </span>
                    <span class="qodef-property-value">
                       <?php echo esc_html($property_accommodation); ?>
                    </span>
                </span>
            </div>
            <div class="qodef-property-param">
                <span class="qodef-property-content">
                    <span class="qodef-property-label">
                        <?php esc_html_e('Heating:', 'qode-real-estate'); ?>
                    </span>
                    <span class="qodef-property-value">
                       <?php echo esc_html($property_heating); ?>
                    </span>
                </span>
            </div>
        </div>
        <div class="qodef-property-basic-info-inner-right clearfix">
            <?php if($assocciated_user_type !== '') { ?>
                <div class="qodef-property-cta">
                    <?php
                    $button_text = bridge_qode_options()->getOptionValue('property_enquiry_button_text');
                    $button_text = $button_text !== '' ? $button_text : esc_html__( 'Request a showing', 'qode-real-estate' );
                    echo bridge_core_get_button_html(
                        array(
                            'custom_class' => 'qodef-property-single-action',
                            'html_type'    => 'anchor',
                            'text'         => $button_text
                        )
                    );
                    ?>
                    <?php
                    $enable_compare = bridge_qode_options()->getOptionValue('enable_property_comparing');
                    if ($enable_compare == 'yes') {
                        $enable_compare_single = bridge_qode_options()->getOptionValue('enable_property_comparing_single');
                        if($enable_compare_single == 'yes') { ?>
                            <div class="qodef-item-compare">
                                <?php echo qodef_re_get_add_to_compare_list_button(); ?>
                            </div>
                        <?php   }
                    }
                    ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
