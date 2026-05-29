<?php
/**
 * Template part for displaying a single Ember Blend post.
 *
 * @package Ember_Oak
 */

$meta = ember_oak_get_blend_meta( get_the_ID() );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'blend-single' ); ?>>

	<!-- Hero -->
	<div class="blend-single-hero">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="blend-hero-image">
				<?php the_post_thumbnail( 'full', array( 'class' => 'blend-hero-img', 'alt' => get_the_title() ) ); ?>
			</div>
		<?php endif; ?>
		<div class="blend-hero-overlay">
			<div class="blend-hero-inner">
				<?php if ( ! empty( $meta['roast_level'] ) ) : ?>
					<span class="roast-badge roast-<?php echo esc_attr( sanitize_title( $meta['roast_level'] ) ); ?>">
						<?php echo esc_html( $meta['roast_level'] ); ?>
					</span>
				<?php endif; ?>
				<h1 class="blend-hero-title"><?php the_title(); ?></h1>
			</div>
		</div>
	</div><!-- .blend-single-hero -->

	<!-- Two-column layout -->
	<div class="blend-layout">

		<!-- Left: content -->
		<div class="blend-content">

			<div class="entry-content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->

			<?php if ( ! empty( $meta['tasting_notes'] ) ) : ?>
				<section class="blend-tasting-notes">
					<h2 class="section-heading"><?php esc_html_e( 'Tasting Notes', 'ember-oak' ); ?></h2>
					<div class="tasting-notes-body">
						<?php echo wp_kses_post( $meta['tasting_notes'] ); ?>
					</div>
				</section>
			<?php endif; ?>

			<section class="blend-origin">
				<h2 class="section-heading"><?php esc_html_e( 'Origin', 'ember-oak' ); ?></h2>
				<?php if ( ! empty( $meta['origin_region'] ) ) : ?>
					<p class="origin-region"><strong><?php esc_html_e( 'Region:', 'ember-oak' ); ?></strong> <?php echo esc_html( $meta['origin_region'] ); ?></p>
				<?php endif; ?>

				<?php
				$origin_terms = get_the_terms( get_the_ID(), 'blend_origin' );
				if ( $origin_terms && ! is_wp_error( $origin_terms ) ) :
				?>
					<div class="origin-terms">
						<?php foreach ( $origin_terms as $term ) : ?>
							<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="origin-tag">
								<?php echo esc_html( $term->name ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</section><!-- .blend-origin -->

			<?php if ( ! empty( $meta['process'] ) ) :
				$process_descriptions = array(
					'washed'          => 'The coffee cherry skin and fruit are removed before the beans are fermented in water tanks, then dried, producing a clean, bright cup.',
					'natural'         => 'Whole cherries are dried in the sun with the fruit intact, imparting fruity, wine-like sweetness to the bean.',
					'honey'           => 'The skin is removed but some mucilage is left on the bean during drying, striking a balance between washed clarity and natural sweetness.',
					'wet-hulled'      => 'Beans are partially dried then hulled while still moist, common in Indonesia, yielding a heavy body and earthy notes.',
					'anaerobic'       => 'Cherries ferment in sealed oxygen-free tanks, developing intense, complex flavours.',
					'carbonic'        => 'Whole cherries ferment intracellularly in a CO2-rich environment, producing vibrant, fruit-forward profiles.',
				);
				$process_key  = strtolower( sanitize_title( $meta['process'] ) );
				$process_desc = isset( $process_descriptions[ $process_key ] ) ? $process_descriptions[ $process_key ] : '';
			?>
				<section class="blend-process">
					<h2 class="section-heading"><?php esc_html_e( 'Process', 'ember-oak' ); ?></h2>
					<p class="process-name"><strong><?php echo esc_html( $meta['process'] ); ?></strong></p>
					<?php if ( $process_desc ) : ?>
						<p class="process-description"><?php echo esc_html( $process_desc ); ?></p>
					<?php endif; ?>
				</section>
			<?php endif; ?>

		</div><!-- .blend-content -->

		<!-- Right: sticky sidebar -->
		<aside class="blend-sidebar">
			<div class="purchase-card">

				<?php if ( ! empty( $meta['price'] ) ) : ?>
					<div class="purchase-price">
						<span class="price-label"><?php esc_html_e( 'Price', 'ember-oak' ); ?></span>
						<span class="price-amount">$<?php echo esc_html( $meta['price'] ); ?></span>
					</div>
				<?php endif; ?>

				<div class="weight-selector">
					<span class="weight-label"><?php esc_html_e( 'Weight', 'ember-oak' ); ?></span>
					<div class="weight-buttons">
						<button type="button" class="weight-btn" data-weight="250g" data-price="0">250g</button>
						<button type="button" class="weight-btn active" data-weight="500g" data-price="5">500g</button>
						<button type="button" class="weight-btn" data-weight="1kg" data-price="10">1kg</button>
					</div>
				</div>

				<div class="quantity-selector">
					<label for="blend-qty-<?php the_ID(); ?>" class="qty-label"><?php esc_html_e( 'Quantity', 'ember-oak' ); ?></label>
					<input
						type="number"
						id="blend-qty-<?php the_ID(); ?>"
						class="qty-input"
						min="1"
						value="1"
					>
				</div>

				<button type="button" class="btn btn-primary btn-block add-to-bag" data-post-id="<?php the_ID(); ?>">
					<?php esc_html_e( 'Add to Bag', 'ember-oak' ); ?>
				</button>

				<p class="shipping-note">
					<?php esc_html_e( 'Free shipping on orders over $50', 'ember-oak' ); ?>
				</p>

			</div><!-- .purchase-card -->
		</aside><!-- .blend-sidebar -->

	</div><!-- .blend-layout -->

	<!-- Brew Guides -->
	<section class="brew-guides">
		<h2 class="section-heading"><?php esc_html_e( 'Brew Guides', 'ember-oak' ); ?></h2>

		<div class="brew-tabs">
			<div class="tab-buttons" role="tablist">
				<button type="button" class="tab-btn active" role="tab" data-tab="pour-over" aria-selected="true">
					<?php esc_html_e( 'Pour Over', 'ember-oak' ); ?>
				</button>
				<button type="button" class="tab-btn" role="tab" data-tab="french-press" aria-selected="false">
					<?php esc_html_e( 'French Press', 'ember-oak' ); ?>
				</button>
				<button type="button" class="tab-btn" role="tab" data-tab="aeropress" aria-selected="false">
					<?php esc_html_e( 'AeroPress', 'ember-oak' ); ?>
				</button>
				<button type="button" class="tab-btn" role="tab" data-tab="espresso" aria-selected="false">
					<?php esc_html_e( 'Espresso', 'ember-oak' ); ?>
				</button>
			</div><!-- .tab-buttons -->

			<div class="tab-panels">

				<div id="tab-pour-over" class="tab-panel active" role="tabpanel">
					<h3><?php esc_html_e( 'Pour Over', 'ember-oak' ); ?></h3>
					<dl class="brew-specs">
						<dt><?php esc_html_e( 'Water Temperature', 'ember-oak' ); ?></dt>
						<dd>93&deg;C / 200&deg;F</dd>
						<dt><?php esc_html_e( 'Grind Size', 'ember-oak' ); ?></dt>
						<dd><?php esc_html_e( 'Medium-fine', 'ember-oak' ); ?></dd>
						<dt><?php esc_html_e( 'Coffee-to-Water Ratio', 'ember-oak' ); ?></dt>
						<dd>1:15 (e.g. 20g coffee / 300ml water)</dd>
						<dt><?php esc_html_e( 'Total Brew Time', 'ember-oak' ); ?></dt>
						<dd>3&ndash;4 minutes</dd>
					</dl>
					<p class="brew-tip"><?php esc_html_e( 'Bloom the grounds with twice their weight in water for 30 seconds before continuing your pour in slow, concentric circles.', 'ember-oak' ); ?></p>
				</div><!-- #tab-pour-over -->

				<div id="tab-french-press" class="tab-panel" role="tabpanel" hidden>
					<h3><?php esc_html_e( 'French Press', 'ember-oak' ); ?></h3>
					<dl class="brew-specs">
						<dt><?php esc_html_e( 'Water Temperature', 'ember-oak' ); ?></dt>
						<dd>95&deg;C / 203&deg;F</dd>
						<dt><?php esc_html_e( 'Grind Size', 'ember-oak' ); ?></dt>
						<dd><?php esc_html_e( 'Coarse', 'ember-oak' ); ?></dd>
						<dt><?php esc_html_e( 'Coffee-to-Water Ratio', 'ember-oak' ); ?></dt>
						<dd>1:12 (e.g. 30g coffee / 360ml water)</dd>
						<dt><?php esc_html_e( 'Total Brew Time', 'ember-oak' ); ?></dt>
						<dd>4 minutes</dd>
					</dl>
					<p class="brew-tip"><?php esc_html_e( 'After pouring, place the lid on without pressing. At 4 minutes, press slowly and pour immediately to prevent over-extraction.', 'ember-oak' ); ?></p>
				</div><!-- #tab-french-press -->

				<div id="tab-aeropress" class="tab-panel" role="tabpanel" hidden>
					<h3><?php esc_html_e( 'AeroPress', 'ember-oak' ); ?></h3>
					<dl class="brew-specs">
						<dt><?php esc_html_e( 'Water Temperature', 'ember-oak' ); ?></dt>
						<dd>85&ndash;90&deg;C / 185&ndash;194&deg;F</dd>
						<dt><?php esc_html_e( 'Grind Size', 'ember-oak' ); ?></dt>
						<dd><?php esc_html_e( 'Medium', 'ember-oak' ); ?></dd>
						<dt><?php esc_html_e( 'Coffee-to-Water Ratio', 'ember-oak' ); ?></dt>
						<dd>1:10 (e.g. 17g coffee / 170ml water)</dd>
						<dt><?php esc_html_e( 'Total Brew Time', 'ember-oak' ); ?></dt>
						<dd>1.5&ndash;2 minutes</dd>
					</dl>
					<p class="brew-tip"><?php esc_html_e( 'Use the inverted method for better control. Stir once at 30 seconds, then press steadily for 20&ndash;30 seconds.', 'ember-oak' ); ?></p>
				</div><!-- #tab-aeropress -->

				<div id="tab-espresso" class="tab-panel" role="tabpanel" hidden>
					<h3><?php esc_html_e( 'Espresso', 'ember-oak' ); ?></h3>
					<dl class="brew-specs">
						<dt><?php esc_html_e( 'Water Temperature', 'ember-oak' ); ?></dt>
						<dd>90&ndash;96&deg;C / 194&ndash;205&deg;F</dd>
						<dt><?php esc_html_e( 'Grind Size', 'ember-oak' ); ?></dt>
						<dd><?php esc_html_e( 'Fine', 'ember-oak' ); ?></dd>
						<dt><?php esc_html_e( 'Coffee-to-Water Ratio', 'ember-oak' ); ?></dt>
						<dd>1:2 (e.g. 18g in / 36g out)</dd>
						<dt><?php esc_html_e( 'Total Brew Time', 'ember-oak' ); ?></dt>
						<dd>25&ndash;30 seconds</dd>
					</dl>
					<p class="brew-tip"><?php esc_html_e( 'Dial in your grind until the shot runs blond at around 25 seconds. Tamp with even, level pressure of approximately 15kg.', 'ember-oak' ); ?></p>
				</div><!-- #tab-espresso -->

			</div><!-- .tab-panels -->
		</div><!-- .brew-tabs -->
	</section><!-- .brew-guides -->

	<!-- Related Blends -->
	<?php
	$related_args = array(
		'post_type'      => 'ember_blend',
		'posts_per_page' => 3,
		'post__not_in'   => array( get_the_ID() ),
		'orderby'        => 'rand',
	);
	$related_query = new WP_Query( $related_args );

	if ( $related_query->have_posts() ) :
	?>
		<section class="related-blends">
			<h2 class="section-heading"><?php esc_html_e( 'You Might Also Like', 'ember-oak' ); ?></h2>
			<div class="related-blends-grid">
				<?php while ( $related_query->have_posts() ) : $related_query->the_post();
					$related_meta = ember_oak_get_blend_meta( get_the_ID() );
				?>
					<article class="related-blend-card">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" class="related-blend-thumb" tabindex="-1" aria-hidden="true">
								<?php the_post_thumbnail( 'medium', array( 'alt' => get_the_title() ) ); ?>
							</a>
						<?php endif; ?>
						<div class="related-blend-info">
							<?php if ( ! empty( $related_meta['roast_level'] ) ) : ?>
								<span class="roast-badge roast-<?php echo esc_attr( sanitize_title( $related_meta['roast_level'] ) ); ?>">
									<?php echo esc_html( $related_meta['roast_level'] ); ?>
								</span>
							<?php endif; ?>
							<h3 class="related-blend-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>
							<?php if ( ! empty( $related_meta['price'] ) ) : ?>
								<span class="related-blend-price">$<?php echo esc_html( $related_meta['price'] ); ?></span>
							<?php endif; ?>
						</div>
					</article>
				<?php endwhile; ?>
			</div><!-- .related-blends-grid -->
		</section><!-- .related-blends -->
	<?php
	endif;
	wp_reset_postdata();
	?>

</article><!-- .blend-single -->
