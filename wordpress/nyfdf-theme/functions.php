<?php
defined( 'ABSPATH' ) || exit;

foreach ( [ 'cpt', 'taxonomies', 'fields', 'enqueue', 'template-tags', 'customizer' ] as $file ) {
	require_once get_template_directory() . '/inc/' . $file . '.php';
}

add_action( 'after_setup_theme', 'nyfdf_theme_setup' );

function nyfdf_theme_setup(): void {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', [
		'width'       => 200,
		'height'      => 200,
		'flex-width'  => true,
		'flex-height' => true,
	] );
	add_theme_support( 'html5', [
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style',
	] );

	register_nav_menus( [
		'primary' => 'Primary Navigation',
		'footer'  => 'Footer Navigation',
	] );

	add_image_size( 'programme-card',   600, 400, true );
	add_image_size( 'programme-hero',  1400, 600, true );
	add_image_size( 'programme-single', 900, 500, true );
}

// Flush rewrite rules on theme activation so CPT permalinks work immediately.
add_action( 'after_switch_theme', function () {
	nyfdf_register_post_types();
	flush_rewrite_rules();
} );

/**
 * Warn in wp-admin when CMB2 isn't active, instead of letting the front end
 * fatal on the first cmb2_get_option() call. All template calls are routed
 * through nyfdf_cmb2_get_option(), which falls back to defaults when CMB2
 * is missing, so the site itself stays up — this notice just tells the
 * admin what to install to unlock full editing.
 */
add_action( 'admin_notices', 'nyfdf_cmb2_missing_notice' );

function nyfdf_cmb2_missing_notice(): void {
	if ( function_exists( 'cmb2_get_option' ) || ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	$install_url = wp_nonce_url(
		self_admin_url( 'update.php?action=install-plugin&plugin=cmb2' ),
		'install-plugin_cmb2'
	);
	?>
	<div class="notice notice-warning">
		<p>
			<strong>NYFDI theme:</strong> the CMB2 plugin isn't active, so Hero, About,
			Programmes, Leadership, and other content sections are showing built-in
			placeholder text instead of your real content.
			<a href="<?php echo esc_url( $install_url ); ?>">Install &amp; activate CMB2</a>
			to edit them via NYFDI Settings in wp-admin.
		</p>
	</div>
	<?php
}
