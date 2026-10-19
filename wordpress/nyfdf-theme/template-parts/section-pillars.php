<?php
$pillars = nyfdf_cmb2_get_option( 'nyfdf_pillars', 'pillars', [] );
if ( empty( $pillars ) ) {
    return;
}
?>

<section id="pillars">
  <div class="section-eyebrow">
    <div class="section-eyebrow-line"></div>
    <span>Our Core Values</span>
  </div>
  <h2 class="section-title">The principles that<br/><em>guide everything we do.</em></h2>

  <div class="pillars-grid">
    <?php foreach ( $pillars as $pillar ) :
      $icon  = $pillar['pillar_icon']        ?? '';
      $title = $pillar['pillar_title']       ?? '';
      $desc  = $pillar['pillar_description'] ?? '';
      if ( ! $title ) continue;
    ?>
    <div class="pillar">
      <?php if ( $icon ) : ?>
        <span class="pillar-icon"><?php echo esc_html( $icon ); ?></span>
      <?php endif; ?>
      <h4><?php echo esc_html( $title ); ?></h4>
      <?php if ( $desc ) : ?>
        <p><?php echo esc_html( $desc ); ?></p>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
</section>
