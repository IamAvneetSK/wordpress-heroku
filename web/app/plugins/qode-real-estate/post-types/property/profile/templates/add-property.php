<?php

if (!function_exists('qodef_real_estate_dashboard_add_property_fields')) {
    function qodef_real_estate_dashboard_add_property_fields($params) {

        extract($params);

        $add_property = bridge_qode_add_dashboard_fields(array(
            'name' => 'add_property',
        ));

        $add_property_form = bridge_qode_add_dashboard_form(array(
            'name'         => 'add_property_form',
            'form_id'      => 'qodef-re-add-property-form',
            'form_action'  => 'qodef_re_add_property',
            'parent'       => $add_property,
            'button_label' => esc_html__('Create property', 'qode-real-estate'),
            'button_args'  => array(
                'data-updating-text' => esc_html__('Creating property', 'qode-real-estate'),
                'data-updated-text'  => esc_html__('Property created', 'qode-real-estate'),
            )
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'property_title',
            'label'  => esc_html__('Property Title', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'property_id',
            'label'  => esc_html__('Property ID', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_section_title(array(
            'name'   => 'project_title_featured_image',
            'title'  => esc_html__('Featured Image', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'image',
            'name'   => 'property_featured_image',
            'label'  => esc_html__('Featured Image', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_section_title(array(
            'name'   => 'project_title_property_type',
            'title'  => esc_html__('Property Type', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'    => 'checkboxgroup',
            'name'    => 'property_type',
            'parent'  => $add_property_form,
            'options' => qodef_re_get_property_terms_list_dashboard('property-type')
        ));

        bridge_qode_add_dashboard_section_title(array(
            'name'   => 'project_title_property_feature',
            'title'  => esc_html__('Property Feature', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'    => 'checkboxgroup',
            'name'    => 'property_feature',
            'parent'  => $add_property_form,
            'options' => qodef_re_get_property_terms_list_dashboard('property-feature')
        ));

        bridge_qode_add_dashboard_section_title(array(
            'name'   => 'project_title_property_status',
            'title'  => esc_html__('Property Status', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'    => 'checkboxgroup',
            'name'    => 'property_status',
            'parent'  => $add_property_form,
            'options' => qodef_re_get_property_terms_list_dashboard('property-status')
        ));

        bridge_qode_add_dashboard_section_title(array(
            'name'   => 'project_title_property_county',
            'title'  => esc_html__('Property County/State', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'    => 'checkboxgroup',
            'name'    => 'property_county',
            'parent'  => $add_property_form,
            'options' => qodef_re_get_property_terms_list_dashboard('property-county')
        ));

        bridge_qode_add_dashboard_section_title(array(
            'name'   => 'project_title_property_city',
            'title'  => esc_html__('Property City', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'    => 'checkboxgroup',
            'name'    => 'property_city',
            'parent'  => $add_property_form,
            'options' => qodef_re_get_property_terms_list_dashboard('property-city')
        ));

        bridge_qode_add_dashboard_section_title(array(
            'name'   => 'project_title_property_neighborhood',
            'title'  => esc_html__('Property Neighborhood', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'    => 'checkboxgroup',
            'name'    => 'property_neighborhood',
            'parent'  => $add_property_form,
            'options' => qodef_re_get_property_terms_list_dashboard('property-neighborhood')
        ));

        bridge_qode_add_dashboard_section_title(array(
            'name'   => 'project_title_property_tag',
            'title'  => esc_html__('Property Tags', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'    => 'checkboxgroup',
            'name'    => 'property_tag',
            'parent'  => $add_property_form,
            'options' => qodef_re_get_property_terms_list_dashboard('property-tag', false)
        ));

        bridge_qode_add_dashboard_section_title(array(
            'name'   => 'project_title_description',
            'title'  => esc_html__('Description', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'textarea',
            'name'   => 'description',
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_section_title(array(
            'name'   => 'project_title_specifications',
            'title'  => esc_html__('Specifications', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'price',
            'label'  => esc_html__('Price', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'discount_price',
            'label'  => esc_html__('Discount Price', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'price_label',
            'label'  => esc_html__('Price Label', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'    => 'select',
            'name'    => 'price_label_position',
            'label'   => esc_html__('Price Label Position', 'qode-real-estate'),
            'parent'  => $add_property_form,
            'options' => array(
                ''       => esc_html__('Default', 'qode-real-estate'),
                'before' => esc_html__('Before Price', 'qode-real-estate'),
                'after'  => esc_html__('After Price', 'qode-real-estate'),
            )
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'size',
            'label'  => esc_html__('Size', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'size_label',
            'label'  => esc_html__('Size Label', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'    => 'select',
            'name'    => 'size_label_position',
            'label'   => esc_html__('Size Label Position', 'qode-real-estate'),
            'parent'  => $add_property_form,
            'options' => array(
                ''       => esc_html__('Default', 'qode-real-estate'),
                'before' => esc_html__('Before Value', 'qode-real-estate'),
                'after'  => esc_html__('After Value', 'qode-real-estate'),
            )
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'bedrooms',
            'label'  => esc_html__('Bedrooms', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'bathrooms',
            'label'  => esc_html__('Bathrooms', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'floor',
            'label'  => esc_html__('Floor', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'total_floors',
            'label'  => esc_html__('Total Floors', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'year_built',
            'label'  => esc_html__('Year Built', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'heating',
            'label'  => esc_html__('Heating', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'accommodation',
            'label'  => esc_html__('Accommodation', 'qode-real-estate'),
            'parent' => $add_property_form
        ));


        bridge_qode_add_dashboard_section_title(array(
            'name'   => 'project_title_additional_specifications',
            'title'  => esc_html__('Additional Specifications', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'ceiling_height',
            'label'  => esc_html__('Ceiling Height', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'parking',
            'label'  => esc_html__('Parking', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'property_from_center',
            'label'  => esc_html__('Distance From the City Center', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'area_size',
            'label'  => esc_html__('Area Size', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'garages',
            'label'  => esc_html__('Garages', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'garages_size',
            'label'  => esc_html__('Garages Size', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'additional_space',
            'label'  => esc_html__('Additional Space', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'date',
            'name'   => 'publication_date',
            'label'  => esc_html__('Publication Date', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        if ($number_of_featured > 0) {

            bridge_qode_add_dashboard_field(array(
                'type'    => 'select',
                'name'    => 'featured_property',
                'label'   => esc_html__('Featured Property (can\'t be edited later)', 'qode-real-estate'),
                'parent'  => $add_property_form,
                'options' => array(
                    ''    => esc_html__('Default', 'qode-real-estate'),
                    'no'  => esc_html__('No', 'qode-real-estate'),
                    'yes' => esc_html__('Yes', 'qode-real-estate'),
                )
            ));

        }

        bridge_qode_add_dashboard_repeater_field(array(
            'name'         => 'property_leasing_terms',
            'label'        => esc_html__('Leasing Terms', 'qode-real-estate'),
            'parent'       => $add_property_form,
            'table_layout' => true,
            'button_text'  => esc_html__('Add New', 'qode-real-estate'),
            'fields'       => array(
                array(
                    'type'      => 'select',
                    'name'      => 'icon',
                    'th'        => esc_html__('Icon', 'qode-real-estate'),
                    'col_width' => '4',
                    'options'   => qodef_re_get_assets_icon_list(),
                    'args'      => array(
                    		'select2' => true
                    )
                ),
                array(
                    'type'      => 'text',
                    'name'      => 'label',
                    'th'        => esc_html__('Label', 'qode-real-estate'),
                    'col_width' => '4'
                ),
                array(
                    'type'      => 'text',
                    'name'      => 'value',
                    'th'        => esc_html__('Value', 'qode-real-estate'),
                    'col_width' => '4'
                ),
            )
        ));

        bridge_qode_add_dashboard_repeater_field(array(
            'name'         => 'property_costs',
            'label'        => esc_html__('Costs', 'qode-real-estate'),
            'parent'       => $add_property_form,
            'table_layout' => true,
            'button_text'  => esc_html__('Add New', 'qode-real-estate'),
            'fields'       => array(
                array(
                    'type'      => 'select',
                    'name'      => 'icon',
                    'th'        => esc_html__('Icon', 'qode-real-estate'),
                    'col_width' => '4',
                    'options'   => qodef_re_get_assets_icon_list(),
                    'args'      => array(
	                    'select2' => true
                    )
                ),
                array(
                    'type'      => 'text',
                    'name'      => 'label',
                    'th'        => esc_html__('Label', 'qode-real-estate'),
                    'col_width' => '4'
                ),
                array(
                    'type'      => 'text',
                    'name'      => 'value',
                    'th'        => esc_html__('Value', 'qode-real-estate'),
                    'col_width' => '4'
                ),
            )
        ));

        bridge_qode_add_dashboard_section_title(array(
            'name'   => 'project_title_address',
            'title'  => esc_html__('Address', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'address',
            'name'   => 'property_full_address',
            'label'  => esc_html__('Full Address', 'qode-real-estate'),
            'parent' => $add_property_form,
            'args'   => array(
                'latitude_field'  => 'property_latitude',
                'longitude_field' => 'property_longitude',
            )
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'property_latitude',
            'label'  => esc_html__('Latitude', 'qode-real-estate'),
            'parent' => $add_property_form,
            'args'   => array(
                'custom_class' => 'qodef-dashboard-address-elements'
            )
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'property_longitude',
            'label'  => esc_html__('Longitude', 'qode-real-estate'),
            'parent' => $add_property_form,
            'args'   => array(
                'custom_class' => 'qodef-dashboard-address-elements'
            )
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'property_simple_address',
            'label'  => esc_html__('Simple Address', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'property_zip_code',
            'label'  => esc_html__('Property ZIP Code', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'    => 'select',
            'name'    => 'property_country',
            'label'   => esc_html__('Country', 'qode-real-estate'),
            'parent'  => $add_property_form,
            'options' => qodef_re_get_countries_list()
        ));


        bridge_qode_add_dashboard_section_title(array(
            'name'   => 'project_title_media',
            'title'  => esc_html__('Media', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'gallery',
            'name'   => 'property_image_gallery',
            'label'  => esc_html__('Gallery Images', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'    => 'select',
            'name'    => 'property_video_type',
            'label'   => esc_html__('Video Service', 'qode-real-estate'),
            'parent'  => $add_property_form,
            'options' => array(
                'social_networks' => esc_html__('Video Service', 'qode-real-estate'),
                'self'            => esc_html__('Self Hosted', 'qode-real-estate'),
            )
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'property_video_link',
            'label'  => esc_html__('Enter video URL (if self hosted, enter MP4 format)', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'image',
            'name'   => 'property_video_image',
            'label'  => esc_html__('Video Image', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'property_virtual_tour',
            'label'  => esc_html__('Video Tour Core', 'qode-real-estate'),
            'parent' => $add_property_form
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'image',
            'name'   => 'property_attachment',
            'label'  => esc_html__('Attachment', 'qode-real-estate'),
            'parent' => $add_property_form,
            'args' => array(
                'button_text' => esc_html__('Upload Tour', 'qode-real-estate')
            )
        ));


        bridge_qode_add_dashboard_repeater_field(array(
            'name'   => 'property_multi_unit',
            'label'  => esc_html__('Multi Units / Sub Properties', 'qode-real-estate'),
            'parent' => $add_property_form,
            'button_text' => esc_html__('Add New', 'qode-real-estate'),
            'fields' => array(
                array(
                    'type'      => 'text',
                    'name'      => 'title',
                    'label'     => esc_html__('Title', 'qode-real-estate'),
                    'col_width' => '6'
                ),
                array(
                    'type'      => 'text',
                    'name'      => 'type',
                    'label'     => esc_html__('Type', 'qode-real-estate'),
                    'col_width' => '6'
                ),
                array(
                    'type'      => 'text',
                    'name'      => 'price',
                    'label'     => esc_html__('Price', 'qode-real-estate'),
                    'col_width' => '6'
                ),
                array(
                    'type'      => 'text',
                    'name'      => 'bedrooms',
                    'label'     => esc_html__('Bedrooms', 'qode-real-estate'),
                    'col_width' => '6'
                ),
                array(
                    'type'      => 'text',
                    'name'      => 'bathrooms',
                    'label'     => esc_html__('Bathrooms', 'qode-real-estate'),
                    'col_width' => '6'
                ),
                array(
                    'type'      => 'text',
                    'name'      => 'size',
                    'label'     => esc_html__('Size', 'qode-real-estate'),
                    'col_width' => '6'
                ),
                array(
                    'type'      => 'text',
                    'name'      => 'availability',
                    'label'     => esc_html__('Availability Date', 'qode-real-estate'),
                    'col_width' => '6'
                ),
            )
        ));

        bridge_qode_add_dashboard_repeater_field(array(
            'name'   => 'property_home_plan',
            'label'  => esc_html__('Home Plans', 'qode-real-estate'),
            'parent' => $add_property_form,
            'button_text' => esc_html__('Add New', 'qode-real-estate'),
            'fields' => array(
                array(
                    'type'      => 'text',
                    'name'      => 'title',
                    'label'     => esc_html__('Title', 'qode-real-estate'),
                    'col_width' => '6'
                ),
                array(
                    'type'      => 'text',
                    'name'      => 'price',
                    'label'     => esc_html__('Price', 'qode-real-estate'),
                    'col_width' => '6'
                ),
                array(
                    'type'      => 'text',
                    'name'      => 'bedrooms',
                    'label'     => esc_html__('Bedrooms', 'qode-real-estate'),
                    'col_width' => '6'
                ),
                array(
                    'type'      => 'text',
                    'name'      => 'bathrooms',
                    'label'     => esc_html__('Bathrooms', 'qode-real-estate'),
                    'col_width' => '6'
                ),
                array(
                    'type'      => 'text',
                    'name'      => 'size',
                    'label'     => esc_html__('Size', 'qode-real-estate'),
                    'col_width' => '6'
                ),
                array(
                    'type'      => 'image',
                    'name'      => 'image',
                    'label'     => esc_html__('Image', 'qode-real-estate'),
                    'col_width' => '6'
                ),
                array(
                    'type'      => 'textarea',
                    'name'      => 'description',
                    'label'     => esc_html__('Description', 'qode-real-estate'),
                    'col_width' => '12'
                )
            )
        ));

        bridge_qode_add_dashboard_field(array(
            'type'   => 'text',
            'name'   => 'property_package_meta',
            'parent' => $add_property_form,
            'value'  => qodef_re_get_user_current_package(),
            'args'   => array(
                'input_type' => 'hidden'
            ),
        ));

        $add_property->render();
    }
}

//fallback if someone enters page directly and has no packages

$package = qodef_re_property_addition_enabled();
?>
<div class="qodef-membership-dashboard-page qodef-real-estate-dashboard-page">
<?php
	//stongly false because of the 0 key for packages
	if ($package === false) { ?>
    <div class="qodef-no-package">
        <h3><?php esc_html_e('Please buy package in order to add more properties.', 'qode-real-estate'); ?></h3>
        <?php if (qode_membership_theme_installed()) {
            echo bridge_core_get_button_v2_html(array(
                'text' => esc_html__('BUY PACKAGES', 'qode-real-estate'),
                'link' => qodef_re_get_pricing_packages_page()
            ));
        } else {
            echo '<a itemprop="url" href="' . esc_url(qodef_re_get_pricing_packages_page()) . '" target="_self" class="qodef-btn qodef-btn-medium qodef-btn-solid"><span class="qodef-btn-text">' . esc_html__('BUY PACKAGES', 'qode-real-estate') . '</span></a>';
        }
        ?>
    </div>
<?php } else { ?>
    <div class="qodef-add-property-page">
        <h2 class="qodef-membership-page-title"><?php esc_html_e('Add Property', 'qode-real-estate'); ?></h2>
        <p><?php esc_html_e('Add New Property', 'qode-real-estate'); ?></p>

        <div>
            <?php qodef_real_estate_dashboard_add_property_fields($params); ?>
            <?php do_action('qode_membership_action_login_ajax_response'); ?>
        </div>
    </div>
<?php } ?>
</div>
	