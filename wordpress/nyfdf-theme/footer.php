<footer>
  <div>
    <div class="footer-brand">
      <?php
      $logo_id = get_theme_mod( 'custom_logo' );
      if ( $logo_id ) {
          echo wp_get_attachment_image( $logo_id, 'thumbnail', false, [ 'class' => 'footer-logo', 'alt' => get_bloginfo( 'name' ) ] );
      }
      ?>
      NYFDI <span>&middot;</span> Northgate Youth &amp; Family Development Initiatives
    </div>
    <div class="footer-tagline">Empowering Families &hellip; Developing Youths &hellip; Defining the Future</div>
  </div>

  <?php
  wp_nav_menu( [
    'theme_location' => 'footer',
    'container'      => false,
    'menu_class'     => 'footer-links',
    'items_wrap'     => '<nav class="%2$s">%3$s</nav>',
    'depth'          => 1,
  ] );
  ?>

  <div class="footer-legal">
    &copy; <?php echo esc_html( date( 'Y' ) ); ?> NYFDI.
    Incorporated under the Companies Act of Jamaica, 2008.
  </div>
</footer>

<?php wp_footer(); ?>
<script async defer crossorigin="anonymous"
  src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v18.0"></script>
</body>
</html>
