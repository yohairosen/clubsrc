<?php
/*
Plugin Name: Staff List
Plugin URI: https://abcfolio.com/wordpress-plugin-staff-list/
Description:  Easily create list of staff members. Add single pages, filters and menus.
Author: abcFolio
Author URI: https://www.abcfolio.com
Text Domain: staff-list
Domain Path: /languages/
License: GPL v3
Requires at least: 4.9
Requires PHP: 5.6
Version: 1.6.4
------------------------------------------------------------------------
Copyright 2009-2021 abcFolio.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see http://www.gnu.org/licenses.
*/


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'ABCF_Staff_List' ) ) {

final class ABCF_Staff_List {

    private static $instance;
    public $pluginSlug = 'abcfolio-staff-list';
    public $pluginVersion = '1.6.4';   
    public $prefix = 'abcfsl';

    public static function instance() {

            if ( ! isset( self::$instance ) && ! ( self::$instance instanceof ABCF_Staff_List ) ) {
                    self::$instance = new ABCF_Staff_List;
                    self::$instance->setup_constants();
                    self::$instance->includes();
                    self::$instance->setup_actions();
            }
            return self::$instance;
    }

    private function __construct (){}

     //Throw error on object clone. We don't want the object to be cloned.
    public function __clone() {
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'staff-list' ), '1.5' );
    }

    //Disable unserializing of the class
    public function __wakeup() {
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'staff-list' ), '1.5' );
    }

    private function setup_constants() {
        // Plugin Folder QPath
        if( ! defined( 'ABCFSL_PLUGIN_DIR' ) ){ define( 'ABCFSL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) ); }
        // Plugin Folder URL
        if ( ! defined( 'ABCFSL_PLUGIN_URL' ) ) { define( 'ABCFSL_PLUGIN_URL', plugin_dir_url( __FILE__ ) ); }
        // Plugin Root File QPath
        if ( ! defined( 'ABCFSL_PLUGIN_FILE' ) ){ define( 'ABCFSL_PLUGIN_FILE', __FILE__ ); }
        if ( ! defined( 'ABCFSL_ICONS_URL' ) ){ define( 'ABCFSL_ICONS_URL', trailingslashit(trailingslashit(ABCFSL_PLUGIN_URL) . 'images')); }
     }

    //Include required files
    private function includes() {
        
        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt-field.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt-mp.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt-fone.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt-img.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt-txt.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt-txt-field.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt-vcard.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt-addr.php';
        
        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt-list.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt-list-i.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt-spage.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt-icons.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt-groups.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt-txt-img.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt-date.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt-cats.php';
        
        require_once ABCFSL_PLUGIN_DIR . 'inc/db.php'; 
        require_once ABCFSL_PLUGIN_DIR . 'inc/db-all.php';       
        require_once ABCFSL_PLUGIN_DIR . 'inc/scripts.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/struct-data.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/img.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/paginator.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/class-paginator.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/txt.php';        
        require_once ABCFSL_PLUGIN_DIR . 'inc/spg-a-tag.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/util.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/post-types.php';
       
        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt-menu.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt-menu-az.php'; 
        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt-menu-cat.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/class-img-util.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/class-qr-img-builder.php';  

        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt-menu-cat-i.php';
        require_once ABCFSL_PLUGIN_DIR . 'inc/cnt-js-i.php';
        
        require_once ABCFSL_PLUGIN_DIR . 'library/abcfl-css.php';
        require_once ABCFSL_PLUGIN_DIR . 'library/abcfl-html.php';
        require_once ABCFSL_PLUGIN_DIR . 'library/abcfl-util.php'; 

        //require_once ABCFSL_PLUGIN_DIR . 'deprecated/inc.php'; 

        //if( $this->pluginSlug == 'abcfolio-staff-list' ) {
            require_once ABCFSL_PLUGIN_DIR . 'incf/shortcode.php';
            require_once ABCFSL_PLUGIN_DIR . 'incf/post-types.php';
        //}

        //=== ADMIN ==========================================
        if( is_admin() ) {
            require_once ABCFSL_PLUGIN_DIR . 'admin/admin-scripts.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/dba.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/autil.php'; 
            require_once ABCFSL_PLUGIN_DIR . 'admin/ajax-handlers.php'; 
            require_once ABCFSL_PLUGIN_DIR . 'admin/v-tabs.php'; 
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-tplate-optns-default.php';         
            require_once ABCFSL_PLUGIN_DIR . 'admin/cbos.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/admin-months.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/class-mbox-tplate.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/class-mbox-item.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/class-mbox-groups.php';
                      
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-tplate-staff-pg-cntrs.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-tplate-img.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-tplate-field-order.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-tplate-field.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-tplate-vcard.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-tplate-addr.php';            
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-tplate-field-mp.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-tplate-cbo-items.php'; 
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-tplate-icons.php'; 
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-tplate-staff-pg-layout.php';                   
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-tplate-spg-layout.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-tplate-spg-optns.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-tplate-staff-order.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-tplate-structured-data.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-tplate-shortcode.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-tplate-pgnt.php'; 
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-shortcode.php';   
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-item-tabs.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-item-text.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-item-mp.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-item-cbo.php'; 
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-item-fone.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-item-date.php';            
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-item-img.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-item-optns.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-item-icons.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-item-cats.php'; 
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-item-vcard.php'; 
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-item-addr.php';                      
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-groups-tabs.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-groups-layout.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-group-items.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/admin-default-tplate.php';            
            require_once ABCFSL_PLUGIN_DIR . 'admin/txt-admin.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/txt-aurl.php'; 
            require_once ABCFSL_PLUGIN_DIR . 'library/abcfl-input.php';
            require_once ABCFSL_PLUGIN_DIR . 'library/abcfl-mbox-save.php';
            require_once ABCFSL_PLUGIN_DIR . 'library/abcfl-autil.php';  
            
            require_once ABCFSL_PLUGIN_DIR . 'admin/class-mbox-az-menu.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/class-mbox-cat-menu.php';             
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-menu-az-items.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-menu-cat-items.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-menu-az-tabs.php';            
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-menu-cat-tabs.php';
            require_once ABCFSL_PLUGIN_DIR . 'admin/mbox-menu-layout.php'; 

            //if( $this->pluginSlug == 'abcfolio-staff-list' ) {
                require_once ABCFSL_PLUGIN_DIR . 'adminf/class-menu.php';
                require_once ABCFSL_PLUGIN_DIR . 'adminf/admin-tabs.php';
                require_once ABCFSL_PLUGIN_DIR . 'adminf/admin-help.php';
                require_once ABCFSL_PLUGIN_DIR . 'adminf/admin-quick-start.php';
                require_once ABCFSL_PLUGIN_DIR . 'adminf/mbox-tplate-optns.php';
                require_once ABCFSL_PLUGIN_DIR . 'adminf/mbox-tplate-staff-pg-layout.php';
                require_once ABCFSL_PLUGIN_DIR . 'adminf/mbox-tplate-fields.php';
            //}

            $mboxCATMenu = new ABCFSL_MBox_CAT_Menu();
            $mboxAZMenu = new ABCFSL_MBox_AZ_Menu();
            $mboxLst = new ABCFSL_MBox_List();
            $mboxLstItem = new ABCFSL_MBox_Item();                  
            $mboxGrps = new ABCFSL_MBox_Groups();
        }
    }
  
    //===================================================================
    private function setup_actions() {

        //add_action( 'plugins_loaded', array( $this, 'load_textdomain' ));
        add_action( 'init', array( $this, 'load_textdomain' ));
        //add_action( 'init', array( $this, 'add_author_support_to_posts' ));
        
        add_action( 'admin_print_styles-post-new.php', array( $this, 'action_remove_permalink' ), 1 );
        add_action( 'admin_print_styles-post.php', array( $this, 'action_remove_permalink' ), 1000 );
        add_action( 'load-edit.php', array( $this, 'action_add_custom_columns' ), 10, 2 );

        add_action( 'restrict_manage_posts', array( $this, 'add_filter_parent_tplate' ) );
        add_action( 'restrict_manage_posts', array( $this, 'add_filter_category' ), 10, 1 );
        add_filter( 'parse_query', array( $this, 'filter_by_parent_tplate') );

        add_filter( 'post_row_actions', array( $this, 'filter_remove_post_edit_links' ), 10, 1 );
        add_filter( 'query_vars', array( $this, 'filter_query_vars' ), 1 );
        add_filter('rewrite_rules_array', array( $this, 'filter_rewrite_rules' ), 1 );

        // Priority 20 sice WordPress SEO by Yoast uses priority 15. This filter should run after.
        //add_filter( 'pre_get_document_title', array( $this, 'filter_spage_wp_title' ), 20, 2 );
        add_filter( 'wpseo_title', array( $this, 'filter_spage_wp_title' ), 20, 2 );
        
        register_activation_hook( __FILE__, array( $this, 'activation' ) );

        global $wp_embed;
        add_filter( 'abcfsl_cnt', array( $wp_embed, 'run_shortcode' ), 8 );
        add_filter( 'abcfsl_cnt', array( $wp_embed, 'autoembed'     ), 8 );
        add_filter( 'abcfsl_cnt', 'wptexturize' );
        add_filter( 'abcfsl_cnt', 'convert_smilies' );
        add_filter( 'abcfsl_cnt', 'convert_chars' );        
        add_filter( 'abcfsl_cnt', 'shortcode_unautop' );
        add_filter( 'abcfsl_cnt', 'do_shortcode' );
        add_filter( 'abcfsl_cnt_wpautop', 'wpautop' );  
    }

    //-------------------------------------------------
    public function activation() {
        $this->add_caps( 'administrator' );
        $this->add_caps( 'editor' );
    }

    public function add_caps( $toRole ) {

        $role = get_role( $toRole );

        if ( ! is_null( $role ) ) {

            //Categories Menu
            $role->add_cap( 'staff_categories_editor' );

            // Taxonomy caps.
            $role->add_cap( 'manage_staff_categories' );
            $role->add_cap( 'assign_staff_categories' );

            //-Staff Members ---------------------------
            $role->add_cap( 'edit_staff_member');
            $role->add_cap( 'read_staff_member');
            $role->add_cap( 'read_staff_members');

            $role->add_cap( 'delete_staff_member' );
            $role->add_cap( 'edit_staff_members' );
            $role->add_cap( 'edit_others_staff_members' );

            $role->add_cap( 'publish_staff_members' );
            $role->add_cap( 'read_private_staff_members' );
            $role->add_cap( 'delete_staff_members' );

            $role->add_cap( 'delete_private_staff_members' );
            $role->add_cap( 'delete_published_staff_members' );
            $role->add_cap( 'delete_others_staff_members' );

            $role->add_cap( 'edit_private_staff_members' );
            $role->add_cap( 'edit_published_staff_members' );
        }
    }

    //== REWRITE ================================
    //staff-cp = staff custom process
    function filter_query_vars( $vars ){
        $vars[] = 'smid';
        $vars[] = 'vctid';
        $vars[] = 'staff-name';
        $vars[] = 'staff-page-no';
        $vars[] = 'staff-az';
        $vars[] = 'staff-category';
        $vars[] = 'staff-cp';        
      return $vars;
    }

    // PRETTY
    function filter_rewrite_rules( $rules ) {

        //'(.+?)(/[0-9]+)?/?$' => 'index.php?pagename=$matches[1]&staff-category=$matches[2]&page=$matches[3]'
        $newRules = array(
            'bio/([^/]+)/?$' => 'index.php?pagename=bio&staff-name=$matches[1]',
            'profile/([^/]+)/?$' => 'index.php?pagename=profile&staff-name=$matches[1]',
            'profil/([^/]+)/?$' => 'index.php?pagename=profil&staff-name=$matches[1]',
            'perfil/([^/]+)/?$' => 'index.php?pagename=perfil&staff-name=$matches[1]',
            'profilo/([^/]+)/?$' => 'index.php?pagename=profilo&staff-name=$matches[1]'
        );
        return $newRules + $rules;
    }

    //Yoast SEO. Page title filter. PRETTY
    function filter_spage_wp_title( $title ) {
        
        $ppPages = array( 'bio', 'profile', 'profil', 'perfil', 'profilo' );

        //Custom permalinks plugin. Adds custom page name to ppPages.
        $ppCustomPages = array();
        if( function_exists( 'abcfslcp_custom_page_names' )){
           $ppCustomPages = abcfslcp_custom_page_names();
           $ppPages = wp_parse_args( $ppCustomPages, $ppPages );
        }

        //Custom page title is appended to single page title. Works only when pretty permalink field is populated.
        if( is_page( $ppPages ) ){
            global $wp;
            $currentURL = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
            $nameStart = strpos( $currentURL, '&staff-name=' );

            if( $nameStart === false ){ return $title; }
            $staffName = substr( $currentURL, $nameStart + 12 );

            $sPgTitle = abcfsl_db_spg_title_by_pretty( $staffName );
            if( !empty( $sPgTitle ) ){
                    $title .= ' ' . $sPgTitle;
            }
        }

        return $title;
    }

    //== Staff Members - Admin Screen - Add template filter  =================
    function add_filter_parent_tplate() {

        global $typenow;
	    $postType = 'cpt_staff_lst_item';

        if ($typenow == $postType) {

                $pTplateID = intval(isset( $_GET['pTplateID'] ) ? esc_attr( $_GET['pTplateID'] ) : 0);

                $cboTplates = abcfsl_dba_cbo_tplates( abcfsl_txta(204) );
                $items = abcfl_input_cbo_get_options_strings( $cboTplates, $pTplateID );
                echo  '<select type="text" id="pTplateID" name="pTplateID" >' . $items . '</select>';
            }
    }

    function filter_by_parent_tplate( $query ) {

        if ( strpos($_SERVER[ 'REQUEST_URI' ], '/wp-admin/edit.php') !== false ) {

            if( is_admin() AND $query->query['post_type'] == 'cpt_staff_lst_item' ) {
                $pTplateID = isset( $_GET['pTplateID'] ) ? esc_attr( $_GET['pTplateID'] ) : 0;
                if( $pTplateID > 0 ){
                    $qv = &$query->query_vars;
                    $qv['post_parent'] = $pTplateID;
                }
            }
        }
    }

    //Staff admin table category filter. Single taxonomy (staff categories).
    function add_filter_category( $post_type ){

        if( 'cpt_staff_lst_item' !== $post_type ){ return; }

        $taxSlug = 'tax_staff_member_cat';
        $taxonomy = get_taxonomy( $taxSlug );
        $selected = '';
        // if the current page is already filtered, get the selected term slug
        $selected = isset( $_REQUEST[ $taxSlug ] ) ? $_REQUEST[ $taxSlug ] : '';
        // Render a dropdown
        wp_dropdown_categories( array(
            'show_option_all' =>  $taxonomy->labels->all_items,
            'taxonomy'        =>  $taxSlug,
            'name'            =>  $taxSlug,
            'orderby'         =>  'name',
            'value_field'     =>  'slug',
            'selected'        =>  $selected,
            'hierarchical'    =>  true,
            'show_count'      =>  1
        ) );
    }

    //=== CUSTOM COLUMNS ========================================================
   function action_add_custom_columns() {

        add_filter( 'manage_cpt_staff_lst_item_posts_columns', array( $this,'staff_columns_add') );
        add_action( 'manage_cpt_staff_lst_item_posts_custom_column', array( $this, 'staff_custom_column_render' ), 10, 2 );
        add_filter( 'manage_edit-cpt_staff_lst_item_sortable_columns', array( $this, 'staff_sortable_columns' ));
        add_action( 'pre_get_posts', array( $this, 'staff_columns_orderby'));

        add_filter( 'manage_cpt_staff_lst_posts_columns', array( $this,'add_template_columns'), 10 );
        add_action( 'manage_cpt_staff_lst_posts_custom_column', array( $this, 'render_template_columns' ), 10, 2 );
    }

    //== CUSTOM COLUMNS STAFF ==========================================
    function staff_columns_add($defaults) {

        //Admin table column names
        $defaults['menu_order'] = 'SortTxt' . abcfsl_txta(360); //Order
        $defaults['sort_text'] = abcfsl_txta(61);
        $defaults['tplate_name'] = abcfsl_txta(359); //Template
        $defaults['item_img'] = abcfsl_txta(27); //Image
        $defaults['post_id'] = 'ID';
        $defaults['post_modified'] = 'Modified';
        return $defaults;
    }

    function staff_custom_column_render( $column_name, $postID ) {

        $tplateName = '';
        if ( $column_name == 'tplate_name' ) {
            $parentID = wp_get_post_parent_id( $postID );
            if($parentID){
                $parent = get_post($parentID);
                if($parent){ $tplateName = $parent->post_title; }
            }
        }
        echo $tplateName;
        //----------------------------------
        $sortTxt = '';
        if ( $column_name == 'sort_text' ) {
            $sortTxt = get_post_meta( $postID, '_sortTxt', true );
        }
        echo $sortTxt;
        //----------------------------------

        if ($column_name == 'item_img') {
            $imgUrl = get_post_meta( $postID, '_imgUrlL', true );
            echo abcfl_html_img_tag('', $imgUrl, '', '', 60);            
        }

        if ($column_name == 'menu_order') { echo get_post_field( 'menu_order', $postID ); }
        //if ($column_name == 'post_parent') {  echo get_post_field( 'post_parent', $postID ); }
        if ($column_name === 'post_id'){ echo $postID; }

        //if ($column_name == 'post_modified') {  echo 'Modified </br>' .  get_the_modified_date('Y-m-d h:i', $postID); }  
        if ($column_name == 'post_modified') {  echo get_the_modified_date('Y-m-d h:i', $postID); }  
    }

    function staff_sortable_columns( $columns ) {      
        $columns[ 'menu_order' ] = 'menu_order';
        $columns[ 'post_modified' ] = 'post_modified';
        return $columns;
     }

    function staff_columns_orderby( $query ) {

        if( ! is_admin() ){  return; }    

        $postType = $query->get('post_type');
 
        if ( $postType == 'cpt_staff_lst_item') {

            $orderBy = $query->get( 'orderby');
            $order = $query->get( 'order');

            if ( $orderBy == '' ) {
                $query->set( 'orderby', array( 'post_parent' => 'ASC', 'title' => 'ASC',  ));
                return;
            }
            if ( $orderBy == 'title' ) {
                    $query->set( 'orderby', array( 'post_parent' => 'ASC', 'title' => 'ASC',  ));
                    return;
            }
            if ( $orderBy == 'menu_order' ) {
                if ( $order == 'asc' ) {
                    $query->set( 'orderby', array( 'post_parent' => 'ASC', 'menu_order' => 'ASC' ) );
                    return;
                }
                else{
                    $query->set( 'orderby', array( 'post_parent' => 'ASC', 'menu_order' => 'DESC' ) );
                    return;
                }
            }
            if ( $orderBy == 'post_modified' ) {
                if ( $order == 'asc' ) {
                    $query->set( 'orderby', array( 'post_modified' => 'ASC') );
                    return;
                }
                else{
                    $query->set( 'orderby', array( 'post_modified' => 'DESC' ) );
                    return;
                }
            }           
        }
     }


    //== CUSTOM COLUMNS TEMPLATE =====================================
    function add_template_columns($defaults) {

        $defaults['post_id'] = 'ID';
        return $defaults;
    }

    function render_template_columns($column_name, $postID) {
        if($column_name === 'post_id'){ echo $postID; }
    }

    //Remove permalink and preview buttons from custom post screen.
    function action_remove_permalink() {
        global $post_type;
        if ( abcfsl_autil_post_type( $post_type ) > 0 ) {
            echo '<style type="text/css">#edit-slug-box,#view-post-btn,#post-preview,.updated p a{display: none;}</style>';
        }
    }

    //Remove view and quick edit from custom posts list.
    function filter_remove_post_edit_links( $actions ){

        $postType = get_post_type();
        if ( abcfsl_autil_post_type( $postType ) > 0 ) {
            unset( $actions['view'] );
        }

        //if ( abcfsl_autil_post_type( $postType ) !=2 ) {
        if ( abcfsl_autil_post_type( $postType ) == 1 ) {
            unset( $actions['inline hide-if-no-js'] );
        }
        return $actions;
    }

    function load_textdomain() {
        $domain = 'staff-list';
        //$langDir = plugin_basename( dirname( __FILE__ ) ) . '/languages/';
        $langDir = dirname( plugin_basename( __FILE__ ) ) . '//languages/';
        $locale = apply_filters( 'plugin_locale', get_locale(), $domain );
        load_plugin_textdomain( $domain, false, $langDir );  
    }  
    
    // function add_author_support_to_posts() {
    //     add_post_type_support( 'cpt_staff_lst_item', 'author' ); 
    // }
}
} // End class_exists check


/**
 * The main function responsible for returning the one true ABCFSL_Main instance to functions everywhere.
 * Use this function like you would a global variable, except without needing to declare the global.
 *  * Example: $object = ABCFSL_Main();
 */
function ABCFSL_Main() {
    return ABCF_Staff_List::instance();
}
// Get plugin Running
ABCFSL_Main();