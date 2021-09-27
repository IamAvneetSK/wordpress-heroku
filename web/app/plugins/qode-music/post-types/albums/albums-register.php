<?php
namespace QodeMusic\CPT\Albums;

use QodeMusic\Lib\PostTypeInterface;

/**
 * Class AlbumsRegister
 * @package QodeMusic\CPT\Albums
 */
class AlbumsRegister implements PostTypeInterface {
    /**
     * @var string
     */
    private $base;

    public function __construct() {

        $this->base				= 'qode-album';
        $this->taxGenreBase		= 'qode-album-genre';
        $this->taxLabelBase		= 'qode-album-label';
        $this->taxArtistBase	= 'qode-album-artist';

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
     * Registers album single template if one does'nt exists in theme.
     * Hooked to single_template filter
     * @param $single string current template
     * @return string string changed template
     */
    public function registerSingleTemplate($single) {
        global $post;

        if($post->post_type == $this->base) {
            if(!file_exists(get_template_directory().'/single-'.$this->base.'.php')) {
                return QODE_MUSIC_CPT_PATH.'/albums/templates/single-'.$this->base.'.php';
            }
        }

        return $single;
    }

    /**
     * Registers custom post type with WordPress
     */
    private function registerPostType() {

        $menuPosition = 5;
        $menuIcon = 'dashicons-admin-post';
        $slug = $this->base;

        register_post_type( $this->base,
            array(
                'labels'		=> array(
                    'name'			=> esc_html__( 'Albums','qode-music' ),
                    'singular_name'	=> esc_html__( 'Album','qode-music' ),
                    'add_item'		=> esc_html__( 'New Album','qode-music' ),
                    'add_new_item'	=> esc_html__( 'Add New Album','qode-music' ),
                    'edit_item'		=> esc_html__( 'Edit Album','qode-music' )
                ),
                'public'		=> true,
                'has_archive'	=> true,
                'rewrite'		=> array('slug' => 'album'),
                'menu_position'	=> $menuPosition,
                'show_ui'		=> true,
                'supports'		=> array('author', 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'comments'),
                'menu_icon'		=>  $menuIcon
            )
        );
    }

    /**
     * Registers custom taxonomy with WordPress
     */
    private function registerTax() {
        $label_labels = array(
            'name'				=> esc_html__( 'Labels', 'qode-music' ),
            'singular_name'		=> esc_html__( 'Label', 'qode-music' ),
            'search_items'		=> esc_html__( 'Search Labels', 'qode-music' ),
            'all_items'			=> esc_html__( 'All Labels', 'qode-music' ),
            'parent_item'		=> esc_html__( 'Parent Label', 'qode-music' ),
            'parent_item_colon'	=> esc_html__( 'Parent Label:', 'qode-music' ),
            'edit_item'			=> esc_html__( 'Edit Label', 'qode-music' ),
            'update_item'		=> esc_html__( 'Update Label', 'qode-music' ),
            'add_new_item'		=> esc_html__( 'Add New Label', 'qode-music' ),
            'new_item_name'		=> esc_html__( 'New Label Name', 'qode-music' ),
            'menu_name'			=> esc_html__( 'Labels', 'qode-music' ),
        );

        register_taxonomy($this->taxLabelBase, array($this->base), array(
            'hierarchical'		=> true,
            'labels'			=> $label_labels,
            'show_ui'			=> true,
            'query_var'			=> true,
	        'show_admin_column'	=> true
        ));

		$genre_labels = array(
			'name'				=> esc_html__( 'Genres', 'qode-music' ),
			'singular_name'		=> esc_html__( 'Genre', 'qode-music' ),
			'search_items'		=> esc_html__( 'Genres', 'qode-music' ),
			'all_items'			=> esc_html__( 'Genres', 'qode-music' ),
			'parent_item'		=> esc_html__( 'Parent Genre', 'qode-music' ),
			'parent_item_colon'	=> esc_html__( 'Parent Genres:', 'qode-music' ),
			'edit_item'			=> esc_html__( 'Edit Genre', 'qode-music' ),
			'update_item'		=> esc_html__( 'Update Genre', 'qode-music' ),
			'add_new_item'		=> esc_html__( 'Add New Genre', 'qode-music' ),
			'new_item_name'		=> esc_html__( 'New Genre', 'qode-music' ),
			'menu_name'			=> esc_html__( 'Genres', 'qode-music' ),
		);

		register_taxonomy($this->taxGenreBase,array($this->base), array(
			'hierarchical'		=> true,
			'labels'			=> $genre_labels,
			'show_ui'			=> true,
			'query_var'			=> true,
			'show_admin_column'	=> true
		));

		$artist_labels = array(
			'name'				=> esc_html__( 'Artists', 'qode-music' ),
			'singular_name'		=> esc_html__( 'Artist', 'qode-music' ),
			'search_items'		=> esc_html__( 'Artists', 'qode-music' ),
			'all_items'			=> esc_html__( 'Artists', 'qode-music' ),
			'parent_item'		=> esc_html__( 'Parent Artist', 'qode-music' ),
			'parent_item_colon'	=> esc_html__( 'Parent Artists:', 'qode-music' ),
			'edit_item'			=> esc_html__( 'Edit Artist', 'qode-music' ),
			'update_item'		=> esc_html__( 'Update Artist', 'qode-music' ),
			'add_new_item'		=> esc_html__( 'Add New Artist', 'qode-music' ),
			'new_item_name'		=> esc_html__( 'New Artist Name', 'qode-music' ),
			'menu_name'			=> esc_html__( 'Artists', 'qode-music' ),
		);

		register_taxonomy($this->taxArtistBase,array($this->base), array(
			'hierarchical'		=> true,
			'labels'			=> $artist_labels,
			'show_ui'			=> true,
			'query_var'			=> true,
			'show_admin_column'	=> true
		));
    }

}