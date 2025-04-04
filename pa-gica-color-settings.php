<?php
/**
 * GICA Color Settings
 * Maneja la personalización de colores desde el panel de administración
 */

if (!defined('ABSPATH')) {
    exit; // Salir si se accede directamente
}

class GICA_Color_Settings {
    private $default_colors;

    public function __construct() {
        $this->default_colors = array(
            // Colores generales
            'primary' => '#092f58',
            'secondary' => '#f9c127',
            'tertiary' => '#63a3fa',
            'quaternary' => '#7f8c8d',
            
            // Botones navbar
            'btn_nav_active' => '#082949',
            'btn_nav_primary' => '#f9b809',
            'btn_nav_secondary' => '#dd8d02',
            'btn_nav_text' => '#ffffff',
            
            // Botones año
            'btn_year_bg' => '#f5f5f5',
            'btn_year_text' => '#333333',
            'btn_year_text_hover' => '#ffffff',
            
            // Badges estado
            'badge_active' => '#27ae60',
            'badge_inactive' => '#e74c3c',
            'badge_updated' => '#f39c12',
            
            // Paginación
            'pagination_bg' => '#f5f5f5',
            'pagination_text' => '#333333',
            'pagination_text_active' => '#ffffff'
        );

        add_action('admin_menu', array($this, 'register_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('wp_enqueue_scripts', array($this, 'generate_dynamic_css'), 100);
    }

    public function register_settings_page() {
        add_menu_page(
            'Personalización de Colores', 
            'Colores GICA', 
            'manage_options', 
            'gica-color-settings', 
            array($this, 'render_settings_page'),
            'dashicons-admin-appearance',
            80
        );
    }

    public function register_settings() {
        register_setting('gica_color_options', 'gica_colors', array(
            'sanitize_callback' => array($this, 'validate_colors')
        ));
    }

    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        $colors = get_option('gica_colors', array());
        $colors = wp_parse_args($colors, $this->default_colors);
        ?>
        <div class="wrap">
            <h1>Personalización de Colores GICA</h1>
            <form method="post" action="options.php">
                <?php settings_fields('gica_color_options'); ?>
                <?php do_settings_sections('gica_color_options'); ?>
                
                <h2>Colores Principales</h2>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="primary_color">Color Primario</label></th>
                        <td>
                            <input type="color" id="primary_color" name="gica_colors[primary]" value="<?php echo esc_attr($colors['primary']); ?>">
                            <span class="description">Color principal de la marca</span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="secondary_color">Color Secundario</label></th>
                        <td>
                            <input type="color" id="secondary_color" name="gica_colors[secondary]" value="<?php echo esc_attr($colors['secondary']); ?>">
                            <span class="description">Color secundario/accent</span>
                        </td>
                    </tr>
                    <!-- Agrega más campos según necesites -->
                </table>
                
                <?php submit_button('Guardar Cambios'); ?>
            </form>
        </div>
        <?php
    }

    public function generate_dynamic_css() {
        $colors = get_option('gica_colors', array());
        $colors = wp_parse_args($colors, $this->default_colors);
        
        $css = ":root {\n";
        $css .= "    --primary-color: {$colors['primary']};\n";
        $css .= "    --secondary-color: {$colors['secondary']};\n";
        $css .= "    --tertiary-color: {$colors['tertiary']};\n";
        $css .= "    --quaternary-color: {$colors['quaternary']};\n";
        // Agrega todas las variables CSS necesarias
        $css .= "}\n";
        
        wp_register_style('gica-dynamic-css', false);
        wp_enqueue_style('gica-dynamic-css');
        wp_add_inline_style('gica-dynamic-css', $css);
    }

    public function validate_colors($input) {
        $validated = array();
        foreach ($input as $key => $value) {
            if (preg_match('/^#([a-f0-9]{3}){1,2}$/i', $value)) {
                $validated[$key] = $value;
            } else {
                $validated[$key] = $this->default_colors[$key];
            }
        }
        return $validated;
    }
}

// Inicializar la clase
new GICA_Color_Settings();