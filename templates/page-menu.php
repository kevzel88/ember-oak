<?php
/**
 * Template Name: Coffee Menu
 *
 * Displays the full Ember & Oak coffee menu with filterable blend cards.
 *
 * @package Ember_Oak
 */

get_header();
?>

<main id="main-content" class="site-main page-menu">

    <!-- Page Hero -->
    <section class="page-hero page-hero--menu">
        <div class="container">
            <h1 class="page-hero__title">Our Coffee</h1>
            <?php
            $page_description = get_the_excerpt();
            if ( $page_description ) : ?>
                <p class="page-hero__description"><?php echo wp_kses_post( $page_description ); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Roast Filter Tabs -->
    <section class="menu-filter-section">
        <div class="container">
            <div class="roast-filter" role="tablist" aria-label="<?php esc_attr_e( 'Filter coffee by roast level', 'ember-oak' ); ?>">
                <button
                    class="roast-filter__btn roast-filter__btn--active"
                    data-filter="all"
                    role="tab"
                    aria-selected="true"
                    aria-controls="blends-grid"
                >
                    <?php esc_html_e( 'All', 'ember-oak' ); ?>
                </button>
                <button
                    class="roast-filter__btn"
                    data-filter="light"
                    role="tab"
                    aria-selected="false"
                    aria-controls="blends-grid"
                >
                    <?php esc_html_e( 'Light Roast', 'ember-oak' ); ?>
                </button>
                <button
                    class="roast-filter__btn"
                    data-filter="medium"
                    role="tab"
                    aria-selected="false"
                    aria-controls="blends-grid"
                >
                    <?php esc_html_e( 'Medium Roast', 'ember-oak' ); ?>
                </button>
                <button
                    class="roast-filter__btn"
                    data-filter="dark"
                    role="tab"
                    aria-selected="false"
                    aria-controls="blends-grid"
                >
                    <?php esc_html_e( 'Dark Roast', 'ember-oak' ); ?>
                </button>
                <button
                    class="roast-filter__btn"
                    data-filter="espresso"
                    role="tab"
                    aria-selected="false"
                    aria-controls="blends-grid"
                >
                    <?php esc_html_e( 'Espresso', 'ember-oak' ); ?>
                </button>
            </div>
        </div>
    </section>

    <!-- Blends Grid -->
    <section class="menu-blends-section">
        <div class="container">

            <?php
            $blends_query = new WP_Query( array(
                'post_type'      => 'ember_blend',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
            ) );

            if ( $blends_query->have_posts() ) : ?>

                <div class="blends-grid" id="blends-grid">

                    <?php while ( $blends_query->have_posts() ) : $blends_query->the_post();

                        $meta = ember_oak_get_blend_meta( get_the_ID() );

                        $roast_level    = ! empty( $meta['roast_level'] )    ? $meta['roast_level']    : '';
                        $origin         = ! empty( $meta['origin'] )         ? $meta['origin']         : '';
                        $tasting_notes  = ! empty( $meta['tasting_notes'] )  ? $meta['tasting_notes']  : '';
                        $price          = ! empty( $meta['price'] )          ? $meta['price']          : '';
                        $price_unit     = ! empty( $meta['price_unit'] )     ? $meta['price_unit']     : '';
                    ?>

                    <article
                        id="blend-<?php the_ID(); ?>"
                        class="blend-card<?php echo $roast_level ? ' blend-card--' . esc_attr( $roast_level ) : ''; ?>"
                        data-roast="<?php echo esc_attr( $roast_level ); ?>"
                    >

                        <!-- Blend Thumbnail -->
                        <div class="blend-card__thumbnail">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                                    <?php
                                    the_post_thumbnail(
                                        'ember-oak-card',
                                        array(
                                            'class' => 'blend-card__image',
                                            'alt'   => the_title_attribute( array( 'echo' => false ) ),
                                        )
                                    );
                                    ?>
                                </a>
                            <?php else : ?>
                                <div class="blend-card__image-placeholder" aria-hidden="true">
                                    <span class="blend-card__image-placeholder-icon"></span>
                                </div>
                            <?php endif; ?>
                        </div><!-- .blend-card__thumbnail -->

                        <!-- Blend Card Body -->
                        <div class="blend-card-body">

                            <!-- Title -->
                            <h3 class="blend-card-body__title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <!-- Badges -->
                            <div class="blend-card-body__badges">
                                <?php if ( $origin ) : ?>
                                    <span class="blend-badge blend-badge--origin">
                                        <?php echo esc_html( $origin ); ?>
                                    </span>
                                <?php endif; ?>

                                <?php if ( $roast_level && function_exists( 'ember_oak_roast_level_label' ) ) : ?>
                                    <span class="blend-badge blend-badge--roast blend-badge--roast-<?php echo esc_attr( $roast_level ); ?>">
                                        <?php echo esc_html( ember_oak_roast_level_label( $roast_level ) ); ?>
                                    </span>
                                <?php endif; ?>
                            </div><!-- .blend-card-body__badges -->

                            <!-- Tasting Notes -->
                            <?php if ( $tasting_notes ) : ?>
                                <p class="blend-card-body__tasting-notes">
                                    <?php echo wp_kses_post( $tasting_notes ); ?>
                                </p>
                            <?php endif; ?>

                            <!-- Price -->
                            <?php if ( $price ) : ?>
                                <div class="blend-card-body__price">
                                    <span class="blend-card-body__price-amount">
                                        <?php echo esc_html( '$' . number_format( (float) $price, 2 ) ); ?>
                                    </span>
                                    <?php if ( $price_unit ) : ?>
                                        <span class="blend-card-body__price-unit">
                                            <?php echo esc_html( '/ ' . $price_unit ); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Actions -->
                            <div class="blend-card-body__actions">
                                <a
                                    href="<?php the_permalink(); ?>"
                                    class="blend-card-body__link btn btn--secondary"
                                >
                                    <?php esc_html_e( 'View Blend', 'ember-oak' ); ?>
                                </a>

                                <button
                                    class="blend-card-body__add-to-bag btn btn--primary js-add-to-bag"
                                    data-blend-id="<?php echo esc_attr( get_the_ID() ); ?>"
                                    data-blend-title="<?php echo esc_attr( get_the_title() ); ?>"
                                    data-blend-price="<?php echo esc_attr( $price ); ?>"
                                    aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to bag', 'ember-oak' ), get_the_title() ) ); ?>"
                                >
                                    <?php esc_html_e( 'Add to Bag', 'ember-oak' ); ?>
                                </button>
                            </div><!-- .blend-card-body__actions -->

                        </div><!-- .blend-card-body -->

                    </article><!-- .blend-card -->

                    <?php endwhile; ?>

                </div><!-- .blends-grid -->

            <?php
            wp_reset_postdata();

            else :
                // No blends found — empty state
                wp_reset_postdata();
            ?>

                <div class="blends-empty-state">
                    <div class="blends-empty-state__inner">
                        <span class="blends-empty-state__icon" aria-hidden="true"></span>
                        <h2 class="blends-empty-state__heading">
                            <?php esc_html_e( 'No Blends Available Yet', 'ember-oak' ); ?>
                        </h2>
                        <p class="blends-empty-state__message">
                            <?php esc_html_e( "We're busy perfecting our roasts. Check back soon, or get in touch to find out what's coming to the menu.", 'ember-oak' ); ?>
                        </p>
                        <a href="/contact" class="btn btn--primary blends-empty-state__cta">
                            <?php esc_html_e( 'Contact Us', 'ember-oak' ); ?>
                        </a>
                    </div>
                </div><!-- .blends-empty-state -->

            <?php endif; ?>

        </div><!-- .container -->
    </section><!-- .menu-blends-section -->

</main><!-- #main-content -->

<?php
get_footer();
