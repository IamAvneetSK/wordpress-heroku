<?php
namespace QodefRE\Lib;

/**
 * interface PostTypeInterface
 * @package QodefRE\Lib;
 */
interface PostTypeInterface {
    /**
     * @return string
     */
    public function getBase();

    /**
     * @return array
     */
    public function getTaxonomies();

    /**
     * Registers custom post type with WordPress
     */
    public function register();
}