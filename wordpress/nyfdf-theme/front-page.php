<?php get_header(); ?>

<?php
$nyfdf_section_map = nyfdf_home_section_map();
foreach ( nyfdf_get_home_sections() as $nyfdf_section_key ) {
	get_template_part( $nyfdf_section_map[ $nyfdf_section_key ] );
}
?>

<?php get_footer(); ?>
