<?php
/**
 * GICA Design Settings
 * Maneja la personalización desde el panel de administración
 */
require_once plugin_dir_path(__FILE__) . 'helpers/pa-gica-dynamic-css-helper.php';

class GICA_Design_Settings {

    private $default_design_title;
    private $default_design_navbar;
    private $default_design_filters;
    private $default_design_cards;
    private $default_design_pagination;

    public function __construct() {
        $this->default_design_title = array(
            'title-color' => '#092f58',
            'line-title-color' => '#092f58',
            'text-title-size-min' => '1.8rem',
            'text-title-size-max' => '2.5rem',
            'text-title-weight' => '700',

            'width-title-line-base' => '50%',
            'width-title-line-tablet' => '60%',
            'width-title-line-mobile' => '70%',

            'width-title-line-hover-base' => '80%',
            'width-title-line-hover-tablet' => '90%',
            'width-title-line-hover-mobile' => '95%',
        );

        $this->default_design_navbar = array(
            'gap-navbar' => '12px',
            'margin-bottom-navbar' => '20px',
            'border-radius-navbar' => '8px',
            'font-size-navbar' => '14px',
            'font-weight-navbar' => '600',

            'grid-columns-navbar-escritorio-xl' => '4',
            'grid-columns-navbar-escritorio-lg' => '3',
            'grid-columns-navbar-tablet' => '2',
            'grid-columns-navbar-mobile' => '1',

            'btn-nav-active' => '#082949',
            'btn-nav-primary-color' => '#f9b809',
            'btn-nav-secondary-color' => '#dd8d02',
            'btn-nav-text-color' => '#ffffff',
        );

        $this->default_design_filters = array(
            'border-container-section' => '#ddd',
            'padding-container-section' => '1rem',
            'margin-top-container-section' => '0px',
            
            'margin-bottom-container-filter' => '30px',
            
            'gap-filter-year' => '8px',
            'border-radius-filter-year' => '20px',
            'font-weight-filter-year' => '600',
            'font-size-filter-year' => '13px',
            'min-width-filter-year' => '60px',

            'filter-primary-color' => '#63a3fa',
            'filter-secondary-color' => '#092f58',
            'filter-color' => '#333',
            'filter-hover-color' => '#ffffff',
            'filter-bg-color' => '#f5f5f5',
        );

        $this->default_design_cards = array(
            'border-radius-card' => '12px',
            'title-color-card' => '#092f58',
            'subtitle-color-card' => '#7f8c8d',
            'title-font-size-card' => '18px',
            'subtitle-font-size-card' => '14px',
            'title-font-weight-card' => '900',

            'badge-state-active-card' => '#27ae60',
            'badge-state-inactive-card' => '#e74c3c',
            'badge-state-updated-card' => '#f39c12',
        );

        $this->default_design_pagination = array(
            'pagination-gap' => '8px',
            'pagination-font-weight' => '900',
            'pagination-border-radius' => '50%',
            'pagination-border-radius-prev-next' => '20px',

            'pagination-bg' => '#f5f5f5',
            'pagination-bg-hover' => '#e0e0e0',
            'pagination-bg-hover-active' => '#2c3e50',
            'pagination-text-color' => '#333333',
            'pagination-text-color-active' => '#ffffff'
        );

        add_action('admin_menu', array($this, 'register_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('wp_enqueue_scripts', array($this, 'generate_dynamic_css_main_title'), 999);
        add_action('wp_enqueue_scripts', array($this, 'generate_dynamic_css_navbar'), 999);
        add_action('wp_enqueue_scripts', array($this, 'generate_dynamic_css_filters'), 999);
        add_action('wp_enqueue_scripts', array($this, 'generate_dynamic_css_cards'), 999);
        add_action('wp_enqueue_scripts', array($this, 'generate_dynamic_css_pagination'), 999);
        add_action('admin_post_export_design_settings', array($this, 'export_design_settings'));
        add_action('admin_post_import_design_settings', array($this, 'import_design_settings'));
    }

    public function register_settings_page() {
        add_submenu_page(
            'gica-dashboard',
            'Personalización de Diseño del Shortcode', 
            'Diseño del Shortcode',
            'manage_options', 
            'gica-design-settings',
            array($this, 'render_settings_page'),
            10
        );
    }

    public function register_settings() {
        register_setting('gica_design_title_options', 'gica_design_title', array(
            'sanitize_callback' => array($this, 'reset_values_title')
        ));
        register_setting('gica_design_navbar_options', 'gica_design_navbar', array(
            'sanitize_callback' => array($this, 'reset_values_navbar')
        ));
        register_setting('gica_design_filters_options', 'gica_design_filters', array(
            'sanitize_callback' => array($this, 'reset_values_filters')
        ));
        register_setting('gica_design_cards_options', 'gica_design_cards', array(
            'sanitize_callback' => array($this, 'reset_values_cards')
        ));
        register_setting('gica_design_pagination_options', 'gica_design_pagination', array(
            'sanitize_callback' => array($this, 'reset_values_pagination')
        ));
    }

    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
    
        $design_title = get_option('gica_design_title', array());
        $design_title = wp_parse_args($design_title, $this->default_design_title);

        $design_navbar = get_option('gica_design_navbar', array());
        $design_navbar = wp_parse_args($design_navbar, $this->default_design_navbar);

        $design_filters = get_option('gica_design_filters', array());
        $design_filters = wp_parse_args($design_filters, $this->default_design_filters);

        $design_cards = get_option('gica_design_cards', array());
        $design_cards = wp_parse_args($design_cards, $this->default_design_cards);

        $design_pagination = get_option('gica_design_pagination', array());
        $design_pagination = wp_parse_args($design_pagination, $this->default_design_pagination);

        $title_gica = "Personalización del Diseño GicaIngenieros";
        $redirect_page = 'admin.php?page=gica-dashboard';
        $redirect_page_name = "Ir al Dashboard";
        $third_option_redirect_page = 'admin-post.php?action=export_design_settings';
        $third_option_name = "Exportar Diseño";
        $fourth_option_name_design_settings = "Cargar JSON de diseño";
        ?>
        <div class="wrap gica-academic-program">
            <?php include plugin_dir_path(__FILE__) . 'partials/pa-gica-header.php'; ?>


            <?php include plugin_dir_path(__FILE__) . 'partials/design-settings/form-main-title.php'; ?>

            <?php include plugin_dir_path(__FILE__) . 'partials/design-settings/form-navbar.php'; ?>

            <?php include plugin_dir_path(__FILE__) . 'partials/design-settings/form-filters.php'; ?>

            <?php include plugin_dir_path(__FILE__) . 'partials/design-settings/form-cards.php'; ?>

            <?php include plugin_dir_path(__FILE__) . 'partials/design-settings/form-pagination.php'; ?>

            <?php include plugin_dir_path(__FILE__) . 'partials/pa-gica-actions.php'; ?>

            <?php include plugin_dir_path(__FILE__) . 'partials/pa-gica-footer.php'; ?>
        </div>
        <?php
    }
    
    public function extract_size_value($size) {
        return preg_replace('/[^0-9.]/', '', $size);
    }
    
    public function extract_size_unit($size) {
        return preg_replace('/[^a-z%]/', '', $size);
    }

    public function reset_values_title($input) {
        if (isset($input['reset-default-title']) && $input['reset-default-title'] == '1') {
            return $this->default_design_title;
        }
        return $input;
    }

    public function reset_values_navbar($input) {
        if (isset($input['reset-default-navbar']) && $input['reset-default-navbar'] == '1') {
            return $this->default_design_navbar;
        }
        return $input;
    }

    public function reset_values_filters($input) {
        if (isset($input['reset-default-filters']) && $input['reset-default-filters'] == '1') {
            return $this->default_design_filters;
        }
        return $input;
    }

    public function reset_values_cards($input) {
        if (isset($input['reset-default-cards']) && $input['reset-default-cards'] == '1') {
            return $this->default_design_cards;
        }
        return $input;
    }

    public function reset_values_pagination($input) {
        if (isset($input['reset-default-pagination']) && $input['reset-default-pagination'] == '1') {
            return $this->default_design_pagination;
        }
        return $input;
    }

    public function generate_dynamic_css_main_title() {
        GICA_Design_CSS_Helper::generate_dynamic_css(
            $this->default_design_title,
            'gica_design_title',
            array_keys($this->default_design_title),
            'gica-dynamic-css_main_title'
        );
    }


    public function generate_dynamic_css_navbar() {
        GICA_Design_CSS_Helper::generate_dynamic_css(
            $this->default_design_navbar,
            'gica_design_navbar',
            array_keys($this->default_design_navbar),
            'gica-dynamic-css_navbar'
        );
    }
    
    public function generate_dynamic_css_filters() {
        GICA_Design_CSS_Helper::generate_dynamic_css(
            $this->default_design_filters,
            'gica_design_filters',
            array_keys($this->default_design_filters),
            'gica-dynamic-css_filters'
        );
    }
    
    public function generate_dynamic_css_cards() {
        GICA_Design_CSS_Helper::generate_dynamic_css(
            $this->default_design_cards,
            'gica_design_cards',
            array_keys($this->default_design_cards),
            'gica-dynamic-css_cards'
        );
    }
    
    public function generate_dynamic_css_pagination() {
        GICA_Design_CSS_Helper::generate_dynamic_css(
            $this->default_design_pagination,
            'gica_design_pagination',
            array_keys($this->default_design_pagination),
            'gica-dynamic-css_pagination'
        );
    }    

    function export_design_settings() {

        $design_title = get_option('gica_design_title', array());
        $design_title = wp_parse_args($design_title, $this->default_design_title);

        $design_navbar = get_option('gica_design_navbar', array());
        $design_navbar = wp_parse_args($design_navbar, $this->default_design_navbar);

        $design_filters = get_option('gica_design_filters', array());
        $design_filters = wp_parse_args($design_filters, $this->default_design_filters);

        $design_cards = get_option('gica_design_cards', array());
        $design_cards = wp_parse_args($design_cards, $this->default_design_cards);

        $design_pagination = get_option('gica_design_pagination', array());
        $design_pagination = wp_parse_args($design_pagination, $this->default_design_pagination);

        $design_settings = array(
            'title' => $design_title,
            'navbar' => $design_navbar,
            'filters' => $design_filters,
            'cards' => $design_cards,
            'pagination' => $design_pagination,
        );

        $json_data = json_encode($design_settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="design-settings.json"');
        header('Content-Length: ' . strlen($json_data));

        echo $json_data;
        exit;
    }

    function import_design_settings() {
        if (!current_user_can('manage_options')) {
            wp_die('No tienes permisos suficientes.');
        }

        check_admin_referer('import_design_settings_nonce');

    
        if (isset($_FILES['design_settings_file']) && $_FILES['design_settings_file']['error'] == UPLOAD_ERR_OK) {
            $file = $_FILES['design_settings_file'];
            
            if ($file['type'] == 'application/json') {
                $json_data = file_get_contents($file['tmp_name']);
                
                $design_settings = json_decode($json_data, true);
    
                if (is_array($design_settings)) {
                    if (isset($design_settings['title'])) {
                        update_option('gica_design_title', $design_settings['title']);
                    }
                    if (isset($design_settings['navbar'])) {
                        update_option('gica_design_navbar', $design_settings['navbar']);
                    }
                    if (isset($design_settings['filters'])) {
                        update_option('gica_design_filters', $design_settings['filters']);
                    }
                    if (isset($design_settings['cards'])) {
                        update_option('gica_design_cards', $design_settings['cards']);
                    }
                    if (isset($design_settings['pagination'])) {
                        update_option('gica_design_pagination', $design_settings['pagination']);
                    }
    
                    wp_redirect(add_query_arg('import_status', 'success', wp_get_referer()));
                    exit;
                } else {
                    wp_redirect(add_query_arg('import_status', 'error', wp_get_referer()));
                    exit;
                }
            } else {
                wp_redirect(add_query_arg('import_status', 'invalid_file', wp_get_referer()));
                exit;
            }
        } else {
            wp_redirect(add_query_arg('import_status', 'upload_error', wp_get_referer()));
            exit;
        }
    }
}

new GICA_Design_Settings();