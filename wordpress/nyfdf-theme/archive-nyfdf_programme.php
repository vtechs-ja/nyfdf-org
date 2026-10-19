<?php get_header();
$flagship    = nyfdf_get_flagship();
$all         = nyfdf_get_programmes();
$flagship_id = $flagship ? $flagship->ID : 0;
$intro       = nyfdf_cmb2_get_option( 'nyfdf_programmes', 'programmes_intro', '' );
?>

<!-- Archive Header -->
<div class="archive-header">
  <div class="archive-header-bg"></div>
  <div class="archive-header-content">
    <div class="section-eyebrow">
      <div class="section-eyebrow-line"></div>
      <span>What We Do</span>
    </div>
    <h1 class="section-title">Our <em>Programmes</em></h1>
    <?php if ( $intro ) : ?>
      <p class="archive-header-intro"><?php echo esc_html( $intro ); ?></p>
    <?php endif; ?>
  </div>
</div>

<!-- Featured Programme -->
<?php if ( $flagship ) :
  $f_desc     = get_post_meta( $flagship_id, 'programme_short_description', true );
  $f_timeline = nyfdf_get_timeline( $flagship_id );
  $f_thumb    = get_the_post_thumbnail_url( $flagship_id, 'programme-hero' );
?>
<div class="featured-programme">
  <div class="featured-programme-content">
    <div class="section-eyebrow">
      <div class="section-eyebrow-line"></div>
      <span>Current Initiative</span>
    </div>
    <h2 class="featured-programme-title">
      <?php echo esc_html( get_the_title( $flagship_id ) ); ?>
    </h2>
    <?php if ( $f_desc ) : ?>
      <p class="featured-programme-desc"><?php echo esc_html( $f_desc ); ?></p>
    <?php endif; ?>

    <?php if ( ! empty( $f_timeline ) ) : ?>
    <div class="featured-timeline-preview">
      <?php get_template_part( 'template-parts/programme-timeline', null, [
        'entries' => $f_timeline,
        'light'   => false,
        'limit'   => 2,
      ] ); ?>
    </div>
    <?php endif; ?>

    <a href="<?php echo esc_url( get_permalink( $flagship_id ) ); ?>" class="btn-outline">
      View Programme &rarr;
    </a>
  </div>

  <div class="featured-programme-image">
    <?php if ( $f_thumb ) : ?>
      <img src="<?php echo esc_url( $f_thumb ); ?>"
           alt="<?php echo esc_attr( get_the_title( $flagship_id ) ); ?>"/>
    <?php else : ?>
      <div class="featured-programme-image-ph"></div>
    <?php endif; ?>
  </div>
</div>
<?php endif; ?>

<!-- All Programmes Grid -->
<?php if ( ! empty( $all ) ) : ?>
<div class="archive-programmes-section">
  <div class="section-eyebrow">
    <div class="section-eyebrow-line"></div>
    <span>All Programmes</span>
  </div>

  <div class="archive-programme-grid">
    <?php foreach ( $all as $i => $programme ) :
      $pid         = $programme->ID;
      $order       = get_post_meta( $pid, 'programme_order', true ) ?: ( $i + 1 );
      $desc        = get_post_meta( $pid, 'programme_short_description', true );
      $is_flagship = ( $pid === $flagship_id );
      $thumb       = get_the_post_thumbnail_url( $pid, 'programme-card' );
    ?>
    <a href="<?php echo esc_url( get_permalink( $pid ) ); ?>" class="archive-programme-card">
      <div class="archive-card-image">
        <?php if ( $thumb ) : ?>
          <img src="<?php echo esc_url( $thumb ); ?>"
               alt="<?php echo esc_attr( get_the_title( $pid ) ); ?>"/>
        <?php else : ?>
          <div class="archive-card-image-ph"></div>
        <?php endif; ?>
      </div>
      <div class="archive-card-body">
        <div class="archive-card-meta">
          <span class="archive-card-num">
            <?php echo esc_html( str_pad( (string) $order, 2, '0', STR_PAD_LEFT ) ); ?>
          </span>
          <?php if ( $is_flagship ) : ?>
            <span class="archive-card-flagship-tag">Current Initiative</span>
          <?php endif; ?>
        </div>
        <div class="archive-card-title"><?php echo esc_html( get_the_title( $pid ) ); ?></div>
        <?php if ( $desc ) : ?>
          <p class="archive-card-desc"><?php echo esc_html( $desc ); ?></p>
        <?php endif; ?>
        <span class="archive-card-cta">Learn More &rarr;</span>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>

<!-- CTA Strip -->
<div class="archive-cta-strip">
  <p>Want to get involved?</p>
  <a href="<?php echo esc_url( home_url( '/#connect' ) ); ?>" class="btn-ink">
    Partner With Us
  </a>
</div>

<?php get_footer(); ?>
