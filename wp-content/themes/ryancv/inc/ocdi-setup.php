<?php

function ryancv_ocdi_import_files() {
    return array(
        array(
            'import_file_name'             => esc_html__( 'Demo 1', 'ryancv' ),
            'categories'                   => array( esc_html__( 'New', 'ryancv' ) ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'demo/01/content.xml',
            //'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'demo/01/widgets.json',
            //'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'demo/01/customizer.dat',
            'import_preview_image_url'     => get_template_directory_uri() . '/demo/01/preview.jpg',
            'preview_url'                  => esc_url( 'https://ryan.beshley.com/' ),
        ),
        array(
            'import_file_name'             => esc_html__( 'Demo 2', 'ryancv' ),
            'categories'                   => array( esc_html__( 'New', 'ryancv' ) ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'demo/02/content.xml',
            //'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'demo/02/widgets.json',
            //'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'demo/02/customizer.dat',
            'import_preview_image_url'     => get_template_directory_uri() . '/demo/02/preview.jpg',
            'preview_url'                  => esc_url( 'https://ryan.beshley.com/v2/' ),
        ),
        array(
            'import_file_name'             => esc_html__( 'Demo 3', 'ryancv' ),
            'categories'                   => array( esc_html__( 'Classic', 'ryancv' ) ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'demo/03/content.xml',
            //'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'demo/03/widgets.json',
            //'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'demo/03/customizer.dat',
            'import_preview_image_url'     => get_template_directory_uri() . '/demo/03/preview.jpg',
            'preview_url'                  => esc_url( 'https://ryan.beshley.com/v3/' ),
        ),
        array(
            'import_file_name'             => esc_html__( 'Demo 4', 'ryancv' ),
            'categories'                   => array( esc_html__( 'Classic', 'ryancv' ) ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'demo/04/content.xml',
            //'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'demo/04/widgets.json',
            //'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'demo/04/customizer.dat',
            'import_preview_image_url'     => get_template_directory_uri() . '/demo/04/preview.jpg',
            'preview_url'                  => esc_url( 'https://ryan.beshley.com/v4/' ),
        ),
        array(
            'import_file_name'             => esc_html__( 'Demo 5', 'ryancv' ),
            'categories'                   => array( esc_html__( 'Classic', 'ryancv' ) ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'demo/05/content.xml',
            //'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'demo/05/widgets.json',
            //'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'demo/05/customizer.dat',
            'import_preview_image_url'     => get_template_directory_uri() . '/demo/05/preview.jpg',
            'preview_url'                  => esc_url( 'https://ryan.beshley.com/v5/' ),
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'ryancv_ocdi_import_files' );

function ryancv_ocdi_after_import_setup( $selected_import ) {
    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
    $index_url = get_home_url();
    $contacts_url = $index_url . '#contacts';

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    $blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );
    update_option( 'posts_per_page', 4 );

    $ocdi_fields_static = array(
    	'options_vcard_social_0_icon' => 'fab fa-dribbble',
        '_options_vcard_social_0_icon' => 'field_5bb0de9a64446',
    	'options_vcard_social_0_url' => 'https://dribbble.com/',
        '_options_vcard_social_0_url' => 'field_5bb0dec864447',
    	'options_vcard_social_1_icon' => 'fab fa-twitter',
        '_options_vcard_social_1_icon' => 'field_5bb0de9a64446',
    	'options_vcard_social_1_url' => 'https://twitter.com/',
        '_options_vcard_social_1_url' => 'field_5bb0dec864447',
    	'options_vcard_social_2_icon' => 'fab fa-github',
        '_options_vcard_social_2_icon' => 'field_5bb0de9a64446',
    	'options_vcard_social_2_url' => 'https://github.com/',
        '_options_vcard_social_2_url' => 'field_5bb0dec864447',
        'options_vcard_social_3_icon' => 'fab fa-spotify',
        '_options_vcard_social_3_icon' => 'field_5bb0de9a64446',
        'options_vcard_social_3_url' => 'https://www.spotify.com/',
        '_options_vcard_social_3_url' => 'field_5bb0dec864447',
        'options_vcard_social_4_icon' => 'fab fa-stack-overflow',
        '_options_vcard_social_4_icon' => 'field_5bb0de9a64446',
        'options_vcard_social_4_url' => 'https://stackoverflow.com/',
        '_options_vcard_social_4_url' => 'field_5bb0dec864447',
    	'options_vcard_social' => 5,
        '_options_vcard_social' => 'field_5bb0de8264445',
        'options_vcard_title' => 'Ryan Adlard',
        '_options_vcard_title' => 'field_5bb0de5464443',
        'options_vcard_subtitle' => 'Web Designer',
        '_options_vcard_subtitle' => 'field_5bb0de7364444',
        'options_theme_bg_type' => 2,
        '_options_theme_bg_type' => 'field_5beb53bf79fa8',
        'options_theme_bg' => '',
        '_options_theme_bg' => 'field_5beb5d2d9bb11',
        'options_vcard_subtitle_type' => 2,
        '_options_vcard_subtitle_type' => 'field_5bf25dce1fc31',
        'options_vcard_subtitles_0_text' => 'Web Designer',
        '_options_vcard_subtitles_0_text' => 'field_5bf25e451fc34',
        'options_vcard_subtitles_1_text' => 'Blogger',
        '_options_vcard_subtitles_1_text' => 'field_5bf25e451fc34',
        'options_vcard_subtitles_2_text' => 'Freelancer',
        '_options_vcard_subtitles_2_text' => 'field_5bf25e451fc34',
        'options_vcard_subtitles_3_text' => 'Photographer',
        '_options_vcard_subtitles_3_text' => 'field_5bf25e451fc34',
        'options_vcard_subtitles' => 4,
        '_options_vcard_subtitles' => 'field_5bf25e291fc33',
    );
    $ocdi_fields_to_change = array();
    
    if( 'Demo 1' === $selected_import['import_file_name'] ) {
        $ocdi_fields_to_change = array(
            'options_sticky_menu' => 1,
            '_options_sticky_menu' => 'field_5bc924b819f83',
            'options_onepage' => 1,
            '_options_onepage' => 'field_5bc9149ea45bf',
            'options_vcard_bg' => 165,
            '_options_vcard_bg' => 'field_5bb0d92348dd3',
            'options_vcard_photo' => '',
            '_options_vcard_photo' => 'field_5bb0de38020c0',
            'options_vcard_bts' => 2,
            '_options_vcard_bts' => 'field_5bb0ebd1519a0',
            'options_vcard_bts_0_text' => 'Download CV',
            '_options_vcard_bts_0_text' => 'field_5bb10b753eacd',
            'options_vcard_bts_0_icon' => 0,
            '_options_vcard_bts_0_icon' => 'field_5bb10b833eace',
            'options_vcard_bts_0_url' => 'https://ryan.beshley.com/',
            '_options_vcard_bts_0_url' => 'field_5bb10b923eacf',
            'options_vcard_bts_1_text' => 'Contact Me',
            '_options_vcard_bts_1_text' => 'field_5bb10b753eacd',
            'options_vcard_bts_1_icon' => 0,
            '_options_vcard_bts_1_icon' => 'field_5bb10b833eace',
            'options_vcard_bts_1_url' => 'https://ryan.beshley.com/#contacts',
            '_options_vcard_bts_1_url' => 'field_5bb10b923eacf',
            'options_theme_bg_color1' => '#50a3a2',
            '_options_theme_bg_color1' => 'field_5beb54b479fa9',
            'options_theme_bg_color2' => '#78cc6d',
            '_options_theme_bg_color2' => 'field_5beb554079fab',
            'options_theme_color' => '#78cc6d',
            '_options_theme_color' => 'field_5b68d509665d9',
            'options_theme_ui' => 0,
            '_options_theme_ui' => 'field_5bf64250c9820',
            'options_theme_style' => 0,
            '_options_theme_style' => 'field_5bf6a3372280a',
            'options_simple_vcard' => 0,
            '_options_simple_vcard' => 'field_5cb0c69578340',
            'options_sidebar_disable' => 0,
            '_options_sidebar_disable' => 'field_5b74a0eb27c4c',
        );
    }
    if( 'Demo 2' === $selected_import['import_file_name'] ) {
        $ocdi_fields_to_change = array(
            'options_sticky_menu' => 0,
            '_options_sticky_menu' => 'field_5bc924b819f83',
            'options_onepage' => 0,
            '_options_onepage' => 'field_5bc9149ea45bf',
            'options_vcard_bg' => 166,
            '_options_vcard_bg' => 'field_5bb0d92348dd3',
            'options_vcard_photo' => 164,
            '_options_vcard_photo' => 'field_5bb0de38020c0',
            'options_vcard_bts' => 2,
            '_options_vcard_bts' => 'field_5bb0ebd1519a0',
            'options_vcard_bts_0_text' => 'Download CV',
            '_options_vcard_bts_0_text' => 'field_5bb10b753eacd',
            'options_vcard_bts_0_icon' => 0,
            '_options_vcard_bts_0_icon' => 'field_5bb10b833eace',
            'options_vcard_bts_0_url' => 'https://ryan.beshley.com/',
            '_options_vcard_bts_0_url' => 'field_5bb10b923eacf',
            'options_vcard_bts_1_text' => 'Contact Me',
            '_options_vcard_bts_1_text' => 'field_5bb10b753eacd',
            'options_vcard_bts_1_icon' => 0,
            '_options_vcard_bts_1_icon' => 'field_5bb10b833eace',
            'options_vcard_bts_1_url' => 'https://ryan.beshley.com/#contacts',
            '_options_vcard_bts_1_url' => 'field_5bb10b923eacf',
            'options_theme_bg_color1' => '#48b1bf',
            '_options_theme_bg_color1' => 'field_5beb54b479fa9',
            'options_theme_bg_color2' => '#0856c1',
            '_options_theme_bg_color2' => 'field_5beb554079fab',
            'options_theme_color' => '#48b1bf',
            '_options_theme_color' => 'field_5b68d509665d9',
            'options_theme_ui' => 0,
            '_options_theme_ui' => 'field_5bf64250c9820',
            'options_theme_style' => 0,
            '_options_theme_style' => 'field_5bf6a3372280a',
            'options_simple_vcard' => 0,
            '_options_simple_vcard' => 'field_5cb0c69578340',
            'options_sidebar_disable' => 0,
            '_options_sidebar_disable' => 'field_5b74a0eb27c4c',
        );
    }
    if( 'Demo 3' === $selected_import['import_file_name'] ) {
        $ocdi_fields_to_change = array(
            'options_sticky_menu' => 1,
            '_options_sticky_menu' => 'field_5bc924b819f83',
            'options_onepage' => 1,
            '_options_onepage' => 'field_5bc9149ea45bf',
            'options_vcard_bg' => 360,
            '_options_vcard_bg' => 'field_5bb0d92348dd3',
            'options_vcard_photo' => 359,
            '_options_vcard_photo' => 'field_5bb0de38020c0',
            'options_vcard_bts' => 2,
            '_options_vcard_bts' => 'field_5bb0ebd1519a0',
            'options_vcard_bts_0_text' => 'Download CV',
            '_options_vcard_bts_0_text' => 'field_5bb10b753eacd',
            'options_vcard_bts_0_icon' => 132,
            '_options_vcard_bts_0_icon' => 'field_5bb10b833eace',
            'options_vcard_bts_0_url' => 'https://ryan.beshley.com/',
            '_options_vcard_bts_0_url' => 'field_5bb10b923eacf',
            'options_vcard_bts_1_text' => 'Contact Me',
            '_options_vcard_bts_1_text' => 'field_5bb10b753eacd',
            'options_vcard_bts_1_icon' => 107,
            '_options_vcard_bts_1_icon' => 'field_5bb10b833eace',
            'options_vcard_bts_1_url' => 'https://ryan.beshley.com/#contacts',
            '_options_vcard_bts_1_url' => 'field_5bb10b923eacf',
            'options_theme_bg_color1' => '#50a3a2',
            '_options_theme_bg_color1' => 'field_5beb54b479fa9',
            'options_theme_bg_color2' => '#78cc6d',
            '_options_theme_bg_color2' => 'field_5beb554079fab',
            'options_theme_color' => '#78cc6d',
            '_options_theme_color' => 'field_5b68d509665d9',
            'options_theme_ui' => 0,
            '_options_theme_ui' => 'field_5bf64250c9820',
            'options_theme_style' => 1,
            '_options_theme_style' => 'field_5bf6a3372280a',
            'options_simple_vcard' => 0,
            '_options_simple_vcard' => 'field_5cb0c69578340',
            'options_sidebar_disable' => 0,
            '_options_sidebar_disable' => 'field_5b74a0eb27c4c',
        );
    }
    if( 'Demo 4' === $selected_import['import_file_name'] ) {
        $ocdi_fields_to_change = array(
            'options_sticky_menu' => 1,
            '_options_sticky_menu' => 'field_5bc924b819f83',
            'options_onepage' => 1,
            '_options_onepage' => 'field_5bc9149ea45bf',
            'options_vcard_bg' => 360,
            '_options_vcard_bg' => 'field_5bb0d92348dd3',
            'options_vcard_photo' => 359,
            '_options_vcard_photo' => 'field_5bb0de38020c0',
            'options_vcard_bts' => 2,
            '_options_vcard_bts' => 'field_5bb0ebd1519a0',
            'options_vcard_bts_0_text' => 'Download CV',
            '_options_vcard_bts_0_text' => 'field_5bb10b753eacd',
            'options_vcard_bts_0_icon' => 132,
            '_options_vcard_bts_0_icon' => 'field_5bb10b833eace',
            'options_vcard_bts_0_url' => 'https://ryan.beshley.com/',
            '_options_vcard_bts_0_url' => 'field_5bb10b923eacf',
            'options_vcard_bts_1_text' => 'Contact Me',
            '_options_vcard_bts_1_text' => 'field_5bb10b753eacd',
            'options_vcard_bts_1_icon' => 107,
            '_options_vcard_bts_1_icon' => 'field_5bb10b833eace',
            'options_vcard_bts_1_url' => 'https://ryan.beshley.com/#contacts',
            '_options_vcard_bts_1_url' => 'field_5bb10b923eacf',
            'options_theme_bg_color1' => '#50a3a2',
            '_options_theme_bg_color1' => 'field_5beb54b479fa9',
            'options_theme_bg_color2' => '#78cc6d',
            '_options_theme_bg_color2' => 'field_5beb554079fab',
            'options_theme_color' => '#ff9800',
            '_options_theme_color' => 'field_5b68d509665d9',
            'options_theme_ui' => 1,
            '_options_theme_ui' => 'field_5bf64250c9820',
            'options_theme_style' => 1,
            '_options_theme_style' => 'field_5bf6a3372280a',
            'options_simple_vcard' => 0,
            '_options_simple_vcard' => 'field_5cb0c69578340',
            'options_sidebar_disable' => 0,
            '_options_sidebar_disable' => 'field_5b74a0eb27c4c',
        );
    }
    if( 'Demo 5' === $selected_import['import_file_name'] ) {
        $ocdi_fields_to_change = array(
            'options_sticky_menu' => 0,
            '_options_sticky_menu' => 'field_5bc924b819f83',
            'options_onepage' => 0,
            '_options_onepage' => 'field_5bc9149ea45bf',
            'options_vcard_bg' => 360,
            '_options_vcard_bg' => 'field_5bb0d92348dd3',
            'options_vcard_photo' => 359,
            '_options_vcard_photo' => 'field_5bb0de38020c0',
            'options_vcard_bts' => 2,
            '_options_vcard_bts' => 'field_5bb0ebd1519a0',
            'options_vcard_bts_0_text' => 'Download CV',
            '_options_vcard_bts_0_text' => 'field_5bb10b753eacd',
            'options_vcard_bts_0_icon' => 132,
            '_options_vcard_bts_0_icon' => 'field_5bb10b833eace',
            'options_vcard_bts_0_url' => 'https://ryan.beshley.com/',
            '_options_vcard_bts_0_url' => 'field_5bb10b923eacf',
            'options_vcard_bts_1_text' => 'Contact Me',
            '_options_vcard_bts_1_text' => 'field_5bb10b753eacd',
            'options_vcard_bts_1_icon' => 107,
            '_options_vcard_bts_1_icon' => 'field_5bb10b833eace',
            'options_vcard_bts_1_url' => 'contact-me@ryan.beshley.com',
            '_options_vcard_bts_1_url' => 'field_5bb10b923eacf',
            'options_theme_bg_color1' => '#50a3a2',
            '_options_theme_bg_color1' => 'field_5beb54b479fa9',
            'options_theme_bg_color2' => '#78cc6d',
            '_options_theme_bg_color2' => 'field_5beb554079fab',
            'options_theme_color' => '#ff9800',
            '_options_theme_color' => 'field_5b68d509665d9',
            'options_theme_ui' => 1,
            '_options_theme_ui' => 'field_5bf64250c9820',
            'options_theme_style' => 1,
            '_options_theme_style' => 'field_5bf6a3372280a',
            'options_simple_vcard' => 1,
            '_options_simple_vcard' => 'field_5cb0c69578340',
            'options_sidebar_disable' => 1,
            '_options_sidebar_disable' => 'field_5b74a0eb27c4c',
        );
    }

    global $wpdb;
	foreach ( array_merge( $ocdi_fields_static, $ocdi_fields_to_change ) as $field => $value ) {
		if ( $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'options WHERE option_name = \'' . $field . '\'' ) == 0 ) {
			$wpdb->insert( $wpdb->prefix . 'options', array( 'option_value' => $value, 'option_name' => $field, 'autoload' => 'no' ), array( '%s', '%s', '%s' ) );
		} else {
			$wpdb->update( $wpdb->prefix . 'options', array( 'option_value' => $value ), array( 'option_name' => $field ) );
		}
	}

}
add_action( 'pt-ocdi/after_import', 'ryancv_ocdi_after_import_setup' );
