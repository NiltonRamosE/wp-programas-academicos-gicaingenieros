<?php
/**
 * GICA Design Settings
 * Maneja la personalización de colores desde el panel de administración
 */

class GICA_Design_Settings {
    private $default_colors;

    public function __construct() {
        $this->default_colors = array(
            // Título principal
            
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
        register_setting('gica_design_options', 'gica_design', array(
            'sanitize_callback' => array($this, 'validate_colors')
        ));
    }

    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
    
        $colors = get_option('gica_design', array());
        $colors = wp_parse_args($colors, $this->default_colors);
        ?>
        <div class="wrap gica-design-settings">
            <h1>Diseño de ShortCode - GICA</h1>

            <form method="post" action="options.php">
                <?php settings_fields('gica_design_options'); ?>
                <?php do_settings_sections('gica_design_options'); ?>
    
                <h2>Colores Principales</h2>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="primary_color">Primario</label></th>
                        <td>
                            <input type="color" id="primary_color" name="gica_design[primary-color]" value="<?php echo esc_attr($colors['primary-color']); ?>">
                            <span class="description">Color principal de la marca</span>
                            <span class="gica-help-tooltip" data-help="Título principal y su línea subrayada, título del card y gradiente derecho del filtro de año.">
                                ?
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="secondary_color">Secundario</label></th>
                        <td>
                            <input type="color" id="secondary_color" name="gica_design[secondary-color]" value="<?php echo esc_attr($colors['secondary-color']); ?>">
                            <span class="description">Color secundario</span>
                            <span class="gica-help-tooltip" data-help="Gradiente izquierdo del filtro de año.">
                                ?
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="quaternary_color">Terciario</label></th>
                        <td>
                            <input type="color" id="quaternary_color" name="gica_design[tertiary-color]" value="<?php echo esc_attr($colors['tertiary-color']); ?>">
                            <span class="description">Color terciario</span>
                            <span class="gica-help-tooltip" data-help="Subtítulo del card.">
                                ?
                            </span>
                        </td>
                    </tr>
                </table>
    
                <input type="hidden" name="gica_design[reset]" value="0" />
                <?php submit_button('Guardar Cambios'); ?>
                <button type="submit" name="gica_design[reset]" value="1" class="button button-secondary">Restablecer a Valores Predeterminados</button>
            </form>
        </div>
        <?php
    }
    

    public function generate_dynamic_css() {
        $colors = get_option('gica_design', array());
        $colors = wp_parse_args($colors, $this->default_colors);
        
        $css = ":root {\n";
        $css .= "    --primary-color: {$colors['primary-color']};\n";
        $css .= "    --secondary-color: {$colors['secondary-color']};\n";
        $css .= "    --tertiary-color: {$colors['tertiary-color']};\n";

        $css .= "    --border-container: {$colors['border-container']};\n";
        $css .= "    --shadow-color: {$colors['shadow-color']};\n";
        $css .= "    --shadow-color-hover: {$colors['shadow-color-hover']};\n";

        $css .= "    --btn-nav-active: {$colors['btn-nav-active']};\n";
        $css .= "    --btn-nav-primary-color: {$colors['btn-nav-primary-color']};\n";
        $css .= "    --btn-nav-secondary-color: {$colors['btn-nav-secondary-color']};\n";
        $css .= "    --btn-nav-text-color: {$colors['btn-nav-text-color']};\n";
        
        $css .= "    --btn-year-bg: {$colors['btn-year-bg']};\n";
        $css .= "    --btn-year-text: {$colors['btn-year-text']};\n";
        $css .= "    --btn-year-text-hover: {$colors['btn-year-text-hover']};\n";

        $css .= "    --badge-state-active: {$colors['badge-state-active']};\n";
        $css .= "    --badge-state-inactive: {$colors['badge-state-inactive']};\n";
        $css .= "    --badge-state-updated: {$colors['badge-state-updated']};\n";

        $css .= "    --pagination-bg: {$colors['pagination-bg']};\n";
        $css .= "    --pagination-bg-hover: {$colors['pagination-bg-hover']};\n";
        $css .= "    --pagination-bg-hover-active: {$colors['pagination-bg-hover-active']};\n";
        $css .= "    --pagination-text-color: {$colors['pagination-text-color']};\n";
        $css .= "    --pagination-text-color-active: {$colors['pagination-text-color-active']};\n";

        $css .= "}\n";
        
        wp_register_style('gica-dynamic-css', false);
        wp_enqueue_style('gica-dynamic-css');
        wp_add_inline_style('gica-dynamic-css', $css);
    }

    public function validate_colors($input) {
        $validated = array();
        foreach ($input as $key => $value) {
            if ($key === 'reset' && $value == '1') {
                // Restablecer a los valores predeterminados
                return $this->default_colors;
            } elseif (preg_match('/^#([a-f0-9]{3}){1,2}$/i', $value)) {
                $validated[$key] = $value;
            } else {
                $validated[$key] = $this->default_colors[$key];
            }
        }
        return $validated;
    }
    
}

new GICA_Design_Settings();