<?php get_header(); ?>

<?php while ( have_posts() ) : the_post();
  $impact      = get_post_meta( get_the_ID(), 'programme_impact', true );
  $gallery     = nyfdf_get_programme_gallery( get_the_ID() );
  $timeline    = nyfdf_get_timeline( get_the_ID() );
  $has_content = trim( get_the_content() ) !== '';
  $thumbnail   = get_the_post_thumbnail_url( get_the_ID(), 'programme-hero' );
?>

<!-- Hero -->
<div class="programme-hero">
  <?php if ( $thumbnail ) : ?>
    <img src="<?php echo esc_url( $thumbnail ); ?>"
         alt="<?php echo esc_attr( get_the_title() ); ?>"
         class="programme-hero-img"/>
  <?php endif; ?>
  <div class="programme-hero-overlay"></div>
  <div class="programme-hero-content">
    <div class="section-eyebrow">
      <div class="section-eyebrow-line"></div>
      <span>
        <a href="<?php echo esc_url( get_post_type_archive_link( 'nyfdf_programme' ) ); ?>"
           style="color:inherit;text-decoration:none;">Programmes</a>
      </span>
    </div>
    <h1 class="programme-hero-title"><?php the_title(); ?></h1>
  </div>
</div>

<!-- Background / main content, paired with Impact & Outcomes when both exist -->
<?php if ( $has_content ) : ?>
<div class="programme-section programme-section--mist">
  <?php if ( $impact ) : ?>
  <div class="programme-split">
  <?php endif; ?>

    <div class="programme-content">
      <div class="section-eyebrow">
        <div class="section-eyebrow-line"></div>
        <span>Background</span>
      </div>
      <?php the_content(); ?>
    </div>

    <?php if ( $impact ) : ?>
    <div class="programme-impact-card">
      <div class="section-eyebrow" style="margin-bottom:20px;">
        <div class="section-eyebrow-line"></div>
        <span>Impact &amp; Outcomes</span>
      </div>
      <div class="programme-impact-text"><?php echo wp_kses_post( $impact ); ?></div>
    </div>
  </div>
  <?php endif; ?>
</div>
<?php elseif ( $impact ) : ?>
<!-- Impact alone (no Background content) -->
<div class="programme-section programme-section--ink">
  <div class="section-eyebrow" style="margin-bottom:28px;">
    <div class="section-eyebrow-line"></div>
    <span>Impact &amp; Outcomes</span>
  </div>
  <div class="programme-impact-text"><?php echo wp_kses_post( $impact ); ?></div>
</div>
<?php endif; ?>

<?php $gallery_markup = static function ( array $gallery ) {
  foreach ( $gallery as $image ) : ?>
    <div class="programme-gallery-item">
      <?php if ( $image['id'] ) : ?>
        <?php echo wp_get_attachment_image( $image['id'], 'large', false, [ 'alt' => esc_attr( get_the_title() ) ] ); ?>
      <?php else : ?>
        <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"/>
      <?php endif; ?>
    </div>
  <?php endforeach;
}; ?>

<?php if ( ! empty( $gallery ) && ! empty( $timeline ) ) : ?>
<!-- Milestones + Gallery, paired -->
<div class="programme-section programme-section--white">
  <div class="milestones-gallery-row">
    <div class="milestones-col">
      <div class="section-eyebrow" style="margin-bottom:24px;">
        <div class="section-eyebrow-line"></div>
        <span>Milestones</span>
      </div>
      <?php get_template_part( 'template-parts/programme-timeline', null, [
        'entries' => $timeline,
        'light'   => true,
        'compact' => true,
      ] ); ?>
    </div>
    <div class="gallery-col">
      <div class="section-eyebrow" style="margin-bottom:24px;">
        <div class="section-eyebrow-line"></div>
        <span>Gallery</span>
      </div>
      <div class="programme-gallery-grid">
        <?php $gallery_markup( $gallery ); ?>
      </div>
    </div>
  </div>
</div>

<?php elseif ( ! empty( $gallery ) ) : ?>
<!-- Gallery alone -->
<div class="programme-section programme-section--white">
  <div class="section-eyebrow" style="margin-bottom:28px;">
    <div class="section-eyebrow-line"></div>
    <span>Gallery</span>
  </div>
  <div class="programme-gallery-grid">
    <?php $gallery_markup( $gallery ); ?>
  </div>
</div>

<?php elseif ( ! empty( $timeline ) ) : ?>
<!-- Timeline alone -->
<div class="programme-section programme-section--white">
  <div class="section-eyebrow" style="margin-bottom:40px;">
    <div class="section-eyebrow-line"></div>
    <span>Programme Timeline</span>
  </div>
  <h2 class="section-title" style="margin-bottom:40px;">
    <?php echo esc_html( get_the_title() ); ?><br/><em>Milestones</em>
  </h2>
  <?php get_template_part( 'template-parts/programme-timeline', null, [
    'entries' => $timeline,
    'light'   => true,
  ] ); ?>
</div>
<?php endif; ?>

<!-- CTA -->
<div class="programme-cta-section">
  <p>Want to get involved?</p>
  <a href="<?php echo esc_url( home_url( '/#connect' ) ); ?>" class="btn-primary">
    Partner With Us
  </a>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
