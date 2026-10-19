<?php
defined( 'ABSPATH' ) || exit;

/**
 * Safe wrapper around CMB2's cmb2_get_option(). Falls back to $default when
 * the CMB2 plugin isn't installed/active, so a missing dependency degrades
 * to the theme's built-in defaults instead of a fatal error.
 */
function nyfdf_cmb2_get_option( string $option_key, string $field_id, $default = '' ) {
	if ( ! function_exists( 'cmb2_get_option' ) ) {
		return $default;
	}
	return cmb2_get_option( $option_key, $field_id, $default );
}

/**
 * The organisation's full legal/display name (distinct from the short
 * site title "NYFDI"). Sourced from Settings → General → Tagline so it
 * only needs to be set in one place.
 */
function nyfdf_get_org_name(): string {
	return get_bloginfo( 'description' );
}

/**
 * Returns the programme marked as flagship, or null if none is set.
 */
function nyfdf_get_flagship(): ?WP_Post {
	$query = new WP_Query( [
		'post_type'      => 'nyfdf_programme',
		'posts_per_page' => 1,
		'meta_query'     => [ [ 'key' => 'programme_is_flagship', 'value' => 'on' ] ],
		'no_found_rows'  => true,
	] );
	return $query->have_posts() ? $query->posts[0] : null;
}

/**
 * Returns all programmes ordered by programme_order.
 *
 * @param bool $exclude_flagship Exclude the current flagship from results.
 */
function nyfdf_get_programmes( bool $exclude_flagship = false ): array {
	$args = [
		'post_type'              => 'nyfdf_programme',
		'posts_per_page'         => -1,
		'orderby'                => 'meta_value_num',
		'meta_key'               => 'programme_order',
		'order'                  => 'ASC',
		'no_found_rows'          => true,
		'update_post_meta_cache' => true,
	];

	if ( $exclude_flagship ) {
		$args['meta_query'] = [
			'relation' => 'OR',
			[ 'key' => 'programme_is_flagship', 'compare' => 'NOT EXISTS' ],
			[ 'key' => 'programme_is_flagship', 'value' => 'on', 'compare' => '!=' ],
		];
	}

	return ( new WP_Query( $args ) )->posts;
}

/**
 * Returns all reach cards ordered by reach_order.
 */
function nyfdf_get_reach_cards(): array {
	return ( new WP_Query( [
		'post_type'              => 'nyfdf_reach',
		'posts_per_page'         => -1,
		'orderby'                => 'meta_value_num',
		'meta_key'               => 'reach_order',
		'order'                  => 'ASC',
		'no_found_rows'          => true,
		'update_post_meta_cache' => true,
	] ) )->posts;
}

/**
 * Returns the timeline entries for a given programme post ID.
 */
function nyfdf_get_timeline( int $post_id ): array {
	$entries = get_post_meta( $post_id, 'programme_timeline', true );
	return is_array( $entries ) ? $entries : [];
}

/**
 * Returns the gold band items as an array from the Site Settings option.
 */
function nyfdf_get_gold_band_items(): array {
	$raw = nyfdf_cmb2_get_option( 'nyfdf_settings', 'gold_band_items', '' );
	if ( empty( $raw ) ) {
		return [];
	}
	return array_filter( array_map( 'trim', explode( "\n", $raw ) ) );
}

/**
 * Outputs a CMB2 file field as an <img> tag, using attachment ID when available
 * for responsive image support.
 *
 * @param string $option_key CMB2 option key.
 * @param string $field_id   Field ID (base, without _id suffix).
 * @param string $size       WP image size.
 * @param string $alt        Alt text.
 * @param string $class      CSS class(es).
 */
function nyfdf_option_img( string $option_key, string $field_id, string $size = 'large', string $alt = '', string $class = '' ): void {
	$id  = (int) nyfdf_cmb2_get_option( $option_key, $field_id . '_id', 0 );
	$url = nyfdf_cmb2_get_option( $option_key, $field_id, '' );

	if ( $id ) {
		$attrs = $class ? [ 'class' => $class ] : [];
		echo wp_get_attachment_image( $id, $size, false, $attrs );
	} elseif ( $url ) {
		printf(
			'<img src="%s" alt="%s"%s>',
			esc_url( $url ),
			esc_attr( $alt ),
			$class ? ' class="' . esc_attr( $class ) . '"' : ''
		);
	}
}

/**
 * Returns true if a CMB2 file field has an image set.
 */
function nyfdf_option_img_exists( string $option_key, string $field_id ): bool {
	return (bool) nyfdf_cmb2_get_option( $option_key, $field_id . '_id', 0 )
		|| (bool) nyfdf_cmb2_get_option( $option_key, $field_id, '' );
}

/**
 * Returns a programme's optional photo gallery as a list of
 * [ 'id' => attachment ID, 'url' => fallback URL ] pairs.
 */
function nyfdf_get_programme_gallery( int $post_id ): array {
	$raw = get_post_meta( $post_id, 'programme_gallery', true );
	if ( empty( $raw ) || ! is_array( $raw ) ) {
		return [];
	}
	$images = [];
	foreach ( $raw as $id => $url ) {
		$images[] = [ 'id' => (int) $id, 'url' => $url ];
	}
	return $images;
}

/**
 * Homepage section keys mapped to their template part path. This is the
 * single source of truth for what "sections" exist — both the admin
 * picker (fields.php) and front-page.php's render loop read from it.
 */
function nyfdf_home_section_map(): array {
	return [
		'hero'        => 'template-parts/section-hero',
		'gold_band'   => 'template-parts/section-gold-band',
		'about'       => 'template-parts/section-about',
		'pillars'     => 'template-parts/section-pillars',
		'programmes'  => 'template-parts/section-programmes',
		'reach'       => 'template-parts/section-reach',
		'leadership'  => 'template-parts/section-leadership',
		'social_feed' => 'template-parts/section-social-feed',
		'connect'     => 'template-parts/section-connect',
	];
}

/**
 * Admin-facing labels for the section picker, keyed the same as the map above.
 */
function nyfdf_home_section_labels(): array {
	return [
		'hero'        => 'Hero',
		'gold_band'   => 'Gold Band',
		'about'       => 'About',
		'pillars'     => 'Pillars',
		'programmes'  => 'Programmes (includes Flagship Initiative)',
		'reach'       => 'Reach',
		'leadership'  => 'Leadership',
		'social_feed' => 'Social Feed',
		'connect'     => 'Connect',
	];
}

/**
 * Returns the ordered list of homepage section keys to render. CMB2
 * repeatable fields have no 'default', so a fresh install with nothing
 * saved yet falls back to the theme's original section order instead of
 * rendering a blank homepage. Unknown/stale keys (e.g. from a renamed or
 * removed section) are silently dropped.
 */
function nyfdf_get_home_sections(): array {
	$map   = nyfdf_home_section_map();
	$saved = nyfdf_cmb2_get_option( 'nyfdf_settings', 'home_sections', [] );

	if ( empty( $saved ) || ! is_array( $saved ) ) {
		return array_keys( $map );
	}

	// CMB2's repeatable "select" field can leave a stray extra row behind on
	// save (a known quirk — an unset row falls back to the first <option>,
	// "Hero"). A homepage section should never render twice regardless, so
	// de-duplicate defensively rather than depend on the admin screen being
	// clean.
	$valid = array_filter( $saved, static fn( $key ) => isset( $map[ $key ] ) );
	return array_values( array_unique( $valid ) );
}

/**
 * Fallback rendered when no primary nav menu is assigned.
 */
function nyfdf_primary_nav_fallback(): void {
	$home = esc_url( home_url( '/' ) );
	echo '<ul class="nav-links">'
		. '<li><a href="' . $home . '#about">About</a></li>'
		. '<li><a href="' . $home . '#programmes">Programmes</a></li>'
		. '<li><a href="' . $home . '#reach">Our Reach</a></li>'
		. '<li><a href="' . $home . '#leadership">Leadership</a></li>'
		. '<li><a href="' . $home . '#flagship">Current Initiative</a></li>'
		. '<li><a href="' . $home . '#connect" class="nav-cta">Connect</a></li>'
		. '</ul>';
}
