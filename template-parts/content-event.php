<?php
/**
 * Template part for displaying a single Ember Event post.
 *
 * @package Ember_Oak
 */

$meta       = ember_oak_get_event_meta( get_the_ID() );
$today      = date( 'Y-m-d' );
$is_past    = ! empty( $meta['event_date'] ) && $meta['event_date'] < $today;
$rsvp_email = get_theme_mod( 'ember_oak_email', '' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'event-single' ); ?>>

	<!-- Hero -->
	<div class="event-hero">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="event-hero-image">
				<?php the_post_thumbnail( 'full', array( 'class' => 'event-hero-img', 'alt' => get_the_title() ) ); ?>
			</div>
		<?php endif; ?>
		<div class="event-hero-overlay">
			<div class="event-hero-inner">
				<?php if ( ! empty( $meta['event_date'] ) ) : ?>
					<div class="event-date-badge">
						<span class="date-badge-day"><?php echo esc_html( date( 'j', strtotime( $meta['event_date'] ) ) ); ?></span>
						<span class="date-badge-month"><?php echo esc_html( date( 'M', strtotime( $meta['event_date'] ) ) ); ?></span>
					</div>
				<?php endif; ?>
				<h1 class="event-hero-title"><?php the_title(); ?></h1>
			</div>
		</div>
	</div><!-- .event-hero -->

	<!-- Past event notice -->
	<?php if ( $is_past ) : ?>
		<div class="event-past-notice" role="alert">
			<?php esc_html_e( 'This event has passed.', 'ember-oak' ); ?>
		</div>
	<?php endif; ?>

	<!-- Two-column layout -->
	<div class="event-layout">

		<!-- Left: content -->
		<div class="event-content">

			<div class="entry-content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->

			<section class="event-what-to-expect">
				<h2 class="section-heading"><?php esc_html_e( 'What to Expect', 'ember-oak' ); ?></h2>
				<ul class="expect-list">
					<li><?php esc_html_e( 'An intimate, hands-on session guided by our head roaster in a relaxed café setting.', 'ember-oak' ); ?></li>
					<li><?php esc_html_e( 'A curated flight of three to four single-origin coffees brewed using multiple methods.', 'ember-oak' ); ?></li>
					<li><?php esc_html_e( 'Deep dives into origin stories, processing methods, and roast profiles.', 'ember-oak' ); ?></li>
					<li><?php esc_html_e( 'Plenty of time for questions, discussion, and connecting with fellow coffee lovers.', 'ember-oak' ); ?></li>
					<li><?php esc_html_e( 'A relaxed, no-jargon atmosphere suitable for all experience levels.', 'ember-oak' ); ?></li>
				</ul>
			</section><!-- .event-what-to-expect -->

			<section class="event-whats-included">
				<h2 class="section-heading"><?php esc_html_e( "What's Included", 'ember-oak' ); ?></h2>
				<ul class="included-list">
					<li><?php esc_html_e( 'All brewing equipment and specialty coffee provided.', 'ember-oak' ); ?></li>
					<li><?php esc_html_e( 'Tasting notes card to take home.', 'ember-oak' ); ?></li>
					<li><?php esc_html_e( 'A 100g sample bag of your favourite blend from the session.', 'ember-oak' ); ?></li>
					<li><?php esc_html_e( '10% discount code for your next online order.', 'ember-oak' ); ?></li>
					<li><?php esc_html_e( 'Light refreshments.', 'ember-oak' ); ?></li>
				</ul>
			</section><!-- .event-whats-included -->

		</div><!-- .event-content -->

		<!-- Right: event details card -->
		<aside class="event-details-card">

			<h2 class="details-card-heading"><?php esc_html_e( 'Event Details', 'ember-oak' ); ?></h2>

			<dl class="event-meta-list">

				<?php if ( ! empty( $meta['event_date'] ) ) : ?>
					<dt><?php esc_html_e( 'Date', 'ember-oak' ); ?></dt>
					<dd class="event-meta-date">
						<?php echo esc_html( date( 'F j, Y', strtotime( $meta['event_date'] ) ) ); ?>
					</dd>
				<?php endif; ?>

				<?php if ( ! empty( $meta['event_time'] ) ) : ?>
					<dt><?php esc_html_e( 'Time', 'ember-oak' ); ?></dt>
					<dd class="event-meta-time"><?php echo esc_html( $meta['event_time'] ); ?></dd>
				<?php endif; ?>

				<?php if ( ! empty( $meta['event_location'] ) ) : ?>
					<dt><?php esc_html_e( 'Location', 'ember-oak' ); ?></dt>
					<dd class="event-meta-location">
						<?php echo esc_html( $meta['event_location'] ); ?>
						<a
							href="https://www.google.com/maps/search/?api=1&query=<?php echo rawurlencode( $meta['event_location'] ); ?>"
							class="maps-link"
							target="_blank"
							rel="noopener noreferrer"
						>
							<?php esc_html_e( 'View on Google Maps', 'ember-oak' ); ?>
						</a>
					</dd>
				<?php endif; ?>

				<?php if ( ! empty( $meta['event_price'] ) ) : ?>
					<dt><?php esc_html_e( 'Price', 'ember-oak' ); ?></dt>
					<dd class="event-meta-price"><?php echo esc_html( $meta['event_price'] ); ?></dd>
				<?php endif; ?>

				<?php if ( ! empty( $meta['event_capacity'] ) ) : ?>
					<dt><?php esc_html_e( 'Capacity', 'ember-oak' ); ?></dt>
					<dd class="event-meta-capacity">
						<?php
						printf(
							/* translators: %s: number of spots */
							esc_html__( '%s spots', 'ember-oak' ),
							esc_html( $meta['event_capacity'] )
						);
						?>
					</dd>
				<?php endif; ?>

			</dl><!-- .event-meta-list -->

			<?php if ( ! $is_past ) : ?>
				<?php if ( $rsvp_email ) : ?>
					<a
						href="<?php echo esc_url( 'mailto:' . antispambot( $rsvp_email ) . '?subject=' . rawurlencode( 'RSVP: ' . get_the_title() ) ); ?>"
						class="btn btn-primary btn-block event-rsvp-btn"
					>
						<?php esc_html_e( 'RSVP for this Event', 'ember-oak' ); ?>
					</a>
				<?php else : ?>
					<p class="rsvp-unavailable"><?php esc_html_e( 'RSVP details coming soon.', 'ember-oak' ); ?></p>
				<?php endif; ?>
			<?php else : ?>
				<p class="event-past-cta">
					<?php esc_html_e( 'Check our upcoming events below.', 'ember-oak' ); ?>
				</p>
			<?php endif; ?>

		</aside><!-- .event-details-card -->

	</div><!-- .event-layout -->

	<!-- Related / Upcoming Events -->
	<?php
	$upcoming_args = array(
		'post_type'      => 'ember_event',
		'posts_per_page' => 2,
		'post__not_in'   => array( get_the_ID() ),
		'meta_key'       => '_ember_event_date',
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
		'meta_query'     => array(
			array(
				'key'     => '_ember_event_date',
				'value'   => $today,
				'compare' => '>=',
				'type'    => 'DATE',
			),
		),
	);
	$upcoming_query = new WP_Query( $upcoming_args );

	if ( $upcoming_query->have_posts() ) :
	?>
		<section class="related-events">
			<h2 class="section-heading"><?php esc_html_e( 'Upcoming Events', 'ember-oak' ); ?></h2>
			<div class="related-events-grid">
				<?php while ( $upcoming_query->have_posts() ) : $upcoming_query->the_post();
					$rel_meta = ember_oak_get_event_meta( get_the_ID() );
				?>
					<article class="related-event-card">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" class="related-event-thumb" tabindex="-1" aria-hidden="true">
								<?php the_post_thumbnail( 'medium', array( 'alt' => get_the_title() ) ); ?>
							</a>
						<?php endif; ?>
						<div class="related-event-info">
							<?php if ( ! empty( $rel_meta['event_date'] ) ) : ?>
								<span class="related-event-date">
									<?php echo esc_html( date( 'F j, Y', strtotime( $rel_meta['event_date'] ) ) ); ?>
								</span>
							<?php endif; ?>
							<h3 class="related-event-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>
							<?php if ( ! empty( $rel_meta['event_location'] ) ) : ?>
								<span class="related-event-location"><?php echo esc_html( $rel_meta['event_location'] ); ?></span>
							<?php endif; ?>
							<?php if ( ! empty( $rel_meta['event_price'] ) ) : ?>
								<span class="related-event-price"><?php echo esc_html( $rel_meta['event_price'] ); ?></span>
							<?php endif; ?>
						</div>
					</article>
				<?php endwhile; ?>
			</div><!-- .related-events-grid -->
		</section><!-- .related-events -->
	<?php
	endif;
	wp_reset_postdata();
	?>

</article><!-- .event-single -->
