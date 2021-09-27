<?php
$show_members = get_post_meta( get_the_ID(), 'qode_course_members_meta', true );

function qode_lms_retrieve_user_ids_from_a_course_id( $course_id ) {
	global $wpdb;
	
	$u    = $wpdb->prefix . "users";
	$p    = $wpdb->prefix . "posts";
	$woi  = $wpdb->prefix . "woocommerce_order_items";
	$woim = $wpdb->prefix . "woocommerce_order_itemmeta";
	
	$orders_statuses = "'wc-completed', 'wc-processing', 'wc-on-hold'";
	
	if ( qode_lms_is_wpml_installed() ) {
		$lang = ICL_LANGUAGE_CODE;
		
		$sql = "SELECT DISTINCT $u.ID
		        FROM $woim, $woi, $p, $u
		        WHERE $u.ID = $p.post_author
		        LEFT JOIN {$wpdb->prefix}icl_translations icl_t ON icl_t.element_id = $p.ID
		        AND $woi.order_item_id = $woim.order_item_id
		        AND $woi.order_id = $p.ID
		        AND $p.post_status IN ( $orders_statuses )
		        AND $woi.order_item_type LIKE 'course'
		        AND $woim.meta_value LIKE '$course_id'
		        AND icl_t.language_code='{$lang}'
		        ORDER BY $woi.order_item_id DESC";
		
		$user_ids = $wpdb->get_col( $sql );
	} else {
		$sql = "SELECT DISTINCT $u.ID
		        FROM $woim, $woi, $p, $u
		        WHERE $u.ID = $p.post_author
		        AND $woi.order_item_id = $woim.order_item_id
		        AND $woi.order_id = $p.ID
		        AND $p.post_status IN ( $orders_statuses )
		        AND $woi.order_item_type LIKE 'course'
		        AND $woim.meta_value LIKE '$course_id'
		        ORDER BY $woi.order_item_id DESC";
		
		$user_ids = $wpdb->get_col( $sql );
	}
	
	return $user_ids;
}

if ( $show_members === 'yes' && qode_lms_is_woocommerce_installed() ) {
	$user_ids = qode_lms_retrieve_user_ids_from_a_course_id( get_the_ID() );
	?>
	<div class="qode-course-members">
		<div class="qode-course-members-heading">
			<h4 class="qode-course-members-title"><?php esc_html_e('Members', 'qode-lms'); ?></h4>
			<p class="qode-course-members-description"><?php esc_html_e('Our course begins with the first step for generating great user experiences: understanding what people do, think, say, and feel. In this module, you’ll learn how to keep an open mind while learning.', 'qode-lms') ?></p>
		</div>
		<div class="qode-course-members-items">
			<h5 class="qode-course-members-items-heading"><?php esc_html_e('Total numbers of students in course', 'qode-lms'); ?></h5>
			<ul>
				<?php
				if ( ! empty( $user_ids ) ) {
					foreach ( $user_ids as $id ) { ?>
						<li>
							<span class="qode-course-member-item">
								<span class="qode-course-member-image">
									<?php echo get_avatar( $id, 70 ); ?>
								</span>
								<span class="qode-course-member-content">
									<span class="qode-course-member-author-title"><?php echo esc_html( get_the_author_meta( 'display_name', $id ) ); ?></span>
									<span class="qode-course-member-author-position"><?php echo esc_html( get_the_author_meta( 'position', $id ) ); ?></span>
								</span>
								<span class="qode-course-member-description">
									<p><?php echo esc_html( get_the_author_meta( 'description', $id ) ); ?></p>
								</span>
							</span>
						</li>
					<?php }
				}
				?>
			</ul>
		</div>
	</div>
<?php }