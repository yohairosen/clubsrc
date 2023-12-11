<?php

function azexo_tgmpa_register() {
    $plugins[] = array(
        'name' => esc_html__('Core theme plugin', 'elastik'),
        'slug' => 'elastik-page-builder',
        'required' => true,
    );
    $plugins[] = array(
        'name' => esc_html__('Page Builder by AZEXO', 'elastik'),
        'slug' => 'page-builder-by-azexo',
        'required' => true,
    );
    $plugins[] = array(
        'name' => esc_html__('Redux Framework', 'elastik'),
        'slug' => 'redux-framework',
        'required' => true,
    );
    $plugins[] = array(
        'name' => esc_html__('JP Widget Visibility', 'elastik'),
        'slug' => 'jetpack-widget-visibility',
        'source' => get_template_directory() . '/plugins/jetpack-widget-visibility.zip',
    );
    $plugins[] = array(
        'name' => esc_html__('WP-LESS', 'elastik'),
        'slug' => 'wp-less',
    );

    $plugins = apply_filters('azexo_plugins', $plugins);
    if (!empty($plugins)) {
        tgmpa($plugins, array());
    }
}

add_action('tgmpa_register', 'azexo_tgmpa_register');
