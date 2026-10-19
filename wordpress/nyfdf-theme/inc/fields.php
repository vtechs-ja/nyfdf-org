<?php
defined( 'ABSPATH' ) || exit;

add_action( 'cmb2_admin_init', 'nyfdf_register_options_pages' );
add_action( 'cmb2_admin_init', 'nyfdf_register_cpt_fields' );

// ──────────────────────────────────────────────
// OPTIONS PAGES
// ──────────────────────────────────────────────

function nyfdf_register_options_pages(): void {

	// ── Site Settings (parent menu item) ──────────────────

	$settings = new_cmb2_box( [
		'id'           => 'nyfdf_settings',
		'title'        => 'NYFDI Settings',
		'object_types' => [ 'options-page' ],
		'option_key'   => 'nyfdf_settings',
		'icon_url'     => 'dashicons-heart',
		'capability'   => 'manage_options',
		'position'     => 25,
	] );

	$settings->add_field( [ 'name' => 'Address',           'id' => 'site_address',            'type' => 'text', 'default' => 'Ocho Rios, Saint Ann, Jamaica' ] );
	$settings->add_field( [ 'name' => 'Email',             'id' => 'site_email',              'type' => 'text' ] );
	$settings->add_field( [ 'name' => 'Phone',             'id' => 'site_phone',              'type' => 'text' ] );
	$settings->add_field( [ 'name' => 'WhatsApp Number',   'id' => 'site_whatsapp',           'type' => 'text', 'desc' => 'Include country code, e.g. +18761234567' ] );
	$settings->add_field( [ 'name' => 'Facebook Page URL', 'id' => 'site_facebook_url',       'type' => 'text_url', 'default' => 'https://www.facebook.com/nyfdf/' ] );
	$settings->add_field( [ 'name' => 'Instagram Handle',  'id' => 'site_instagram_handle',   'type' => 'text', 'desc' => 'Without @', 'default' => 'nyfdfoundation' ] );
	$settings->add_field( [ 'name' => 'YouTube Handle',    'id' => 'site_youtube_handle',     'type' => 'text', 'desc' => 'Without @', 'default' => 'nyfdf' ] );
	$settings->add_field( [ 'name' => 'YouTube Uploads Playlist ID', 'id' => 'site_youtube_playlist_id', 'type' => 'text', 'desc' => 'Optional — enables an embedded video feed in the Follow Along section. Find it on the channel\'s "Videos" tab under Playlists (starts with "UU").' ] );
	$settings->add_field( [ 'name' => 'X / Twitter Handle','id' => 'site_twitter_handle',     'type' => 'text', 'desc' => 'Without @', 'default' => 'nyfdf' ] );
	$settings->add_field( [
		'name' => 'Gold Band Items',
		'id'   => 'gold_band_items',
		'type' => 'textarea_small',
		'desc' => 'One focus area label per line.',
		'default' => "Youth Empowerment\nFamily Development\nCharacter Education\nHealth Outreach\nParenting Programmes\nTechnology Access\nCommunity Outreach\nGrief Counselling\nLeadership Development\nDisaster Recovery",
	] );
	$settings->add_field( [
		'name'            => 'Homepage Sections',
		'id'              => 'home_sections',
		'type'            => 'select',
		'desc'            => 'Add, remove, and drag rows to reorder the sections that appear on the homepage. If left empty, the theme\'s default order is used.',
		'options'         => nyfdf_home_section_labels(),
		'repeatable'      => true,
		'text'            => [ 'add_row_text' => 'Add Section' ],
		'sanitization_cb' => 'nyfdf_sanitize_home_sections',
	] );

	// ── Hero ──────────────────────────────────────────────

	$hero = new_cmb2_box( [
		'id'           => 'nyfdf_hero',
		'title'        => 'Hero Section',
		'object_types' => [ 'options-page' ],
		'option_key'   => 'nyfdf_hero',
		'parent_slug'  => 'nyfdf_settings',
	] );

	$hero->add_field( [
		'name'    => 'Hero Image',
		'id'      => 'hero_image',
		'type'    => 'file',
		'desc'    => 'Portrait orientation, min 900×1100px, warm natural light. Replaces the placeholder on the right side of the hero.',
		'options' => [ 'url' => false ],
		'query_args' => [ 'type' => 'image' ],
		'text'    => [ 'add_upload_file_text' => 'Upload Hero Image' ],
	] );
	$hero->add_field( [
		'name'    => 'Headline',
		'id'      => 'hero_headline',
		'type'    => 'textarea_small',
		'desc'    => 'Multi-line headline. Use line breaks to control wrapping.',
		'default' => "Empowering\nFamilies…\nDeveloping\nYouths…\nDefining the Future.",
	] );
	$hero->add_field( [ 'name' => 'Italic words (comma-separated)', 'id' => 'hero_headline_italic', 'type' => 'text', 'desc' => 'Words in the headline to italicise, e.g. "Families…,Future."', 'default' => 'Families…,Future.' ] );
	$hero->add_field( [ 'name' => 'Sub-paragraph', 'id' => 'hero_subtext', 'type' => 'textarea_small', 'default' => 'Founded in Jamaica and incorporated in 2008, NYFDI is a charitable organisation with more than eighteen years of commitment to youth empowerment, family development, education, and community transformation across Jamaica.' ] );
	$hero->add_field( [ 'name' => 'Primary CTA Label',   'id' => 'hero_cta_primary_label',    'type' => 'text', 'default' => 'Our Mission' ] );
	$hero->add_field( [ 'name' => 'Primary CTA Anchor',  'id' => 'hero_cta_primary_anchor',   'type' => 'text', 'default' => '#about' ] );
	$hero->add_field( [ 'name' => 'Secondary CTA Label', 'id' => 'hero_cta_secondary_label',  'type' => 'text', 'default' => 'What We Do' ] );
	$hero->add_field( [ 'name' => 'Secondary CTA Anchor','id' => 'hero_cta_secondary_anchor', 'type' => 'text', 'default' => '#programmes' ] );
	$hero->add_field( [ 'name' => 'Stat Card Quote',     'id' => 'hero_quote', 'type' => 'textarea_small', 'default' => '"The Call is to save the children. The Call is to redemptively impact the social systems within which our children are brought up — and to give them hope and faith for a brighter tomorrow."' ] );
	$hero->add_field( [ 'name' => 'Schools Stat',   'id' => 'hero_stat_schools',  'type' => 'text', 'default' => '30+' ] );
	$hero->add_field( [ 'name' => 'Parishes Stat',  'id' => 'hero_stat_parishes', 'type' => 'text', 'default' => '6+' ] );

	// ── About ────────────────────────────────────────────

	$about = new_cmb2_box( [
		'id'           => 'nyfdf_about',
		'title'        => 'About Section',
		'object_types' => [ 'options-page' ],
		'option_key'   => 'nyfdf_about',
		'parent_slug'  => 'nyfdf_settings',
	] );

	$about->add_field( [ 'name' => 'Body Paragraph 1', 'id' => 'about_body_1', 'type' => 'textarea', 'default' => 'The Northgate Youth and Family Development Initiatives (NYFDI) is an expression of a vision to participate in the process of nation building in a constructive and meaningful way. We believe that successful nation building requires a deliberate focus on the strategic development of young people — and the family structures to which they belong.' ] );
	$about->add_field( [ 'name' => 'Body Paragraph 2', 'id' => 'about_body_2', 'type' => 'textarea', 'default' => 'Growing out of more than ten years of youth and family development initiatives through the Northgate Centre for Global Impact, NYFDI was incorporated as a charitable organisation under the Companies Act of Jamaica on July 2, 2008. Our work spans education, health outreach, counselling, technology access, parenting empowerment, and sustained community development across Jamaica.' ] );
	$about->add_field( [ 'name' => 'Body Paragraph 3', 'id' => 'about_body_3', 'type' => 'textarea', 'default' => 'We also partner with corporate entities on organisational policy, team culture, and strategic development — bringing the same values-based framework to institutional work that guides our community programmes.' ] );
	$about->add_field( [ 'name' => 'Vision', 'id' => 'about_vision', 'type' => 'textarea_small', 'default' => 'Empowering Families … Developing Youths … Defining the Future' ] );
	$about->add_field( [ 'name' => 'Mission', 'id' => 'about_mission', 'type' => 'textarea', 'default' => 'To impact and build young people with strategic initiatives designed to develop sound morals and pristine character — equipping youth to become productive, prosperous citizens who realise their God-given potential in every area of life.' ] );
	$about->add_field( [ 'name' => 'Blockquote', 'id' => 'about_quote', 'type' => 'textarea_small', 'default' => '"We are committed to encouraging individuals and organisations to go beyond perceived limitations — to develop their fullest capacity and discover their God-ordained destinies."' ] );
	$about->add_field( [ 'name' => 'Quote Attribution', 'id' => 'about_quote_attribution', 'type' => 'text', 'default' => 'Wesley Boynes, JP · Founder & Chairman, NYFDI' ] );
	$about->add_field( [
		'name'    => 'Community Photo',
		'id'      => 'about_community_photo',
		'type'    => 'file',
		'desc'    => 'Candid team or community gathering, landscape ~600×380px.',
		'options' => [ 'url' => false ],
		'query_args' => [ 'type' => 'image' ],
		'text'    => [ 'add_upload_file_text' => 'Upload Photo' ],
	] );

	$aff_group = $about->add_field( [
		'id'         => 'about_affiliations',
		'type'       => 'group',
		'repeatable' => true,
		'options'    => [
			'group_title'   => 'Affiliation {#}',
			'add_button'    => 'Add Affiliation',
			'remove_button' => 'Remove',
			'sortable'      => true,
		],
	] );
	$about->add_group_field( $aff_group, [ 'name' => 'Organisation Name', 'id' => 'aff_name', 'type' => 'text' ] );
	$about->add_group_field( $aff_group, [
		'name'    => 'Logo',
		'id'      => 'aff_logo',
		'type'    => 'file',
		'options' => [ 'url' => false ],
		'query_args' => [ 'type' => 'image' ],
		'text'    => [ 'add_upload_file_text' => 'Upload Logo' ],
	] );
	$about->add_group_field( $aff_group, [ 'name' => 'URL (optional)', 'id' => 'aff_url', 'type' => 'text_url' ] );

	// ── Pillars ───────────────────────────────────────────

	$pillars = new_cmb2_box( [
		'id'           => 'nyfdf_pillars',
		'title'        => 'Core Values / Pillars',
		'object_types' => [ 'options-page' ],
		'option_key'   => 'nyfdf_pillars',
		'parent_slug'  => 'nyfdf_settings',
	] );

	$pillar_group = $pillars->add_field( [
		'id'         => 'pillars',
		'type'       => 'group',
		'repeatable' => true,
		'options'    => [
			'group_title'   => 'Pillar {#}',
			'add_button'    => 'Add Pillar',
			'remove_button' => 'Remove',
			'sortable'      => true,
		],
	] );
	$pillars->add_group_field( $pillar_group, [ 'name' => 'Icon', 'id' => 'pillar_icon', 'type' => 'text', 'desc' => 'Emoji character, e.g. 🌱' ] );
	$pillars->add_group_field( $pillar_group, [ 'name' => 'Title', 'id' => 'pillar_title', 'type' => 'text' ] );
	$pillars->add_group_field( $pillar_group, [ 'name' => 'Description', 'id' => 'pillar_description', 'type' => 'textarea_small' ] );

	// ── Programmes ────────────────────────────────────────

	$programmes = new_cmb2_box( [
		'id'           => 'nyfdf_programmes',
		'title'        => 'Programmes Section',
		'object_types' => [ 'options-page' ],
		'option_key'   => 'nyfdf_programmes',
		'parent_slug'  => 'nyfdf_settings',
	] );

	$programmes->add_field( [ 'name' => 'Section Intro', 'id' => 'programmes_intro', 'type' => 'textarea_small', 'default' => 'Our programming is values-driven and community-shaped. From school-based character development to health clinics, parenting empowerment, and technology training — every initiative is designed to develop the whole person and build stronger families and communities.' ] );
	$programmes->add_field( [
		'name'    => 'Banner Image',
		'id'      => 'programmes_banner_image',
		'type'    => 'file',
		'desc'    => 'Wide banner from a health fair, school session, or outreach activity, ~1400×500px.',
		'options' => [ 'url' => false ],
		'query_args' => [ 'type' => 'image' ],
		'text'    => [ 'add_upload_file_text' => 'Upload Banner' ],
	] );

	// ── Leadership ────────────────────────────────────────

	$leadership = new_cmb2_box( [
		'id'           => 'nyfdf_leadership',
		'title'        => 'Leadership Section',
		'object_types' => [ 'options-page' ],
		'option_key'   => 'nyfdf_leadership',
		'parent_slug'  => 'nyfdf_settings',
	] );

	$leadership->add_field( [ 'name' => 'Founder Name', 'id' => 'founder_name', 'type' => 'text', 'default' => 'Wesley Curwin Boynes, JP' ] );
	$leadership->add_field( [ 'name' => 'Founder Title', 'id' => 'founder_title', 'type' => 'text', 'default' => 'Founder & Chairman · Justice of the Peace, St. Mary' ] );
	$leadership->add_field( [
		'name'    => 'Founder Photo',
		'id'      => 'founder_photo',
		'type'    => 'file',
		'options' => [ 'url' => false ],
		'query_args' => [ 'type' => 'image' ],
		'text'    => [ 'add_upload_file_text' => 'Upload Photo' ],
	] );
	$leadership->add_field( [ 'name' => 'Founder Bio', 'id' => 'founder_bio', 'type' => 'textarea', 'default' => 'Born in San Fernando, Trinidad and Tobago, Wesley Boynes has spent more than two decades in strategic leadership, community development, and human capacity building across Jamaica. He serves as Senior Elder at Philadelphia Life Centre, has been a Justice of the Peace for St. Mary since 2018, and is a current board leader in Jamaican independent education. He calls himself simply a life developer — driven by the belief that every person carries unrealised potential waiting to be unlocked.' ] );

	$highlight_group = $leadership->add_field( [
		'id'         => 'founder_highlights',
		'type'       => 'group',
		'repeatable' => true,
		'options'    => [
			'group_title'   => 'Highlight {#}',
			'add_button'    => 'Add Highlight',
			'remove_button' => 'Remove',
			'sortable'      => true,
		],
	] );
	$leadership->add_group_field( $highlight_group, [ 'name' => 'Highlight', 'id' => 'highlight_text', 'type' => 'text' ] );

	$leadership->add_field( [
		'name' => '',
		'id'   => 'governance_title_divider',
		'type' => 'title',
		'before_row' => '<hr style="margin:24px 0">',
		'name' => 'Governance Structure',
	] );

	$governance_group = $leadership->add_field( [
		'id'         => 'governance_tiers',
		'type'       => 'group',
		'repeatable' => true,
		'options'    => [
			'group_title'   => 'Tier {#}',
			'add_button'    => 'Add Tier',
			'remove_button' => 'Remove',
			'sortable'      => true,
		],
	] );
	$leadership->add_group_field( $governance_group, [ 'name' => 'Tier Name',    'id' => 'tier_title',       'type' => 'text' ] );
	$leadership->add_group_field( $governance_group, [ 'name' => 'Named Lead',   'id' => 'tier_named_lead',  'type' => 'text', 'desc' => 'Optional — e.g. "Chaired by Pastor Wesley Boynes"' ] );
	$leadership->add_group_field( $governance_group, [ 'name' => 'Description',  'id' => 'tier_description', 'type' => 'textarea_small' ] );

	// ── Awards ────────────────────────────────────────────

	$awards = new_cmb2_box( [
		'id'           => 'nyfdf_awards',
		'title'        => 'Awards & Recognition',
		'object_types' => [ 'options-page' ],
		'option_key'   => 'nyfdf_awards',
		'parent_slug'  => 'nyfdf_settings',
	] );

	$award_group = $awards->add_field( [
		'id'         => 'awards',
		'type'       => 'group',
		'repeatable' => true,
		'options'    => [
			'group_title'   => 'Award {#}',
			'add_button'    => 'Add Award',
			'remove_button' => 'Remove',
			'sortable'      => true,
		],
	] );
	$awards->add_group_field( $award_group, [ 'name' => 'Source',      'id' => 'award_source',      'type' => 'text' ] );
	$awards->add_group_field( $award_group, [ 'name' => 'Description', 'id' => 'award_description', 'type' => 'textarea_small' ] );

	// ── Connect ───────────────────────────────────────────

	$connect = new_cmb2_box( [
		'id'           => 'nyfdf_connect',
		'title'        => 'Connect Section',
		'object_types' => [ 'options-page' ],
		'option_key'   => 'nyfdf_connect',
		'parent_slug'  => 'nyfdf_settings',
	] );

	$connect->add_field( [ 'name' => 'Section Intro', 'id' => 'connect_intro', 'type' => 'textarea_small', 'default' => 'All live content — events, photos, announcements, and updates — is published across our official channels. Follow us on your preferred platform.' ] );
}

/**
 * CMB2's repeatable "select" field can leave a stray extra row behind on
 * save (an unset row falls back to the first <option>, "Hero"). Clean the
 * value on the way into the database so the admin screen itself stays
 * accurate, not just the front-end render.
 */
function nyfdf_sanitize_home_sections( $value, $field_args, $field ) {
	if ( ! is_array( $value ) ) {
		return $value;
	}
	$map   = nyfdf_home_section_map();
	$clean = array_filter( $value, static fn( $key ) => isset( $map[ $key ] ) );
	return array_values( array_unique( $clean ) );
}

// ──────────────────────────────────────────────
// CPT META BOXES
// ──────────────────────────────────────────────

function nyfdf_register_cpt_fields(): void {

	// ── Programme ─────────────────────────────────────────

	$prog = new_cmb2_box( [
		'id'           => 'nyfdf_programme_meta',
		'title'        => 'Programme Details',
		'object_types' => [ 'nyfdf_programme' ],
		'context'      => 'normal',
		'priority'     => 'high',
	] );

	$prog->add_field( [ 'name' => 'Display Order', 'id' => 'programme_order', 'type' => 'text_small', 'desc' => 'Controls position in the homepage grid. Lower numbers appear first.', 'attributes' => [ 'type' => 'number' ] ] );
	$prog->add_field( [ 'name' => 'Short Description', 'id' => 'programme_short_description', 'type' => 'textarea_small', 'desc' => 'Shown on the homepage grid card and the programmes archive.' ] );
	$prog->add_field( [
		'name'    => 'Impact / Outcomes',
		'id'      => 'programme_impact',
		'type'    => 'wysiwyg',
		'desc'    => 'Displayed on the programme\'s individual page. Use bullet points to list outcomes.',
		'options' => [
			'textarea_rows' => 8,
			'teeny'         => true,
			'media_buttons' => false,
		],
	] );
	$prog->add_field( [
		'name'       => 'Photo Gallery (optional)',
		'id'         => 'programme_gallery',
		'type'       => 'file_list',
		'desc'       => 'Optional photos shown in a gallery on this programme\'s own page. Landscape or square images work best.',
		'text'       => [ 'add_upload_files_text' => 'Add Images' ],
		'query_args' => [ 'type' => 'image' ],
	] );
	$prog->add_field( [
		'name' => 'Current Flagship Programme',
		'id'   => 'programme_is_flagship',
		'type' => 'checkbox',
		'desc' => 'If checked, this programme is featured in the homepage flagship section. Only one programme should have this checked at a time.',
	] );

	$timeline_group = $prog->add_field( [
		'id'         => 'programme_timeline',
		'type'       => 'group',
		'desc'       => 'Timeline entries are shown in the flagship homepage section and on this programme\'s page.',
		'repeatable' => true,
		'options'    => [
			'group_title'   => 'Entry {#}',
			'add_button'    => 'Add Timeline Entry',
			'remove_button' => 'Remove',
			'sortable'      => true,
		],
	] );
	$prog->add_group_field( $timeline_group, [ 'name' => 'Month / Step Number', 'id' => 'month_number',       'type' => 'text_small', 'desc' => 'Display numeral, e.g. 1, 2, 3' ] );
	$prog->add_group_field( $timeline_group, [ 'name' => 'Date Tag',            'id' => 'date_tag',           'type' => 'text',       'desc' => 'e.g. "March 2026 — Complete"' ] );
	$prog->add_group_field( $timeline_group, [ 'name' => 'Event Name',          'id' => 'event_name',         'type' => 'text' ] );
	$prog->add_group_field( $timeline_group, [ 'name' => 'Description',         'id' => 'event_description',  'type' => 'textarea_small' ] );
	$prog->add_group_field( $timeline_group, [ 'name' => 'Complete',            'id' => 'is_complete',        'type' => 'checkbox', 'desc' => 'Mark this entry as complete' ] );

	// ── Reach Card ────────────────────────────────────────

	$reach = new_cmb2_box( [
		'id'           => 'nyfdf_reach_meta',
		'title'        => 'Reach Card Details',
		'object_types' => [ 'nyfdf_reach' ],
		'context'      => 'normal',
		'priority'     => 'high',
	] );

	$reach->add_field( [ 'name' => 'Category Label', 'id' => 'reach_label',       'type' => 'text_small', 'desc' => 'Small label above the card title, e.g. "Education"' ] );
	$reach->add_field( [ 'name' => 'Description',    'id' => 'reach_description', 'type' => 'textarea_small' ] );
	$reach->add_field( [ 'name' => 'Display Order',  'id' => 'reach_order',       'type' => 'text_small', 'attributes' => [ 'type' => 'number' ] ] );
}
