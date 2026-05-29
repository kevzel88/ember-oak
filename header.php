<?php
/**
 * The header for the Ember & Oak theme.
 *
 * @package Ember_Oak
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main">
		<?php esc_html_e( 'Skip to content', 'ember-oak' ); ?>
	</a>

	<?php
	$top_bar_phone = get_theme_mod( 'ember_oak_top_bar_phone', '' );
	$top_bar_email = get_theme_mod( 'ember_oak_top_bar_email', '' );

	if ( $top_bar_phone || $top_bar_email ) : ?>
	<div class="top-bar" role="complementary" aria-label="<?php esc_attr_e( 'Contact information', 'ember-oak' ); ?>">
		<div class="top-bar__inner">
			<?php if ( $top_bar_phone ) : ?>
				<span class="top-bar__item top-bar__phone">
					<a href="tel:<?php echo esc_attr( preg_replace( '/[^+\d]/', '', $top_bar_phone ) ); ?>">
						<span class="screen-reader-text"><?php esc_html_e( 'Phone:', 'ember-oak' ); ?></span>
						<?php echo esc_html( $top_bar_phone ); ?>
					</a>
				</span>
			<?php endif; ?>
			<?php if ( $top_bar_email ) : ?>
				<span class="top-bar__item top-bar__email">
					<a href="mailto:<?php echo esc_attr( antispambot( $top_bar_email ) ); ?>">
						<span class="screen-reader-text"><?php esc_html_e( 'Email:', 'ember-oak' ); ?></span>
						<?php echo esc_html( $top_bar_email ); ?>
					</a>
				</span>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-header__inner">

			<div class="site-branding">
				<?php
				if ( has_custom_logo() ) :
					the_custom_logo();
				else :
					if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<?php bloginfo( 'name' ); ?>
							</a>
						</h1>
					<?php else : ?>
						<p class="site-title">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<?php bloginfo( 'name' ); ?>
							</a>
						</p>
					<?php endif;

					$ember_oak_description = get_bloginfo( 'description', 'display' );
					if ( $ember_oak_description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo esc_html( $ember_oak_description ); ?></p>
					<?php endif;
				endif; ?>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'ember-oak' ); ?>">
				<button
					id="menu-toggle"
					class="menu-toggle"
					aria-expanded="false"
					aria-controls="primary-menu"
					aria-label="<?php esc_attr_e( 'Toggle navigation menu', 'ember-oak' ); ?>"
				>
					<span class="menu-toggle__icon" aria-hidden="true">
						<span class="menu-toggle__bar"></span>
						<span class="menu-toggle__bar"></span>
						<span class="menu-toggle__bar"></span>
					</span>
					<span class="menu-toggle__label"><?php esc_html_e( 'Menu', 'ember-oak' ); ?></span>
				</button>

				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'menu_id'         => 'primary-menu',
						'menu_class'      => 'primary-menu',
						'container'       => false,
						'walker'          => class_exists( 'EmberOakNavWalker' ) ? new EmberOakNavWalker() : null,
						'fallback_cb'     => function() {
							printf(
								'<ul id="primary-menu" class="primary-menu"><li><a href="%s">%s</a></li></ul>',
								esc_url( admin_url( 'nav-menus.php' ) ),
								esc_html__( 'Add a menu', 'ember-oak' )
							);
						},
					)
				);
				?>
			</nav><!-- #site-navigation -->

		</div><!-- .site-header__inner -->
	</header><!-- #masthead -->

	<main id="main" class="site-main" role="main">
