<?php
/**
 * Functions
 *
 * @package      BE-Delicious
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

// Theme.
require_once get_template_directory() . '/inc/tha-theme-hooks.php';
require_once get_template_directory() . '/inc/layouts.php';
require_once get_template_directory() . '/inc/helper-functions.php';
require_once get_template_directory() . '/inc/wordpress-cleanup.php';
require_once get_template_directory() . '/inc/comments.php';
include_once get_template_directory() . '/inc/site-header.php';
include_once get_template_directory() . '/inc/site-footer.php';
include_once get_template_directory() . '/inc/archive-header.php';
include_once get_template_directory() . '/inc/archive-navigation.php';
include_once get_template_directory() . '/inc/template-tags.php';

// Functionality.
require_once get_template_directory() . '/inc/blocks.php';
require_once get_template_directory() . '/inc/block-areas.php';
require_once get_template_directory() . '/inc/loop.php';
include_once get_template_directory() . '/inc/login-logo.php';

// Plugin Support.
require_once get_template_directory() . '/inc/acf.php';
require_once get_template_directory() . '/inc/wordpress-seo.php';
include_once get_template_directory() . '/inc/wpforms.php';

/**
 * Enqueue scripts and styles.
 */
function be_scripts() {

	wp_enqueue_script( 'theme-global', get_theme_file_uri( '/assets/js/global.js' ), [], filemtime( get_theme_file_path( '/assets/js/global.js' ) ), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_style( 'theme-style', get_theme_file_uri( '/assets/css/main.css' ), array(), filemtime( get_theme_file_path( '/assets/css/main.css' ) ) );

}
add_action( 'wp_enqueue_scripts', 'be_scripts' );

/**
 * Gutenberg scripts and styles
 */
function be_gutenberg_scripts() {
	wp_enqueue_script( 'theme-editor', get_theme_file_uri( '/assets/js/editor.js' ), array( 'wp-blocks', 'wp-dom' ), filemtime( get_theme_file_path( '/assets/js/editor.js' ) ), true );
}
add_action( 'enqueue_block_editor_assets', 'be_gutenberg_scripts' );

if ( ! function_exists( 'be_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function be_setup() {
		/*
		 * Make theme available for translation.
		 */
		load_theme_textdomain( 'be-delicious', get_template_directory() . '/languages' );

		// Editor Styles.
		add_theme_support( 'editor-styles' );
		add_editor_style( 'assets/css/editor-style.css' );

		// Admin Bar Styling.
		add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Body open hook.
		add_theme_support( 'body-open' );

		// Remove block templates.
		remove_theme_support( 'block-templates' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Set the content width in pixels, based on the theme's design and stylesheet.
		 */
		$GLOBALS['content_width'] = apply_filters( 'be_content_width', 800 );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			[
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
			]
		);

		// Gutenberg.

		// -- Responsive embeds
		add_theme_support( 'responsive-embeds' );

	}

endif;
add_action( 'after_setup_theme', 'be_setup' );

/**
 * Template Hierarchy
 *
 * @param string $template Template.
 */
function be_template_hierarchy( $template ) {

	if ( is_search() ) {
		$template = get_query_template( 'archive' );
	}
	return $template;
}
add_filter( 'template_include', 'be_template_hierarchy' );

/**
 * Favicon
 */
function cwp_favicon() {
	echo '<link rel="icon" href="' . esc_url( get_stylesheet_directory_uri() . '/favicon.ico' ) . '">';
}
add_action( 'wp_head', 'cwp_favicon', 100 );
add_action( 'admin_head', 'cwp_favicon', 100 );
add_filter( 'site_icon_meta_tags', '__return_empty_array' );

/**
 * Rename "Posts" post type to "Links"
 */
function cwp_change_post_labels( $labels ) {
    $labels->name = 'Links';
    $labels->singular_name = 'Link';
    $labels->add_new = 'Add Link';
    $labels->add_new_item = 'Add New Link';
    $labels->edit_item = 'Edit Link';
    $labels->new_item = 'New Link';
    $labels->view_item = 'View Link';
    $labels->view_items = 'View Links';
    $labels->search_items = 'Search Links';
    $labels->not_found = 'No Links found';
    $labels->not_found_in_trash = 'No Links found in Trash';
    $labels->all_items = 'All Links';
    $labels->archives = 'Link Archives';
    $labels->attributes = 'Link Attributes';
    $labels->insert_into_item = 'Insert into Link';
    $labels->uploaded_to_this_item = 'Uploaded to this Link';
    $labels->filter_items_list = 'Filter Links list';
    $labels->items_list_navigation = 'Links list navigation';
    $labels->items_list = 'Links list';
    $labels->menu_name = 'Links';
    $labels->name_admin_bar = 'Link';

	return $labels;
}
add_filter( 'post_type_labels_post', 'cwp_change_post_labels' );

/**
 * Register Notes Post Type
 */
function cwp_register_notes_cpt() {
	$labels = array(
		'name'               => 'Notes',
		'singular_name'      => 'Note',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Note',
		'edit_item'          => 'Edit Note',
		'new_item'           => 'New Note',
		'view_item'          => 'View Note',
		'search_items'       => 'Search Notes',
		'not_found'          => 'No Notes found',
		'not_found_in_trash' => 'No Notes found in Trash',
		'parent_item_colon'  => 'Parent Note:',
		'menu_name'          => 'Notes',
	);

	$args = array(
		'labels'              => $labels,
		'hierarchical'        => false,
		'supports'            => array( 'title', 'editor' ),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_rest'        => true,
		'show_in_nav_menus'   => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'has_archive'         => true,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => array( 'slug' => 'note', 'with_front' => false ),
		'menu_position'       => 5,
		'taxonomies' => [ 'post_tag' ]
	);

	register_post_type( 'note', $args );

}
add_action( 'init', 'cwp_register_notes_cpt' );

/**
 * Include notes
 */
function cwp_main_query( $query ) {
	if ( $query->is_main_query() && ! is_admin() && ( $query->is_home() || $query->is_archive() || $query->is_search() ) ) {
		$query->set( 'post_type', [ 'post', 'note' ] );
	}
}
add_action( 'pre_get_posts', 'cwp_main_query' );
