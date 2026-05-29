<?php
/**
 * Front Page Template — Ember & Oak
 *
 * @package Ember_Oak
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_template_part( 'header' );
?>

	<?php
	// =========================================================================
	// 1. HERO SECTION
	// =========================================================================

	$hero_heading    = get_theme_mod( 'hero_heading',    'Small-Batch Coffee, Big Soul' );
	$hero_subheading = get_theme_mod( 'hero_subheading', 'Roasted in small batches in our Brooklyn workshop' );
	$hero_cta_text   = get_theme_mod( 'hero_cta_text',   'Shop Our Blends' );
	$hero_cta_url    = get_theme_mod( 'hero_cta_url',    get_post_type_archive_link( 'ember_blend' ) );

	// Resolve hero background: featured image of current page, else CSS gradient.
	$hero_style      = '';
	$hero_img_class  = '';
	if ( is_page() && has_post_thumbnail() ) {
		$hero_img_src = get_the_post_thumbnail_url( get_queried_object_id(), 'ember-oak-hero' );
		if ( $hero_img_src ) {
			$hero_style     = ' style="background-image: url(' . esc_url( $hero_img_src ) . ');"';
			$hero_img_class = ' hero--has-image';
		}
	}
	?>

	<section class="hero<?php echo esc_attr( $hero_img_class ); ?>"<?php echo $hero_style; // Already escaped above. ?> aria-label="<?php esc_attr_e( 'Hero', 'ember-oak' ); ?>">
		<div class="hero__overlay" aria-hidden="true"></div>
		<div class="hero__inner">
			<div class="hero__content">
				<?php if ( $hero_heading ) : ?>
					<h1 class="hero__heading"><?php echo esc_html( $hero_heading ); ?></h1>
				<?php endif; ?>

				<?php if ( $hero_subheading ) : ?>
					<p class="hero__subheading"><?php echo esc_html( $hero_subheading ); ?></p>
				<?php endif; ?>

				<?php if ( $hero_cta_text && $hero_cta_url ) : ?>
					<div class="hero__actions">
						<a href="<?php echo esc_url( $hero_cta_url ); ?>" class="btn btn--primary hero__cta">
							<?php echo esc_html( $hero_cta_text ); ?>
						</a>
					</div>
				<?php endif; ?>
			</div><!-- .hero__content -->
		</div><!-- .hero__inner -->

		<a class="hero__scroll-indicator" href="#intro" aria-label="<?php esc_attr_e( 'Scroll down', 'ember-oak' ); ?>">
			<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
				<circle cx="16" cy="16" r="15" stroke="currentColor" stroke-width="1.5" fill="none"/>
				<path d="M10 14l6 6 6-6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</a>
	</section><!-- .hero -->


	<?php
	// =========================================================================
	// 2. INTRO SECTION
	// =========================================================================
	?>

	<section id="intro" class="intro-section" aria-labelledby="intro-heading">
		<div class="intro-section__inner">

			<div class="intro-section__story">
				<span class="intro-section__est" aria-hidden="true">Est. 2018</span>
				<h2 id="intro-heading" class="intro-section__heading"><?php esc_html_e( 'Coffee as a craft, not a commodity', 'ember-oak' ); ?></h2>
				<p class="intro-section__body">
					<?php esc_html_e( 'Ember &amp; Oak started with a simple belief: great coffee deserves more than a conveyor belt. From our Brooklyn workshop we source directly from farmers we trust, roast every batch by hand, and ship within 48 hours of roasting — so what lands on your doorstep is genuinely fresh, genuinely considered, and genuinely delicious.', 'ember-oak' ); ?>
				</p>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'about' ) ) ?: home_url( '/about/' ) ); ?>" class="btn btn--secondary">
					<?php esc_html_e( 'Our Story', 'ember-oak' ); ?>
				</a>
			</div><!-- .intro-section__story -->

			<div class="intro-section__stats" role="list" aria-label="<?php esc_attr_e( 'Key facts', 'ember-oak' ); ?>">

				<div class="stat-card" role="listitem">
					<span class="stat-card__number">12+</span>
					<span class="stat-card__label"><?php esc_html_e( 'Origins', 'ember-oak' ); ?></span>
					<p class="stat-card__desc"><?php esc_html_e( 'Beans sourced from farms across Africa, Latin America &amp; Asia.', 'ember-oak' ); ?></p>
				</div>

				<div class="stat-card" role="listitem">
					<span class="stat-card__number">3</span>
					<span class="stat-card__label"><?php esc_html_e( 'Roast Profiles', 'ember-oak' ); ?></span>
					<p class="stat-card__desc"><?php esc_html_e( 'Light, medium, and dark — crafted for every palate.', 'ember-oak' ); ?></p>
				</div>

				<div class="stat-card" role="listitem">
					<span class="stat-card__number">&#x1F525;</span>
					<span class="stat-card__label"><?php esc_html_e( 'Weekly Roast', 'ember-oak' ); ?></span>
					<p class="stat-card__desc"><?php esc_html_e( 'Fresh batches roasted every week — never stale, always vibrant.', 'ember-oak' ); ?></p>
				</div>

				<div class="stat-card" role="listitem">
					<span class="stat-card__number">&#x1F69A;</span>
					<span class="stat-card__label"><?php esc_html_e( 'Free Shipping', 'ember-oak' ); ?></span>
					<p class="stat-card__desc"><?php esc_html_e( 'Complimentary delivery on all orders over $50.', 'ember-oak' ); ?></p>
				</div>

			</div><!-- .intro-section__stats -->

		</div><!-- .intro-section__inner -->
	</section><!-- .intro-section -->


	<?php
	// =========================================================================
	// 3. FEATURED BLENDS SECTION
	// =========================================================================

	$blends_query = new WP_Query( array(
		'post_type'      => 'ember_blend',
		'posts_per_page' => 3,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'post_status'    => 'publish',
		'no_found_rows'  => true,
	) );
	?>

	<section class="featured-blends" aria-labelledby="blends-heading">
		<div class="featured-blends__inner">

			<div class="section-header">
				<h2 id="blends-heading" class="section-header__title"><?php esc_html_e( 'Our Signature Blends', 'ember-oak' ); ?></h2>
				<p class="section-header__sub"><?php esc_html_e( 'Carefully curated, meticulously roasted.', 'ember-oak' ); ?></p>
			</div>

			<?php if ( $blends_query->have_posts() ) : ?>

				<div class="blends-grid">
					<?php while ( $blends_query->have_posts() ) : $blends_query->the_post();
						$blend_meta  = ember_oak_get_blend_meta( get_the_ID() );
						$roast_label = $blend_meta['roast_level'] ? ember_oak_roast_level_label( $blend_meta['roast_level'] ) : '';
						$price       = $blend_meta['price'] ? '$' . number_format( (float) $blend_meta['price'], 2 ) : '';
						$excerpt     = ember_oak_excerpt( 20 );
					?>
					<article class="blend-card" aria-label="<?php the_title_attribute(); ?>">

						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" class="blend-card__image-link" tabindex="-1" aria-hidden="true">
								<?php
								the_post_thumbnail(
									'ember-oak-card',
									array(
										'class'   => 'blend-card__image',
										'loading' => 'lazy',
										'alt'     => '',
									)
								);
								?>
							</a>
						<?php else : ?>
							<div class="blend-card__image-placeholder" aria-hidden="true">
								<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64" aria-hidden="true" focusable="false">
									<circle cx="32" cy="32" r="30" fill="none" stroke="currentColor" stroke-width="2"/>
									<path d="M20 40c3-8 10-14 12-22 2 8 9 14 12 22a14 14 0 01-24 0z" fill="currentColor" opacity=".25"/>
								</svg>
							</div>
						<?php endif; ?>

						<div class="blend-card__body">

							<?php if ( $roast_label ) : ?>
								<span class="blend-card__badge blend-card__badge--<?php echo esc_attr( $blend_meta['roast_level'] ); ?>">
									<?php echo esc_html( $roast_label ); ?>
								</span>
							<?php endif; ?>

							<h3 class="blend-card__title">
								<a href="<?php the_permalink(); ?>" class="blend-card__title-link">
									<?php the_title(); ?>
								</a>
							</h3>

							<?php if ( $excerpt ) : ?>
								<p class="blend-card__excerpt"><?php echo wp_kses_post( $excerpt ); ?></p>
							<?php endif; ?>

							<div class="blend-card__footer">
								<?php if ( $price ) : ?>
									<span class="blend-card__price"><?php echo esc_html( $price ); ?></span>
								<?php endif; ?>
								<a href="<?php the_permalink(); ?>" class="btn btn--outline blend-card__link">
									<?php esc_html_e( 'Learn More', 'ember-oak' ); ?>
								</a>
							</div>

						</div><!-- .blend-card__body -->
					</article><!-- .blend-card -->
					<?php endwhile; wp_reset_postdata(); ?>
				</div><!-- .blends-grid -->

				<div class="featured-blends__cta">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'ember_blend' ) ?: home_url( '/blends/' ) ); ?>" class="btn btn--primary">
						<?php esc_html_e( 'View All Blends', 'ember-oak' ); ?>
					</a>
				</div>

			<?php else : ?>

				<p class="featured-blends__empty">
					<?php esc_html_e( 'Our blends are coming soon. Check back shortly or explore our story while you wait.', 'ember-oak' ); ?>
				</p>

			<?php endif; ?>

		</div><!-- .featured-blends__inner -->
	</section><!-- .featured-blends -->


	<?php
	// =========================================================================
	// 4. PROCESS SECTION
	// =========================================================================

	$process_steps = array(
		array(
			'number' => '01',
			'title'  => __( 'Source', 'ember-oak' ),
			'desc'   => __( 'We travel to farms across Ethiopia, Colombia, Guatemala and beyond, building direct relationships and paying prices that reflect quality and care.', 'ember-oak' ),
			'icon'   => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" aria-hidden="true" focusable="false"><circle cx="20" cy="20" r="18" stroke="currentColor" stroke-width="2" fill="none"/><path d="M20 10a8 8 0 018 8c0 5-8 14-8 14s-8-9-8-14a8 8 0 018-8z" stroke="currentColor" stroke-width="1.5" fill="none"/><circle cx="20" cy="18" r="2.5" fill="currentColor"/></svg>',
		),
		array(
			'number' => '02',
			'title'  => __( 'Roast', 'ember-oak' ),
			'desc'   => __( 'Every batch is roasted by hand in our Brooklyn workshop using a vintage drum roaster, dialled to precise temperature curves that unlock the best of each origin.', 'ember-oak' ),
			'icon'   => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" aria-hidden="true" focusable="false"><path d="M10 30h20M14 30V18a6 6 0 0112 0v12" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"/><path d="M20 18c0-3 4-5 4-9" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/><path d="M16 20c0-2 3-4 3-7" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg>',
		),
		array(
			'number' => '03',
			'title'  => __( 'Package', 'ember-oak' ),
			'desc'   => __( 'Within 24 hours of the roast we seal your beans in valve-sealed, compostable bags that lock in freshness and tell you exactly when and where your coffee was roasted.', 'ember-oak' ),
			'icon'   => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" aria-hidden="true" focusable="false"><rect x="8" y="14" width="24" height="20" rx="2" stroke="currentColor" stroke-width="2" fill="none"/><path d="M8 20h24M15 14V8h10v6" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/><path d="M16 27h8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
		),
		array(
			'number' => '04',
			'title'  => __( 'Ship', 'ember-oak' ),
			'desc'   => __( 'Orders dispatched within 48 hours of roasting. Free shipping on orders over $50. Your coffee arrives at its absolute peak — ready to brew, ready to savour.', 'ember-oak' ),
			'icon'   => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" aria-hidden="true" focusable="false"><rect x="4" y="14" width="22" height="16" rx="2" stroke="currentColor" stroke-width="2" fill="none"/><path d="M26 18h5l5 6v6h-10V18z" stroke="currentColor" stroke-width="2" fill="none" stroke-linejoin="round"/><circle cx="11" cy="32" r="3" stroke="currentColor" stroke-width="1.5" fill="none"/><circle cx="29" cy="32" r="3" stroke="currentColor" stroke-width="1.5" fill="none"/></svg>',
		),
	);
	?>

	<section class="process-section" aria-labelledby="process-heading">
		<div class="process-section__inner">

			<div class="section-header section-header--light">
				<h2 id="process-heading" class="section-header__title"><?php esc_html_e( 'From Farm to Cup', 'ember-oak' ); ?></h2>
				<p class="section-header__sub"><?php esc_html_e( 'Every sip carries the full journey.', 'ember-oak' ); ?></p>
			</div>

			<ol class="process-steps" role="list">
				<?php foreach ( $process_steps as $step ) : ?>
				<li class="process-step">
					<div class="process-step__number" aria-hidden="true"><?php echo esc_html( $step['number'] ); ?></div>
					<div class="process-step__icon" aria-hidden="true"><?php echo $step['icon']; // SVG with aria-hidden. ?></div>
					<h3 class="process-step__title"><?php echo esc_html( $step['title'] ); ?></h3>
					<p class="process-step__desc"><?php echo esc_html( $step['desc'] ); ?></p>
				</li>
				<?php endforeach; ?>
			</ol><!-- .process-steps -->

		</div><!-- .process-section__inner -->
	</section><!-- .process-section -->


	<?php
	// =========================================================================
	// 5. EVENTS PREVIEW SECTION
	// =========================================================================

	$today         = current_time( 'Y-m-d' );
	$events_query  = new WP_Query( array(
		'post_type'      => 'ember_event',
		'posts_per_page' => 2,
		'post_status'    => 'publish',
		'no_found_rows'  => true,
		'meta_key'       => '_event_date',
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
		'meta_query'     => array(
			array(
				'key'     => '_event_date',
				'value'   => $today,
				'compare' => '>=',
				'type'    => 'DATE',
			),
		),
	) );
	?>

	<section class="events-preview" aria-labelledby="events-heading">
		<div class="events-preview__inner">

			<div class="section-header">
				<h2 id="events-heading" class="section-header__title"><?php esc_html_e( 'Upcoming Events', 'ember-oak' ); ?></h2>
				<p class="section-header__sub"><?php esc_html_e( 'Cuppings, tastings, and workshops — come see us in person.', 'ember-oak' ); ?></p>
			</div>

			<?php if ( $events_query->have_posts() ) : ?>

				<div class="events-grid">
					<?php while ( $events_query->have_posts() ) : $events_query->the_post();
						$event_meta = ember_oak_get_event_meta( get_the_ID() );
						$raw_date   = $event_meta['event_date'];
						$display_date = $raw_date
							? date_i18n( get_option( 'date_format' ), strtotime( $raw_date ) )
							: '';
						$display_month = $raw_date ? date_i18n( 'M',  strtotime( $raw_date ) ) : '';
						$display_day   = $raw_date ? date_i18n( 'j',  strtotime( $raw_date ) ) : '';
					?>
					<article class="event-card" aria-label="<?php the_title_attribute(); ?>">

						<?php if ( $raw_date ) : ?>
							<div class="event-card__date" aria-label="<?php echo esc_attr( $display_date ); ?>">
								<span class="event-card__date-month"><?php echo esc_html( $display_month ); ?></span>
								<span class="event-card__date-day"><?php echo esc_html( $display_day ); ?></span>
							</div>
						<?php endif; ?>

						<div class="event-card__body">
							<h3 class="event-card__title">
								<a href="<?php the_permalink(); ?>" class="event-card__title-link">
									<?php the_title(); ?>
								</a>
							</h3>

							<dl class="event-card__meta">
								<?php if ( $event_meta['event_time'] ) : ?>
									<div class="event-card__meta-row">
										<dt class="screen-reader-text"><?php esc_html_e( 'Time:', 'ember-oak' ); ?></dt>
										<dd class="event-card__meta-time">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/><path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"/></svg>
											<?php echo esc_html( $event_meta['event_time'] ); ?>
										</dd>
									</div>
								<?php endif; ?>

								<?php if ( $event_meta['event_location'] ) : ?>
									<div class="event-card__meta-row">
										<dt class="screen-reader-text"><?php esc_html_e( 'Location:', 'ember-oak' ); ?></dt>
										<dd class="event-card__meta-location">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 2a7 7 0 017 7c0 5-7 13-7 13S5 14 5 9a7 7 0 017-7z" stroke="currentColor" stroke-width="2" fill="none"/><circle cx="12" cy="9" r="2.5" stroke="currentColor" stroke-width="1.5" fill="none"/></svg>
											<?php echo esc_html( $event_meta['event_location'] ); ?>
										</dd>
									</div>
								<?php endif; ?>

								<?php if ( $event_meta['event_price'] ) : ?>
									<div class="event-card__meta-row">
										<dt class="screen-reader-text"><?php esc_html_e( 'Price:', 'ember-oak' ); ?></dt>
										<dd class="event-card__meta-price">
											<?php echo esc_html( $event_meta['event_price'] ); ?>
										</dd>
									</div>
								<?php endif; ?>
							</dl>

							<a href="<?php the_permalink(); ?>" class="btn btn--outline event-card__link">
								<?php esc_html_e( 'Event Details', 'ember-oak' ); ?>
							</a>
						</div><!-- .event-card__body -->

					</article><!-- .event-card -->
					<?php endwhile; wp_reset_postdata(); ?>
				</div><!-- .events-grid -->

			<?php else : ?>

				<p class="events-preview__empty">
					<?php esc_html_e( 'No upcoming events right now — follow us on Instagram to be first to know about our next cupping.', 'ember-oak' ); ?>
				</p>

			<?php endif; ?>

			<div class="events-preview__cta">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ember_event' ) ?: home_url( '/events/' ) ); ?>" class="btn btn--secondary">
					<?php esc_html_e( 'View All Events', 'ember-oak' ); ?>
				</a>
			</div>

		</div><!-- .events-preview__inner -->
	</section><!-- .events-preview -->


	<?php
	// =========================================================================
	// 6. TESTIMONIALS SECTION
	// =========================================================================

	$testimonials = array(
		array(
			'name'     => 'Sarah M.',
			'location' => 'Portland, OR',
			'quote'    => 'I have ordered from dozens of roasters and Ember &amp; Oak consistently blows them all out of the water. The Brooklyn Sunrise blend is liquid gold — bright, fruity, and absolutely beautiful in an aero press.',
			'rating'   => 5,
		),
		array(
			'name'     => 'James T.',
			'location' => 'Austin, TX',
			'quote'    => 'What sold me was the freshness. My first order arrived two days after the roast date printed on the bag. You can taste the difference immediately. I cancelled every other subscription that week.',
			'rating'   => 5,
		),
		array(
			'name'     => 'Elena R.',
			'location' => 'Chicago, IL',
			'quote'    => 'The Tasting Notes card that comes in every order is such a thoughtful touch. My partner and I make a whole ritual out of trying to spot each flavour. We have been subscribers for two years now — we are never leaving.',
			'rating'   => 5,
		),
	);
	?>

	<section class="testimonials" aria-labelledby="testimonials-heading">
		<div class="testimonials__inner">

			<div class="section-header section-header--light">
				<h2 id="testimonials-heading" class="section-header__title"><?php esc_html_e( 'What Our Customers Say', 'ember-oak' ); ?></h2>
			</div>

			<div class="testimonials__grid" role="list">
				<?php foreach ( $testimonials as $t ) :
					$stars = (int) $t['rating'];
				?>
				<blockquote class="testimonial-card" role="listitem">

					<div class="testimonial-card__stars" aria-label="<?php echo esc_attr( sprintf( __( '%d out of 5 stars', 'ember-oak' ), $stars ) ); ?>">
						<?php for ( $i = 0; $i < 5; $i++ ) : ?>
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true" focusable="false" class="star-icon<?php echo $i < $stars ? ' star-icon--filled' : ' star-icon--empty'; ?>">
								<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="currentColor" stroke-width="1.5" <?php echo $i < $stars ? 'fill="currentColor"' : 'fill="none"'; ?>/>
							</svg>
						<?php endfor; ?>
					</div>

					<p class="testimonial-card__quote"><?php echo wp_kses( $t['quote'], array( 'amp' => array() ) ); ?></p>

					<footer class="testimonial-card__footer">
						<cite class="testimonial-card__author">
							<strong class="testimonial-card__name"><?php echo esc_html( $t['name'] ); ?></strong>
							<span class="testimonial-card__location"><?php echo esc_html( $t['location'] ); ?></span>
						</cite>
					</footer>

				</blockquote><!-- .testimonial-card -->
				<?php endforeach; ?>
			</div><!-- .testimonials__grid -->

		</div><!-- .testimonials__inner -->
	</section><!-- .testimonials -->


	<?php
	// =========================================================================
	// 7. CTA BANNER SECTION
	// =========================================================================
	?>

	<section class="cta-banner" aria-labelledby="cta-banner-heading">
		<div class="cta-banner__inner">

			<h2 id="cta-banner-heading" class="cta-banner__heading">
				<?php esc_html_e( 'Ready to discover your perfect roast?', 'ember-oak' ); ?>
			</h2>
			<p class="cta-banner__sub">
				<?php esc_html_e( 'Join thousands of coffee lovers who have already made the switch to genuinely fresh, genuinely delicious small-batch coffee.', 'ember-oak' ); ?>
			</p>

			<div class="cta-banner__actions">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ember_blend' ) ?: home_url( '/blends/' ) ); ?>" class="btn btn--primary btn--large">
					<?php esc_html_e( 'Shop All Blends', 'ember-oak' ); ?>
				</a>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ember_event' ) ?: home_url( '/events/' ) ); ?>" class="btn btn--outline-light btn--large">
					<?php esc_html_e( 'Attend a Tasting', 'ember-oak' ); ?>
				</a>
			</div>

		</div><!-- .cta-banner__inner -->
	</section><!-- .cta-banner -->

<?php get_template_part( 'footer' ); ?>
