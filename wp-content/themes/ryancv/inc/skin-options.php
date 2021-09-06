<?php
/**
 * Skin
 */

function ryancv_hexToRgb( $hex ) {
	$hex = str_replace( '#', '', $hex );
	$length = strlen( $hex );
	$rgb['r'] = hexdec( $length == 6 ? substr( $hex, 0, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 0, 1), 2) : 0 ) );
	$rgb['g'] = hexdec( $length == 6 ? substr( $hex, 2, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 1, 1), 2) : 0 ) );
	$rgb['b'] = hexdec( $length == 6 ? substr( $hex, 4, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 2, 1), 2) : 0 ) );
	
	return implode( ", ", $rgb );
}

function ryancv_skin() {
	$theme_bg = get_field( 'theme_bg', 'options' );
	$theme_color = get_field( 'theme_color', 'options' );
	$theme_style = get_field( 'theme_style', 'options' );
	$theme_ui = get_field( 'theme_ui', 'options' );
	$heading_color = get_field( 'heading_color', 'options' );
	$text_color = get_field( 'text_color', 'options' );
	$heading_font = get_field( 'heading_font_family', 'options' );
	$text_font = get_field( 'text_font_family', 'options' );
	$heading_font_size = get_field( 'heading_font_size', 'options' );
	$text_font_size = get_field( 'text_font_size', 'options' );
?>
	
<style>
	<?php if ( $theme_bg['type'] == 1 ) : ?>
	/*
		Background Color
	*/

	.background, body {
		background-color: <?php echo esc_attr( $theme_bg['color'] ); ?>;
	}
	<?php endif; ?>

	<?php if ( $theme_bg['type'] == 2 ) : ?>
	/*
		Background Gradient
	*/

	body {
		background-color: <?php echo esc_attr( $theme_bg['color1'] ); ?>;
	}

	.background.gradient {
		background: <?php echo esc_attr( $theme_bg['color1'] ); ?>;
		background: -webkit-linear-gradient(top left, <?php echo esc_attr( $theme_bg['color1'] ); ?> 0%, <?php echo esc_attr( $theme_bg['color2'] ); ?> 100%);
		background: linear-gradient(to bottom right, <?php echo esc_attr( $theme_bg['color1'] ); ?> 0%, <?php echo esc_attr( $theme_bg['color2'] ); ?> 100%);
	}
	<?php endif; ?>

	<?php if ( $theme_bg['type'] == 3 ) : ?>
	/*
		Background Image
	*/

	.background {
		background-image: url(<?php echo esc_attr( $theme_bg['image'] ); ?>);
	}
	<?php endif; ?>

	<?php if ( $theme_color ) : ?>
	/*
		Primary Color
	*/

	.preloader .spinner .double-bounce1,
	.preloader .spinner .double-bounce2,
	.lnk:hover .arrow:before,
	.button:hover .arrow:before,
	.lnk:hover .arrow:after,
	.button:hover .arrow:after,
	.resume-items .resume-item.active .date:before,
	.skills-list ul li .progress .percentage,
	.single-post-text ul > li:before, 
	.comment-text ul > li:before,
	.content-sidebar .main-menu ul li.page_item_has_children.current_page_item > a:before, 
	.content-sidebar .main-menu ul li.page_item_has_children.current_page_item > a:after, 
	.content-sidebar .main-menu ul li.page_item_has_children:hover > a:before, 
	.content-sidebar .main-menu ul li.page_item_has_children:hover > a:after,
	.content-sidebar .main-menu ul li.page_item_has_children.current_page_parent > a:before, 
	.content-sidebar .main-menu ul li.page_item_has_children.current_page_parent > a:after,
	.content-sidebar .main-menu ul li.page_item_has_children.current_page_ancestor > a:before, 
	.content-sidebar .main-menu ul li.page_item_has_children.current_page_ancestor > a:after,
	.content-sidebar .close:hover:before, .content-sidebar .close:hover:after,
	.header .menu-btn:hover span, .header .menu-btn:hover span:before,
	.header .menu-btn:hover span:after,
	.info-list ul li strong,
	.profile .main-menu ul li.page_item_has_children.current_page_item > a:before,
	.profile .main-menu ul li.page_item_has_children.current_page_item > a:after,
	.profile .main-menu ul li.page_item_has_children:hover > a:before,
	.profile .main-menu ul li.page_item_has_children:hover > a:after,
	.profile .main-menu ul li.page_item_has_children.current_page_parent > a:before,
	.profile .main-menu ul li.page_item_has_children.current_page_parent > a:after,
	.profile .main-menu ul li.page_item_has_children.current_page_ancestor > a:before,
	.profile .main-menu ul li.page_item_has_children.current_page_ancestor > a:after,
	.service-items .service-item .icon,
	.revs-carousel .owl-dot.active,
	.custom-content-reveal span.custom-content-close,
	.fc-calendar .fc-row > div.fc-today,
	.fc-calendar .fc-content:hover span.fc-date,
	.fc-calendar .fc-row > div.fc-today span.fc-date,
	.skills-list.dotted ul li .progress .percentage .da span {
		background: <?php echo esc_attr( $theme_color ); ?>;
	}

	.lnk:hover,
	.button:hover,
	.lnk:hover .ion,
	.button:hover .ion,
	a,
	a:hover,
	input:focus, 
	textarea:focus,
	.header .top-menu ul li:hover a,
	.header .top-menu ul li.active a,
	.header .top-menu ul li.current-menu-item a,
	.header .top-menu ul li:hover a .icon,
	.header .top-menu ul li.active a .icon,
	.header .top-menu ul li:hover a .link,
	.header .top-menu ul li.active a .link,
	.header .top-menu ul li.current-menu-item a .icon,
	.header .top-menu ul li.current-menu-item a .link,
	.header .profile .subtitle,
	.card-started .profile .subtitle,
	.content-sidebar .profile .subtitle,
	.card-started .profile .social a:hover .ion, 
	.card-started .profile .social a:hover .fab, 
	.card-started .profile .social a:hover .fas,
	.content-sidebar .profile .social a:hover .ion, 
	.content-sidebar .profile .social a:hover .fab, 
	.content-sidebar .profile .social a:hover .fas,
	.pricing-items .pricing-item .icon,
	.fuct-items .fuct-item .icon,
	.resume-title .icon,
	.skill-title .icon,
	.resume-items .resume-item.active .date,
	.content.works .filter-menu .f_btn.active,
	.box-item:hover .desc .name,
	.single-post-text p a, 
	.comment-text p a,
	.post-text-bottom span.cat-links a,
	.post-text-bottom .tags-links a, 
	.post-text-bottom .tags-links span,
	.page-numbers.current, 
	.page-links a,
	.post-comments .post-comment .desc .name,
	.post-comments .post-comment .desc span.comment-reply a:hover,
	.content-sidebar .main-menu ul li.current_page_item > a, 
	.content-sidebar .main-menu ul li:hover > a,
	.content-sidebar .main-menu ul li.current_page_parent > a,
	.content-sidebar .main-menu ul li.current_page_ancestor > a,
	.content-sidebar .widget ul li a:hover,
	.content-sidebar .tagcloud a,
	.card-started .profile .subtitle, 
	.content-sidebar .profile .subtitle, 
	.content-sidebar .profile .typed-cursor, 
	.card-started .profile .typed-cursor,
	.content .title .first-word,
	.content .title::first-letter,
	.content .title .first-letter::first-letter,
	.content-sidebar h2.widget-title .first-word,
	.content-sidebar h2.widget-title::first-letter,
	.content-sidebar h2.widget-title .first-letter::first-letter,
	.box-item .date,
	.profile .main-menu ul li.current-menu-item a,
	.profile .main-menu ul li.current_page_item > a,
	.profile .main-menu ul li:hover > a,
	.profile .main-menu ul li.current_page_parent > a,
	.profile .main-menu ul li.current_page_ancestor > a,
	.custom-header nav span:before,
	.fc-calendar .fc-row > div.fc-content:hover:after,
	.skills-list.list ul li .name:before {
		color: <?php echo esc_attr( $theme_color ); ?>;
	}

	.content .title .first-word,
	.content .title:first-letter,
	.content-sidebar h2.widget-title .first-word,
	.content-sidebar h2.widget-title:first-letter {
		color: <?php echo esc_attr( $theme_color ); ?>!important;
	}

	.card-started .profile .image:before,
	.content-sidebar .profile .image:before,
	.content .title:before,
	.box-item .image .info:before,
	.content-sidebar h2.widget-title:before {
		background: -moz-linear-gradient(-45deg, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.15) 0%, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.01) 100%);
		background: -webkit-linear-gradient(-45deg, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.15) 0%, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.01) 100%);
		background: linear-gradient(135deg, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.15) 0%, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.01) 100%);
	}

	.card-started:after {
		background: -moz-linear-gradient(-45deg, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.4) 0%, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.01) 100%);
		background: -webkit-linear-gradient(-45deg, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.4) 0%, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.01) 100%);
		background: linear-gradient(135deg, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.4) 0%, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.01) 100%);
	}

	.box-item .image .info:before {
		background: -moz-linear-gradient(-45deg, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.5) 0%, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.01) 100%);
		background: -webkit-linear-gradient(-45deg, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.5) 0%, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.01) 100%);
		background: linear-gradient(135deg, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.5) 0%, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.01) 100%);
	}

	.card-started .profile .slide,
	.content-sidebar .profile .slide {
		background-color: rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.1);
	}

	.pricing-items .pricing-item .feature-list ul li strong {
		background: rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.15);
	}

	input:focus, 
	textarea:focus,
	.revs-carousel .owl-dots .owl-dot,
	.custom-header,
	.post-text-bottom .tags-links a, 
	.post-text-bottom .tags-links span, 
	.content-sidebar .tagcloud a,
	.resume-items .resume-item.active .date,
	.box-item .date,
	.content.skills .skills-list.circles .progress .bar,
	.content.skills .skills-list.circles .progress .fill {
		border-color: <?php echo esc_attr( $theme_color ); ?>;
	}

	blockquote {
		border-left-color: <?php echo esc_attr( $theme_color ); ?>;
	}
	<?php endif; ?>

	<?php if ( $heading_color ) : ?>
	/*
		Heading Color
	*/

	.content .title {
		color: <?php echo esc_attr( $heading_color ); ?>;
	}
	<?php endif; ?>

	<?php if ( $text_color ) : ?>
	/*
		Text Color
	*/

	body {
		color: <?php echo esc_attr( $text_color ); ?>;
	}
	<?php endif; ?>

	<?php if ( $heading_font ) : ?>
	/*
		Heading Font Family
	*/

	.content .title {
		font-family: '<?php echo esc_attr( $heading_font['font_name'] ); ?>';
	}
	<?php endif; ?>

	<?php if ( $text_font ) : ?>
	/*
		Text Font Family
	*/

	body {
		font-family: '<?php echo esc_attr( $text_font['font_name'] ); ?>';
	}
	<?php endif; ?>

	<?php if ( $heading_font_size ) : ?>
	/*
		Heading Font Size
	*/

	.content .title {
		font-size: <?php echo esc_attr( $heading_font_size ); ?>px;
	}
	<?php endif; ?>

	<?php if ( $text_font_size ) : ?>
	/*
		Text Font Size
	*/

	p, .row .col, body, .info-list ul li {
		font-size: <?php echo esc_attr( $text_font_size ); ?>px;
	}
	<?php endif; ?>

	<?php if ( $theme_style && $theme_color ) : ?>
	/*
		Classic Version Style
	*/

	.service-items .service-item .icon {
		background: -moz-linear-gradient(-45deg, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.15) 0%, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.01) 100%);
		background: -webkit-linear-gradient(-45deg, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.15) 0%, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.01) 100%);
		background: linear-gradient(135deg, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.15) 0%, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.01) 100%);
	}
	.service-items .service-item .icon {
		color: <?php echo esc_attr( $theme_color ); ?>;
	}
	<?php endif; ?>

	<?php if ( $theme_style && $theme_color ) : ?>
	/*
		Classic Version Style
	*/
	.card-started:after,
	.card-started .profile .image:before,
	.content-sidebar .profile .image:before,
	.content .title:before,
	.box-item .image .info:before,
	.content-sidebar h2.widget-title:before {
		background: -moz-linear-gradient(-45deg, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.4) 0%, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.01) 100%);
		background: -webkit-linear-gradient(-45deg, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.4) 0%, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.01) 100%);
		background: linear-gradient(135deg, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.4) 0%, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.01) 100%);
	}
	<?php endif; ?>

	<?php if ( $theme_ui && $theme_color ) : ?>
	/*
		Dark Version Style
	*/
	.card-started:after,
	.card-started .profile .image:before,
	.content-sidebar .profile .image:before,
	.content .title:before,
	.box-item .image .info:before,
	.content-sidebar h2.widget-title:before {
		background: -moz-linear-gradient(-45deg, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.4) 0%, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.01) 100%);
		background: -webkit-linear-gradient(-45deg, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.4) 0%, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.01) 100%);
		background: linear-gradient(135deg, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.4) 0%, rgba(<?php echo esc_attr( ryancv_hexToRgb( $theme_color ) ); ?>, 0.01) 100%);
	}
	<?php endif; ?>
</style>
		
<?php
}
add_action( 'wp_head', 'ryancv_skin' );

if ( function_exists( 'get_field' ) ) {
	/**
	 * Classic Version
	 */

	$theme_style = get_field( 'theme_style', 'options' );

	if ( $theme_style ) {
		function ryancv_classic_stylesheets() {
			wp_enqueue_style( 'ryancv-classic', get_template_directory_uri() . '/assets/css/classic.css', '1.0' );
		}
		add_action( 'wp_head', 'ryancv_classic_stylesheets' );

	}

	/**
	 * Dark Version
	 */

	$theme_ui = get_field( 'theme_ui', 'options' );

	if ( $theme_ui ) {
		function ryancv_dark_stylesheets() {
			wp_enqueue_style( 'ryancv-dark', get_template_directory_uri() . '/assets/css/dark.css', '1.0' );
		}
		add_action( 'wp_head', 'ryancv_dark_stylesheets' );

	}
}
