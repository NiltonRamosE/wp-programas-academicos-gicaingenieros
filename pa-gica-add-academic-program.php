<?php
/**
 * GICA Add Academic Program
 * Maneja la agregación de nuevos programas académicos
 */

class GICA_Add_Academic_Program {

    public function __construct() {

        add_action('admin_menu', array($this, 'register_add_program_page'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function register_add_program_page() {
        add_submenu_page(
            'gica-dashboard',
            'Añadir Nuevo Programa Académico', 
            'Añadir Nuevo Programa Académico',
            'manage_options', 
            'gica-add-academic-program',
            array($this, 'render_add_program_page'),
            10
        );
    }

    public function register_settings() {
        /*register_setting('gica_design_title_options', 'gica_design_title', array(
            'sanitize_callback' => array($this, 'reset_values_title')
        ));*/
    }

    public function render_add_program_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        $title_gica = "Nuevo Programa Académico GicaIngenieros";
        $redirect_page = 'admin.php?page=gica-dashboard';
        $redirect_page_name = "Ir al Dashboard";
        $third_option_name = "Importar archivo JSON";
        ?>
        <div class="wrap gica-academic-program">
            <?php include plugin_dir_path(__FILE__) . 'partials/pa-gica-header.php'; ?>

            <section class="gica-academic-program__card">
                <h2 class="gica-academic-program__card-title">Añadir Programa Académico</h2>
            </section>

            <?php include plugin_dir_path(__FILE__) . 'partials/pa-gica-actions.php'; ?>

            <?php include plugin_dir_path(__FILE__) . 'partials/pa-gica-footer.php'; ?>
        </div>
        <?php
    }
    

}

new GICA_Add_Academic_Program();