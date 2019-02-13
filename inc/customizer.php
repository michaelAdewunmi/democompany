<?php
/**
 * Fiction Demo Company Theme Customizer
 *
 * @package democompany
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function democompany_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'democompany_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'democompany_customize_partial_blogdescription',
		) );
	}


	/**
	 * Custom Customizer customization
	 */
	//Add a Custom customizer section
	$wp_customize->add_section('theme_options',
		array(
			'title' 		=> __('Footer Options', 'democompany'),
			'priority'		=> 20,
			'capability'	=> 'edit_theme_options',
			'description'	=> __('Add/remove the footer logo', 'democompany'),
		)
	);

	//Create footer logo settings
	$wp_customize->add_setting('footer_logo_url',
		array(
			'default'			=> get_theme_file_uri() . '/images/logo.jpg',
			'type'				=> 'theme_mod',
			'sanitize_callback'	=> 'esc_url'
		)
	);

	//Add the controls
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'logo',
			array(
				'label'		=> __('Upload Footer Logo', 'democompany'),
				'section'	=> 'theme_options',
				'settings'	=> 'footer_logo_url',

			)
		)
	);

	$wp_customize->add_setting('copyright_info',
		array(
			//'default'			=> 'rtPanel. All Rights Reserved. Designed by rtCamp',
			'type'				=> 'theme_mod',
			'sanitize_callback'	=> 'sanitize_text_field',
		)
	);

	//Add the controls
	$wp_customize->add_control( 'democompany_copyright_control',
		array(
			'type'		=> 'text',
			'label'		=> __('Footer copyright content and site info', 'democompany'),
			'section'	=> 'theme_options',
			'settings'	=> 'copyright_info',
		)
	);
}
add_action( 'customize_register', 'democompany_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function democompany_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function democompany_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function democompany_customize_preview_js() {
	wp_enqueue_script( 'democompany-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'democompany_customize_preview_js' );
