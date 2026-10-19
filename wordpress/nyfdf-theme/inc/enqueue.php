<?php
defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'nyfdf_enqueue_assets' );

function nyfdf_enqueue_assets(): void {

	wp_enqueue_style(
		'nyfdf-fonts',
		nyfdf_get_google_fonts_url(),
		[],
		null
	);

	wp_enqueue_style(
		'nyfdf-style',
		get_template_directory_uri() . '/assets/css/style.css',
		[ 'nyfdf-fonts' ],
		wp_get_theme()->get( 'Version' )
	);

	wp_add_inline_style( 'nyfdf-style', nyfdf_get_color_css() );
	wp_add_inline_style( 'nyfdf-style', nyfdf_get_font_css() );

	wp_enqueue_script(
		'nyfdf-site',
		get_template_directory_uri() . '/assets/js/site.js',
		[],
		wp_get_theme()->get( 'Version' ),
		true
	);
}
