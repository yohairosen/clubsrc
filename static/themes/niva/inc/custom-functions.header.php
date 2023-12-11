<?php
/**
CUSTOM HEADER FUNCTIONS
*/




/**
Function name:              niva_current_header_template()          
Function description:       Gets the current header variant from theme options. If page has custom options, theme options will be overwritten.
*/
function niva_current_header_template(){

    global  $niva;


    // PAGE METAS
    $custom_header_activated = get_post_meta( get_the_ID(), 'niva_custom_header_options_status', true );
    $header_v = get_post_meta( get_the_ID(), 'niva_header_custom_variant', true );
    $sidebar_headers = array('header6', 'header7', 'header14', 'header15');

    // THEME INIT
    $theme_init = new niva_init_class;

    $html = '';

    if (is_page() && $header_v) {
        if ($custom_header_activated && $custom_header_activated == 'yes') {
            if (!in_array($header_v, $sidebar_headers)){
                $html .= get_template_part( 'templates/template-'.esc_html($header_v) ); ?>

            <?php }else{ ?>

            <?php }
        }?>
    <?php }else{
        if (isset($niva['mt_header_layout'])) {
            if (!in_array($header_v, $sidebar_headers)){
                $html .= get_template_part( 'templates/template-'.esc_html($niva['mt_header_layout']) );
            }
        }else{
            $html .= get_template_part( 'templates/template-'.esc_html($theme_init->niva_get_header_variant()) );
        }
    }
    return $html;
}


/**
||-> FUNCTION: GET GOOGLE FONTS FROM THEME OPTIONS PANEL
*/

function niva_get_site_fonts(){
    global  $niva;
    $fonts_string = '';
    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        if (isset($niva['mt_google_fonts_select'])) {
            $i = 0;
            $len = count($niva['mt_google_fonts_select']);
            foreach(array_keys($niva['mt_google_fonts_select']) as $key){
                $font_url = str_replace(' ', '+', $niva['mt_google_fonts_select'][$key]);
                
                if ($i == $len - 1) {
                    // last
                    $fonts_string .= $font_url;
                }else{
                    $fonts_string .= $font_url . '|';
                }
                $i++;
            }
            // fonts url
            $fonts_url = add_query_arg( 'family', $fonts_string, "//fonts.googleapis.com/css" );
            // enqueue fonts
            wp_enqueue_style( 'niva-fonts', $fonts_url, array(), '1.0.0' );
        }
    } else {
        $font_url = str_replace(' ', '+', 'Poppins:300,regular,500,600,700,latin-ext,latin,devanagari');
        $fonts_url = add_query_arg( 'family', $font_url, "//fonts.googleapis.com/css" );
        wp_enqueue_style( 'niva-fonts-fallback', $fonts_url, array(), '1.0.0' );
    }
}
add_action('wp_enqueue_scripts', 'niva_get_site_fonts');


// Add specific CSS class by filter
if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
    if ( function_exists('sweetthemes_framework')) {
        add_filter( 'body_class', 'niva_body_classes' );
        function niva_body_classes( $classes ) {

            global  $niva;
            $theme_init = new niva_init_class;

            $plugin_redux_status = '';
            if ( !class_exists( 'ReduxFrameworkPlugin' ) ) {
                $plugin_redux_status = 'missing-redux-framework';
            } else {
                $plugin_redux_status = 'added-redux-framework';
            }
            $plugin_sweetthemes_status = '';
            if ( !function_exists('sweetthemes_framework')) {
                $plugin_sweetthemes_status = 'missing-sweetthemes-framework';
            }

            // POST META FOOTER STATUS
            $row1_status = get_post_meta( get_the_ID(), 'mt_footer_row1_status', true );
            $row2_status = get_post_meta( get_the_ID(), 'mt_footer_row2_status', true );
            $row3_status = get_post_meta( get_the_ID(), 'mt_footer_row3_status', true );
            $footer_bottom_bar = get_post_meta( get_the_ID(), 'mt_footer_bottom_bar', true );
            $mt_page_preloader_status = get_post_meta( get_the_ID(), 'mt_page_preloader_status', true );

            $footers_row1_status = '';
            $footers_row2_status = '';
            $footers_row3_status = '';
            $footers_status = '';
            $page_preloader_status = '';

            if (is_single() || is_page()) {
                # code...
                if ($row1_status == 'on') {
                    $footers_row1_status = 'footer_row1_off';
                }
                if ($row2_status == 'on') {
                    $footers_row2_status = 'footer_row2_off';
                }
                if ($row3_status == 'on') {
                    $footers_row3_status = 'footer_row3_off';
                }
                if ($footer_bottom_bar == 'on') {
                    $footers_status = 'footer_bottom_bar_off';
                }
                if ($mt_page_preloader_status == 'on') {
                    $page_preloader_status = 'page_preloader_off';
                }
            }



                    // CHECK IF FEATURED IMAGE IS FALSE(Disabled)
                    $post_featured_image = '';
                    if (is_singular('post')) {
                        if ($niva['mt_post_featured_image'] == false) {
                            $post_featured_image = 'hide_post_featured_image';
                        }else{
                            $post_featured_image = '';
                        }
                    }

                    // CHECK IF THE NAV IS STICKY
                    $is_nav_sticky = '';
                    if ($niva['mt_is_nav_sticky'] == true) {
                        // If is sticky
                        $is_nav_sticky = 'is_nav_sticky';
                    }else{
                        // If is not sticky
                        $is_nav_sticky = '';
                    }

                    // CHECK IF HEADER IS SEMITRANSPARENT
                    $semitransparent_header_meta = get_post_meta( get_the_ID(), 'mt_header_semitransparent', true );
                    $semitransparent_header = '';
                    if ($semitransparent_header_meta == 'enabled') {
                        // If is semitransparent
                        $semitransparent_header = 'is_header_semitransparent';
                    }

                    // CHECK IF PAGE IS DARK
                    $darkmode_on_off_meta = get_post_meta( get_the_ID(), 'darkmode_on_off', true );
                    $darkmode_on_off = '';
                    $rand_class_dark = "";
                    $rand_class_dark_1 = 'dark' . rand();
                    if ($darkmode_on_off_meta == 'yes') {
                        // If is semitransparent
                        $darkmode_on_off = 'page_dark';
                        $rand_class_dark = $rand_class_dark_1;
                    }

                    // DIFFERENT HEADER LAYOUT TEMPLATES
                    $header_status = get_post_meta( get_the_ID(), 'niva_custom_header_options_status', true );
                    $header_v = get_post_meta( get_the_ID(), 'niva_header_custom_variant', true );

                    
                    $header_version = $theme_init->niva_get_header_variant();
                    if (isset($header_status) && $header_status == 'yes') {
                        $header_version = $header_v;
                    }else{
                        if ($niva['mt_header_layout']) {
                            // Header Layout #1
                            $header_version = $niva['mt_header_layout'];
                        }
                    }


                    // HEADER NAVIGATION HOVER STYLE
                    $header_nav_hover = $theme_init->niva_navstyle_variant();
                    $header_nav_submenu_variant = $theme_init->niva_get_header_nav_submenu_variant();
                    $sidebar_widgets_variant = $theme_init->niva_get_sidebar_widgets_variant();

                    

                    $classes[] = esc_attr($header_nav_submenu_variant) . ' ' . esc_attr($sidebar_widgets_variant) . ' ' . esc_attr($plugin_sweetthemes_status) . ' ' . esc_attr($plugin_redux_status) . ' ' . esc_attr($header_nav_hover) . ' ' . esc_attr($page_preloader_status) . ' ' . esc_attr($footers_status) . ' ' . esc_attr($footers_row1_status) . ' ' . esc_attr($footers_row2_status) . ' ' . esc_attr($footers_row3_status) . ' ' . esc_attr($post_featured_image) . ' ' . esc_attr($is_nav_sticky) . ' ' . esc_attr($rand_class_dark). ' ' . esc_attr($header_version) . ' ' . esc_attr($darkmode_on_off) . ' ' . esc_attr($semitransparent_header) . ' ';

                    return $classes;




        }
    }
}

/**
||-> FUNCTION: GET DYNAMIC CSS
*/
add_action('wp_enqueue_scripts', 'niva_dynamic_css' );
function niva_dynamic_css(){

    $html = '';

    // THEME INIT
    $theme_init = new niva_init_class;

    // BEGIN: REVAMP SKIN COLORS ===============================================================================
    $skin_main_bg = $theme_init->niva_get_fallback_primary_color(); //Fallback primary background color
    $skin_main_bg_hover = $theme_init->niva_get_fallback_primary_color_hover(); //Fallback primary background hover color
    $skin_main_texts = $theme_init->niva_get_fallback_main_texts(); //Fallback main text color
    $skin_semitransparent_blocks = $theme_init->niva_get_fallback_semitransparent_blocks(); //Fallback semitransparent blocks
    // END: REVAMP SKIN COLORS ===============================================================================

    //PAGE PRELOADER 
    if ( function_exists('sweetthemes_framework')) {
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
            if (niva('mt_preloader_status') == true) {
                $html .= '
                    .pace-cover {
                        background-color: '.niva('mt_preloader_bg_color','background-color').';
                        background-image: url('.niva('mt_preloader_bg_color','background-image').');
                        background-position: '.niva('mt_preloader_bg_color','background-position').';
                     }
                    .pace-progress,
                    .pace-inactive, 
                    .pace-done .pace-cover,
                    .pace .pace-activity {
                        background: '.niva('mt_global_color').';
                    }';
            }

            $html .= '
                    .woocommerce button.button,
                    .woocommerce a.button,
                    .woocommerce nav.woocommerce-pagination ul li span.current,
                    .woocommerce nav.woocommerce-pagination ul li a::before,
                    .woocommerce nav.woocommerce-pagination ul li a:hover,
                    body .woocommerce-MyAccount-content .button,
                    .woocommerce ul.products li.product .woocommerce-product--list-meta::before,
                    .single-member .member_social span.social-holder-span a,
                    .woocommerce #review_form #respond .form-submit input,
                    .mt_members1 .flex-zone,
                    .pagination a.page-numbers::before {
                        background: '.niva('mt_global_color').' !important;
                    }

                    body.single-product .woocommerce-tabs ul.tabs>li a:hover, 
                    body.single-product .woocommerce-tabs ul.tabs>li.active a {
                        border-bottom-color: '.niva('mt_global_color').' !important;
                        color: '.niva('mt_global_color').' !important;
                    }
                
                    body.woocommerce ul.products li.product h2.woocommerce-loop-product__title a:hover,
                    body.woocommerce ul.products li.product .woocommerce_product__category a:hover,
                    .woocommerce ul.products li.product .button:hover, 
                    .woocommerce ul.products li.product a.added_to_cart.wc-forward:hover,
                    .single-member .member_position,
                    .single-member .member_email i, 
                    .single-member .member_phone i,
                    .single-member .areas_expertise_content h4,
                    .mt_members1 .member01_link:hover {
                        color: '.niva('mt_global_color').' !important;
                    }';
        }
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                    $html .= '
                    body .cd-tab-filter a.selected,
                    .iconfilter-shortcode .project_cat_title_overlay,
                    .mt_members1 .flex-zone,
                    body .owl-theme .owl-controls .owl-page.active span,
                    footer .social-links a,
                    body .blogloop-v2.list-view .post-date,
                    article.sticky:after,
                    .sidebar-content.col-md-4 .widget .widget-title,
                    .list-view .post-details .post-excerpt .more-link,
                    footer .mc4wp-form-fields button,
                    .projects-posts-list-shortcode .col-project .project_cat_title_overlay,
                    .blog-posts-shortcode.blog-posts .list-view .blog_custom .post-categories,
                    .blog-posts-shortcode .featured_image_blog:hover .flex-icon,
                    body .progress-bar-success,
                    body .sidebar-content .tagcloud > a:hover,
                    .sweetthemes-pricing-vers4 .cd-pricing-switcher .cd-switch,
                    #commentform .form-submit button {
                        background: '.niva('mt_global_color').' !important;
                    }

                    .no-touch .cd-tab-filter a:hover,
                    .cd-tab-filter a:hover {
                        color: '.niva('mt_global_color').';
                    }

                    @media only screen and (max-width: 767px) {
                        body header #navbar .menu-item > a {
                            background: '.niva('mt_global_color').' !important;
                        }
                    }
                
                    .dark_title,
                    footer .social-links a:hover i,
                    .list-view .post-details .post-category-comment-date span > i,
                    .tweet-content i,
                    .projects-posts-list-shortcode .projects-listing a.active, .projects-posts-list-shortcode .projects-listing a:hover,
                    body .blog-posts-shortcode.blog-posts .list-view .post-details .post-name a:hover,
                    .single-st_projects h4.portfolio-name a:hover,
                    .single-st_projects .portfolio-posted-in a:hover,
                    .post-category-comment-date i,
                    .sidebar-content .custom-html-widget a.html-widget-link:hover,
                    .widget_sweetthemes_recent_entries_with_thumbnail li:hover a,
                    body .fixed-sidebar-menu .left-side .social-links li:hover *,
                    .parent-typed-text .mt_typed_text, .parent-typed-text .typed-cursor,
                    .header2 header .right-side-social-actions li:hover i,
                    .owl-theme .owl-controls.clickable .owl-buttons div:hover,
                    .mt-icon-listgroup-item .mt-icon-listgroup-holder .mt-icon-listgroup-title:hover,
                    body .portfolio-bottom-description a:hover,
                    .post-tags-single i,
                    .social-sharer li:hover a,
                    .post-navigation .prev-post span, 
                    .post-navigation .next-post span,
                    .post-navigation .prev-post a:hover, 
                    .post-navigation .next-post a:hover,
                    .comment_body .reply_button,
                    body .comment-edit-link:hover, .comment-reply-link:hover, 
                    body .comment-edit-link:focus, .comment-reply-link:focus {
                        color: '.niva('mt_global_color').' !important;
                    }

                    footer .mc4wp-form-fields input[type="email"]:focus,
                    footer .mc4wp-form-fields button {
                        border-color: '.niva('mt_global_color').' !important;
                    }

                    body .vivus-icon svg path {
                        stroke: '.niva('mt_global_color').' !important;
                    }

                    .sidebar-content .widget_recent_comments li::before, 
                    .sidebar-content .widget_pages li::before, 
                    .sidebar-content .widget_meta li::before, 
                    .sidebar-content .widget_categories li::before, 
                    .sidebar-content .widget_archive li::before, 
                    .sidebar-content .widget_nav_menu li::before, 
                    .widget_recent_entries li::before, .widget_rss li::before {
                        color: '.niva('mt_global_color').' !important;
                    }
                    ';

        }
        //GLOBAL COLOR
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
            $html .= '
                    .header2 header .right-side-social-actions .phone-menu a,
                    #mt-nav-burger span {
                        background: '.niva('mt_global_color').';
                    }
                    .header2 header .right-side-social-actions .mt-search-icon i {
                        color: '.niva('mt_global_color').' !important;
                    }';
        }
    } //close sweetthemes_framework
    // HEADER SEMITRANSPARENT - METABOX
    $custom_header_activated = get_post_meta( get_the_ID(), 'niva_custom_header_options_status', true );
    $mt_header_custom_bg_color = get_post_meta( get_the_ID(), 'mt_header_custom_bg_color', true );
    $mt_header_custom_link_color = get_post_meta( get_the_ID(), 'mt_header_custom_link_color', true );
    $mt_header_semitransparent = get_post_meta( get_the_ID(), 'mt_header_semitransparent', true );
    if (isset($mt_header_semitransparent) == 'enabled') {
        $mt_header_semitransparentr_rgba_value = get_post_meta( get_the_ID(), 'mt_header_semitransparentr_rgba_value', true );
        $mt_header_semitransparentr_rgba_value_scroll = get_post_meta( get_the_ID(), 'mt_header_semitransparentr_rgba_value_scroll', true );
        
        if (isset($mt_header_custom_bg_color)) {
            list($r, $g, $b) = sscanf($mt_header_custom_bg_color, "#%02x%02x%02x");
        }else{
            $hexa = '#04ABE9'; //Theme Options Color
            list($r, $g, $b) = sscanf($hexa, "#%02x%02x%02x");
        }

        if(!empty($mt_header_semitransparentr_rgba_value) || !empty($mt_header_semitransparentr_rgba_value_scroll)) {
            $html .= '
            .is_header_semitransparent .navbar-default .container{
                background: rgba('.esc_attr($r).', '.esc_attr($g).', '.esc_attr($b).', '.esc_attr($mt_header_semitransparentr_rgba_value).') none repeat scroll 0 0;
            }
            .is_header_semitransparent .sticky-wrapper.is-sticky .navbar-default .container{
                background: rgba('.esc_attr($r).', '.esc_attr($g).', '.esc_attr($b).', '.esc_attr($mt_header_semitransparentr_rgba_value_scroll).') none repeat scroll 0 0;
            }';
        }

    }

    // THEME OPTIONS STYLESHEET

    // SOCIAL MEDIA ICONS (Header + Footer) - CUSTOM STYLING
    if ( function_exists('sweetthemes_framework')) {
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
            if (niva('mt_social_custom_styling') == true) {
                 $html .= 'footer .social-links a i {
                                color: '.niva('mt_social_custom_styling_color').';
                           }
                           footer .social-links a {
                                border-color: '.niva('mt_social_custom_styling_color').' !important;
                           }
                           footer .social-links a:hover i {
                                color: '.niva('mt_social_custom_styling_color_hover').';
                           }
                           footer .social-links a:hover {
                                border-color: '.niva('mt_social_custom_styling_color_hover').' !important;
                           }';
            }
        }
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
            // BACK TO TOP - CUSTOM STYLING
            if (niva('mt_backtotop_status') == true) {
                $html .= '.back-to-top {
                                color: '.niva('mt_backtotop_text_color').';
                            }
                            .back-to-top:hover {
                                color: '.niva('mt_backtotop_text_color_hover').';
                            }';
                }
        }
        // BACK TO TOP - CUSTOM STYLING
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
            if (niva('mt_backtotop_status') == true) {
                $html .= '.back-to-top {
                                background: '.esc_html($skin_main_bg).';
                            }
                            .back-to-top:hover {
                                background: '.esc_html($skin_main_bg_hover).';
                            }';
                }
        }
    } //close sweetthemes_framework
    // FALLBACKS for REDUX FRAMEWORK
    $breadcrumbs_delimitator = '|';
    $logo_max_width = '200';
    $text_selection_color = '#ffffff';
    $body_global_bg = '#ffffff';
    // REDUX FRAMEWORK CONDITIONS
    if ( function_exists('sweetthemes_framework')) {
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
            $breadcrumbs_delimitator = niva('mt_breadcrumbs_delimitator');
            $logo_max_width = niva('mt_logo_max_width');
            $text_selection_color = niva('mt_text_selection_color');
            $body_global_bg = niva('mt_body_global_bg');
        }
        // THEME OPTIONS STYLESHEET - Responsive SmartPhones
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        $html .= '.single article .article-content p,
                   p,
                   .post-excerpt{
                        font-size: '.niva('mt_single_post_typography','font-size').';
                        line-height: '.niva('mt_single_post_typography','line-height').';
                        font-family: '.niva('mt_single_post_typography','font-family').';
                        color: '.niva('mt_single_post_typography','color').';
                   }
                   body{
                        font-family: '.niva('mt_body_typography','font-family').';
                   }
                   h1,
                   h1 span {
                        font-family: "'.niva('mt_heading_h1','font-family').'";
                        font-size: '.niva('mt_heading_h1','font-size').';
                   }
                   h2 {
                        font-family: "'.niva('mt_heading_h2','font-family').'";
                        font-size: '.niva('mt_heading_h2','font-size').';
                   }
                   h3 {
                        font-family: "'.niva('mt_heading_h3','font-family').'";
                        font-size: '.niva('mt_heading_h3','font-size').';
                   }
                   h4 {
                        font-family: "'.niva('mt_heading_h4','font-family').'";
                        font-size: '.niva('mt_heading_h4','font-size').';
                   } 
                   h5 {
                        font-family: "'.niva('mt_heading_h5','font-family').'";
                        font-size: '.niva('mt_heading_h5','font-size').';
                   } 
                   h6 {
                        font-family: "'.niva('mt_heading_h6','font-family').'";
                        font-size: '.niva('mt_heading_h6','font-size').';
                   } 
                   input,
                   textarea {
                        font-family: '.niva('mt_inputs_typography','font-family').';
                   }  
                   input[type="submit"] {
                        font-family: '.niva('mt_buttons_typography','font-family').';
                   } 
        ';
        // THEME OPTIONS STYLESHEET - Responsive SmartPhones
        $html .= '
                    @media only screen and (max-width: 767px) {
                        .single article .article-content p,
                        p,
                        .post-excerpt{
                            font-size: '.niva('mt_heading_paragraphs_tablets','font-size').' !important;
                            line-height: '.niva('mt_heading_paragraphs_tablets','line-height').' !important;
                       }
                        body h1,
                        body h1 span{
                            font-size: '.niva('mt_heading_h1_smartphones', 'font-size').' !important;
                            line-height: '.niva('mt_heading_h1_smartphones', 'line-height').' !important;
                        }
                        body h2{
                            font-size: '.niva('mt_heading_h2_smartphones', 'font-size').' !important;
                            line-height: '.niva('mt_heading_h2_smartphones', 'line-height').' !important;
                        }
                        body h3{
                            font-size: '.niva('mt_heading_h3_smartphones', 'font-size').' !important;
                            line-height: '.niva('mt_heading_h3_smartphones', 'line-height').' !important;
                        }
                        body h4{
                            font-size: '.niva('mt_heading_h4_smartphones', 'font-size').' !important;
                            line-height: '.niva('mt_heading_h4_smartphones', 'line-height').' !important;
                        }
                        body h5{
                            font-size: '.niva('mt_heading_h5_smartphones', 'font-size').' !important;
                            line-height: '.niva('mt_heading_h5_smartphones', 'line-height').' !important;
                        }
                        body h6{
                            font-size: '.niva('mt_heading_h6_smartphones', 'font-size').' !important;
                            line-height: '.niva('mt_heading_h6_smartphones', 'line-height').' !important;
                        }
                    }
                    ';
        }

        // THEME OPTIONS STYLESHEET - Responsive Tablets
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        $html .= '
                    @media only screen and (min-width: 768px) and (max-width: 1024px) {
                        .single article .article-content p,
                        p,
                        .post-excerpt{
                            font-size: '.niva('mt_heading_paragraphs_smartphones','font-size').' !important;
                            line-height: '.niva('mt_heading_paragraphs_smartphones','line-height').' !important;
                       }
                        body h1,
                        body h1 span{
                            font-size: '.niva('mt_heading_h1_tablets', 'font-size').' !important;
                            line-height: '.niva('mt_heading_h1_tablets', 'line-height').' !important;
                        }
                        body h2{
                            font-size: '.niva('mt_heading_h2_tablets', 'font-size').' !important;
                            line-height: '.niva('mt_heading_h2_tablets', 'line-height').' !important;
                        }
                        body h3{
                            font-size: '.niva('mt_heading_h3_tablets', 'font-size').' !important;
                            line-height: '.niva('mt_heading_h3_tablets', 'line-height').' !important;
                        }
                        body h4{
                            font-size: '.niva('mt_heading_h4_tablets', 'font-size').' !important;
                            line-height: '.niva('mt_heading_h4_tablets', 'line-height').' !important;
                        }
                        body h5{
                            font-size: '.niva('mt_heading_h5_tablets', 'font-size').' !important;
                            line-height: '.niva('mt_heading_h5_tablets', 'line-height').' !important;
                        }
                        body h6{
                            font-size: '.niva('mt_heading_h6_tablets', 'font-size').' !important;
                            line-height: '.niva('mt_heading_h6_tablets', 'line-height').' !important;
                        }
                    }
                    ';
        }
    } //close sweetthemes_framework

    // THEME OPTIONS STYLESHEET
    $html .= '.breadcrumb a::after {
                  content: "'.$breadcrumbs_delimitator.'";
            }
            body{
                background: '.esc_html($body_global_bg).';
            }
            .logo img,
            .navbar-header .logo img {
                max-width: '.esc_html($logo_max_width).'px;
            }
            ::selection{
                color: '.esc_html($text_selection_color).';
                background: '.esc_html($skin_main_bg).';
            }
            ::-moz-selection { /* Code for Firefox */
                color: '.esc_html($text_selection_color).';
                background: '.esc_html($skin_main_bg).';
            }

            a,
            a:visited{
                color: '.esc_html($skin_main_bg).';
            }
            a:focus,
            a:hover{
                color: '.esc_html($skin_main_bg_hover).';
            }

            /*------------------------------------------------------------------
                COLOR
            ------------------------------------------------------------------*/
            a, 
            span.amount,
            .widget_popular_recent_tabs .nav-tabs li.active a,
            .widget_product_categories .cat-item:hover,
            .widget_product_categories .cat-item a:hover,
            .widget_archive li:hover,
            .widget_archive li a:hover,
            .widget_categories .cat-item:hover,
            .widget_categories li a:hover,
            .pricing-table.recomended .button.solid-button, 
            .pricing-table .table-content:hover .button.solid-button,
            .pricing-table.Recommended .button.solid-button, 
            .pricing-table.recommended .button.solid-button, 
            #sync2 .owl-item.synced .post_slider_title,
            #sync2 .owl-item:hover .post_slider_title,
            #sync2 .owl-item:active .post_slider_title,
            .pricing-table.recomended .button.solid-button, 
            .pricing-table .table-content:hover .button.solid-button,
            .testimonial-author,
            .testimonials-container blockquote::before,
            .testimonials-container blockquote::after,
            .post-author > a,
            h2 span,
            label.error,
            .author-name,
            .prev-next-post a:hover,
            .prev-text,
            .wpb_button.btn-filled:hover,
            .next-text,
            .social ul li a:hover i,
            .wpcf7-form span.wpcf7-not-valid-tip,
            .text-dark .statistics .stats-head *,
            .wpb_button.btn-filled,
            .widget_meta a:hover,
            .widget_pages a:hover,
            .blogloop-v1 .post-name a:hover,
            .blogloop-v2 .post-name a:hover,
            .blogloop-v3 .post-name a:hover,
            .blogloop-v4 .post-name a:hover,
            .blogloop-v5 .post-name a:hover,
            .post-category-comment-date span a:hover,
            .list-view .post-details .post-category-comment-date a:hover,
            .simple_sermon_content_top h4,
            .page_404_v1 h1,
            .widget_recent_comments li:hover a,
            .list-view .post-details .post-name a:hover,
            .blogloop-v5 .post-details .post-sticky-label i,
            header.header2 .header-info-group .header_text_title strong,
            footer .widget_nav_menu li::before,
            .widget_recent_entries_with_thumbnail li:hover a,
            .widget_recent_entries li a:hover,
            .blogloop-v1 .post-details .post-sticky-label i,
            .blogloop-v2 .post-details .post-sticky-label i,
            .blogloop-v3 .post-details .post-sticky-label i,
            .blogloop-v4 .post-details .post-sticky-label i,
            .blogloop-v5 .post-details .post-sticky-label i,
            .error-404.not-found h1,
            .action-expand::after,
            .list-view .post-details .post-excerpt .more-link:hover,
            .header4 header .right-side-social-actions .social-links a:hover i,
            .sidebar-content .widget_nav_menu li a:hover,
            .jobs-container-1 h3.name-test,
            .title1-holder .title1-name span::before{
                color: '.esc_html($skin_main_bg).';
            }


            /* NAVIGATION */
            .navstyle-v8.header3 #navbar .menu > .menu-item.current-menu-item > a, 
            .navstyle-v8.header3 #navbar .menu > .menu-item:hover > a,
            .navstyle-v1.header3 #navbar .menu > .menu-item:hover > a,
            .navstyle-v1.header2 #navbar .menu > .menu-item:hover > a,
            .navstyle-v4 #navbar .menu > .menu-item.current-menu-item > a,
            .navstyle-v4 #navbar .menu > .menu-item:hover > a,
            .navstyle-v3 #navbar .menu > .menu-item.current-menu-item > a, 
            .navstyle-v3 #navbar .menu > .menu-item:hover > a,
            .navstyle-v3 #navbar .menu > .menu-item > a::before, 
            .navstyle-v3 #navbar .menu > .menu-item > a::after,
            .navstyle-v2 #navbar .menu > .menu-item.current-menu-item > a,
            .navstyle-v2 #navbar .menu > .menu-item:hover > a{
                color: '.esc_html($skin_main_bg).';
            }
            .nav-submenu-style1 #navbar .sub-menu .menu-item.selected > a, 
            .nav-submenu-style1 #navbar .sub-menu .menu-item:hover > a,
            .navstyle-v2.header3 #navbar .menu > .menu-item > a::before,
            .navstyle-v2.header3 #navbar .menu > .menu-item > a::after,
            .navstyle-v8 #navbar .menu > .menu-item > a::before,
            .navstyle-v7 #navbar .menu > .menu-item .sub-menu > .menu-item > a:hover,
            .navstyle-v7 #navbar .menu > .menu-item.current_page_item > a,
            .navstyle-v7 #navbar .menu > .menu-item.current-menu-item > a,
            .navstyle-v7 #navbar .menu > .menu-item:hover > a,
            .navstyle-v6 #navbar .menu > .menu-item.current_page_item > a,
            .navstyle-v6 #navbar .menu > .menu-item.current-menu-item > a,
            .navstyle-v6 #navbar .menu > .menu-item:hover > a,
            .navstyle-v5 #navbar .menu > .menu-item.current_page_item > a, 
            .navstyle-v5 #navbar .menu > .menu-item.current-menu-item > a,
            .navstyle-v5 #navbar .menu > .menu-item:hover > a,
            .navstyle-v2 #navbar .menu > .menu-item > a::before, 
            .navstyle-v2 #navbar .menu > .menu-item > a::after{
                background: '.esc_html($skin_main_bg).';
            }';
            if(!empty($mt_header_custom_link_color)) {
                $html .= '
                .header2 #sweetthemes-main-head #navbar .menu-item > a {
                    color: '.esc_html($mt_header_custom_link_color).';
                }';
            }
            $html .= '
            /* Color Dark / Hovers */
            .related-posts .post-name:hover a{

                color: '.esc_html($skin_main_bg_hover).';
            }

            /*------------------------------------------------------------------
                BACKGROUND + BACKGROUND-COLOR
            ------------------------------------------------------------------*/
            .sweetthemes-icon-search,
            .wpb_button::after,
            .rotate45,
            .latest-posts .post-date-day,
            .latest-posts h3, 
            .latest-tweets h3, 
            .latest-videos h3,
            .button.solid-button, 
            button.vc_btn,
            .pricing-table.recomended .table-content, 
            .pricing-table .table-content:hover,
            .pricing-table.Recommended .table-content, 
            .pricing-table.recommended .table-content, 
            .pricing-table.recomended .table-content, 
            .pricing-table .table-content:hover,
            .block-triangle,
            .owl-theme .owl-controls .owl-page span,
            body .vc_btn.vc_btn-blue, 
            body a.vc_btn.vc_btn-blue, 
            body button.vc_btn.vc_btn-blue,
            .pagination .page-numbers.current,
            .pagination a.page-numbers:hover,
            #subscribe > button[type=\'submit\'],
            .prev-next-post a:hover .rotate45,
            .masonry_banner.default-skin,
            .form-submit input,
            .member-header::before, 
            .member-header::after,
            .member-footer .social::before, 
            .member-footer .social::after,
            .subscribe > button[type=\'submit\'],
            .no-results input[type=\'submit\'],
            h3#reply-title::after,
            .newspaper-info,
            header.header1 .header-nav-actions .shop_cart,
            .categories_shortcode .owl-controls .owl-buttons i:hover,
            .widget-title:after,
            .title-subtile-holder .section-title::after,
            body.single-st_projects .post-name::after,
            h2.heading-bottom:after,
            .single .content-car-heading:after,
            .wpb_content_element .wpb_accordion_wrapper .wpb_accordion_header.ui-state-active,
            #primary .main-content ul li:not(.rotate45)::before,
            .wpcf7-form .wpcf7-submit,
            ul.ecs-event-list li span,
            #contact_form2 .solid-button.button,
            .details-container > div.details-item .amount, .details-container > div.details-item ins,
            .sweetthemes-search .search-submit,
            .pricing-table.recommended .table-content .title-pricing,
            .pricing-table .table-content:hover .title-pricing,
            .pricing-table.recommended .button.solid-button,
            #navbar ul.sub-menu li a:hover
            .blogloop-v5 .absolute-date-badge span,
            .post-category-date a[rel="tag"],
            .niva_preloader_holder,
            #navbar .mt-icon-list-item:hover,
            .sweetthemes-pagination.pagination .page-numbers.current,
            .pricing-table .table-content:hover .button.solid-button,
            footer .footer-top .menu .menu-item a::before,
            .blogloop-v4.list-view .post-date,
            .navbar-toggle .icon-bar,
            .back-to-top,
            .post-password-form input[type="submit"],
            .search-form input[type="submit"],
            .post-password-form input[type=\'submit\'],
            .jobs-container-1 a.btn_job,
            .st_clients_slider_v2 .slick-dots li.slick-active button:after,
            blockquote {
                background: '.esc_html($skin_main_bg).';
            }

            .sweetthemes-search.sweetthemes-search-open .sweetthemes-icon-search, 
            .no-js .sweetthemes-search .sweetthemes-icon-search,
            .sweetthemes-icon-search:hover,
            .latest-posts .post-date-month,
            .button.solid-button:hover,
            body .vc_btn.vc_btn-blue:hover, 
            body a.vc_btn.vc_btn-blue:hover, 
            .post-category-date a[rel="tag"]:hover,
            body button.vc_btn.vc_btn-blue:hover,
            .blogloop-v5 .absolute-date-badge span:hover,
            #contact_form2 .solid-button.button:hover,
            .subscribe > button[type=\'submit\']:hover,
            footer .mc4wp-form-fields input[type="submit"]:hover,
            .no-results.not-found .search-submit:hover,
            .no-results input[type=\'submit\']:hover,
            ul.ecs-event-list li span:hover,
            .pricing-table.recommended .table-content .price_circle,
            .pricing-table .table-content:hover .price_circle,
            #modal-search-form .modal-content input.search-input,
            .wpcf7-form .wpcf7-submit:hover,
            .form-submit input:hover,
            .blogloop-v4.list-view .post-date a:hover,
            .pricing-table.recommended .button.solid-button:hover,
            .search-form input[type="submit"]:hover,
            .error-return-home.text-center > a:hover,
            .pricing-table .table-content:hover .button.solid-button:hover,
            .post-password-form input[type="submit"]:hover,
            .navbar-toggle .navbar-toggle:hover .icon-bar,
            .back-to-top:hover,
            .post-password-form input[type=\'submit\']:hover {
                background: '.esc_html($skin_main_bg_hover).';
            }

            .flickr_badge_image a::after,
            .portfolio-hover,
            .pastor-image-content .details-holder,
            .item-description .holder-top,
            blockquote::before {
                background: '.esc_html($skin_semitransparent_blocks).';
            }

            /*------------------------------------------------------------------
                BORDER-COLOR
            ------------------------------------------------------------------*/
            .author-bio,
            .blockquote,
            .widget_popular_recent_tabs .nav-tabs > li.active,
            body .left-border, 
            body .right-border,
            body .member-header,
            body .member-footer .social,
            body .button[type=\'submit\'],
            .navbar ul li ul.sub-menu,
            .wpb_content_element .wpb_tabs_nav li.ui-tabs-active,
            #contact-us .form-control:focus,
            .sale_banner_holder:hover,
            .testimonial-img,
            .wpcf7-form input:focus, 
            .wpcf7-form textarea:focus,
            .header_search_form,
            .list-view .post-details .post-excerpt .more-link:hover{
                border-color: '.esc_html($skin_main_bg).';
            }
            .sidebar-content .widget_search .search-submit  {
                background: '.esc_html($skin_main_bg).' !important;
            }';
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                $html .= '.header2 header .right-side-social-actions .phone-menu a:before {
                    background: '.esc_html(niva('mt_style_main_backgrounds_color_hover')).' !important;
                }
                #navbar .menu > .menu-item > a::before {
                    background: '.esc_html(niva('mt_nav_menu_hover_color')).' !important;
                }';
            }

            $darkmode_on_off = get_post_meta( get_queried_object_id(), 'darkmode_on_off', true );
            $dark_primary_color = get_post_meta( get_queried_object_id(), 'dark_primary_color', true );
            $dark_header_transparent = get_post_meta( get_queried_object_id(), 'dark_header_transparent', true );
            $dark_header_sticky_bg = get_post_meta( get_queried_object_id(), 'dark_header_sticky_bg', true );
            $dark_header_links_color = get_post_meta( get_queried_object_id(), 'dark_header_links_color', true );
            $dark_preloader_bg = get_post_meta( get_queried_object_id(), 'dark_preloader_bg', true );
            $dark_custom_logo = get_post_meta( get_queried_object_id(), 'dark_custom_logo', true );


            
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                if ( function_exists('sweetthemes_framework')) {
                    if (isset($darkmode_on_off) && $darkmode_on_off == 'yes') {
                        
                        if (isset($dark_header_transparent) && $dark_header_transparent == 'on') {
                            $html .= 'body .navbar-default {
                                background-color: transparent !important;
                            }';
                        }

                        $html .= 'body.sticky .navbar-default {
                            background: '.$dark_header_sticky_bg.' !important;
                        }';

                        $html .= '.pace-cover {
                            background-color: '.$dark_preloader_bg.' !important;
                        }';

                        $html .= 'body #navbar .menu-item > a,
                        body #navbar ul:not(.sub-menu) > .menu-item:hover > a,
                        body .shop_cart_div .shop_cart,
                        header .social-links *,
                        header .social-links::after {
                            color: '.$dark_header_links_color.' !important;
                        }';

                        $html .= 'body #mt-nav-burger span,
                        body.is_header_semitransparent #mt-nav-burger span {
                            background: '.$dark_header_links_color.' !important;
                        }';

                        $html .= '.header2 header .right-side-social-actions .phone-menu a,
                        #navbar .menu > .menu-item > a::before,
                        body #navbar .menu > .menu-item > a::before, 
                        body.is_header_semitransparent #mt-nav-burger:hover span,
                        .back-to-top,
                        .services-slider .slick-dots li.slick-active button:after,
                        .st_clients_slider_v2 .slick-dots li.slick-active button:after,
                        .projects-slider-list .slick-dots li.slick-active button:after,
                        .contact_form__bottom button::before,
                         .header_mini_cart .button.wc-forward, 
                        .header_mini_cart .button.checkout,
                        footer .social-links a,
                        footer .mc4wp-form-fields button,
                        .projects-slider-list .slick-dots li button:after{
                            background: '.$dark_primary_color.' !important;
                        }';

                        $html .= 'body #navbar ul:not(.sub-menu) > .menu-item:hover > a,
                        .header2 header .right-side-social-actions li:hover i,
                        body .shop_cart_div .shop_cart:hover,
                        .parent-typed-text .typed-cursor,
                        .services-slider .services-col1 .service-name,
                        .projects-posts-list-shortcode .col-project h3.project_title,
                        .projects-posts-list-shortcode .col-project h5.project_cat a,
                        .page_dark .jobs-container-1 a.btn_job,
                        .jobs-container-1 h3.name-test,
                        .wpcf7-form span.wpcf7-not-valid-tip,
                        .contact_form__bottom button,
                         .tweet-content i,
                        footer .social-links a:hover i {
                            color: '.$dark_primary_color.' !important;
                        }';

                        $html .= 'body div.wpcf7-validation-errors, 
                        body div.wpcf7-acceptance-missing,
                        .wpcf7-form input:focus,
                        .wpcf7-form textarea:focus,
                        .contact_form__bottom button,
                        footer .social-links a,
                        footer .mc4wp-form-fields button {
                            border-color: '.$dark_primary_color.' !important;
                        }';

                        $html .= '@media only screen and (max-width: 767px) {
                            body header #navbar .menu-item > a {
                                background: '.$dark_primary_color.' !important;
                            }
                        }';

                        $html .= '.pace-cover {
                            background-image: url('.$dark_custom_logo.');
                        }';

                    } 
                }
            }

    wp_add_inline_style( 'niva-style', $html );
}
?>