<?php
if(qode_music_theme_installed()) {
	if(!function_exists('qode_albums_meta_box_map')) {
		function qode_albums_meta_box_map() {

			$album_meta_box = bridge_qode_create_meta_box(
				array(
					'scope' => array('qode-album'),
					'title' => esc_html__('Album General', 'qode-music'),
					'name' => 'album_meta'
				)
			);

			bridge_qode_create_meta_box_field(
				array(
					'name'        => 'qode_album_skin_meta',
					'type'        => 'selectblank',
					'label'       => esc_html__('Album Skin', 'qode-music'),
					'description' => '',
					'options' => array(
						'light' => esc_html__('Light','qode-music'),
						'dark'		=> esc_html__('Dark','qode-music')
					),
					'parent'      => $album_meta_box
				)
			);

			bridge_qode_create_meta_box_field(
				array(
					'name'        => 'qode_album_type_meta',
					'type'        => 'select',
					'label'       => esc_html__('Album Type', 'qode-music'),
					'description' => '',
					'options' => array(
						'' => esc_html__('Default','qode-music'),
						'comprehensive' => esc_html__('Album Comprehensive','qode-music'),
						'minimal'		=> esc_html__('Album Minimal','qode-music'),
						'compact'		=> esc_html__('Album Compact','qode-music')
					),
					'parent'      => $album_meta_box
				)
			);

			bridge_qode_create_meta_box_field(
				array(
					'name'        => 'qode_album_release_date',
					'type'        => 'date',
					'label'       => esc_html__('Release Date', 'qode-music'),
					'description' => '',
					'parent'      => $album_meta_box,
                    'args'        => array(
                        'formatted_date' => 'yes'
                    )
				)
			);
			bridge_qode_create_meta_box_field(
				array(
					'name'        => 'qode_album_people',
					'type'        => 'text',
					'label'       => esc_html__('People', 'qode-music'),
					'description' => '',
					'parent'      => $album_meta_box
				)
			);

			bridge_qode_create_meta_box_field(
				array(
					'name'        => 'qode_album_video_link_meta',
					'type'        => 'text',
					'label'       => esc_html__('Latest Video Link', 'qode-music'),
					'description' => esc_html__('Enter Video Link', 'qode-music'),
					'parent'      => $album_meta_box,

				)
			);

			bridge_qode_create_meta_box_field(
				array(
					'name'        => 'qode_album_back_to_link',
					'type'        => 'text',
					'label'       => esc_html__('"Back To" Link','qode-music'),
					'description' => esc_html__('Choose "Back To" page to link from album single page', 'qode-music'),
					'parent'      => $album_meta_box,

				)
			);


			$tracks_meta_box = bridge_qode_create_meta_box(
				array(
					'scope' => array('qode-album'),
					'title' => esc_html__('Tracks', 'qode-music'),
					'name' => 'tracks_meta_box'
				)
			);
			bridge_qode_add_repeater_field(
				array(
					'name'        => 'qode_album_tracks',
					'label'       => esc_html__('Tracks', 'qode-music'),
					'fields' => array(
						array(
							'name'        => 'qode_album_track_file',
							'type'        => 'file',
							'label'       => esc_html__('Audio File', 'qode-music'),
						),
						array(
							'name'        => 'qode_album_track_title',
							'type'        => 'text',
							'label'       => esc_html__('Title', 'qode-music'),
						),
						array(
							'name'        => 'qode_album_track_buy_link',
							'type'        => 'text',
							'label'       => esc_html__('Buy Link', 'qode-music'),
						),
						array(
							'name'        	=> 'qode_album_track_free_download',
							'type'        	=> 'yesno',
							'default_value'	=> 'no',
							'label'      	=> esc_html__('Free Download', 'qode-music'),
						),
						array(
							'name'        => 'qode_album_track_video_link',
							'type'        => 'text',
							'label'       => esc_html__('Video Link', 'qode-music'),
						),
						array(
							'name'        => 'qode_album_track_lyrics',
							'type'        => 'textarea',
							'label'       => esc_html__('Lyrics', 'qode-music')
						)

					),
					'parent'      => $tracks_meta_box,
					'description' => ''
				)
			);

			$reviews_meta_box = bridge_qode_create_meta_box(
				array(
					'scope' => array('qode-album'),
					'title' => esc_html__('Reviews', 'qode-music'),
					'name' => 'reviews_meta_box'
				)
			);
			bridge_qode_add_repeater_field(
				array(
					'name'        => 'qode_album_reviews',
					'label'       => esc_html__('Reviews', 'qode-music'),
					'fields' => array(
						array(
							'name'        => 'qode_album_review_author',
							'type'        => 'text',
							'label'       => esc_html__('Review Author', 'qode-music'),
						),
						array(
							'name'        => 'qode_album_review_text',
							'type'        => 'textarea',
							'label'       => esc_html__('Review Text', 'qode-music')
						)

					),
					'parent'      => $reviews_meta_box
				)
			);
			$stores_meta_box = bridge_qode_create_meta_box(
				array(
					'scope' => array('qode-album'),
					'title' => esc_html__('Stores', 'qode-music'),
					'name' => 'stores_meta_box'
				)
			);
			bridge_qode_add_repeater_field(
				array(
					'name'        => 'qode_album_stores',
					'label'       => esc_html__('Stores', 'qode-music'),
					'fields' => array(
						array(
							'name'        => 'qode_album_store_name',
							'type'        => 'select',
							'options'	  => array(
								'itunes'		=> esc_html__('iTunes', 'qode-music'),
								'google-play'	=> esc_html__('Google Play', 'qode-music'),
								'bandcamp'		=> esc_html__('Bandcamp', 'qode-music'),
								'spotify'		=> esc_html__('Spotify', 'qode-music'),
								'amazonmp3'		=> esc_html__('AmazonMP3', 'qode-music'),
								'deezer'		=> esc_html__('Deezer', 'qode-music')
							),
							'label'       => esc_html__('Store', 'qode-music'),
						),
						array(
							'name'        => 'qode_album_store_link',
							'type'        => 'text',
							'label'       => esc_html__('Store Link', 'qode-music')
						)

					),
					'parent'      => $stores_meta_box
				)
			);

		}

		add_action('bridge_qode_action_meta_boxes_map', 'qode_albums_meta_box_map');
	}
}