<?php
defined( 'ABSPATH' ) || exit;

/**
 * Brand color Customizer controls, mapped 1:1 to the CSS custom properties
 * defined in assets/css/style.css. Each control's default matches the
 * hardcoded value in that stylesheet, so leaving everything untouched
 * reproduces the theme's current look exactly.
 */
function nyfdf_color_defaults(): array {
	return [
		'teal'       => '#1A4FA8',
		'teal_dark'  => '#0E2F6B',
		'teal_light' => '#D5E4F5',
		'gold'       => '#C8952A',
		'gold_light' => '#F5E6C8',
		'ink'        => '#0A1628',
		'mist'       => '#EEF4FB',
		'grey'       => '#4A6080',
		'white'      => '#FFFFFF',
	];
}

add_action( 'customize_register', 'nyfdf_customize_register' );

function nyfdf_customize_register( WP_Customize_Manager $wp_customize ): void {

	$wp_customize->add_section( 'nyfdf_colors', [
		'title'       => 'Brand Colors',
		'priority'    => 30,
		'description' => 'Controls the site\'s color palette. Leave any field blank/default to keep the current look.',
	] );

	$labels = [
		'teal'       => 'Teal (Primary)',
		'teal_dark'  => 'Teal Dark',
		'teal_light' => 'Teal Light',
		'gold'       => 'Gold (Accent)',
		'gold_light' => 'Gold Light',
		'ink'        => 'Ink (Dark Backgrounds / Text)',
		'mist'       => 'Mist (Light Background)',
		'grey'       => 'Grey (Secondary Text)',
		'white'      => 'White',
	];

	foreach ( nyfdf_color_defaults() as $key => $default ) {
		$setting_id = 'nyfdf_color_' . $key;

		$wp_customize->add_setting( $setting_id, [
			'default'           => $default,
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		] );

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			$setting_id,
			[
				'label'   => $labels[ $key ],
				'section' => 'nyfdf_colors',
			]
		) );
	}
}

/**
 * Returns the CSS custom property overrides for the current Customizer values.
 */
function nyfdf_get_color_css(): string {
	$vars = [];
	foreach ( nyfdf_color_defaults() as $key => $default ) {
		$value = get_theme_mod( 'nyfdf_color_' . $key, $default );
		$vars[] = '--' . str_replace( '_', '-', $key ) . ': ' . $value . ';';
	}
	return ':root {' . implode( ' ', $vars ) . '}';
}

/**
 * Curated Google Fonts choices for the heading (display/serif) role.
 * 'google' is the css2 API family query segment; 'css' is the CSS
 * font-family value (with a generic fallback) used in the custom property.
 */
function nyfdf_heading_fonts(): array {
	return [
		'cormorant_garamond' => [
			'label'  => 'Cormorant Garamond (Default)',
			'css'    => "'Cormorant Garamond', serif",
			'google' => 'Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400',
		],
		'playfair_display' => [
			'label'  => 'Playfair Display',
			'css'    => "'Playfair Display', serif",
			'google' => 'Playfair+Display:ital,wght@0,400;0,600;0,700;1,400',
		],
		'libre_baskerville' => [
			'label'  => 'Libre Baskerville',
			'css'    => "'Libre Baskerville', serif",
			'google' => 'Libre+Baskerville:ital,wght@0,400;0,700;1,400',
		],
		'merriweather' => [
			'label'  => 'Merriweather',
			'css'    => "'Merriweather', serif",
			'google' => 'Merriweather:ital,wght@0,300;0,400;0,700;1,300;1,400',
		],
		'dm_serif_display' => [
			'label'  => 'DM Serif Display',
			'css'    => "'DM Serif Display', serif",
			'google' => 'DM+Serif+Display:ital,wght@0,400;1,400',
		],
	];
}

/**
 * Curated Google Fonts choices for the body (text) role.
 */
function nyfdf_body_fonts(): array {
	return [
		'dm_sans' => [
			'label'  => 'DM Sans (Default)',
			'css'    => "'DM Sans', sans-serif",
			'google' => 'DM+Sans:wght@300;400;500',
		],
		'inter' => [
			'label'  => 'Inter',
			'css'    => "'Inter', sans-serif",
			'google' => 'Inter:wght@300;400;500;600',
		],
		'work_sans' => [
			'label'  => 'Work Sans',
			'css'    => "'Work Sans', sans-serif",
			'google' => 'Work+Sans:wght@300;400;500;600',
		],
		'nunito_sans' => [
			'label'  => 'Nunito Sans',
			'css'    => "'Nunito Sans', sans-serif",
			'google' => 'Nunito+Sans:wght@300;400;500;600',
		],
		'source_sans_3' => [
			'label'  => 'Source Sans 3',
			'css'    => "'Source Sans 3', sans-serif",
			'google' => 'Source+Sans+3:wght@300;400;500;600',
		],
	];
}

add_action( 'customize_register', 'nyfdf_customize_register_typography' );

function nyfdf_customize_register_typography( WP_Customize_Manager $wp_customize ): void {

	$wp_customize->add_section( 'nyfdf_typography', [
		'title'       => 'Typography',
		'priority'    => 31,
		'description' => 'Choose the fonts used for headings/display text and body copy.',
	] );

	$wp_customize->add_setting( 'nyfdf_font_heading', [
		'default'           => 'cormorant_garamond',
		'sanitize_callback' => 'sanitize_key',
		'transport'         => 'refresh',
	] );
	$wp_customize->add_control( 'nyfdf_font_heading', [
		'label'   => 'Heading / Display Font',
		'section' => 'nyfdf_typography',
		'type'    => 'select',
		'choices' => wp_list_pluck( nyfdf_heading_fonts(), 'label' ),
	] );

	$wp_customize->add_setting( 'nyfdf_font_body', [
		'default'           => 'dm_sans',
		'sanitize_callback' => 'sanitize_key',
		'transport'         => 'refresh',
	] );
	$wp_customize->add_control( 'nyfdf_font_body', [
		'label'   => 'Body Font',
		'section' => 'nyfdf_typography',
		'type'    => 'select',
		'choices' => wp_list_pluck( nyfdf_body_fonts(), 'label' ),
	] );
}

/**
 * Returns the CSS custom property overrides for the current font choices.
 */
function nyfdf_get_font_css(): string {
	$headings = nyfdf_heading_fonts();
	$bodies   = nyfdf_body_fonts();

	$heading_key = get_theme_mod( 'nyfdf_font_heading', 'cormorant_garamond' );
	$body_key    = get_theme_mod( 'nyfdf_font_body', 'dm_sans' );

	$heading_css = $headings[ $heading_key ]['css'] ?? $headings['cormorant_garamond']['css'];
	$body_css    = $bodies[ $body_key ]['css'] ?? $bodies['dm_sans']['css'];

	return ":root { --font-heading: {$heading_css}; --font-body: {$body_css}; }";
}

/**
 * Builds the Google Fonts css2 API URL for the currently selected heading
 * and body fonts, so only the fonts actually in use are ever requested.
 */
function nyfdf_get_google_fonts_url(): string {
	$headings = nyfdf_heading_fonts();
	$bodies   = nyfdf_body_fonts();

	$heading_key = get_theme_mod( 'nyfdf_font_heading', 'cormorant_garamond' );
	$body_key    = get_theme_mod( 'nyfdf_font_body', 'dm_sans' );

	$families = [
		$headings[ $heading_key ]['google'] ?? $headings['cormorant_garamond']['google'],
		$bodies[ $body_key ]['google'] ?? $bodies['dm_sans']['google'],
	];

	$query = 'family=' . implode( '&family=', $families ) . '&display=swap';

	return 'https://fonts.googleapis.com/css2?' . $query;
}
