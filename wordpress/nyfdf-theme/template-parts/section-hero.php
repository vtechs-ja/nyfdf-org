<?php
$logo_id        = get_theme_mod( 'custom_logo' );
$headline       = nyfdf_cmb2_get_option( 'nyfdf_hero', 'hero_headline', "Empowering\nFamilies…\nDeveloping\nYouths…\nDefining the Future." );
$italic_words   = array_filter( array_map( 'trim', explode( ',', nyfdf_cmb2_get_option( 'nyfdf_hero', 'hero_headline_italic', 'Families…,Future.' ) ) ) );
$subtext        = nyfdf_cmb2_get_option( 'nyfdf_hero', 'hero_subtext', '' );
$cta_p_label    = nyfdf_cmb2_get_option( 'nyfdf_hero', 'hero_cta_primary_label', 'Our Mission' );
$cta_p_anchor   = nyfdf_cmb2_get_option( 'nyfdf_hero', 'hero_cta_primary_anchor', '#about' );
$cta_s_label    = nyfdf_cmb2_get_option( 'nyfdf_hero', 'hero_cta_secondary_label', 'What We Do' );
$cta_s_anchor   = nyfdf_cmb2_get_option( 'nyfdf_hero', 'hero_cta_secondary_anchor', '#programmes' );
$quote          = nyfdf_cmb2_get_option( 'nyfdf_hero', 'hero_quote', '' );
$stat_schools   = nyfdf_cmb2_get_option( 'nyfdf_hero', 'hero_stat_schools', '30+' );
$stat_parishes  = nyfdf_cmb2_get_option( 'nyfdf_hero', 'hero_stat_parishes', '6+' );

// Build headline HTML: wrap italic words in <em>
$lines = explode( "\n", esc_html( $headline ) );
$headline_html = '';
foreach ( $lines as $line ) {
    foreach ( $italic_words as $word ) {
        $line = str_replace( esc_html( $word ), '<em>' . esc_html( $word ) . '</em>', $line );
    }
    $headline_html .= $line . '<br/>';
}
$headline_html = rtrim( $headline_html, '<br/>' );

$has_hero_img = nyfdf_option_img_exists( 'nyfdf_hero', 'hero_image' );
?>

<section class="hero" id="home">
  <?php if ( $has_hero_img ) : ?>
    <?php nyfdf_option_img( 'nyfdf_hero', 'hero_image', 'full', 'Community outreach', 'hero-img' ); ?>
  <?php endif; ?>

  <div class="hero-overlay"></div>
  <div class="hero-bg-pattern"></div>

  <div class="hero-left">
    <?php if ( $logo_id ) : ?>
    <div class="hero-logo">
      <?php echo wp_get_attachment_image( $logo_id, 'medium', false, [ 'class' => 'hero-logo-img', 'alt' => get_bloginfo( 'name' ) ] ); ?>
    </div>
    <?php endif; ?>

    <div class="hero-eyebrow">
      <div class="hero-eyebrow-line"></div>
      <span><?php echo esc_html( nyfdf_get_org_name() ); ?></span>
    </div>

    <h1><?php echo $headline_html; ?></h1>

    <?php if ( $subtext ) : ?>
    <p class="hero-sub"><?php echo esc_html( $subtext ); ?></p>
    <?php endif; ?>

    <div class="hero-actions">
      <a href="<?php echo esc_url( $cta_p_anchor ); ?>" class="btn-primary">
        <?php echo esc_html( $cta_p_label ); ?>
      </a>
      <a href="<?php echo esc_url( $cta_s_anchor ); ?>" class="btn-outline">
        <?php echo esc_html( $cta_s_label ); ?>
      </a>
    </div>
  </div>

  <div class="hero-right">
    <?php if ( ! $has_hero_img ) : ?>
    <div class="hero-ph">
      <span class="ph-icon">📷</span>
      <p class="ph-label">Community Photo</p>
      <p class="ph-hint">Upload a hero image via NYFDI Settings → Hero Section. Wide/landscape, min 1920×1080px — it will span the full section as a background.</p>
    </div>
    <?php endif; ?>

    <div class="hero-stat-card">
      <?php if ( $quote ) : ?>
      <p><?php echo esc_html( $quote ); ?></p>
      <?php endif; ?>
      <div class="stat-row">
        <div class="stat-item">
          <span class="stat-num" id="stat-years">18+</span>
          <span class="stat-label">Years of Service</span>
        </div>
        <div class="stat-item">
          <span class="stat-num"><?php echo esc_html( $stat_schools ); ?></span>
          <span class="stat-label">Schools Reached</span>
        </div>
        <div class="stat-item">
          <span class="stat-num">2008</span>
          <span class="stat-label">Incorporated</span>
        </div>
        <div class="stat-item">
          <span class="stat-num"><?php echo esc_html( $stat_parishes ); ?></span>
          <span class="stat-label">Parishes Active</span>
        </div>
      </div>
    </div>
  </div>
</section>
