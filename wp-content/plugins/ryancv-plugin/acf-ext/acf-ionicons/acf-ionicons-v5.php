<?php

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

// check if class already exists
if( ! class_exists( 'acf_field_ryancv_ionicons' ) ) :

class acf_field_ryancv_ionicons extends acf_field {
	
	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	public function __construct() {
		
		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/
		
		$this->name = 'ionicons';

		$ION_FONTS = array(
			array('class' => 'none', 'content' => '', ),

			array('class' => 'alert', 'content' => '\f101', ),

			array('class' => 'alert-circled', 'content' => '\f100', ),

			array('class' => 'android-add', 'content' => '\f2c7', ),

			array('class' => 'android-add-circle', 'content' => '\f359', ),

			array('class' => 'android-alarm-clock', 'content' => '\f35a', ),

			array('class' => 'android-alert', 'content' => '\f35b', ),

			array('class' => 'android-apps', 'content' => '\f35c', ),

			array('class' => 'android-archive', 'content' => '\f2c9', ),

			array('class' => 'android-arrow-back', 'content' => '\f2ca', ),

			array('class' => 'android-arrow-down', 'content' => '\f35d', ),

			array('class' => 'android-arrow-dropdown', 'content' => '\f35f', ),

			array('class' => 'android-arrow-dropdown-circle', 'content' => '\f35e', ),

			array('class' => 'android-arrow-dropleft', 'content' => '\f361', ),

			array('class' => 'android-arrow-dropleft-circle', 'content' => '\f360', ),

			array('class' => 'android-arrow-dropright', 'content' => '\f363', ),

			array('class' => 'android-arrow-dropright-circle', 'content' => '\f362', ),

			array('class' => 'android-arrow-dropup', 'content' => '\f365', ),

			array('class' => 'android-arrow-dropup-circle', 'content' => '\f364', ),

			array('class' => 'android-arrow-forward', 'content' => '\f30f', ),

			array('class' => 'android-arrow-up', 'content' => '\f366', ),

			array('class' => 'android-attach', 'content' => '\f367', ),

			array('class' => 'android-bar', 'content' => '\f368', ),

			array('class' => 'android-bicycle', 'content' => '\f369', ),

			array('class' => 'android-boat', 'content' => '\f36a', ),

			array('class' => 'android-bookmark', 'content' => '\f36b', ),

			array('class' => 'android-bulb', 'content' => '\f36c', ),

			array('class' => 'android-bus', 'content' => '\f36d', ),

			array('class' => 'android-calendar', 'content' => '\f2d1', ),

			array('class' => 'android-call', 'content' => '\f2d2', ),

			array('class' => 'android-camera', 'content' => '\f2d3', ),

			array('class' => 'android-cancel', 'content' => '\f36e', ),

			array('class' => 'android-car', 'content' => '\f36f', ),

			array('class' => 'android-cart', 'content' => '\f370', ),

			array('class' => 'android-chat', 'content' => '\f2d4', ),

			array('class' => 'android-checkbox', 'content' => '\f374', ),

			array('class' => 'android-checkbox-blank', 'content' => '\f371', ),

			array('class' => 'android-checkbox-outline', 'content' => '\f373', ),

			array('class' => 'android-checkbox-outline-blank', 'content' => '\f372', ),

			array('class' => 'android-checkmark-circle', 'content' => '\f375', ),

			array('class' => 'android-clipboard', 'content' => '\f376', ),

			array('class' => 'android-close', 'content' => '\f2d7', ),

			array('class' => 'android-cloud', 'content' => '\f37a', ),

			array('class' => 'android-cloud-circle', 'content' => '\f377', ),

			array('class' => 'android-cloud-done', 'content' => '\f378', ),

			array('class' => 'android-cloud-outline', 'content' => '\f379', ),

			array('class' => 'android-color-palette', 'content' => '\f37b', ),

			array('class' => 'android-compass', 'content' => '\f37c', ),

			array('class' => 'android-contact', 'content' => '\f2d8', ),

			array('class' => 'android-contacts', 'content' => '\f2d9', ),

			array('class' => 'android-contract', 'content' => '\f37d', ),

			array('class' => 'android-create', 'content' => '\f37e', ),

			array('class' => 'android-delete', 'content' => '\f37f', ),

			array('class' => 'android-desktop', 'content' => '\f380', ),

			array('class' => 'android-document', 'content' => '\f381', ),

			array('class' => 'android-done', 'content' => '\f383', ),

			array('class' => 'android-done-all', 'content' => '\f382', ),

			array('class' => 'android-download', 'content' => '\f2dd', ),

			array('class' => 'android-drafts', 'content' => '\f384', ),

			array('class' => 'android-exit', 'content' => '\f385', ),

			array('class' => 'android-expand', 'content' => '\f386', ),

			array('class' => 'android-favorite', 'content' => '\f388', ),

			array('class' => 'android-favorite-outline', 'content' => '\f387', ),

			array('class' => 'android-film', 'content' => '\f389', ),

			array('class' => 'android-folder', 'content' => '\f2e0', ),

			array('class' => 'android-folder-open', 'content' => '\f38a', ),

			array('class' => 'android-funnel', 'content' => '\f38b', ),

			array('class' => 'android-globe', 'content' => '\f38c', ),

			array('class' => 'android-hand', 'content' => '\f2e3', ),

			array('class' => 'android-hangout', 'content' => '\f38d', ),

			array('class' => 'android-happy', 'content' => '\f38e', ),

			array('class' => 'android-home', 'content' => '\f38f', ),

			array('class' => 'android-image', 'content' => '\f2e4', ),

			array('class' => 'android-laptop', 'content' => '\f390', ),

			array('class' => 'android-list', 'content' => '\f391', ),

			array('class' => 'android-locate', 'content' => '\f2e9', ),

			array('class' => 'android-lock', 'content' => '\f392', ),

			array('class' => 'android-mail', 'content' => '\f2eb', ),

			array('class' => 'android-map', 'content' => '\f393', ),

			array('class' => 'android-menu', 'content' => '\f394', ),

			array('class' => 'android-microphone', 'content' => '\f2ec', ),

			array('class' => 'android-microphone-off', 'content' => '\f395', ),

			array('class' => 'android-more-horizontal', 'content' => '\f396', ),

			array('class' => 'android-more-vertical', 'content' => '\f397', ),

			array('class' => 'android-navigate', 'content' => '\f398', ),

			array('class' => 'android-notifications', 'content' => '\f39b', ),

			array('class' => 'android-notifications-none', 'content' => '\f399', ),

			array('class' => 'android-notifications-off', 'content' => '\f39a', ),

			array('class' => 'android-open', 'content' => '\f39c', ),

			array('class' => 'android-options', 'content' => '\f39d', ),

			array('class' => 'android-people', 'content' => '\f39e', ),

			array('class' => 'android-person', 'content' => '\f3a0', ),

			array('class' => 'android-person-add', 'content' => '\f39f', ),

			array('class' => 'android-phone-landscape', 'content' => '\f3a1', ),

			array('class' => 'android-phone-portrait', 'content' => '\f3a2', ),

			array('class' => 'android-pin', 'content' => '\f3a3', ),

			array('class' => 'android-plane', 'content' => '\f3a4', ),

			array('class' => 'android-playstore', 'content' => '\f2f0', ),

			array('class' => 'android-print', 'content' => '\f3a5', ),

			array('class' => 'android-radio-button-off', 'content' => '\f3a6', ),

			array('class' => 'android-radio-button-on', 'content' => '\f3a7', ),

			array('class' => 'android-refresh', 'content' => '\f3a8', ),

			array('class' => 'android-remove', 'content' => '\f2f4', ),

			array('class' => 'android-remove-circle', 'content' => '\f3a9', ),

			array('class' => 'android-restaurant', 'content' => '\f3aa', ),

			array('class' => 'android-sad', 'content' => '\f3ab', ),

			array('class' => 'android-search', 'content' => '\f2f5', ),

			array('class' => 'android-send', 'content' => '\f2f6', ),

			array('class' => 'android-settings', 'content' => '\f2f7', ),

			array('class' => 'android-share', 'content' => '\f2f8', ),

			array('class' => 'android-share-alt', 'content' => '\f3ac', ),

			array('class' => 'android-star', 'content' => '\f2fc', ),

			array('class' => 'android-star-half', 'content' => '\f3ad', ),

			array('class' => 'android-star-outline', 'content' => '\f3ae', ),

			array('class' => 'android-stopwatch', 'content' => '\f2fd', ),

			array('class' => 'android-subway', 'content' => '\f3af', ),

			array('class' => 'android-sunny', 'content' => '\f3b0', ),

			array('class' => 'android-sync', 'content' => '\f3b1', ),

			array('class' => 'android-textsms', 'content' => '\f3b2', ),

			array('class' => 'android-time', 'content' => '\f3b3', ),

			array('class' => 'android-train', 'content' => '\f3b4', ),

			array('class' => 'android-unlock', 'content' => '\f3b5', ),

			array('class' => 'android-upload', 'content' => '\f3b6', ),

			array('class' => 'android-volume-down', 'content' => '\f3b7', ),

			array('class' => 'android-volume-mute', 'content' => '\f3b8', ),

			array('class' => 'android-volume-off', 'content' => '\f3b9', ),

			array('class' => 'android-volume-up', 'content' => '\f3ba', ),

			array('class' => 'android-walk', 'content' => '\f3bb', ),

			array('class' => 'android-warning', 'content' => '\f3bc', ),

			array('class' => 'android-watch', 'content' => '\f3bd', ),

			array('class' => 'android-wifi', 'content' => '\f305', ),

			array('class' => 'aperture', 'content' => '\f313', ),

			array('class' => 'archive', 'content' => '\f102', ),

			array('class' => 'arrow-down-a', 'content' => '\f103', ),

			array('class' => 'arrow-down-b', 'content' => '\f104', ),

			array('class' => 'arrow-down-c', 'content' => '\f105', ),

			array('class' => 'arrow-expand', 'content' => '\f25e', ),

			array('class' => 'arrow-graph-down-left', 'content' => '\f25f', ),

			array('class' => 'arrow-graph-down-right', 'content' => '\f260', ),

			array('class' => 'arrow-graph-up-left', 'content' => '\f261', ),

			array('class' => 'arrow-graph-up-right', 'content' => '\f262', ),

			array('class' => 'arrow-left-a', 'content' => '\f106', ),

			array('class' => 'arrow-left-b', 'content' => '\f107', ),

			array('class' => 'arrow-left-c', 'content' => '\f108', ),

			array('class' => 'arrow-move', 'content' => '\f263', ),

			array('class' => 'arrow-resize', 'content' => '\f264', ),

			array('class' => 'arrow-return-left', 'content' => '\f265', ),

			array('class' => 'arrow-return-right', 'content' => '\f266', ),

			array('class' => 'arrow-right-a', 'content' => '\f109', ),

			array('class' => 'arrow-right-b', 'content' => '\f10a', ),

			array('class' => 'arrow-right-c', 'content' => '\f10b', ),

			array('class' => 'arrow-shrink', 'content' => '\f267', ),

			array('class' => 'arrow-swap', 'content' => '\f268', ),

			array('class' => 'arrow-up-a', 'content' => '\f10c', ),

			array('class' => 'arrow-up-b', 'content' => '\f10d', ),

			array('class' => 'arrow-up-c', 'content' => '\f10e', ),

			array('class' => 'asterisk', 'content' => '\f314', ),

			array('class' => 'at', 'content' => '\f10f', ),

			array('class' => 'backspace', 'content' => '\f3bf', ),

			array('class' => 'backspace-outline', 'content' => '\f3be', ),

			array('class' => 'bag', 'content' => '\f110', ),

			array('class' => 'battery-charging', 'content' => '\f111', ),

			array('class' => 'battery-empty', 'content' => '\f112', ),

			array('class' => 'battery-full', 'content' => '\f113', ),

			array('class' => 'battery-half', 'content' => '\f114', ),

			array('class' => 'battery-low', 'content' => '\f115', ),

			array('class' => 'beaker', 'content' => '\f269', ),

			array('class' => 'beer', 'content' => '\f26a', ),

			array('class' => 'bluetooth', 'content' => '\f116', ),

			array('class' => 'bonfire', 'content' => '\f315', ),

			array('class' => 'bookmark', 'content' => '\f26b', ),

			array('class' => 'bowtie', 'content' => '\f3c0', ),

			array('class' => 'briefcase', 'content' => '\f26c', ),

			array('class' => 'bug', 'content' => '\f2be', ),

			array('class' => 'calculator', 'content' => '\f26d', ),

			array('class' => 'calendar', 'content' => '\f117', ),

			array('class' => 'camera', 'content' => '\f118', ),

			array('class' => 'card', 'content' => '\f119', ),

			array('class' => 'cash', 'content' => '\f316', ),

			array('class' => 'chatbox', 'content' => '\f11b', ),

			array('class' => 'chatbox-working', 'content' => '\f11a', ),

			array('class' => 'chatboxes', 'content' => '\f11c', ),

			array('class' => 'chatbubble', 'content' => '\f11e', ),

			array('class' => 'chatbubble-working', 'content' => '\f11d', ),

			array('class' => 'chatbubbles', 'content' => '\f11f', ),

			array('class' => 'checkmark', 'content' => '\f122', ),

			array('class' => 'checkmark-circled', 'content' => '\f120', ),

			array('class' => 'checkmark-round', 'content' => '\f121', ),

			array('class' => 'chevron-down', 'content' => '\f123', ),

			array('class' => 'chevron-left', 'content' => '\f124', ),

			array('class' => 'chevron-right', 'content' => '\f125', ),

			array('class' => 'chevron-up', 'content' => '\f126', ),

			array('class' => 'clipboard', 'content' => '\f127', ),

			array('class' => 'clock', 'content' => '\f26e', ),

			array('class' => 'close', 'content' => '\f12a', ),

			array('class' => 'close-circled', 'content' => '\f128', ),

			array('class' => 'close-round', 'content' => '\f129', ),

			array('class' => 'closed-captioning', 'content' => '\f317', ),

			array('class' => 'cloud', 'content' => '\f12b', ),

			array('class' => 'code', 'content' => '\f271', ),

			array('class' => 'code-download', 'content' => '\f26f', ),

			array('class' => 'code-working', 'content' => '\f270', ),

			array('class' => 'coffee', 'content' => '\f272', ),

			array('class' => 'compass', 'content' => '\f273', ),

			array('class' => 'compose', 'content' => '\f12c', ),

			array('class' => 'connection-bars', 'content' => '\f274', ),

			array('class' => 'contrast', 'content' => '\f275', ),

			array('class' => 'crop', 'content' => '\f3c1', ),

			array('class' => 'cube', 'content' => '\f318', ),

			array('class' => 'disc', 'content' => '\f12d', ),

			array('class' => 'document', 'content' => '\f12f', ),

			array('class' => 'document-text', 'content' => '\f12e', ),

			array('class' => 'drag', 'content' => '\f130', ),

			array('class' => 'earth', 'content' => '\f276', ),

			array('class' => 'easel', 'content' => '\f3c2', ),

			array('class' => 'edit', 'content' => '\f2bf', ),

			array('class' => 'egg', 'content' => '\f277', ),

			array('class' => 'eject', 'content' => '\f131', ),

			array('class' => 'email', 'content' => '\f132', ),

			array('class' => 'email-unread', 'content' => '\f3c3', ),

			array('class' => 'erlenmeyer-flask', 'content' => '\f3c5', ),

			array('class' => 'erlenmeyer-flask-bubbles', 'content' => '\f3c4', ),

			array('class' => 'eye', 'content' => '\f133', ),

			array('class' => 'eye-disabled', 'content' => '\f306', ),

			array('class' => 'female', 'content' => '\f278', ),

			array('class' => 'filing', 'content' => '\f134', ),

			array('class' => 'film-marker', 'content' => '\f135', ),

			array('class' => 'fireball', 'content' => '\f319', ),

			array('class' => 'flag', 'content' => '\f279', ),

			array('class' => 'flame', 'content' => '\f31a', ),

			array('class' => 'flash', 'content' => '\f137', ),

			array('class' => 'flash-off', 'content' => '\f136', ),

			array('class' => 'folder', 'content' => '\f139', ),

			array('class' => 'fork', 'content' => '\f27a', ),

			array('class' => 'fork-repo', 'content' => '\f2c0', ),

			array('class' => 'forward', 'content' => '\f13a', ),

			array('class' => 'funnel', 'content' => '\f31b', ),

			array('class' => 'gear-a', 'content' => '\f13d', ),

			array('class' => 'gear-b', 'content' => '\f13e', ),

			array('class' => 'grid', 'content' => '\f13f', ),

			array('class' => 'hammer', 'content' => '\f27b', ),

			array('class' => 'happy', 'content' => '\f31c', ),

			array('class' => 'happy-outline', 'content' => '\f3c6', ),

			array('class' => 'headphone', 'content' => '\f140', ),

			array('class' => 'heart', 'content' => '\f141', ),

			array('class' => 'heart-broken', 'content' => '\f31d', ),

			array('class' => 'help', 'content' => '\f143', ),

			array('class' => 'help-buoy', 'content' => '\f27c', ),

			array('class' => 'help-circled', 'content' => '\f142', ),

			array('class' => 'home', 'content' => '\f144', ),

			array('class' => 'icecream', 'content' => '\f27d', ),

			array('class' => 'image', 'content' => '\f147', ),

			array('class' => 'images', 'content' => '\f148', ),

			array('class' => 'information', 'content' => '\f14a', ),

			array('class' => 'information-circled', 'content' => '\f149', ),

			array('class' => 'ionic', 'content' => '\f14b', ),

			array('class' => 'ios-alarm', 'content' => '\f3c8', ),

			array('class' => 'ios-alarm-outline', 'content' => '\f3c7', ),

			array('class' => 'ios-albums', 'content' => '\f3ca', ),

			array('class' => 'ios-albums-outline', 'content' => '\f3c9', ),

			array('class' => 'ios-americanfootball', 'content' => '\f3cc', ),

			array('class' => 'ios-americanfootball-outline', 'content' => '\f3cb', ),

			array('class' => 'ios-analytics', 'content' => '\f3ce', ),

			array('class' => 'ios-analytics-outline', 'content' => '\f3cd', ),

			array('class' => 'ios-arrow-back', 'content' => '\f3cf', ),

			array('class' => 'ios-arrow-down', 'content' => '\f3d0', ),

			array('class' => 'ios-arrow-forward', 'content' => '\f3d1', ),

			array('class' => 'ios-arrow-left', 'content' => '\f3d2', ),

			array('class' => 'ios-arrow-right', 'content' => '\f3d3', ),

			array('class' => 'ios-arrow-thin-down', 'content' => '\f3d4', ),

			array('class' => 'ios-arrow-thin-left', 'content' => '\f3d5', ),

			array('class' => 'ios-arrow-thin-right', 'content' => '\f3d6', ),

			array('class' => 'ios-arrow-thin-up', 'content' => '\f3d7', ),

			array('class' => 'ios-arrow-up', 'content' => '\f3d8', ),

			array('class' => 'ios-at', 'content' => '\f3da', ),

			array('class' => 'ios-at-outline', 'content' => '\f3d9', ),

			array('class' => 'ios-barcode', 'content' => '\f3dc', ),

			array('class' => 'ios-barcode-outline', 'content' => '\f3db', ),

			array('class' => 'ios-baseball', 'content' => '\f3de', ),

			array('class' => 'ios-baseball-outline', 'content' => '\f3dd', ),

			array('class' => 'ios-basketball', 'content' => '\f3e0', ),

			array('class' => 'ios-basketball-outline', 'content' => '\f3df', ),

			array('class' => 'ios-bell', 'content' => '\f3e2', ),

			array('class' => 'ios-bell-outline', 'content' => '\f3e1', ),

			array('class' => 'ios-body', 'content' => '\f3e4', ),

			array('class' => 'ios-body-outline', 'content' => '\f3e3', ),

			array('class' => 'ios-bolt', 'content' => '\f3e6', ),

			array('class' => 'ios-bolt-outline', 'content' => '\f3e5', ),

			array('class' => 'ios-book', 'content' => '\f3e8', ),

			array('class' => 'ios-book-outline', 'content' => '\f3e7', ),

			array('class' => 'ios-bookmarks', 'content' => '\f3ea', ),

			array('class' => 'ios-bookmarks-outline', 'content' => '\f3e9', ),

			array('class' => 'ios-box', 'content' => '\f3ec', ),

			array('class' => 'ios-box-outline', 'content' => '\f3eb', ),

			array('class' => 'ios-briefcase', 'content' => '\f3ee', ),

			array('class' => 'ios-briefcase-outline', 'content' => '\f3ed', ),

			array('class' => 'ios-browsers', 'content' => '\f3f0', ),

			array('class' => 'ios-browsers-outline', 'content' => '\f3ef', ),

			array('class' => 'ios-calculator', 'content' => '\f3f2', ),

			array('class' => 'ios-calculator-outline', 'content' => '\f3f1', ),

			array('class' => 'ios-calendar', 'content' => '\f3f4', ),

			array('class' => 'ios-calendar-outline', 'content' => '\f3f3', ),

			array('class' => 'ios-camera', 'content' => '\f3f6', ),

			array('class' => 'ios-camera-outline', 'content' => '\f3f5', ),

			array('class' => 'ios-cart', 'content' => '\f3f8', ),

			array('class' => 'ios-cart-outline', 'content' => '\f3f7', ),

			array('class' => 'ios-chatboxes', 'content' => '\f3fa', ),

			array('class' => 'ios-chatboxes-outline', 'content' => '\f3f9', ),

			array('class' => 'ios-chatbubble', 'content' => '\f3fc', ),

			array('class' => 'ios-chatbubble-outline', 'content' => '\f3fb', ),

			array('class' => 'ios-checkmark', 'content' => '\f3ff', ),

			array('class' => 'ios-checkmark-empty', 'content' => '\f3fd', ),

			array('class' => 'ios-checkmark-outline', 'content' => '\f3fe', ),

			array('class' => 'ios-circle-filled', 'content' => '\f400', ),

			array('class' => 'ios-circle-outline', 'content' => '\f401', ),

			array('class' => 'ios-clock', 'content' => '\f403', ),

			array('class' => 'ios-clock-outline', 'content' => '\f402', ),

			array('class' => 'ios-close', 'content' => '\f406', ),

			array('class' => 'ios-close-empty', 'content' => '\f404', ),

			array('class' => 'ios-close-outline', 'content' => '\f405', ),

			array('class' => 'ios-cloud', 'content' => '\f40c', ),

			array('class' => 'ios-cloud-download', 'content' => '\f408', ),

			array('class' => 'ios-cloud-download-outline', 'content' => '\f407', ),

			array('class' => 'ios-cloud-outline', 'content' => '\f409', ),

			array('class' => 'ios-cloud-upload', 'content' => '\f40b', ),

			array('class' => 'ios-cloud-upload-outline', 'content' => '\f40a', ),

			array('class' => 'ios-cloudy', 'content' => '\f410', ),

			array('class' => 'ios-cloudy-night', 'content' => '\f40e', ),

			array('class' => 'ios-cloudy-night-outline', 'content' => '\f40d', ),

			array('class' => 'ios-cloudy-outline', 'content' => '\f40f', ),

			array('class' => 'ios-cog', 'content' => '\f412', ),

			array('class' => 'ios-cog-outline', 'content' => '\f411', ),

			array('class' => 'ios-color-filter', 'content' => '\f414', ),

			array('class' => 'ios-color-filter-outline', 'content' => '\f413', ),

			array('class' => 'ios-color-wand', 'content' => '\f416', ),

			array('class' => 'ios-color-wand-outline', 'content' => '\f415', ),

			array('class' => 'ios-compose', 'content' => '\f418', ),

			array('class' => 'ios-compose-outline', 'content' => '\f417', ),

			array('class' => 'ios-contact', 'content' => '\f41a', ),

			array('class' => 'ios-contact-outline', 'content' => '\f419', ),

			array('class' => 'ios-copy', 'content' => '\f41c', ),

			array('class' => 'ios-copy-outline', 'content' => '\f41b', ),

			array('class' => 'ios-crop', 'content' => '\f41e', ),

			array('class' => 'ios-crop-strong', 'content' => '\f41d', ),

			array('class' => 'ios-download', 'content' => '\f420', ),

			array('class' => 'ios-download-outline', 'content' => '\f41f', ),

			array('class' => 'ios-drag', 'content' => '\f421', ),

			array('class' => 'ios-email', 'content' => '\f423', ),

			array('class' => 'ios-email-outline', 'content' => '\f422', ),

			array('class' => 'ios-eye', 'content' => '\f425', ),

			array('class' => 'ios-eye-outline', 'content' => '\f424', ),

			array('class' => 'ios-fastforward', 'content' => '\f427', ),

			array('class' => 'ios-fastforward-outline', 'content' => '\f426', ),

			array('class' => 'ios-filing', 'content' => '\f429', ),

			array('class' => 'ios-filing-outline', 'content' => '\f428', ),

			array('class' => 'ios-film', 'content' => '\f42b', ),

			array('class' => 'ios-film-outline', 'content' => '\f42a', ),

			array('class' => 'ios-flag', 'content' => '\f42d', ),

			array('class' => 'ios-flag-outline', 'content' => '\f42c', ),

			array('class' => 'ios-flame', 'content' => '\f42f', ),

			array('class' => 'ios-flame-outline', 'content' => '\f42e', ),

			array('class' => 'ios-flask', 'content' => '\f431', ),

			array('class' => 'ios-flask-outline', 'content' => '\f430', ),

			array('class' => 'ios-flower', 'content' => '\f433', ),

			array('class' => 'ios-flower-outline', 'content' => '\f432', ),

			array('class' => 'ios-folder', 'content' => '\f435', ),

			array('class' => 'ios-folder-outline', 'content' => '\f434', ),

			array('class' => 'ios-football', 'content' => '\f437', ),

			array('class' => 'ios-football-outline', 'content' => '\f436', ),

			array('class' => 'ios-game-controller-a', 'content' => '\f439', ),

			array('class' => 'ios-game-controller-a-outline', 'content' => '\f438', ),

			array('class' => 'ios-game-controller-b', 'content' => '\f43b', ),

			array('class' => 'ios-game-controller-b-outline', 'content' => '\f43a', ),

			array('class' => 'ios-gear', 'content' => '\f43d', ),

			array('class' => 'ios-gear-outline', 'content' => '\f43c', ),

			array('class' => 'ios-glasses', 'content' => '\f43f', ),

			array('class' => 'ios-glasses-outline', 'content' => '\f43e', ),

			array('class' => 'ios-grid-view', 'content' => '\f441', ),

			array('class' => 'ios-grid-view-outline', 'content' => '\f440', ),

			array('class' => 'ios-heart', 'content' => '\f443', ),

			array('class' => 'ios-heart-outline', 'content' => '\f442', ),

			array('class' => 'ios-help', 'content' => '\f446', ),

			array('class' => 'ios-help-empty', 'content' => '\f444', ),

			array('class' => 'ios-help-outline', 'content' => '\f445', ),

			array('class' => 'ios-home', 'content' => '\f448', ),

			array('class' => 'ios-home-outline', 'content' => '\f447', ),

			array('class' => 'ios-infinite', 'content' => '\f44a', ),

			array('class' => 'ios-infinite-outline', 'content' => '\f449', ),

			array('class' => 'ios-information', 'content' => '\f44d', ),

			array('class' => 'ios-information-empty', 'content' => '\f44b', ),

			array('class' => 'ios-information-outline', 'content' => '\f44c', ),

			array('class' => 'ios-ionic-outline', 'content' => '\f44e', ),

			array('class' => 'ios-keypad', 'content' => '\f450', ),

			array('class' => 'ios-keypad-outline', 'content' => '\f44f', ),

			array('class' => 'ios-lightbulb', 'content' => '\f452', ),

			array('class' => 'ios-lightbulb-outline', 'content' => '\f451', ),

			array('class' => 'ios-list', 'content' => '\f454', ),

			array('class' => 'ios-list-outline', 'content' => '\f453', ),

			array('class' => 'ios-location', 'content' => '\f456', ),

			array('class' => 'ios-location-outline', 'content' => '\f455', ),

			array('class' => 'ios-locked', 'content' => '\f458', ),

			array('class' => 'ios-locked-outline', 'content' => '\f457', ),

			array('class' => 'ios-loop', 'content' => '\f45a', ),

			array('class' => 'ios-loop-strong', 'content' => '\f459', ),

			array('class' => 'ios-medical', 'content' => '\f45c', ),

			array('class' => 'ios-medical-outline', 'content' => '\f45b', ),

			array('class' => 'ios-medkit', 'content' => '\f45e', ),

			array('class' => 'ios-medkit-outline', 'content' => '\f45d', ),

			array('class' => 'ios-mic', 'content' => '\f461', ),

			array('class' => 'ios-mic-off', 'content' => '\f45f', ),

			array('class' => 'ios-mic-outline', 'content' => '\f460', ),

			array('class' => 'ios-minus', 'content' => '\f464', ),

			array('class' => 'ios-minus-empty', 'content' => '\f462', ),

			array('class' => 'ios-minus-outline', 'content' => '\f463', ),

			array('class' => 'ios-monitor', 'content' => '\f466', ),

			array('class' => 'ios-monitor-outline', 'content' => '\f465', ),

			array('class' => 'ios-moon', 'content' => '\f468', ),

			array('class' => 'ios-moon-outline', 'content' => '\f467', ),

			array('class' => 'ios-more', 'content' => '\f46a', ),

			array('class' => 'ios-more-outline', 'content' => '\f469', ),

			array('class' => 'ios-musical-note', 'content' => '\f46b', ),

			array('class' => 'ios-musical-notes', 'content' => '\f46c', ),

			array('class' => 'ios-navigate', 'content' => '\f46e', ),

			array('class' => 'ios-navigate-outline', 'content' => '\f46d', ),

			array('class' => 'ios-nutrition', 'content' => '\f470', ),

			array('class' => 'ios-nutrition-outline', 'content' => '\f46f', ),

			array('class' => 'ios-paper', 'content' => '\f472', ),

			array('class' => 'ios-paper-outline', 'content' => '\f471', ),

			array('class' => 'ios-paperplane', 'content' => '\f474', ),

			array('class' => 'ios-paperplane-outline', 'content' => '\f473', ),

			array('class' => 'ios-partlysunny', 'content' => '\f476', ),

			array('class' => 'ios-partlysunny-outline', 'content' => '\f475', ),

			array('class' => 'ios-pause', 'content' => '\f478', ),

			array('class' => 'ios-pause-outline', 'content' => '\f477', ),

			array('class' => 'ios-paw', 'content' => '\f47a', ),

			array('class' => 'ios-paw-outline', 'content' => '\f479', ),

			array('class' => 'ios-people', 'content' => '\f47c', ),

			array('class' => 'ios-people-outline', 'content' => '\f47b', ),

			array('class' => 'ios-person', 'content' => '\f47e', ),

			array('class' => 'ios-person-outline', 'content' => '\f47d', ),

			array('class' => 'ios-personadd', 'content' => '\f480', ),

			array('class' => 'ios-personadd-outline', 'content' => '\f47f', ),

			array('class' => 'ios-photos', 'content' => '\f482', ),

			array('class' => 'ios-photos-outline', 'content' => '\f481', ),

			array('class' => 'ios-pie', 'content' => '\f484', ),

			array('class' => 'ios-pie-outline', 'content' => '\f483', ),

			array('class' => 'ios-pint', 'content' => '\f486', ),

			array('class' => 'ios-pint-outline', 'content' => '\f485', ),

			array('class' => 'ios-play', 'content' => '\f488', ),

			array('class' => 'ios-play-outline', 'content' => '\f487', ),

			array('class' => 'ios-plus', 'content' => '\f48b', ),

			array('class' => 'ios-plus-empty', 'content' => '\f489', ),

			array('class' => 'ios-plus-outline', 'content' => '\f48a', ),

			array('class' => 'ios-pricetag', 'content' => '\f48d', ),

			array('class' => 'ios-pricetag-outline', 'content' => '\f48c', ),

			array('class' => 'ios-pricetags', 'content' => '\f48f', ),

			array('class' => 'ios-pricetags-outline', 'content' => '\f48e', ),

			array('class' => 'ios-printer', 'content' => '\f491', ),

			array('class' => 'ios-printer-outline', 'content' => '\f490', ),

			array('class' => 'ios-pulse', 'content' => '\f493', ),

			array('class' => 'ios-pulse-strong', 'content' => '\f492', ),

			array('class' => 'ios-rainy', 'content' => '\f495', ),

			array('class' => 'ios-rainy-outline', 'content' => '\f494', ),

			array('class' => 'ios-recording', 'content' => '\f497', ),

			array('class' => 'ios-recording-outline', 'content' => '\f496', ),

			array('class' => 'ios-redo', 'content' => '\f499', ),

			array('class' => 'ios-redo-outline', 'content' => '\f498', ),

			array('class' => 'ios-refresh', 'content' => '\f49c', ),

			array('class' => 'ios-refresh-empty', 'content' => '\f49a', ),

			array('class' => 'ios-refresh-outline', 'content' => '\f49b', ),

			array('class' => 'ios-reload', 'content' => '\f49d', ),

			array('class' => 'ios-reverse-camera', 'content' => '\f49f', ),

			array('class' => 'ios-reverse-camera-outline', 'content' => '\f49e', ),

			array('class' => 'ios-rewind', 'content' => '\f4a1', ),

			array('class' => 'ios-rewind-outline', 'content' => '\f4a0', ),

			array('class' => 'ios-rose', 'content' => '\f4a3', ),

			array('class' => 'ios-rose-outline', 'content' => '\f4a2', ),

			array('class' => 'ios-search', 'content' => '\f4a5', ),

			array('class' => 'ios-search-strong', 'content' => '\f4a4', ),

			array('class' => 'ios-settings', 'content' => '\f4a7', ),

			array('class' => 'ios-settings-strong', 'content' => '\f4a6', ),

			array('class' => 'ios-shuffle', 'content' => '\f4a9', ),

			array('class' => 'ios-shuffle-strong', 'content' => '\f4a8', ),

			array('class' => 'ios-skipbackward', 'content' => '\f4ab', ),

			array('class' => 'ios-skipbackward-outline', 'content' => '\f4aa', ),

			array('class' => 'ios-skipforward', 'content' => '\f4ad', ),

			array('class' => 'ios-skipforward-outline', 'content' => '\f4ac', ),

			array('class' => 'ios-snowy', 'content' => '\f4ae', ),

			array('class' => 'ios-speedometer', 'content' => '\f4b0', ),

			array('class' => 'ios-speedometer-outline', 'content' => '\f4af', ),

			array('class' => 'ios-star', 'content' => '\f4b3', ),

			array('class' => 'ios-star-half', 'content' => '\f4b1', ),

			array('class' => 'ios-star-outline', 'content' => '\f4b2', ),

			array('class' => 'ios-stopwatch', 'content' => '\f4b5', ),

			array('class' => 'ios-stopwatch-outline', 'content' => '\f4b4', ),

			array('class' => 'ios-sunny', 'content' => '\f4b7', ),

			array('class' => 'ios-sunny-outline', 'content' => '\f4b6', ),

			array('class' => 'ios-telephone', 'content' => '\f4b9', ),

			array('class' => 'ios-telephone-outline', 'content' => '\f4b8', ),

			array('class' => 'ios-tennisball', 'content' => '\f4bb', ),

			array('class' => 'ios-tennisball-outline', 'content' => '\f4ba', ),

			array('class' => 'ios-thunderstorm', 'content' => '\f4bd', ),

			array('class' => 'ios-thunderstorm-outline', 'content' => '\f4bc', ),

			array('class' => 'ios-time', 'content' => '\f4bf', ),

			array('class' => 'ios-time-outline', 'content' => '\f4be', ),

			array('class' => 'ios-timer', 'content' => '\f4c1', ),

			array('class' => 'ios-timer-outline', 'content' => '\f4c0', ),

			array('class' => 'ios-toggle', 'content' => '\f4c3', ),

			array('class' => 'ios-toggle-outline', 'content' => '\f4c2', ),

			array('class' => 'ios-trash', 'content' => '\f4c5', ),

			array('class' => 'ios-trash-outline', 'content' => '\f4c4', ),

			array('class' => 'ios-undo', 'content' => '\f4c7', ),

			array('class' => 'ios-undo-outline', 'content' => '\f4c6', ),

			array('class' => 'ios-unlocked', 'content' => '\f4c9', ),

			array('class' => 'ios-unlocked-outline', 'content' => '\f4c8', ),

			array('class' => 'ios-upload', 'content' => '\f4cb', ),

			array('class' => 'ios-upload-outline', 'content' => '\f4ca', ),

			array('class' => 'ios-videocam', 'content' => '\f4cd', ),

			array('class' => 'ios-videocam-outline', 'content' => '\f4cc', ),

			array('class' => 'ios-volume-high', 'content' => '\f4ce', ),

			array('class' => 'ios-volume-low', 'content' => '\f4cf', ),

			array('class' => 'ios-wineglass', 'content' => '\f4d1', ),

			array('class' => 'ios-wineglass-outline', 'content' => '\f4d0', ),

			array('class' => 'ios-world', 'content' => '\f4d3', ),

			array('class' => 'ios-world-outline', 'content' => '\f4d2', ),

			array('class' => 'ipad', 'content' => '\f1f9', ),

			array('class' => 'iphone', 'content' => '\f1fa', ),

			array('class' => 'ipod', 'content' => '\f1fb', ),

			array('class' => 'jet', 'content' => '\f295', ),

			array('class' => 'key', 'content' => '\f296', ),

			array('class' => 'knife', 'content' => '\f297', ),

			array('class' => 'laptop', 'content' => '\f1fc', ),

			array('class' => 'leaf', 'content' => '\f1fd', ),

			array('class' => 'levels', 'content' => '\f298', ),

			array('class' => 'lightbulb', 'content' => '\f299', ),

			array('class' => 'link', 'content' => '\f1fe', ),

			array('class' => 'load-a', 'content' => '\f29a', ),

			array('class' => 'load-b', 'content' => '\f29b', ),

			array('class' => 'load-c', 'content' => '\f29c', ),

			array('class' => 'load-d', 'content' => '\f29d', ),

			array('class' => 'location', 'content' => '\f1ff', ),

			array('class' => 'lock-combination', 'content' => '\f4d4', ),

			array('class' => 'locked', 'content' => '\f200', ),

			array('class' => 'log-in', 'content' => '\f29e', ),

			array('class' => 'log-out', 'content' => '\f29f', ),

			array('class' => 'loop', 'content' => '\f201', ),

			array('class' => 'magnet', 'content' => '\f2a0', ),

			array('class' => 'male', 'content' => '\f2a1', ),

			array('class' => 'man', 'content' => '\f202', ),

			array('class' => 'map', 'content' => '\f203', ),

			array('class' => 'medkit', 'content' => '\f2a2', ),

			array('class' => 'merge', 'content' => '\f33f', ),

			array('class' => 'mic-a', 'content' => '\f204', ),

			array('class' => 'mic-b', 'content' => '\f205', ),

			array('class' => 'mic-c', 'content' => '\f206', ),

			array('class' => 'minus', 'content' => '\f209', ),

			array('class' => 'minus-circled', 'content' => '\f207', ),

			array('class' => 'minus-round', 'content' => '\f208', ),

			array('class' => 'model-s', 'content' => '\f2c1', ),

			array('class' => 'monitor', 'content' => '\f20a', ),

			array('class' => 'more', 'content' => '\f20b', ),

			array('class' => 'mouse', 'content' => '\f340', ),

			array('class' => 'music-note', 'content' => '\f20c', ),

			array('class' => 'navicon', 'content' => '\f20e', ),

			array('class' => 'navicon-round', 'content' => '\f20d', ),

			array('class' => 'navigate', 'content' => '\f2a3', ),

			array('class' => 'network', 'content' => '\f341', ),

			array('class' => 'no-smoking', 'content' => '\f2c2', ),

			array('class' => 'nuclear', 'content' => '\f2a4', ),

			array('class' => 'outlet', 'content' => '\f342', ),

			array('class' => 'paintbrush', 'content' => '\f4d5', ),

			array('class' => 'paintbucket', 'content' => '\f4d6', ),

			array('class' => 'paper-airplane', 'content' => '\f2c3', ),

			array('class' => 'paperclip', 'content' => '\f20f', ),

			array('class' => 'pause', 'content' => '\f210', ),

			array('class' => 'person', 'content' => '\f213', ),

			array('class' => 'person-add', 'content' => '\f211', ),

			array('class' => 'person-stalker', 'content' => '\f212', ),

			array('class' => 'pie-graph', 'content' => '\f2a5', ),

			array('class' => 'pin', 'content' => '\f2a6', ),

			array('class' => 'pinpoint', 'content' => '\f2a7', ),

			array('class' => 'pizza', 'content' => '\f2a8', ),

			array('class' => 'plane', 'content' => '\f214', ),

			array('class' => 'planet', 'content' => '\f343', ),

			array('class' => 'play', 'content' => '\f215', ),

			array('class' => 'playstation', 'content' => '\f30a', ),

			array('class' => 'plus', 'content' => '\f218', ),

			array('class' => 'plus-circled', 'content' => '\f216', ),

			array('class' => 'plus-round', 'content' => '\f217', ),

			array('class' => 'podium', 'content' => '\f344', ),

			array('class' => 'pound', 'content' => '\f219', ),

			array('class' => 'power', 'content' => '\f2a9', ),

			array('class' => 'pricetag', 'content' => '\f2aa', ),

			array('class' => 'pricetags', 'content' => '\f2ab', ),

			array('class' => 'printer', 'content' => '\f21a', ),

			array('class' => 'pull-request', 'content' => '\f345', ),

			array('class' => 'qr-scanner', 'content' => '\f346', ),

			array('class' => 'quote', 'content' => '\f347', ),

			array('class' => 'radio-waves', 'content' => '\f2ac', ),

			array('class' => 'record', 'content' => '\f21b', ),

			array('class' => 'refresh', 'content' => '\f21c', ),

			array('class' => 'reply', 'content' => '\f21e', ),

			array('class' => 'reply-all', 'content' => '\f21d', ),

			array('class' => 'ribbon-a', 'content' => '\f348', ),

			array('class' => 'ribbon-b', 'content' => '\f349', ),

			array('class' => 'sad', 'content' => '\f34a', ),

			array('class' => 'sad-outline', 'content' => '\f4d7', ),

			array('class' => 'scissors', 'content' => '\f34b', ),

			array('class' => 'search', 'content' => '\f21f', ),

			array('class' => 'settings', 'content' => '\f2ad', ),

			array('class' => 'share', 'content' => '\f220', ),

			array('class' => 'shuffle', 'content' => '\f221', ),

			array('class' => 'skip-backward', 'content' => '\f222', ),

			array('class' => 'skip-forward', 'content' => '\f223', ),

			array('class' => 'social-android', 'content' => '\f225', ),

			array('class' => 'social-android-outline', 'content' => '\f224', ),

			array('class' => 'social-angular', 'content' => '\f4d9', ),

			array('class' => 'social-angular-outline', 'content' => '\f4d8', ),

			array('class' => 'social-apple', 'content' => '\f227', ),

			array('class' => 'social-apple-outline', 'content' => '\f226', ),

			array('class' => 'social-bitcoin', 'content' => '\f2af', ),

			array('class' => 'social-bitcoin-outline', 'content' => '\f2ae', ),

			array('class' => 'social-buffer', 'content' => '\f229', ),

			array('class' => 'social-buffer-outline', 'content' => '\f228', ),

			array('class' => 'social-chrome', 'content' => '\f4db', ),

			array('class' => 'social-chrome-outline', 'content' => '\f4da', ),

			array('class' => 'social-codepen', 'content' => '\f4dd', ),

			array('class' => 'social-codepen-outline', 'content' => '\f4dc', ),

			array('class' => 'social-css3', 'content' => '\f4df', ),

			array('class' => 'social-css3-outline', 'content' => '\f4de', ),

			array('class' => 'social-designernews', 'content' => '\f22b', ),

			array('class' => 'social-designernews-outline', 'content' => '\f22a', ),

			array('class' => 'social-dribbble', 'content' => '\f22d', ),

			array('class' => 'social-dribbble-outline', 'content' => '\f22c', ),

			array('class' => 'social-dropbox', 'content' => '\f22f', ),

			array('class' => 'social-dropbox-outline', 'content' => '\f22e', ),

			array('class' => 'social-euro', 'content' => '\f4e1', ),

			array('class' => 'social-euro-outline', 'content' => '\f4e0', ),

			array('class' => 'social-facebook', 'content' => '\f231', ),

			array('class' => 'social-facebook-outline', 'content' => '\f230', ),

			array('class' => 'social-foursquare', 'content' => '\f34d', ),

			array('class' => 'social-foursquare-outline', 'content' => '\f34c', ),

			array('class' => 'social-freebsd-devil', 'content' => '\f2c4', ),

			array('class' => 'social-github', 'content' => '\f233', ),

			array('class' => 'social-github-outline', 'content' => '\f232', ),

			array('class' => 'social-google', 'content' => '\f34f', ),

			array('class' => 'social-google-outline', 'content' => '\f34e', ),

			array('class' => 'social-googleplus', 'content' => '\f235', ),

			array('class' => 'social-googleplus-outline', 'content' => '\f234', ),

			array('class' => 'social-hackernews', 'content' => '\f237', ),

			array('class' => 'social-hackernews-outline', 'content' => '\f236', ),

			array('class' => 'social-html5', 'content' => '\f4e3', ),

			array('class' => 'social-html5-outline', 'content' => '\f4e2', ),

			array('class' => 'social-instagram', 'content' => '\f351', ),

			array('class' => 'social-instagram-outline', 'content' => '\f350', ),

			array('class' => 'social-javascript', 'content' => '\f4e5', ),

			array('class' => 'social-javascript-outline', 'content' => '\f4e4', ),

			array('class' => 'social-linkedin', 'content' => '\f239', ),

			array('class' => 'social-linkedin-outline', 'content' => '\f238', ),

			array('class' => 'social-markdown', 'content' => '\f4e6', ),

			array('class' => 'social-nodejs', 'content' => '\f4e7', ),

			array('class' => 'social-octocat', 'content' => '\f4e8', ),

			array('class' => 'social-pinterest', 'content' => '\f2b1', ),

			array('class' => 'social-pinterest-outline', 'content' => '\f2b0', ),

			array('class' => 'social-python', 'content' => '\f4e9', ),

			array('class' => 'social-reddit', 'content' => '\f23b', ),

			array('class' => 'social-reddit-outline', 'content' => '\f23a', ),

			array('class' => 'social-rss', 'content' => '\f23d', ),

			array('class' => 'social-rss-outline', 'content' => '\f23c', ),

			array('class' => 'social-sass', 'content' => '\f4ea', ),

			array('class' => 'social-skype', 'content' => '\f23f', ),

			array('class' => 'social-skype-outline', 'content' => '\f23e', ),

			array('class' => 'social-snapchat', 'content' => '\f4ec', ),

			array('class' => 'social-snapchat-outline', 'content' => '\f4eb', ),

			array('class' => 'social-tumblr', 'content' => '\f241', ),

			array('class' => 'social-tumblr-outline', 'content' => '\f240', ),

			array('class' => 'social-tux', 'content' => '\f2c5', ),

			array('class' => 'social-twitch', 'content' => '\f4ee', ),

			array('class' => 'social-twitch-outline', 'content' => '\f4ed', ),

			array('class' => 'social-twitter', 'content' => '\f243', ),

			array('class' => 'social-twitter-outline', 'content' => '\f242', ),

			array('class' => 'social-usd', 'content' => '\f353', ),

			array('class' => 'social-usd-outline', 'content' => '\f352', ),

			array('class' => 'social-vimeo', 'content' => '\f245', ),

			array('class' => 'social-vimeo-outline', 'content' => '\f244', ),

			array('class' => 'social-whatsapp', 'content' => '\f4f0', ),

			array('class' => 'social-whatsapp-outline', 'content' => '\f4ef', ),

			array('class' => 'social-windows', 'content' => '\f247', ),

			array('class' => 'social-windows-outline', 'content' => '\f246', ),

			array('class' => 'social-wordpress', 'content' => '\f249', ),

			array('class' => 'social-wordpress-outline', 'content' => '\f248', ),

			array('class' => 'social-yahoo', 'content' => '\f24b', ),

			array('class' => 'social-yahoo-outline', 'content' => '\f24a', ),

			array('class' => 'social-yen', 'content' => '\f4f2', ),

			array('class' => 'social-yen-outline', 'content' => '\f4f1', ),

			array('class' => 'social-youtube', 'content' => '\f24d', ),

			array('class' => 'social-youtube-outline', 'content' => '\f24c', ),

			array('class' => 'soup-can', 'content' => '\f4f4', ),

			array('class' => 'soup-can-outline', 'content' => '\f4f3', ),

			array('class' => 'speakerphone', 'content' => '\f2b2', ),

			array('class' => 'speedometer', 'content' => '\f2b3', ),

			array('class' => 'spoon', 'content' => '\f2b4', ),

			array('class' => 'star', 'content' => '\f24e', ),

			array('class' => 'stats-bars', 'content' => '\f2b5', ),

			array('class' => 'steam', 'content' => '\f30b', ),

			array('class' => 'stop', 'content' => '\f24f', ),

			array('class' => 'thermometer', 'content' => '\f2b6', ),

			array('class' => 'thumbsdown', 'content' => '\f250', ),

			array('class' => 'thumbsup', 'content' => '\f251', ),

			array('class' => 'toggle', 'content' => '\f355', ),

			array('class' => 'toggle-filled', 'content' => '\f354', ),

			array('class' => 'transgender', 'content' => '\f4f5', ),

			array('class' => 'trash-a', 'content' => '\f252', ),

			array('class' => 'trash-b', 'content' => '\f253', ),

			array('class' => 'trophy', 'content' => '\f356', ),

			array('class' => 'tshirt', 'content' => '\f4f7', ),

			array('class' => 'tshirt-outline', 'content' => '\f4f6', ),

			array('class' => 'umbrella', 'content' => '\f2b7', ),

			array('class' => 'university', 'content' => '\f357', ),

			array('class' => 'unlocked', 'content' => '\f254', ),

			array('class' => 'upload', 'content' => '\f255', ),

			array('class' => 'usb', 'content' => '\f2b8', ),

			array('class' => 'videocamera', 'content' => '\f256', ),

			array('class' => 'volume-high', 'content' => '\f257', ),

			array('class' => 'volume-low', 'content' => '\f258', ),

			array('class' => 'volume-medium', 'content' => '\f259', ),

			array('class' => 'volume-mute', 'content' => '\f25a', ),

			array('class' => 'wand', 'content' => '\f358', ),

			array('class' => 'waterdrop', 'content' => '\f25b', ),

			array('class' => 'wifi', 'content' => '\f25c', ),

			array('class' => 'wineglass', 'content' => '\f2b9', ),

			array('class' => 'woman', 'content' => '\f25d', ),

			array('class' => 'wrench', 'content' => '\f2ba', ),

			array('class' => 'xbox', 'content' => '\f30c', ),
		);

		$this->font = $ION_FONTS;
		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/
		
		$this->label = __( 'Ionicons', 'ryancv-plugin' );
		
		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/
		
		$this->category = 'basic';
		
		/*
		*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
		*/
		
		$this->defaults = array(
			'font_size'	=> 14,
		);
		
		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*/
		
		$this->l10n = array(
			'error'	=> __( 'Error! Please enter a higher value', 'ryancv-plugin' ),
		);
				
		// do not delete!
		parent::__construct();
		
	}
	
	/*
	*  render_field_settings()
	*
	*  Create extra settings for your field. These are visible when editing a field
	*/
	
	function render_field_settings( $field ) {
		
		/*
		*  acf_render_field_setting
		*
		*  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
		*  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
		*
		*  More than one setting can be added by copy/paste the above code.
		*  Please note that you must also have a matching $defaults value for the field name (font_size)
		*/

	}
	
	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*/
	
	function render_field( $field ) {

		// Begin HTML select field
		echo '<div class="ionicons_preview"></div>';
		echo '<select id="' . $field['name'] . '" class="' . $field['class'] . ' ionicons-select" name="' . $field['name'] . '">';
		
		foreach ( $this->font as $key => $font ) :
			$field_selected = '';
			if ( $field['value'] == $key ) {
				$field_selected = 'selected="selected"';
			}
			echo '<option ' . $field_selected . ' value="' . $key . '">' . $font["class"] . '</option>';
		endforeach;

		echo '</select>';
	}
	
	/*
	*  input_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*/

	function input_admin_head() {
	?>
		<script>
			jQuery(document).ready(function($) {
				function formatState (state) {
					if (!state.id) {
						return state.text; 
					}
				  	var $state = $('<span><span class="ion ion-' +  state.text + '"></span>' + state.text + '</span>');
				 	return $state;
				};

				$('.ionicons_preview').each(function(){
					$(this).html('<span class="'+'ion ion-' + $(this).parent().find('.ionicons-select').find('option:selected').html() + '"></span>');
				});
				$(".ionicons-select").on('change', function(){
					$(this).parent().find('.ionicons_preview').html('<span class="'+'ion ion-' + $(this).find('option:selected').html() + '"></span>');
				});

				function select2_init( fa_field ) {
					var $select = $( fa_field );
					var parent = $( $select ).closest('.acf-field-ionicons');

					$select.select2({
						width: '100%',
						templateResult: formatState
					});
				}

				// Update field previews and init select2 in field edit area
				acf.add_action( 'ready_field/type=ionicons append_field/type=ionicons show_field/type=ionicons load_field/type=ionicons', function( $el ) {
					var $fa_fields = $( 'select.ionicons-select:not(.select2_initalized)', $el );

					if ( $fa_fields.length ) {
						$fa_fields.each( function( index, fa_field ) {
							select2_init( fa_field );
						});
					}
				});

				var instance = new acf.Model({
				    events: {
				        'change select.ionicons-select': 'onChange',
				    },
				    onChange: function(e, $el){
				        $el.parent().find('.ionicons_preview').html('<span class="'+'ion ion-' + $el.find('option:selected').html() + '"></span>');
				    },
				});
			});
		</script>
	<?php	
	}

	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your render_field() action.
	*/

	function input_admin_enqueue_scripts() {
		/*
		wp_register_script( 'acf-input-font-awesome', "assets/js/input-v5.js", array('acf-input'), '1.0.0' );
		wp_enqueue_script('acf-input-font-awesome');
		*/

		wp_register_style( 'acf-input-ionicons-input',  plugin_dir_url( __FILE__ ) . "assets/css/input.css", array('acf-input'), '1.0.0' );
		wp_enqueue_style( 'acf-input-ionicons-input' );
		wp_register_style( 'acf-input-font-ionicons',  plugin_dir_url( __FILE__ ) . "assets/css/ionicons.css", array('acf-input'), '1.0.0' );
		wp_enqueue_style( 'acf-input-font-ionicons' );
	}

	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*/

	function format_value( $value, $post_id, $field ) {
		$cur_font = isset( $this->font[ $value ] ) && $this->font[ $value ] ? $this->font[ $value ] : "";

		if ( $cur_font ) {
			$ion_font = 'ion-' . $cur_font['class'];
			return $ion_font;
		} else {
			return '';
		}
	}

}

// initialize
new acf_field_ryancv_ionicons();

// class_exists check
endif;

?>
