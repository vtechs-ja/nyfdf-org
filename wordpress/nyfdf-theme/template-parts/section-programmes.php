<?php
$intro          = nyfdf_cmb2_get_option( 'nyfdf_programmes', 'programmes_intro', '' );
$has_banner     = nyfdf_option_img_exists( 'nyfdf_programmes', 'programmes_banner_image' );
$all_programmes = nyfdf_get_programmes( exclude_flagship: true );

$home_limit  = 6;
$programmes  = array_slice( $all_programmes, 0, $home_limit );
$has_more    = count( $all_programmes ) > $home_limit;

$flagship = nyfdf_get_flagship();
if ( $flagship ) {
	$flagship_desc     = get_post_meta( $flagship->ID, 'programme_short_description', true );
	$flagship_excerpt  = get_the_excerpt( $flagship->ID );
	$flagship_timeline = nyfdf_get_timeline( $flagship->ID );
}
?>

<section id="programmes">
  <div class="programmes-header">
    <div>
      <div class="section-eyebrow">
        <div class="section-eyebrow-line"></div>
        <span>What We Do</span>
      </div>
      <h2 class="section-title">Programmes &amp;<br/><em>Initiatives</em></h2>
    </div>
    <?php if ( $intro ) : ?>
      <p class="programmes-intro"><?php echo esc_html( $intro ); ?></p>
    <?php endif; ?>
  </div>

  <?php if ( $has_banner ) : ?>
    <?php nyfdf_option_img( 'nyfdf_programmes', 'programmes_banner_image', 'full', 'Programmes in action', 'programmes-banner-img' ); ?>
  <?php else : ?>
  <div class="img-ph" style="aspect-ratio:16/5;margin-bottom:1px;">
    <span class="ph-icon">📷</span>
    <p class="ph-label">Programmes in Action</p>
    <p class="ph-hint">Upload a banner image via NYFDI Settings → Programmes Section</p>
  </div>
  <?php endif; ?>

  <?php if ( $flagship ) : ?>
  <div id="flagship" class="flagship-highlight">
    <div>
      <div class="section-eyebrow">
        <div class="section-eyebrow-line"></div>
        <span>Current Flagship Initiative</span>
      </div>
      <h3 class="flagship-highlight-title"><?php echo esc_html( get_the_title( $flagship->ID ) ); ?></h3>

      <?php if ( $flagship_desc ) : ?>
        <p class="flagship-body"><?php echo esc_html( $flagship_desc ); ?></p>
      <?php endif; ?>

      <?php if ( $flagship_excerpt && $flagship_excerpt !== $flagship_desc ) : ?>
        <p class="flagship-body flagship-body--secondary"><?php echo esc_html( $flagship_excerpt ); ?></p>
      <?php endif; ?>

      <a href="<?php echo esc_url( get_permalink( $flagship->ID ) ); ?>"
         class="btn-primary" style="background:var(--gold);color:var(--ink);margin-top:24px;">
        Learn More &rarr;
      </a>
    </div>

    <?php if ( ! empty( $flagship_timeline ) ) : ?>
    <div>
      <?php get_template_part( 'template-parts/programme-timeline', null, [
        'entries' => $flagship_timeline,
        'light'   => false,
      ] ); ?>
    </div>
    <?php endif; ?>
  </div>

  <div class="programmes-subheading">
    <span>Other Initiatives</span>
  </div>
  <?php endif; ?>

  <?php if ( ! empty( $programmes ) ) : ?>
  <div class="programme-grid">
    <?php foreach ( $programmes as $i => $programme ) :
      $order = get_post_meta( $programme->ID, 'programme_order', true ) ?: ( $i + 1 );
      $desc  = get_post_meta( $programme->ID, 'programme_short_description', true );
      $thumb = get_the_post_thumbnail( $programme->ID, 'thumbnail', [ 'class' => 'programme-card-thumb-img', 'alt' => '' ] );
    ?>
    <div class="programme-card">
      <a href="<?php echo esc_url( get_permalink( $programme->ID ) ); ?>">
        <?php if ( $thumb ) : ?>
          <div class="programme-card-thumb"><?php echo $thumb; ?></div>
        <?php endif; ?>
        <span class="programme-num"><?php echo esc_html( str_pad( (string) $order, 2, '0', STR_PAD_LEFT ) ); ?></span>
        <h3><?php echo esc_html( get_the_title( $programme->ID ) ); ?></h3>
        <?php if ( $desc ) : ?>
          <p><?php echo esc_html( $desc ); ?></p>
        <?php endif; ?>
        <span class="programme-card-link">Learn More &rarr;</span>
      </a>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <?php if ( $has_more ) : ?>
  <div class="programmes-view-all">
    <a href="<?php echo esc_url( get_post_type_archive_link( 'nyfdf_programme' ) ); ?>" class="btn-outline-dark">
      View All Programmes &rarr;
    </a>
  </div>
  <?php endif; ?>
</section>
