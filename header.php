<?php
/**
 * Header — Ember & Oak
 * @package EmberOak
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">

<a class="sr-only" href="#main"><?php esc_html_e('Skip to content','ember-oak'); ?></a>

<header id="masthead" class="site-header">
  <div class="site-header__inner">

    <div class="site-branding">
      <?php if ( has_custom_logo() ) : ?>
        <?php the_custom_logo(); ?>
      <?php else : ?>
        <?php if ( is_front_page() ) : ?>
          <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
        <?php else : ?>
          <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
        <?php endif; ?>
      <?php endif; ?>
    </div>

    <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e('Primary','ember-oak'); ?>">
      <button id="menu-toggle" class="menu-toggle" aria-expanded="false" aria-controls="primary-menu">
        <span class="menu-toggle__bar"></span>
        <span class="menu-toggle__bar"></span>
        <span class="menu-toggle__bar"></span>
        <span class="sr-only"><?php esc_html_e('Menu','ember-oak'); ?></span>
      </button>
      <?php wp_nav_menu([
        'theme_location' => 'primary',
        'menu_id'        => 'primary-menu',
        'menu_class'     => 'primary-menu',
        'container'      => false,
        'fallback_cb'    => function() {
          echo '<ul id="primary-menu" class="primary-menu">';
          echo '<li><a href="'.esc_url(home_url('/')).'">Home</a></li>';
          $pages = get_pages(['number'=>6]);
          foreach ($pages as $p) {
            echo '<li><a href="'.esc_url(get_permalink($p->ID)).'">'.esc_html($p->post_title).'</a></li>';
          }
          echo '</ul>';
        },
      ]); ?>
    </nav>

  </div>
</header>

<main id="main" class="site-main">
