<?php

namespace QodefRE\CPT\Shortcodes\AgencyAndAgentList;

use QodefRE\Lib;

class AgencyAndAgentList implements Lib\ShortcodeInterface {
    private $base;

    public function __construct() {
        $this->base = 'qodef_agency_and_agent_list';

        add_action( 'vc_before_init', array( $this, 'vcMap' ) );

		//Selected Agency filter
		add_filter( 'vc_autocomplete_' . $this->base . '_selected_agencies_callback', array( &$this, 'agencyIdAutocompleteSuggester', ), 10, 1 ); // Get suggestion(find). Must return an array
		
		//Agency render
		add_filter( 'vc_autocomplete_' . $this->base . '_selected_agencies_render', array( &$this, 'agencyIdAutocompleteRender', ), 10, 1 );
    }

    public function getBase() {
        return $this->base;
    }

    public function vcMap() {
        if ( function_exists( 'vc_map' ) ) {
            vc_map( array(
                    'name'                      => esc_html__( 'Qode Agency and Agent List', 'qode-real-estate' ),
                    'base'                      => $this->getBase(),
                    'category'                  => esc_html__( 'by QODE REAL ESTATE', 'qode-real-estate' ),
                    'icon'                      => 'icon-wpb-agency-and-agent-list extended-custom-re-icon',
                    'allowed_container_element' => 'vc_row',
                    'params'                    => array(
                    	array(
                            'type'        => 'dropdown',
                            'param_name'  => 'display_user',
                            'heading'     => esc_html__( 'Choose What to Display', 'qode-real-estate' ),
                            'value'       => array(
                                esc_html__( 'Agencies', 'qode-real-estate' ) => 'agencies',
                                esc_html__( 'Agents', 'qode-real-estate' ) => 'agents',
                            )
                		),
                		array(
                            'type'        => 'autocomplete',
                            'param_name'  => 'selected_agencies',
                            'heading'     => esc_html__( 'Show Only Agencies with Listed Ids', 'qode-real-estate' ),
							'settings'    => array(
								'multiple'      => true,
								'sortable'      => true,
								'unique_values' => true
							),
                            'description' => esc_html__('Enter agencies you want to display, left empty for all','qode-real-estate'),
                            'dependency'  => array('element' => 'display_user', 'value' => 'agencies')
            			),
                		array(
                            'type'        => 'dropdown',
                            'param_name'  => 'agents_of_agency',
                            'heading'     => esc_html__( 'Show Agents of Agency', 'qode-real-estate' ),
                            'value'       => array_merge(array(''=>''), array_flip(qodef_re_get_user_agency_options())),
                            'dependency'  => array('element' => 'display_user', 'value' => 'agents')
            			),
                        array(
                            'type'        => 'dropdown',
                            'param_name'  => 'number_of_columns',
                            'heading'     => esc_html__( 'Number of Columns', 'qode-real-estate' ),
                            'value'       => array(
                                esc_html__( 'Default', 'qode-real-estate' ) => '',
                                esc_html__( 'One', 'qode-real-estate' )     => '1',
                                esc_html__( 'Two', 'qode-real-estate' )     => '2',
                                esc_html__( 'Three', 'qode-real-estate' )   => '3',
                                esc_html__( 'Four', 'qode-real-estate' )    => '4',
                                esc_html__( 'Five', 'qode-real-estate' )    => '5',
                                esc_html__( 'Six', 'qode-real-estate' )     => '6'
                            ),
                            'description' => esc_html__( 'Default value is Four', 'qode-real-estate' ),
                        ),
                        array(
                            'type'        => 'dropdown',
                            'param_name'  => 'space_between_items',
                            'heading'     => esc_html__( 'Space Between Items', 'qode-real-estate' ),
                            'value'       => array_flip( bridge_qode_get_space_between_items_array() ),
                            'save_always' => true
                        ),
                        array(
                            'type'       => 'dropdown',
                            'param_name' => 'enable_link',
                            'heading'    => esc_html__( 'Link Items to Profile Pages', 'qode-real-estate' ),
                            'value'      => array_flip( bridge_qode_get_yes_no_select_array( false ) ),
                            'save_always' => true
                        )
                    )
                )
            );
        }
    }

    /**
     * Renders shortcodes HTML
     *
     * @param $atts array of shortcode params
     * @param $content string shortcode content
     *
     * @return string
     */
    public function render($atts, $content = null) {
        $args = array(
        	'display_user'				=> 'agencies',
        	'selected_agencies'			=> '',
        	'agents_of_agency'			=> '',
            'number_of_columns'         => '4',
            'space_between_items'       => 'normal',
            'enable_link'               => 'no'
        );
        $params = shortcode_atts($args, $atts);

        $users           = $this->getUserParams($params);
        $params['all_users'] = $users;

        $params['holder_classes']        = $this->getHolderClasses( $params );
        $params['holder_inner_classes']  = $this->getHolderInnerClasses();

        $params['item_layout'] = 'standard';
        $params['this_object'] = $this;

        $html = qodef_re_get_module_template_part( 'roles/shortcodes/agency-and-agent-list/templates/agency-and-agent-template', '', $params);

        return $html;
    }

    /**
     * Generates parameters for user (both Agents and Agencies)
     */
    private function getUserParams($params) {
    	$users = array();

    	if ($params['display_user'] == 'agencies'){


			//check if agency role exists
			if (wp_roles()->is_role('agency')) {

				$query_args = array(
					'role' => 'agency',
				);

				if ($params['selected_agencies'] !== ''){
					$query_args['include'] = explode(',', $params['selected_agencies']);
				}

				$user_query = get_users($query_args);
			}

    	} elseif ($params['display_user'] == 'agents') {

			$agency_id = $params['agents_of_agency'];

			//check if agent role exists
			if (wp_roles()->is_role('agent')) {

				$query_args = array(
					'role' => 'agent',
				);

                if(!empty($agency_id)){
                    $query_args['meta_key'] = 'qodef_belonging_agency';
                    $query_args['meta_value'] = $agency_id;
                }

				$user_query = get_users($query_args);
			}
		}

		if (is_array($user_query) && count($user_query)){

			foreach ($user_query as $user) {
				$user_params = array();
				$user_data = $user->data;

				$user_params['id'] = $user_data->ID;
				$user_params['name'] = $user_data->display_name;
                $user_params['position'] = get_user_meta($user_data->ID, 'qodef_agent_position', true);
				$user_params['image'] = qodef_re_get_author_image($user_data->ID, $user->roles, 'full', 600);
                $user_params['link'] = get_author_posts_url($user_data->ID);
				$user_params['description'] = get_user_meta($user_data->ID, 'description', true);
				$user_params['social_icons'] = $this->getSocialIcons($user_data->ID);

				$users[] = $user_params;
			}
		}

    	$returning_users['users'] = $users;

		return $returning_users;
    }


    private function getSocialIcons($id) {
        $social_icons = array();

        $social_links = array('facebook','twitter','linkedin','instagram','pinterest','tumblr','googleplus');

        foreach ($social_links as $social_link) {
        	$link = get_user_meta($id, $social_link, true);

        	if ($link == ''){
        		continue;
        	}

        	switch ($social_link) {
				case 'facebook':
					$icon = 'fa fa-facebook';
					break;
				case 'twitter':
					$icon = 'fa fa-twitter';
					break;
				case 'googleplus':
					$icon = 'fa fa-google-plus';
					break;
				case 'linkedin':
					$icon = 'fa fa-linkedin';
					break;
				case 'instagram':
					$icon = 'fa fa-instagram';
					break;
				case 'tumblr':
					$icon = 'fa fa-tumblr';
					break;
				case 'pinterest':
					$icon = 'fa fa-pinterest-p';
					break;
        	}

			$icon_params = array();
			$icon_params['icon_pack'] = 'font_awesome';
			$icon_params['fa_icon'] = $icon;
			$icon_params['link'] = $link;
			$icon_params['target'] = '_blank';

            $social_icons[] = bridge_qode_execute_shortcode('qodef_icon', $icon_params);
        }

        return $social_icons;
    }


    /**
     * Generates holder classes
     *
     * @param $params
     *
     * @return string
     */
    public function getHolderClasses( $params ) {
        $classes = array();

        $classes[] = ! empty( $params['space_between_items'] ) ? 'qodef-' . $params['space_between_items'] . '-space' : 'qodef-normal-space';

        $number_of_columns = $params['number_of_columns'];
        switch ( $number_of_columns ):
            case '1':
                $classes[] = 'qodef-aal-one-column';
                break;
            case '2':
                $classes[] = 'qodef-aal-two-columns';
                break;
            case '3':
                $classes[] = 'qodef-aal-three-columns';
                break;
            case '4':
                $classes[] = 'qodef-aal-four-columns';
                break;
            case '5':
                $classes[] = 'qodef-aal-five-columns';
                break;
            case '6':
                $classes[] = 'qodef-aal-six-columns';
                break;
            default:
                $classes[] = 'qodef-aal-three-columns';
                break;
        endswitch;

        return implode( ' ', $classes );
    }

    /**
     * Generates property holder inner classes
     *
     *
     * @return string
     */
    public function getHolderInnerClasses(){
        $classes = array();

        $classes[] = 'qodef-outer-space';

        return implode(' ', $classes);
    }

	/**
	 * Filter agencies
	 *
	 * @param $query
	 *
	 * @return array
	 */
	public function agencyIdAutocompleteSuggester( $query ) {
		global $wpdb;
		
		$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.id AS ID, a.user_nicename as user_nicename
                    FROM {$wpdb->users} AS a WHERE a.user_nicename LIKE '%%%s%%' AND a.id in (SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key LIKE '%%capabilities%%' AND meta_value LIKE '%%agency%%')", stripslashes( $query ) ), ARRAY_A );
		
		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data          = array();
				$data['value'] = $value['ID'];
				$data['label'] = ( ( strlen( $value['user_nicename'] ) > 0 ) ? esc_html__( 'Agency', 'qode-real-estate' ) . ': ' . $value['user_nicename'] : '' );
				$results[]     = $data;
			}
		}
		
		return $results;
	}
	
	/**
	 * Find agencies by id
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	public function agencyIdAutocompleteRender( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		
		if ( ! empty( $query ) ) {
			$author = get_user_by( 'ID', $query, 'user_nicename' );
			
			if ( is_object( $author ) ) {
				$author_id            = $author->id;
				$author_user_nicename = $author->user_nicename;
				
				$author_display = '';
				if ( ! empty( $author_user_nicename ) ) {
					$author_display = esc_html__( 'Agency', 'qode-real-estate' ) . ': ' . $author_user_nicename;
				}
				
				$data          = array();
				$data['value'] = $author_id;
				$data['label'] = $author_display;

				return ! empty( $data ) ? $data : false;
			}
			
			return false;
		}
		
		return false;
	}
}