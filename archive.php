<?php
/**
 * Archive Template
 *
 * Handles archives for the ember_blend CPT, ember_event CPT,
 * and the standard blog post archive.
 *
 * @package Ember_Oak
 */

get_header();
?>

<?php if ( is_post_type_archive( 'ember_blend' ) ) : ?>

	<?php
	// Collect all blend posts for filtering
	$blends_args = array(
		'post_type'      => 'ember_blend',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
	);
	$blends_query = new WP_Query( $blends_args );

	// Gather unique roast levels from post meta for filter sidebar
	$roast_levels = array();
	if ( $blends_query->have_posts() ) {
		foreach ( $blends_query->posts as $blend_post ) {
			$roast = get_post_meta( $blend_post->ID, 'roast_level', true );
			if ( $roast && ! in_array( $roast, $roast_levels, true ) ) {
				$roast_levels[] = $roast;
			}
		}
		sort( $roast_levels );
	}

	// Get origin taxonomy terms
	$origin_terms = get_terms( array(
		'taxonomy'   => 'origin',
		'hide_empty' => true,
	) );
	?>

	<div class="blends-archive">

		<header class="archive-header">
			<div class="container">
				<h1 class="archive-title"><?php post_type_archive_title(); ?></h1>
				<?php
				$pt_obj = get_post_type_object( 'ember_blend' );
				if ( $pt_obj && ! empty( $pt_obj->description ) ) :
				?>
					<div class="archive-description"><?php echo wp_kses_post( $pt_obj->description ); ?></div>
				<?php endif; ?>
			</div>
		</header>

		<div class="container blends-archive__inner">

			<!-- Filter Sidebar -->
			<aside class="blends-archive__sidebar blend-filters" role="search" aria-label="<?php esc_attr_e( 'Filter blends', 'ember-oak' ); ?>">

				<form class="blend-filters__form" id="blend-filter-form">

					<?php if ( ! empty( $roast_levels ) ) : ?>
					<div class="blend-filters__group blend-filters__group--roast">
						<h2 class="blend-filters__heading"><?php esc_html_e( 'Roast Level', 'ember-oak' ); ?></h2>
						<ul class="blend-filters__list blend-filters__list--radio" role="group" aria-labelledby="roast-filter-label">
							<li>
								<label class="blend-filters__label">
									<input
										class="blend-filters__radio"
										type="radio"
										name="roast_level"
										value=""
										data-filter="roast:"
										checked
									/>
									<?php esc_html_e( 'All Roasts', 'ember-oak' ); ?>
								</label>
							</li>
							<?php foreach ( $roast_levels as $roast_level ) : ?>
							<li>
								<label class="blend-filters__label">
									<input
										class="blend-filters__radio"
										type="radio"
										name="roast_level"
										value="<?php echo esc_attr( $roast_level ); ?>"
										data-filter="roast:<?php echo esc_attr( $roast_level ); ?>"
									/>
									<?php echo esc_html( ucwords( $roast_level ) ); ?>
								</label>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<?php endif; ?>

					<?php if ( ! is_wp_error( $origin_terms ) && ! empty( $origin_terms ) ) : ?>
					<div class="blend-filters__group blend-filters__group--origin">
						<h2 class="blend-filters__heading"><?php esc_html_e( 'Origin', 'ember-oak' ); ?></h2>
						<ul class="blend-filters__list blend-filters__list--checkboxes" role="group" aria-labelledby="origin-filter-label">
							<?php foreach ( $origin_terms as $origin_term ) : ?>
							<li>
								<label class="blend-filters__label">
									<input
										class="blend-filters__checkbox"
										type="checkbox"
										name="origin[]"
										value="<?php echo esc_attr( $origin_term->slug ); ?>"
										data-filter="origin:<?php echo esc_attr( $origin_term->slug ); ?>"
									/>
									<?php echo esc_html( $origin_term->name ); ?>
									<span class="blend-filters__count">(<?php echo absint( $origin_term->count ); ?>)</span>
								</label>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<?php endif; ?>

					<button type="reset" class="blend-filters__reset"><?php esc_html_e( 'Clear Filters', 'ember-oak' ); ?></button>

				</form>

			</aside><!-- .blends-archive__sidebar -->

			<!-- Blends Grid -->
			<main class="blends-archive__main" id="main-content">

				<?php if ( $blends_query->have_posts() ) : ?>

					<div class="blends-grid" id="blends-grid">

						<?php while ( $blends_query->have_posts() ) : $blends_query->the_post(); ?>

							<?php
							$roast_badge = get_post_meta( get_the_ID(), 'roast_level', true );
							$price       = get_post_meta( get_the_ID(), 'price', true );

							// Build data attributes for JS filtering
							$origins_for_post = get_the_terms( get_the_ID(), 'origin' );
							$origin_slugs = array();
							if ( $origins_for_post && ! is_wp_error( $origins_for_post ) ) {
								foreach ( $origins_for_post as $o ) {
									$origin_slugs[] = $o->slug;
								}
							}
							?>

							<article
								class="blend-card"
								data-roast="<?php echo esc_attr( $roast_badge ); ?>"
								data-origins="<?php echo esc_attr( implode( ',', $origin_slugs ) ); ?>"
							>

								<?php if ( has_post_thumbnail() ) : ?>
									<a class="blend-card__thumbnail-link" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
										<div class="blend-card__thumbnail">
											<?php the_post_thumbnail( 'medium', array( 'alt' => get_the_title() ) ); ?>
										</div>
									</a>
								<?php endif; ?>

								<div class="blend-card__body">

									<?php if ( $roast_badge ) : ?>
										<span class="blend-card__roast-badge roast-badge roast-badge--<?php echo esc_attr( sanitize_html_class( strtolower( $roast_badge ) ) ); ?>">
											<?php echo esc_html( ucwords( $roast_badge ) ); ?>
										</span>
									<?php endif; ?>

									<h2 class="blend-card__title">
										<a class="blend-card__title-link" href="<?php the_permalink(); ?>">
											<?php the_title(); ?>
										</a>
									</h2>

									<?php if ( has_excerpt() || get_the_content() ) : ?>
										<div class="blend-card__excerpt">
											<?php the_excerpt(); ?>
										</div>
									<?php endif; ?>

									<footer class="blend-card__footer">

										<?php if ( $price ) : ?>
											<span class="blend-card__price">
												<?php echo esc_html( $price ); ?>
											</span>
										<?php endif; ?>

										<a class="blend-card__link button button--primary" href="<?php the_permalink(); ?>">
											<?php esc_html_e( 'View Blend', 'ember-oak' ); ?>
										</a>

									</footer>

								</div><!-- .blend-card__body -->

							</article><!-- .blend-card -->

						<?php endwhile; ?>

					</div><!-- .blends-grid -->

					<p class="blends-grid__no-results" id="blends-no-results" style="display:none;" aria-live="polite">
						<?php esc_html_e( 'No blends match your current filters. Try adjusting your selection.', 'ember-oak' ); ?>
					</p>

				<?php else : ?>

					<p class="blends-archive__empty">
						<?php esc_html_e( 'No blends found.', 'ember-oak' ); ?>
					</p>

				<?php endif; wp_reset_postdata(); ?>

			</main><!-- .blends-archive__main -->

		</div><!-- .blends-archive__inner -->

	</div><!-- .blends-archive -->

	<script>
	( function () {
		var form     = document.getElementById( 'blend-filter-form' );
		var grid     = document.getElementById( 'blends-grid' );
		var noResult = document.getElementById( 'blends-no-results' );

		if ( ! form || ! grid ) return;

		function applyFilters() {
			var selectedRoast   = '';
			var selectedOrigins = [];

			var roastRadio = form.querySelector( 'input[name="roast_level"]:checked' );
			if ( roastRadio ) selectedRoast = roastRadio.value;

			var originBoxes = form.querySelectorAll( 'input[name="origin[]"]:checked' );
			originBoxes.forEach( function ( cb ) { selectedOrigins.push( cb.value ); } );

			var cards   = grid.querySelectorAll( '.blend-card' );
			var visible = 0;

			cards.forEach( function ( card ) {
				var roatMatch   = ! selectedRoast || card.dataset.roast === selectedRoast;
				var originsData = card.dataset.origins ? card.dataset.origins.split( ',' ) : [];
				var originMatch = selectedOrigins.length === 0 || selectedOrigins.every( function ( o ) {
					return originsData.indexOf( o ) !== -1;
				} );

				if ( roatMatch && originMatch ) {
					card.style.display = '';
					visible++;
				} else {
					card.style.display = 'none';
				}
			} );

			noResult.style.display = visible === 0 ? '' : 'none';
		}

		form.addEventListener( 'change', applyFilters );
		form.addEventListener( 'reset', function () {
			setTimeout( applyFilters, 0 );
		} );
	} )();
	</script>

<?php elseif ( is_post_type_archive( 'ember_event' ) ) : ?>

	<?php
	$today = date( 'Ymd' );

	// Upcoming events: event_date >= today, sorted ASC
	$upcoming_args = array(
		'post_type'      => 'ember_event',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'meta_key'       => 'event_date',
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
		'meta_query'     => array(
			array(
				'key'     => 'event_date',
				'value'   => $today,
				'compare' => '>=',
				'type'    => 'DATE',
			),
		),
	);
	$upcoming_query = new WP_Query( $upcoming_args );

	// Past events: event_date < today, sorted DESC (most recent first)
	$past_args = array(
		'post_type'      => 'ember_event',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'meta_key'       => 'event_date',
		'orderby'        => 'meta_value',
		'order'          => 'DESC',
		'meta_query'     => array(
			array(
				'key'     => 'event_date',
				'value'   => $today,
				'compare' => '<',
				'type'    => 'DATE',
			),
		),
	);
	$past_query = new WP_Query( $past_args );
	?>

	<div class="events-archive">

		<header class="archive-header">
			<div class="container">
				<h1 class="archive-title"><?php post_type_archive_title(); ?></h1>
				<?php
				$pt_obj = get_post_type_object( 'ember_event' );
				if ( $pt_obj && ! empty( $pt_obj->description ) ) :
				?>
					<div class="archive-description"><?php echo wp_kses_post( $pt_obj->description ); ?></div>
				<?php endif; ?>
			</div>
		</header>

		<div class="container events-archive__inner">

			<!-- Upcoming Events -->
			<section class="events-archive__section events-archive__section--upcoming" aria-labelledby="upcoming-events-heading">

				<h2 class="events-archive__section-heading" id="upcoming-events-heading">
					<?php esc_html_e( 'Upcoming Events', 'ember-oak' ); ?>
				</h2>

				<?php if ( $upcoming_query->have_posts() ) : ?>

					<div class="events-grid events-grid--upcoming">

						<?php while ( $upcoming_query->have_posts() ) : $upcoming_query->the_post(); ?>

							<?php
							$event_date_raw = get_post_meta( get_the_ID(), 'event_date', true );
							$event_location = get_post_meta( get_the_ID(), 'event_location', true );
							$event_price    = get_post_meta( get_the_ID(), 'price', true );

							// Format date nicely if available
							$event_date_display = '';
							if ( $event_date_raw ) {
								$ts = strtotime( $event_date_raw );
								if ( $ts ) {
									$event_date_display = date_i18n( get_option( 'date_format' ), $ts );
								}
							}
							?>

							<article class="event-card event-card--upcoming">

								<div class="event-card__body">

									<?php if ( $event_date_display ) : ?>
										<time class="event-card__date" datetime="<?php echo esc_attr( $event_date_raw ); ?>">
											<?php echo esc_html( $event_date_display ); ?>
										</time>
									<?php endif; ?>

									<h3 class="event-card__title">
										<a class="event-card__title-link" href="<?php the_permalink(); ?>">
											<?php the_title(); ?>
										</a>
									</h3>

									<?php if ( $event_location ) : ?>
										<p class="event-card__location">
											<span class="event-card__location-icon" aria-hidden="true">&#128205;</span>
											<?php echo esc_html( $event_location ); ?>
										</p>
									<?php endif; ?>

									<?php if ( $event_price ) : ?>
										<p class="event-card__price">
											<?php echo esc_html( $event_price ); ?>
										</p>
									<?php endif; ?>

									<a class="event-card__link button button--primary" href="<?php the_permalink(); ?>">
										<?php esc_html_e( 'Event Details', 'ember-oak' ); ?>
									</a>

								</div><!-- .event-card__body -->

							</article><!-- .event-card -->

						<?php endwhile; wp_reset_postdata(); ?>

					</div><!-- .events-grid--upcoming -->

				<?php else : ?>

					<p class="events-archive__empty">
						<?php esc_html_e( 'No upcoming events at this time. Check back soon!', 'ember-oak' ); ?>
					</p>

				<?php endif; ?>

			</section><!-- .events-archive__section--upcoming -->

			<!-- Past Events -->
			<?php if ( $past_query->have_posts() ) : ?>

			<section class="events-archive__section events-archive__section--past" aria-labelledby="past-events-heading">

				<h2 class="events-archive__section-heading" id="past-events-heading">
					<?php esc_html_e( 'Past Events', 'ember-oak' ); ?>
				</h2>

				<div class="events-grid events-grid--past">

					<?php while ( $past_query->have_posts() ) : $past_query->the_post(); ?>

						<?php
						$event_date_raw = get_post_meta( get_the_ID(), 'event_date', true );
						$event_location = get_post_meta( get_the_ID(), 'event_location', true );
						$event_price    = get_post_meta( get_the_ID(), 'price', true );

						$event_date_display = '';
						if ( $event_date_raw ) {
							$ts = strtotime( $event_date_raw );
							if ( $ts ) {
								$event_date_display = date_i18n( get_option( 'date_format' ), $ts );
							}
						}
						?>

						<article class="event-card event-card--past">

							<div class="event-card__body">

								<?php if ( $event_date_display ) : ?>
									<time class="event-card__date" datetime="<?php echo esc_attr( $event_date_raw ); ?>">
										<?php echo esc_html( $event_date_display ); ?>
									</time>
								<?php endif; ?>

								<h3 class="event-card__title">
									<a class="event-card__title-link" href="<?php the_permalink(); ?>">
										<?php the_title(); ?>
									</a>
								</h3>

								<?php if ( $event_location ) : ?>
									<p class="event-card__location">
										<span class="event-card__location-icon" aria-hidden="true">&#128205;</span>
										<?php echo esc_html( $event_location ); ?>
									</p>
								<?php endif; ?>

								<?php if ( $event_price ) : ?>
									<p class="event-card__price">
										<?php echo esc_html( $event_price ); ?>
									</p>
								<?php endif; ?>

								<a class="event-card__link button button--secondary" href="<?php the_permalink(); ?>">
									<?php esc_html_e( 'View Event', 'ember-oak' ); ?>
								</a>

							</div><!-- .event-card__body -->

						</article><!-- .event-card -->

					<?php endwhile; wp_reset_postdata(); ?>

				</div><!-- .events-grid--past -->

			</section><!-- .events-archive__section--past -->

			<?php endif; ?>

		</div><!-- .events-archive__inner -->

	</div><!-- .events-archive -->

<?php else : ?>

	<!-- Standard Blog Archive -->
	<div class="posts-archive">

		<header class="archive-header">
			<div class="container">
				<h1 class="archive-title"><?php the_archive_title(); ?></h1>
				<?php
				$archive_description = get_the_archive_description();
				if ( $archive_description ) :
				?>
					<div class="archive-description">
						<?php echo wp_kses_post( $archive_description ); ?>
					</div>
				<?php endif; ?>
			</div>
		</header>

		<div class="container posts-archive__inner">

			<main class="posts-archive__main" id="main-content">

				<?php if ( have_posts() ) : ?>

					<div class="posts-grid posts-grid--two-col">

						<?php while ( have_posts() ) : the_post(); ?>

							<?php get_template_part( 'template-parts/content', get_post_format() ); ?>

						<?php endwhile; ?>

					</div><!-- .posts-grid -->

					<?php the_posts_pagination( array(
						'mid_size'  => 2,
						'prev_text' => sprintf(
							'<span class="nav-subtitle">%s</span> <span class="nav-title">%s</span>',
							esc_html__( 'Newer', 'ember-oak' ),
							'&larr;'
						),
						'next_text' => sprintf(
							'<span class="nav-subtitle">%s</span> <span class="nav-title">%s</span>',
							esc_html__( 'Older', 'ember-oak' ),
							'&rarr;'
						),
					) ); ?>

				<?php else : ?>

					<p class="posts-archive__empty">
						<?php esc_html_e( 'No posts found.', 'ember-oak' ); ?>
					</p>

				<?php endif; ?>

			</main><!-- .posts-archive__main -->

			<?php get_sidebar(); ?>

		</div><!-- .posts-archive__inner -->

	</div><!-- .posts-archive -->

<?php endif; ?>

<?php get_footer(); ?>
