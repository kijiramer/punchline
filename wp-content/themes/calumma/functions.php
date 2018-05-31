<?php
/**
 * calumma functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package calumma
 */

if ( ! function_exists( 'calumma_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function calumma_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on calumma, use a find and replace
	 * to change 'calumma' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'calumma', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'calumma' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'calumma_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

        // Add theme support for Custom Logo.
        add_theme_support( 'custom-logo', array(
                'width'       => 250,
                'height'      => 250,
                'flex-width'  => true,
        ) );

}
endif;
add_action( 'after_setup_theme', 'calumma_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function calumma_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'calumma_content_width', 640 );
}
add_action( 'after_setup_theme', 'calumma_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function calumma_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'calumma' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'calumma' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'calumma_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function calumma_scripts() {
	wp_enqueue_style( 'calumma-style', get_stylesheet_uri() );

	wp_enqueue_script( 'calumma-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'calumma-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'calumma_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

function calumma_googlefonts()
{
  global $wp_filesystem;

  if (empty($wp_filesystem)) {
    require_once (ABSPATH . '/wp-admin/includes/file.php');
    WP_Filesystem();
  }
  $strgf = $wp_filesystem->get_contents(get_template_directory()."/googlefonts.dat");
  $tabgf = explode("\n",$strgf);
  $i = 1;
  foreach($tabgf as $url)
  {
    wp_enqueue_style('googlefont'.$i, $url, array(), null);
    $i++;
  }
}

function calumma_add_css()
{
  wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css');
  wp_enqueue_style( 'calumma-custom', get_template_directory_uri() . '/calumma.css');
}

add_action('wp_enqueue_scripts','calumma_googlefonts',1);
add_action('wp_enqueue_scripts','calumma_add_css',20);


