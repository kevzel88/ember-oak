<?php /* Template Name: About Us */ ?>
<?php get_header(); ?>

<main id="main-content" class="about-page">

    <!-- =====================
         1. HERO SECTION
    ===================== -->
    <section class="page-hero" <?php if ( has_post_thumbnail() ) : ?>style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');"<?php endif; ?>>
        <div class="page-hero__overlay"></div>
        <div class="page-hero__inner container">
            <h1 class="page-hero__title">Our Story</h1>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <ol class="breadcrumb__list">
                    <li class="breadcrumb__item">
                        <a class="breadcrumb__link" href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
                    </li>
                    <li class="breadcrumb__separator" aria-hidden="true">/</li>
                    <li class="breadcrumb__item breadcrumb__item--current" aria-current="page">
                        <?php the_title(); ?>
                    </li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- =====================
         2. MISSION STATEMENT
    ===================== -->
    <section class="mission-section">
        <div class="container">
            <blockquote class="mission-section__quote">
                <p class="mission-section__quote-text">&#8220;We believe great coffee starts with great relationships.&#8221;</p>
                <footer class="mission-section__quote-footer">
                    <cite class="mission-section__cite">Ember &amp; Oak Coffee Co.</cite>
                </footer>
            </blockquote>
        </div>
    </section>

    <!-- =====================
         3. OUR STORY
    ===================== -->
    <section class="our-story">
        <div class="container">
            <div class="our-story__inner">

                <div class="our-story__content">
                    <h2 class="our-story__heading">How It All Began</h2>
                    <p class="our-story__body">
                        Ember &amp; Oak was born in the winter of 2016 out of a shared obsession with two things: exceptional coffee and the neighborhoods that make cities feel alive. Co-founders Priya Chen and Marcus Reid met at a specialty coffee tasting in Williamsburg, Brooklyn, and quickly discovered they had more in common than a love of single-origin pour-overs. They both believed that the third-wave coffee movement had drifted too far from the communities it served.
                    </p>
                    <p class="our-story__body">
                        In early 2017, they signed a lease on a narrow, sun-drenched space on Franklin Avenue in Crown Heights. Marcus transformed a salvaged brick wall into the backdrop for a custom La Marzocco espresso bar, while Priya negotiated direct-trade contracts with small-lot farmers in Ethiopia, Colombia, and Guatemala. From the very first week, the shop became a gathering point &#8212; for remote workers, local parents, weekend cyclists, and anyone else drawn in by the scent of freshly roasted beans drifting down the block.
                    </p>
                    <p class="our-story__body">
                        Today, Ember &amp; Oak operates three Brooklyn locations, a small-batch roastery in Bushwick, and a nationwide subscription program that ships to over 4,000 households each month. Through every expansion, we have held fast to the founding principle that sourced with care, roasted with precision, and served with warmth, coffee has the power to slow the day down and bring people together.
                    </p>
                </div>

                <div class="our-story__media">
                    <div class="story-image" role="img" aria-label="Inside the Ember and Oak roastery" style="aspect-ratio: 4 / 5; background-color: #d6cfc7; border-radius: 4px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                        <?php
                        $story_image_id = get_theme_mod( 'about_story_image' );
                        if ( $story_image_id ) :
                            echo wp_get_attachment_image( $story_image_id, 'large', false, array( 'class' => 'story-image__img', 'style' => 'width:100%;height:100%;object-fit:cover;' ) );
                        else : ?>
                        <span class="story-image__placeholder" style="color:#9a8c82;font-size:0.85rem;letter-spacing:0.06em;text-transform:uppercase;">Roastery Photo</span>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- =====================
         4. MEET THE TEAM
    ===================== -->
    <section class="team-section">
        <div class="container">
            <header class="team-section__header">
                <h2 class="team-section__heading">Meet the Team</h2>
                <p class="team-section__subheading">The people behind every cup.</p>
            </header>

            <ul class="team-grid" role="list">

                <li class="team-member">
                    <div class="team-avatar" aria-hidden="true" style="width:120px;height:120px;border-radius:50%;background-color:#c9b99a;margin:0 auto 1.25rem;display:flex;align-items:center;justify-content:center;">
                        <span style="color:#6b5744;font-size:2rem;font-weight:700;line-height:1;">MR</span>
                    </div>
                    <h3 class="team-member__name">Marcus Reid</h3>
                    <p class="team-member__role">Head Roaster</p>
                    <p class="team-member__bio">10 years in specialty coffee, trained in Copenhagen and S&#227;o Paulo.</p>
                </li>

                <li class="team-member">
                    <div class="team-avatar" aria-hidden="true" style="width:120px;height:120px;border-radius:50%;background-color:#b5c4b1;margin:0 auto 1.25rem;display:flex;align-items:center;justify-content:center;">
                        <span style="color:#3a5240;font-size:2rem;font-weight:700;line-height:1;">PC</span>
                    </div>
                    <h3 class="team-member__name">Priya Chen</h3>
                    <p class="team-member__role">Co-Founder &amp; CEO</p>
                    <p class="team-member__bio">Former tech founder who swapped Silicon Valley for Brooklyn roastery.</p>
                </li>

                <li class="team-member">
                    <div class="team-avatar" aria-hidden="true" style="width:120px;height:120px;border-radius:50%;background-color:#b8c4d0;margin:0 auto 1.25rem;display:flex;align-items:center;justify-content:center;">
                        <span style="color:#2c3e50;font-size:2rem;font-weight:700;line-height:1;">JO</span>
                    </div>
                    <h3 class="team-member__name">James O&#8217;Sullivan</h3>
                    <p class="team-member__role">Barista &amp; Trainer</p>
                    <p class="team-member__bio">SCA-certified, passionate about teaching home brewing technique.</p>
                </li>

            </ul>
        </div>
    </section>

    <!-- =====================
         5. VALUES
    ===================== -->
    <section class="values-section">
        <div class="container">
            <header class="values-section__header">
                <h2 class="values-section__heading">What We Stand For</h2>
            </header>

            <ul class="values-grid" role="list">

                <li class="value-card">
                    <div class="value-card__icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48" height="48" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M24 4C12.95 4 4 12.95 4 24s8.95 20 20 20 20-8.95 20-20S35.05 4 24 4z"/>
                            <path d="M16 24c0-4.42 3.58-8 8-8s8 3.58 8 8-3.58 8-8 8"/>
                            <path d="M24 16v-4M24 36v-4M16 24h-4M36 24h-4"/>
                        </svg>
                    </div>
                    <h3 class="value-card__title">Sustainability</h3>
                    <p class="value-card__description">We source from farms committed to regenerative agriculture, use compostable packaging, and offset 100% of our shipping emissions.</p>
                </li>

                <li class="value-card">
                    <div class="value-card__icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48" height="48" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="24,4 29.5,17 44,18.5 33.5,28 37,42 24,34.5 11,42 14.5,28 4,18.5 18.5,17"/>
                        </svg>
                    </div>
                    <h3 class="value-card__title">Quality</h3>
                    <p class="value-card__description">Every lot is cupped, scored, and approved before it reaches our roaster. We reject anything that does not meet our rigorous sensory standards.</p>
                </li>

                <li class="value-card">
                    <div class="value-card__icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48" height="48" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="16" cy="16" r="6"/>
                            <circle cx="32" cy="16" r="6"/>
                            <circle cx="24" cy="30" r="6"/>
                            <line x1="21.8" y1="20.6" x2="18.2" y2="25.4"/>
                            <line x1="26.2" y1="20.6" x2="29.8" y2="25.4"/>
                            <line x1="20" y1="16" x2="28" y2="16"/>
                        </svg>
                    </div>
                    <h3 class="value-card__title">Community</h3>
                    <p class="value-card__description">Our shops are designed to be living rooms for the block &#8212; places where artists, organizers, and neighbours find common ground over a shared cup.</p>
                </li>

                <li class="value-card">
                    <div class="value-card__icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48" height="48" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 38l6-6"/>
                            <path d="M16 14l18 18"/>
                            <path d="M30 10l8 8-4 4-8-8z"/>
                            <path d="M10 38l4-4 8 8-4 4z"/>
                            <circle cx="20" cy="28" r="2"/>
                        </svg>
                    </div>
                    <h3 class="value-card__title">Craft</h3>
                    <p class="value-card__description">Roasting is both science and art. We dial in every profile by hand, chasing the exact moment when heat transforms green bean into something extraordinary.</p>
                </li>

            </ul>
        </div>
    </section>

    <!-- =====================
         6. PRESS LOGOS
    ===================== -->
    <section class="press-section">
        <div class="container">
            <h2 class="press-section__heading">As Seen In</h2>
            <ul class="press-logos" role="list">

                <li class="press-logo">
                    <div class="press-logo__inner" aria-label="The New York Times">
                        <span class="press-logo__name">The New York Times</span>
                    </div>
                </li>

                <li class="press-logo">
                    <div class="press-logo__inner" aria-label="Eater">
                        <span class="press-logo__name">Eater</span>
                    </div>
                </li>

                <li class="press-logo">
                    <div class="press-logo__inner" aria-label="Bon Appétit">
                        <span class="press-logo__name">Bon App&#233;tit</span>
                    </div>
                </li>

                <li class="press-logo">
                    <div class="press-logo__inner" aria-label="Sprudge">
                        <span class="press-logo__name">Sprudge</span>
                    </div>
                </li>

                <li class="press-logo">
                    <div class="press-logo__inner" aria-label="Food52">
                        <span class="press-logo__name">Food52</span>
                    </div>
                </li>

                <li class="press-logo">
                    <div class="press-logo__inner" aria-label="Time Out New York">
                        <span class="press-logo__name">Time Out NY</span>
                    </div>
                </li>

            </ul>
        </div>
    </section>

</main>

<?php get_footer(); ?>
