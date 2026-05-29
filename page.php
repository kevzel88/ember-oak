<?php get_header(); ?>

<div class="page-hero" style="<?php if ( has_post_thumbnail() ) { $img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ); echo 'background-image: url(' . esc_url( $img[0] ) . ');'; } ?>">
	<div class="page-hero-inner">
		<h1 class="page-title"><?php the_title(); ?></h1>
		<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'ember-oak' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'ember-oak' ); ?></a>
			<span class="breadcrumb-sep" aria-hidden="true">&rsaquo;</span>
			<span class="breadcrumb-current" aria-current="page"><?php the_title(); ?></span>
		</nav>
	</div>
</div>

<main id="primary" class="site-main">
	<div class="container">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="entry-thumbnail">
						<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'large', false, array( 'class' => 'page-featured-image', 'alt' => get_the_title() ) ); ?>
					</div>
				<?php endif; ?>

				<div class="entry-content">
					<?php the_content(); ?>

					<?php
					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ember-oak' ),
						'after'  => '</div>',
					) );
					?>
				</div>

			</article>

			<?php if ( comments_open() || get_comments_number() ) : ?>
				<?php comments_template(); ?>
			<?php endif; ?>

		<?php endwhile; endif; ?>

	</div>
</main>

<?php get_footer(); ?>
