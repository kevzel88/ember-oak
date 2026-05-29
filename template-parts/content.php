<?php
/**
 * Template part for displaying standard posts in the loop.
 *
 * @package Ember_Oak
 */
?>
<article <?php post_class('post-card'); ?>>

  <?php if ( has_post_thumbnail() ) : ?>
    <div class="post-card__thumbnail">
      <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
        <?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'ember-oak-card', false, array( 'alt' => get_the_title() ) ); ?>
      </a>
    </div>
  <?php endif; ?>

  <div class="post-card__body">

    <?php
    $categories = get_the_category();
    if ( $categories ) : ?>
      <div class="post-card__categories">
        <?php foreach ( $categories as $category ) : ?>
          <a class="category-badge" href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
            <?php echo esc_html( $category->name ); ?>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <h2 class="post-card__title">
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h2>

    <div class="post-card__meta">
      <span class="post-card__date">
        <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
          <?php echo esc_html( get_the_date() ); ?>
        </time>
      </span>

      <span class="post-card__author">
        <?php
        printf(
          /* translators: %s: author display name */
          esc_html__( 'by %s', 'ember-oak' ),
          '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
        );
        ?>
      </span>

      <?php
      $word_count    = str_word_count( wp_strip_all_tags( get_the_content() ) );
      $reading_time  = max( 1, (int) ceil( $word_count / 200 ) );
      ?>
      <span class="post-card__reading-time">
        <?php
        printf(
          /* translators: %d: estimated reading time in minutes */
          esc_html( _n( '%d min read', '%d min read', $reading_time, 'ember-oak' ) ),
          $reading_time
        );
        ?>
      </span>
    </div>

    <div class="post-card__excerpt">
      <?php the_excerpt(); ?>
    </div>

    <a class="post-card__read-more button" href="<?php the_permalink(); ?>">
      <?php esc_html_e( 'Read More', 'ember-oak' ); ?>
      <span class="screen-reader-text"><?php echo esc_html( get_the_title() ); ?></span>
    </a>

  </div><!-- .post-card__body -->

</article>
