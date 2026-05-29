<?php
/**
 * Footer — Ember & Oak
 * @package EmberOak
 */
?>
</main><!-- #main -->

<footer id="colophon" class="site-footer">
  <div class="container">
    <div class="footer-grid">

      <div class="footer-col footer-brand">
        <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>">Ember &amp; Oak</a></p>
        <p class="footer-tagline">Small-batch coffee roasted with care in Brooklyn, NY.</p>
        <nav aria-label="Social">
          <div class="social-links">
            <?php
            $ig = get_theme_mod('ember_oak_social_instagram','');
            $fb = get_theme_mod('ember_oak_social_facebook','');
            $tw = get_theme_mod('ember_oak_social_twitter','');
            if($ig): ?><a href="<?php echo esc_url($ig); ?>" class="social-link" target="_blank" rel="noopener">IG</a><?php endif; ?>
            <?php if($fb): ?><a href="<?php echo esc_url($fb); ?>" class="social-link" target="_blank" rel="noopener">FB</a><?php endif; ?>
            <?php if($tw): ?><a href="<?php echo esc_url($tw); ?>" class="social-link" target="_blank" rel="noopener">TW</a><?php endif; ?>
            <?php if(!$ig && !$fb && !$tw): ?>
              <a href="#" class="social-link">IG</a>
              <a href="#" class="social-link">FB</a>
              <a href="#" class="social-link">TW</a>
            <?php endif; ?>
          </div>
        </nav>
      </div>

      <div class="footer-col">
        <h4><?php esc_html_e('Quick Links','ember-oak'); ?></h4>
        <?php wp_nav_menu([
          'theme_location' => 'footer',
          'menu_class'     => 'footer-menu',
          'container'      => false,
          'depth'          => 1,
          'fallback_cb'    => function() { ?>
            <ul class="footer-menu">
              <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
              <li><a href="<?php echo esc_url(get_post_type_archive_link('ember_blend') ?: home_url('/blends/')); ?>">Coffee Menu</a></li>
              <li><a href="<?php echo esc_url(get_post_type_archive_link('ember_event') ?: home_url('/events/')); ?>">Events</a></li>
              <li><a href="<?php echo esc_url(home_url('/blog/')); ?>">Blog</a></li>
              <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a></li>
            </ul>
          <?php },
        ]); ?>
      </div>

      <div class="footer-col">
        <h4><?php esc_html_e('Visit Us','ember-oak'); ?></h4>
        <ul class="footer-info">
          <li><strong>📍</strong> <?php echo esc_html(get_theme_mod('ember_oak_address','123 Roastery Lane, Brooklyn NY 11201')); ?></li>
          <li><strong>📞</strong> <?php echo esc_html(get_theme_mod('ember_oak_phone','(718) 555-0142')); ?></li>
          <li><strong>✉</strong> <?php echo esc_html(get_theme_mod('ember_oak_email','hello@emberandoak.com')); ?></li>
          <li><strong>🕐</strong> <?php echo esc_html(get_theme_mod('ember_oak_hours_weekday','Mon–Fri: 7am–6pm')); ?></li>
          <li><strong>🕐</strong> <?php echo esc_html(get_theme_mod('ember_oak_hours_weekend','Sat–Sun: 8am–5pm')); ?></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4><?php esc_html_e('Stay in Touch','ember-oak'); ?></h4>
        <p style="font-size:.9rem;color:rgba(255,255,255,.5);margin-bottom:1rem;"><?php esc_html_e('Get roast updates, brew tips, and event news.','ember-oak'); ?></p>
        <form class="footer-newsletter" onsubmit="return false;">
          <input type="text"  placeholder="<?php esc_attr_e('Your Name','ember-oak'); ?>" aria-label="<?php esc_attr_e('Name','ember-oak'); ?>">
          <input type="email" placeholder="<?php esc_attr_e('Your Email','ember-oak'); ?>" aria-label="<?php esc_attr_e('Email','ember-oak'); ?>">
          <button type="submit" class="btn btn-primary btn-block" style="margin-top:.5rem;">
            <?php esc_html_e('Subscribe','ember-oak'); ?>
          </button>
        </form>
      </div>

    </div>
  </div>

  <div class="footer-bottom">
    <div class="container" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.5rem;">
      <span>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All rights reserved.','ember-oak'); ?></span>
      <span><?php printf(esc_html__('Powered by %s','ember-oak'),'<a href="https://wordpress.org">WordPress</a>'); ?></span>
    </div>
  </div>
</footer>

</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>
