<?php get_header(); ?>
<main class="error-404 not-found">
  <div class="container">
    <div class="page-content">
      <div class="error-number">404</div>
      <h1><?php esc_html_e('Looks like this roast went missing.', 'ember-oak'); ?></h1>
      <p><?php esc_html_e('The page you are looking for might have been removed, renamed, or is temporarily unavailable.', 'ember-oak'); ?></p>
      <?php get_search_form(); ?>
      <div class="error-links">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary"><?php esc_html_e('Back Home', 'ember-oak'); ?></a>
        <a href="<?php echo esc_url(get_post_type_archive_link('ember_blend')); ?>" class="btn btn-secondary"><?php esc_html_e('Shop Coffee', 'ember-oak'); ?></a>
      </div>
    </div>
  </div>
</main>
<?php get_footer(); ?>
