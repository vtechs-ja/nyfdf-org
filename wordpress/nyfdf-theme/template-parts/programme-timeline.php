<?php
/**
 * Reusable timeline component.
 *
 * Expects $args:
 *   'entries'   array   Timeline rows from CMB2 group field
 *   'light'     bool    Use light-background variant (default false — white text on dark)
 *   'limit'     int     Max entries to show (0 = all)
 *   'compact'   bool    Tighter sizing for a narrow-column layout (default false)
 */
$entries = $args['entries'] ?? [];
$light   = (bool) ( $args['light'] ?? false );
$limit   = (int)  ( $args['limit'] ?? 0 );
$compact = (bool) ( $args['compact'] ?? false );

if ( empty( $entries ) ) {
    return;
}

if ( $limit > 0 ) {
    $entries = array_slice( $entries, 0, $limit );
}

$wrapper_class = 'programme-timeline'
  . ( $light ? ' timeline-light' : '' )
  . ( $compact ? ' timeline-compact' : '' );
?>

<div class="<?php echo esc_attr( $wrapper_class ); ?>">
  <?php foreach ( $entries as $entry ) :
    $num         = $entry['month_number']      ?? '';
    $tag         = $entry['date_tag']          ?? '';
    $name        = $entry['event_name']        ?? '';
    $desc        = $entry['event_description'] ?? '';
    $is_complete = ! empty( $entry['is_complete'] );
    if ( ! $name ) continue;
  ?>
  <div class="timeline-entry">
    <?php if ( $num ) : ?>
      <div class="timeline-num"><?php echo esc_html( $num ); ?></div>
    <?php endif; ?>
    <div class="timeline-content">
      <?php if ( $tag ) : ?>
        <span class="timeline-tag"><?php echo esc_html( $tag ); ?></span>
      <?php endif; ?>
      <h4><?php echo esc_html( $name ); ?></h4>
      <?php if ( $desc ) : ?>
        <p><?php echo esc_html( $desc ); ?></p>
      <?php endif; ?>
    </div>
  </div>
  <?php endforeach; ?>
</div>
