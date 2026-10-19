<?php
$founder_name    = nyfdf_cmb2_get_option( 'nyfdf_leadership', 'founder_name',  '' );
$founder_title   = nyfdf_cmb2_get_option( 'nyfdf_leadership', 'founder_title', '' );
$founder_bio     = nyfdf_cmb2_get_option( 'nyfdf_leadership', 'founder_bio',   '' );
$highlights      = nyfdf_cmb2_get_option( 'nyfdf_leadership', 'founder_highlights', [] );
$governance      = nyfdf_cmb2_get_option( 'nyfdf_leadership', 'governance_tiers',   [] );
$has_photo       = nyfdf_option_img_exists( 'nyfdf_leadership', 'founder_photo' );
?>

<section id="leadership">
  <div class="section-eyebrow">
    <div class="section-eyebrow-line"></div>
    <span>The People Behind the Work</span>
  </div>
  <h2 class="section-title">Our <em>Leadership</em></h2>

  <div class="leadership-layout">
    <div class="chairman-card">
      <?php if ( $has_photo ) : ?>
        <?php nyfdf_option_img( 'nyfdf_leadership', 'founder_photo', 'medium', esc_attr( $founder_name ), 'chairman-photo' ); ?>
      <?php endif; ?>

      <?php if ( $founder_name ) : ?>
        <div class="chairman-name"><?php echo esc_html( $founder_name ); ?></div>
      <?php endif; ?>

      <?php if ( $founder_title ) : ?>
        <div class="chairman-creds"><?php echo esc_html( $founder_title ); ?></div>
      <?php endif; ?>

      <?php if ( $founder_bio ) : ?>
        <p class="chairman-bio"><?php echo esc_html( $founder_bio ); ?></p>
      <?php endif; ?>

      <?php if ( ! empty( $highlights ) ) : ?>
      <div class="chairman-highlights">
        <?php foreach ( $highlights as $h ) :
          $text = $h['highlight_text'] ?? '';
          if ( ! $text ) continue;
        ?>
        <div class="ch-highlight"><span><?php echo esc_html( $text ); ?></span></div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>

    <?php if ( ! empty( $governance ) ) : ?>
    <div class="board-section">
      <h3>Governance Structure</h3>
      <div class="board-cards">
        <?php foreach ( $governance as $tier ) :
          $tier_title = $tier['tier_title']       ?? '';
          $named_lead = $tier['tier_named_lead']  ?? '';
          $tier_desc  = $tier['tier_description'] ?? '';
          if ( ! $tier_title ) continue;
        ?>
        <div class="board-card">
          <div class="board-card-title"><?php echo esc_html( $tier_title ); ?></div>
          <?php if ( $named_lead ) : ?>
            <div class="board-card-name"><?php echo esc_html( $named_lead ); ?></div>
          <?php endif; ?>
          <?php if ( $tier_desc ) : ?>
            <p class="board-card-desc"><?php echo esc_html( $tier_desc ); ?></p>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>
