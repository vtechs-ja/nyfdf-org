<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<nav>
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-brand">
    <?php
    $logo_id = get_theme_mod( 'custom_logo' );
    if ( $logo_id ) {
        echo wp_get_attachment_image( $logo_id, 'thumbnail', false, [ 'class' => 'nav-logo', 'alt' => get_bloginfo( 'name' ) ] );
    }
    ?>
    <div class="nav-name"><?php echo esc_html( nyfdf_get_org_name() ); ?></div>
  </a>

  <?php
  wp_nav_menu( [
    'theme_location' => 'primary',
    'container'      => false,
    'menu_class'     => 'nav-links',
    'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
    'fallback_cb'    => 'nyfdf_primary_nav_fallback',
  ] );
  ?>

  <button class="nav-toggle" aria-label="Toggle navigation" aria-expanded="false">
    <span></span>
    <span></span>
    <span></span>
  </button>
</nav>
