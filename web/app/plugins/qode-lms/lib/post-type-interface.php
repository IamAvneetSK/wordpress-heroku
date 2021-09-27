<?php

namespace QodeLMS\Lib;

/**
 * interface PostTypeInterface
 * @package QodeLMS\Lib;
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