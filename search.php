<?php get_header(); ?>

<main id="primary" class="site-main search-results">
  <div class="container">

    <header class="page-header">
      <h1 class="page-title">
        <?php
        printf(
          /* translators: %s: search term */
          esc_html__( 'Search Results for: %s', 'ember-oak' ),
          '<span>' . get_search_query() . '</span>'
        );
        ?>
      </h1>
      <?php
      global $wp_query;
      $result_count = $wp_query->found_posts;
      printf(
        /* translators: %d: number of results */
        esc_html( _n( '%d result found', '%d results found', $result_count, 'ember-oak' ) ),
        intval( $result_count )
      );
      ?>
    </header><!-- .page-header -->

    <?php if ( have_posts() ) : ?>

      <div class="search-results-loop">
        <?php
        while ( have_posts() ) :
          the_post();

          /*
           * Try to load template-parts/content-search.php first.
           * If that file does not exist, WordPress falls back to
           * template-parts/content.php, and if that is also absent
           * the inline fallback below is used via the get_template_part
           * action or the loop body itself.
           */
          $template_slug = 'template-parts/content';
          $template_name = 'search';

          if ( locate_template( $template_slug . '-' . $template_name . '.php' ) ) {
            get_template_part( $template_slug, $template_name );
          } elseif ( locate_template( $template_slug . '.php' ) ) {
            get_template_part( $template_slug );
          } else {
            // Inline fallback — renders a minimal but functional card.
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'search-result-item' ); ?>>

              <header class="entry-header">
                <?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
                <div class="entry-meta">
                  <span class="posted-on">
                    <time class="entry-date published" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
                      <?php echo esc_html( get_the_date() ); ?>
                    </time>
                  </span>
                  <span class="byline">
                    <?php
                    printf(
                      /* translators: %s: author name */
                      esc_html__( 'by %s', 'ember-oak' ),
                      '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
                    );
                    ?>
                  </span>
                </div><!-- .entry-meta -->
              </header><!-- .entry-header -->

              <?php if ( has_post_thumbnail() ) : ?>
                <div class="post-thumbnail">
                  <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail( 'medium' ); ?>
                  </a>
                </div>
              <?php endif; ?>

              <div class="entry-summary">
                <?php the_excerpt(); ?>
              </div><!-- .entry-summary -->

              <footer class="entry-footer">
                <a href="<?php the_permalink(); ?>" class="btn btn-primary read-more">
                  <?php esc_html_e( 'Read More', 'ember-oak' ); ?>
                </a>
              </footer><!-- .entry-footer -->

            </article><!-- #post-<?php the_ID(); ?> -->
            <?php
          }

        endwhile;
        ?>
      </div><!-- .search-results-loop -->

      <?php the_posts_pagination( array(
        'mid_size'  => 2,
        'prev_text' => esc_html__( '&laquo; Previous', 'ember-oak' ),
        'next_text' => esc_html__( 'Next &raquo;', 'ember-oak' ),
      ) ); ?>

    <?php else : ?>

      <div class="no-results not-found">
        <header class="page-header">
          <h2 class="page-title"><?php esc_html_e( 'Nothing Found', 'ember-oak' ); ?></h2>
        </header><!-- .page-header -->

        <div class="page-content">
          <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'ember-oak' ); ?></p>
          <?php get_search_form(); ?>
        </div><!-- .page-content -->
      </div><!-- .no-results -->

    <?php endif; ?>

  </div><!-- .container -->
</main><!-- #primary -->

<?php get_footer(); ?>
