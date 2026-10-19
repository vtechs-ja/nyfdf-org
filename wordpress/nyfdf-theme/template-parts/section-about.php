<?php
$body_1       = nyfdf_cmb2_get_option( 'nyfdf_about', 'about_body_1', '' );
$body_2       = nyfdf_cmb2_get_option( 'nyfdf_about', 'about_body_2', '' );
$body_3       = nyfdf_cmb2_get_option( 'nyfdf_about', 'about_body_3', '' );
$vision       = nyfdf_cmb2_get_option( 'nyfdf_about', 'about_vision', '' );
$mission      = nyfdf_cmb2_get_option( 'nyfdf_about', 'about_mission', '' );
$quote        = nyfdf_cmb2_get_option( 'nyfdf_about', 'about_quote', '' );
$attribution  = nyfdf_cmb2_get_option( 'nyfdf_about', 'about_quote_attribution', '' );
$affiliations = nyfdf_cmb2_get_option( 'nyfdf_about', 'about_affiliations', [] );
$has_photo    = nyfdf_option_img_exists( 'nyfdf_about', 'about_community_photo' );
?>

<section id="about">
  <div class="about-text">
    <div class="section-eyebrow">
      <div class="section-eyebrow-line"></div>
      <span>Who We Are</span>
    </div>
    <h2 class="section-title">Rooted in purpose.<br/><em>Committed to people.</em></h2>

    <?php foreach ( [ $body_1, $body_2, $body_3 ] as $para ) : if ( $para ) : ?>
      <p class="about-body"><?php echo esc_html( $para ); ?></p>
    <?php endif; endforeach; ?>

    <?php if ( $vision || $mission ) : ?>
    <div class="vision-mission">
      <?php if ( $vision ) : ?>
      <div class="vm-item">
        <div class="vm-label">Vision</div>
        <div class="vm-text"><?php echo esc_html( $vision ); ?></div>
      </div>
      <?php endif; ?>
      <?php if ( $mission ) : ?>
      <div class="vm-item">
        <div class="vm-label">Mission</div>
        <div class="vm-text"><?php echo esc_html( $mission ); ?></div>
      </div>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>

  <div class="about-right">
    <?php if ( $quote ) : ?>
    <div class="about-quote-card">
      <blockquote><?php echo esc_html( $quote ); ?></blockquote>
      <?php if ( $attribution ) : ?>
        <cite>&mdash; <?php echo esc_html( $attribution ); ?></cite>
      <?php endif; ?>
    </div>
    <div class="about-accent-bar"></div>
    <?php endif; ?>

    <?php if ( ! empty( $affiliations ) ) : ?>
    <div class="affiliation-strip">
      <div class="aff-label">Organisational Affiliations</div>
      <div class="aff-items">
        <?php foreach ( $affiliations as $aff ) :
          $name     = $aff['aff_name'] ?? '';
          $logo_url = $aff['aff_logo'] ?? '';
          $logo_id  = $aff['aff_logo_id'] ?? 0;
          $url      = $aff['aff_url'] ?? '';
          if ( ! $name ) continue;
        ?>
        <div class="aff-item">
          <?php if ( $logo_id ) : ?>
            <?php echo wp_get_attachment_image( (int) $logo_id, 'thumbnail', false, [ 'class' => 'aff-logo', 'alt' => esc_attr( $name ) ] ); ?>
          <?php elseif ( $logo_url ) : ?>
            <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" class="aff-logo"/>
          <?php endif; ?>

          <?php if ( $url ) : ?>
            <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" class="aff-link">
              <?php echo esc_html( $name ); ?> <span class="aff-ext">↗</span>
            </a>
          <?php else : ?>
            <?php echo esc_html( $name ); ?>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <?php if ( $has_photo ) : ?>
      <?php nyfdf_option_img( 'nyfdf_about', 'about_community_photo', 'large', 'NYFDI community', 'about-community-photo' ); ?>
    <?php else : ?>
    <div class="img-ph" style="aspect-ratio:8/5;">
      <span class="ph-icon">📷</span>
      <p class="ph-label">Team or Community Photo</p>
      <p class="ph-hint">Upload via NYFDI Settings → About Section</p>
    </div>
    <?php endif; ?>
  </div>
</section>
