<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Ember_Oak
 */
?>

<aside id="secondary" class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Blog Sidebar', 'ember-oak' ); ?>">

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>

		<?php dynamic_sidebar( 'sidebar-1' ); ?>

	<?php else : ?>

		<!-- Fallback: Recent Posts -->
		<section class="widget widget_recent_entries">
			<h2 class="widget-title"><?php esc_html_e( 'Recent Posts', 'ember-oak' ); ?></h2>
			<?php
			$recent_posts = new WP_Query(
				array(
					'posts_per_page'      => 5,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
				)
			);

			if ( $recent_posts->have_posts() ) :
			?>
				<ul>
					<?php while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>
						<li>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							<span class="post-date"><?php echo esc_html( get_the_date() ); ?></span>
						</li>
					<?php endwhile; ?>
				</ul>
			<?php
			endif;
			wp_reset_postdata();
			?>
		</section>

		<!-- Fallback: Categories -->
		<section class="widget widget_categories">
			<h2 class="widget-title"><?php esc_html_e( 'Categories', 'ember-oak' ); ?></h2>
			<ul>
				<?php
				wp_list_categories(
					array(
						'orderby'    => 'name',
						'order'      => 'ASC',
						'show_count' => true,
						'title_li'   => '',
					)
				);
				?>
			</ul>
		</section>

		<!-- Fallback: Tag Cloud -->
		<section class="widget widget_tag_cloud">
			<h2 class="widget-title"><?php esc_html_e( 'Tags', 'ember-oak' ); ?></h2>
			<?php
			wp_tag_cloud(
				array(
					'smallest' => 10,
					'largest'  => 22,
					'unit'     => 'px',
					'number'   => 45,
					'orderby'  => 'name',
					'order'    => 'ASC',
					'format'   => 'flat',
				)
			);
			?>
		</section>

	<?php endif; ?>

</aside><!-- #secondary -->
