<?php
/**
 * Template part for displaying a message when no posts are found.
 *
 * @package Ember_Oak
 */
?>
<div class="no-content">
  <h2><?php esc_html_e('Nothing Found','ember-oak'); ?></h2>
  <p><?php esc_html_e('Looks like this roast went missing. Try a search.','ember-oak'); ?></p>
  <?php get_search_form(); ?>
</div>
