<?php

require_once(get_theme_file_path('framework/framework.php'));
if(!is_admin()) {
    require_once(get_theme_file_path('framework/less-variables.php'));
}

add_action('wp_enqueue_scripts', 'elastik_scripts');

function elastik_scripts() {
    global $azexo_azh;

    $options = get_option(AZEXO_FRAMEWORK);
    $frontend_variables = array(
        'ajaxurl' => esc_url(admin_url('admin-ajax.php')),
        'logged_in' => is_user_logged_in(),
        'nonce' => wp_create_nonce('ajax'),
        'homeurl' => esc_url(home_url('/')),
        'templateurl' => esc_js(get_template_directory_uri()),
    );
    $user = wp_get_current_user();
    if (in_array('administrator', (array) $user->roles)) {
        $frontend_variables['edit_links'] = array();
        $frontend_variables['edit_button'] = esc_html__('Edit', 'elastik');
        $post_type_object = get_post_type_object('post');
        $frontend_variables['edit_url'] = esc_url(admin_url(sprintf($post_type_object->_edit_link . '&action=edit', 0)));
        if (function_exists('get_redux_instance')) {
            $configure_templates = array();
            $azexo_templates = azexo_get_templates();
            foreach ($azexo_templates as $template_name => $template_label) {
                $template_class = str_replace('_', '-', $template_name);
                $template_selector = '.entry.' . $template_class . ', .product.' . $template_class;
                $configure_templates[$template_selector] = esc_url(admin_url('?page=_options&tab=5&template=' . $template_label));
            }
            $frontend_variables['edit_links']['configure_templates'] = array(
                'links' => $configure_templates,
                'text' => esc_html__('Configure template', 'elastik'),
                'target' => '_blank',
            );
        }
    }
    wp_enqueue_script('elastik-frontend', get_template_directory_uri() . '/js/frontend.js', array('jquery', 'imagesloaded'), AZEXO_FRAMEWORK_VERSION, true);
    wp_localize_script('elastik-frontend', 'azexo', $frontend_variables);


    if (file_exists(get_template_directory() . '/js/jquery.sticky-kit.min.js')) {
        wp_enqueue_script('jquery-sticky-kit', get_template_directory_uri() . '/js/jquery.sticky-kit.min.js', array('jquery'), AZEXO_FRAMEWORK_VERSION, true);
    }

    if (file_exists(get_template_directory() . '/js/background-check.min.js')) {
        wp_enqueue_script('background-check', get_template_directory_uri() . '/js/background-check.min.js', array(), AZEXO_FRAMEWORK_VERSION, true);
    }

    if (!isset($azexo_azh)) {

        if (file_exists(get_template_directory() . '/js/owl.carousel.min.js')) {
            wp_register_script('jquery-owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), AZEXO_FRAMEWORK_VERSION, true);
            wp_register_style('jquery-owl-carousel', get_template_directory_uri() . '/css/owl.carousel.min.css');
        }

        if (file_exists(get_template_directory() . '/js/jquery.magnific-popup.min.js')) {
            wp_register_script('jquery-magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array('jquery'), AZEXO_FRAMEWORK_VERSION, true);
            wp_register_style('jquery-magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css');
        }

        if (file_exists(get_template_directory() . '/js/scrollReveal.js')) {
            wp_register_script('scrollReveal', get_template_directory_uri() . '/js/scrollReveal.js', array(), AZEXO_FRAMEWORK_VERSION, true);
        }

        if (file_exists(get_template_directory() . '/js/jquery.fitvids.js')) {
            wp_enqueue_script('jquery-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array(), AZEXO_FRAMEWORK_VERSION, true);
        }

        if (file_exists(get_template_directory() . '/js/jquery.waypoints.min.js')) {
            wp_register_script('jquery-waypoints', get_template_directory_uri() . '/js/jquery.waypoints.min.js', array(), AZEXO_FRAMEWORK_VERSION, true);
        }

        if (file_exists(get_template_directory() . '/js/jquery.countdown.min.js')) {
            wp_enqueue_script('jquery-countdown', get_template_directory_uri() . '/js/jquery.countdown.min.js', array('jquery'), AZEXO_FRAMEWORK_VERSION, true);
        }

        if (file_exists(get_template_directory() . '/js/jquery.flexslider-min.js')) {
            wp_register_script('jquery-flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js');
            wp_register_style('jquery-flexslider', get_template_directory_uri() . '/css/flexslider.css');
        }


        //move styles to header for HTML5 validation
        wp_enqueue_style('jquery-owl-carousel');
        wp_enqueue_style('jquery-flexslider');
        wp_enqueue_style('jquery-magnific-popup');
        wp_enqueue_style('js_composer_front');
        wp_enqueue_style('yarppRelatedCss');
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    if (class_exists('WC_Bookings')) {
        wp_dequeue_style('jquery-ui-style');
    }

    if (!empty($options['custom-js'])) {
        wp_add_inline_script('elastik-frontend', $options['custom-js']);
    }


    $default_template = isset($options['default_' . get_post_type() . '_template']) ? $options['default_' . get_post_type() . '_template'] : 'post';
    if (is_single() && isset($options['single_' . get_post_type() . '_template']) && !empty($options['single_' . get_post_type() . '_template'])) {
        $default_template = $options['single_' . get_post_type() . '_template'];
    }
    $template_name = apply_filters('azexo_template_name', $default_template);
    if ($template_name == 'masonry_post') {
        wp_enqueue_script('masonry');
    }
}

add_action('wp_enqueue_scripts', 'elastik_styles');

function elastik_styles() {
    global $azexo_azh;
    if (function_exists('visual_composer')) {
        visual_composer()->frontCss();
    }

    if (!isset($azexo_azh)) {
        if (file_exists(get_template_directory() . '/css/animate.css/animate.min.css')) {
            wp_enqueue_style('animate-css', get_template_directory_uri() . '/css/animate.css/animate.min.css');
        }

        if (file_exists(get_template_directory() . '/css/font-awesome.min.css')) {
            if (!wp_style_is('font-awesome', 'register')) {
                wp_register_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
            }
            wp_enqueue_style('font-awesome');
        }

        if (file_exists(get_template_directory() . '/css/themify-icons.css')) {
            wp_enqueue_style('themify-icons', get_template_directory_uri() . '/css/themify-icons.css');
        }
    }

    if (class_exists('WPLessPlugin')) {
        $less = WPLessPlugin::getInstance();
        $less->dispatch();
        $skin_style = get_template_directory_uri() . '/less/' . azexo_get_skin() . '/skin.less';
        if (is_child_theme()) {
            if (file_exists(get_stylesheet_directory() . '/less/' . azexo_get_skin() . '/skin.less')) {
                $skin_style = get_stylesheet_directory_uri() . '/less/' . azexo_get_skin() . '/skin.less';
            }
        }
        if (class_exists('Less_Colors')) {
            Less_Colors::$colors = array();
        }
        wp_enqueue_style('elastik-skin', $skin_style);
    } else {
        $skin_style = get_template_directory_uri() . '/css/' . azexo_get_skin() . '/skin.css';
        if (is_child_theme()) {
            if (file_exists(get_stylesheet_directory() . '/css/' . azexo_get_skin() . '/skin.css')) {
                $skin_style = get_stylesheet_directory_uri() . '/css/' . azexo_get_skin() . '/skin.css';
            }
        }
        wp_enqueue_style('elastik-skin', $skin_style);
    }

    $options = get_option(AZEXO_FRAMEWORK);

    if (isset($options['google_font_families']) && is_array($options['google_font_families'])) {
        global $azh_google_fonts_locale_subsets;
        $font_families = array();
        foreach ($options['google_font_families'] as $font_family) {
            if ('off' !== esc_html_x('on', $font_family . ' font: on or off', 'elastik')) {
                $font_families[] = $font_family . ':100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic';
            }
        }
        if (!empty($font_families)) {
            $subset = 'latin,latin-ext';
            if (isset($azh_google_fonts_locale_subsets[get_locale()])) {
                $subset = $azh_google_fonts_locale_subsets[get_locale()];
            }
            $query_args = array(
                'family' => implode(urlencode('|'), $font_families),
                'subset' => $subset,
            );
            $fonts_url = add_query_arg($query_args, (is_ssl() ? 'https' : 'http') . '://fonts.googleapis.com/css');
            wp_enqueue_style('elastik-fonts', $fonts_url, array(), null);
        }
    }

    wp_enqueue_style('elastik-style', get_stylesheet_uri(), array('elastik-skin'));


    if (!empty($options['custom-css'])) {
        wp_add_inline_style('elastik-style', $options['custom-css']);
    }
    wp_add_inline_style('elastik-style', azexo_dynamic_css());
}

add_action('current_screen', 'elastik_current_screen');

function elastik_current_screen() {
    add_editor_style('editor-styles.css');
}

add_action('init', 'elastik_fix_google_font_families', 13); // after load default skin options

function elastik_fix_google_font_families() {
    $options = get_option(AZEXO_FRAMEWORK);
    if (isset($options['google_font_families']) && is_array($options['google_font_families'])) {
        $font_families = array();
        foreach ($options['google_font_families'] as $font_family) {
            $font = explode(':', $font_family);
            if (!empty($font_family)) {
                $font_families[] = str_replace('+', ' ', $font[0]);
            }
        }
        $options['google_font_families'] = $font_families;
        update_option(AZEXO_FRAMEWORK, $options);
    }
}