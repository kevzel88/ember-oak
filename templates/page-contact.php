<?php
/* Template Name: Contact */

get_header();
?>

<section class="page-hero">
    <div class="container">
        <h1 class="page-hero__title">Get in Touch</h1>
    </div>
</section>

<section class="contact-section section-padding">
    <div class="container">
        <div class="contact-layout">

            <div class="contact-form-col">
                <form class="contact-form" method="post" novalidate>

                    <?php wp_nonce_field( 'ember_oak_contact' ); ?>

                    <div class="form-group">
                        <label for="contact-name"><?php esc_html_e( 'Your Name', 'ember-oak' ); ?> <span aria-hidden="true">*</span></label>
                        <input
                            type="text"
                            id="contact-name"
                            name="contact_name"
                            autocomplete="name"
                            required
                            aria-required="true"
                        >
                        <span class="field-error" aria-live="polite"></span>
                    </div>

                    <div class="form-group">
                        <label for="contact-email"><?php esc_html_e( 'Email Address', 'ember-oak' ); ?> <span aria-hidden="true">*</span></label>
                        <input
                            type="email"
                            id="contact-email"
                            name="contact_email"
                            autocomplete="email"
                            required
                            aria-required="true"
                        >
                        <span class="field-error" aria-live="polite"></span>
                    </div>

                    <div class="form-group">
                        <label for="contact-subject"><?php esc_html_e( 'Subject', 'ember-oak' ); ?></label>
                        <input
                            type="text"
                            id="contact-subject"
                            name="contact_subject"
                            autocomplete="off"
                        >
                        <span class="field-error" aria-live="polite"></span>
                    </div>

                    <div class="form-group">
                        <label for="contact-message"><?php esc_html_e( 'Message', 'ember-oak' ); ?> <span aria-hidden="true">*</span></label>
                        <textarea
                            id="contact-message"
                            name="contact_message"
                            rows="6"
                            required
                            aria-required="true"
                        ></textarea>
                        <span class="field-error" aria-live="polite"></span>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <?php esc_html_e( 'Send Message', 'ember-oak' ); ?>
                    </button>

                </form>
            </div>

            <div class="contact-info-col">

                <div class="contact-info-block">
                    <h2 class="contact-info-block__heading"><?php esc_html_e( 'Visit Us', 'ember-oak' ); ?></h2>

                    <div class="contact-info-item contact-info-item--address">
                        <span class="contact-info-item__label"><?php esc_html_e( 'Address', 'ember-oak' ); ?></span>
                        <address class="contact-info-item__value">
                            <?php echo nl2br( esc_html( get_theme_mod( 'ember_oak_address', '123 Roastery Lane, Brooklyn NY 11201' ) ) ); ?>
                        </address>
                    </div>

                    <div class="contact-info-item contact-info-item--phone">
                        <span class="contact-info-item__label"><?php esc_html_e( 'Phone', 'ember-oak' ); ?></span>
                        <span class="contact-info-item__value">
                            <a href="tel:<?php echo esc_attr( preg_replace( '/[^+\d]/', '', get_theme_mod( 'ember_oak_phone', '(718) 555-0142' ) ) ); ?>">
                                <?php echo esc_html( get_theme_mod( 'ember_oak_phone', '(718) 555-0142' ) ); ?>
                            </a>
                        </span>
                    </div>

                    <div class="contact-info-item contact-info-item--email">
                        <span class="contact-info-item__label"><?php esc_html_e( 'Email', 'ember-oak' ); ?></span>
                        <span class="contact-info-item__value">
                            <a href="mailto:<?php echo esc_attr( get_theme_mod( 'ember_oak_email', 'hello@emberandoak.com' ) ); ?>">
                                <?php echo esc_html( get_theme_mod( 'ember_oak_email', 'hello@emberandoak.com' ) ); ?>
                            </a>
                        </span>
                    </div>
                </div>

                <div class="contact-info-block">
                    <h2 class="contact-info-block__heading"><?php esc_html_e( 'Hours', 'ember-oak' ); ?></h2>

                    <div class="contact-info-item contact-info-item--hours">
                        <span class="contact-info-item__value">
                            <?php echo esc_html( get_theme_mod( 'ember_oak_hours_weekday', 'Mon–Fri: 7am–6pm' ) ); ?>
                        </span>
                    </div>

                    <div class="contact-info-item contact-info-item--hours">
                        <span class="contact-info-item__value">
                            <?php echo esc_html( get_theme_mod( 'ember_oak_hours_weekend', 'Sat–Sun: 8am–5pm' ) ); ?>
                        </span>
                    </div>
                </div>

                <div class="map-placeholder" style="height:300px;background-color:#e5e5e5;display:flex;align-items:center;justify-content:center;">
                    <span><?php esc_html_e( 'Find Us on Google Maps', 'ember-oak' ); ?></span>
                </div>

            </div>

        </div>
    </div>
</section>

<section class="faq-section section-padding">
    <div class="container">
        <h2 class="faq-section__heading"><?php esc_html_e( 'Frequently Asked Questions', 'ember-oak' ); ?></h2>

        <div class="faq-accordion">

            <details class="faq-item">
                <summary class="faq-item__question">
                    <?php esc_html_e( 'Do you ship internationally?', 'ember-oak' ); ?>
                </summary>
                <div class="faq-item__answer">
                    <p><?php esc_html_e( 'Currently we ship within the US only. We offer free shipping on all orders over $50.', 'ember-oak' ); ?></p>
                </div>
            </details>

            <details class="faq-item">
                <summary class="faq-item__question">
                    <?php esc_html_e( 'Can I visit the roastery?', 'ember-oak' ); ?>
                </summary>
                <div class="faq-item__answer">
                    <p><?php esc_html_e( 'Yes! We welcome visitors. Roastery tours are available every Saturday from 10am to 2pm. No reservation required.', 'ember-oak' ); ?></p>
                </div>
            </details>

            <details class="faq-item">
                <summary class="faq-item__question">
                    <?php esc_html_e( 'Do you offer wholesale?', 'ember-oak' ); ?>
                </summary>
                <div class="faq-item__answer">
                    <p><?php esc_html_e( 'Yes, we work with cafes, restaurants, and retailers. Please contact us using the form above for wholesale pricing and availability.', 'ember-oak' ); ?></p>
                </div>
            </details>

        </div>
    </div>
</section>

<?php get_footer(); ?>
