<?php

function gica_enqueue_admin_styles($hook) {
    wp_enqueue_style('gica-general-style-css', plugin_dir_url(__FILE__) . 'assets/css/pa-general-style.css', GICA_PLUGIN_VERSION, true);

    if ($hook == 'toplevel_page_gica-dashboard') {
        wp_enqueue_style('gica-pa-dashboard-style', plugin_dir_url(__FILE__) . 'assets/css/pa-dashboard.css', GICA_PLUGIN_VERSION, true);
    }
    if ($hook === 'programas-academicos_page_gica-design-settings') {
        wp_enqueue_style('gica-design-settings-css', plugin_dir_url(__FILE__) . 'assets/css/pa-design-settings.css', GICA_PLUGIN_VERSION, true);
    }
    if ($hook === 'programas-academicos_page_gica-add-academic-program') {
        wp_enqueue_style('gica-add-academic-program-css', plugin_dir_url(__FILE__) . 'assets/css/pa-add-academic-program.css', GICA_PLUGIN_VERSION, true);
    }
}
add_action('admin_enqueue_scripts', 'gica_enqueue_admin_styles');

function gica_enqueue_admin_scripts($hook) {
    if (strpos($hook, 'gica-dashboard') !== false) {
        wp_enqueue_script('clipboard-js', 'https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js');
        wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js', array('jquery'), '3.7.1', true);
        wp_enqueue_script('gica-pa-script-copy-text', plugin_dir_url(__FILE__) . 'assets/js/pa-copy-text.js', array('clipboard-js', 'jquery'), GICA_PLUGIN_VERSION, true);
        wp_enqueue_script('gica-dashboard-chart', plugin_dir_url(__FILE__) . 'assets/js/pa-gica-chart.js', array('jquery', 'chart-js'), GICA_PLUGIN_VERSION, true); 
    }
    if ($hook === 'programas-academicos_page_gica-design-settings') {
        wp_enqueue_script('gica-design-settings-join-values', plugin_dir_url(__FILE__) . 'assets/js/design-settings/ds-join-values.js', GICA_PLUGIN_VERSION, true);
    }
    if ($hook === 'programas-academicos_page_gica-add-academic-program') {
        wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array(), null, true);
        wp_enqueue_script('gica-add-academic-program-add', plugin_dir_url(__FILE__) . 'assets/js/add-program/ap-add-program.js', array('jquery'), GICA_PLUGIN_VERSION, true);
        wp_enqueue_script('gica-add-academic-program-delete', plugin_dir_url(__FILE__) . 'assets/js/add-program/ap-delete-program.js', array('jquery'), GICA_PLUGIN_VERSION, true);
        wp_localize_script('gica-add-academic-program-delete', 'gica_admin_params', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('delete_academic_program_nonce')
        ));

        wp_enqueue_script('gica-category-program-delete', plugin_dir_url(__FILE__) . 'assets/js/add-program/ap-delete-category.js', array('jquery'), GICA_PLUGIN_VERSION, true);
        wp_localize_script('gica-category-program-delete', 'gica_category_admin_params', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('delete_category_program_nonce')
        ));
    }
}
add_action('admin_enqueue_scripts', 'gica_enqueue_admin_scripts');

function gica_enqueue_styles() {
    wp_enqueue_style('gica-pa-shortcode-style', plugin_dir_url(__FILE__) . 'assets/css/pa-shortcode.css', GICA_PLUGIN_VERSION, true);
}
add_action('wp_enqueue_scripts', 'gica_enqueue_styles');

function gica_enqueue_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('gica-pa-script-sections', plugin_dir_url(__FILE__) . 'assets/js/pa-sections.js', array('jquery'), GICA_PLUGIN_VERSION, true);
    wp_enqueue_script('gica-pa-script-filter-year', plugin_dir_url(__FILE__) . 'assets/js/pa-filter-year.js', array('jquery'), GICA_PLUGIN_VERSION, true);
    wp_enqueue_script('gica-pa-script-pagination', plugin_dir_url(__FILE__) . 'assets/js/pa-pagination.js', array('jquery'), GICA_PLUGIN_VERSION, true);
}
add_action('wp_enqueue_scripts', 'gica_enqueue_scripts');
