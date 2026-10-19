<?php
$items = nyfdf_get_gold_band_items();
if ( empty( $items ) ) {
    return;
}
// Duplicate items to create seamless infinite scroll
$all_items = array_merge( $items, $items );
?>

<div class="gold-band">
  <span class="gold-band-label">Focus Areas</span>
  <div class="gold-band-divider"></div>
  <div style="overflow:hidden;flex:1">
    <div class="gold-band-scroll">
      <?php foreach ( $all_items as $item ) : ?>
        <span class="gold-band-item"><?php echo esc_html( $item ); ?></span>
      <?php endforeach; ?>
    </div>
  </div>
</div>
