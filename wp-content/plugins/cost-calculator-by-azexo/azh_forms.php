<?php

/*
  Plugin Name: Cost Calculator by AZEXO
  Description: Payment Forms Builder for WordPress
  Author: azexo
  Author URI: http://azexo.com
  Version: 1.27.20
  Text Domain: azf
 */

define('AZF_VERSION', '1.27');
define('AZF_PLUGIN_VERSION', '1.27.20');
define('AZF_URL', plugins_url('', __FILE__));
define('AZF_DIR', trailingslashit(dirname(__FILE__)));

if (file_exists(AZF_DIR . 'integrations/paypal.php')) {
    include_once(AZF_DIR . 'integrations/paypal.php');
}
if (is_admin()) {
    include_once(AZF_DIR . 'settings.php' );
}

register_activation_hook(__FILE__, 'azf_extension_activate');

function azf_extension_activate() {
    update_option('azh-library', array());
    update_option('azh-all-settings', array());
    update_option('azh-get-content-scripts', array());
    update_option('azh-content-settings', array());
}


add_action('plugins_loaded', 'azf_plugins_loaded');

function azf_plugins_loaded() {
    load_plugin_textdomain('azf', FALSE, basename(dirname(__FILE__)) . '/languages/');
}

add_action('admin_notices', 'azf_admin_notices');

function azf_admin_notices() {
    if (!defined('AZH_VERSION')) {
        $plugin_data = get_plugin_data(__FILE__);
        print '<div class="updated notice error is-dismissible"><p>' . $plugin_data['Name'] . ': ' . __('please install <a href="https://codecanyon.net/item/azexo-html-customizer/16350601">Page builder by AZEXO</a> plugin.', 'azf') . '</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">' . esc_html__('Dismiss this notice.', 'azf') . '</span></button></div>';
    }
}

add_filter('azh_directory', 'azf_directory');

function azf_directory($dir) {
    $dir[untrailingslashit(dirname(__FILE__)) . '/azh'] = plugins_url('', __FILE__) . '/azh';
    return $dir;
}

add_action('admin_enqueue_scripts', 'azf_admin_scripts');

function azf_admin_scripts() {
    if (isset($_GET['azh']) && $_GET['azh'] == 'customize') {
        wp_enqueue_style('azf_admin_frontend', plugins_url('css/admin-frontend.css', __FILE__));
        wp_enqueue_script('azf_admin_frontend', plugins_url('js/admin-frontend.js', __FILE__), array('azh_admin_frontend'), AZF_PLUGIN_VERSION, true);
        wp_enqueue_script('azf-frontend-customization-options', plugins_url('frontend-customization-options.js', __FILE__), array(), AZF_PLUGIN_VERSION, true);
    }
}

add_action('wp_enqueue_scripts', 'azf_scripts');

function azf_scripts() {
    if (isset($_GET['azh']) && $_GET['azh'] == 'customize') {
        wp_enqueue_style('azf_admin_frontend', plugins_url('css/admin-frontend.css', __FILE__));
        wp_enqueue_script('azf_admin_frontend', plugins_url('js/admin-frontend.js', __FILE__), array('azh_admin_frontend'), AZF_PLUGIN_VERSION, true);
        wp_enqueue_script('azf-frontend-customization-options', plugins_url('frontend-customization-options.js', __FILE__), array(), AZF_PLUGIN_VERSION, true);
    }
    wp_enqueue_script('numeral', plugins_url('js/numeral.js', __FILE__), array(), false, true);
    wp_enqueue_script('azf_frontend', plugins_url('js/frontend.js', __FILE__), array('numeral', 'azh_frontend'), AZF_PLUGIN_VERSION, true);
    wp_enqueue_style('azf_frontend', plugins_url('css/frontend.css', __FILE__));
}

add_filter('azh_get_object', 'azf_get_object');

function azf_get_object($azh) {
    $settings = get_option('azh-forms-settings', array());
    $azh['thousands_delimiter'] = isset($settings['thousands-delimiter']) ? $settings['thousands-delimiter'] : '';
    $azh['decimal_delimiter'] = isset($settings['decimal-delimiter']) ? $settings['decimal-delimiter'] : '';
    $azh['currency_symbol'] = isset($settings['currency-symbol']) ? $settings['currency-symbol'] : '';
    $azh['money_format'] = isset($settings['money-format']) ? $settings['money-format'] : '';
    $azh['float_format'] = isset($settings['float-format']) ? $settings['float-format'] : '';
    $azh['i18n']['show_if_all'] = esc_html__('Show if all', 'azf');
    $azh['i18n']['show_if_any'] = esc_html__('Show if any', 'azf');
    $azh['i18n']['hide_if_all'] = esc_html__('Hide if all', 'azf');
    $azh['i18n']['hide_if_any'] = esc_html__('Hide if any', 'azf');
    $azh['i18n']['next'] = esc_html__('Next', 'azf');
    return $azh;
}

add_filter('azh_get_frontend_object', 'azf_get_frontend_object');

function azf_get_frontend_object($azh) {
    $settings = get_option('azh-forms-settings', array());
    $azh['thousands_delimiter'] = isset($settings['thousands-delimiter']) ? $settings['thousands-delimiter'] : '';
    $azh['decimal_delimiter'] = isset($settings['decimal-delimiter']) ? $settings['decimal-delimiter'] : '';
    $azh['currency_symbol'] = isset($settings['currency-symbol']) ? $settings['currency-symbol'] : '';
    $azh['money_format'] = isset($settings['money-format']) ? $settings['money-format'] : '';
    $azh['float_format'] = isset($settings['float-format']) ? $settings['float-format'] : '';
    $azh['i18n']['next'] = esc_html__('Next', 'azf');
    return $azh;
}

add_action('init', 'azf_init');

function azf_init() {
    register_post_type('azf_submission', array(
        'labels' => array(
            'name' => __('Submission', 'azf'),
            'singular_name' => __('Submission', 'azf'),
            'add_new' => __('Add Submission', 'azf'),
            'add_new_item' => __('Add New Submission', 'azf'),
            'edit_item' => __('Edit Submission', 'azf'),
            'new_item' => __('New Submission', 'azf'),
            'view_item' => __('View Submission', 'azf'),
            'search_items' => __('Search Submissions', 'azf'),
            'not_found' => __('No Submission found', 'azf'),
            'not_found_in_trash' => __('No Submission found in Trash', 'azf'),
            'parent_item_colon' => __('Parent Submission:', 'azf'),
            'menu_name' => __('Forms Submissions', 'azf'),
        ),
        'query_var' => false,
        'rewrite' => false,
        'hierarchical' => true,
        'supports' => array('title', 'custom-fields', 'author', 'comments'),
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_in_menu' => true,
        'public' => false,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
    ));
}

add_filter('default_hidden_meta_boxes', 'azf_default_hidden_meta_boxes', 10, 2);

function azf_default_hidden_meta_boxes($hidden, $screen) {
    global $post;
    if ($post && $post->post_type === 'azf_submission') {
        $i = array_search('postcustom', $hidden);
        unset($hidden[$i]);
    }
    return $hidden;
}

add_filter('azh_process_form', 'azf_process_form', 10, 3);

function azf_process_form($response, $files, $form_settings) {
    if (isset($_POST['post_id']) && is_numeric($_POST['post_id'])) {
        $post_id = (int) $_POST['post_id'];
        $page = get_post($post_id);
        if ($page) {
            $submission_id = wp_insert_post(array(
                'post_title' => isset($_POST['form_title']) ? sanitize_text_field($_POST['form_title']) : '',
                'post_type' => 'azf_submission',
                'post_status' => 'publish',
                'post_author' => $page->post_author,
                'post_parent' => $post_id,
                    ), true);
            if (!is_wp_error($submission_id)) {
                update_post_meta($submission_id, '_hash', uniqid());
                $forms = azh_get_forms_from_page($page);
                if (isset($_POST['form_title'])) {
                    $form_title = wp_unslash(sanitize_text_field($_POST['form_title']));
                    update_post_meta($submission_id, 'form_title', $form_title);
                    if (isset($forms[$form_title])) {
                        foreach ($forms[$form_title] as $name => $field) {
                            if (isset($_POST[$name])) {
                                if (is_array($_POST[$name])) {
                                    update_post_meta($submission_id, trim($name), sanitize_text_field(trim(implode(', ', $_POST[$name]))));
                                } else {
                                    update_post_meta($submission_id, trim($name), sanitize_text_field(trim($_POST[$name])));
                                }
                            }
                            if (isset($files[trim($name)])) {
                                update_post_meta($submission_id, trim($name), implode(', ', $files[trim($name)]));
                            }
                        }
                    }
                }
                $response = apply_filters('azf_process_form', $response, $form_settings, $submission_id);
            }
        }
    }
    return $response;
}

function azf_get_country_codes() {
    $codes = array(
        esc_html__('AFGHANISTAN', 'azf') => 'AF',
        esc_html__('ALBANIA', 'azf') => 'AL',
        esc_html__('ALGERIA', 'azf') => 'DZ',
        esc_html__('AMERICAN SAMOA', 'azf') => 'AS',
        esc_html__('ANDORRA', 'azf') => 'AD',
        esc_html__('ANGOLA', 'azf') => 'AO',
        esc_html__('ANTIGUA AND BARBUDA', 'azf') => 'AG',
        esc_html__('ARGENTINA', 'azf') => 'AR',
        esc_html__('ARMENIA', 'azf') => 'AM',
        esc_html__('AUSTRALIA', 'azf') => 'AU',
        esc_html__('AUSTRIA', 'azf') => 'AT',
        esc_html__('AZERBAIJAN', 'azf') => 'AZ',
        esc_html__('BAHAMAS', 'azf') => 'BS',
        esc_html__('BAHRAIN', 'azf') => 'BH',
        esc_html__('BANGLADESH', 'azf') => 'BD',
        esc_html__('BARBADOS', 'azf') => 'BB',
        esc_html__('BELARUS', 'azf') => 'BY',
        esc_html__('BELGIUM', 'azf') => 'BE',
        esc_html__('BELIZE', 'azf') => 'BZ',
        esc_html__('BENIN', 'azf') => 'BJ',
        esc_html__('BERMUDA', 'azf') => 'BM',
        esc_html__('BHUTAN', 'azf') => 'BT',
        esc_html__('BOLIVIA', 'azf') => 'BO',
        esc_html__('BOSNIA AND HERZEGOVINA', 'azf') => 'BA',
        esc_html__('BOTSWANA', 'azf') => 'BW',
        esc_html__('BRAZIL', 'azf') => 'BR',
        esc_html__('BRUNEI', 'azf') => 'BN',
        esc_html__('BULGARIA', 'azf') => 'BG',
        esc_html__('BURKINA FASO', 'azf') => 'BF',
        esc_html__('BURUNDI', 'azf') => 'BI',
        esc_html__('CAMBODIA', 'azf') => 'KH',
        esc_html__('CAMEROON', 'azf') => 'CM',
        esc_html__('CANADA', 'azf') => 'CA',
        esc_html__('CAPE VERDE', 'azf') => 'CV',
        esc_html__('CAYMAN ISLANDS', 'azf') => 'KY',
        esc_html__('CENTRAL AFRICAN REPUBLIC', 'azf') => 'CF',
        esc_html__('CHAD', 'azf') => 'TD',
        esc_html__('CHILE', 'azf') => 'CL',
        esc_html__('CHINA', 'azf') => 'CN',
        esc_html__('COLOMBIA', 'azf') => 'CO',
        esc_html__('COMOROS', 'azf') => 'KM',
        esc_html__('CONGO, DEMOCRATIC REPUBLIC OF THE', 'azf') => 'CD',
        esc_html__('CONGO, REPUBLIC OF THE', 'azf') => 'CG',
        esc_html__('COSTA RICA', 'azf') => 'CR',
        esc_html__("CÔTE D'IVOIRE", 'azf') => 'CI',
        esc_html__('CROATIA', 'azf') => 'HR',
        esc_html__('CUBA', 'azf') => 'CU',
        esc_html__('CURAÇAO', 'azf') => 'CW',
        esc_html__('CYPRUS', 'azf') => 'CY',
        esc_html__('CZECH REPUBLIC', 'azf') => 'CZ',
        esc_html__('DENMARK', 'azf') => 'DK',
        esc_html__('DJIBOUTI', 'azf') => 'DJ',
        esc_html__('DOMINICA', 'azf') => 'DM',
        esc_html__('DOMINICAN REPUBLIC', 'azf') => 'DO',
        esc_html__('EAST TIMOR', 'azf') => 'TL',
        esc_html__('ECUADOR', 'azf') => 'EC',
        esc_html__('EGYPT', 'azf') => 'EG',
        esc_html__('EL SALVADOR', 'azf') => 'SV',
        esc_html__('EQUATORIAL GUINEA', 'azf') => 'GQ',
        esc_html__('ERITREA', 'azf') => 'ER',
        esc_html__('ESTONIA', 'azf') => 'EE',
        esc_html__('ETHIOPIA', 'azf') => 'ET',
        esc_html__('FAROE ISLANDS', 'azf') => 'FO',
        esc_html__('FIJI', 'azf') => 'FJ',
        esc_html__('FINLAND', 'azf') => 'FI',
        esc_html__('FRANCE', 'azf') => 'FR',
        esc_html__('FRENCH POLYNESIA', 'azf') => 'PF',
        esc_html__('GABON', 'azf') => 'GA',
        esc_html__('GAMBIA', 'azf') => 'GM',
        esc_html(_x('GEORGIA', 'Country', 'azf')) => 'GE',
        esc_html__('GERMANY', 'azf') => 'DE',
        esc_html__('GHANA', 'azf') => 'GH',
        esc_html__('GREECE', 'azf') => 'GR',
        esc_html__('GREENLAND', 'azf') => 'GL',
        esc_html__('GRENADA', 'azf') => 'GD',
        esc_html__('GUAM', 'azf') => 'GU',
        esc_html__('GUATEMALA', 'azf') => 'GT',
        esc_html__('GUINEA', 'azf') => 'GN',
        esc_html__('GUINEA-BISSAU', 'azf') => 'GW',
        esc_html__('GUYANA', 'azf') => 'GY',
        esc_html__('HAITI', 'azf') => 'HT',
        esc_html__('HONDURAS', 'azf') => 'HN',
        esc_html__('HONG KONG', 'azf') => 'HK',
        esc_html__('HUNGARY', 'azf') => 'HU',
        esc_html__('ICELAND', 'azf') => 'IS',
        esc_html__('INDIA', 'azf') => 'IN',
        esc_html__('INDONESIA', 'azf') => 'ID',
        esc_html__('IRAN', 'azf') => 'IR',
        esc_html__('IRAQ', 'azf') => 'IQ',
        esc_html__('IRELAND', 'azf') => 'IE',
        esc_html__('ISRAEL', 'azf') => 'IL',
        esc_html__('ITALY', 'azf') => 'IT',
        esc_html__('JAMAICA', 'azf') => 'JM',
        esc_html__('JAPAN', 'azf') => 'JP',
        esc_html__('JORDAN', 'azf') => 'JO',
        esc_html__('KAZAKHSTAN', 'azf') => 'KZ',
        esc_html__('KENYA', 'azf') => 'KE',
        esc_html__('KIRIBATI', 'azf') => 'KI',
        esc_html__('NORTH KOREA', 'azf') => 'KP',
        esc_html__('SOUTH KOREA', 'azf') => 'KR',
        esc_html__('KOSOVO', 'azf') => 'KV',
        esc_html__('KUWAIT', 'azf') => 'KW',
        esc_html__('KYRGYZSTAN', 'azf') => 'KG',
        esc_html__('LAOS', 'azf') => 'LA',
        esc_html__('LATVIA', 'azf') => 'LV',
        esc_html__('LEBANON', 'azf') => 'LB',
        esc_html__('LESOTHO', 'azf') => 'LS',
        esc_html__('LIBERIA', 'azf') => 'LR',
        esc_html__('LIBYA', 'azf') => 'LY',
        esc_html__('LIECHTENSTEIN', 'azf') => 'LI',
        esc_html__('LITHUANIA', 'azf') => 'LT',
        esc_html__('LUXEMBOURG', 'azf') => 'LU',
        esc_html__('MACEDONIA', 'azf') => 'MK',
        esc_html__('MADAGASCAR', 'azf') => 'MG',
        esc_html__('MALAWI', 'azf') => 'MW',
        esc_html__('MALAYSIA', 'azf') => 'MY',
        esc_html__('MALDIVES', 'azf') => 'MV',
        esc_html__('MALI', 'azf') => 'ML',
        esc_html__('MALTA', 'azf') => 'MT',
        esc_html__('MARSHALL ISLANDS', 'azf') => 'MH',
        esc_html__('MAURITANIA', 'azf') => 'MR',
        esc_html__('MAURITIUS', 'azf') => 'MU',
        esc_html__('MEXICO', 'azf') => 'MX',
        esc_html__('MICRONESIA', 'azf') => 'FM',
        esc_html__('MOLDOVA', 'azf') => 'MD',
        esc_html__('MONACO', 'azf') => 'MC',
        esc_html__('MONGOLIA', 'azf') => 'MN',
        esc_html__('MONTENEGRO', 'azf') => 'ME',
        esc_html__('MOROCCO', 'azf') => 'MA',
        esc_html__('MOZAMBIQUE', 'azf') => 'MZ',
        esc_html__('MYANMAR', 'azf') => 'MM',
        esc_html__('NAMIBIA', 'azf') => 'NA',
        esc_html__('NAURU', 'azf') => 'NR',
        esc_html__('NEPAL', 'azf') => 'NP',
        esc_html__('NETHERLANDS', 'azf') => 'NL',
        esc_html__('NEW ZEALAND', 'azf') => 'NZ',
        esc_html__('NICARAGUA', 'azf') => 'NI',
        esc_html__('NIGER', 'azf') => 'NE',
        esc_html__('NIGERIA', 'azf') => 'NG',
        esc_html__('NORTHERN MARIANA ISLANDS', 'azf') => 'MP',
        esc_html__('NORWAY', 'azf') => 'NO',
        esc_html__('OMAN', 'azf') => 'OM',
        esc_html__('PAKISTAN', 'azf') => 'PK',
        esc_html__('PALAU', 'azf') => 'PW',
        esc_html__('PALESTINE, STATE OF', 'azf') => 'PS',
        esc_html__('PANAMA', 'azf') => 'PA',
        esc_html__('PAPUA NEW GUINEA', 'azf') => 'PG',
        esc_html__('PARAGUAY', 'azf') => 'PY',
        esc_html__('PERU', 'azf') => 'PE',
        esc_html__('PHILIPPINES', 'azf') => 'PH',
        esc_html__('POLAND', 'azf') => 'PL',
        esc_html__('PORTUGAL', 'azf') => 'PT',
        esc_html__('PUERTO RICO', 'azf') => 'PR',
        esc_html__('QATAR', 'azf') => 'QA',
        esc_html__('ROMANIA', 'azf') => 'RO',
        esc_html__('RUSSIA', 'azf') => 'RU',
        esc_html__('RWANDA', 'azf') => 'RW',
        esc_html__('SAINT KITTS AND NEVIS', 'azf') => 'KN',
        esc_html__('SAINT LUCIA', 'azf') => 'LC',
        esc_html__('SAINT VINCENT AND THE GRENADINES', 'azf') => 'VC',
        esc_html__('SAMOA', 'azf') => 'WS',
        esc_html__('SAN MARINO', 'azf') => 'SM',
        esc_html__('SAO TOME AND PRINCIPE', 'azf') => 'ST',
        esc_html__('SAUDI ARABIA', 'azf') => 'SA',
        esc_html__('SENEGAL', 'azf') => 'SN',
        esc_html__('SERBIA', 'azf') => 'RS',
        esc_html__('SEYCHELLES', 'azf') => 'SC',
        esc_html__('SIERRA LEONE', 'azf') => 'SL',
        esc_html__('SINGAPORE', 'azf') => 'SG',
        esc_html__('SINT MAARTEN', 'azf') => 'SX',
        esc_html__('SLOVAKIA', 'azf') => 'SK',
        esc_html__('SLOVENIA', 'azf') => 'SI',
        esc_html__('SOLOMON ISLANDS', 'azf') => 'SB',
        esc_html__('SOMALIA', 'azf') => 'SO',
        esc_html__('SOUTH AFRICA', 'azf') => 'ZA',
        esc_html__('SPAIN', 'azf') => 'ES',
        esc_html__('SRI LANKA', 'azf') => 'LK',
        esc_html__('SUDAN', 'azf') => 'SD',
        esc_html__('SUDAN, SOUTH', 'azf') => 'SS',
        esc_html__('SURINAME', 'azf') => 'SR',
        esc_html__('SWAZILAND', 'azf') => 'SZ',
        esc_html__('SWEDEN', 'azf') => 'SE',
        esc_html__('SWITZERLAND', 'azf') => 'CH',
        esc_html__('SYRIA', 'azf') => 'SY',
        esc_html__('TAIWAN', 'azf') => 'TW',
        esc_html__('TAJIKISTAN', 'azf') => 'TJ',
        esc_html__('TANZANIA', 'azf') => 'TZ',
        esc_html__('THAILAND', 'azf') => 'TH',
        esc_html__('TOGO', 'azf') => 'TG',
        esc_html__('TONGA', 'azf') => 'TO',
        esc_html__('TRINIDAD AND TOBAGO', 'azf') => 'TT',
        esc_html__('TUNISIA', 'azf') => 'TN',
        esc_html__('TURKEY', 'azf') => 'TR',
        esc_html__('TURKMENISTAN', 'azf') => 'TM',
        esc_html__('TUVALU', 'azf') => 'TV',
        esc_html__('UGANDA', 'azf') => 'UG',
        esc_html__('UKRAINE', 'azf') => 'UA',
        esc_html__('UNITED ARAB EMIRATES', 'azf') => 'AE',
        esc_html__('UNITED KINGDOM', 'azf') => 'GB',
        esc_html__('UNITED STATES', 'azf') => 'US',
        esc_html__('URUGUAY', 'azf') => 'UY',
        esc_html__('UZBEKISTAN', 'azf') => 'UZ',
        esc_html__('VANUATU', 'azf') => 'VU',
        esc_html__('VATICAN CITY', 'azf') => 'VA',
        esc_html__('VENEZUELA', 'azf') => 'VE',
        esc_html__('VIRGIN ISLANDS, BRITISH', 'azf') => 'VG',
        esc_html__('VIRGIN ISLANDS, U.S.', 'azf') => 'VI',
        esc_html__('VIETNAM', 'azf') => 'VN',
        esc_html__('YEMEN', 'azf') => 'YE',
        esc_html__('ZAMBIA', 'azf') => 'ZM',
        esc_html__('ZIMBABWE', 'azf') => 'ZW',
    );

    return $codes;
}

function azf_get_us_states() {
    return array(
        esc_html__('Alabama', 'azf'),
        esc_html__('Alaska', 'azf'),
        esc_html__('Arizona', 'azf'),
        esc_html__('Arkansas', 'azf'),
        esc_html__('California', 'azf'),
        esc_html__('Colorado', 'azf'),
        esc_html__('Connecticut', 'azf'),
        esc_html__('Delaware', 'azf'),
        esc_html__('District of Columbia', 'azf'),
        esc_html__('Florida', 'azf'),
        esc_html(_x('Georgia', 'US State', 'azf')),
        esc_html__('Hawaii', 'azf'),
        esc_html__('Idaho', 'azf'),
        esc_html__('Illinois', 'azf'),
        esc_html__('Indiana', 'azf'),
        esc_html__('Iowa', 'azf'),
        esc_html__('Kansas', 'azf'),
        esc_html__('Kentucky', 'azf'),
        esc_html__('Louisiana', 'azf'),
        esc_html__('Maine', 'azf'),
        esc_html__('Maryland', 'azf'),
        esc_html__('Massachusetts', 'azf'),
        esc_html__('Michigan', 'azf'),
        esc_html__('Minnesota', 'azf'),
        esc_html__('Mississippi', 'azf'),
        esc_html__('Missouri', 'azf'),
        esc_html__('Montana', 'azf'),
        esc_html__('Nebraska', 'azf'),
        esc_html__('Nevada', 'azf'),
        esc_html__('New Hampshire', 'azf'),
        esc_html__('New Jersey', 'azf'),
        esc_html__('New Mexico', 'azf'),
        esc_html__('New York', 'azf'),
        esc_html__('North Carolina', 'azf'),
        esc_html__('North Dakota', 'azf'),
        esc_html__('Ohio', 'azf'),
        esc_html__('Oklahoma', 'azf'),
        esc_html__('Oregon', 'azf'),
        esc_html__('Pennsylvania', 'azf'),
        esc_html__('Rhode Island', 'azf'),
        esc_html__('South Carolina', 'azf'),
        esc_html__('South Dakota', 'azf'),
        esc_html__('Tennessee', 'azf'),
        esc_html__('Texas', 'azf'),
        esc_html__('Utah', 'azf'),
        esc_html__('Vermont', 'azf'),
        esc_html__('Virginia', 'azf'),
        esc_html__('Washington', 'azf'),
        esc_html__('West Virginia', 'azf'),
        esc_html__('Wisconsin', 'azf'),
        esc_html__('Wyoming', 'azf'),
        esc_html__('Armed Forces Americas', 'azf'),
        esc_html__('Armed Forces Europe', 'azf'),
        esc_html__('Armed Forces Pacific', 'azf'),
    );
}
