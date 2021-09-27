<?php
/**
 * List View Single Event
 * This file contains one event in the list view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */
if(!defined('ABSPATH')) {
	die('-1');
}

// Setup an array of venue details for use later in the template
$venue_details = tribe_get_venue_details();

// Venue
$has_venue_address = (!empty($venue_details['address'])) ? ' location' : '';

// Organizer
$organizer = tribe_get_organizer();

$price_class = '';
if(tribe_get_cost(null, true)== 'Free') {
	$price_class = 'qode-free';
}
?>

<div class="qode-events-list-item-holder qode-grid-row">
	<div class="qode-grid-col-6">
		<div class="qode-events-list-item-image-holder">
			<a href="<?php echo esc_url(tribe_get_event_link()); ?>">
				<?php the_post_thumbnail('large'); ?>

				<div class="qode-events-list-item-date-holder">
					<div class="qode-events-list-item-date-inner">
						<span class="qode-events-list-item-date-day">
							<?php echo tribe_get_start_date(null, true, 'd'); ?>
						</span>
						<span class="qode-events-list-item-date-month">
							<?php echo tribe_get_start_date(null, true, 'M'); ?>
						</span>
					</div>
				</div>
			</a>
		</div>
	</div>

	<div class="qode-grid-col-6">
		<div class="qode-events-list-item-content">
			<div class="qode-events-list-item-title-holder">

				<?php do_action('tribe_events_before_the_event_title') ?>

				<h3 class="qode-events-list-item-title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h3>
				<span class="qode-events-list-item-price <?php echo esc_html($price_class);?>">
					<?php echo esc_html(tribe_get_cost(null, true)); ?>
				</span>

				<?php do_action('tribe_events_after_the_event_title') ?>
			</div>

			<?php do_action('tribe_events_before_the_meta') ?>

			<div class="qode-events-list-item-meta">
				<div class="qode-events-single-meta-item">
					<span class="qode-events-single-meta-icon">
						<span class="dripicons-calendar"></span>
					</span>
					<span class="qode-events-single-meta-label"><?php esc_html_e('Date:', 'qode-lms'); ?></span>
					<span class="qode-events-single-meta-value">
						<?php echo tribe_events_event_schedule_details(); ?>
					</span>
				</div>

				<div class="qode-events-single-meta-item">
					<span class="qode-events-single-meta-icon">
						<span class="dripicons-clock"></span>
					</span>
					<span class="qode-events-single-meta-label"><?php esc_html_e('Time:', 'qode-lms'); ?></span>
					<span class="qode-events-single-meta-value">
						<?php echo tribe_get_start_time(); ?> - <?php echo tribe_get_end_time(); ?>
					</span>
				</div>

				<?php if(tribe_has_venue()) : ?>
					<div class="qode-events-single-meta-item">
						<span class="qode-events-single-meta-icon">
							<span class="dripicons-copy"></span>
						</span>
						<span class="qode-events-single-meta-label"><?php esc_html_e('Venue:', 'qode-lms'); ?></span>
						<span class="qode-events-single-meta-value">
							<?php echo esc_html(tribe_get_venue()); ?>
						</span>
					</div>

					<?php if(tribe_address_exists()) : ?>
						<div class="qode-events-single-meta-item">
							<span class="qode-events-single-meta-icon">
								<span class="dripicons-location"></span>
							</span>
							<span class="qode-events-single-meta-label"><?php esc_html_e('Address:', 'qode-lms'); ?></span>
							<span class="qode-events-single-meta-value">
								<?php echo tribe_get_address(); ?>
							</span>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>

			<?php do_action('tribe_events_after_the_meta') ?>

			<?php if(tribe_events_get_the_excerpt()) : ?>

				<?php do_action('tribe_events_before_the_content') ?>

				<div class="qode-events-list-item-excerpt">
					<?php echo tribe_events_get_the_excerpt(); ?>
				</div>

				<?php do_action('tribe_events_after_the_content'); ?>

			<?php endif; ?>
		</div>
	</div>
</div>