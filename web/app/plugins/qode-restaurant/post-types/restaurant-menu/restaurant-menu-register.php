<?php
namespace QodeRestaurant\CPT\RestaurantMenu;

use QodeRestaurant\Lib;

/**
 * Class RestaurantMenuRegister
 * @package QodeRestaurant\CPT\RestaurantMenu
 */

class RestaurantMenuRegister implements Lib\PostTypeInterface {
	/**
	 * @var string
	 */
	private $base;
	/**
	 * @var string
	 */
	private $taxBase;

	public function __construct() {
		$this->base    = 'qode-restaurant-menu';
		$this->taxBase = 'qode-restaurant-menu-category';
	}

	/**
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}

	public function register() {
		$this->registerPostType();
		$this->registerTax();
	}

	/**
	 * Regsiters custom post type with WordPress
	 */
	private function registerPostType() {

		$menuPosition = 5;
		$menuIcon     = 'dashicons-list-view';

		register_post_type($this->base,
			array(
				'labels'        => array(
					'name'          => __('Restaurant Menu', 'qode-restaurant'),
					'menu_name'     => __('Restaurant Menu', 'qode-restaurant'),
					'all_items'     => __('Restaurant Menu Items', 'qode-restaurant'),
					'add_new'       => __('Add New Restaurant Menu Item', 'qode-restaurant'),
					'singular_name' => __('Restaurant Menu Item', 'qode-restaurant'),
					'add_item'      => __('New Restaurant Menu Item', 'qode-restaurant'),
					'add_new_item'  => __('Add New Restaurant Menu Item', 'qode-restaurant'),
					'edit_item'     => __('Edit Restaurant Menu Item', 'qode-restaurant')
				),
				'public'        => false,
				'show_in_menu'  => true,
				'menu_position' => $menuPosition,
				'show_ui'       => true,
				'has_archive'   => false,
				'hierarchical'  => false,
				'supports'      => array('title', 'thumbnail', 'page-attributes'),
				'menu_icon'     => $menuIcon
			)
		);
	}

	/**
	 * Registers custom taxonomy with WordPress
	 */
	private function registerTax() {
		$labels = array(
			'name'              => __('Restaurant Menu Category', 'qode-restaurant'),
			'singular_name'     => __('Restaurant Menu Category', 'qode-restaurant'),
			'search_items'      => __('Search Restaurant Menu Categories', 'qode-restaurant'),
			'all_items'         => __('All Restaurant Menu Categories', 'qode-restaurant'),
			'parent_item'       => __('Parent Restaurant Menu Category', 'qode-restaurant'),
			'parent_item_colon' => __('Parent Restaurant Menu Category:', 'qode-restaurant'),
			'edit_item'         => __('Edit Restaurant Menu Category', 'qode-restaurant'),
			'update_item'       => __('Update Restaurant Menu Category', 'qode-restaurant'),
			'add_new_item'      => __('Add New Restaurant Menu Category', 'qode-restaurant'),
			'new_item_name'     => __('New Restaurant Menu Category Name', 'qode-restaurant'),
			'menu_name'         => __('Restaurant Menu Categories', 'qode-restaurant'),
		);

		register_taxonomy($this->taxBase, array($this->base), array(
			'public'      		=> false,
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'query_var'         => true,
			'show_admin_column' => true,
		));
	}

}