<?php
$reach_cards = nyfdf_get_reach_cards();
$awards      = nyfdf_cmb2_get_option( 'nyfdf_awards', 'awards', [] );
?>

<section id="reach">
  <div class="section-eyebrow">
    <div class="section-eyebrow-line"></div>
    <span>Impact &amp; Reach</span>
  </div>
  <h2 class="section-title" style="color:var(--white)">
    A record of <em style="color:var(--gold)">meaningful work</em><br/>across Jamaica.
  </h2>
  <p style="font-size:16px;line-height:1.8;font-weight:300;color:rgba(255,255,255,0.5);max-width:620px;margin-bottom:52px;">
    Over more than eighteen years, NYFDI has engaged schools, communities, and organisations across six Jamaican parishes — and beyond our shores.
  </p>

  <?php if ( ! empty( $reach_cards ) ) : ?>
  <div class="reach-grid">
    <?php foreach ( $reach_cards as $card ) :
      $label = get_post_meta( $card->ID, 'reach_label', true );
      $desc  = get_post_meta( $card->ID, 'reach_description', true );
    ?>
    <div class="reach-card">
      <?php if ( $label ) : ?>
        <div class="reach-card-label"><?php echo esc_html( $label ); ?></div>
      <?php endif; ?>
      <h4><?php echo esc_html( get_the_title( $card->ID ) ); ?></h4>
      <?php if ( $desc ) : ?>
        <p><?php echo esc_html( $desc ); ?></p>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <?php if ( ! empty( $awards ) ) : ?>
  <div>
    <div class="section-eyebrow" style="margin-bottom:24px;">
      <div class="section-eyebrow-line"></div>
      <span>Recognition &amp; Awards</span>
    </div>
    <div class="achievements">
      <?php foreach ( $awards as $award ) :
        $source = $award['award_source']      ?? '';
        $desc   = $award['award_description'] ?? '';
        if ( ! $desc ) continue;
      ?>
      <div class="achievement-item">
        <?php if ( $source ) : ?>
          <div class="ach-source"><?php echo esc_html( $source ); ?></div>
        <?php endif; ?>
        <p><?php echo esc_html( $desc ); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>
</section>
