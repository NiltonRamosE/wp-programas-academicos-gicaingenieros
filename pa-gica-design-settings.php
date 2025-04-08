<?php
/**
 * GICA Design Settings
 * Maneja la personalización de colores desde el panel de administración
 */

class GICA_Design_Settings {

    private $default_design_title;
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

        $this->default_colors = array(
            // Colores generales
            'primary-color' => '#092f58',
            'secondary-color' => '#63a3fa',
            'tertiary-color' => '#7f8c8d',
            
            'border-container' => '#ddd',
            'shadow-color' => 'rgba(0, 0, 0, 0.1)',
            'shadow-color-hover' => 'rgba(0, 0, 0, 0.15)',
            // Botones navbar
            'btn-nav-active' => '#082949',
            'btn-nav-primary-color' => '#f9b809',
            'btn-nav-secondary-color' => '#dd8d02',
            'btn-nav-text-color' => '#ffffff',
            
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
        add_action('wp_enqueue_scripts', array($this, 'generate_dynamic_css'), 100);
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
    }

    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
    
        $design_title = get_option('gica_design_title', array());
        $design_title = wp_parse_args($design_title, $this->default_design_title);
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
                <section class="gica-design-settings__card">
                    <h2 class="gica-design-settings__card-title">Título principal</h2>

                    <form method="post" action="options.php" class="main-title__form">
                        <?php settings_fields('gica_design_title_options'); ?>
                        <?php do_settings_sections('gica_design_title_options'); ?>
                        <table class="main-title__table">
                            <tr class="main-title__table-row">
                                <th class="main-title__table-label"><label for="title_color">Color del Título</label></th>
                                <td class="main-title__table-input">
                                    <input type="color" id="title_color" name="gica_design_title[title-color]" value="<?php echo esc_attr($design_title['title-color']); ?>" class="main-title__input--color">
                                </td>
                                <th class="main-title__table-label"><label for="text_title_size_min">Min Text Size </label></th>
                                <td class="main-title__table-input">
                                    <div class="main-title__size-input-group">
                                        <input 
                                            type="number"
                                            id="text_title_size_min_temp" 
                                            class="main-title__input--number"
                                            step="0.1"
                                            min="0.1"
                                            value="<?php echo esc_attr($this->extract_size_value($design_title['text-title-size-min'])); ?>"
                                        >
                                        
                                        <select class="main-title__unit-select ">
                                            <option value="px" <?php selected($this->extract_size_unit($design_title['text-title-size-min']), 'px'); ?>>px</option>
                                            <option value="rem" <?php selected($this->extract_size_unit($design_title['text-title-size-min']), 'rem'); ?>>rem</option>
                                        </select>
                                        
                                        <input type="hidden" 
                                            name="gica_design_title[text-title-size-min]" 
                                            id="text_title_size_min_real"
                                            value="<?php echo esc_attr($design_title['text-title-size-min']); ?>"
                                        >
                                    </div>
                                </td>
                            </tr>

                            <tr class="main-title__table-row">
                                <th class="main-title__table-label"><label for="line_title_color">Color de la Línea</label></th>
                                <td class="main-title__table-input">
                                    <input type="color" id="line_title_color" name="gica_design_title[line-title-color]" value="<?php echo esc_attr($design_title['line-title-color']); ?>" class="main-title__input--color">
                                </td>
                                <th class="main-title__table-label"><label for="text_title_size_max">Max Text Size</label></th>
                                <td class="main-title__table-input">
                                    <div class="main-title__size-input-group">
                                        <input 
                                            type="number"
                                            id="text_title_size_max_temp" 
                                            class="main-title__input--number"
                                            step="0.1"
                                            min="0.1"
                                            value="<?php echo esc_attr($this->extract_size_value($design_title['text-title-size-max'])); ?>"
                                        >
                                        
                                        <select class="main-title__unit-select ">
                                            <option value="px" <?php selected($this->extract_size_unit($design_title['text-title-size-max']), 'px'); ?>>px</option>
                                            <option value="rem" <?php selected($this->extract_size_unit($design_title['text-title-size-max']), 'rem'); ?>>rem</option>
                                        </select>
                                        
                                        <input type="hidden" 
                                            name="gica_design_title[text-title-size-max]" 
                                            id="text_title_size_max_real"
                                            value="<?php echo esc_attr($design_title['text-title-size-max']); ?>"
                                        >
                                    </div>
                                </td>
                            </tr>

                            <tr class="main-title__table-row">
                                <th class="main-title__table-label"><label for="text_title_weight">Grosor del Texto</label></th>
                                <td class="main-title__table-input" colspan="3">
                                    <select id="text_title_weight" name="gica_design_title[text-title-weight]" class="main-title__input--select">
                                        <option value="300" <?php selected($design_title['text-title-weight'], '300'); ?>>Light (300)</option>
                                        <option value="400" <?php selected($design_title['text-title-weight'], '400'); ?>>Normal (400)</option>
                                        <option value="500" <?php selected($design_title['text-title-weight'], '500'); ?>>Medium (500)</option>
                                        <option value="600" <?php selected($design_title['text-title-weight'], '600'); ?>>Semi-bold (600)</option>
                                        <option value="700" <?php selected($design_title['text-title-weight'], '700'); ?>>Bold (700)</option>
                                        <option value="800" <?php selected($design_title['text-title-weight'], '800'); ?>>Extra-bold (800)</option>
                                        <option value="900" <?php selected($design_title['text-title-weight'], '900'); ?>>Black (900)</option>
                                    </select>
                                </td>
                            </tr>
                        </table>

                        <table class="main-title__responsive-table">
                            <tr class="main-title__responsive-header">
                                <th class="main-title__responsive-title">Ancho de la Línea</th>
                                <th class="main-title__responsive-title">Normal</th>
                                <th class="main-title__responsive-title">Hover</th>
                            </tr>

                            <!-- Desktop -->
                            <tr class="main-title__responsive-row">
                                <td class="main-title__responsive-icon">
                                    <span class="main-title__icon main-title__icon--desktop"></span>
                                </td>
                                <td class="main-title__responsive-input">
                                    <input type="text" name="gica_design_title[width-title-line-base]" value="<?php echo esc_attr($design_title['width-title-line-base']); ?>" class="main-title__input--text">
                                </td>
                                <td class="main-title__responsive-input">
                                    <input type="text" name="gica_design_title[width-title-line-hover-base]" value="<?php echo esc_attr($design_title['width-title-line-hover-base']); ?>" class="main-title__input--text">
                                </td>
                            </tr>

                            <!-- Tablet -->
                            <tr class="main-title__responsive-row">
                                <td class="main-title__responsive-icon">
                                    <span class="main-title__icon main-title__icon--tablet"></span>
                                </td>
                                <td class="main-title__responsive-input">
                                    <input type="text" name="gica_design_title[width-title-line-tablet]" value="<?php echo esc_attr($design_title['width-title-line-tablet']); ?>" class="main-title__input--text">
                                </td>
                                <td class="main-title__responsive-input">
                                    <input type="text" name="gica_design_title[width-title-line-hover-tablet]" value="<?php echo esc_attr($design_title['width-title-line-hover-tablet']); ?>" class="main-title__input--text">
                                </td>
                            </tr>

                            <!-- Mobile -->
                            <tr class="main-title__responsive-row">
                                <td class="main-title__responsive-icon">
                                    <span class="main-title__icon main-title__icon--mobile"></span>
                                </td>
                                <td class="main-title__responsive-input">
                                    <input type="text" name="gica_design_title[width-title-line-mobile]" value="<?php echo esc_attr($design_title['width-title-line-mobile']); ?>" class="main-title__input--text">
                                </td>
                                <td class="main-title__responsive-input">
                                    <input type="text" name="gica_design_title[width-title-line-hover-mobile]" value="<?php echo esc_attr($design_title['width-title-line-hover-mobile']); ?>" class="main-title__input--text">
                                </td>
                            </tr>
                        </table>

                        <div class="main-title__actions">
                            <input type="hidden" name="gica_design_title[reset]" value="0" />
                            <?php submit_button('Guardar Cambios', 'primary', 'submit', false, ['class' => 'main-title__button main-title__button--primary']); ?>
                            <button type="submit" name="gica_design_title[reset-default-title]" value="1" class="main-title__button main-title__button--secondary">Restablecer a Valores Predeterminados</button>
                        </div>
                    </form>
                </section>
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
    
    private function extract_size_value($size) {
        return preg_replace('/[^0-9.]/', '', $size);
    }
    
    private function extract_size_unit($size) {
        return preg_replace('/[^a-z%]/', '', $size);
    }

    public function reset_values_title($input) {
        if (isset($input['reset-default-title']) && $input['reset-default-title'] == '1') {
            return $this->default_design_title;
        }
        return $input;
    }

    public function generate_dynamic_css() {
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
        
        wp_register_style('gica-dynamic-css', false);
        wp_enqueue_style('gica-dynamic-css');
        wp_add_inline_style('gica-dynamic-css', $css);
    }
    
}

new GICA_Design_Settings();