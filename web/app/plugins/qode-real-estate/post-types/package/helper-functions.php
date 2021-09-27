<?php
//Register meta boxes
if(!function_exists('qodef_re_package_meta_box_functions')) {
	function qodef_re_package_meta_box_functions($post_types) {
		$post_types[] = 'package';
		
		return $post_types;
	}
	
	add_filter('bridge_qode_filter_meta_box_post_types_save', 'qodef_re_package_meta_box_functions');
	add_filter('bridge_qode_filter_meta_box_post_types_remove', 'qodef_re_package_meta_box_functions');
}

//Register post type and required scripts/styles
if(!function_exists('qodef_re_register_package_cpt')) {
    function qodef_re_register_package_cpt($cpt_class_name) {
        $cpt_class = array(
            'QodefRE\CPT\Package\PackageRegister'
        );

        $cpt_class_name = array_merge($cpt_class_name, $cpt_class);

        return $cpt_class_name;
    }

    add_filter('qodef_re_filter_register_custom_post_types', 'qodef_re_register_package_cpt');
}

if ( ! function_exists( 'qodef_re_package_enqueue_meta_box_styles' ) ) {
    function qodef_re_package_enqueue_meta_box_styles() {
        global $post;

        if ($post->post_type == 'package') {
            wp_enqueue_style('qodef-jquery-ui', get_template_directory_uri() . '/framework/admin/assets/css/jquery-ui/jquery-ui.css');
        }
    }

    add_action('bridge_qode_enqueue_meta_box_styles', 'qodef_re_package_enqueue_meta_box_styles');
}

if(!function_exists('qodef_re_users_packages_in_menu')) {
    function qodef_re_users_packages_in_menu() {
        add_submenu_page(
            'edit.php?post_type=package',
            esc_html__('Users Packages', 'qode-real-estate'),
            esc_html__('Users Packages', 'qode-real-estate'),
            'administrator',
            'users_packages',
            'qodef_re_users_packages_admin_panel'
        );
    }

    add_action( 'admin_menu', 'qodef_re_users_packages_in_menu' );
}

//Add admin section
if(!function_exists('qodef_re_users_packages_admin_panel')) {
    function qodef_re_users_packages_admin_panel() {
        $params = array();
        $orders = wc_get_orders(
            array(
                'limit' => '-1'
            )
        );
        $users_orders = array();
        if ( ! empty( $orders ) ) {
            foreach ( $orders as $order ) {
                $items = $order->get_items();
                foreach ( $items as $item ) {
                    if ( is_a( $item, 'WC_Order_Item_Package' ) ) {
                        $package_id = $item->get_product_id();
                        $order_params = array();
                        $order_params['order_id'] = $order->get_id();
                        $order_params['order_package_name'] = get_the_title($package_id);
                        $order_params['order_date'] = gmdate( 'Y-m-d H:i:s', $order->get_date_created()->getOffsetTimestamp() );
                        $order_params['order_price'] = get_post_meta($package_id, 'qodef_package_price_meta', true);
                        $order_params['order_buyer_name'] = $order->get_billing_last_name() . ' ' . $order->get_billing_first_name();
                        $order_params['order_buyer_email'] = $order->get_billing_email();
                        $order_params['order_payment_method'] = $order->get_payment_method_title();
                        $order_params['order_status'] = wc_get_order_status_name($order->get_status());
                        $order_params['order_link'] = admin_url('post.php?post=' . $order->get_id() . '&action=edit');
                        $users_orders[] = $order_params;
                    }
                }
            }
        }
        $params['users_orders'] = $users_orders;
        qodef_re_get_cpt_single_module_template_part( 'admin/templates/users-packages', 'package', '', $params );
    }
}

// Load package shortcodes
if(!function_exists('qodef_re_include_package_shortcodes_file')) {
    /**
     * Loades all shortcodes by going through all folders that are placed directly in shortcodes folder
     */
    function qodef_re_include_package_shortcodes_file() {
        foreach(glob(QODE_RE_CPT_PATH.'/package/shortcodes/*/load.php') as $shortcode_load) {
            include_once $shortcode_load;
        }
    }

    add_action('qodef_re_action_include_shortcodes_file', 'qodef_re_include_package_shortcodes_file');
}

//Package payment functions
if ( ! function_exists( 'qodef_re_include_package_payment_class' ) ) {
    /**
     * Function that includes product course
     */
    function qodef_re_include_package_payment_class() {
        if ( qodef_re_qodef_woocommerce_integration_installed() && qodef_re_is_woocommerce_installed() ) {
            require_once 'payment/class-wc-product-package.php';
            require_once 'payment/class-wc-order-item-package.php';
            require_once 'payment/class-wc-order-item-package-store.php';
            require_once 'payment/class-wc-package-data-store-cpt.php';
        }
    }

    add_action( 'wp_loaded', 'qodef_re_include_package_payment_class' );
}

if ( ! function_exists( 'qodef_re_add_package_to_post_types_payment' ) ) {
    /**
     * Function that add custom post type to list
     */
    function qodef_re_add_package_to_post_types_payment( $post_types ) {
        if ( qodef_re_qodef_woocommerce_integration_installed() ) {
            $post_types[] = 'package';
        }

        return $post_types;
    }

    add_filter( 'qode_woocommerce_checkout_integration_post_types', 'qodef_re_add_package_to_post_types_payment', 100 );
}

if ( ! function_exists( 'qodef_re_package_add_to_cart_action' ) ) {
    function qodef_re_package_add_to_cart_action( $add_to_cart_url ) {
        $product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_REQUEST['add-to-cart'] ) );
        $product           = new WC_Product_Package( $product_id );
        $url               = $product->add_to_cart_url();
        $quantity          = empty( $_REQUEST['quantity'] ) ? 1 : wc_stock_amount( $_REQUEST['quantity'] );
        $passed_validation = true;

        if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity ) !== false ) {
            wc_add_to_cart_message( array( $product_id => $quantity ), true );
            // If has custom URL redirect there
            if ( $url ) {
                wp_safe_redirect( $url );
                exit;
            } elseif ( get_option( 'woocommerce_cart_redirect_after_add' ) === 'yes' ) {
                wp_safe_redirect( wc_get_cart_url() );
                exit;
            }
        }
    }

    add_action( 'woocommerce_add_to_cart_handler_package', 'qodef_re_package_add_to_cart_action', 10, 1 );
}

if ( ! function_exists( 'qodef_re_get_pricing_packages_page' ) ) {
    function qodef_re_get_pricing_packages_page() {
        $pp_shop_page_id = bridge_qode_options()->getOptionValue( 'packages_default_page' );

        $url = esc_url( get_the_permalink( $pp_shop_page_id ) );

        return $url;
    }

    add_filter( 'woocommerce_return_to_shop_redirect', 'qodef_re_get_pricing_packages_page', 10 );
}

if ( ! function_exists( 'qodef_re_set_notice_for_pricing_packages_page' ) ) {
    function qodef_re_set_notice_for_pricing_packages_page() {
        $pricing_page_id = bridge_qode_options()->getOptionValue( 'packages_default_page' );
        if(is_page($pricing_page_id)) {
            add_action( 'bridge_qode_after_container_inner_open', 'wc_print_notices', 10 );
        }
    }

    add_action('wp', 'qodef_re_set_notice_for_pricing_packages_page');
}

if ( ! function_exists( 'qodef_re_set_packages_page_body_class' ) ) {
    function qodef_re_set_packages_page_body_class( $classes ) {
        $pricing_page_id = bridge_qode_options()->getOptionValue( 'packages_default_page' );
        if(is_page($pricing_page_id)) {
            $classes[] = 'qodef-pricing-package-page';
        }

        return $classes;
    }

    add_filter( 'body_class', 'qodef_re_set_packages_page_body_class' );
}

if(!function_exists('qodef_re_woocommerce_auto_complete_order')) {
    function qodef_re_woocommerce_auto_complete_order( $order_id ) {
        $qodef_payment_autocomplete = bridge_qode_options()->getOptionValue( 'enable_payment_autocomplete' ) == 'yes' ? true : false;
        if($qodef_payment_autocomplete) {
            if ( ! $order_id ) {
                return;
            }

            $order = wc_get_order( $order_id );
            $order->update_status( 'completed' );
        }
    }

    add_action('woocommerce_thankyou', 'qodef_re_woocommerce_auto_complete_order');
}

if(!function_exists('qodef_re_set_user_meta_packages_list')) {
    function qodef_re_set_user_meta_packages_list($order_id, $status_from, $status_to, $order) {
        if($status_to === 'completed') {
            $items = $order->get_items();
            $user_packages = get_user_meta($order->get_customer_id(), 'qodef_user_packages', true);
            $package_exists = false;
            if(!isset($user_packages) || empty($user_packages)) {
                $user_packages = array();
                $index = 0;
            } else {
                end($user_packages);         // move the internal pointer to the end of the array
                $index = key($user_packages);
                reset($user_packages);
                foreach ($user_packages as $user_package) {
                    if($user_package['order_id'] == $order_id) {
                        $package_exists = true;
                        break;
                    }
                }
            }

            if(!$package_exists) {
                foreach ($items as $item) {
                    if (is_a($item, 'WC_Order_Item_Package')) {
                        $index++;
                        $package_id = $item->get_product_id();
                        $package = array();
                        $package['post_type_id'] = $package_id;
                        $package['order_id'] = $order_id;
                        $user_packages[$index] = $package;
                    }
                }

                update_user_meta($order->get_customer_id(), 'qodef_user_packages', $user_packages);
            }
        }
    }

    add_action('woocommerce_order_status_changed', 'qodef_re_set_user_meta_packages_list', 10, 4);
}

if(!function_exists('qodef_re_get_user_packages_list')) {
    function qodef_re_get_user_packages_list() {
        $user_packages = get_user_meta(get_current_user_id(), 'qodef_user_packages', true);

        return $user_packages;
    }
}

if(!function_exists('qodef_re_get_user_package_item')) {
    function qodef_re_get_user_package_item($package_id) {
        $user_packages = get_user_meta(get_current_user_id(), 'qodef_user_packages', true);
        if(isset($user_packages) && !empty($user_packages)) {
            $package = $user_packages[$package_id];
            return $package;
        }
        return false;
    }
}

if(!function_exists('qodef_re_get_user_current_package')) {
    function qodef_re_get_user_current_package() {
        $user_packages = qodef_re_get_user_packages_list();
        $user_posts = count_user_posts(get_current_user_id(), 'property');
        $items = 0;
        if ( is_array($user_packages) && count($user_packages) ) {
	        foreach($user_packages as $key => $package) {
	            if(!qodef_re_get_package_expired($package)) {
	                $package_id = $package['post_type_id'];
	                $package_unlimited = get_post_meta($package_id, 'qodef_package_unlimited_listings_meta', true);
	                if ($package_unlimited === 'yes') {
	                    return $key;
	                }
	                $available_items = get_post_meta($package_id, 'qodef_package_listings_included_meta', true);
	                $items += $available_items;
	                if ($items > $user_posts) {
	                    return $key;
	                }
	            }
	        }
	    }

        return false;
    }
}

//Post type helper functions
if(!function_exists('qodef_re_calculate_package_price')) {
    function qodef_re_calculate_package_price($id = '') {
        $id = $id !== '' ? $id : get_the_ID();
        $price = get_post_meta($id, 'qodef_package_price_meta', true);

        return $price;
    }
}

if(!function_exists('qodef_re_get_package_expiration_date')) {
    function qodef_re_get_package_expiration_date($package) {
        $package_id = $package['post_type_id'];
        $order_id = $package['order_id'];
        $post_time = get_post_time('U', true, $order_id);
        $package_duration = get_post_meta($package_id, 'qodef_package_duration_meta', true);
        $package_duration = !isset($package_duration) || empty($package_duration) ? 12 : (int) $package_duration;
        $expiration_time = strtotime('+' . $package_duration . 'month', $post_time);

        return $expiration_time;
    }
}

if(!function_exists('qodef_re_get_package_expired')) {
    function qodef_re_get_package_expired($package) {
        $current_time = current_time( 'timestamp', 0 );
        $expiration_time = qodef_re_get_package_expiration_date($package);

        return $expiration_time < $current_time;
    }
}

if(!function_exists('qodef_re_get_package_status')) {
    function qodef_re_get_package_status($package) {
//        $package_item = qodef_re_get_user_package_item($package);
        $package_id = $package['post_type_id'];
        $package_unlimited = get_post_meta($package_id, 'qodef_package_unlimited_listings_meta', true);
        if ($package_unlimited === 'yes') {
            if(qodef_re_get_package_expired($package)) {
                return esc_html__('Expired', 'qode-real-estate');
            } else {
                return esc_html__('Active', 'qode-real-estate');
            }
        } else {
            $total_items = get_post_meta($package_id, 'qodef_package_listings_included_meta', true);
            $used_items = qodef_re_get_properties_with_package($package);
            $items_remaining = $total_items - $used_items;
            if ($items_remaining <= 0) {
                return esc_html__('All used', 'qode-real-estate');
            } else {
                if(qodef_re_get_package_expired($package)) {
                    return esc_html__('Expired', 'qode-real-estate');
                } else {
                    return esc_html__('Active', 'qode-real-estate');
                }
            }
        }
    }
}

if(!function_exists(('qodef_re_get_properties_with_package'))) {
    function qodef_re_get_properties_with_package($package, $featured_only = false) {
        $meta_query = array();

        $user = wp_get_current_user();

        $query_array = array(
        	'author'		 => $user->ID,
            'post_status'    => array('publish','draft'),
            'post_type'      => 'property'
        );

        $meta_query[] = array(
            'key' => 'qodef_property_package_meta',
            'value' => $package,
            'type' => 'numeric'
        );

        if($featured_only) {
            $meta_query[] = array(
                'key' => 'qodef_property_is_featured_meta',
                'value' => 'yes'
            );
        }

        $query_array['meta_query'] = $meta_query;

        $query_results = new \WP_Query( $query_array );
        $number_of_items = $query_results->post_count;

        return $number_of_items;
    }
}

if(!function_exists('qodef_re_get_package_info')) {
    function qodef_re_get_package_info($package) {
        $package_info = array();
//        $package_item = qodef_re_get_user_package_item($package);
        $package_id = $package['post_type_id'];
        //Get name
        $package_name = get_the_title($package_id);
        $package_info['package_name'] = $package_name;

        //Get items remaining
        $package_unlimited = get_post_meta($package_id, 'qodef_package_unlimited_listings_meta', true);
        if ($package_unlimited === 'yes') {
            $items_included = 'unlimited';
            $items_remaining = 'unlimited';
        } else {
            $total_items = get_post_meta($package_id, 'qodef_package_listings_included_meta', true);
            $items_included = $total_items;
            $used_items = qodef_re_get_properties_with_package($package);
            $items_remaining = $total_items - $used_items;
        }
        $package_info['items_included'] = $items_included;
        $package_info['items_remaining'] = $items_remaining;

        //Get featured included
        $featured_items_included = get_post_meta($package_id, 'qodef_package_featured_listings_included_meta', true);
        $package_info['featured_items_included'] = $featured_items_included;

        //Get featured remaining
        $used_featured_items = qodef_re_get_properties_with_package($package, true);
        $featured_items_remaining = $featured_items_included - $used_featured_items;
        $package_info['featured_items_remaining'] = $featured_items_remaining;

        //Get expiration time
        $package_info['expiration_date'] = qodef_re_get_package_expiration_date($package);

        return $package_info;
    }
}

//Post type template functions
if ( ! function_exists( 'qodef_re_get_buy_form' ) ) {
    function qodef_re_get_package_buy_form() {

        if ( qodef_re_is_woocommerce_installed() && qodef_re_qodef_woocommerce_integration_installed()) {
            qode_woocomerce_checkout_integration_get_buy_form( array(), array( 'input_text' => esc_html__( 'Purchase', 'qode-real-estate' ) ) );
        }
    }
}