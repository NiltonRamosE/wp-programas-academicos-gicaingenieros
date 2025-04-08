<?php
/**
 * GICA Design Settings
 * Maneja la personalización desde el panel de administración
 */

class GICA_Design_Settings {

    private $default_design_title;
    private $default_design_navbar;
    private $default_colors;

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

        $this->default_colors = array(
            // Botones año
            'btn-year-bg' => '#f5f5f5',
            'btn-year-text' => '#333333',
            'btn-year-text-hover' => '#ffffff',
            
            // Badges estado
            'badge-state-active' => '#27ae60',
            'badge-state-inactive' => '#e74c3c',
            'badge-state-updated' => '#f39c12',
            
            // Paginación
            'pagination-bg' => '#f5f5f5',
            'pagination-bg-hover' => '#e0e0e0',
            'pagination-bg-hover-active' => '#2c3e50',
            'pagination-text-color' => '#333333',
            'pagination-text-color-active' => '#ffffff'
        );

        add_action('admin_menu', array($this, 'register_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('wp_enqueue_scripts', array($this, 'generate_dynamic_css_main_title'), 100);
        add_action('wp_enqueue_scripts', array($this, 'generate_dynamic_css_navbar'), 100);
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
    }

    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
    
        $design_title = get_option('gica_design_title', array());
        $design_title = wp_parse_args($design_title, $this->default_design_title);

        $design_navbar = get_option('gica_design_navbar', array());
        $design_navbar = wp_parse_args($design_navbar, $this->default_design_navbar);

        $last_updated = date('d/m/Y H:i');
        ?>
        <div class="wrap gica-design-settings">
            <header class="gica-design-settings__header">
                <div class="gica-design-settings__header-img-container">
                    <img src="https://www.gicaingenieros.com/email/images/img-gica-2.jpg" alt="GICA Ingenieros" class="gica-design-settings__header-img">
                </div>
                <div class="gica-design-settings__header-content">
                    <div>
                        <h1 class="gica-design-settings__title">
                            Programas Académicos
                        </h1>
                        <p class="gica-design-settings__subtitle">Personalización de Shortcode GicaIngenieros</p>
                    </div>
                    <div class="gica-design-settings__header-badge">
                        <span class="gica-design-settings__update"> v<?php echo GICA_PLUGIN_VERSION; ?> • <?php echo $last_updated; ?></span>
                    </div>
                </div>
                <div class="gica-design-settings__header-line"></div>
            </header>

            <div class="gica-design-settings__grid">
                <?php include plugin_dir_path(__FILE__) . 'partials/design-settings/form-main-title.php'; ?>
            </div>
            
            <div class="gica-design-settings__grid">
                <?php include plugin_dir_path(__FILE__) . 'partials/design-settings/form-navbar.php'; ?>
            </div>

            <footer class="gica-design-settings__footer">
                <div class="gica-design-settings__footer-content">
                    <p class="gica-design-settings__footer-text">Plugin desarrollado por <a href="https://niltonramosencarnacion.vercel.app/" target="_blank">Nilton Ramos Encarnacion</a></p>
                    <p class="gica-design-settings__version">Versión <?php echo GICA_PLUGIN_VERSION; ?> | Licencia GPL2</p>
                </div>
            </footer>
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

    public function generate_dynamic_css_main_title() {
        $design_title = get_option('gica_design_title', array());
        $design_title = wp_parse_args($design_title, $this->default_design_title);
        
        $css = ":root {\n";
        $css .= "    --title-color: {$design_title['title-color']};\n";
        $css .= "    --line-title-color: {$design_title['line-title-color']};\n";
        $css .= "    --text-title-size-min: {$design_title['text-title-size-min']};\n";
        $css .= "    --text-title-size-max: {$design_title['text-title-size-max']};\n";
        $css .= "    --text-title-weight: {$design_title['text-title-weight']};\n";

        $css .= "    --width-title-line-base: {$design_title['width-title-line-base']};\n";
        $css .= "    --width-title-line-tablet: {$design_title['width-title-line-tablet']};\n";
        $css .= "    --width-title-line-mobile: {$design_title['width-title-line-mobile']};\n";

        $css .= "    --width-title-line-hover-base: {$design_title['width-title-line-hover-base']};\n";
        $css .= "    --width-title-line-hover-tablet: {$design_title['width-title-line-hover-tablet']};\n";
        $css .= "    --width-title-line-hover-mobile: {$design_title['width-title-line-hover-mobile']};\n";
        $css .= "}\n";
        
        wp_register_style('gica-dynamic-css_main_title', false);
        wp_enqueue_style('gica-dynamic-css_main_title');
        wp_add_inline_style('gica-dynamic-css_main_title', $css);
    }

    public function generate_dynamic_css_navbar() {
        $design_navbar = get_option('gica_design_navbar', array());
        $design_navbar = wp_parse_args($design_navbar, $this->default_design_navbar);
        
        $css = ":root {\n";
        $css .= "    --gap-navbar: {$design_navbar['gap-navbar']};\n";
        $css .= "    --margin-bottom-navbar: {$design_navbar['margin-bottom-navbar']};\n";
        $css .= "    --border-radius-navbar: {$design_navbar['border-radius-navbar']};\n";
        $css .= "    --font-size-navbar: {$design_navbar['font-size-navbar']};\n";
        $css .= "    --font-weight-navbar: {$design_navbar['font-weight-navbar']};\n";

        $css .= "    --grid-columns-navbar-escritorio-xl: {$design_navbar['grid-columns-navbar-escritorio-xl']};\n";
        $css .= "    --grid-columns-navbar-escritorio-lg: {$design_navbar['grid-columns-navbar-escritorio-lg']};\n";
        $css .= "    --grid-columns-navbar-tablet: {$design_navbar['grid-columns-navbar-tablet']};\n";
        $css .= "    --grid-columns-navbar-mobile: {$design_navbar['grid-columns-navbar-mobile']};\n";
        
        $css .= "    --btn-nav-active: {$design_navbar['btn-nav-active']};\n";
        $css .= "    --btn-nav-primary-color: {$design_navbar['btn-nav-primary-color']};\n";
        $css .= "    --btn-nav-secondary-color: {$design_navbar['btn-nav-secondary-color']};\n";
        $css .= "    --btn-nav-text-color: {$design_navbar['btn-nav-text-color']};\n";
        $css .= "}\n";
        
        wp_register_style('gica-dynamic-css_navbar', false);
        wp_enqueue_style('gica-dynamic-css_navbar');
        wp_add_inline_style('gica-dynamic-css_navbar', $css);
    }
    
}

new GICA_Design_Settings();