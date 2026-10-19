<?php
$fb_url         = nyfdf_cmb2_get_option( 'nyfdf_settings', 'site_facebook_url',        'https://www.facebook.com/nyfdf/' );
$has_ig_shortcode = shortcode_exists( 'instagram-feed' );

// Smash Balloon registers the shortcode as soon as the plugin is active, even
// before an Instagram account has actually been connected. Render it once and
// check the output for a real post item — that's the only reliable signal
// (across versions/free-vs-pro) that it's actually configured, not just installed.
$ig_output   = $has_ig_shortcode ? trim( (string) do_shortcode( '[instagram-feed feed=1]' ) ) : '';
$has_ig_feed = $ig_output !== '' && ( strpos( $ig_output, 'sbi_item' ) !== false || strpos( $ig_output, 'sbi-item' ) !== false );
$show_ig_ph  = ! $has_ig_feed && current_user_can( 'activate_plugins' );

if ( ! $fb_url && ! $has_ig_feed && ! $show_ig_ph ) {
    return;
}
?>

<?php if ( $fb_url ) : ?><div id="fb-root"></div><?php endif; ?>
<section id="social-feed">
  <div class="social-feed-layout">
    <div class="social-feed-intro">
      <div class="section-eyebrow">
        <div class="section-eyebrow-line"></div>
        <span>Follow Along</span>
      </div>
      <h2 class="section-title">What we&rsquo;re<br/><em>up to.</em></h2>
      <p class="social-feed-text">
        Events, outreach updates, stories, and announcements are shared regularly across our
        channels. Follow along to stay in the loop between programmes.
      </p>
    </div>

  <div class="social-feed-grid">

    <?php if ( $fb_url ) : ?>
    <div class="sf-card">
      <div class="sf-card-accent" style="background:#1877F2;"></div>
      <div class="sf-card-header">
        <div class="sf-card-label">Facebook</div>
      </div>
      <div class="fb-page"
        data-href="<?php echo esc_attr( $fb_url ); ?>"
        data-tabs="timeline"
        data-width="340"
        data-height="420"
        data-small-header="true"
        data-hide-cover="false"
        data-show-facepile="true">
      </div>
    </div>
    <?php endif; ?>

    <?php if ( $has_ig_feed ) : ?>
    <div class="sf-card sf-card--embed">
      <div class="sf-card-accent" style="background:linear-gradient(45deg,#fdf497,#fd5949,#d6249f,#285AEB);"></div>
      <div class="sf-card-header">
        <div class="sf-card-label">Instagram</div>
      </div>
      <?php echo $ig_output; ?>
    </div>
    <?php elseif ( $show_ig_ph ) : ?>
    <div class="sf-card img-ph" style="min-height:260px;">
      <span class="ph-icon">📷</span>
      <span class="ph-label">Instagram Feed</span>
      <span class="ph-hint">Only visible to admins. Install &amp; connect an account in the "Smash Balloon Instagram Feed" plugin to show a live feed here &mdash; it disappears automatically for visitors until then.</span>
    </div>
    <?php endif; ?>

  </div>
  </div>
</section>
