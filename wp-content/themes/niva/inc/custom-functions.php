<?php


//GET HEADER TITLE/BREADCRUMBS AREA
function niva_header_title_breadcrumbs(){


    $css_inline = '';
    $default_image = esc_url(get_template_directory_uri().'/images/breadcumbs-section.jpg');
    $breadcrumbs_page_image = get_post_meta( get_the_ID(), 'breadcrumbs_page_image', true );
    $breadcrumbs_case_image = get_post_meta( get_the_ID(), 'breadcrumbs_case_image', true );

    if ( is_search() || is_category() || is_tag() || is_author() || is_archive() || is_home() ) {
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) { 
            if (niva('st_breadcrumbs_image_blog_templates','url')) {
                $css_inline = "background-image:url(".esc_url(niva('st_breadcrumbs_image_blog_templates','url')).");";
            } else {
                $css_inline = "background-image:url(".esc_url($default_image).");";
            }
        } else {
            $css_inline = "background-image:url(".esc_url($default_image).");";
        }
    }

    if ( is_single() ) {
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) { 
            if (niva('st_breadcrumbs_image_posts','url')) {
                $css_inline = "background-image:url(".esc_url(niva('st_breadcrumbs_image_posts','url')).");";
            } else {
                $css_inline = "background-image:url(".esc_url($default_image).");";
            }
        } else {
            $css_inline = "background-image:url(".esc_url($default_image).");";
        }
    }

    if ( class_exists( 'WooCommerce' ) && is_product() ) {
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) { 
            if (niva('st_breadcrumbs_product','url')) {
                $css_inline = "background-image:url(".esc_url(niva('st_breadcrumbs_product','url')).");";
            } else {
                $css_inline = "background-image:url(".esc_url($default_image).");";
            }
        } else {
                $css_inline = "background-image:url(".esc_url($default_image).");";
        }
    }

    if ( class_exists( 'WooCommerce' ) && is_shop() ) {
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) { 
            if (niva('st_breadcrumbs_shop_archive','url')) {
                $css_inline = "background-image:url(".esc_url(niva('st_breadcrumbs_shop_archive','url')).");";
            } else {
                $css_inline = "background-image:url(".esc_url($default_image).");";
            } 
        } else {
                $css_inline = "background-image:url(".esc_url($default_image).");";
        }
    }

    if ( is_page() || is_singular('member')) {
        if (!empty($breadcrumbs_page_image)) {
            $css_inline = "background-image:url(".esc_url($breadcrumbs_page_image).");";
        } else {
            $css_inline = "background-image:url(".esc_url($default_image).");";
        }
    }
    
    if ( is_singular('st_projects') ) {
        if (!empty($breadcrumbs_case_image)) {
            $css_inline = "background-image:url(".esc_url($breadcrumbs_case_image).");";

        } else {
            $css_inline = "background-image:url(".esc_url($default_image).");";

        }
    }

    $html = '';
    $html .= '<div class="header-title-breadcrumb relative">';
        $html .= '<div class="header-title-breadcrumb-overlay text-center" style="'.$css_inline.'">
                        <div class="container">
                            <div class="row">

                                <div class="col-md-12 col-sm-12 col-xs-12">';
                                    $classes = get_body_class();
                                    if (class_exists( 'WooCommerce' ) && is_product()) {
                                        $html .= '<h1>'.esc_html__( 'Shop', 'niva' ) . get_search_query().'</h1>';
                                    }elseif (class_exists( 'WooCommerce' ) && is_shop()) {
                                        $html .= '<h1>'.esc_html__( 'Shop', 'niva' ) . get_search_query().'</h1>';
                                    }elseif (is_singular('member')) {
                                        $html .= '<h1>'.esc_html__( 'Team', 'niva' ).'</h1>';
                                    }elseif (is_singular('st_projects')) {
                                        $html .= '<h1>'.esc_html__( 'Portfolio', 'niva' ) . '</h1>';
                                    }elseif (is_single()) {
                                        $html .= '<h1>'.esc_html__( 'Blog', 'niva' ) . get_search_query().'</h1>';
                                    }elseif (is_page()) {
                                        $html .= '<h1>'.get_the_title().'</h1>';
                                    }elseif (is_search()) {
                                        $html .= '<h1>'.esc_html__( 'Search Results for: ', 'niva' ) . get_search_query().'</h1>';
                                    }elseif (is_category()) {
                                        $html .= '<h1>'.esc_html__( 'Category: ', 'niva' ).' <span>'.single_cat_title( '', false ).'</span></h1>';
                                    }elseif (is_tag()) {
                                        $html .= '<h1>'.esc_html__( 'Tag Archives: ', 'niva' ) . single_tag_title( '', false ).'</h1>';
                                    }elseif (is_author() || is_archive()) {
                                        $html .= '<h1>'.get_the_archive_title() . get_the_archive_description().'</h1>';
                                    }elseif (is_home()) {
                                        $html .= '<h1>'.esc_html__( 'From the Blog', 'niva' ).'</h1>';
                                    }else {
                                        $html .= '<h1>'.get_the_title().'</h1>';
                                    }
                                    $html .= '<ol class="breadcrumb">'.niva_breadcrumb().'</ol>  
                                    
                                </div>';                                                           
                            $html .='</div> 
                        </div>
                    </div>';

    $html .= '</div>';
    $html .= '<div class="clearfix"></div>';

    return $html;
}

?>