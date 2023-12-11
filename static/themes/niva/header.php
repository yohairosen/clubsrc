<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php esc_attr(bloginfo( 'charset' )); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) { ?>
        <link rel="shortcut icon" href="<?php echo esc_url(niva('mt_favicon', 'url')); ?>">
    <?php } ?>
    <script type="text/javascript">window.paceOptions = { restartOnPushState: false, restartOnRequestAfter: false }</script>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php
    /**
    * Since WordPress 5.2
    */
    if ( function_exists( 'wp_body_open' ) ) {
        wp_body_open();
    }
    ?>

    <?php /* PAGE PRELOADER */ ?>
    <?php
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
            if(niva('mt_preloader_status') == true) {
                echo '<div class="pace-cover"></div>';
            } 
        }
    ?>


    <?php /* VARS */ ?>
    <?php 
    $below_slider_headers = array('header5', 'header6', 'header7', 'header8');
    $normal_headers = array('header1', 'header2', 'header3', 'header4');
    $custom_header_options_status = get_post_meta( get_the_ID(), 'niva_custom_header_options_status', true );
    $header_custom_variant = get_post_meta( get_the_ID(), 'niva_header_custom_variant', true );
    $header_layout = niva('mt_header_layout');
    if (isset($custom_header_options_status) && $custom_header_options_status == 'yes') {
        $header_layout = $header_custom_variant;
    }
    ?>

    <?php /* BURGER MENU */ ?>
    <?php if(niva('mt_header_fixed_sidebar_menu_status') == true){ ?>
        <!-- Fixed Sidebar Overlay -->
        <div class="fixed-sidebar-menu-overlay"></div>
        <!-- Fixed Sidebar Menu -->
        <div class="relative fixed-sidebar-menu-holder header7">
            <div class="fixed-sidebar-menu">
                <!-- Close Sidebar Menu + Close Overlay -->
                <div class="close-sidebar"></div>
                <!-- Sidebar Menu Holder -->
                <div class="header7 sidebar-content">
                    <!-- RIGHT SIDE -->
                    <div class="left-side">
                        <?php if (is_active_sidebar( niva('mt_header_fixed_sidebar') )) {
                            dynamic_sidebar( niva('mt_header_fixed_sidebar') ); 
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>


    <!-- PAGE #page -->
    <div id="page" class="hfeed site">
        <?php
            $page_slider = get_post_meta( get_the_ID(), 'select_revslider_shortcode', true );
            if (in_array($header_layout, $below_slider_headers)){
                // Revolution slider
                if (!empty($page_slider)) {
                    echo '<div class="theme_header_slider">';
                    echo do_shortcode('[rev_slider '.esc_attr($page_slider).']');
                    echo '</div>';
                }

                // Header template variant
                echo wp_kses_post(niva_current_header_template());
            }elseif (in_array($header_layout, $normal_headers)){
                // Header template variant
                echo wp_kses_post(niva_current_header_template());
                // Revolution slider
                if (!empty($page_slider)) {
                    echo '<div class="theme_header_slider">';
                    echo do_shortcode('[rev_slider '.esc_attr($page_slider).']');
                    echo '</div>';
                }
            }else{
                echo wp_kses_post(niva_current_header_template());
            }
        ?>