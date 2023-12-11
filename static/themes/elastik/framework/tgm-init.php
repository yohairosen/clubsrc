<?php

function azexo_tgmpa_register() {

    $plugins = array();
    if (file_exists(get_template_directory() . '/plugins/' . azexo_get_skin() . '-page-builder.zip')) {
        $plugins[] = array(
            'name' => esc_html__('Core theme plugin', 'elastik'),
            'slug' => azexo_get_skin() . '-page-builder',
            'source' => get_template_directory() . '/plugins/' . azexo_get_skin() . '-page-builder.zip',
            'required' => true,
            'version' => '1.27.6',
        );
    }
    $plugins[] = array(
        'name' => esc_html__('Redux Framework', 'elastik'),
        'slug' => 'redux-framework',
        'required' => true,
    );
    $plugins[] = array(
        'name' => esc_html__('One click demo import', 'elastik'),
        'slug' => 'one-click-demo-import',
    );
    $plugins[] = array(
        'name' => esc_html__('WP-LESS', 'elastik'),
        'slug' => 'wp-less',
    );

    $plugins = apply_filters('azexo_plugins', $plugins);
    if (!empty($plugins)) {
        tgmpa($plugins, array());
    }


    $additional_plugins = array(
        'jetpack-widget-visibility' => esc_html__('JP Widget Visibility', 'elastik'),
        'vc_widgets' => esc_html__('Visual Composer Widgets', 'elastik'),
        'azexo_vc_elements' => esc_html__('AZEXO Visual Composer elements', 'elastik'),
        'az_social_login' => esc_html__('AZEXO Social Login', 'elastik'),
        'az_email_verification' => esc_html__('AZEXO Email Verification', 'elastik'),
        'az_likes' => esc_html__('AZEXO Post/Comments likes', 'elastik'),
        'az_voting' => esc_html__('AZEXO Voting', 'elastik'),
        'azexo_html' => esc_html__('AZEXO HTML Customizer', 'elastik'),
        'azh_extension' => esc_html__('AZEXO HTML Library', 'elastik'),
        'page-builder-by-azexo' => esc_html__('Page builder by AZEXO', 'elastik'),
        'elements-library-for-azexo-builder' => esc_html__('Elements Library for AZEXO Builder', 'elastik'),
        'az_listings' => esc_html__('AZEXO Listings', 'elastik'),
        'az_query_form' => esc_html__('AZEXO Query Form', 'elastik'),
        'az_group_buying' => esc_html__('AZEXO Group Buying', 'elastik'),
        'az_vouchers' => esc_html__('AZEXO Vouchers', 'elastik'),
        'az_bookings' => esc_html__('AZEXO Bookings', 'elastik'),
        'az_deals' => esc_html__('AZEXO Deals', 'elastik'),
        'az_sport_club' => esc_html__('AZEXO Sport Club', 'elastik'),
        'az_locations' => esc_html__('AZEXO Locations', 'elastik'),
        'circular_countdown' => esc_html__('Circular CountDown', 'elastik'),
    );
    $plugins = array();
    foreach ($additional_plugins as $additional_plugin_slug => $additional_plugin_name) {
        $plugin_path = get_template_directory() . '/plugins/' . $additional_plugin_slug . '.zip';
        if (file_exists($plugin_path)) {
            $plugins[] = array(
                'name' => $additional_plugin_name,
                'slug' => $additional_plugin_slug,
                'source' => $plugin_path,
                'required' => true,
                'version' => AZEXO_FRAMEWORK_VERSION,
            );
        }
    }
    $plugins = apply_filters('azexo_plugins', $plugins);
    if (!empty($plugins)) {
        tgmpa($plugins, array(
        ));
    }
}

add_action('tgmpa_register', 'azexo_tgmpa_register');
