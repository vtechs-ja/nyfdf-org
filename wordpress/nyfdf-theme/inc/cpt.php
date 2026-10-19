<?php
defined( 'ABSPATH' ) || exit;

add_action( 'init', 'nyfdf_register_post_types' );

function nyfdf_register_post_types(): void {

	register_post_type( 'nyfdf_programme', [
		'labels' => [
			'name'               => 'Programmes',
			'singular_name'      => 'Programme',
			'add_new_item'       => 'Add New Programme',
			'edit_item'          => 'Edit Programme',
			'new_item'           => 'New Programme',
			'view_item'          => 'View Programme',
			'search_items'       => 'Search Programmes',
			'not_found'          => 'No programmes found',
			'not_found_in_trash' => 'No programmes found in trash',
			'all_items'          => 'All Programmes',
		],
		'public'        => true,
		'has_archive'   => true,
		'rewrite'       => [ 'slug' => 'programmes', 'with_front' => false ],
		'supports'      => [ 'title', 'editor', 'thumbnail' ],
		'menu_icon'     => 'dashicons-heart',
		'menu_position' => 5,
		'show_in_rest'  => true,
	] );

	register_post_type( 'nyfdf_reach', [
		'labels' => [
			'name'               => 'Reach Cards',
			'singular_name'      => 'Reach Card',
			'add_new_item'       => 'Add New Reach Card',
			'edit_item'          => 'Edit Reach Card',
			'not_found'          => 'No reach cards found',
			'not_found_in_trash' => 'No reach cards found in trash',
			'all_items'          => 'All Reach Cards',
		],
		'public'        => false,
		'show_ui'       => true,
		'supports'      => [ 'title' ],
		'menu_icon'     => 'dashicons-location-alt',
		'menu_position' => 6,
		'show_in_rest'  => false,
	] );
}
