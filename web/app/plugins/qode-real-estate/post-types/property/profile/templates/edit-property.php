<?php $property_db_id = $_GET['property_id'];

if ( !function_exists('qodef_real_estate_dashboard_edit_property_fields') ) {
	function qodef_real_estate_dashboard_edit_property_fields($params, $property_db_id){
		$title = '';
		$qodef_property_id_meta = '';
		$featured_image_url = '';
		$property_type_terms = '';
		$property_feature_terms = '';
		$property_status_terms = '';
		$property_county_terms = '';
		$property_city_terms = '';
		$property_neighborhood_terms = '';
		$property_tag_terms = '';
		$description = '';
		$qodef_property_price_meta = '';
		$qodef_property_discount_price_meta = '';
		$qodef_property_price_label_meta = '';
		$qodef_property_price_label_position_meta = '';
		$qodef_property_size_meta = '';
		$qodef_property_size_label_meta = '';
		$qodef_property_size_label_position_meta = '';
		$qodef_property_bedrooms_meta = '';
		$qodef_property_bathrooms_meta = '';
		$qodef_property_floor_meta = '';
		$qodef_property_total_floors_meta = '';
		$qodef_property_year_built_meta = '';
		$qodef_property_heating_meta = '';
		$qodef_property_accommodation_meta = '';
		$qodef_property_ceiling_height_meta = '';
		$qodef_property_parking_meta = '';
		$qodef_property_from_center_meta = '';
		$qodef_property_area_size_meta = '';
		$qodef_property_garages_meta = '';
		$qodef_property_garages_size_meta = '';
		$qodef_property_additional_space_meta = '';
		$qodef_property_publication_date_meta = '';
		$qodef_leasing_terms_meta = '';
		$qodef_costs_meta = '';
		$qodef_property_full_address_meta = '';
		$qodef_property_full_address_latitude = '';
		$qodef_property_full_address_longitude = '';
		$qodef_property_simple_address_meta = '';
		$qodef_property_zip_code_meta = '';
		$qodef_property_address_country_meta = '';
		$qodef_property_image_gallery = '';
		$qodef_property_video_type_meta = '';
		$qodef_property_video_display_link = '';
		$qodef_property_video_image_meta = '';
		$qodef_property_virtual_tour_meta = '';
		$qodef_property_attachment_meta = '';
		$qodef_multi_units_meta = '';
		$qodef_home_plans_meta = '';

		extract($params);

		$edit_property = bridge_qode_add_dashboard_fields(array(
			'name' => 'edit_agent',
		));

		$edit_property_form = bridge_qode_add_dashboard_form(array(
			'name' => 'edit_property_form',
			'form_id'   => 'qodef-re-edit-property-form',
			'form_action' => 'qodef_re_edit_property',
			'parent' => $edit_property,
			'button_label' => esc_html__( 'EDIT PROPERTY', 'qode-real-estate' ),
			'button_args' => array(
				'data-updating-text' => esc_html__('EDITING PROPERTY', 'qode-real-estate'),
				'data-updated-text' => esc_html__('PROPERTY EDITED', 'qode-real-estate'),
			)
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'property_db_id',
			'parent' => $edit_property_form,
			'value' => $property_db_id,
			'args' => array(
				'input_type' => 'hidden'
			),
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'property_title',
			'label' => esc_html__('Property Title','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $title
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'property_id',
			'label' => esc_html__('Property ID','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_id_meta
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'image',
			'name' => 'property_featured_image',
			'label' => esc_html__('Featured Image','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $featured_image_url
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'checkboxgroup',
			'name' => 'property_type',
			'label' => esc_html__('Property Type','qode-real-estate'),
			'parent' => $edit_property_form,
			'options' => qodef_re_get_property_terms_list_dashboard('property-type'),
			'value' => $property_type_terms
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'checkboxgroup',
			'name' => 'property_feature',
			'label' => esc_html__('Property Feature','qode-real-estate'),
			'parent' => $edit_property_form,
			'options' => qodef_re_get_property_terms_list_dashboard('property-feature'),
			'value' => $property_feature_terms
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'checkboxgroup',
			'name' => 'property_status',
			'label' => esc_html__('Property Status','qode-real-estate'),
			'parent' => $edit_property_form,
			'options' => qodef_re_get_property_terms_list_dashboard('property-status'),
			'value' => $property_status_terms
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'checkboxgroup',
			'name' => 'property_county',
			'label' => esc_html__('Property County/State','qode-real-estate'),
			'parent' => $edit_property_form,
			'options' => qodef_re_get_property_terms_list_dashboard('property-county'),
			'value' => $property_county_terms
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'checkboxgroup',
			'name' => 'property_city',
			'label' => esc_html__('Property City','qode-real-estate'),
			'parent' => $edit_property_form,
			'options' => qodef_re_get_property_terms_list_dashboard('property-city'),
			'value' => $property_city_terms
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'checkboxgroup',
			'name' => 'property_neighborhood',
			'label' => esc_html__('Property Neighborhood','qode-real-estate'),
			'parent' => $edit_property_form,
			'options' => qodef_re_get_property_terms_list_dashboard('property-neighborhood'),
			'value' => $property_neighborhood_terms
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'checkboxgroup',
			'name' => 'property_tag',
			'label' => esc_html__('Property Tags','qode-real-estate'),
			'parent' => $edit_property_form,
			'options' => qodef_re_get_property_terms_list_dashboard('property-tag', false),
			'value' => $property_tag_terms
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'textarea',
			'name' => 'description',
			'label' => esc_html__('Description','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $description
		));


		bridge_qode_add_dashboard_section_title(array(
			'name'   => 'project_title_specifications',
			'title'  => esc_html__( 'Specifications', 'qode-real-estate' ),
			'parent' => $edit_property_form
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'price',
			'label' => esc_html__('Price','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_price_meta
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'discount_price',
			'label' => esc_html__('Discount Price','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_discount_price_meta
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'price_label',
			'label' => esc_html__('Price Label','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_price_label_meta
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'select',
			'name' => 'price_label_position',
			'label' => esc_html__('Price Label Position','qode-real-estate'),
			'parent' => $edit_property_form,
			'options' => array(
				'' => esc_html__('Default','qode-real-estate'),
				'before' => esc_html__('Before Price','qode-real-estate'),
				'after' => esc_html__('After Price','qode-real-estate'),
			),
			'value' => $qodef_property_price_label_position_meta
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'size',
			'label' => esc_html__('Size','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_size_meta
		));
		
		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'size_label',
			'label' => esc_html__('Size Label','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_size_label_meta
		));
		
		bridge_qode_add_dashboard_field(array(
			'type' => 'select',
			'name' => 'size_label_position',
			'label' => esc_html__('Size Label Position','qode-real-estate'),
			'parent' => $edit_property_form,
			'options' => array(
				'' => esc_html__('Default','qode-real-estate'),
				'before' => esc_html__('Before Value','qode-real-estate'),
				'after' => esc_html__('After Value','qode-real-estate'),
			),
			'value' => $qodef_property_size_label_position_meta
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'bedrooms',
			'label' => esc_html__('Bedrooms','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_bedrooms_meta
		));
		
		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'bathrooms',
			'label' => esc_html__('Bathrooms','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_bathrooms_meta
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'floor',
			'label' => esc_html__('Floor','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_floor_meta
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'total_floors',
			'label' => esc_html__('Total Floors','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_total_floors_meta
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'year_built',
			'label' => esc_html__('Year Built','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_year_built_meta
		));
		
		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'heating',
			'label' => esc_html__('Heating','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_heating_meta
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'accommodation',
			'label' => esc_html__('Accommodation','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_accommodation_meta
		));


		bridge_qode_add_dashboard_section_title(array(
			'name'   => 'project_title_additional_specifications',
			'title'  => esc_html__( 'Additional Specifications', 'qode-real-estate' ),
			'parent' => $edit_property_form
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'ceiling_height',
			'label' => esc_html__('Ceiling Height','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_ceiling_height_meta
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'parking',
			'label' => esc_html__('Parking','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_parking_meta
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'property_from_center',
			'label' => esc_html__('Distance From the City Center','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_from_center_meta
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'area_size',
			'label' => esc_html__('Area Size','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_area_size_meta
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'garages',
			'label' => esc_html__('Garages','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_garages_meta
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'garages_size',
			'label' => esc_html__('Garages Size','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_garages_size_meta
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'additional_space',
			'label' => esc_html__('Additional Space','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_additional_space_meta
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'date',
			'name' => 'publication_date',
			'label' => esc_html__('Publication Date','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_publication_date_meta
		));

		bridge_qode_add_dashboard_repeater_field(array(
			'name' => 'property_leasing_terms',
			'label' => esc_html__('Leasing Terms','qode-real-estate'),
			'parent' => $edit_property_form,
			'table_layout' => true,
			'value' => $qodef_leasing_terms_meta,
			'fields' => array(
				array(
					'type'      => 'select',
					'name'      => 'icon',
					'th' => esc_html__('Icon','qode-real-estate'),
					'col_width' => '4',
					'options'   => qodef_re_get_assets_icon_list(),
					'args'      => array(
						'select2' => true
					)
				),
				array(
					'type' => 'text',
					'name' => 'label',
					'th' => esc_html__('Label','qode-real-estate'),
					'col_width' => '4'
				),
				array(
					'type' => 'text',
					'name' => 'value',
					'th' => esc_html__('Value','qode-real-estate'),
					'col_width' => '4'
				),
			)
		));

		bridge_qode_add_dashboard_repeater_field(array(
			'name' => 'property_costs',
			'label' => esc_html__('Costs','qode-real-estate'),
			'parent' => $edit_property_form,
			'table_layout' => true,
			'value' => $qodef_costs_meta,
			'fields' => array(
				array(
					'type'      => 'select',
					'name'      => 'icon',
					'th' => esc_html__('Icon','qode-real-estate'),
					'col_width' => '4',
					'options'   => qodef_re_get_assets_icon_list(),
					'args'      => array(
						'select2' => true
					)
				),
				array(
					'type' => 'text',
					'name' => 'label',
					'th' => esc_html__('Label','qode-real-estate'),
					'col_width' => '4'
				),
				array(
					'type' => 'text',
					'name' => 'value',
					'th' => esc_html__('Value','qode-real-estate'),
					'col_width' => '4'
				),
			)
		));


		bridge_qode_add_dashboard_field(array(
			'type' => 'address',
			'name' => 'property_full_address',
			'label' => esc_html__('Full Address','qode-real-estate'),
			'parent' => $edit_property_form,
			'args' => array(
				'latitude_field' => 'property_latitude',
				'longitude_field' => 'property_longitude',
			),
			'value' => $qodef_property_full_address_meta,
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'property_latitude',
			'label' => esc_html__('Latitude','qode-real-estate'),
			'parent' => $edit_property_form,
			'args' => array(
				'custom_class' => 'qodef-dashboard-address-elements'
			),
			'value' => $qodef_property_full_address_latitude,
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'property_longitude',
			'label' => esc_html__('Longitude','qode-real-estate'),
			'parent' => $edit_property_form,
			'args' => array(
				'custom_class' => 'qodef-dashboard-address-elements'
			),
			'value' => $qodef_property_full_address_longitude,
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'property_simple_address',
			'label' => esc_html__('Simple Address','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_simple_address_meta,
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'property_zip_code',
			'label' => esc_html__('Property ZIP Code','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_zip_code_meta,
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'select',
			'name' => 'property_country',
			'label' => esc_html__('Country','qode-real-estate'),
			'parent' => $edit_property_form,
			'options' => qodef_re_get_countries_list(),
			'value' => $qodef_property_address_country_meta,
		));


		bridge_qode_add_dashboard_section_title(array(
			'name'   => 'project_title_media',
			'title'  => esc_html__( 'Media', 'qode-real-estate' ),
			'parent' => $edit_property_form
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'gallery',
			'name' => 'property_image_gallery',
			'label' => esc_html__('Gallery Images','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_image_gallery,
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'select',
			'name' => 'property_video_type',
			'label' => esc_html__('Video Service','qode-real-estate'),
			'parent' => $edit_property_form,
			'options' => array(
				'social_networks' => esc_html__('Video Service', 'qode-real-estate'),
				'self' => esc_html__('Self Hosted', 'qode-real-estate'),
			),
			'value' => $qodef_property_video_type_meta,
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'property_video_link',
			'label' => esc_html__('Enter video URL (if self hosted, enter MP4 format)','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_video_display_link,
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'image',
			'name' => 'property_video_image',
			'label' => esc_html__('Video Image','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_video_image_meta,
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'property_virtual_tour',
			'label' => esc_html__('Video Tour Core','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_virtual_tour_meta,
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'image',
			'name' => 'property_attachment',
			'label' => esc_html__('Attachment','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_property_attachment_meta,
			'args' => array(
				'not_image' => true
			)
		));


		bridge_qode_add_dashboard_repeater_field(array(
			'name' => 'property_multi_unit',
			'label' => esc_html__('Multi Units / Sub Properties','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_multi_units_meta,
			'fields' => array(
				array(
					'type' => 'text',
					'name' => 'title',
					'label' => esc_html__('Title','qode-real-estate'),
					'col_width' => '6'
				),
				array(
					'type' => 'text',
					'name' => 'type',
					'label' => esc_html__('Type','qode-real-estate'),
					'col_width' => '6'
				),
				array(
					'type' => 'text',
					'name' => 'price',
					'label' => esc_html__('Price','qode-real-estate'),
					'col_width' => '6'
				),
				array(
					'type' => 'text',
					'name' => 'bedrooms',
					'label' => esc_html__('Bedrooms','qode-real-estate'),
					'col_width' => '6'
				),
				array(
					'type' => 'text',
					'name' => 'bathrooms',
					'label' => esc_html__('Bathrooms','qode-real-estate'),
					'col_width' => '6'
				),
				array(
					'type' => 'text',
					'name' => 'size',
					'label' => esc_html__('Size','qode-real-estate'),
					'col_width' => '6'
				),
				array(
					'type' => 'text',
					'name' => 'availability',
					'label' => esc_html__('Availability Date','qode-real-estate'),
					'col_width' => '6'
				),
			)
		));

		bridge_qode_add_dashboard_repeater_field(array(
			'name' => 'property_home_plan',
			'label' => esc_html__('Home Plans','qode-real-estate'),
			'parent' => $edit_property_form,
			'value' => $qodef_home_plans_meta,
			'fields' => array(
				array(
					'type' => 'text',
					'name' => 'title',
					'label' => esc_html__('Title','qode-real-estate'),
					'col_width' => '6'
				),
				array(
					'type' => 'text',
					'name' => 'price',
					'label' => esc_html__('Price','qode-real-estate'),
					'col_width' => '6'
				),
				array(
					'type' => 'text',
					'name' => 'bedrooms',
					'label' => esc_html__('Bedrooms','qode-real-estate'),
					'col_width' => '6'
				),
				array(
					'type' => 'text',
					'name' => 'bathrooms',
					'label' => esc_html__('Bathrooms','qode-real-estate'),
					'col_width' => '6'
				),
				array(
					'type' => 'text',
					'name' => 'size',
					'label' => esc_html__('Size','qode-real-estate'),
					'col_width' => '6'
				),
				array(
					'type' => 'image',
					'name' => 'image',
					'label' => esc_html__('Image','qode-real-estate'),
					'col_width' => '6'
				),
				array(
					'type' => 'textarea',
					'name' => 'description',
					'label' => esc_html__('Description','qode-real-estate'),
					'col_width' => '12'
				)
			)
		));

		$edit_property->render();
	}
}

?>
<div class="qodef-membership-dashboard-page qodef-real-estate-dashboard-page">
	<div class="qodef-edit-property-page">
		<h2 class="qodef-membership-page-title"><?php esc_html_e('Edit Property', 'qode-real-estate'); ?></h2>
		<p><?php esc_html_e('Edit Property', 'qode-real-estate'); ?></p>
		<div>
			<?php qodef_real_estate_dashboard_edit_property_fields(qodef_re_get_property_meta($property_db_id),$property_db_id);?>
			<?php do_action( 'qode_membership_action_login_ajax_response' ); ?>
		</div>
	</div>
</div>