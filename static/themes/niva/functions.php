<?php

if ( ! isset( $content_width ) ) {
    $content_width = 640; /* pixels */
}


/**
||-> niva
 
*/
function niva($redux_meta_name1,$redux_meta_name2 = ''){

    global  $niva;

    $html = '';
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
            if ( function_exists('sweetthemes_framework')) {
                if (isset($redux_meta_name1) && !empty($redux_meta_name2)) {
                    $html = $niva[$redux_meta_name1][$redux_meta_name2];
                }elseif(isset($redux_meta_name1) && empty($redux_meta_name2)){
                    $html = $niva[$redux_meta_name1];
                }
            }
        }
    
    return $html;

}


/**
||-> niva_setup
*/
function niva_setup() {

    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on niva, use a find and replace
     * to change 'niva' to the name of your theme in all the template files
     */
    load_theme_textdomain( 'niva', get_template_directory() . '/languages' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary menu', 'niva' )
    ) );

    // ADD THEME SUPPORT
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'custom-header' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
    ) );
    // Switch default core markup for search form, comment form, and comments to output valid HTML5.
    // Enable support for Post Formats.
    add_theme_support( 'custom-background', apply_filters( 'niva_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    ) ) );// Set up the WP core custom background feature.

}
add_action( 'after_setup_theme', 'niva_setup' );

/**
||-> Register widget areas.
*/
function niva_widgets_init() {

    global  $niva;

    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'niva' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Main Theme Sidebar', 'niva' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );


    if (!empty($niva['mt_dynamic_sidebars'])){
        foreach ($niva['mt_dynamic_sidebars'] as &$value) {
            $id           = str_replace(' ', '', $value);
            $id_lowercase = strtolower($id);
            if ($id_lowercase) {
                register_sidebar( array(
                    'name'          => esc_attr($value),
                    'id'            => esc_attr($id_lowercase),
                    'description'   => esc_html__( 'Sidebar ', 'niva' ) . esc_attr($value),
                    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h1 class="widget-title">',
                    'after_title'   => '</h1>',
                ) );
            }
        }
    }


    
    // FOOTER ROW 1
    if (isset($niva['mt_footer_row_1_layout'])) {
        $footer_row_1 = $niva['mt_footer_row_1_layout'];
        $nr1 = array("1", "2", "3", "4", "5", "6");
        if (in_array($footer_row_1, $nr1)) {
            for ($i=1; $i <= $footer_row_1 ; $i++) { 
                register_sidebar( array(
                    'name'          => esc_html__( 'Footer Row 1 - Sidebar ','niva').esc_attr($i),
                    'id'            => 'footer_row_1_'.esc_attr($i),
                    'description'   => esc_html__( 'Footer Row 1 - Sidebar ', 'niva' ) . esc_attr($i),
                    'before_widget' => '<aside id="%1$s" class="widget vc_column_vc_container %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h1 class="widget-title">',
                    'after_title'   => '</h1>',
                ) );
            }
        }elseif ($footer_row_1 == 'column_half_sub_half' || $footer_row_1 == 'column_sub_half_half') {
            $footer_row_1 = '3';
            for ($i=1; $i <= $footer_row_1 ; $i++) { 
                register_sidebar( array(
                    'name'          => esc_html__( 'Footer Row 1 - Sidebar ', 'niva' ) . esc_attr($i),
                    'id'            => 'footer_row_1_'.esc_attr($i),
                    'description'   => esc_html__( 'Footer Row 1 - Sidebar ', 'niva' ) . esc_attr($i),
                    'before_widget' => '<aside id="%1$s" class="widget vc_column_vc_container %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h1 class="widget-title">',
                    'after_title'   => '</h1>',
                ) );
            }
        }elseif ($footer_row_1 == 'column_sub_fourth_third' || $footer_row_1 == 'column_third_sub_fourth') {
            $footer_row_1 = '5';
            for ($i=1; $i <= $footer_row_1 ; $i++) { 
                register_sidebar( array(
                    'name'          => esc_html__( 'Footer Row 1 - Sidebar ','niva').esc_attr($i),
                    'id'            => 'footer_row_1_'.esc_attr($i),
                    'description'   => esc_html__( 'Footer Row 1 - Sidebar ', 'niva' ) . esc_attr($i),
                    'before_widget' => '<aside id="%1$s" class="widget vc_column_vc_container %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h1 class="widget-title">',
                    'after_title'   => '</h1>',
                ) );
            }
        }elseif ($footer_row_1 == 'column_sub_third_half' || $footer_row_1 == 'column_half_sub_third') {
            $footer_row_1 = '4';
            for ($i=1; $i <= $footer_row_1 ; $i++) { 
                register_sidebar( array(
                    'name'          => esc_html__( 'Footer Row 1 - Sidebar ','niva').esc_attr($i),
                    'id'            => 'footer_row_1_'.esc_attr($i),
                    'description'   => esc_html__( 'Footer Row 1 - Sidebar ', 'niva' ) . esc_attr($i),
                    'before_widget' => '<aside id="%1$s" class="widget vc_column_vc_container %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h1 class="widget-title">',
                    'after_title'   => '</h1>',
                ) );
            }
        }
    }

    // FOOTER ROW 2
    if (isset($niva['mt_footer_row_2_layout'])) {
        $footer_row_2 = $niva['mt_footer_row_2_layout'];
        $nr2 = array("1", "2", "3", "4", "5", "6");
        if (in_array($footer_row_2, $nr2)) {
            for ($i=1; $i <= $footer_row_2 ; $i++) { 
                register_sidebar( array(
                    'name'          => esc_html__( 'Footer Row 2 - Sidebar ','niva').esc_attr($i),
                    'id'            => 'footer_row_2_'.esc_url($i),
                    'description'   => esc_html__( 'Footer Row 2 - Sidebar ', 'niva' ) . esc_attr($i),
                    'before_widget' => '<aside id="%1$s" class="widget vc_column_vc_container %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h1 class="widget-title">',
                    'after_title'   => '</h1>',
                ) );
            }
        }elseif ($footer_row_2 == 'column_half_sub_half' || $footer_row_2 == 'column_sub_half_half') {
            $footer_row_2 = '3';
            for ($i=1; $i <= $footer_row_2 ; $i++) { 
                register_sidebar( array(
                    'name'          => esc_html__( 'Footer Row 2 - Sidebar ','niva').esc_attr($i),
                    'id'            => 'footer_row_2_'.esc_attr($i),
                    'description'   => esc_html__( 'Footer Row 2 - Sidebar ', 'niva' ) . esc_attr($i),
                    'before_widget' => '<aside id="%1$s" class="widget vc_column_vc_container %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h1 class="widget-title">',
                    'after_title'   => '</h1>',
                ) );
            }
        }elseif ($footer_row_2 == 'column_sub_fourth_third' || $footer_row_2 == 'column_third_sub_fourth') {
            $footer_row_2 = '5';
            for ($i=1; $i <= $footer_row_2 ; $i++) { 
                register_sidebar( array(
                    'name'          => esc_html__( 'Footer Row 2 - Sidebar ','niva').esc_attr($i),
                    'id'            => 'footer_row_2_'.esc_attr($i),
                    'description'   => esc_html__( 'Footer Row 2 - Sidebar ', 'niva' ) . esc_attr($i),
                    'before_widget' => '<aside id="%1$s" class="widget vc_column_vc_container %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h1 class="widget-title">',
                    'after_title'   => '</h1>',
                ) );
            }
        }elseif ($footer_row_2 == 'column_sub_third_half' || $footer_row_2 == 'column_half_sub_third') {
            $footer_row_2 = '4';
            for ($i=1; $i <= $footer_row_2 ; $i++) { 
                register_sidebar( array(
                    'name'          => esc_html__( 'Footer Row 2 - Sidebar ','niva').esc_attr($i),
                    'id'            => 'footer_row_2_'.esc_attr($i),
                    'description'   => esc_html__( 'Footer Row 2 - Sidebar ', 'niva' ) . esc_attr($i),
                    'before_widget' => '<aside id="%1$s" class="widget vc_column_vc_container %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h1 class="widget-title">',
                    'after_title'   => '</h1>',
                ) );
            }
        }
    }

    // FOOTER ROW 3
    if (isset($niva['mt_footer_row_3_layout'])) {
        $footer_row_3 = $niva['mt_footer_row_3_layout'];
        $nr3 = array("1", "2", "3", "4", "5", "6");
        if (in_array($footer_row_3, $nr3)) {
            for ($i=1; $i <= $footer_row_3 ; $i++) { 
                register_sidebar( array(
                    'name'          => esc_html__( 'Footer Row 3 - Sidebar ', 'niva').esc_attr($i),
                    'id'            => 'footer_row_3_'.esc_attr($i),
                    'description'   => esc_html__( 'Footer Row 3 - Sidebar ', 'niva' ) . esc_attr($i),
                    'before_widget' => '<aside id="%1$s" class="widget vc_column_vc_container %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h1 class="widget-title">',
                    'after_title'   => '</h1>',
                ) );
            }
        }elseif ($footer_row_3 == 'column_half_sub_half' || $footer_row_3 == 'column_sub_half_half') {
            $footer_row_3 = '3';
            for ($i=1; $i <= $footer_row_3 ; $i++) { 
                register_sidebar( array(
                    'name'          => esc_html__( 'Footer Row 3 - Sidebar ','niva').esc_attr($i),
                    'id'            => 'footer_row_3_'.esc_attr($i),
                    'description'   => esc_html__( 'Footer Row 3 - Sidebar ', 'niva' ) . esc_attr($i),
                    'before_widget' => '<aside id="%1$s" class="widget vc_column_vc_container %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h1 class="widget-title">',
                    'after_title'   => '</h1>',
                ) );
            }
        }elseif ($footer_row_3 == 'column_sub_fourth_third' || $footer_row_3 == 'column_third_sub_fourth') {
            $footer_row_3 = '5';
            for ($i=1; $i <= $footer_row_3 ; $i++) { 
                register_sidebar( array(
                    'name'          => esc_html__( 'Footer Row 3 - Sidebar ','niva').esc_attr($i),
                    'id'            => 'footer_row_3_'.esc_attr($i),
                    'description'   => esc_html__( 'Footer Row 3 - Sidebar ', 'niva' ) . esc_attr($i),
                    'before_widget' => '<aside id="%1$s" class="widget vc_column_vc_container %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h1 class="widget-title">',
                    'after_title'   => '</h1>',
                ) );
            }
        }elseif ($footer_row_3 == 'column_sub_third_half' || $footer_row_3 == 'column_half_sub_third') {
            $footer_row_3 = '4';
            for ($i=1; $i <= $footer_row_3 ; $i++) { 
                register_sidebar( array(
                    'name'          => esc_html__( 'Footer Row 3 - Sidebar ','niva').esc_attr($i),
                    'id'            => 'footer_row_3_'.esc_attr($i),
                    'description'   => esc_html__( 'Footer Row 3 - Sidebar ', 'niva' ) . esc_attr($i),
                    'before_widget' => '<aside id="%1$s" class="widget vc_column_vc_container %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h1 class="widget-title">',
                    'after_title'   => '</h1>',
                ) );
            }
        }
    }
}
add_action( 'widgets_init', 'niva_widgets_init' );


/**
||-> Enqueue scripts and styles.
*/
function niva_scripts() {

    //STYLESHEETS
    wp_enqueue_style( "font-awesome", get_template_directory_uri().'/css/font-awesome.min.css' );
    wp_enqueue_style( "niva-responsive", get_template_directory_uri().'/css/responsive.css' );
    wp_enqueue_style( "niva-media-screens", get_template_directory_uri().'/css/media-screens.css' );
    wp_enqueue_style( "owl-carousel", get_template_directory_uri().'/css/owl.carousel.css' );
    wp_enqueue_style( "animate", get_template_directory_uri().'/css/animate.css' );
    wp_enqueue_style( "niva-styles", get_template_directory_uri().'/css/styles.css' );
    wp_enqueue_style( 'niva-style', get_stylesheet_uri() );
    wp_enqueue_style( "niva-blogloops-style", get_template_directory_uri().'/css/styles-module-blogloops.css' );
    wp_enqueue_style( "niva-navigations-style", get_template_directory_uri().'/css/styles-module-navigations.css' );
    wp_enqueue_style( "niva-header-style", get_template_directory_uri().'/css/styles-headers.css' );
    wp_enqueue_style( "niva-footer-style", get_template_directory_uri().'/css/styles-footer.css' );
    wp_enqueue_style( "simple-line-icons", get_template_directory_uri().'/css/simple-line-icons.css' );
    wp_enqueue_style( "js-composer", get_template_directory_uri().'/css/js_composer.css' );
    wp_enqueue_style( "niva-gutenberg-frontend", get_template_directory_uri().'/css/gutenberg-frontend.css' );
    

    //SCRIPTS
    wp_enqueue_script( 'modernizr-custom', get_template_directory_uri() . '/js/modernizr.custom.js', array('jquery'), '2.6.2', true );
    wp_enqueue_script( 'classie', get_template_directory_uri() . '/js/classie.js', array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'jquery-form', get_template_directory_uri() . '/js/jquery.form.js', array('jquery'), '3.51.0', true );
    wp_enqueue_script( 'jquery-ketchup', get_template_directory_uri() . '/js/jquery.ketchup.js', array('jquery'), '0.3.1', true );
    wp_enqueue_script( 'jquery-validation', get_template_directory_uri() . '/js/jquery.validation.js', array('jquery'), '1.13.1', true );
    wp_enqueue_script( 'uisearch', get_template_directory_uri() . '/js/uisearch.js', array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'jquery-parallax', get_template_directory_uri() . '/js/jquery.parallax.js', array('jquery'), '1.1.3', true );
    wp_enqueue_script( 'jquery.appear', get_template_directory_uri() . '/js/jquery.appear.js', array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'jquery.countTo', get_template_directory_uri() . '/js/jquery.countTo.js', array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.js', array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'modernizr-viewport', get_template_directory_uri() . '/js/modernizr.viewport.js', array('jquery'), '2.6.2', true );
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '3.3.1', true );
    wp_enqueue_script( 'animate', get_template_directory_uri() . '/js/animate.js', array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'jquery-countdown', get_template_directory_uri() . '/js/jquery.countdown.js', array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'wow', get_template_directory_uri() . '/js/wow.min.js', array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'niva-custom-js', get_template_directory_uri() . '/js/niva-custom.js', array('jquery'), '1.0.0', true );
    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        if(niva('mt_preloader_status') == true) {
            wp_enqueue_script( 'pace', get_template_directory_uri() . '/js/pace.js', array('jquery'), '1.0.0', false );
        }
    }
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'niva_scripts' );


/**
||-> Enqueue admin css/js
*/
function niva_enqueue_admin_scripts( $hook ) {
    // JS
    wp_enqueue_script( "niva-admin-scripts", get_template_directory_uri().'/js/niva-admin-scripts.js' , array( 'jquery' ) );
    // CSS
    wp_enqueue_style( "niva-admin-css", get_template_directory_uri().'/css/admin-style.css' );
}
add_action('admin_enqueue_scripts', 'niva_enqueue_admin_scripts');


/**
||-> Enqueue css to js_composer
*/
add_action( 'vc_base_register_front_css', 'niva_enqueue_front_css_foreever' );
function niva_enqueue_front_css_foreever() {
    wp_enqueue_style( 'js-composer-front' );
}


/**
||-> Enqueue css to redux
*/
function niva_register_fontawesome_to_redux() {
    wp_register_style( 'font-awesome', get_template_directory_uri().'/css/font-awesome.min.css', array(), time(), 'all' );  
    wp_enqueue_style( 'font-awesome' );
}
add_action( 'redux/page/redux_demo/enqueue', 'niva_register_fontawesome_to_redux' );


/**
||-> Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
*/
add_action( 'vc_before_init', 'niva_vcSetAsTheme' );
function niva_vcSetAsTheme() {
    vc_set_as_theme( true );
}


/**
||-> Other required parts/files
*/
/* ========= LOAD CUSTOM FUNCTIONS ===================================== */
require_once get_template_directory() . '/inc/custom-functions.php';
require_once get_template_directory() . '/inc/custom-functions.header.php';
require_once get_template_directory() . '/inc/custom-functions.footer.php';
require_once get_template_directory() . '/inc/custom-functions.gutenberg.php';
/* ========= Customizer additions. ===================================== */
require_once get_template_directory() . '/inc/customizer.php';
/* ========= Load Jetpack compatibility file. ===================================== */
require_once get_template_directory() . '/inc/jetpack.php';
/* ========= Include the TGM_Plugin_Activation class. ===================================== */
require_once get_template_directory() . '/inc/tgm/include_plugins.php';
/* ========= LOAD - REDUX - FRAMEWORK ===================================== */
require_once get_template_directory() . '/redux-framework/sweetthemes-config.php';
/* ========= CUSTOM COMMENTS ===================================== */
require_once get_template_directory() . '/inc/custom-comments.php';
/* ========= THEME DEFAULTS ===================================== */
require_once get_template_directory() . '/inc/theme-defaults.php';


/**
||-> add_image_size //Resize images
*/
/* ========= RESIZE IMAGES ===================================== */
add_image_size( 'niva_related_post_pic700x300', 700, 300, true );
add_image_size( 'niva_post_widget_pic100x100',  100, 100, true );
add_image_size( 'niva_about_625x415',           625, 415, true );
add_image_size( 'niva_listing_archive_featured_square',    600, 370, true );
add_image_size( 'niva_listing_archive_featured',    800, 500, true );
add_image_size( 'niva_listing_archive_thumbnail',   300, 180, true );
add_image_size( 'niva_listing_single_featured',     1200, 200, true );
add_image_size( 'niva_breadcrumbs',     1500, 255, true );
// Blogloop-v2


// sweetthemes
add_image_size( 'niva_projects_listing', 600, 400, true );
add_image_size( 'niva_post_pic700x500', 700, 500, true );
add_image_size( 'niva_blog_900x550',  900, 450, true );
add_image_size( 'sweetthemes_post_widget_pic100x100',  150, 150, true );
add_image_size( 'sweetthemes_members',     600, 600, true );
/**
||-> LIMIT POST CONTENT
*/
function niva_excerpt_limit($string, $word_limit) {
    $words = explode(' ', $string, ($word_limit + 1));
    if(count($words) > $word_limit) {
        array_pop($words);
    }
    return implode(' ', $words);
}


/**
||-> BREADCRUMBS
*/
function niva_breadcrumb() {
    
    $delimiter = '';
    $html =  '';

    $name = esc_html__("Home", "niva");
    $currentBefore = '<li class="active">';
    $currentAfter = '</li>';
        $classes = get_body_class();
        if (!is_home() && !is_front_page() || is_paged()) {
            global  $post;
            $home = esc_url(home_url('/'));
            $html .= '<li><a href="' . esc_url($home) . '">' . esc_attr($name) . '</a></li> ' . esc_attr($delimiter) . '';
        if (is_category()) {
            global  $wp_query;
            $cat_obj = $wp_query->get_queried_object();
            $thisCat = $cat_obj->term_id;
            $thisCat = get_category($thisCat);
            $parentCat = get_category($thisCat->parent);
                if ($thisCat->parent != 0)
            $html .= (get_category_parents($parentCat, true, '' . esc_attr($delimiter) . ''));
            $html .= $currentBefore . single_cat_title('', false) . $currentAfter;
        }elseif (is_tax()) {
            global  $wp_query;
            $html .= $currentBefore . single_cat_title('', false) . $currentAfter;
        } elseif (is_day()) {
            $html .= '<li><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a></li> ' . esc_attr($delimiter) . '';
            $html .= '<li><a href="' . esc_url(get_month_link( get_the_time('Y'), get_the_time('m'))) . '">' . get_the_time('F') . '</a></li> ' . esc_attr($delimiter) . ' ';
            $html .= $currentBefore . get_the_time('d') . $currentAfter;
        } elseif (is_month()) {
            $html .= '<li><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a></li> ' . esc_attr($delimiter) . '';
            $html .= $currentBefore . get_the_time('F') . $currentAfter;
        } elseif (is_year()) {
            $html .= $currentBefore . get_the_time('Y') . $currentAfter;
        } elseif (is_attachment()) {
            $html .= $currentBefore;
            $html .= get_the_title();
            $html .= $currentAfter;
        } elseif (class_exists( 'WooCommerce' ) && is_shop()) {
            $html .= $currentBefore;
            $html .= esc_html__('Shop','niva');
            $html .= $currentAfter;
        } elseif (class_exists( 'WooCommerce' ) && is_product()) {

            global  $post;
            $cat = get_the_terms( $post->ID, 'product_cat' );
            foreach ($cat as $categoria) {
                if ($categoria) {
                    if($categoria->parent == 0){

                        // Get the ID of a given category
                        $category_id = get_cat_ID( $categoria->name );

                        // Get the URL of this category
                        $category_link = get_category_link( $category_id );

                        $html .= '<li><a href="'.esc_url('#').'">' . esc_attr($categoria->name) . '</a></li>';
                        $html .= esc_url($category_link);
                    }
                }
            }

            $html .= $currentBefore;
            $html .= get_the_title();
            $html .= $currentAfter;

        } elseif (is_single()) {
            if (get_the_category()) {
                $cat = get_the_category();
                $cat = $cat[0];
                $html .= '<li>' . get_category_parents($cat, true, ' ' . wp_kses_post($delimiter) . '') . '</li>';
            }
            $html .= $currentBefore;
            $html .= get_the_title();
            $html .= $currentAfter;
        } elseif (is_page() && !$post->post_parent) {
            $html .= $currentBefore;
            $html .= get_the_title();
            $html .= $currentAfter;
        } elseif (is_page() && $post->post_parent) {
            $parent_id = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . get_the_title($page->ID) . '</a></li>';
                $parent_id = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb)
                $html .= $crumb . ' ' . esc_attr($delimiter) . ' ';
            $html .= $currentBefore;
            $html .= get_the_title();
            $html .= $currentAfter;
        } elseif (is_search()) {
            $html .= $currentBefore . get_search_query() . $currentAfter;
        } elseif (is_tag()) {
            $html .= $currentBefore . single_tag_title( '', false ) . $currentAfter;
        } elseif (is_author()) {
            global  $author;
            $userdata = get_userdata($author);
            $html .= $currentBefore . $userdata->display_name . $currentAfter;
        } elseif (is_404()) {
            $html .= $currentBefore . esc_html__('404 Not Found','niva') . $currentAfter;
        }
    }

    return $html;
}


/**
||-> FUNCTION: ADD EDITOR STYLE
*/
function niva_add_editor_styles() {
    add_editor_style( 'css/custom-editor-style.css' );
}
add_action( 'admin_init', 'niva_add_editor_styles' );


/**
||-> SEARCH FOR POSTS ONLY
*/
if (!is_admin()) {
    function niva_search_filter($query) {
        if ($query->is_search && !isset($_GET['post_type'])) {
            if ( !function_exists('sweetthemes_framework')) {
                $query->set('post_type', 'post');
            }else{
                $query->set('post_type', 'post');
            }
        }
        return $query;
    }
    add_filter('pre_get_posts','niva_search_filter');
}


/**
||-> REMOVE PLUGINS NOTIFICATIONS and NOTICES
*/
// |---> REVOLUTION SLIDER
if(function_exists( 'set_revslider_as_theme' )){
    add_action( 'init', 'niva_disable_revslider_update_notices' );
    function niva_disable_revslider_update_notices() {
        set_revslider_as_theme();
    }
}

// |---> Custom search article
function niva_search_form( $form ) {
    $form = '<form role="search" method="get" class="search-form" action="' . esc_url(home_url( '/' )) . '" >
    <label><input type="text" class="search-field" placeholder="'.esc_attr__('Search ...','niva').'" name="s" id="s" /></label>
    <button type="submit" class="search-submit"><i class="fa fa-search" aria-hidden="true"></i></button>
    </form>';
    return $form;
}
add_filter( 'get_search_form', 'niva_search_form', 100 );

function niva_post_nav() {
    global $post;

    // Don't print empty markup if there's nowhere to navigate.
    $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
    $next     = get_adjacent_post( false, '', false );

    if ( ! $next && ! $previous )
        return;

    ?>
    <?php $prev_link = get_previous_post_link( '%link', esc_html__( '%title', 'niva' ) ); ?>
    <?php $next_link = get_next_post_link( '%link', esc_html__( '%title', 'niva' ) ); ?>
    <div class="post-navigation<?php echo esc_attr(( (!empty($prev_link) || !empty($next_link) ) ? ' post-navigation-line':'' )); ?>">
        <?php if($prev_link):?>
            <div class="prev-post col-md-6 col-xs-12">
                <div class="navigation-thumbnail">
                    <a href="<?php echo esc_url(get_permalink( $previous->ID )); ?>">
                        <?php echo wp_kses_post(wp_get_attachment_image(get_post_thumbnail_id( $previous->ID ), array(150,150))); ?>
                    </a>
                </div>
                <div class="prev-post-content">
                    <a href="<?php echo esc_url(get_permalink( $previous->ID )); ?>"><span><?php echo esc_html_e('Previous Post','niva'); ?></span></a>
                    <?php echo wp_kses_post($prev_link); ?>
                </div>
            </div>
        <?php endif;?>
                
        <?php if(!empty($next_link)):?>
            <div class="next-post col-md-6 col-xs-12">
                <div class="navigation-thumbnail">
                    <a href="<?php echo esc_url(get_permalink( $next->ID )); ?>">
                        <?php echo wp_kses_post(wp_get_attachment_image(get_post_thumbnail_id( $next->ID ),  array(150,150))); ?> 
                    </a>
                </div>
                <div class="next-post-content">
                    <a href="<?php echo esc_url(get_permalink( $next->ID )); ?>"><span><?php echo esc_html_e('Next Post','niva'); ?></span></a>            
                    <?php echo wp_kses_post($next_link); ?>
                </div>        
            </div>
        <?php endif;?>
    </div>
    <?php
}

/**
 * Modify image width theme support.
 */
/* Increasse the image sizes */
function niva_iconic_modify_theme_support() {
    $theme_support = get_theme_support( 'woocommerce' );
    $theme_support = is_array( $theme_support ) ? $theme_support[0] : array();
 
    $theme_support['single_image_width'] = 1000;
    $theme_support['thumbnail_image_width'] = 1000;
 
    remove_theme_support( 'woocommerce' );
    add_theme_support( 'woocommerce', $theme_support );
}
 
add_action( 'after_setup_theme', 'niva_iconic_modify_theme_support', 100 );


/* Set products per page */
add_filter( 'loop_shop_per_page', 'niva_loop_shop_per_page', 20 );

function niva_loop_shop_per_page( $cols ) {
  $cols = 12;
  return $cols;
}

/* Woo cart menu ajax */
function niva_wc_cart_count() {
 
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
 
        $count_woo = WC()->cart->cart_contents_count;  ?>
        
        <a class="shop_cart" href="<?php echo esc_url(wc_get_cart_url()); ?>">
            <i class="fa fa-shopping-basket" aria-hidden="true"></i><span class="cart-contents-count"><?php echo esc_html( $count_woo ); ?></span>
        </a>

    <?php }
 
}
add_action( 'niva_header_top', 'niva_wc_cart_count' );


/**
 * Ensure cart contents update when products are added to the cart via AJAX
 */
function niva_my_header_add_to_cart_fragment( $fragments ) {
    ob_start();
    $count_woo = WC()->cart->cart_contents_count; ?>

    <a class="shop_cart" href="<?php echo esc_url(wc_get_cart_url()); ?>">
        <i class="fa fa-shopping-basket" aria-hidden="true"></i><span class="cart-contents-count"><?php echo esc_html( $count_woo ); ?></span>
    </a>

    <?php $fragments['a.shop_cart'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'niva_my_header_add_to_cart_fragment' );


// Remove cross-sells at cart
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

?>