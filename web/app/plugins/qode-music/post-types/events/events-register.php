<?php
namespace QodeMusic\CPT\Events;

use QodeMusic\Lib\PostTypeInterface;

/**
 * Class EventsRegister
 * @package QodeMusic\CPT\Events
 */
class EventsRegister implements PostTypeInterface {
    /**
     * @var string
     */
    private $base;

    public function __construct() {
        $this->base		= 'qode-event';
        $this->taxBase	= 'qode-event-type';

        add_filter('single_template', array($this, 'registerSingleTemplate'));
    }

    /**
     * @return string
     */
    public function getBase() {
        return $this->base;
    }

    /**
     * Registers custom post type with WordPress
     */
    public function register() {
        $this->registerPostType();
        $this->registerTax();
    }


    /**
     * Registers event single template if one doesn't exists in theme.
     * Hooked to single_template filter
     * @param $single string current template
     * @return string string changed template
     */
    public function registerSingleTemplate($single) {
        global $post;

        if($post->post_type == $this->base) {
            if(!file_exists(get_template_directory().'/single-event.php')) {
                return QODE_MUSIC_CPT_PATH.'/events/templates/single-'.$this->base.'.php';
            }
        }

        return $single;
    }

    /**
     * Registers custom post type with WordPress
     */
    private function registerPostType() {

        global $bridge_qode_options;

        $menuPosition	= 5;
        $menuIcon		= 'dashicons-admin-post';
        $slug			= 'event';

        if(isset($bridge_qode_options['event_single_slug'])) {
            if($bridge_qode_options['event_single_slug'] != ""){
                $slug = $bridge_qode_options['event_single_slug'];
            }
        }

        register_post_type( $this->base,
            array(
                'labels'		=> array(
                    'name'			=> esc_html__( 'Events','qode-music' ),
                    'singular_name'	=> esc_html__( 'Event','qode-music' ),
                    'add_item'		=> esc_html__( 'New Event','qode-music' ),
                    'add_new_item'	=> esc_html__( 'Add New Event','qode-music' ),
                    'edit_item'		=> esc_html__( 'Edit Event','qode-music' )
                ),
                'public'		=> true,
                'has_archive'	=> true,
                'rewrite'		=> array('slug' => $slug),
                'menu_position'	=> $menuPosition,
                'show_ui'		=> true,
                'supports'		=> array('author', 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'comments'),
                'menu_icon'		=> $menuIcon
            )
        );
    }

    /**
     * Registers custom taxonomy with WordPress
     */
    private function registerTax() {
        $labels = array(
            'name'				=> esc_html__( 'Event Types', 'qode-music' ),
            'singular_name'		=> esc_html__( 'Event Type', 'qode-music' ),
            'search_items'		=> esc_html__( 'Search Event Types', 'qode-music' ),
            'all_items'			=> esc_html__( 'All Event Types', 'qode-music' ),
            'parent_item'		=> esc_html__( 'Parent Event Type', 'qode-music' ),
            'parent_item_colon'	=> esc_html__( 'Parent Event Type:', 'qode-music' ),
            'edit_item'			=> esc_html__( 'Edit Event Type', 'qode-music' ),
            'update_item'		=> esc_html__( 'Update Event Type', 'qode-music' ),
            'add_new_item'		=> esc_html__( 'Add New Event Type', 'qode-music' ),
            'new_item_name'		=> esc_html__( 'New Event Type Name', 'qode-music' ),
            'menu_name'			=> esc_html__( 'Event Types', 'qode-music' ),
        );

        register_taxonomy($this->taxBase, array($this->base), array(
            'hierarchical'		=> true,
            'labels'			=> $labels,
            'show_ui'			=> true,
            'query_var'			=> true,
	        'show_admin_column'	=> true,
            'rewrite'			=> array( 'slug' => 'event-type' ),
        ));
    }
}
