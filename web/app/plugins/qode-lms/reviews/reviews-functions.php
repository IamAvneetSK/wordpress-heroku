<?php

/*
* Function that overrides default comment form in LMS plugin
*/
if(!function_exists('qode_lms_load_comment_template')){

    function qode_lms_load_comment_template( $comment_template ) {
        global $post;
        if(isset($post) && $post->post_type === 'course'){
            if ( !( is_singular() && ( have_comments() || 'open' == $post->comment_status ) ) ) {
                return;
            }
            return QODE_LMS_ABS_PATH.'/post-types/course/templates/single/comments.php';
        }
        else{
            return $comment_template;
        }

    }
    add_filter( 'comments_template', 'qode_lms_load_comment_template');
}

/*
 * Function that through theme filter renders required fields in comment form on single post
 */
if(!function_exists('qode_lms_comment_additional_fields')) {

    function qode_lms_comment_additional_fields() {

        if (is_singular('course')) {
            $html = '<div class="qode-rating-form-title-holder">'; //Form title begin
            /*$html .= '<div class="qode-rating-form-title">';
            $html .= '<h5>' . esc_html__('Write a Review','qode-tours') . '</h5>';
            $html .= '</div>';*/
            //$html .= qode_tours_get_tour_module_template_part('title-field', 'tours/reviews/templates/front-input','','','');
            $html .= '<div class="qode-comment-form-rating">
                        <label>' . esc_html__('Post a Review', 'qode-lms') . '
                            <span class="required">*</span>
                        </label><span class="qode-comment-rating-box">';
            $rating_criteria = bridge_core_rating_criteria(get_post_type());
            foreach ($rating_criteria as $criteria) {
                $star_params = array();
                $star_params['label'] = $criteria['label'];
                $star_params['key'] = $criteria['key'];
                $html .= qode_lms_get_module_template_part('reviews/templates/front-input/stars-field', '', $star_params);
            }
            $html .= '<input type="hidden" name="qode_rating" id="qode-rating" value="3">';
            $html .= '</span></div>';
            $html .= '</div>'; //Form title end

            $html .= '<div class="qode-comment-input-title">';
            $html .= '<input id="title" name="qode_comment_title" class="qode-input-field" type="text" placeholder="' . esc_html__('Title of your Review', 'qode-tours') . '"/>';
            $html .= '</div>';

            print $html;
        }
    }

    add_action( 'comment_form_top', 'qode_lms_comment_additional_fields' );

}

if ( ! function_exists( 'qode_lms_override_comments_list_callback' ) ) {
    function qode_lms_override_comments_list_callback( $args ) {
        $post_types = bridge_core_rating_posts_types();

        if ( is_array( $post_types ) && count( $post_types ) > 0 ) {
            foreach ( $post_types as $post_type ) {
                if ( is_singular( $post_type ) ) {
                    $args['callback'] = 'qode_list_reviews';
                }
            }
        }

        return $args;
    }

    add_filter( 'bridge_qode_filter_comments_callback', 'qode_lms_override_comments_list_callback' );
}

if ( ! function_exists( 'qode_lms_post_reviews_html' ) ) {

    function qode_lms_post_reviews_html($reviews, $post_id) {

    	if( ! is_array( $reviews ) ){
    		$reviews = array();
	    }

        $post = get_post($post_id);
        $html = '';

        if(count($reviews)){

            foreach ($reviews as $comment){

                $is_pingback_comment = $comment->comment_type == 'pingback';
                $is_author_comment  = $post->post_author == $comment->user_id;

                $comment_class = 'qode-comment clearfix';

                if($is_author_comment) {
                    $comment_class .= ' qode-post-author-comment';
                }

                if($is_pingback_comment) {
                    $comment_class .= ' qode-pingback-comment';
                }
                $review_rating = get_comment_meta( $comment->comment_ID, 'qode_rating', true );
                $review_rating_style  = 'width: '.esc_attr($review_rating*20).'%';
                $review_title = get_comment_meta( $comment->comment_ID, 'qode_comment_title', true );
                $rating_criteria = bridge_core_rating_criteria(get_post_type());

                $comment_params = array(
                    'comment'   => $comment,
                    'is_pingback_comment' => $is_pingback_comment,
                    'is_author_comment' => $is_author_comment,
                    'comment_class' => $comment_class,
                    'review_rating_style' => $review_rating_style,
                    'review_title' => $review_title,
                    'rating_criteria' => $rating_criteria
                );
                $html .= qode_lms_get_module_template_part('reviews/templates/front-list/item-holder', '', $comment_params);
            }
        }
        return $html;
    }
}
