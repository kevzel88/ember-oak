<?php
/**
 * Front Page — Ember & Oak
 * @package EmberOak
 */
get_header();

$hero_heading    = get_theme_mod('hero_heading',    'Small-Batch Coffee, Big Soul');
$hero_subheading = get_theme_mod('hero_subheading', 'Roasted in small batches in our Brooklyn workshop since 2018.');
$hero_cta_text   = get_theme_mod('hero_cta_text',   'Shop Our Blends');
$hero_cta_url    = get_theme_mod('hero_cta_url',    get_post_type_archive_link('ember_blend') ?: home_url('/blends/'));
?>

<!-- ===== HERO ===== -->
<section class="hero">
  <div class="container">
    <div class="hero__content">
      <span class="hero__eyebrow">Brooklyn, New York · Est. 2018</span>
      <h1><?php echo esc_html($hero_heading); ?></h1>
      <p class="hero__sub"><?php echo esc_html($hero_subheading); ?></p>
      <div class="hero__actions">
        <a href="<?php echo esc_url($hero_cta_url); ?>" class="btn btn-primary btn-lg"><?php echo esc_html($hero_cta_text); ?></a>
        <a href="<?php echo esc_url(get_post_type_archive_link('ember_event') ?: home_url('/events/')); ?>" class="btn btn-ghost btn-lg"><?php esc_html_e('Upcoming Events','ember-oak'); ?></a>
      </div>
    </div>
  </div>
  <div class="hero__scroll">&#8595; Scroll</div>
</section>

<!-- ===== INTRO / STATS ===== -->
<section class="intro-section">
  <div class="container">
    <div class="intro-text">
      <div class="intro-eyebrow">Est. 2018</div>
      <h2><?php esc_html_e('Coffee worth slowing down for','ember-oak'); ?></h2>
      <p><?php esc_html_e('We started Ember & Oak in a rented corner of a Bushwick warehouse with one second-hand roaster and a mailing list of 40 friends. Eight years later we\'re still in Brooklyn, still roasting in small batches, still adjusting every week.','ember-oak'); ?></p>
      <p><?php esc_html_e('Every bag ships within 48 hours of roast. Every origin is traceable. Every cup is worth the moment you take to drink it.','ember-oak'); ?></p>
      <a href="<?php echo esc_url(home_url('/about-us/')); ?>" class="btn btn-secondary" style="margin-top:1.5rem;"><?php esc_html_e('Our Story','ember-oak'); ?></a>
    </div>
    <div class="stats-grid">
      <div class="stat-item" data-animate>
        <span class="stat-number">12+</span>
        <div class="stat-label"><?php esc_html_e('Origins Sourced','ember-oak'); ?></div>
      </div>
      <div class="stat-item" data-animate>
        <span class="stat-number">4</span>
        <div class="stat-label"><?php esc_html_e('Roast Profiles','ember-oak'); ?></div>
      </div>
      <div class="stat-item" data-animate>
        <span class="stat-number">2×</span>
        <div class="stat-label"><?php esc_html_e('Weekly Roast','ember-oak'); ?></div>
      </div>
      <div class="stat-item" data-animate>
        <span class="stat-number">$50</span>
        <div class="stat-label"><?php esc_html_e('Free Shipping Over','ember-oak'); ?></div>
      </div>
    </div>
  </div>
</section>

<!-- ===== FEATURED BLENDS ===== -->
<section class="featured-blends section">
  <div class="container">
    <div class="section-header">
      <h2><?php esc_html_e('Our Signature Blends','ember-oak'); ?></h2>
      <p><?php esc_html_e('Each roasted to order and shipped within 48 hours.','ember-oak'); ?></p>
    </div>

    <?php
    $blends = new WP_Query([
      'post_type'      => 'ember_blend',
      'posts_per_page' => 3,
      'post_status'    => 'publish',
    ]);
    $roast_colors = [
      'light'   => 'light',
      'medium'  => 'medium',
      'dark'    => 'dark',
      'espresso'=> 'espresso',
    ];
    $roast_labels = [
      'light'    => 'Light Roast',
      'medium'   => 'Medium Roast',
      'dark'     => 'Dark Roast',
      'espresso' => 'Espresso',
    ];
    if ($blends->have_posts()) : ?>
      <div class="blends-grid">
        <?php while ($blends->have_posts()) : $blends->the_post();
          $id    = get_the_ID();
          $roast = get_post_meta($id,'roast_level',true);
          $notes = get_post_meta($id,'tasting_notes',true);
          $price = get_post_meta($id,'price',true);
          $level = $roast_labels[$roast] ?? ucfirst($roast);
        ?>
        <article class="blend-card" data-animate>
          <div class="blend-card__image">
            <?php if (has_post_thumbnail()) : ?>
              <?php the_post_thumbnail('ember-oak-card'); ?>
            <?php else : ?>
              <div class="blend-card__placeholder">☕</div>
            <?php endif; ?>
          </div>
          <div class="blend-card__body">
            <div class="blend-card__meta">
              <?php if ($roast) : ?>
                <span class="roast-badge roast-badge--<?php echo esc_attr($roast); ?>"><?php echo esc_html($level); ?></span>
              <?php endif; ?>
            </div>
            <h3><?php the_title(); ?></h3>
            <?php if ($notes) : ?>
              <p class="blend-card__notes"><?php echo esc_html($notes); ?></p>
            <?php else : ?>
              <p class="blend-card__notes"><?php echo wp_trim_words(get_the_excerpt(),12); ?></p>
            <?php endif; ?>
            <div class="blend-card__footer">
              <?php if ($price) : ?>
                <span class="blend-price">$<?php echo esc_html($price); ?></span>
              <?php endif; ?>
              <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-primary"><?php esc_html_e('View Blend','ember-oak'); ?></a>
            </div>
          </div>
        </article>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    <?php else : ?>
      <p style="text-align:center;color:var(--color-mist);"><?php esc_html_e('No blends yet — check back soon!','ember-oak'); ?></p>
    <?php endif; ?>

    <div style="text-align:center;margin-top:2.5rem;">
      <a href="<?php echo esc_url(get_post_type_archive_link('ember_blend') ?: home_url('/blends/')); ?>" class="btn btn-secondary">
        <?php esc_html_e('View All Blends','ember-oak'); ?>
      </a>
    </div>
  </div>
</section>

<!-- ===== PROCESS ===== -->
<section class="process-section">
  <div class="container">
    <div class="section-header">
      <h2><?php esc_html_e('From Origin to Your Cup','ember-oak'); ?></h2>
      <p><?php esc_html_e('Every bag tells the story of a careful four-step journey.','ember-oak'); ?></p>
    </div>
    <div class="process-grid">
      <div class="process-step" data-animate>
        <div class="process-step__number">01</div>
        <div class="process-step__icon">🌱</div>
        <h3><?php esc_html_e('Source','ember-oak'); ?></h3>
        <p><?php esc_html_e('We build direct relationships with smallholder farmers across Ethiopia, Colombia, Guatemala, and Brazil.','ember-oak'); ?></p>
      </div>
      <div class="process-step" data-animate>
        <div class="process-step__number">02</div>
        <div class="process-step__icon">🔥</div>
        <h3><?php esc_html_e('Roast','ember-oak'); ?></h3>
        <p><?php esc_html_e('Small batches on our Probat roaster, twice weekly. Every profile dialed in by hand, never automated.','ember-oak'); ?></p>
      </div>
      <div class="process-step" data-animate>
        <div class="process-step__number">03</div>
        <div class="process-step__icon">📦</div>
        <h3><?php esc_html_e('Package','ember-oak'); ?></h3>
        <p><?php esc_html_e('Sealed within hours of roasting in compostable bags with one-way degassing valves.','ember-oak'); ?></p>
      </div>
      <div class="process-step" data-animate>
        <div class="process-step__number">04</div>
        <div class="process-step__icon">🚚</div>
        <h3><?php esc_html_e('Ship','ember-oak'); ?></h3>
        <p><?php esc_html_e('Dispatched Tuesday and Thursday. Arrives at your door within days of the roast date.','ember-oak'); ?></p>
      </div>
    </div>
  </div>
</section>

<!-- ===== EVENTS ===== -->
<section class="events-preview section section--cream">
  <div class="container">
    <div class="section-header">
      <h2><?php esc_html_e('Upcoming Events','ember-oak'); ?></h2>
      <p><?php esc_html_e('Tastings, brewing workshops, and origin education nights at The Roastery.','ember-oak'); ?></p>
    </div>

    <?php
    $today  = date('Y-m-d');
    $events = new WP_Query([
      'post_type'      => 'ember_event',
      'posts_per_page' => 2,
      'post_status'    => 'publish',
      'meta_key'       => 'event_date',
      'orderby'        => 'meta_value',
      'order'          => 'ASC',
      'meta_query'     => [[
        'key'     => 'event_date',
        'value'   => $today,
        'compare' => '>=',
        'type'    => 'DATE',
      ]],
    ]);
    if ($events->have_posts()) : ?>
      <div class="events-grid">
        <?php while ($events->have_posts()) : $events->the_post();
          $eid   = get_the_ID();
          $edate = get_post_meta($eid,'event_date',true);
          $etime = get_post_meta($eid,'event_time',true);
          $eloc  = get_post_meta($eid,'event_location',true);
          $eprice= get_post_meta($eid,'event_price',true);
          $formatted = $edate ? date('F j, Y', strtotime($edate)) : '';
        ?>
        <div class="event-card" data-animate>
          <?php if ($formatted) : ?>
            <div class="event-card__date"><?php echo esc_html($formatted); ?><?php if ($etime) echo ' · '.esc_html($etime); ?></div>
          <?php endif; ?>
          <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          <div class="event-card__meta">
            <?php if ($eloc)  : ?><span>📍 <?php echo esc_html($eloc); ?></span><?php endif; ?>
            <?php if ($eprice): ?><span class="event-card__price"><?php echo esc_html($eprice); ?></span><?php endif; ?>
          </div>
          <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-secondary"><?php esc_html_e('Learn More','ember-oak'); ?></a>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    <?php else : ?>
      <div class="events-grid">
        <div class="event-card">
          <div class="event-card__date">July 15, 2026 · 6:00 PM</div>
          <h3>Introduction to Home Brewing</h3>
          <div class="event-card__meta">
            <span>📍 The Roastery, Brooklyn NY</span>
            <span class="event-card__price">$45 per person</span>
          </div>
          <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-sm btn-secondary">RSVP</a>
        </div>
        <div class="event-card">
          <div class="event-card__date">August 20, 2026 · 7:00 PM</div>
          <h3>Origin Trip: Ethiopia</h3>
          <div class="event-card__meta">
            <span>📍 The Roastery, Brooklyn NY</span>
            <span class="event-card__price">$35 per person</span>
          </div>
          <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-sm btn-secondary">RSVP</a>
        </div>
      </div>
    <?php endif; ?>

    <div style="text-align:center;margin-top:2.5rem;">
      <a href="<?php echo esc_url(get_post_type_archive_link('ember_event') ?: home_url('/events/')); ?>" class="btn btn-secondary">
        <?php esc_html_e('All Events','ember-oak'); ?>
      </a>
    </div>
  </div>
</section>

<!-- ===== TESTIMONIALS ===== -->
<section class="testimonials-section section">
  <div class="container">
    <div class="section-header">
      <h2><?php esc_html_e('What People Are Saying','ember-oak'); ?></h2>
    </div>
    <div class="testimonials-grid">
      <div class="testimonial-card" data-animate>
        <div class="testimonial-stars">★★★★★</div>
        <p class="testimonial-quote">"The Morning Light Ethiopian changed how I think about light roasts. I used to be a dark-roast person. Not anymore."</p>
        <div class="testimonial-author"><strong>Sarah K.</strong><span>Fort Greene, Brooklyn</span></div>
      </div>
      <div class="testimonial-card" data-animate>
        <div class="testimonial-stars">★★★★★</div>
        <p class="testimonial-quote">"I've ordered six times now and every bag arrives within two days of the roast date. Freshest coffee I've ever had delivered."</p>
        <div class="testimonial-author"><strong>Marcus T.</strong><span>Astoria, Queens</span></div>
      </div>
      <div class="testimonial-card" data-animate>
        <div class="testimonial-stars">★★★★★</div>
        <p class="testimonial-quote">"Attended the home brewing workshop. James is an incredible teacher — practical, patient, and clearly obsessed with coffee."</p>
        <div class="testimonial-author"><strong>Priya N.</strong><span>Williamsburg, Brooklyn</span></div>
      </div>
    </div>
  </div>
</section>

<!-- ===== CTA BANNER ===== -->
<section class="cta-banner">
  <div class="container">
    <h2><?php esc_html_e('Ready to discover your perfect roast?','ember-oak'); ?></h2>
    <p><?php esc_html_e('Browse our current selection of single-origin coffees and house blends. Free shipping on orders over $50.','ember-oak'); ?></p>
    <div class="cta-banner__actions">
      <a href="<?php echo esc_url(get_post_type_archive_link('ember_blend') ?: home_url('/blends/')); ?>" class="btn btn-primary btn-lg">
        <?php esc_html_e('Shop Coffee','ember-oak'); ?>
      </a>
      <a href="<?php echo esc_url(home_url('/about-us/')); ?>" class="btn btn-ghost btn-lg">
        <?php esc_html_e('Our Story','ember-oak'); ?>
      </a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
