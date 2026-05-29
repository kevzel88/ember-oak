<?php
/**
 * The template for displaying all single posts
 *
 * @package Ember_Oak
 */

get_header();

// Custom post type routing
if ( is_singular( 'ember_blend' ) ) {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', 'blend' );
	}
	get_footer();
	return;
}

if ( is_singular( 'ember_event' ) ) {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', 'event' );
	}
	get_footer();
	return;
}

/**
 * Calculate estimated reading time for post content.
 *
 * @param string $content Post content.
 * @param int    $wpm     Words per minute reading speed.
 * @return string Formatted reading time string.
 */
function ember_oak_reading_time( $content, $wpm = 200 ) {
	$word_count = str_word_count( wp_strip_all_tags( $content ) );
	$minutes    = (int) ceil( $word_count / $wpm );
	if ( $minutes < 1 ) {
		$minutes = 1;
	}
	/* translators: %d: number of minutes */
	return sprintf( _n( '%d min read', '%d min read', $minutes, 'ember-oak' ), $minutes );
}

while ( have_posts() ) :
	the_post();

	$post_id        = get_the_ID();
	$post_title     = get_the_title();
	$post_url       = get_permalink();
	$post_date_iso  = get_the_date( 'c' );
	$post_date_disp = get_the_date();
	$modified_iso   = get_the_modified_date( 'c' );
	$author_id      = get_the_author_meta( 'ID' );
	$author_name    = get_the_author();
	$author_url     = get_author_posts_url( $author_id );
	$author_bio     = get_the_author_meta( 'description' );
	$content        = get_the_content();
	$reading_time   = ember_oak_reading_time( $content );
	$categories     = get_the_category();
	$tags           = get_the_tags();

	// Build schema.org structured data
	$schema = array(
		'@context'         => 'https://schema.org',
		'@type'            => 'Article',
		'headline'         => esc_html( $post_title ),
		'url'              => esc_url( $post_url ),
		'datePublished'    => esc_attr( $post_date_iso ),
		'dateModified'     => esc_attr( $modified_iso ),
		'author'           => array(
			'@type' => 'Person',
			'name'  => esc_html( $author_name ),
			'url'   => esc_url( $author_url ),
		),
		'publisher'        => array(
			'@type' => 'Organization',
			'name'  => esc_html( get_bloginfo( 'name' ) ),
			'logo'  => array(
				'@type' => 'ImageObject',
				'url'   => esc_url( get_site_icon_url() ),
			),
		),
		'description'      => esc_html( wp_trim_words( get_the_excerpt(), 30, '...' ) ),
		'mainEntityOfPage' => array(
			'@type' => 'WebPage',
			'@id'   => esc_url( $post_url ),
		),
	);

	if ( has_post_thumbnail() ) {
		$thumbnail_src        = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		$schema['image']      = array(
			'@type'  => 'ImageObject',
			'url'    => esc_url( $thumbnail_src[0] ),
			'width'  => absint( $thumbnail_src[1] ),
			'height' => absint( $thumbnail_src[2] ),
		);
	}

	if ( ! empty( $categories ) ) {
		$schema['articleSection'] = esc_html( $categories[0]->name );
	}

	?>
	<script type="application/ld+json">
	<?php echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT ); ?>
	</script>

	<main id="primary" class="site-main ember-oak-single">

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'ember-oak-article' ); ?> itemscope itemtype="https://schema.org/Article">

			<?php if ( has_post_thumbnail() ) : ?>
				<header class="entry-header entry-header--featured-image">
					<div class="featured-image-wrap">
						<?php
						the_post_thumbnail(
							'full',
							array(
								'class'    => 'featured-image',
								'itemprop' => 'image',
								'loading'  => 'eager',
								'alt'      => the_title_attribute( array( 'echo' => false ) ),
							)
						);
						?>
					</div>
					<div class="entry-header__inner">
						<?php if ( ! empty( $categories ) ) : ?>
							<div class="entry-categories">
								<?php foreach ( $categories as $category ) : ?>
									<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="entry-category" rel="category tag">
										<?php echo esc_html( $category->name ); ?>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
						<h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
						<div class="entry-meta">
							<span class="entry-meta__date">
								<time datetime="<?php echo esc_attr( $post_date_iso ); ?>" itemprop="datePublished">
									<?php echo esc_html( $post_date_disp ); ?>
								</time>
							</span>
							<span class="entry-meta__separator" aria-hidden="true">&middot;</span>
							<span class="entry-meta__author" itemprop="author" itemscope itemtype="https://schema.org/Person">
								<?php esc_html_e( 'By', 'ember-oak' ); ?>
								<a href="<?php echo esc_url( $author_url ); ?>" itemprop="url" rel="author">
									<span itemprop="name"><?php echo esc_html( $author_name ); ?></span>
								</a>
							</span>
							<span class="entry-meta__separator" aria-hidden="true">&middot;</span>
							<span class="entry-meta__reading-time">
								<?php echo esc_html( $reading_time ); ?>
							</span>
						</div>
					</div>
				</header>
			<?php else : ?>
				<header class="entry-header">
					<?php if ( ! empty( $categories ) ) : ?>
						<div class="entry-categories">
							<?php foreach ( $categories as $category ) : ?>
								<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="entry-category" rel="category tag">
									<?php echo esc_html( $category->name ); ?>
								</a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
					<div class="entry-meta">
						<span class="entry-meta__date">
							<time datetime="<?php echo esc_attr( $post_date_iso ); ?>" itemprop="datePublished">
								<?php echo esc_html( $post_date_disp ); ?>
							</time>
						</span>
						<span class="entry-meta__separator" aria-hidden="true">&middot;</span>
						<span class="entry-meta__author" itemprop="author" itemscope itemtype="https://schema.org/Person">
							<?php esc_html_e( 'By', 'ember-oak' ); ?>
							<a href="<?php echo esc_url( $author_url ); ?>" itemprop="url" rel="author">
								<span itemprop="name"><?php echo esc_html( $author_name ); ?></span>
							</a>
						</span>
						<span class="entry-meta__separator" aria-hidden="true">&middot;</span>
						<span class="entry-meta__reading-time">
							<?php echo esc_html( $reading_time ); ?>
						</span>
					</div>
				</header>
			<?php endif; ?>

			<div class="entry-content" itemprop="articleBody">
				<?php
				the_content(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'ember-oak' ),
							array( 'span' => array( 'class' => array() ) )
						),
						wp_kses_post( get_the_title() )
					)
				);

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ember-oak' ),
						'after'  => '</div>',
					)
				);
				?>
			</div>

			<?php if ( ! empty( $tags ) ) : ?>
				<footer class="entry-footer entry-tags">
					<span class="entry-tags__label"><?php esc_html_e( 'Tags:', 'ember-oak' ); ?></span>
					<?php foreach ( $tags as $tag ) : ?>
						<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="entry-tag" rel="tag">
							<?php echo esc_html( $tag->name ); ?>
						</a>
					<?php endforeach; ?>
				</footer>
			<?php endif; ?>

		</article>

		<?php
		// Author bio box
		if ( get_the_author_meta( 'description' ) ) :
			?>
			<div class="author-bio-box">
				<div class="author-bio-box__avatar">
					<?php echo get_avatar( $author_id, 96, '', esc_attr( $author_name ), array( 'class' => 'author-avatar' ) ); ?>
				</div>
				<div class="author-bio-box__content">
					<h3 class="author-bio-box__name">
						<a href="<?php echo esc_url( $author_url ); ?>">
							<?php echo esc_html( $author_name ); ?>
						</a>
					</h3>
					<p class="author-bio-box__description">
						<?php echo wp_kses_post( $author_bio ); ?>
					</p>
					<a href="<?php echo esc_url( $author_url ); ?>" class="author-bio-box__posts-link">
						<?php
						printf(
							/* translators: %s: Author display name */
							esc_html__( 'View all posts by %s', 'ember-oak' ),
							esc_html( $author_name )
						);
						?>
					</a>
				</div>
			</div>
		<?php endif; ?>

		<nav class="post-navigation" aria-label="<?php esc_attr_e( 'Post navigation', 'ember-oak' ); ?>">
			<?php
			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous', 'ember-oak' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next', 'ember-oak' ) . '</span> <span class="nav-title">%title</span>',
				)
			);
			?>
		</nav>

		<?php
		// Related posts by same category
		if ( ! empty( $categories ) ) :
			$related_args = array(
				'post_type'           => 'post',
				'posts_per_page'      => 3,
				'post__not_in'        => array( $post_id ),
				'category__in'        => wp_list_pluck( $categories, 'term_id' ),
				'orderby'             => 'rand',
				'no_found_rows'       => true,
				'ignore_sticky_posts' => true,
			);

			$related_query = new WP_Query( $related_args );

			if ( $related_query->have_posts() ) :
				?>
				<section class="related-posts" aria-label="<?php esc_attr_e( 'Related Posts', 'ember-oak' ); ?>">
					<h2 class="related-posts__title"><?php esc_html_e( 'Related Posts', 'ember-oak' ); ?></h2>
					<div class="related-posts__grid">
						<?php
						while ( $related_query->have_posts() ) :
							$related_query->the_post();
							?>
							<article class="related-post-card" id="related-post-<?php the_ID(); ?>">
								<?php if ( has_post_thumbnail() ) : ?>
									<a href="<?php the_permalink(); ?>" class="related-post-card__thumbnail" tabindex="-1" aria-hidden="true">
										<?php
										the_post_thumbnail(
											'medium',
											array(
												'class'   => 'related-post-card__image',
												'loading' => 'lazy',
												'alt'     => the_title_attribute( array( 'echo' => false ) ),
											)
										);
										?>
									</a>
								<?php endif; ?>
								<div class="related-post-card__body">
									<?php
									$related_cats = get_the_category();
									if ( ! empty( $related_cats ) ) :
										?>
										<span class="related-post-card__category">
											<?php echo esc_html( $related_cats[0]->name ); ?>
										</span>
									<?php endif; ?>
									<h3 class="related-post-card__title">
										<a href="<?php the_permalink(); ?>">
											<?php the_title(); ?>
										</a>
									</h3>
									<p class="related-post-card__excerpt">
										<?php echo esc_html( wp_trim_words( get_the_excerpt(), 15, '...' ) ); ?>
									</p>
									<span class="related-post-card__date">
										<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
											<?php echo esc_html( get_the_date() ); ?>
										</time>
									</span>
								</div>
							</article>
						<?php endwhile; ?>
					</div>
				</section>
				<?php
				wp_reset_postdata();
			endif;
		endif;
		?>

		<?php comments_template(); ?>

	</main>

	<?php
endwhile;

get_footer();
