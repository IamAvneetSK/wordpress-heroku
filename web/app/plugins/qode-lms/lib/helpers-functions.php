<?php

if ( ! function_exists( 'qode_lms_get_module_template_part' ) ) {
	/**
	 * Loads module template part.
	 *
	 * @param string $template name of the template to load
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 *
	 * @return html
	 */
	function qode_lms_get_module_template_part( $template, $slug = '', $params = array() ) {
		//HTML Content from template
		$html          = '';
		$template_path = QODE_LMS_ABS_PATH;
		
		$temp = $template_path . '/' . $template;
		
		if ( is_array( $params ) && count( $params ) ) {
			extract( $params );
		}
		
		$template = '';
		
		if ( ! empty( $temp ) ) {
			if ( ! empty( $slug ) ) {
				$template = "{$temp}-{$slug}.php";
				
				if ( ! file_exists( $template ) ) {
					$template = $temp . '.php';
				}
			} else {
				$template = $temp . '.php';
			}
		}
		
		if ( ! empty( $template ) ) {
			ob_start();
			include( $template );
			$html = ob_get_clean();
		}
		
		return $html;
	}
}

if ( ! function_exists( 'qode_lms_get_cpt_shortcode_module_template_part' ) ) {
	/**
	 * Loads module template part.
	 *
	 * @param string $shortcode name of the shortcode folder
	 * @param string $template name of the template to load
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 *
	 * @return html
	 */
	function qode_lms_get_cpt_shortcode_module_template_part( $shortcode, $template, $slug = '', $params = array(), $additional_params = array() ) {
		//HTML Content from template
		$html          = '';
		$template_path = QODE_LMS_CPT_PATH . '/' . $shortcode . '/shortcodes/templates';
		
		$temp = $template_path . '/' . $template;
		if ( is_array( $params ) && count( $params ) ) {
			extract( $params );
		}
		
		if ( is_array( $additional_params ) && count( $additional_params ) ) {
			extract( $additional_params );
		}
		
		$template = '';
		
		if ( ! empty( $temp ) ) {
			if ( ! empty( $slug ) ) {
				$template = "{$temp}-{$slug}.php";
				
				if ( ! file_exists( $template ) ) {
					$template = $temp . '.php';
				}
			} else {
				$template = $temp . '.php';
			}
		}
		
		if ( $template ) {
			ob_start();
			include( $template );
			$html = ob_get_clean();
		}
		
		return $html;
	}
}

if ( ! function_exists( 'qode_lms_cpt_single_module_template_part' ) ) {
	/**
	 * Loads module template part.
	 *
	 * @param string $cpt_name name of the cpt folder
	 * @param string $template name of the template to load
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 *
	 * @return html
	 */
	function qode_lms_cpt_single_module_template_part( $template, $cpt_name, $slug = '', $params = array() ) {
		//HTML Content from template
		$html          = '';
		$template_path = QODE_LMS_CPT_PATH . '/' . $cpt_name;
		
		$temp = $template_path . '/' . $template;
		
		if ( is_array( $params ) && count( $params ) ) {
			extract( $params );
		}
		
		$template = '';
		
		if ( ! empty( $temp ) ) {
			if ( ! empty( $slug ) ) {
				$template = "{$temp}-{$slug}.php";
				
				if ( ! file_exists( $template ) ) {
					$template = $temp . '.php';
				}
			} else {
				$template = $temp . '.php';
			}
		}
		
		if ( ! empty( $template ) ) {
			ob_start();
			include( $template );
			$html = ob_get_clean();
		}
		
		return $html;
	}
}

if ( ! function_exists( 'qode_lms_get_cpt_single_module_template_part' ) ) {
	/**
	 * Loads module template part.
	 *
	 * @param string $cpt_name name of the cpt folder
	 * @param string $template name of the template to load
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 *
	 * @return html
	 */
	function qode_lms_get_cpt_single_module_template_part( $template, $cpt_name, $slug = '', $params = array() ) {
		//HTML Content from template
		$html          = '';
		$template_path = QODE_LMS_CPT_PATH . '/' . $cpt_name;
		
		$temp = $template_path . '/' . $template;
		
		if ( is_array( $params ) && count( $params ) ) {
			extract( $params );
		}
		
		$template = '';
		
		if ( ! empty( $temp ) ) {
			if ( ! empty( $slug ) ) {
				$template = "{$temp}-{$slug}.php";
				
				if ( ! file_exists( $template ) ) {
					$template = $temp . '.php';
				}
			} else {
				$template = $temp . '.php';
			}
		}
		
		if ( ! empty( $template ) ) {
			ob_start();
			include( $template );
			$html = ob_get_clean();
		}
		
		print $html;
	}
}

if ( ! function_exists( 'qode_lms_get_shortcode_module_template_part' ) ) {
	/**
	 * Loads module template part.
	 *
	 * @param string $template name of the template to load
	 * @param string $shortcode name of the shortcode folder
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 *
	 * @return html
	 */
	function qode_lms_get_shortcode_module_template_part( $template, $shortcode, $slug = '', $params = array() ) {
		//HTML Content from template
		$html          = '';
		$template_path = QODE_LMS_SHORTCODES_PATH . '/' . $shortcode;
		
		$temp = $template_path . '/' . $template;
		
		if ( is_array( $params ) && count( $params ) ) {
			extract( $params );
		}
		
		$template = '';
		
		if ( ! empty( $temp ) ) {
			if ( ! empty( $slug ) ) {
				$template = "{$temp}-{$slug}.php";
				
				if ( ! file_exists( $template ) ) {
					$template = $temp . '.php';
				}
			} else {
				$template = $temp . '.php';
			}
		}
		
		if ( $template ) {
			ob_start();
			include( $template );
			$html = ob_get_clean();
		}
		
		return $html;
	}
}

if ( ! function_exists( 'qode_lms_ajax_status' ) ) {
	/**
	 * Function that return status from ajax functions
	 */
	function qode_lms_ajax_status( $status, $message, $data = null ) {
		$response = array(
			'status'  => $status,
			'message' => $message,
			'data'    => $data
		);
		
		$output = json_encode( $response );
		
		exit( $output );
	}
}

if ( ! function_exists( 'qode_lms_array_equal' ) ) {
	//is Qode LMS are arrays equal
	function qode_lms_array_equal( $a, $b ) {
		return (
			is_array( $a ) && is_array( $b ) &&
			count( $a ) == count( $b ) &&
			array_diff( $a, $b ) === array_diff( $b, $a )
		);
	}
}

if ( ! function_exists( 'qode_lms_qode_woocommerce_integration_installed' ) ) {
	//is Qode Woocommerce Integration?
	function qode_lms_qode_woocommerce_integration_installed() {
		return defined( 'QODE_WOOCOMMERCE_CHECKOUT_INTEGRATION' );
	}
}

if ( ! function_exists( 'qode_lms_update_order_status' ) ) {
	function qode_lms_update_order_status( $order_id, $old_status, $new_status ) {
		$items_list         = apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' );
		$items              = wc_get_order( $order_id )->get_items( $items_list );
		$user_status_values = get_user_meta( get_current_user_id(), 'qode_user_course_status', true );
		
		if ( $new_status == 'completed' ) {
			foreach ( $items as $item ) {
				$data       = $item->get_data();
				$product_id = $data['product_id'];
				if ( $product_id !== - 1 ) {
					if ( ! empty( $user_status_values ) ) {
						$user_status_values[ $product_id ] = array(
							'status'          => 'enrolled',
							'items_completed' => array(),
							'retakes'         => 0
						);
					} else {
						$user_status_values = array(
							$product_id => array(
								'status'          => 'enrolled',
								'items_completed' => array(),
								'retakes'         => 0
							)
						);
					}
				}
			}
		} else {
			if ( ! empty( $user_status_values ) ) {
				foreach ( $items as $item ) {
					$data       = $item->get_data();
					$product_id = $data['product_id'];
					unset( $product_id );
				}
			}
		}
		
		update_user_meta( get_current_user_id(), 'qode_user_course_status', $user_status_values );
	}
	
	add_action( 'woocommerce_order_status_changed', 'qode_lms_update_order_status', 10, 3 );
}