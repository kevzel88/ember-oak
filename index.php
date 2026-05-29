<?php get_header(); ?>
<section class="blog-index">
  <div class="container">
    <header class="section-header"><h1><?php esc_html_e('From Our Blog','ember-oak'); ?></h1></header>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <?php get_template_part('template-parts/content', get_post_format()); ?>
    <?php endwhile; the_posts_pagination(); else : ?>
      <?php get_template_part('template-parts/content','none'); ?>
    <?php endif; ?>
  </div>
  <?php get_sidebar(); ?>
</section>
<?php get_footer(); ?>
