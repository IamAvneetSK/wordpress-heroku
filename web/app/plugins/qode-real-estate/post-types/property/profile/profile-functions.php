<?php

if ( ! function_exists( 'qodef_re_add_profile_navigation_item' ) ) {
	function qodef_re_add_profile_navigation_item( $navigation, $dashboard_url ) {
		
		$user = wp_get_current_user();
		
		$navigation['property-favorites'] = array(
			'url'         => esc_url( add_query_arg( array( 'user-action' => 'property-favorites' ), $dashboard_url ) ),
			'text'        => esc_html__( 'Property Wishlist', 'qode-real-estate' ),
			'user_action' => 'property-favorites',
			'icon'        => '<span class="lnr lnr-heart"></span>'
		);

        $navigation['property-searches'] = array(
            'url'         => esc_url( add_query_arg( array( 'user-action' => 'property-searches' ), $dashboard_url ) ),
            'text'        => esc_html__( 'Saved Searches', 'qode-real-estate' ),
            'user_action' => 'property-searches',
			'icon'        => '<span class="lnr lnr-magnifier"></span>'
        );

		//Check if role in approved roles
		if ( qodef_re_approved_user_roles($user->roles ) ) {
			if (post_type_exists('property')) {
				$navigation['list-properties'] = array(
					'url'         => esc_url( add_query_arg( array( 'user-action' => 'list-properties' ), $dashboard_url ) ),
					'text'        => esc_html__( 'My Properties', 'qode-real-estate' ),
					'user_action' => 'list-properties',
					'icon'        => '<span class="lnr lnr-text-align-left"></span>'
				);

				$package = qodef_re_property_addition_enabled();

				//stongly false because of the 0 key for packages
				if ($package !== false) {
					$add_property_url = esc_url( add_query_arg( array( 'user-action' => 'add-property' ), $dashboard_url ) );
				} else {
					$add_property_url = qodef_re_get_pricing_packages_page();
				}

				$navigation['add-property'] = array(
					'url'         => $add_property_url,
					'text'        => esc_html__( 'Add Property', 'qode-real-estate' ),
					'user_action' => 'add-property',
					'icon'        => '<span class="lnr lnr-file-add"></span>'
				);

			}
		}
		
		return $navigation;
	}
	
	add_filter( 'qode_membership_dashboard_navigation_pages', 'qodef_re_add_profile_navigation_item', 10, 2 );
}

if ( ! function_exists( 'qodef_re_add_profile_navigation_pages' ) ) {
	function qodef_re_add_profile_navigation_pages( $page, $action ) {
		$user = wp_get_current_user();

        if( $action == 'property-favorites' ) {
            $favorites_params = array();
            $user_favorites = qode_membership_get_user_favorites(get_current_user_id(), array('property'));
            $favorites_params['user_favorites'] = $user_favorites;
            $page['profile'] = qodef_re_cpt_single_module_template_part( 'profile/templates/favorites-list', 'property', '', $favorites_params );
        }
        else if( $action == 'property-searches' ) {
            $searches_params = array();
            $user_searches = get_user_meta(get_current_user_id(), 'qodef_user_saved_queries', true);
            $searches_params['user_searches'] = $user_searches;
            $page['profile'] = qodef_re_cpt_single_module_template_part( 'profile/templates/searches-list', 'property', '', $searches_params );
        }
        else if( $action == 'edit-property' && qodef_re_approved_user_roles($user->roles) ) {
            $page['profile'] = qodef_re_cpt_single_module_template_part( 'profile/templates/edit-property', 'property' );
        }
        else if( $action == 'add-property' && qodef_re_approved_user_roles($user->roles) ) {
            $add_property_params = qodef_re_get_add_property_params();
            $page['profile'] = qodef_re_cpt_single_module_template_part( 'profile/templates/add-property', 'property', '', $add_property_params);
        }
        else if( $action == 'list-properties' && qodef_re_approved_user_roles($user->roles) ) {
            $list_params['query_args'] = qodef_re_all_user_properties_query();
            $list_params['dashboard_url'] = qode_membership_get_dashboard_page_url();
            $page['profile'] = qodef_re_cpt_single_module_template_part( 'profile/templates/user-properties-list', 'property', '', $list_params );
        }

		return $page;
	}
	
	add_filter( 'qode_membership_dashboard_pages', 'qodef_re_add_profile_navigation_pages', 10, 2 );
}

/*
* Function for adding new property
*/

if ( ! function_exists( 'qodef_re_add_property' ) ) {
	function qodef_re_add_property() {
		if ( empty( $_POST ) || ! isset( $_POST ) ) {
			qodef_re_ajax_status( 'error', esc_html__( 'All fields are empty', 'qode-real-estate' ) );
		} else {
			$dashboard_url = apply_filters( 'qode_membership_filter_add_property_redirect_url', qode_membership_get_dashboard_page_url() );
			$published = bridge_qode_options()->getOptionValue('real_estate_enable_publish_from_user');
			parse_str( $_POST['data'], $new_property_data );

			$user = wp_get_current_user();
			$nonce_name = 'qodef_validate_'.$new_property_data['qodef_form_name'].'_'.$user->ID;
			$nonce_value = 'qodef_nonce_'.$new_property_data['qodef_form_name'].'_'.$user->ID;

			//Check nonce
			if ( wp_verify_nonce( $new_property_data[$nonce_value], $nonce_name ) && qodef_re_approved_user_roles($user->roles ) ) {
				$property_params = array();
				$property_params['meta_input'] = array();
				$property_params['tax_input'] = array();
				$property_ids = array();

				$query_args = array(
					'post_status'    => 'publish',
					'post_type'      => 'property',
				);

				$query_results = new \WP_Query( $query_args );

				if($query_results->have_posts()):
					while ( $query_results->have_posts() ) : $query_results->the_post();
						$id = get_the_ID();
						if (get_post_meta($id,'qodef_property_id_meta',true) !== ''){
							$property_ids[] = get_post_meta($id,'qodef_property_id_meta',true);
						}
					endwhile;
				endif;

				//Check if property id already exists
				if ( in_array($new_property_data['property_id'], $property_ids) ){					
					qodef_re_ajax_status( 'error', esc_html__( 'This property ID is taken, please try another.', 'qode-real-estate' ) );
				} else {
					$property_params['meta_input']['qodef_property_id_meta'] = $new_property_data['property_id'];
				}

				if ($new_property_data['property_title'] == ''){					
					qodef_re_ajax_status( 'error', esc_html__( 'Please enter property title', 'qode-real-estate' ) );
				}
				
				$property_params['post_title'] = $new_property_data['property_title'];
				$property_params['post_type'] = 'property';
				$property_params['post_content'] = $new_property_data['description'];

				if ( is_array($new_property_data['property_type']) && count($new_property_data['property_type']) ) {
					$property_params['tax_input']['property-type'] = $new_property_data['property_type'];
				}

				if ( is_array($new_property_data['property_feature']) && count($new_property_data['property_feature']) ) {
					$property_params['tax_input']['property-feature'] = $new_property_data['property_feature'];
				}

				if ( is_array($new_property_data['property_status']) && count($new_property_data['property_status']) ) {
					$property_params['tax_input']['property-status'] = $new_property_data['property_status'];
				}

				if ( is_array($new_property_data['property_county']) && count($new_property_data['property_county']) ) {
					$property_params['tax_input']['property-county'] = $new_property_data['property_county'];
				}

				if ( is_array($new_property_data['property_city']) && count($new_property_data['property_city']) ) {
					$property_params['tax_input']['property-city'] = $new_property_data['property_city'];
				}

				if ( is_array($new_property_data['property_neighborhood']) && count($new_property_data['property_neighborhood']) ) {
					$property_params['tax_input']['property-neighborhood'] = $new_property_data['property_neighborhood'];
				}
				
				//property_tag is non-hierahical, so it must be assigned as string of slugs so it doesn't create new tag
				if ( is_array($new_property_data['property_tag']) && count($new_property_data['property_tag']) ) {
					$property_params['tax_input']['property-tag'] = implode(', ', $new_property_data['property_tag']);
				}

				$property_params['meta_input']['qodef_property_price_meta'] = $new_property_data['price'];
				$property_params['meta_input']['qodef_property_discount_price_meta'] = $new_property_data['discount_price'];
				$property_params['meta_input']['qodef_property_price_label_meta'] = $new_property_data['price_label'];
				$property_params['meta_input']['qodef_property_price_label_position_meta'] = $new_property_data['price_label_position'];
				$property_params['meta_input']['qodef_property_size_meta'] = $new_property_data['size'];
				$property_params['meta_input']['qodef_property_size_label_meta'] = $new_property_data['size_label'];
				$property_params['meta_input']['qodef_property_size_label_position_meta'] = $new_property_data['size_label_position'];
				$property_params['meta_input']['qodef_property_bedrooms_meta'] = $new_property_data['bedrooms'];
				$property_params['meta_input']['qodef_property_bathrooms_meta'] = $new_property_data['bathrooms'];
				$property_params['meta_input']['qodef_property_floor_meta'] = $new_property_data['floor'];
				$property_params['meta_input']['qodef_property_total_floors_meta'] = $new_property_data['total_floors'];
				$property_params['meta_input']['qodef_property_year_built_meta'] = $new_property_data['year_built'];
				$property_params['meta_input']['qodef_property_heating_meta'] = $new_property_data['heating'];
				$property_params['meta_input']['qodef_property_accommodation_meta'] = $new_property_data['accommodation'];

				$property_params['meta_input']['qodef_property_ceiling_height_meta'] = $new_property_data['ceiling_height'];
				$property_params['meta_input']['qodef_property_parking_meta'] = $new_property_data['parking'];
				$property_params['meta_input']['qodef_property_from_center_meta'] = $new_property_data['property_from_center'];
				$property_params['meta_input']['qodef_property_area_size_meta'] = $new_property_data['area_size'];
				$property_params['meta_input']['qodef_property_garages_meta'] = $new_property_data['garages'];
				$property_params['meta_input']['qodef_property_garages_size_meta'] = $new_property_data['garages_size'];
				$property_params['meta_input']['qodef_property_additional_space_meta'] = $new_property_data['additional_space'];
				$property_params['meta_input']['qodef_property_publication_date_meta'] = $new_property_data['publication_date'];
				$property_params['meta_input']['qodef_property_is_featured_meta'] = $new_property_data['featured_property'];
				
				$property_params['meta_input']['qodef_leasing_terms_meta'] = $new_property_data['property_leasing_terms'];
				$property_params['meta_input']['qodef_costs_meta'] = $new_property_data['property_costs'];

				$property_params['meta_input']['qodef_property_full_address_meta'] = $new_property_data['property_full_address'];
				$property_params['meta_input']['qodef_property_full_address_latitude'] = $new_property_data['property_latitude'];
				$property_params['meta_input']['qodef_property_full_address_longitude'] = $new_property_data['property_longitude'];
				$property_params['meta_input']['qodef_property_simple_address_meta'] = $new_property_data['property_simple_address'];
				$property_params['meta_input']['qodef_property_zip_code_meta'] = $new_property_data['property_zip_code'];
				$property_params['meta_input']['qodef_property_address_country_meta'] = $new_property_data['property_country'];
				
				// WordPress handles the upload (keys form $_FILES used).
				$property_image_gallery_array = array();
				$property_home_plan_image = array();

				foreach ($_FILES as $key => $value) {
					if (stripos($key,'_qodef_reg_')) {

						$lastLetterPos = stripos($key,'_qodef_reg_');
						$name = substr($key, 0, $lastLetterPos);

					} elseif (stripos($key,'_qodef_regarray_')) {

						$lastLetterPos = stripos($key,'_qodef_regarray_');
						$name = substr($key, 0, $lastLetterPos);
					}

					if ($value['name'] == 'qodef-dummy-file.txt'){
						$attachment_id = '';
						$attachment_url = '';
					} else {
						$attachment_id = media_handle_upload( $key, 0 );
						$attachment_url = wp_get_attachment_url($attachment_id);
					}

					if ( is_wp_error( $attachment_id ) ) {
						qodef_re_ajax_status( 'error', esc_html__( 'Image not uploaded, please try again.', 'qode-real-estate' ) );
					} else {
						switch ($name) {
							case 'property_featured_image':
								$featured_image_id = $attachment_id;
								break;
							case 'property_image_gallery':
								$property_image_gallery_array[] = $attachment_id;
								break;
							case 'property_home_plan':
								$property_home_plan_image[] = $attachment_url;
								break;
							case 'property_video_image':
								$property_params['meta_input']['qodef_property_video_image_meta'] = $attachment_url;
								break;
							case 'property_attachment':
								$property_params['meta_input']['qodef_property_attachment_meta'] = $attachment_url;
								break;
						}
					}
				}

				//add multiple images to single qodef_property_image_gallery field
				$property_params['meta_input']['qodef_property_image_gallery'] = implode(',', $property_image_gallery_array);

				$video_service = $new_property_data['property_video_type'];
				$property_params['meta_input']['qodef_property_video_type_meta'] = $video_service;

				if ($video_service == 'social_networks') {
					$property_params['meta_input']['qodef_property_video_link_meta'] = $new_property_data['property_video_link'];
				} else {
					$property_params['meta_input']['qodef_property_video_custom_meta'] = $new_property_data['property_video_link'];
				}

				$property_params['meta_input']['qodef_property_virtual_tour_meta'] = $new_property_data['property_virtual_tour'];

				//merge options for repeater that have image

				//merge home plan
				$home_plan_options = $new_property_data['property_home_plan'];
				$merged_home_plan_options = array();

				foreach ($home_plan_options as $key => $home_plan_row) {
					$home_plan_row['image'] = $property_home_plan_image[$key];
					$merged_home_plan_options[] = $home_plan_row;
				}

				$property_params['meta_input']['qodef_multi_units_meta'] = $new_property_data['property_multi_unit'];
				$property_params['meta_input']['qodef_home_plans_meta'] = $merged_home_plan_options;

				$user_role = 'agent';
				if ( in_array( 'agency', $user->roles ) ) {
					$user_role = 'agency';
				} elseif ( in_array( 'owner', $user->roles ) ) {
					$user_role = 'owner';
				}

				$property_params['meta_input']['qodef_property_contact_info_meta'] = $user_role;
				$property_params['meta_input']['qodef_property_contact_'.$user_role.'_meta'] = $user->ID;

				$property_params['meta_input']['qodef_property_package_meta'] = $new_property_data['property_package_meta'];

				if ($published == 'yes'){
					$property_params['post_status'] = 'publish';
				}

				$property_id = wp_insert_post($property_params);
				if ( ! is_wp_error( $property_id ) ) {
					set_post_thumbnail($property_id, $featured_image_id);
					qodef_re_ajax_status( 'success', esc_html__( 'Property successfully added.', 'qode-real-estate' ), NULL, $dashboard_url);
				} else {
					qodef_re_ajax_status( 'error', esc_html__( 'Error.', 'qode-real-estate' ) );
				}				

			} else {
				qodef_re_ajax_status( 'error', esc_html__( 'Error.', 'qode-real-estate' ) );
			}
		}
	}

	add_action( 'wp_ajax_qodef_re_add_property', 'qodef_re_add_property' );
}

if (!function_exists('qodef_re_all_user_properties_query')) {
	function qodef_re_all_user_properties_query(){
		$query_array = array(
			'post_status'    => array('publish','draft'),
			'post_type'      => 'property',
			'posts_per_page' => '-1',
			'author' => get_current_user_id()
		);

		return $query_array;
	}
}

if (!function_exists('qodef_re_get_property_meta')) {
	function qodef_re_get_property_meta($id){
		$meta_values_array = array();
		$meta = get_post_meta($id);

		$meta_values_array['title'] = get_the_title($id);
		$meta_values_array['featured_image'] = get_post_thumbnail_id($id);
		$meta_values_array['featured_image_url'] = get_the_post_thumbnail_url($id);
		$meta_values_array['description'] = get_post_field('post_content', $id);
	
		foreach ($meta as $param_key => $array_value) {
			switch ($param_key) {
				case 'qodef_leasing_terms_meta':
				case 'qodef_costs_meta':
				case 'qodef_home_plans_meta':
				case 'qodef_multi_units_meta':
					$meta_values_array[$param_key] = get_post_meta($id,$param_key,true);
					break;				
				default:
					$meta_values_array[$param_key] = $array_value[0];
					break;
			}
		}

		if ($meta_values_array['qodef_property_video_type_meta'] == 'social_networks'){
			if (isset($meta_values_array['qodef_property_video_link_meta'])) {
				$meta_values_array['qodef_property_video_display_link'] = $meta_values_array['qodef_property_video_link_meta'];
			} else {
				$meta_values_array['qodef_property_video_display_link'] = '';
			}
		} else {
			if (isset($meta_values_array['qodef_property_video_custom_meta'])) {
				$meta_values_array['qodef_property_video_display_link'] = $meta_values_array['qodef_property_video_custom_meta'];
			} else {
				$meta_values_array['qodef_property_video_display_link'] = '';
			}
		}

		$property_type_terms = array();
		$terms = get_the_terms($id,'property-type');
		if (is_array($terms) && count($terms)) {
			foreach ($terms as $term) {
				$property_type_terms[] = $term->term_id;
			}
		}

		$property_feature_terms = array();
		$terms = get_the_terms($id,'property-feature');
		if (is_array($terms) && count($terms)) {
			foreach ($terms as $term) {
				$property_feature_terms[] = $term->term_id;
			}
		}

		$property_status_terms = array();
		$terms = get_the_terms($id,'property-status');
		if (is_array($terms) && count($terms)) {
			foreach ($terms as $term) {
				$property_status_terms[] = $term->term_id;
			}
		}

		$property_county_terms = array();
		$terms = get_the_terms($id,'property-county');
		if (is_array($terms) && count($terms)) {
			foreach ($terms as $term) {
				$property_county_terms[] = $term->term_id;
			}
		}

		$property_city_terms = array();
		$terms = get_the_terms($id,'property-city');
		if (is_array($terms) && count($terms)) {
			foreach ($terms as $term) {
				$property_city_terms[] = $term->term_id;
			}
		}

		$property_neighborhood_terms = array();
		$terms = get_the_terms($id,'property-neighborhood');
		if (is_array($terms) && count($terms)) {
			foreach ($terms as $term) {
				$property_neighborhood_terms[] = $term->term_id;
			}
		}

		$property_tag_terms = array();
		$terms = get_the_terms($id,'property-tag');
		if (is_array($terms) && count($terms)) {
			foreach ($terms as $term) {
				$property_tag_terms[] = $term->slug;
			}
		}

		$meta_values_array['property_type_terms'] = $property_type_terms;
		$meta_values_array['property_feature_terms'] = $property_feature_terms;
		$meta_values_array['property_status_terms'] = $property_status_terms;
		$meta_values_array['property_county_terms'] = $property_county_terms;
		$meta_values_array['property_city_terms'] = $property_city_terms;
		$meta_values_array['property_neighborhood_terms'] = $property_neighborhood_terms;
		$meta_values_array['property_tag_terms'] = $property_tag_terms;
		
		//get just file name for attachment
		if ( isset($meta_values_array['qodef_property_attachment_meta']) && $meta_values_array['qodef_property_attachment_meta'] !== ''){
			preg_match('/[^\/]+$/', $meta_values_array['qodef_property_attachment_meta'], $matches, PREG_OFFSET_CAPTURE);
			if (is_array($matches) && count($matches)) {
				$meta_values_array['qodef_property_attachment_meta'] = $matches[0][0];
			}
		}

		return $meta_values_array;
	}
}

/*
* Function for editing property
*/

if ( ! function_exists( 'qodef_re_edit_property' ) ) {
	function qodef_re_edit_property() {
		if ( empty( $_POST ) || ! isset( $_POST ) ) {
			qodef_re_ajax_status( 'error', esc_html__( 'All fields are empty', 'qode-real-estate' ) );
		} else {
			parse_str( $_POST['data'], $new_property_data );
			$property_db_id = $new_property_data['property_db_id'];
			$dashboard_url = apply_filters( 'qode_membership_filter_edit_property_redirect_url', qode_membership_get_dashboard_page_url() );

			$user = wp_get_current_user();
			$nonce_name = 'qodef_validate_'.$new_property_data['qodef_form_name'].'_'.$user->ID;
			$nonce_value = 'qodef_nonce_'.$new_property_data['qodef_form_name'].'_'.$user->ID;
			
			//Check nonce
			if ( wp_verify_nonce( $new_property_data[$nonce_value], $nonce_name ) && qodef_re_approved_user_roles($user->roles ) ) {
				$property_params = array();
				$property_params['meta_input'] = array();
				$property_params['tax_input'] = array();
				$property_ids = array();

				$query_args = array(
					'post_status'    => 'publish',
					'post_type'      => 'property',
				);

				$query_results = new \WP_Query( $query_args );

				if($query_results->have_posts()):
					while ( $query_results->have_posts() ) : $query_results->the_post();
						$id = get_the_ID();
						if (get_post_meta($id,'qodef_property_id_meta',true) !== ''){
							$property_ids[] = get_post_meta($id,'qodef_property_id_meta',true);
						}
					endwhile;
				endif;

				$current_property_id = get_post_meta($property_db_id,'qodef_property_id_meta', true);

				if ($current_property_id !== $new_property_data['property_id']){
					//Check if property id already exists 
					if ( in_array($new_property_data['property_id'], $property_ids) ){					
						qodef_re_ajax_status( 'error', esc_html__( 'This property ID is taken, please try another.', 'qode-real-estate' ) );
					} else {
						$property_params['meta_input']['qodef_property_id_meta'] = $new_property_data['property_id'];
					}
				}

				if ( is_array($new_property_data['property_type']) && count($new_property_data['property_type']) ) {
					$property_params['tax_input']['property-type'] = array_map('intval', $new_property_data['property_type']);
				}

				if ( is_array($new_property_data['property_feature']) && count($new_property_data['property_feature']) ) {
					$property_params['tax_input']['property-feature'] = array_map('intval', $new_property_data['property_feature']);
				}

				if ( is_array($new_property_data['property_status']) && count($new_property_data['property_status']) ) {
					$property_params['tax_input']['property-status'] = array_map('intval', $new_property_data['property_status']);
				}

				if ( is_array($new_property_data['property_county']) && count($new_property_data['property_county']) ) {
					$property_params['tax_input']['property-county'] = array_map('intval', $new_property_data['property_county']);
				}

				if ( is_array($new_property_data['property_city']) && count($new_property_data['property_city']) ) {
					$property_params['tax_input']['property-city'] = array_map('intval', $new_property_data['property_city']);
				}

				if ( is_array($new_property_data['property_neighborhood']) && count($new_property_data['property_neighborhood']) ) {
					$property_params['tax_input']['property-neighborhood'] = array_map('intval', $new_property_data['property_neighborhood']);
				}
				
				//property_tag is non-hierahical, so it must be assigned as string of slugs so it doesn't create new tag
				if ( is_array($new_property_data['property_tag']) && count($new_property_data['property_tag']) ) {
					$property_params['tax_input']['property-tag'] = $new_property_data['property_tag'];
				}

				$property_params['meta_input']['qodef_property_price_meta'] = $new_property_data['price'];
				$property_params['meta_input']['qodef_property_discount_price_meta'] = $new_property_data['discount_price'];
				$property_params['meta_input']['qodef_property_price_label_meta'] = $new_property_data['price_label'];
				$property_params['meta_input']['qodef_property_price_label_position_meta'] = $new_property_data['price_label_position'];
				$property_params['meta_input']['qodef_property_size_meta'] = $new_property_data['size'];
				$property_params['meta_input']['qodef_property_size_label_meta'] = $new_property_data['size_label'];
				$property_params['meta_input']['qodef_property_size_label_position_meta'] = $new_property_data['size_label_position'];
				$property_params['meta_input']['qodef_property_bedrooms_meta'] = $new_property_data['bedrooms'];
				$property_params['meta_input']['qodef_property_bathrooms_meta'] = $new_property_data['bathrooms'];
				$property_params['meta_input']['qodef_property_floor_meta'] = $new_property_data['floor'];
				$property_params['meta_input']['qodef_property_total_floors_meta'] = $new_property_data['total_floors'];
				$property_params['meta_input']['qodef_property_year_built_meta'] = $new_property_data['year_built'];
				$property_params['meta_input']['qodef_property_heating_meta'] = $new_property_data['heating'];
				$property_params['meta_input']['qodef_property_accommodation_meta'] = $new_property_data['accommodation'];

				$property_params['meta_input']['qodef_property_ceiling_height_meta'] = $new_property_data['ceiling_height'];
				$property_params['meta_input']['qodef_property_parking_meta'] = $new_property_data['parking'];
				$property_params['meta_input']['qodef_property_from_center_meta'] = $new_property_data['property_from_center'];
				$property_params['meta_input']['qodef_property_area_size_meta'] = $new_property_data['area_size'];
				$property_params['meta_input']['qodef_property_garages_meta'] = $new_property_data['garages'];
				$property_params['meta_input']['qodef_property_garages_size_meta'] = $new_property_data['garages_size'];
				$property_params['meta_input']['qodef_property_additional_space_meta'] = $new_property_data['additional_space'];
				$property_params['meta_input']['qodef_property_publication_date_meta'] = $new_property_data['publication_date'];
				
				$property_params['meta_input']['qodef_leasing_terms_meta'] = $new_property_data['property_leasing_terms'];
				$property_params['meta_input']['qodef_costs_meta'] = $new_property_data['property_costs'];

				$property_params['meta_input']['qodef_property_full_address_meta'] = $new_property_data['property_full_address'];
				$property_params['meta_input']['qodef_property_full_address_latitude'] = $new_property_data['property_latitude'];
				$property_params['meta_input']['qodef_property_full_address_longitude'] = $new_property_data['property_longitude'];
				$property_params['meta_input']['qodef_property_simple_address_meta'] = $new_property_data['property_simple_address'];
				$property_params['meta_input']['qodef_property_zip_code_meta'] = $new_property_data['property_zip_code'];
				$property_params['meta_input']['qodef_property_address_country_meta'] = $new_property_data['property_country'];

				//get media values (needed to be in input hidden because of the repeater values) - if empty then media is removed
				$property_featured_image_db = $new_property_data['hidden_property_featured_image'];
				$property_image_gallery_db = $new_property_data['hidden_property_image_gallery'];
				$property_video_image_db = $new_property_data['hidden_property_video_image'];
				$property_attachment_db = $new_property_data['hidden_property_attachment'];
				$property_home_plan_db_images = $new_property_data['hidden_property_home_plan'];

				//remove media, it needs to be before adding media, in case user removed and then uploaded some media
				$featured_image_id = '';

				if ($property_featured_image_db == ''){
					$featured_image_id = 'removed';
				}

				if ($property_image_gallery_db == ''){
					$property_params['meta_input']['qodef_property_image_gallery'] = '';
				}

				if ($property_video_image_db == ''){
					$property_params['meta_input']['qodef_property_video_image_meta'] = '';
				}

				if ($property_attachment_db == ''){
					$property_params['meta_input']['qodef_property_attachment_meta'] = '';
				}
				
				// WordPress handles the upload (keys form $_FILES used).
				$property_image_gallery_array = array();
				$property_home_plan_image = array();

				$repeater_names = array('property_home_plan');

				foreach ($_FILES as $key => $value) {
					if (stripos($key,'_qodef_reg_')) {

						$lastLetterPos = stripos($key,'_qodef_reg_');
						$name = substr($key, 0, $lastLetterPos);

					} elseif (stripos($key,'_qodef_regarray_')) {

						$lastLetterPos = stripos($key,'_qodef_regarray_');
						$name = substr($key, 0, $lastLetterPos);
					}

					if ($value['name'] == 'qodef-dummy-file.txt'){
						$attachment_id = '';
						$attachment_url = '';

						//only repeater values needs to be sent even if empty
						if ( !in_array($name, $repeater_names) ){
							continue;
						}
					} else {
						$attachment_id = media_handle_upload( $key, 0 );
						$attachment_url = wp_get_attachment_url($attachment_id);
					}

					if ( is_wp_error( $attachment_id ) ) {
						qodef_re_ajax_status( 'error', esc_html__( 'Media not uploaded, please try again.', 'qode-real-estate' ) );
					} else {
						switch ($name) {
							case 'property_featured_image':
								$featured_image_id = $attachment_id;
								break;
							case 'property_image_gallery':
								$property_image_gallery_array[] = $attachment_id;
								break;
							case 'property_home_plan':
								$property_home_plan_image[] = $attachment_url;
								break;
							case 'property_video_image':
								$property_params['meta_input']['qodef_property_video_image_meta'] = $attachment_url;
								break;
							case 'property_attachment':
								$property_params['meta_input']['qodef_property_attachment_meta'] = $attachment_url;
								break;
						}
					}
				}

				//mix new with old values for repeater
				foreach ($property_home_plan_image as $key => $value) {
					if ($property_home_plan_image[$key] !== ''){
						$property_home_plan_db_images[$key] = $property_home_plan_image[$key];
					}
					if (!isset($property_home_plan_db_images[$key])){
						$property_home_plan_db_images[$key] = $property_home_plan_image[$key];
					}
				}

				//merge options for repeater that have image

				//merge home plan
				$home_plan_options = $new_property_data['property_home_plan'];
				$merged_home_plan_options = array();

				foreach ($home_plan_options as $key => $home_plan_row) {
					$home_plan_row['image'] = $property_home_plan_db_images[$key];
					$merged_home_plan_options[] = $home_plan_row;
				}

				$property_params['meta_input']['qodef_multi_units_meta'] = $new_property_data['property_multi_unit'];
				$property_params['meta_input']['qodef_home_plans_meta'] = $merged_home_plan_options;

				//add multiple images to single qodef_property_image_gallery field
				if (is_array($property_image_gallery_array) && count($property_image_gallery_array)) {
					$property_params['meta_input']['qodef_property_image_gallery'] = implode(',', $property_image_gallery_array);
				}

				$video_service = $new_property_data['property_video_type'];
				$property_params['meta_input']['qodef_property_video_type_meta'] = $video_service;

				if ($video_service == 'social_networks') {
					$property_params['meta_input']['qodef_property_video_link_meta'] = $new_property_data['property_video_link'];
				} else {
					$property_params['meta_input']['qodef_property_video_custom_meta'] = $new_property_data['property_video_link'];
				}

				$property_params['meta_input']['qodef_property_virtual_tour_meta'] = $new_property_data['property_virtual_tour'];


				//update meta fields
				foreach ($property_params['meta_input'] as $key => $value) {
					update_post_meta($property_db_id, $key, $value);
				}

				//update terms
				foreach ($property_params['tax_input'] as $key => $value) {
					wp_set_object_terms($property_db_id, $value, $key);
				}

				//update featured image
				if ($featured_image_id !== '') {

					if ($featured_image_id == 'removed') {
						delete_post_thumbnail($property_db_id);
					} else {
						set_post_thumbnail($property_db_id, $featured_image_id);
					}
				}

				$this_property_args = array(
					'ID'           => $property_db_id,
					'post_title'   => $new_property_data['property_title'],
					'post_content' => $new_property_data['description'],
				);



				// Update the property into the database
				$property_id_success = wp_update_post($this_property_args);
				if ( ! is_wp_error( $property_id_success ) ) {
					qodef_re_ajax_status( 'success', esc_html__( 'Property successfully edited.', 'qode-real-estate' ), NULL, $dashboard_url );
				} else {
					qodef_re_ajax_status( 'error', esc_html__( 'Error.', 'qode-real-estate' ) );
				}				

			} else {
				qodef_re_ajax_status( 'error', esc_html__( 'Error.', 'qode-real-estate' ) );
			}
		}
	}

	add_action( 'wp_ajax_qodef_re_edit_property', 'qodef_re_edit_property' );
}

if (!function_exists('qodef_re_delete_property')) {
	function qodef_re_delete_property(){
		if ( empty( $_POST ) || ! isset( $_POST ) ) {
			qodef_re_ajax_status( 'error', esc_html__( 'All fields are empty', 'qode-real-estate' ) );
		} else {
			$user = wp_get_current_user();

			//Check if role in approved roles
			if ( qodef_re_approved_user_roles($user->roles ) ) {
				$deleted = wp_delete_post($_POST['property_id']);
				if ($deleted){
					qodef_re_ajax_status( 'success', esc_html__( 'Property deleted.', 'qode-real-estate' ) );
				}
			}
		}
	}

	add_action( 'wp_ajax_qodef_re_delete_property', 'qodef_re_delete_property' );
}

if (!function_exists('qodef_re_get_add_property_params')) {
	function qodef_re_get_add_property_params(){

		$add_property_params = array();

		$package_necessary = bridge_qode_options()->getOptionValue('enable_packages_necessity');

		if ($package_necessary == 'no') {
			//if package is not necessary, featured items cannot be set by user, therefore is 0
			$add_property_params['number_of_featured'] = 0;

        } else {
            $package_key = qodef_re_get_user_current_package();

            $number_of_featured = 0;
            if($package_key !== false) {
                $package_info = qodef_re_get_package_info($package_key);
                $number_of_featured = $package_info['featured_items_remaining'];
            }

            $add_property_params['number_of_featured'] = $number_of_featured;
        }

		return $add_property_params;
	}
}

if (!function_exists('qodef_re_approved_user_roles')) {
	function qodef_re_approved_user_roles($user_roles){
		$roles = array();
		$approved_roles = apply_filters( 'qodef_real_estate_role_property_filter', $roles);
		$approved = false;

		foreach ($approved_roles as $approved_role) {
			if (in_array($approved_role, $user_roles)){
				$approved = true;
				continue;
			}
		}

		return $approved;
	}
}

if (!function_exists('qodef_re_property_addition_enabled')) {

	function qodef_re_property_addition_enabled(){
		$enabled = false;
		$package_necessary = bridge_qode_options()->getOptionValue('enable_packages_necessity');

		if ($package_necessary == 'no'){
			$enabled = true;
		} else {
			$enabled = qodef_re_get_user_current_package();
		}

		return $enabled;
	}
}