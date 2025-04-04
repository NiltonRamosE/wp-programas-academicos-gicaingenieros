<?php

function gica_enqueue_admin_styles($hook) {
    if ($hook == 'toplevel_page_gica-dashboard') {
        wp_enqueue_style('gica-pa-dashboard-style', plugin_dir_url(__FILE__) . 'assets/css/pa-dashboard.css');
    }
    if ($hook === 'programas-academicos_page_gica-color-settings') {
        wp_enqueue_style('gica-color-settings-css', plugin_dir_url(__FILE__) . 'assets/css/pa-color-settings.css');
    }
}
add_action('admin_enqueue_scripts', 'gica_enqueue_admin_styles');

function gica_enqueue_styles() {
    wp_enqueue_style('gica-pa-shortcode-style', plugin_dir_url(__FILE__) . 'assets/css/pa-shortcode.css');
}
add_action('wp_enqueue_scripts', 'gica_enqueue_styles');

function gica_enqueue_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('gica-pa-script-sections', plugin_dir_url(__FILE__) . 'assets/js/pa-sections.js', array('jquery'), null, true);
    wp_enqueue_script('gica-pa-script-filter-year', plugin_dir_url(__FILE__) . 'assets/js/pa-filter-year.js', array('jquery'), null, true);
    wp_enqueue_script('gica-pa-script-pagination', plugin_dir_url(__FILE__) . 'assets/js/pa-pagination.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'gica_enqueue_scripts');
