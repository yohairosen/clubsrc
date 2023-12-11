<?php
/**
||-> Defining Default datas
*/
function niva_init_function( $key = null ){

    global  $niva;

	// Variable Initialization
    $niva_init = [];
    /* Blog Variant
    Choose from: blogloop-v5 */
    $niva_init['blog_variant'] = 'blogloop-v5';
    /* Header Variant 
    Choose from: header1, header2 */
    $niva_init['header_variant'] = 'header1';
    /* Footer Variant 
    Choose from: footer1, footer2 */
    $niva_init['footer_variant'] = 'footer1';
    /* Header Navigation Hover
    Choose from: navstyle-v1, navstyle-v2, navstyle-v3, navstyle-v4, navstyle-v5, navstyle-v6, navstyle-v7, navstyle-v8 */
    $niva_init['header_nav_hover'] = 'navstyle-v1';
    /* Header Navigation Submenus Variant
    Choose from: nav-submenu-style1, nav-submenu-style2 */
    $niva_init['header_nav_submenu_variant'] = 'nav-submenu-style2';
    /* Sidebar Widgets Defaults
    Choose from: widgets_v1, widgets_v2 */
    $niva_init['sidebar_widgets_variant'] = 'widgets_v1';
    /* 404 Template Variant
    Choose from: page_404_v1_center, page_404_v2_left */
    $niva_init['page_404_template_variant'] = 'page_404_v2_right';
    /* Default Styling
    Set a HEXA Color Code */
    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        $niva_init['fallback_primary_color'] = niva('mt_global_color');
    } else {
        $niva_init['fallback_primary_color'] = '#6022ea'; // Primary Color
    }
    $niva_init['fallback_primary_color_hover'] = '#000000'; // Primary Color - Hover
    $niva_init['fallback_main_texts'] = '#000000'; // Main Texts Color
    $niva_init['fallback_semitransparent_blocks'] = 'rgba(155, 89, 182, 0.7)'; // Semitransparent Blocks
    // The Condition
    if ( is_null($key) ){
        return $niva_init;
    } else if ( array_key_exists($key, $niva_init) ) {
        return $niva_init[$key];
    }
}
class niva_init_class{
    public function niva_get_blog_variant(){
        return niva_init_function('blog_variant');
    }
    public function niva_get_header_variant(){
        return niva_init_function('header_variant');
    }
    public function niva_get_footer_variant(){
        return niva_init_function('footer_variant');
    }
    public function niva_get_header_nav_hover(){
        return niva_init_function('header_nav_hover');
    }
    public function niva_get_header_nav_submenu_variant(){
        return niva_init_function('header_nav_submenu_variant');
    }
    public function niva_get_sidebar_widgets_variant(){
        return niva_init_function('sidebar_widgets_variant');
    }
    public function niva_get_page_404_template_variant(){
        return niva_init_function('page_404_template_variant');
    }
    public function niva_get_fallback_primary_color(){
        return niva_init_function('fallback_primary_color');
    }
    public function niva_get_fallback_primary_color_hover(){
        return niva_init_function('fallback_primary_color_hover');
    }
    public function niva_get_fallback_main_texts(){
        return niva_init_function('fallback_main_texts');
    }
    public function niva_get_fallback_semitransparent_blocks(){
        return niva_init_function('fallback_semitransparent_blocks');
    }
    // Blog Loop Variant
    public function niva_blogloop_variant(){
        if ( !class_exists( 'ReduxFrameworkPlugin' ) ) {
            $theme_init = new niva_init_class;
            return $theme_init->niva_get_blog_variant();
        }
    }
    // Navstyle Variant
    public function niva_navstyle_variant(){
    	if ( !class_exists( 'ReduxFrameworkPlugin' ) ) {
			$theme_init = new niva_init_class;
    		return $theme_init->niva_get_header_nav_hover();
    	}
    }
}
?>