<?php

if ( ! function_exists( 'qode_re_extend_rating_posts_types' ) ) {
    function qode_re_extend_rating_posts_types($post_types) {
        $post_types[] = 'property';

        return $post_types;
    }

    add_filter( 'bridge_core_filter_rating_post_types', 'qode_re_extend_rating_posts_types' );
}

if(!function_exists('qode_re_comment_additional_fields')) {

    function qode_re_comment_additional_fields() {

        if (is_singular('property')) {
            $html = '<div class="qode-rating-form-title-holder">'; //Form title begin
            $html .= '<div class="qode-rating-form-title">';
            $html .= '<h5 class="qode-rating-section-title">' . esc_html__('Write a Review','qode-real-estate') . '</h5>';
            $html .= '<div class="qode-comment-form-rating">
						<label>' . esc_html__('Rate Here', 'qode-real-estate') . '<span class="required">*</span></label>
						<span class="qode-comment-rating-box">';
            for ($i = 1; $i <= 5; $i++) {
                $html .= '<span class="qode-star-rating" data-value="' . $i . '"></span>';
            }
            $html .= '<input type="hidden" name="qode_rating" id="qode-rating" value="3">';
            $html .= '</span></div>';
            $html .= '</div>';
            $html .= '</div>'; //Form title end

            print $html;
        }
    }

    add_action( 'comment_form_top', 'qode_re_comment_additional_fields' );

}

if(!function_exists('qode_re_load_comment_template')){

    function qode_re_load_comment_template( $comment_template ) {
        global $post;
        if(isset($post) && $post->post_type === 'property'){
            if ( !( is_singular() && ( have_comments() || 'open' == $post->comment_status ) ) ) {
                return;
            }
            return QODE_RE_ABS_PATH.'/modules/reviews/templates/comments.php';
        }else{
            return $comment_template;
        }

    }

    add_filter( 'comments_template', 'qode_re_load_comment_template');
}

if(!function_exists('qode_re_get_current_post_comments')){

    function qode_re_get_current_post_comments($post_id, $order_by = 'comment_date_gmt' , $order = 'desc'){

        $meta_key  = '';
        if($order_by === 'rating'){
            $order_by = 'meta_value';
            $meta_key  = 'qode_rating';
        }elseif($order_by === 'date'){
            $order_by = 'comment_date_gmt';
        };

        $comment_args = array(
            'post_id' => $post_id,
            'status' => 'approve',
            'orderby' => $order_by,
            'meta_key'  => $meta_key,
            'order' => $order
        );
        if ( is_user_logged_in() ) {
            $comment_args['include_unapproved'] = get_current_user_id();
        } else {
            $commenter = wp_get_current_commenter();
            if ( $commenter['comment_author_email'] ) {
                $comment_args['include_unapproved'] = $commenter['comment_author_email'];
            }
        }

        $comments  = get_comments($comment_args);
        return $comments;

    }
}

if ( ! function_exists( 'qode_re_post_reviews_html' ) ) {

    function qode_re_post_reviews_html($reviews, $post_id) {

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

                $comment_params = array(
                    'comment'   => $comment,
                    'is_pingback_comment' => $is_pingback_comment,
                    'is_author_comment' => $is_author_comment,
                    'comment_class' => $comment_class,
                    'review_rating_style' => $review_rating_style,
                    'review_title' => $review_title,
                );
                $html .= qodef_re_get_module_template_part('reviews/templates/review', '', $comment_params);

            }
        }
        return $html;
    }
}

if ( ! function_exists( 'qode_re_singular_plural_words' ) ) {

    function qode_re_singular_plural_words( $count, $zero = false, $one = false, $more = false) {

        if($count > 1) {
            $text = ($more !== false) ? $count . ' ' .$more : '';
        } else if($count == 0){
            $text = ($zero !== false) ? $zero : '';
        } else {
            $text = ($one !== false) ?  $count . ' ' . $one : '';
        }

        return $text;
    }
}
