<?php

add_action('admin_init', 'azf_general_options');

function azf_general_options() {
    if (file_exists(AZF_DIR . 'azh_settings.json')) {
        $settings = get_option('azh-forms-settings');
        if (!is_array($settings)) {
            if (function_exists('azh_filesystem')) {
                azh_filesystem();
                global $wp_filesystem;
                $settings = $wp_filesystem->get_contents(AZF_DIR . 'azh_settings.json');
                update_option('azh-forms-settings', json_decode($settings, true));
            }
        }
    }

    if (isset($_GET['page']) && $_GET['page'] == 'azh-forms-settings') {
        add_settings_field(
                'thousands-delimiter', // Field ID
                esc_html__('Thousands delimiter', 'azf'), // Label to the left
                'azh_textfield', // Name of function that renders options on the page
                'azh-forms-settings', // Page to show on
                'azh_general_settings', // Associate with which settings section?
                array(
            'id' => 'thousands-delimiter',
            'default' => ',',
                )
        );

        add_settings_field(
                'decimal-delimiter', // Field ID
                esc_html__('Decimal delimiter', 'azf'), // Label to the left
                'azh_textfield', // Name of function that renders options on the page
                'azh-forms-settings', // Page to show on
                'azh_general_settings', // Associate with which settings section?
                array(
            'id' => 'decimal-delimiter',
            'default' => '.',
                )
        );
        add_settings_field(
                'currency-symbol', // Field ID
                esc_html__('Currency symbol', 'azf'), // Label to the left
                'azh_textfield', // Name of function that renders options on the page
                'azh-forms-settings', // Page to show on
                'azh_general_settings', // Associate with which settings section?
                array(
            'id' => 'currency-symbol',
            'default' => '$',
                )
        );
        add_settings_field(
                'money-format', // Field ID
                esc_html__('Money format', 'azf'), // Label to the left
                'azh_textfield', // Name of function that renders options on the page
                'azh-forms-settings', // Page to show on
                'azh_general_settings', // Associate with which settings section?
                array(
            'id' => 'money-format',
            'default' => '$0,0.00',
                )
        );
        add_settings_field(
                'float-format', // Field ID
                esc_html__('Float format', 'azf'), // Label to the left
                'azh_textfield', // Name of function that renders options on the page
                'azh-forms-settings', // Page to show on
                'azh_general_settings', // Associate with which settings section?
                array(
            'id' => 'float-format',
            'default' => '0,0.00',
                )
        );
    }
}
