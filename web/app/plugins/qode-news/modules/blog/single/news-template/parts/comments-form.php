<?php
if ( post_password_required() ) {
	return;
}

if ( comments_open() || get_comments_number() ) { ?>
	<div class="qode-comment-holder clearfix" id="comments">
		<?php if ( have_comments() ) { ?>
			<div class="qode-comment-holder-inner">
				<div class="qode-comments-title">
					<h4><?php comments_number( esc_html__('No Comments','qode-news'), esc_html__('1 Comment','qode-news'), '%'.esc_html__(' Comments','qode-news')); ?></h4>
				</div>
				<div class="qode-comments">
					<ul class="qode-comment-list">
						<?php wp_list_comments( array_unique( array_merge( array( 'callback' => 'qode_news_comment' ), apply_filters( 'bridge_qode_filter_comments_callback', array() ) ) ) ); ?>
					</ul>
				</div>
			</div>
		<?php } ?>
		<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) { ?>
			<p><?php esc_html_e( 'Sorry, the comment form is closed at this time.', 'qode-news' ); ?></p>
		<?php } ?>
	</div>
	<?php
		$qode_commenter = wp_get_current_commenter();
		$qode_req       = get_option( 'require_name_email' );
		$qode_aria_req  = ( $qode_req ? " aria-required='true'" : '' );
		
		$qode_args = array(
			'id_form'              => 'commentform',
			'id_submit'            => 'submit_comment',
			'title_reply'          => esc_html__( 'Post a Comment', 'qode-news' ),
			'title_reply_before'   => '<h4 id="reply-title" class="comment-reply-title">',
			'title_reply_after'    => '</h4>',
			'title_reply_to'       => esc_html__( 'Post a Reply to %s', 'qode-news' ),
			'cancel_reply_link'    => esc_html__( 'cancel reply', 'qode-news' ),
			'label_submit'         => esc_html__( 'Post a Comment', 'qode-news' ),
			'comment_field'        => apply_filters( 'comment_form_textarea_field', '<textarea id="comment" placeholder="' . esc_html__( 'Your comment', 'qode-news' ) . '" name="comment" cols="45" rows="6" aria-required="true"></textarea>' ),
			'comment_notes_before' => '',
			'comment_notes_after'  => '',
			'fields'               => apply_filters( 'comment_form_default_fields', array(
				'author' => '<div class="three_columns clearfix"><div class="column1"><div class="column_inner"><input id="author" name="author" placeholder="' . esc_html__( 'Your Name', 'qode-news' ) . '" type="text" value="' . esc_attr( $qode_commenter['comment_author'] ) . '"' . $qode_aria_req . ' /></div></div>',
				'email'  => '<div class="column2"><div class="column_inner"><input id="email" name="email" placeholder="' . esc_html__( 'Your Email', 'qode-news' ) . '" type="text" value="' . esc_attr( $qode_commenter['comment_author_email'] ) . '"' . $qode_aria_req . ' /></div></div>',
				'url'    => '<div class="column3"><div class="column_inner"><input id="url" name="url" placeholder="' . esc_html__( 'Website', 'qode-news' ) . '" type="text" value="' . esc_attr( $qode_commenter['comment_author_url'] ) . '" size="30" maxlength="200" /></div></div></div>'
			) )
		);
		
	if ( get_comment_pages_count() > 1 ) { ?>
		<div class="qode-comment-pager">
			<p><?php paginate_comments_links(); ?></p>
		</div>
	<?php } ?>
	
	<div class="qode-comment-form">
		<div class="qode-comment-form-inner">
			<?php comment_form( $qode_args ); ?>
		</div>
	</div>
<?php } ?>	