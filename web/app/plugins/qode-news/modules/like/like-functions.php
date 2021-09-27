<?php
if ( ! function_exists('qode_news_like') ) {
	/**
	 * Returns QodeNewsLike instance
	 *
	 * @return QodeNewsLike
	 */
	function qode_news_like() {
		return QodeNewsLike::get_instance();
	}
}

function qode_news_get_like() {
	echo wp_kses(qode_news_like()->add_like(), array(
		'div' => array(
			'class' => true,
			'aria-hidden' => true,
			'style' => true,
			'id' => true
		),
		'i' => array(
			'class' => true,
			'style' => true,
			'id' => true
		),
		'span' => array(
			'class' => true,
			'aria-hidden' => true,
			'style' => true,
			'id' => true
		),
		'i' => array(
			'class' => true,
			'style' => true,
			'id' => true
		),
		'a' => array(
			'href' => true,
			'class' => true,
			'id' => true,
			'title' => true,
			'style' => true
		)
	));
}