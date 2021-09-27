<?php
namespace QodeRestaurant\Lib;

/**
 * interface PostTypeInterface
 * @package QodeRestaurant\Lib;
 */
interface PostTypeInterface {
    /**
     * @return string
     */
    public function getBase();

    /**
     * Registers custom post type with WordPress
     */
    public function register();
}