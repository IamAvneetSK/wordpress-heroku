<?php
if ( ! function_exists( 'qodef_re_get_module_template_part' ) ) {
    /**
     * Loads module template part.
     *
     * @param string $template name of the template to load
     * @param string $slug
     * @param array $params array of parameters to pass to template
     *
     * @return string
     */
    function qodef_re_get_module_template_part( $template, $slug = '', $params = array() ) {
        //HTML Content from template
        $html          = '';
        $template_path = QODE_RE_MODULE_PATH;

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

if(!function_exists('qodef_re_get_cpt_shortcode_module_template_part')) {
	/**
	 * Loads module template part.
	 *
	 * @param string $post_type name of the post type
	 * @param string $shortcode name of the shortcode folder
	 * @param string $template name of the template to load
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 * @param array $additional_params array of additional parameters to pass to template
	 *
	 * @return html
	 */
	function qodef_re_get_cpt_shortcode_module_template_part($post_type, $shortcode, $template, $slug = '', $params = array(), $additional_params = array()) {
		
		//HTML Content from template
		$html = '';
		$template_path = QODE_RE_CPT_PATH.'/'.$post_type.'/shortcodes/'.$shortcode.'/'.'templates';
		
		$temp = $template_path.'/'.$template;
		if(is_array($params) && count($params)) {
			extract($params);
		}
		
		if(is_array($additional_params) && count($additional_params)) {
			extract($additional_params);
		}
		
		$template = '';
		
		if (!empty($temp)) {
			if (!empty($slug)) {
				$template = "{$temp}-{$slug}.php";
				
				if(!file_exists($template)) {
					$template = $temp.'.php';
				}
			} else {
				$template = $temp.'.php';
			}
		}
		
		if ($template) {
			ob_start();
			include($template);
			$html = ob_get_clean();
		}
		
		return $html;
	}
}

if ( ! function_exists( 'qodef_re_cpt_single_module_template_part' ) ) {
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
    function qodef_re_cpt_single_module_template_part( $template, $cpt_name, $slug = '', $params = array() ) {
        //HTML Content from template
        $html          = '';
        $template_path = QODE_RE_CPT_PATH . '/' . $cpt_name;

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

if(!function_exists('qodef_re_get_cpt_single_module_template_part')) {
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
	function qodef_re_get_cpt_single_module_template_part($template, $cpt_name, $slug = '', $params = array()) {
		
		//HTML Content from template
		$html = '';
		$template_path = QODE_RE_CPT_PATH.'/'.$cpt_name;
		
		$temp = $template_path.'/'.$template;
		
		if(is_array($params) && count($params)) {
			extract($params);
		}
		
		$template = '';
		
		if (!empty($temp)) {
			if (!empty($slug)) {
				$template = "{$temp}-{$slug}.php";
				
				if(!file_exists($template)) {
					$template = $temp.'.php';
				}
			} else {
				$template = $temp.'.php';
			}
		}
		
		if (!empty($template)) {
			ob_start();
			include($template);
			$html = ob_get_clean();
		}
		
		print bridge_qode_get_module_part($html);
	}
}

if(!function_exists('qodef_re_get_shortcode_module_template_part')) {
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
	function qodef_re_get_shortcode_module_template_part($template, $shortcode, $slug = '', $params = array()) {
		
		//HTML Content from template
		$html          = '';
		$template_path = QODE_RE_SHORTCODES_PATH.'/'.$shortcode;
		
		$temp = $template_path.'/'.$template;
		
		if(is_array($params) && count($params)) {
			extract($params);
		}
		
		$template = '';
		
		if (!empty($temp)) {
			if (!empty($slug)) {
				$template = "{$temp}-{$slug}.php";
				
				if(!file_exists($template)) {
					$template = $temp.'.php';
				}
			} else {
				$template = $temp.'.php';
			}
		}
		
		if ($template) {
			ob_start();
			include($template);
			$html = ob_get_clean();
		}
		
		return $html;
	}
}

if( ! function_exists( 'qodef_re_ajax_status' ) ) {
	/**
	 * Function that return status from ajax functions
	 */
	function qodef_re_ajax_status($status, $message, $data = NULL, $redirect = '') {
		$response = array (
			'status' => $status,
			'message' => $message,
			'data' => $data,
			'redirect' => $redirect
		);

		$output = json_encode($response);

		exit($output);
	}
}

if ( ! function_exists( 'qodef_re_get_countries_list' ) ) {
    function qodef_re_get_countries_list() {
        
        $countries = array(
            'AF' => esc_html__( 'Afghanistan', 'qode-real-estate' ),
            'AX' => esc_html__( '&#197;land Islands', 'qode-real-estate' ),
            'AL' => esc_html__( 'Albania', 'qode-real-estate' ),
            'DZ' => esc_html__( 'Algeria', 'qode-real-estate' ),
            'AS' => esc_html__( 'American Samoa', 'qode-real-estate' ),
            'AD' => esc_html__( 'Andorra', 'qode-real-estate' ),
            'AO' => esc_html__( 'Angola', 'qode-real-estate' ),
            'AI' => esc_html__( 'Anguilla', 'qode-real-estate' ),
            'AQ' => esc_html__( 'Antarctica', 'qode-real-estate' ),
            'AG' => esc_html__( 'Antigua and Barbuda', 'qode-real-estate' ),
            'AR' => esc_html__( 'Argentina', 'qode-real-estate' ),
            'AM' => esc_html__( 'Armenia', 'qode-real-estate' ),
            'AW' => esc_html__( 'Aruba', 'qode-real-estate' ),
            'AU' => esc_html__( 'Australia', 'qode-real-estate' ),
            'AT' => esc_html__( 'Austria', 'qode-real-estate' ),
            'AZ' => esc_html__( 'Azerbaijan', 'qode-real-estate' ),
            'BS' => esc_html__( 'Bahamas', 'qode-real-estate' ),
            'BH' => esc_html__( 'Bahrain', 'qode-real-estate' ),
            'BD' => esc_html__( 'Bangladesh', 'qode-real-estate' ),
            'BB' => esc_html__( 'Barbados', 'qode-real-estate' ),
            'BY' => esc_html__( 'Belarus', 'qode-real-estate' ),
            'BE' => esc_html__( 'Belgium', 'qode-real-estate' ),
            'PW' => esc_html__( 'Belau', 'qode-real-estate' ),
            'BZ' => esc_html__( 'Belize', 'qode-real-estate' ),
            'BJ' => esc_html__( 'Benin', 'qode-real-estate' ),
            'BM' => esc_html__( 'Bermuda', 'qode-real-estate' ),
            'BT' => esc_html__( 'Bhutan', 'qode-real-estate' ),
            'BO' => esc_html__( 'Bolivia', 'qode-real-estate' ),
            'BQ' => esc_html__( 'Bonaire, Saint Eustatius and Saba', 'qode-real-estate' ),
            'BA' => esc_html__( 'Bosnia and Herzegovina', 'qode-real-estate' ),
            'BW' => esc_html__( 'Botswana', 'qode-real-estate' ),
            'BV' => esc_html__( 'Bouvet Island', 'qode-real-estate' ),
            'BR' => esc_html__( 'Brazil', 'qode-real-estate' ),
            'IO' => esc_html__( 'British Indian Ocean Territory', 'qode-real-estate' ),
            'VG' => esc_html__( 'British Virgin Islands', 'qode-real-estate' ),
            'BN' => esc_html__( 'Brunei', 'qode-real-estate' ),
            'BG' => esc_html__( 'Bulgaria', 'qode-real-estate' ),
            'BF' => esc_html__( 'Burkina Faso', 'qode-real-estate' ),
            'BI' => esc_html__( 'Burundi', 'qode-real-estate' ),
            'KH' => esc_html__( 'Cambodia', 'qode-real-estate' ),
            'CM' => esc_html__( 'Cameroon', 'qode-real-estate' ),
            'CA' => esc_html__( 'Canada', 'qode-real-estate' ),
            'CV' => esc_html__( 'Cape Verde', 'qode-real-estate' ),
            'KY' => esc_html__( 'Cayman Islands', 'qode-real-estate' ),
            'CF' => esc_html__( 'Central African Republic', 'qode-real-estate' ),
            'TD' => esc_html__( 'Chad', 'qode-real-estate' ),
            'CL' => esc_html__( 'Chile', 'qode-real-estate' ),
            'CN' => esc_html__( 'China', 'qode-real-estate' ),
            'CX' => esc_html__( 'Christmas Island', 'qode-real-estate' ),
            'CC' => esc_html__( 'Cocos (Keeling) Islands', 'qode-real-estate' ),
            'CO' => esc_html__( 'Colombia', 'qode-real-estate' ),
            'KM' => esc_html__( 'Comoros', 'qode-real-estate' ),
            'CG' => esc_html__( 'Congo (Brazzaville)', 'qode-real-estate' ),
            'CD' => esc_html__( 'Congo (Kinshasa)', 'qode-real-estate' ),
            'CK' => esc_html__( 'Cook Islands', 'qode-real-estate' ),
            'CR' => esc_html__( 'Costa Rica', 'qode-real-estate' ),
            'HR' => esc_html__( 'Croatia', 'qode-real-estate' ),
            'CU' => esc_html__( 'Cuba', 'qode-real-estate' ),
            'CW' => esc_html__( 'Cura&ccedil;ao', 'qode-real-estate' ),
            'CY' => esc_html__( 'Cyprus', 'qode-real-estate' ),
            'CZ' => esc_html__( 'Czech Republic', 'qode-real-estate' ),
            'DK' => esc_html__( 'Denmark', 'qode-real-estate' ),
            'DJ' => esc_html__( 'Djibouti', 'qode-real-estate' ),
            'DM' => esc_html__( 'Dominica', 'qode-real-estate' ),
            'DO' => esc_html__( 'Dominican Republic', 'qode-real-estate' ),
            'EC' => esc_html__( 'Ecuador', 'qode-real-estate' ),
            'EG' => esc_html__( 'Egypt', 'qode-real-estate' ),
            'SV' => esc_html__( 'El Salvador', 'qode-real-estate' ),
            'GQ' => esc_html__( 'Equatorial Guinea', 'qode-real-estate' ),
            'ER' => esc_html__( 'Eritrea', 'qode-real-estate' ),
            'EE' => esc_html__( 'Estonia', 'qode-real-estate' ),
            'ET' => esc_html__( 'Ethiopia', 'qode-real-estate' ),
            'FK' => esc_html__( 'Falkland Islands', 'qode-real-estate' ),
            'FO' => esc_html__( 'Faroe Islands', 'qode-real-estate' ),
            'FJ' => esc_html__( 'Fiji', 'qode-real-estate' ),
            'FI' => esc_html__( 'Finland', 'qode-real-estate' ),
            'FR' => esc_html__( 'France', 'qode-real-estate' ),
            'GF' => esc_html__( 'French Guiana', 'qode-real-estate' ),
            'PF' => esc_html__( 'French Polynesia', 'qode-real-estate' ),
            'TF' => esc_html__( 'French Southern Territories', 'qode-real-estate' ),
            'GA' => esc_html__( 'Gabon', 'qode-real-estate' ),
            'GM' => esc_html__( 'Gambia', 'qode-real-estate' ),
            'GE' => esc_html__( 'Georgia', 'qode-real-estate' ),
            'DE' => esc_html__( 'Germany', 'qode-real-estate' ),
            'GH' => esc_html__( 'Ghana', 'qode-real-estate' ),
            'GI' => esc_html__( 'Gibraltar', 'qode-real-estate' ),
            'GR' => esc_html__( 'Greece', 'qode-real-estate' ),
            'GL' => esc_html__( 'Greenland', 'qode-real-estate' ),
            'GD' => esc_html__( 'Grenada', 'qode-real-estate' ),
            'GP' => esc_html__( 'Guadeloupe', 'qode-real-estate' ),
            'GU' => esc_html__( 'Guam', 'qode-real-estate' ),
            'GT' => esc_html__( 'Guatemala', 'qode-real-estate' ),
            'GG' => esc_html__( 'Guernsey', 'qode-real-estate' ),
            'GN' => esc_html__( 'Guinea', 'qode-real-estate' ),
            'GW' => esc_html__( 'Guinea-Bissau', 'qode-real-estate' ),
            'GY' => esc_html__( 'Guyana', 'qode-real-estate' ),
            'HT' => esc_html__( 'Haiti', 'qode-real-estate' ),
            'HM' => esc_html__( 'Heard Island and McDonald Islands', 'qode-real-estate' ),
            'HN' => esc_html__( 'Honduras', 'qode-real-estate' ),
            'HK' => esc_html__( 'Hong Kong', 'qode-real-estate' ),
            'HU' => esc_html__( 'Hungary', 'qode-real-estate' ),
            'IS' => esc_html__( 'Iceland', 'qode-real-estate' ),
            'IN' => esc_html__( 'India', 'qode-real-estate' ),
            'ID' => esc_html__( 'Indonesia', 'qode-real-estate' ),
            'IR' => esc_html__( 'Iran', 'qode-real-estate' ),
            'IQ' => esc_html__( 'Iraq', 'qode-real-estate' ),
            'IE' => esc_html__( 'Ireland', 'qode-real-estate' ),
            'IM' => esc_html__( 'Isle of Man', 'qode-real-estate' ),
            'IL' => esc_html__( 'Israel', 'qode-real-estate' ),
            'IT' => esc_html__( 'Italy', 'qode-real-estate' ),
            'CI' => esc_html__( 'Ivory Coast', 'qode-real-estate' ),
            'JM' => esc_html__( 'Jamaica', 'qode-real-estate' ),
            'JP' => esc_html__( 'Japan', 'qode-real-estate' ),
            'JE' => esc_html__( 'Jersey', 'qode-real-estate' ),
            'JO' => esc_html__( 'Jordan', 'qode-real-estate' ),
            'KZ' => esc_html__( 'Kazakhstan', 'qode-real-estate' ),
            'KE' => esc_html__( 'Kenya', 'qode-real-estate' ),
            'KI' => esc_html__( 'Kiribati', 'qode-real-estate' ),
            'KW' => esc_html__( 'Kuwait', 'qode-real-estate' ),
            'KG' => esc_html__( 'Kyrgyzstan', 'qode-real-estate' ),
            'LA' => esc_html__( 'Laos', 'qode-real-estate' ),
            'LV' => esc_html__( 'Latvia', 'qode-real-estate' ),
            'LB' => esc_html__( 'Lebanon', 'qode-real-estate' ),
            'LS' => esc_html__( 'Lesotho', 'qode-real-estate' ),
            'LR' => esc_html__( 'Liberia', 'qode-real-estate' ),
            'LY' => esc_html__( 'Libya', 'qode-real-estate' ),
            'LI' => esc_html__( 'Liechtenstein', 'qode-real-estate' ),
            'LT' => esc_html__( 'Lithuania', 'qode-real-estate' ),
            'LU' => esc_html__( 'Luxembourg', 'qode-real-estate' ),
            'MO' => esc_html__( 'Macao S.A.R., China', 'qode-real-estate' ),
            'MK' => esc_html__( 'Macedonia', 'qode-real-estate' ),
            'MG' => esc_html__( 'Madagascar', 'qode-real-estate' ),
            'MW' => esc_html__( 'Malawi', 'qode-real-estate' ),
            'MY' => esc_html__( 'Malaysia', 'qode-real-estate' ),
            'MV' => esc_html__( 'Maldives', 'qode-real-estate' ),
            'ML' => esc_html__( 'Mali', 'qode-real-estate' ),
            'MT' => esc_html__( 'Malta', 'qode-real-estate' ),
            'MH' => esc_html__( 'Marshall Islands', 'qode-real-estate' ),
            'MQ' => esc_html__( 'Martinique', 'qode-real-estate' ),
            'MR' => esc_html__( 'Mauritania', 'qode-real-estate' ),
            'MU' => esc_html__( 'Mauritius', 'qode-real-estate' ),
            'YT' => esc_html__( 'Mayotte', 'qode-real-estate' ),
            'MX' => esc_html__( 'Mexico', 'qode-real-estate' ),
            'FM' => esc_html__( 'Micronesia', 'qode-real-estate' ),
            'MD' => esc_html__( 'Moldova', 'qode-real-estate' ),
            'MC' => esc_html__( 'Monaco', 'qode-real-estate' ),
            'MN' => esc_html__( 'Mongolia', 'qode-real-estate' ),
            'ME' => esc_html__( 'Montenegro', 'qode-real-estate' ),
            'MS' => esc_html__( 'Montserrat', 'qode-real-estate' ),
            'MA' => esc_html__( 'Morocco', 'qode-real-estate' ),
            'MZ' => esc_html__( 'Mozambique', 'qode-real-estate' ),
            'MM' => esc_html__( 'Myanmar', 'qode-real-estate' ),
            'NA' => esc_html__( 'Namibia', 'qode-real-estate' ),
            'NR' => esc_html__( 'Nauru', 'qode-real-estate' ),
            'NP' => esc_html__( 'Nepal', 'qode-real-estate' ),
            'NL' => esc_html__( 'Netherlands', 'qode-real-estate' ),
            'NC' => esc_html__( 'New Caledonia', 'qode-real-estate' ),
            'NZ' => esc_html__( 'New Zealand', 'qode-real-estate' ),
            'NI' => esc_html__( 'Nicaragua', 'qode-real-estate' ),
            'NE' => esc_html__( 'Niger', 'qode-real-estate' ),
            'NG' => esc_html__( 'Nigeria', 'qode-real-estate' ),
            'NU' => esc_html__( 'Niue', 'qode-real-estate' ),
            'NF' => esc_html__( 'Norfolk Island', 'qode-real-estate' ),
            'MP' => esc_html__( 'Northern Mariana Islands', 'qode-real-estate' ),
            'KP' => esc_html__( 'North Korea', 'qode-real-estate' ),
            'NO' => esc_html__( 'Norway', 'qode-real-estate' ),
            'OM' => esc_html__( 'Oman', 'qode-real-estate' ),
            'PK' => esc_html__( 'Pakistan', 'qode-real-estate' ),
            'PS' => esc_html__( 'Palestinian Territory', 'qode-real-estate' ),
            'PA' => esc_html__( 'Panama', 'qode-real-estate' ),
            'PG' => esc_html__( 'Papua New Guinea', 'qode-real-estate' ),
            'PY' => esc_html__( 'Paraguay', 'qode-real-estate' ),
            'PE' => esc_html__( 'Peru', 'qode-real-estate' ),
            'PH' => esc_html__( 'Philippines', 'qode-real-estate' ),
            'PN' => esc_html__( 'Pitcairn', 'qode-real-estate' ),
            'PL' => esc_html__( 'Poland', 'qode-real-estate' ),
            'PT' => esc_html__( 'Portugal', 'qode-real-estate' ),
            'PR' => esc_html__( 'Puerto Rico', 'qode-real-estate' ),
            'QA' => esc_html__( 'Qatar', 'qode-real-estate' ),
            'RE' => esc_html__( 'Reunion', 'qode-real-estate' ),
            'RO' => esc_html__( 'Romania', 'qode-real-estate' ),
            'RU' => esc_html__( 'Russia', 'qode-real-estate' ),
            'RW' => esc_html__( 'Rwanda', 'qode-real-estate' ),
            'BL' => esc_html__( 'Saint Barth&eacute;lemy', 'qode-real-estate' ),
            'SH' => esc_html__( 'Saint Helena', 'qode-real-estate' ),
            'KN' => esc_html__( 'Saint Kitts and Nevis', 'qode-real-estate' ),
            'LC' => esc_html__( 'Saint Lucia', 'qode-real-estate' ),
            'MF' => esc_html__( 'Saint Martin (French part)', 'qode-real-estate' ),
            'SX' => esc_html__( 'Saint Martin (Dutch part)', 'qode-real-estate' ),
            'PM' => esc_html__( 'Saint Pierre and Miquelon', 'qode-real-estate' ),
            'VC' => esc_html__( 'Saint Vincent and the Grenadines', 'qode-real-estate' ),
            'SM' => esc_html__( 'San Marino', 'qode-real-estate' ),
            'ST' => esc_html__( 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe', 'qode-real-estate' ),
            'SA' => esc_html__( 'Saudi Arabia', 'qode-real-estate' ),
            'SN' => esc_html__( 'Senegal', 'qode-real-estate' ),
            'RS' => esc_html__( 'Serbia', 'qode-real-estate' ),
            'SC' => esc_html__( 'Seychelles', 'qode-real-estate' ),
            'SL' => esc_html__( 'Sierra Leone', 'qode-real-estate' ),
            'SG' => esc_html__( 'Singapore', 'qode-real-estate' ),
            'SK' => esc_html__( 'Slovakia', 'qode-real-estate' ),
            'SI' => esc_html__( 'Slovenia', 'qode-real-estate' ),
            'SB' => esc_html__( 'Solomon Islands', 'qode-real-estate' ),
            'SO' => esc_html__( 'Somalia', 'qode-real-estate' ),
            'ZA' => esc_html__( 'South Africa', 'qode-real-estate' ),
            'GS' => esc_html__( 'South Georgia/Sandwich Islands', 'qode-real-estate' ),
            'KR' => esc_html__( 'South Korea', 'qode-real-estate' ),
            'SS' => esc_html__( 'South Sudan', 'qode-real-estate' ),
            'ES' => esc_html__( 'Spain', 'qode-real-estate' ),
            'LK' => esc_html__( 'Sri Lanka', 'qode-real-estate' ),
            'SD' => esc_html__( 'Sudan', 'qode-real-estate' ),
            'SR' => esc_html__( 'Suriname', 'qode-real-estate' ),
            'SJ' => esc_html__( 'Svalbard and Jan Mayen', 'qode-real-estate' ),
            'SZ' => esc_html__( 'Swaziland', 'qode-real-estate' ),
            'SE' => esc_html__( 'Sweden', 'qode-real-estate' ),
            'CH' => esc_html__( 'Switzerland', 'qode-real-estate' ),
            'SY' => esc_html__( 'Syria', 'qode-real-estate' ),
            'TW' => esc_html__( 'Taiwan', 'qode-real-estate' ),
            'TJ' => esc_html__( 'Tajikistan', 'qode-real-estate' ),
            'TZ' => esc_html__( 'Tanzania', 'qode-real-estate' ),
            'TH' => esc_html__( 'Thailand', 'qode-real-estate' ),
            'TL' => esc_html__( 'Timor-Leste', 'qode-real-estate' ),
            'TG' => esc_html__( 'Togo', 'qode-real-estate' ),
            'TK' => esc_html__( 'Tokelau', 'qode-real-estate' ),
            'TO' => esc_html__( 'Tonga', 'qode-real-estate' ),
            'TT' => esc_html__( 'Trinidad and Tobago', 'qode-real-estate' ),
            'TN' => esc_html__( 'Tunisia', 'qode-real-estate' ),
            'TR' => esc_html__( 'Turkey', 'qode-real-estate' ),
            'TM' => esc_html__( 'Turkmenistan', 'qode-real-estate' ),
            'TC' => esc_html__( 'Turks and Caicos Islands', 'qode-real-estate' ),
            'TV' => esc_html__( 'Tuvalu', 'qode-real-estate' ),
            'UG' => esc_html__( 'Uganda', 'qode-real-estate' ),
            'UA' => esc_html__( 'Ukraine', 'qode-real-estate' ),
            'AE' => esc_html__( 'United Arab Emirates', 'qode-real-estate' ),
            'GB' => esc_html__( 'United Kingdom (UK)', 'qode-real-estate' ),
            'US' => esc_html__( 'United States (US)', 'qode-real-estate' ),
            'UM' => esc_html__( 'United States (US) Minor Outlying Islands', 'qode-real-estate' ),
            'VI' => esc_html__( 'United States (US) Virgin Islands', 'qode-real-estate' ),
            'UY' => esc_html__( 'Uruguay', 'qode-real-estate' ),
            'UZ' => esc_html__( 'Uzbekistan', 'qode-real-estate' ),
            'VU' => esc_html__( 'Vanuatu', 'qode-real-estate' ),
            'VA' => esc_html__( 'Vatican', 'qode-real-estate' ),
            'VE' => esc_html__( 'Venezuela', 'qode-real-estate' ),
            'VN' => esc_html__( 'Vietnam', 'qode-real-estate' ),
            'WF' => esc_html__( 'Wallis and Futuna', 'qode-real-estate' ),
            'EH' => esc_html__( 'Western Sahara', 'qode-real-estate' ),
            'WS' => esc_html__( 'Samoa', 'qode-real-estate' ),
            'YE' => esc_html__( 'Yemen', 'qode-real-estate' ),
            'ZM' => esc_html__( 'Zambia', 'qode-real-estate' ),
            'ZW' => esc_html__( 'Zimbabwe', 'qode-real-estate' )
        );
        
        return $countries;
    }
}

/**
 * Get property county taxonomy values
 * return value is array in provided format.
 *
 * @param $taxonomy string - queried taxonomy
 * @param $first_empty boolean - if is true, first element in key_value return array will be empty
 * @param $return_type string - format of returned array (can be key_value, object)
 *
 * @return array
 */
if ( ! function_exists( 'qodef_re_get_taxonomy_list' ) ) {
    function qodef_re_get_taxonomy_list($taxonomy = '', $first_empty = false, $return_type = 'key_value') {
        $property_taxonomy_array = array();
        $property_taxonomy_array['key_value'] = array();
        $property_taxonomy_array['obj'] = array();

        if($taxonomy !== '') {

            $args = array(
                'taxonomy' => $taxonomy,
                'hide_empty' => false
            );

            $property_taxonomies = get_terms($args);

            if (is_array($property_taxonomies) && count($property_taxonomies)) {
                if ($first_empty) {
                    $property_taxonomy_array['key_value'][''] = '';
                }
                foreach ($property_taxonomies as $property_taxonomy) {

                    $property_taxonomy_array['key_value'][$property_taxonomy->term_id] = $property_taxonomy->name;
                    $property_taxonomy_array['obj'][] = $property_taxonomy;

                }

            }
        }

        return $property_taxonomy_array[$return_type];
    }
}

if ( ! function_exists( 'qodef_re_get_taxonomy_name_from_id' ) ) {
    function qodef_re_get_taxonomy_name_from_id($term_id) {
        if(!empty ($term_id)) {
            $term = get_term($term_id);
            return $term->name;
        }
        return "";
    }
}

if ( ! function_exists( 'qodef_re_get_taxonomy_icon' ) ) {
    function qodef_re_get_taxonomy_icon($id, $image_field_name = '', $icon_field_name = '') {

        if($image_field_name !== '') {
            $taxonomy_image_id = get_term_meta($id, $image_field_name, true);

            $image_original = wp_get_attachment_image_src($taxonomy_image_id, 'full');
            $type_image = $image_original[0];

            if (!empty($type_image)) {
                $html = '<span class="qodef-taxonomy-image">';
                $html .= '<img src="' . esc_url($type_image) . '" alt="' . esc_attr__('Taxonomy Custom Icon', 'qode-real-estate') . '">';
                $html .= '</span>';
                return $html;
            }
        }

        if (!qodef_re_theme_installed()) {
            return false;
        }

        if($icon_field_name !== '') {
            $category_icon_pack = get_term_meta($id, $icon_field_name, true);
            $icon_param_name = bridge_qode_icon_collections()->getIconCollectionParamNameByKey($category_icon_pack);
            $category_icon = get_term_meta($id, $icon_field_name . '_' . $icon_param_name, true);

            if (empty($category_icon)) {
                return '';
            }

            $html = '<span class="qodef-taxonomy-icon">';
            $html .= bridge_qode_icon_collections()->renderIconHTML($category_icon, $category_icon_pack);
            $html .= '</span>';
            return $html;
        }

        return '';
    }
}

if ( ! function_exists( 'qodef_re_get_taxonomy_featured_image' ) ) {
    function qodef_re_get_taxonomy_featured_image($id, $image_field_name = '', $thumb_size = 'full', $return_type = 'html') {

        if($image_field_name !== '') {
            $taxonomy_image_id = get_term_meta($id, $image_field_name, true);

            $image_original = wp_get_attachment_image_src($taxonomy_image_id, $thumb_size);
            $type_image = $image_original[0];

            if (!empty($type_image)) {
                if($return_type === 'html') {
                    $html = '<span class="qodef-taxonomy-image">';
                    $html .= '<img src="' . esc_url($type_image) . '" alt="' . esc_attr__('Taxonomy Featured Image', 'qode-real-estate') . '">';
                    $html .= '</span>';
                    return $html;
                }
                else if($return_type === 'src') {
                    return $type_image;
                }
            }
        }

        return '';
    }
}

if ( ! function_exists( 'qodef_re_get_assets_icon_list' ) ) {
	function qodef_re_get_assets_icon_list() {
		$icon_list = array(
			''                  => esc_html__( 'None', 'qode-real-estate' ),
			'accommodation'     => esc_html__( 'Accommodation', 'qode-real-estate' ),
			'additional-space'  => esc_html__( 'Additional Space', 'qode-real-estate' ),
			'area-size'         => esc_html__( 'Area Size', 'qode-real-estate' ),
			'bathrooms'         => esc_html__( 'Bathrooms', 'qode-real-estate' ),
			'bedrooms'          => esc_html__( 'Bedrooms', 'qode-real-estate' ),
			'cable-tv'          => esc_html__( 'Cable TV', 'qode-real-estate' ),
			'ceiling-height'    => esc_html__( 'Ceiling Height', 'qode-real-estate' ),
			'd-f-center'        => esc_html__( 'Distance From Center', 'qode-real-estate' ),
			'deposit'           => esc_html__( 'Deposit', 'qode-real-estate' ),
			'electricity'       => esc_html__( 'Electricity', 'qode-real-estate' ),
			'floor'             => esc_html__( 'Floor', 'qode-real-estate' ),
			'garages'           => esc_html__( 'Garages', 'qode-real-estate' ),
			'garages-size'      => esc_html__( 'Garages Size', 'qode-real-estate' ),
			'heating'           => esc_html__( 'Heating', 'qode-real-estate' ),
			'hebitable'         => esc_html__( 'Hebitable', 'qode-real-estate' ),
			'min-lease-term'    => esc_html__( 'Minimum Lease Term', 'qode-real-estate' ),
			'parking'           => esc_html__( 'Parking', 'qode-real-estate' ),
			'payment-period'    => esc_html__( 'Payment Period', 'qode-real-estate' ),
			'pets'              => esc_html__( 'Pets', 'qode-real-estate' ),
			'property-size'     => esc_html__( 'Property Size', 'qode-real-estate' ),
			'public-cost'       => esc_html__( 'Public Cost', 'qode-real-estate' ),
			'publication-date'  => esc_html__( 'Publication Date', 'qode-real-estate' ),
			'total-floors'      => esc_html__( 'Total Floors', 'qode-real-estate' ),
			'year-built'        => esc_html__( 'Year Built', 'qode-real-estate' )
		);
		
		return $icon_list;
	}
}

if ( ! function_exists( 'qodef_re_get_assets_icon_src' ) ) {
    function qodef_re_get_assets_icon_src($icon_name, $extension) {
        return QODE_RE_ASSETS_URL_PATH . '/img/' . $icon_name . '.' . $extension;
    }
}

if (!function_exists('qodef_re_get_author_image')) {
	function qodef_re_get_author_image($author_id, $author_roles, $size = '', $avatar_size = '') {
		$role = $author_roles[0];
		$author_image = get_user_meta($author_id, 'qodef_'.$role.'_profile_image', true);
		$profile_image			= get_user_meta($author_id, 'social_profile_image', true);
		
		$size = ($size == '') ? 'thumbnail' : $size;
		$avatar_size = ($avatar_size == '') ? 96 : $avatar_size;
		
		if ( isset($author_image) && $author_image !== '' ) {
			$profile_image = wp_get_attachment_image($author_image, $size);
		} elseif ( $profile_image !== '' ) {
			$profile_image = '<img src="' . esc_url( $profile_image ) . '">';
		} else {
			$profile_image = get_avatar( $author_id, $avatar_size );
		}
		
		return $profile_image;
	}
}

if ( ! function_exists( 'qode_re_get_holder_data_for_cpt' ) ) {
    function qode_re_get_holder_data_for_cpt( $params, $additional_params, $additional_data = '' ) {
        $dataString = '';

        if ( get_query_var( 'paged' ) ) {
            $paged = get_query_var( 'paged' );
        } elseif ( get_query_var( 'page' ) ) {
            $paged = get_query_var( 'page' );
        } else {
            $paged = 1;
        }

        $query_results           = $additional_params['query_results'];
        $params['max_num_pages'] = $query_results->max_num_pages;

        if ( ! empty( $paged ) ) {
            $params['next_page'] = $paged + 1;
        }

        foreach ( $params as $key => $value ) {
            if ( ! is_array( $value ) && $value !== '' ) {
                $new_key = str_replace( '_', '-', $key );

                $dataString .= ' data-' . $new_key . '=' . esc_attr( str_replace( ' ', '', $value ) );
            }
        }

        if ( ! empty( $additional_data ) ) {
            $dataString .= ' ' . esc_attr( $additional_data );
        }

        return $dataString;
    }
}
