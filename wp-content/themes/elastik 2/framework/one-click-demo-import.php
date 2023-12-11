<?php

add_filter('pt-ocdi/import_files', 'azexo_one_click_demo_import');

function azexo_one_click_demo_import($import_files) {
    $demos = array();
    foreach (array(get_template_directory(), get_stylesheet_directory()) as $theme_dir) {
        foreach (new DirectoryIterator($theme_dir . '/data/') as $fileInfo) {
	    if(is_dir($theme_dir . '/data/')) {
            if ($fileInfo->isDir() && !$fileInfo->isDot()) {
                if (is_child_theme() && file_exists(get_stylesheet_directory() . '/data/' . $fileInfo->getFilename())) {
                    $demos[$fileInfo->getFilename()] = array(
                        'dir' => get_stylesheet_directory() . '/data/' . $fileInfo->getFilename(),
                        'uri' => get_stylesheet_directory_uri() . '/data/' . $fileInfo->getFilename(),
                    );
                } else {
                    if (!isset($demos[$fileInfo->getFilename()]) && file_exists(get_template_directory() . '/data/' . $fileInfo->getFilename())) {
                        $demos[$fileInfo->getFilename()] = array(
                            'dir' => get_template_directory() . '/data/' . $fileInfo->getFilename(),
                            'uri' => get_template_directory_uri() . '/data/' . $fileInfo->getFilename(),
                        );
                    }
                }
            }
	    }
        }
    }
    foreach ($demos as $name => $dir) {
        $content = $dir['dir'] . '/content.xml';
        $redux = $dir['dir'] . '/configuration.json';
        if (file_exists($content) || file_exists($redux)) {
            $theme = wp_get_theme();
            $preview_image_url = $theme->get_screenshot();
            if (file_exists($dir['dir'] . '/preview.jpg')) {
                $preview_image_url = $dir['uri'] . '/preview.jpg';
            }
            $demo = array(
                'import_file_name' => $name,
                'import_preview_image_url' => $preview_image_url,
            );
            if (file_exists($content)) {
                $demo['local_import_file'] = $content;
            }
            if (file_exists($redux)) {
                $demo['local_import_redux'] = array(
                    array(
                        'file_path' => $redux,
                        'option_name' => AZEXO_FRAMEWORK,
                    ),
                );
            }
            $widgets = $dir['dir'] . '/widgets.json';
            if (file_exists($widgets)) {
                $demo['local_import_widget_file'] = $content;
            }
            $import_files[] = $demo;
        }
    }

    return $import_files;
}
