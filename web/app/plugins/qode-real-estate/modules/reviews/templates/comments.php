<?php

if ( post_password_required() ) { ?>

    <p class="qode-no-password">
        <?php esc_html_e( 'This post is password protected. Enter the password to view any comments.', 'qode-real-estate' ); ?>
    </p>

<?php }
else {
    if ( have_comments() ) { ?>

        <div class="qode-comment-holder clearfix" id="comments">
            <div class="qode-comment-holder-separator">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="qode-comment-holder-inner">
                <div class="qode-comments-title-holder">
                    <h5 class="qode-comments-title">
                        <?php
                        $post_comments = qode_re_get_current_post_comments( get_the_ID() );
                        $number_of_reviews = is_array( $post_comments ) ? count( $post_comments ) : 0;

                        echo qode_re_singular_plural_words($number_of_reviews, false, esc_html__('Review', 'qode-real-estate'), esc_html__('Reviews', 'qode-real-estate'))?>
                    </h5>
                    <?php
                    if( is_array( $post_comments ) && $number_of_reviews > 0 ) {
                        $sum = 0;
                        foreach ($post_comments as $comment) {
                            $review_rating = get_comment_meta($comment->comment_ID, 'qode_rating', true);
                            $sum += $review_rating;
                        }
                        $average_rating = $sum / $number_of_reviews;
                        $review_rating_style  = 'width: '.esc_attr($average_rating*20).'%'; ?>

                        <div class="qode-review-rating">
                            <span class="rating-inner" style="<?php echo esc_attr( $review_rating_style ); ?>"></span>
                        </div>
                    <?php } ?>
                </div>
                <div class="qode-comments">
                    <ul class="qode-comment-list">
                        <?php echo qode_re_post_reviews_html($post_comments, get_the_ID()); ?>
                    </ul>
                </div>
            </div>

        </div>

    <?php }

    else {
        if ( ! comments_open() ) { ?>
            <p>
                <?php esc_html_e('Sorry, the comment form is closed at this time.', 'qode-real-estate'); ?>
            </p>
        <?php }
    }
}
$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );
$button_params  = array(
    'text' => esc_html__('Write Your Review', 'qode-real-estate'),
    'custom_class' => 'qode-re-button qode-button-shadow qode-rating-form-trigger',
    'html_type' => 'button'
);

$args = array(
    'id_form' => 'commentform',
    'id_submit' => 'submit_comment',
    'title_reply'=> '',
    'title_reply_before' => '',
    'title_reply_after' => '',
    'title_reply_to' => esc_html__( 'Post a Reply to %s','qode-real-estate' ),
    'cancel_reply_link' => esc_html__( 'cancel reply','qode-real-estate' ),
    'label_submit' => esc_html__( 'Send Message','qode-real-estate' ),
    'comment_field' => '<label>Write Your Message</label><textarea id="comment" placeholder="'.esc_html__( 'Your comment','qode-real-estate' ).'" name="comment" cols="45" rows="6" aria-required="true"></textarea>',
    'comment_notes_before' => '',
    'comment_notes_after' => '',
    'fields' => apply_filters( 'comment_form_default_fields', array(
            'author'    => '<label>' . esc_html__( 'Your Full Name','qode-real-estate') . '</label><input id="author" name="author" placeholder="'. esc_html__( 'Your Name','qode-real-estate' ) .'" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"' . $aria_req . ' />',
            'email'     => '<label>' . esc_html__( 'Your E-mail Address','qode-real-estate') . '</label><input id="email" name="email" placeholder="'. esc_html__( 'Your Email','qode-real-estate' ) .'" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '"' . $aria_req . ' />',
            'url'     => '<label>' . esc_html__( 'Website','qode-real-estate') . '</label><input id="url" name="url" placeholder="'. esc_html__( 'Website','qode-real-estate' ) .'" type="text" value="' . esc_attr(  $commenter['comment_author_url'] ) . '"' . $aria_req . ' />'
        )
    )
);
$args['comment_field'] = '<textarea id="comment" placeholder="'.esc_html__( 'Your Experience','qode-real-estate' ).'" name="comment" cols="45" rows="8" aria-required="true"></textarea>';
$args['fields'] = apply_filters( 'comment_form_default_fields', array(
        'author' => '<div class="three_columns clearfix"><div class="column1"><div class="column_inner"><input id="author" name="author" placeholder="'. esc_html__( 'Your full name','qode-real-estate' ) .'" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"' . $aria_req . ' /></div></div>',
        'email' => '<div class="column2"><div class="column_inner"><input id="email" name="email" placeholder="'. esc_html__( 'E-mail address','qode-real-estate' ) .'" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '"' . $aria_req . ' /></div></div>',
        'url' => '<div class="column3"><div class="column_inner"><input id="url" name="url" placeholder="'. esc_html__( 'Website','qode-real-estate' ) .'" type="text" value="' . esc_attr(  $commenter['comment_author_url'] ) . '"' . $aria_req . ' /></div></div></div>',
    )
);

if(get_comment_pages_count() > 1){ ?>
    <div class="qode-comment-pager">
        <p>
            <?php paginate_comments_links(); ?>
        </p>
    </div>
<?php }

if(comments_open()) {
    $log_class = '';
    if ( is_user_logged_in() ) {
        $log_class = 'logged-in';
    }
    ?>
    <div class="qode-comment-form  <?php echo esc_attr($log_class);?>" >
        <div class="qode-comment-form-inner">

            <?php
            comment_form($args);
            ?>
        </div>
    </div>
<?php }