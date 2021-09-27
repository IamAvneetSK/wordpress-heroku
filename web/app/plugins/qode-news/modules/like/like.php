<?php

class QodeNewsLike {
	private static $instance;
	
	private function __construct() {
		add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
		add_action( 'wp_ajax_qode_news_like', array( $this, 'ajax' ) );
		add_action( 'wp_ajax_nopriv_qode_news_like', array( $this, 'ajax' ) );
	}
	
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		
		return self::$instance;
	}

	/**
	 * Loads all necessary script for like functionality
	 */
	public function enqueueScripts() {
		wp_enqueue_script('qode-news-like', QODE_NEWS_LIKE_URL_PATH . '/js/qode-news-like.js', 'jquery', false, true);
	}
	
	function ajax() {
		//update
		if ( isset( $_POST['likes_id'] ) ) {
			$post_id = str_replace( 'qode-like-', '', $_POST['likes_id'] );
			$post_id = substr( $post_id, 0, - 4 );
			$type    = isset( $_POST['type'] ) ? $_POST['type'] : '';
			$reaction    = isset( $_POST['reaction'] ) ? $_POST['reaction'] : 'like';

			echo wp_kses( $this->like_post( $post_id, 'update', $reaction, $type ), array(
				'a' => array(
					'class'       => true,
					'aria-hidden' => true,
					'style'       => true,
					'id'          => true
				),
				'span' => array(
					'class'       => true,
					'aria-hidden' => true,
					'style'       => true,
					'id'          => true
				),
				'i'    => array(
					'class' => true,
					'style' => true,
					'id'    => true
				)
			) );
		} //get
		else {
			$post_id = str_replace( 'qode-like-', '', $_POST['likes_id'] );
			$post_id = substr( $post_id, 0, - 4 );
			echo wp_kses( $this->like_post( $post_id, 'get'), array(
				'a' => array(
					'class'       => true,
					'aria-hidden' => true,
					'style'       => true,
					'id'          => true
				),
				'span' => array(
					'class'       => true,
					'aria-hidden' => true,
					'style'       => true,
					'id'          => true
				),
				'i'    => array(
					'class' => true,
					'style' => true,
					'id'    => true
				)
			) );
		}
		
		exit;
	}
	
	public function like_post( $post_id, $action = 'get', $reaction = 'like', $type = '' ) {
		if ( ! is_numeric( $post_id ) ) {
			return;
		}
		
		$like_icon = '<a href="#" class="qode-news-like arrow_up" aria-hidden="true"></a>';
		$dislike_icon = '<a href="#" class="qode-news-dislike arrow_down" aria-hidden="true"></a>';

		switch ( $action ) {
			
			case 'get':
				$like_count = get_post_meta( $post_id, '_qode-like', true );

				if ( ! $like_count ) {
					$like_count = 0;
					add_post_meta( $post_id, '_qode-like', $like_count, true );
				}
				
				$return_value = $like_icon . $dislike_icon . "<span>" . esc_attr( $like_count ) . "</span>";
				
				return $return_value;
				break;
			
			case 'update':
				$like_count = get_post_meta( $post_id, '_qode-like', true );
				
				if ( isset( $_COOKIE[ 'qode-like_' . $post_id ] ) ) {
					return $like_count;
				}

				if ($reaction == 'like'){
					$like_count++;
				} else{
					$like_count--;
				}
				
				update_post_meta( $post_id, '_qode-like', $like_count );

				setcookie( 'qode-like_' . $post_id, $post_id, time() * 20, '/' );
				
				$return_value =  $like_icon . $dislike_icon . "<span>" . esc_attr( $like_count ) . "</span>";
				
				return $return_value;
				
				break;
			default:
				return '';
				break;
		}
	}
	
	public function add_like() {
		global $post;
		
		$output = $this->like_post( $post->ID );;
		$class       = 'qode-news-like-dislike';
		$rand_number = rand( 100, 999 );
		$title       = esc_html__( 'Like/Dislike this', 'qode-news' );
		
		if ( isset( $_COOKIE[ 'qode-like_' . $post->ID ] ) ) {
			$class = 'qode-news-like-disliked liked';
			$title = esc_html__( 'You already liked/disliked this!', 'qode-news' );
		}
		
		return '<div class="' . $class . '" id="qode-like-' . $post->ID . '-' . $rand_number . '" title="' . $title . '">' . $output . '</div>';
	}
}

if ( ! function_exists( 'qode_news_create_like' ) ) {
	function qode_news_create_like() {
		QodeNewsLike::get_instance();
	}
	
	add_action( 'after_setup_theme', 'qode_news_create_like' );
}