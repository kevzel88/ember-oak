<?php
/**
 * Default page template — Ember & Oak
 * @package EmberOak
 */
get_header();
?>

<?php while (have_posts()) : the_post(); ?>

<div class="page-hero">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home','ember-oak'); ?></a>
      <span aria-hidden="true">›</span>
      <span><?php the_title(); ?></span>
    </nav>
    <h1><?php the_title(); ?></h1>
  </div>
</div>

<div class="container">
  <article id="post-<?php the_ID(); ?>" <?php post_class('page-content'); ?>>

    <?php if (has_post_thumbnail()) : ?>
      <div style="margin-bottom:2rem;border-radius:var(--radius-lg);overflow:hidden;max-height:420px;">
        <?php the_post_thumbnail('ember-oak-wide',['style'=>'width:100%;object-fit:cover;']); ?>
      </div>
    <?php endif; ?>

    <div class="entry-content">
      <?php the_content(); ?>
      <?php wp_link_pages(['before'=>'<div class="page-links">','after'=>'</div>']); ?>
    </div>

  </article>
</div>

<?php if (comments_open() || get_comments_number()) : ?>
  <div class="container"><div class="comments-area"><?php comments_template(); ?></div></div>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>
