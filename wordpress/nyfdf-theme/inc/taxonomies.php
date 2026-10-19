<?php
defined( 'ABSPATH' ) || exit;

add_action( 'init', 'nyfdf_register_taxonomies' );

function nyfdf_register_taxonomies(): void {

	register_taxonomy( 'nyfdf_reach_category', [ 'nyfdf_reach' ], [
		'labels' => [
			'name'          => 'Reach Categories',
			'singular_name' => 'Reach Category',
			'add_new_item'  => 'Add New Category',
			'edit_item'     => 'Edit Category',
			'all_items'     => 'All Categories',
		],
		'hierarchical'      => false,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => false,
		'rewrite'           => false,
	] );
}
