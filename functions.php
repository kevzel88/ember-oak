<?php
/**
 * Ember & Oak Theme Functions
 *
 * @package EmberOak
 * @text-domain ember-oak
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ---------------------------------------------------------------------------
// 1. Theme Setup
// ---------------------------------------------------------------------------

if ( ! isset( $content_width ) ) {
	$content_width = 1200;
}

function ember_oak_setup() {
	load_theme_textdomain( 'ember-oak', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );
	add_theme_support( 'custom-logo', array(
		'width'     => 300,
		'height'    => 80,
		'flex-width' => true,
	) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'customize-selective-refresh-widgets' );

	add_image_size( 'ember-oak-hero',  1600, 900,  true );
	add_image_size( 'ember-oak-card',   800, 600,  true );
	add_image_size( 'ember-oak-thumb',  400, 400,  true );
	add_image_size( 'ember-oak-wide',  1200, 500,  true );

	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'ember-oak' ),
		'footer'  => esc_html__( 'Footer Menu',  'ember-oak' ),
		'social'  => esc_html__( 'Social Links',  'ember-oak' ),
	) );
}
add_action( 'after_setup_theme', 'ember_oak_setup' );

// ---------------------------------------------------------------------------
// 2. Enqueue Styles & Scripts
// ---------------------------------------------------------------------------

function ember_oak_scripts() {
	// Google Fonts
	$google_fonts_url = add_query_arg(
		array(
			'family'  => 'Playfair+Display:ital,wght@0,400;0,700;1,400;1,700|Inter:wght@300;400;500;600',
			'display' => 'swap',
		),
		'https://fonts.googleapis.com/css2'
	);
	wp_enqueue_style( 'ember-oak-google-fonts', $google_fonts_url, array(), null );

	// Main stylesheet (style.css in theme root)
	wp_enqueue_style( 'ember-oak-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );

	// assets/css/main.css with filemtime versioning
	$main_css_path = get_template_directory() . '/assets/css/main.css';
	$main_css_ver  = file_exists( $main_css_path ) ? filemtime( $main_css_path ) : '1.0.0';
	wp_enqueue_style( 'ember-oak-main', get_template_directory_uri() . '/assets/css/main.css', array( 'ember-oak-style' ), $main_css_ver );

	// assets/js/main.js with filemtime versioning, loaded in footer
	$main_js_path = get_template_directory() . '/assets/js/main.js';
	$main_js_ver  = file_exists( $main_js_path ) ? filemtime( $main_js_path ) : '1.0.0';
	wp_enqueue_script( 'ember-oak-main', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ), $main_js_ver, true );

	// Comment reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ember_oak_scripts' );

// ---------------------------------------------------------------------------
// 3. Custom Post Type: ember_blend (Coffee Blends)
// ---------------------------------------------------------------------------

function ember_oak_register_blend_cpt() {
	$labels = array(
		'name'                  => esc_html__( 'Coffee Blends',          'ember-oak' ),
		'singular_name'         => esc_html__( 'Coffee Blend',           'ember-oak' ),
		'menu_name'             => esc_html__( 'Coffee Blends',          'ember-oak' ),
		'name_admin_bar'        => esc_html__( 'Coffee Blend',           'ember-oak' ),
		'add_new'               => esc_html__( 'Add New',                'ember-oak' ),
		'add_new_item'          => esc_html__( 'Add New Coffee Blend',   'ember-oak' ),
		'new_item'              => esc_html__( 'New Coffee Blend',       'ember-oak' ),
		'edit_item'             => esc_html__( 'Edit Coffee Blend',      'ember-oak' ),
		'view_item'             => esc_html__( 'View Coffee Blend',      'ember-oak' ),
		'all_items'             => esc_html__( 'All Coffee Blends',      'ember-oak' ),
		'search_items'          => esc_html__( 'Search Coffee Blends',   'ember-oak' ),
		'parent_item_colon'     => esc_html__( 'Parent Coffee Blends:',  'ember-oak' ),
		'not_found'             => esc_html__( 'No coffee blends found.','ember-oak' ),
		'not_found_in_trash'    => esc_html__( 'No coffee blends found in trash.', 'ember-oak' ),
		'featured_image'        => esc_html__( 'Blend Image',            'ember-oak' ),
		'set_featured_image'    => esc_html__( 'Set blend image',        'ember-oak' ),
		'remove_featured_image' => esc_html__( 'Remove blend image',     'ember-oak' ),
		'use_featured_image'    => esc_html__( 'Use as blend image',     'ember-oak' ),
		'archives'              => esc_html__( 'Coffee Blend archives',  'ember-oak' ),
		'insert_into_item'      => esc_html__( 'Insert into coffee blend', 'ember-oak' ),
		'uploaded_to_this_item' => esc_html__( 'Uploaded to this coffee blend', 'ember-oak' ),
		'items_list'            => esc_html__( 'Coffee Blends list',     'ember-oak' ),
		'items_list_navigation' => esc_html__( 'Coffee Blends list navigation', 'ember-oak' ),
		'filter_items_list'     => esc_html__( 'Filter coffee blends list', 'ember-oak' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'show_in_rest'       => true,
		'has_archive'        => true,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
		'menu_icon'          => 'dashicons-coffee',
		'rewrite'            => array( 'slug' => 'blends' ),
		'show_in_menu'       => true,
		'show_ui'            => true,
		'publicly_queryable' => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'map_meta_cap'       => true,
	);

	register_post_type( 'ember_blend', $args );
}
add_action( 'init', 'ember_oak_register_blend_cpt' );

// ---------------------------------------------------------------------------
// 4. Custom Taxonomy: blend_origin (Origin) for ember_blend
// ---------------------------------------------------------------------------

function ember_oak_register_blend_origin_taxonomy() {
	$labels = array(
		'name'                       => esc_html__( 'Origins',                          'ember-oak' ),
		'singular_name'              => esc_html__( 'Origin',                           'ember-oak' ),
		'search_items'               => esc_html__( 'Search Origins',                   'ember-oak' ),
		'all_items'                  => esc_html__( 'All Origins',                      'ember-oak' ),
		'parent_item'                => esc_html__( 'Parent Origin',                    'ember-oak' ),
		'parent_item_colon'          => esc_html__( 'Parent Origin:',                   'ember-oak' ),
		'edit_item'                  => esc_html__( 'Edit Origin',                      'ember-oak' ),
		'update_item'                => esc_html__( 'Update Origin',                    'ember-oak' ),
		'add_new_item'               => esc_html__( 'Add New Origin',                   'ember-oak' ),
		'new_item_name'              => esc_html__( 'New Origin Name',                  'ember-oak' ),
		'menu_name'                  => esc_html__( 'Origin',                           'ember-oak' ),
		'not_found'                  => esc_html__( 'No origins found.',                'ember-oak' ),
		'no_terms'                   => esc_html__( 'No origins',                       'ember-oak' ),
		'items_list_navigation'      => esc_html__( 'Origins list navigation',          'ember-oak' ),
		'items_list'                 => esc_html__( 'Origins list',                     'ember-oak' ),
		'most_used'                  => esc_html__( 'Most Used',                        'ember-oak' ),
		'back_to_items'              => esc_html__( '&larr; Go to Origins',             'ember-oak' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'origin' ),
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);

	register_taxonomy( 'blend_origin', array( 'ember_blend' ), $args );
}
add_action( 'init', 'ember_oak_register_blend_origin_taxonomy' );

// ---------------------------------------------------------------------------
// 5. Custom Post Type: ember_event (Events)
// ---------------------------------------------------------------------------

function ember_oak_register_event_cpt() {
	$labels = array(
		'name'                  => esc_html__( 'Events',                   'ember-oak' ),
		'singular_name'         => esc_html__( 'Event',                    'ember-oak' ),
		'menu_name'             => esc_html__( 'Events',                   'ember-oak' ),
		'name_admin_bar'        => esc_html__( 'Event',                    'ember-oak' ),
		'add_new'               => esc_html__( 'Add New',                  'ember-oak' ),
		'add_new_item'          => esc_html__( 'Add New Event',            'ember-oak' ),
		'new_item'              => esc_html__( 'New Event',                'ember-oak' ),
		'edit_item'             => esc_html__( 'Edit Event',               'ember-oak' ),
		'view_item'             => esc_html__( 'View Event',               'ember-oak' ),
		'all_items'             => esc_html__( 'All Events',               'ember-oak' ),
		'search_items'          => esc_html__( 'Search Events',            'ember-oak' ),
		'parent_item_colon'     => esc_html__( 'Parent Events:',           'ember-oak' ),
		'not_found'             => esc_html__( 'No events found.',         'ember-oak' ),
		'not_found_in_trash'    => esc_html__( 'No events found in trash.','ember-oak' ),
		'featured_image'        => esc_html__( 'Event Image',              'ember-oak' ),
		'set_featured_image'    => esc_html__( 'Set event image',          'ember-oak' ),
		'remove_featured_image' => esc_html__( 'Remove event image',       'ember-oak' ),
		'use_featured_image'    => esc_html__( 'Use as event image',       'ember-oak' ),
		'archives'              => esc_html__( 'Event archives',           'ember-oak' ),
		'insert_into_item'      => esc_html__( 'Insert into event',        'ember-oak' ),
		'uploaded_to_this_item' => esc_html__( 'Uploaded to this event',   'ember-oak' ),
		'items_list'            => esc_html__( 'Events list',              'ember-oak' ),
		'items_list_navigation' => esc_html__( 'Events list navigation',   'ember-oak' ),
		'filter_items_list'     => esc_html__( 'Filter events list',       'ember-oak' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'show_in_rest'       => true,
		'has_archive'        => true,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'menu_icon'          => 'dashicons-calendar-alt',
		'rewrite'            => array( 'slug' => 'events' ),
		'show_in_menu'       => true,
		'show_ui'            => true,
		'publicly_queryable' => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'map_meta_cap'       => true,
	);

	register_post_type( 'ember_event', $args );
}
add_action( 'init', 'ember_oak_register_event_cpt' );

// ---------------------------------------------------------------------------
// 6. Meta Boxes: ember_blend — Blend Details
// ---------------------------------------------------------------------------

function ember_oak_add_blend_meta_box() {
	add_meta_box(
		'ember_oak_blend_details',
		esc_html__( 'Blend Details', 'ember-oak' ),
		'ember_oak_blend_meta_box_callback',
		'ember_blend',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'ember_oak_add_blend_meta_box' );

function ember_oak_blend_meta_box_callback( $post ) {
	wp_nonce_field( 'ember_oak_blend_save', 'ember_oak_blend_nonce' );

	$roast_level   = get_post_meta( $post->ID, '_roast_level',    true );
	$tasting_notes = get_post_meta( $post->ID, '_tasting_notes',  true );
	$origin_region = get_post_meta( $post->ID, '_origin_region',  true );
	$process       = get_post_meta( $post->ID, '_process',        true );
	$price         = get_post_meta( $post->ID, '_price',          true );
	$weight_opts   = get_post_meta( $post->ID, '_weight_options', true );

	if ( ! is_array( $weight_opts ) ) {
		$weight_opts = array();
	}

	$roast_options   = array(
		'light'    => esc_html__( 'Light',    'ember-oak' ),
		'medium'   => esc_html__( 'Medium',   'ember-oak' ),
		'dark'     => esc_html__( 'Dark',     'ember-oak' ),
		'espresso' => esc_html__( 'Espresso', 'ember-oak' ),
	);
	$process_options = array(
		'washed'  => esc_html__( 'Washed',  'ember-oak' ),
		'natural' => esc_html__( 'Natural', 'ember-oak' ),
		'honey'   => esc_html__( 'Honey',   'ember-oak' ),
	);
	$weight_choices  = array( '250g', '500g', '1kg' );
	?>
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="ember_oak_roast_level"><?php esc_html_e( 'Roast Level', 'ember-oak' ); ?></label>
			</th>
			<td>
				<select id="ember_oak_roast_level" name="ember_oak_roast_level">
					<option value=""><?php esc_html_e( '— Select —', 'ember-oak' ); ?></option>
					<?php foreach ( $roast_options as $val => $label ) : ?>
						<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $roast_level, $val ); ?>>
							<?php echo esc_html( $label ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="ember_oak_tasting_notes"><?php esc_html_e( 'Tasting Notes', 'ember-oak' ); ?></label>
			</th>
			<td>
				<input type="text"
					id="ember_oak_tasting_notes"
					name="ember_oak_tasting_notes"
					value="<?php echo esc_attr( $tasting_notes ); ?>"
					class="regular-text" />
				<p class="description"><?php esc_html_e( 'e.g. chocolate, cherry, citrus', 'ember-oak' ); ?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="ember_oak_origin_region"><?php esc_html_e( 'Origin Region', 'ember-oak' ); ?></label>
			</th>
			<td>
				<input type="text"
					id="ember_oak_origin_region"
					name="ember_oak_origin_region"
					value="<?php echo esc_attr( $origin_region ); ?>"
					class="regular-text" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="ember_oak_process"><?php esc_html_e( 'Process', 'ember-oak' ); ?></label>
			</th>
			<td>
				<select id="ember_oak_process" name="ember_oak_process">
					<option value=""><?php esc_html_e( '— Select —', 'ember-oak' ); ?></option>
					<?php foreach ( $process_options as $val => $label ) : ?>
						<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $process, $val ); ?>>
							<?php echo esc_html( $label ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="ember_oak_price"><?php esc_html_e( 'Price (£)', 'ember-oak' ); ?></label>
			</th>
			<td>
				<input type="number"
					id="ember_oak_price"
					name="ember_oak_price"
					value="<?php echo esc_attr( $price ); ?>"
					step="0.01"
					min="0"
					class="small-text" />
			</td>
		</tr>
		<tr>
			<th scope="row"><?php esc_html_e( 'Weight Options', 'ember-oak' ); ?></th>
			<td>
				<?php foreach ( $weight_choices as $weight ) : ?>
					<label style="margin-right:12px;">
						<input type="checkbox"
							name="ember_oak_weight_options[]"
							value="<?php echo esc_attr( $weight ); ?>"
							<?php checked( in_array( $weight, $weight_opts, true ) ); ?> />
						<?php echo esc_html( $weight ); ?>
					</label>
				<?php endforeach; ?>
			</td>
		</tr>
	</table>
	<?php
}

function ember_oak_save_blend_meta( $post_id ) {
	if ( ! isset( $_POST['ember_oak_blend_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ember_oak_blend_nonce'] ) ), 'ember_oak_blend_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['ember_oak_roast_level'] ) ) {
		$allowed_roast = array( 'light', 'medium', 'dark', 'espresso', '' );
		$roast         = sanitize_text_field( wp_unslash( $_POST['ember_oak_roast_level'] ) );
		if ( in_array( $roast, $allowed_roast, true ) ) {
			update_post_meta( $post_id, '_roast_level', $roast );
		}
	}
	if ( isset( $_POST['ember_oak_tasting_notes'] ) ) {
		update_post_meta( $post_id, '_tasting_notes', sanitize_text_field( wp_unslash( $_POST['ember_oak_tasting_notes'] ) ) );
	}
	if ( isset( $_POST['ember_oak_origin_region'] ) ) {
		update_post_meta( $post_id, '_origin_region', sanitize_text_field( wp_unslash( $_POST['ember_oak_origin_region'] ) ) );
	}
	if ( isset( $_POST['ember_oak_process'] ) ) {
		$allowed_process = array( 'washed', 'natural', 'honey', '' );
		$process         = sanitize_text_field( wp_unslash( $_POST['ember_oak_process'] ) );
		if ( in_array( $process, $allowed_process, true ) ) {
			update_post_meta( $post_id, '_process', $process );
		}
	}
	if ( isset( $_POST['ember_oak_price'] ) ) {
		$price = floatval( $_POST['ember_oak_price'] );
		update_post_meta( $post_id, '_price', $price );
	}
	$allowed_weights = array( '250g', '500g', '1kg' );
	if ( isset( $_POST['ember_oak_weight_options'] ) && is_array( $_POST['ember_oak_weight_options'] ) ) {
		$weights = array_intersect( array_map( 'sanitize_text_field', wp_unslash( $_POST['ember_oak_weight_options'] ) ), $allowed_weights );
		update_post_meta( $post_id, '_weight_options', array_values( $weights ) );
	} else {
		update_post_meta( $post_id, '_weight_options', array() );
	}
}
add_action( 'save_post_ember_blend', 'ember_oak_save_blend_meta' );

// ---------------------------------------------------------------------------
// 7. Meta Boxes: ember_event — Event Details
// ---------------------------------------------------------------------------

function ember_oak_add_event_meta_box() {
	add_meta_box(
		'ember_oak_event_details',
		esc_html__( 'Event Details', 'ember-oak' ),
		'ember_oak_event_meta_box_callback',
		'ember_event',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'ember_oak_add_event_meta_box' );

function ember_oak_event_meta_box_callback( $post ) {
	wp_nonce_field( 'ember_oak_event_save', 'ember_oak_event_nonce' );

	$event_date     = get_post_meta( $post->ID, '_event_date',     true );
	$event_time     = get_post_meta( $post->ID, '_event_time',     true );
	$event_location = get_post_meta( $post->ID, '_event_location', true );
	$event_price    = get_post_meta( $post->ID, '_event_price',    true );
	$event_capacity = get_post_meta( $post->ID, '_event_capacity', true );
	?>
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="ember_oak_event_date"><?php esc_html_e( 'Event Date', 'ember-oak' ); ?></label>
			</th>
			<td>
				<input type="date"
					id="ember_oak_event_date"
					name="ember_oak_event_date"
					value="<?php echo esc_attr( $event_date ); ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="ember_oak_event_time"><?php esc_html_e( 'Event Time', 'ember-oak' ); ?></label>
			</th>
			<td>
				<input type="text"
					id="ember_oak_event_time"
					name="ember_oak_event_time"
					value="<?php echo esc_attr( $event_time ); ?>"
					class="regular-text"
					placeholder="<?php esc_attr_e( 'e.g. 7:00 PM – 9:00 PM', 'ember-oak' ); ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="ember_oak_event_location"><?php esc_html_e( 'Event Location', 'ember-oak' ); ?></label>
			</th>
			<td>
				<input type="text"
					id="ember_oak_event_location"
					name="ember_oak_event_location"
					value="<?php echo esc_attr( $event_location ); ?>"
					class="regular-text" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="ember_oak_event_price"><?php esc_html_e( 'Event Price', 'ember-oak' ); ?></label>
			</th>
			<td>
				<input type="text"
					id="ember_oak_event_price"
					name="ember_oak_event_price"
					value="<?php echo esc_attr( $event_price ); ?>"
					class="regular-text"
					placeholder="<?php esc_attr_e( 'e.g. Free or £15', 'ember-oak' ); ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="ember_oak_event_capacity"><?php esc_html_e( 'Event Capacity', 'ember-oak' ); ?></label>
			</th>
			<td>
				<input type="number"
					id="ember_oak_event_capacity"
					name="ember_oak_event_capacity"
					value="<?php echo esc_attr( $event_capacity ); ?>"
					min="0"
					class="small-text" />
				<p class="description"><?php esc_html_e( 'Maximum number of attendees (0 = unlimited)', 'ember-oak' ); ?></p>
			</td>
		</tr>
	</table>
	<?php
}

function ember_oak_save_event_meta( $post_id ) {
	if ( ! isset( $_POST['ember_oak_event_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ember_oak_event_nonce'] ) ), 'ember_oak_event_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['ember_oak_event_date'] ) ) {
		$date = sanitize_text_field( wp_unslash( $_POST['ember_oak_event_date'] ) );
		// Validate YYYY-MM-DD format
		if ( preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date ) || '' === $date ) {
			update_post_meta( $post_id, '_event_date', $date );
		}
	}
	if ( isset( $_POST['ember_oak_event_time'] ) ) {
		update_post_meta( $post_id, '_event_time', sanitize_text_field( wp_unslash( $_POST['ember_oak_event_time'] ) ) );
	}
	if ( isset( $_POST['ember_oak_event_location'] ) ) {
		update_post_meta( $post_id, '_event_location', sanitize_text_field( wp_unslash( $_POST['ember_oak_event_location'] ) ) );
	}
	if ( isset( $_POST['ember_oak_event_price'] ) ) {
		update_post_meta( $post_id, '_event_price', sanitize_text_field( wp_unslash( $_POST['ember_oak_event_price'] ) ) );
	}
	if ( isset( $_POST['ember_oak_event_capacity'] ) ) {
		update_post_meta( $post_id, '_event_capacity', absint( $_POST['ember_oak_event_capacity'] ) );
	}
}
add_action( 'save_post_ember_event', 'ember_oak_save_event_meta' );

// ---------------------------------------------------------------------------
// 8. Customizer Settings
// ---------------------------------------------------------------------------

function ember_oak_customize_register( $wp_customize ) {

	// ---- Panel ----
	$wp_customize->add_panel( 'ember_oak_panel', array(
		'title'    => esc_html__( 'Ember & Oak Settings', 'ember-oak' ),
		'priority' => 130,
	) );

	// ---- Section: Hero ----
	$wp_customize->add_section( 'ember_oak_hero', array(
		'title'    => esc_html__( 'Hero Section', 'ember-oak' ),
		'panel'    => 'ember_oak_panel',
		'priority' => 10,
	) );

	// hero_heading
	$wp_customize->add_setting( 'hero_heading', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'hero_heading', array(
		'label'   => esc_html__( 'Hero Heading', 'ember-oak' ),
		'section' => 'ember_oak_hero',
		'type'    => 'text',
	) );

	// hero_subheading
	$wp_customize->add_setting( 'hero_subheading', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'hero_subheading', array(
		'label'   => esc_html__( 'Hero Subheading', 'ember-oak' ),
		'section' => 'ember_oak_hero',
		'type'    => 'text',
	) );

	// hero_cta_text
	$wp_customize->add_setting( 'hero_cta_text', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'hero_cta_text', array(
		'label'   => esc_html__( 'CTA Button Text', 'ember-oak' ),
		'section' => 'ember_oak_hero',
		'type'    => 'text',
	) );

	// hero_cta_url
	$wp_customize->add_setting( 'hero_cta_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'hero_cta_url', array(
		'label'   => esc_html__( 'CTA Button URL', 'ember-oak' ),
		'section' => 'ember_oak_hero',
		'type'    => 'url',
	) );

	// ---- Section: Contact Info ----
	$wp_customize->add_section( 'ember_oak_contact_info', array(
		'title'    => esc_html__( 'Contact Info', 'ember-oak' ),
		'panel'    => 'ember_oak_panel',
		'priority' => 20,
	) );

	$contact_fields = array(
		'phone'           => esc_html__( 'Phone Number',      'ember-oak' ),
		'email'           => esc_html__( 'Email Address',     'ember-oak' ),
		'address'         => esc_html__( 'Address',           'ember-oak' ),
		'hours_weekday'   => esc_html__( 'Weekday Hours',     'ember-oak' ),
		'hours_weekend'   => esc_html__( 'Weekend Hours',     'ember-oak' ),
	);
	foreach ( $contact_fields as $id => $label ) {
		$wp_customize->add_setting( $id, array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $label,
			'section' => 'ember_oak_contact_info',
			'type'    => 'text',
		) );
	}

	// ---- Section: Social Links ----
	$wp_customize->add_section( 'ember_oak_social_links', array(
		'title'    => esc_html__( 'Social Links', 'ember-oak' ),
		'panel'    => 'ember_oak_panel',
		'priority' => 30,
	) );

	$social_fields = array(
		'instagram_url' => esc_html__( 'Instagram URL', 'ember-oak' ),
		'facebook_url'  => esc_html__( 'Facebook URL',  'ember-oak' ),
		'twitter_url'   => esc_html__( 'Twitter / X URL', 'ember-oak' ),
	);
	foreach ( $social_fields as $id => $label ) {
		$wp_customize->add_setting( $id, array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $label,
			'section' => 'ember_oak_social_links',
			'type'    => 'url',
		) );
	}
}
add_action( 'customize_register', 'ember_oak_customize_register' );

// ---------------------------------------------------------------------------
// 9. Accessible Walker_Nav_Menu Extension
// ---------------------------------------------------------------------------

class Ember_Oak_Walker_Nav_Menu extends Walker_Nav_Menu {

	/**
	 * Starts the element output, adding aria-expanded and aria-haspopup to
	 * items that have children (sub-menus).
	 *
	 * @param string   $output Used to append additional content.
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$has_children = in_array( 'menu-item-has-children', $classes, true );

		$class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id_attr = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$id_attr = $id_attr ? ' id="' . esc_attr( $id_attr ) . '"' : '';

		$output .= $indent . '<li' . $id_attr . $class_names . '>';

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '#';
		$atts['class']  = 'menu-link';

		if ( $has_children ) {
			$atts['aria-haspopup'] = 'true';
			$atts['aria-expanded'] = 'false';
			$atts['class']        .= ' menu-link--has-children';
		}

		if ( in_array( 'current-menu-item', $classes, true ) ) {
			$atts['aria-current'] = 'page';
		}

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( '' !== $value ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$title       = apply_filters( 'the_title', $item->title, $item->ID );
		$title       = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
		$item_output = isset( $args->before ) ? $args->before : '';
		$item_output .= '<a' . $attributes . '>';
		$item_output .= ( isset( $args->link_before ) ? $args->link_before : '' ) . $title . ( isset( $args->link_after ) ? $args->link_after : '' );
		$item_output .= '</a>';

		if ( $has_children && $depth === 0 ) {
			$item_output .= '<button class="sub-menu-toggle" aria-expanded="false" aria-label="' . esc_attr__( 'Toggle sub-menu', 'ember-oak' ) . '">';
			$item_output .= '<span class="screen-reader-text">' . esc_html__( 'Toggle sub-menu', 'ember-oak' ) . '</span>';
			$item_output .= '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" aria-hidden="true" focusable="false"><path d="M6 8L1 3h10z"/></svg>';
			$item_output .= '</button>';
		}

		$item_output .= isset( $args->after ) ? $args->after : '';

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Starts the list before the elements are added for sub-menus.
	 *
	 * @param string   $output Used to append additional content.
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent  = str_repeat( "\t", $depth );
		$output .= "\n{$indent}<ul class=\"sub-menu\" role=\"list\">\n";
	}
}

// ---------------------------------------------------------------------------
// 10. Helper Functions
// ---------------------------------------------------------------------------

/**
 * Get all blend meta fields for a given post.
 *
 * @param int $post_id Post ID.
 * @return array Associative array of blend meta.
 */
function ember_oak_get_blend_meta( $post_id ) {
	$post_id = absint( $post_id );
	return array(
		'roast_level'   => get_post_meta( $post_id, '_roast_level',    true ),
		'tasting_notes' => get_post_meta( $post_id, '_tasting_notes',  true ),
		'origin_region' => get_post_meta( $post_id, '_origin_region',  true ),
		'process'       => get_post_meta( $post_id, '_process',        true ),
		'price'         => get_post_meta( $post_id, '_price',          true ),
		'weight_options'=> get_post_meta( $post_id, '_weight_options', true ),
	);
}

/**
 * Get all event meta fields for a given post.
 *
 * @param int $post_id Post ID.
 * @return array Associative array of event meta.
 */
function ember_oak_get_event_meta( $post_id ) {
	$post_id = absint( $post_id );
	return array(
		'event_date'     => get_post_meta( $post_id, '_event_date',     true ),
		'event_time'     => get_post_meta( $post_id, '_event_time',     true ),
		'event_location' => get_post_meta( $post_id, '_event_location', true ),
		'event_price'    => get_post_meta( $post_id, '_event_price',    true ),
		'event_capacity' => get_post_meta( $post_id, '_event_capacity', true ),
	);
}

/**
 * Return a human-readable label for a roast level key.
 *
 * @param string $level Roast level key (light, medium, dark, espresso).
 * @return string Human-readable label, or the original value if not matched.
 */
function ember_oak_roast_level_label( $level ) {
	$labels = array(
		'light'    => esc_html__( 'Light',    'ember-oak' ),
		'medium'   => esc_html__( 'Medium',   'ember-oak' ),
		'dark'     => esc_html__( 'Dark',     'ember-oak' ),
		'espresso' => esc_html__( 'Espresso', 'ember-oak' ),
	);
	return isset( $labels[ $level ] ) ? $labels[ $level ] : esc_html( $level );
}

/**
 * Whether the current page is the blend (coffee blends) archive.
 *
 * @return bool True if on the ember_blend post type archive.
 */
function ember_oak_is_blend_archive() {
	return is_post_type_archive( 'ember_blend' );
}

/**
 * Output or return a custom excerpt.
 *
 * @param int    $length Number of words. Default 30.
 * @param string $more   More string appended after excerpt. Default '&hellip;'.
 * @param int    $post_id Optional post ID. Defaults to current post.
 * @return string The trimmed excerpt.
 */
function ember_oak_excerpt( $length = 30, $more = '&hellip;', $post_id = 0 ) {
	if ( $post_id ) {
		$post = get_post( absint( $post_id ) );
	} else {
		$post = get_post();
	}

	if ( ! $post ) {
		return '';
	}

	if ( $post->post_excerpt ) {
		$excerpt = apply_filters( 'the_excerpt', $post->post_excerpt );
	} else {
		$excerpt = get_the_content( '', false, $post );
		$excerpt = strip_shortcodes( $excerpt );
		$excerpt = apply_filters( 'the_content', $excerpt );
		$excerpt = str_replace( ']]>', ']]&gt;', $excerpt );
		$excerpt = wp_strip_all_tags( $excerpt );
		$words   = preg_split( '/\s+/u', $excerpt, -1, PREG_SPLIT_NO_EMPTY );
		if ( count( $words ) > $length ) {
			$excerpt = implode( ' ', array_slice( $words, 0, $length ) ) . $more;
		}
	}

	return $excerpt;
}
