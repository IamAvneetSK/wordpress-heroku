(function($) {
	"use strict";

	var albums = {};
	qode.modules.albums = albums;

	//albums.qodeInitAlbumReviews = qodeInitAlbumReviews;

	albums.qodeOnDocumentReady = qodeOnDocumentReady;
	albums.qodeOnWindowLoad = qodeOnWindowLoad;
	albums.qodeOnWindowResize = qodeOnWindowResize;
	albums.qodeOnWindowScroll = qodeOnWindowScroll;

	$(document).ready(qodeOnDocumentReady);
	$(window).on('load', qodeOnWindowLoad);
	$(window).resize(qodeOnWindowResize);
	$(window).scroll(qodeOnWindowScroll);

	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function qodeOnDocumentReady() {
		qodeAudioPlayer().init();
		qodeAlbumPlayButton();
		qodeInitArtists();
		qodeInitAlbumsLoadMore();
		qodeAlbumFluidVideo();
	}

	/*
	 All functions to be called on $(window).load() should be in this function
	 */
	function qodeOnWindowLoad() {
		qodeInitElementorAlbumPlayer();
		qodeInitElementorAlbum();
		qodeInitElementorAlbumsList();
	}

	/*
	 All functions to be called on $(window).resize() should be in this function
	 */
	function qodeOnWindowResize() {

	}

	/*
	 All functions to be called on $(window).scroll() should be in this function
	 */
	function qodeOnWindowScroll() {

	}


	function qodeInitAlbumReviews(){

		var reviews = $('.qode-single-album-reviews');
		if(reviews.length){
			reviews.each(function(){

				var review = $(this);

				var auto = true;
				var controlNav = false;
				var directionNav = true;
				var slidesToShow = 1;

				review.owl({
					infinite: true,
					autoplay: auto,
					slidesToShow : slidesToShow,
					arrows: directionNav,
					dots: controlNav,
					easing: 'easeInOutQuint',
					adaptiveHeight: true
				});

			});
			$('.qode-single-album-reviews-holder').css('opacity', 1);
		}

	}

	function qodeInitArtists(){
		if($('.qode-artists-list-holder').length) {

			var container = $('.qode-artists-list-holder');

			container.waitForImages({
				finished: function(){
					container.isotope({
						itemSelector: '.qode-artist',
						resizable: false,
						masonry: {
							columnWidth: '.qode-artists-grid-sizer',
							gutter: '.qode-artists-grid-gutter'
						}
					});
				},
				waitForAll: true
			});
		}
	}

	var qodeAudioPlayer = function() {
		//all players on the page
		var players = $('.qode-audio-player-wrapper');

		var albumPlaylist = function(player) {
			var ajaxData = {
				action: 'qode_music_album_playlist',
				album_id : player.find('.qode-audio-player-holder').data('album-id')
			};

			$.ajax({
				type: 'POST',
				data: ajaxData,
				url: QodeAdminAjax.ajaxurl,
				success: function (data) {
					var response = JSON.parse(data);
					if(response.status == 'success'){
						albumPlayer(response.sdata, player);
					}
				}
			});
		};

		var albumPlayer = function(data, player) {
			var jPlayerSelector = '#'+player.find('.jp-jplayer').attr('id');
			var jCssSelectorAncestorSelector = '#'+player.find('.qode-audio-player-holder').attr('id');

			var playlist = new jPlayerPlaylist({
				jPlayer: jPlayerSelector,
				cssSelectorAncestor: jCssSelectorAncestorSelector
			}, data , {
				playlistOptions: {
					autoPlay: false
				},
				supplied: "mp3",
				wmode: "window",
				useStateClassSkin: true,
				autoBlur: false,
				smoothPlayBar: true,
				keyEnabled: true,
				ready: function() {
					setTrackTitle(playlist, player);
					playOnClickOnSingle(playlist)
				},
				play: function() {
					setTrackTitle(playlist, player);
					setActiveTrackOnSigle(playlist)
				}
			});

		};
		var setTrackTitle = function(playlist, player) {
			var titleHolder = player.find('.qode-audio-player-title');
			var artistHolder = player.find('.qode-audio-player-album');

			titleHolder.html(playlist.original[playlist.current].title);
			artistHolder.html(playlist.original[playlist.current].album_name);
		};
		var setActiveTrackOnSigle = function(playlist) {
			var activeSong = playlist.original[playlist.current].unique_id;
			var tracksSingleHolder = $('.qode-album-tracks-holder');
			if(tracksSingleHolder.length) {
				tracksSingleHolder.find('.qode-track-holder').removeClass('qode-active-track');
				tracksSingleHolder.find('.'+activeSong).addClass('qode-active-track');
			}
		};
		var playOnClickOnSingle = function(playlist) {
			var tracksSingleHolder = $('.qode-album-tracks-holder');
			if(tracksSingleHolder.length) {
				tracksSingleHolder.find('.qode-track-title').on('click', function(){
					var track = $(this);
					var trackIndex = track.data('track-index');
					playlist.play(trackIndex);
				});
			}

		};
		return {
			init: function() {
				if(players.length) {
					players.each(function() {
						albumPlaylist($(this));
					});
				}
			}
		};
	};

	function qodeAlbumPlayButton() {
		var albums = $('.qode-album-track-list');
		if (albums.length) {
			albums.each(function(){
				var album = $(this);
				var albumID = $(this).attr('id');
				var tracks = album.find('.qode-album-track');
				var audioTracks = tracks.find('audio');

				tracks.each(function(){
					var track = $(this);
					var playButton = track.find('.qode-at-play-button, .qode-at-title');

					var audioTrack = playButton.find('audio').get(0);
					playButton.on('click',function(){
						if(track.hasClass('qode-track-in-progress')){
							audioTrack.pause();
							track.addClass('qode-track-paused').removeClass('qode-track-in-progress');
						}else if(track.hasClass('qode-track-paused')) {
							audioTrack.play();
							track.addClass('qode-track-playing qode-track-in-progress').removeClass('qode-track-paused')
						}else{
							audioTracks.each(function(){
								this.pause();
								this.currentTime = 0;
							});
							tracks.removeClass('qode-track-playing qode-track-in-progress qode-track-paused');
							audioTrack.play();
							track.addClass('qode-track-playing qode-track-in-progress')
						}
					});

					track.find('audio').bind("ended", function(){
						track.removeClass('qode-track-playing qode-track-in-progress');
					});
				});
			});
		}
	}

	function qodeInitAlbumsLoadMore(){
		var albumsList = $('.qode-albums-list-holder-outer.qode-albums-load-more');

		if(albumsList.length){
			albumsList.each(function(){

				var thisAlbumList = $(this);
				var thisAlbumListInner = thisAlbumList.find('.qode-albums-list-holder');
				var nextPage;
				var maxNumPages;
				var loadMoreButton = thisAlbumList.find('.qode-albums-list-load-more a');

				if (typeof thisAlbumList.data('max-num-pages') !== 'undefined' && thisAlbumList.data('max-num-pages') !== false) {
					maxNumPages = thisAlbumList.data('max-num-pages');
				}

				loadMoreButton.on('click', function (e) {

					var loadMoreDatta = qodeGetAlbumsAjaxData(thisAlbumList);
					nextPage = loadMoreDatta.nextPage;
					e.preventDefault();
					e.stopPropagation();
					if(nextPage <= maxNumPages){
						var ajaxData = qodeSetAlbumsAjaxData(loadMoreDatta);
						$.ajax({
							type: 'POST',
							data: ajaxData,
							url: QodeAdminAjax.ajaxurl,
							success: function (data) {
								nextPage++;
								thisAlbumList.data('next-page', nextPage);
								var response = $.parseJSON(data);
								var responseHtml = response.html;
								thisAlbumList.waitForImages(function(){
									thisAlbumListInner.append(responseHtml);
								});
							}
						});
					}
					if(nextPage === maxNumPages){
						loadMoreButton.hide();
					}
				});

			});
		}
	}

	/**
	 * Initializes portfolio load more data params
	 * @param portfolio list container with defined data params
	 * return array
	 */
	function qodeGetAlbumsAjaxData(container){
		var returnValue = {};

		returnValue.type = '';
		returnValue.columns = '';
		returnValue.orderBy = '';
		returnValue.order = '';
		returnValue.number = '';
		returnValue.label = '';
		returnValue.genre = '';
		returnValue.artist = '';
		returnValue.selectedAlbums = '';
		returnValue.showLoadMore = '';
		returnValue.nextPage = '';
		returnValue.maxNumPages = '';
		returnValue.stores = '';

		if (typeof container.data('type') !== 'undefined' && container.data('type') !== false) {
			returnValue.type = container.data('type');
		}
		if (typeof container.data('columns') !== 'undefined' && container.data('columns') !== false) {
			returnValue.columns = container.data('columns');
		}
		if (typeof container.data('order-by') !== 'undefined' && container.data('order-by') !== false) {
			returnValue.orderBy = container.data('order-by');
		}
		if (typeof container.data('order') !== 'undefined' && container.data('order') !== false) {
			returnValue.order = container.data('order');
		}
		if (typeof container.data('number') !== 'undefined' && container.data('number') !== false) {
			returnValue.number = container.data('number');
		}
		if (typeof container.data('label') !== 'undefined' && container.data('label') !== false) {
			returnValue.category = container.data('label');
		}
		if (typeof container.data('genre') !== 'undefined' && container.data('genre') !== false) {
			returnValue.category = container.data('genre');
		}
		if (typeof container.data('artist') !== 'undefined' && container.data('artist') !== false) {
			returnValue.category = container.data('artist');
		}
		if (typeof container.data('selected-albums') !== 'undefined' && container.data('selected-albums') !== false) {
			returnValue.selectedAlbums = container.data('selected-albums');
		}
		if (typeof container.data('show-load-more') !== 'undefined' && container.data('show-load-more') !== false) {
			returnValue.showLoadMore = container.data('show-load-more');
		}
		if (typeof container.data('next-page') !== 'undefined' && container.data('next-page') !== false) {
			returnValue.nextPage = container.data('next-page');
		}
		if (typeof container.data('max-num-pages') !== 'undefined' && container.data('max-num-pages') !== false) {
			returnValue.maxNumPages = container.data('max-num-pages');
		}
		if (typeof container.data('stores-list') !== 'undefined' && container.data('stores-list') !== false) {
			returnValue.storesList = container.data('stores-list');
		}

		return returnValue;
	}


	/**
	 * Sets portfolio load more data params for ajax function
	 * @param portfolio list container with defined data params
	 * return array
	 */
	function qodeSetAlbumsAjaxData(container){
		var returnValue = {
			action: 'qode_core_albums_ajax_load_more',
			type: container.type,
			columns: container.columns,
			orderBy: container.orderBy,
			order: container.order,
			number: container.number,
			label: container.label,
			genre: container.genre,
			artist: container.artist,
			selectedAlbums: container.selectedAlbums,
			showLoadMore: container.showLoadMore,
			nextPage: container.nextPage,
			storesList: container.storesList
		};

		return returnValue;

	}


	function qodeAlbumFluidVideo() {
		fluidvids.init({
			selector: ['.single-qode-album .qode-latest-video iframe'],
			players: ['www.youtube.com', 'player.vimeo.com']
		});
	}
	
	//Elementor reinitialization
	function qodeInitElementorAlbumPlayer(){
		$j(window).on('elementor/frontend/init', function () {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_album_player.default', function() {
				qodeAudioPlayer().init();
				qodeAlbumPlayButton();
			} );
		});
	}
	
	function qodeInitElementorAlbum(){
		$j(window).on('elementor/frontend/init', function () {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_album.default', function() {
				console.log('nijeca');
				qodeAlbumPlayButton();
			} );
		});
	}
	
	function qodeInitElementorAlbumsList(){
		$j(window).on('elementor/frontend/init', function () {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_albums_list.default', function() {
				qodeInitAlbumsLoadMore();
			} );
		});
	}

})(jQuery);
