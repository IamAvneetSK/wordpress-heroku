<?php

if(qode_restaurant_theme_installed()) {
	if(!function_exists('qode_restaurant_map_map')) {
		/**
		 * Adds admin page for OpenTable integration
		 */
		function qode_restaurant_map_map() {
			bridge_qode_add_admin_page(array(
				'title' => 'Restaurant',
				'slug'  => '_restaurant',
				'icon'  => 'fa fa-cutlery'
			));

			//#Working Hours panel
			$panel_working_hours = bridge_qode_add_admin_panel(array(
				'page'  => '_restaurant',
				'name'  => 'panel_working_hours',
				'title' => 'Working Hours'
			));

			$monday_group = bridge_qode_add_admin_group(array(
				'name'        => 'monday_group',
				'title'       => 'Monday',
				'parent'      => $panel_working_hours,
				'description' => 'Working hours for Monday'
			));

			$monday_row = bridge_qode_add_admin_row(array(
				'name'   => 'monday_row',
				'parent' => $monday_group
			));

			bridge_qode_add_admin_field(array(
				'name'   => 'wh_monday_from',
				'type'   => 'textsimple',
				'label'  => 'From',
				'parent' => $monday_row
			));

			bridge_qode_add_admin_field(array(
				'name'   => 'wh_monday_to',
				'type'   => 'textsimple',
				'label'  => 'To',
				'parent' => $monday_row
			));
			bridge_qode_add_admin_field(array(
				'name'   => 'wh_monday_closed',
				'type'   => 'yesnosimple',
				'default_value' => 'no',
				'label'  => esc_html__('Closed', 'qode-restaurant'),
				'parent' => $monday_row,
			));
			bridge_qode_add_admin_field(array(
				'name'   => 'wh_monday_description',
				'type'   => 'textsimple',
				'label'  => esc_html__('Description', 'qode-restaurant'),
				'parent' => $monday_row
			));
			$tuesday_group = bridge_qode_add_admin_group(array(
				'name'        => 'tuesday_group',
				'title'       => 'Tuesday',
				'parent'      => $panel_working_hours,
				'description' => 'Working hours for Tuesday'
			));

			$tuesday_row = bridge_qode_add_admin_row(array(
				'name'   => 'tuesday_row',
				'parent' => $tuesday_group
			));

			bridge_qode_add_admin_field(array(
				'name'   => 'wh_tuesday_from',
				'type'   => 'textsimple',
				'label'  => 'From',
				'parent' => $tuesday_row
			));

			bridge_qode_add_admin_field(array(
				'name'   => 'wh_tuesday_to',
				'type'   => 'textsimple',
				'label'  => 'To',
				'parent' => $tuesday_row
			));
			bridge_qode_add_admin_field(array(
				'name'   => 'wh_tuesday_closed',
				'type'   => 'yesnosimple',
				'default_value' => 'no',
				'label'  => esc_html__('Closed', 'qode-restaurant'),
				'parent' => $tuesday_row,
			));
			bridge_qode_add_admin_field(array(
				'name'   => 'wh_tuesday_description',
				'type'   => 'textsimple',
				'label'  => esc_html__('Description', 'qode-restaurant'),
				'parent' => $tuesday_row
			));

			$wednesday_group = bridge_qode_add_admin_group(array(
				'name'        => 'wednesday_group',
				'title'       => 'Wednesday',
				'parent'      => $panel_working_hours,
				'description' => 'Working hours for Wednesday'
			));

			$wednesday_row = bridge_qode_add_admin_row(array(
				'name'   => 'wednesday_row',
				'parent' => $wednesday_group
			));

			bridge_qode_add_admin_field(array(
				'name'   => 'wh_wednesday_from',
				'type'   => 'textsimple',
				'label'  => 'From',
				'parent' => $wednesday_row
			));

			bridge_qode_add_admin_field(array(
				'name'   => 'wh_wednesday_to',
				'type'   => 'textsimple',
				'label'  => 'To',
				'parent' => $wednesday_row
			));
			bridge_qode_add_admin_field(array(
				'name'   => 'wh_wednesday_closed',
				'type'   => 'yesnosimple',
				'default_value' => 'no',
				'label'  => esc_html__('Closed', 'qode-restaurant'),
				'parent' => $wednesday_row,
			));
			bridge_qode_add_admin_field(array(
				'name'   => 'wh_wednesday_description',
				'type'   => 'textsimple',
				'label'  => esc_html__('Description', 'qode-restaurant'),
				'parent' => $wednesday_row
			));

			$thursday_group = bridge_qode_add_admin_group(array(
				'name'        => 'thursday_group',
				'title'       => 'Thursday',
				'parent'      => $panel_working_hours,
				'description' => 'Working hours for Thursday'
			));

			$thursday_row = bridge_qode_add_admin_row(array(
				'name'   => 'thursday_row',
				'parent' => $thursday_group
			));

			bridge_qode_add_admin_field(array(
				'name'   => 'wh_thursday_from',
				'type'   => 'textsimple',
				'label'  => 'From',
				'parent' => $thursday_row
			));

			bridge_qode_add_admin_field(array(
				'name'   => 'wh_thursday_to',
				'type'   => 'textsimple',
				'label'  => 'To',
				'parent' => $thursday_row
			));
			bridge_qode_add_admin_field(array(
				'name'   => 'wh_thursday_closed',
				'type'   => 'yesnosimple',
				'default_value' => 'no',
				'label'  => esc_html__('Closed', 'qode-restaurant'),
				'parent' => $thursday_row,
			));
			bridge_qode_add_admin_field(array(
				'name'   => 'wh_thursday_description',
				'type'   => 'textsimple',
				'label'  => esc_html__('Description', 'qode-restaurant'),
				'parent' => $thursday_row
			));

			$friday_group = bridge_qode_add_admin_group(array(
				'name'        => 'friday_group',
				'title'       => 'Friday',
				'parent'      => $panel_working_hours,
				'description' => 'Working hours for Friday'
			));

			$friday_row = bridge_qode_add_admin_row(array(
				'name'   => 'friday_row',
				'parent' => $friday_group
			));

			bridge_qode_add_admin_field(array(
				'name'   => 'wh_friday_from',
				'type'   => 'textsimple',
				'label'  => 'From',
				'parent' => $friday_row
			));

			bridge_qode_add_admin_field(array(
				'name'   => 'wh_friday_to',
				'type'   => 'textsimple',
				'label'  => 'To',
				'parent' => $friday_row
			));

			bridge_qode_add_admin_field(array(
				'name'   => 'wh_friday_closed',
				'type'   => 'yesnosimple',
				'default_value' => 'no',
				'label'  => esc_html__('Closed', 'qode-restaurant'),
				'parent' => $friday_row,
			));

			bridge_qode_add_admin_field(array(
				'name'   => 'wh_friday_description',
				'type'   => 'textsimple',
				'label'  => esc_html__('Description', 'qode-restaurant'),
				'parent' => $friday_row
			));

			$saturday_group = bridge_qode_add_admin_group(array(
				'name'        => 'saturday_group',
				'title'       => 'Saturday',
				'parent'      => $panel_working_hours,
				'description' => 'Working hours for Saturday'
			));

			$saturday_row = bridge_qode_add_admin_row(array(
				'name'   => 'saturday_row',
				'parent' => $saturday_group
			));

			bridge_qode_add_admin_field(array(
				'name'   => 'wh_saturday_from',
				'type'   => 'textsimple',
				'label'  => 'From',
				'parent' => $saturday_row
			));

			bridge_qode_add_admin_field(array(
				'name'   => 'wh_saturday_to',
				'type'   => 'textsimple',
				'label'  => 'To',
				'parent' => $saturday_row
			));

			bridge_qode_add_admin_field(array(
				'name'   => 'wh_saturday_closed',
				'type'   => 'yesnosimple',
				'default_value' => 'no',
				'label'  => esc_html__('Closed', 'qode-restaurant'),
				'parent' => $saturday_row,
			));

			bridge_qode_add_admin_field(array(
				'name'   => 'wh_saturday_description',
				'type'   => 'textsimple',
				'label'  => esc_html__('Description', 'qode-restaurant'),
				'parent' => $saturday_row
			));

			$sunday_group = bridge_qode_add_admin_group(array(
				'name'        => 'sunday_group',
				'title'       => 'Sunday',
				'parent'      => $panel_working_hours,
				'description' => 'Working hours for Sunday'
			));

			$sunday_row = bridge_qode_add_admin_row(array(
				'name'   => 'sunday_row',
				'parent' => $sunday_group
			));

			bridge_qode_add_admin_field(array(
				'name'   => 'wh_sunday_from',
				'type'   => 'textsimple',
				'label'  => 'From',
				'parent' => $sunday_row
			));

			bridge_qode_add_admin_field(array(
				'name'   => 'wh_sunday_to',
				'type'   => 'textsimple',
				'label'  => 'To',
				'parent' => $sunday_row
			));

			bridge_qode_add_admin_field(array(
				'name'   => 'wh_sunday_closed',
				'type'   => 'yesnosimple',
				'default_value' => 'no',
				'label'  => esc_html__('Closed', 'qode-restaurant'),
				'parent' => $sunday_row,
			));

			bridge_qode_add_admin_field(array(
				'name'   => 'wh_sunday_description',
				'type'   => 'textsimple',
				'label'  => esc_html__('Description', 'qode-restaurant'),
				'parent' => $sunday_row
			));
		}

		add_action('bridge_qode_action_options_map', 'qode_restaurant_map_map', 115); //one after elements
	}
}