<?php
/**
 * GICA Add Academic Program
 * Maneja la agregación de nuevos programas académicos
 */

class GICA_Add_Academic_Program {

    public function __construct() {
        add_action('admin_menu', array($this, 'register_add_program_page'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_post_add_academic_program', array($this, 'handle_form_submission'));
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
        register_setting(
            'gica_academic_program_options_group',
            'gica_academic_programs',
            array(
                'type' => 'array',
                'sanitize_callback' => array($this, 'sanitize_academic_programs'),
                'default' => array(),
            )
        );
    }  

    public function sanitize_academic_programs($input) {
        $sanitized = array();
        foreach ($input as $category => $years) {
            $sanitized[$category] = array();
            foreach ($years as $year => $programs) {
                $sanitized[$category][$year] = array();
                foreach ($programs as $program) {
                    $sanitized[$category][$year][] = array(
                        'code' => sanitize_text_field($program['code']),
                        'title' => sanitize_text_field($program['title']),
                        'image' => esc_url_raw($program['image']),
                        'url' => esc_url_raw($program['url']),
                        'active' => (bool)$program['active'],
                        'updated' => (bool)$program['updated'],
                    );
                }
            }
        }
        return $sanitized;
    }
    
    public function render_add_program_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        $current_year = date("Y");

        $title_gica = "Nuevo Programa Académico GicaIngenieros";
        $redirect_page = 'admin.php?page=gica-dashboard';
        $redirect_page_name = "Ir al Dashboard";
        $third_option_name = "Importar archivo JSON";

        $programs = get_option('gica_academic_programs', array());
        if (!is_array($programs)) {
            $programs = array();
        }

        ?>
        <div class="wrap gica-academic-program">
            <?php include plugin_dir_path(__FILE__) . 'partials/pa-gica-header.php'; ?>

            <section class="gica-academic-program__card">
                <h2 class="gica-academic-program__card-title">Añadir Programa Académico</h2>
                <form method="post" action="admin-post.php">
                    <input type="hidden" name="action" value="add_academic_program">
                    <?php wp_nonce_field('add_academic_program_nonce'); ?>

                    <label for="category_program_field">Categoría:</label>
                    <select name="category-program" id="category_program_field">
                        <option value="programas-virtuales">Programas Virtuales</option>
                        <option value="seminarios-virtuales">Seminarios Virtuales</option>
                        <option value="cursos-en-vivo">Cursos en Vivo</option>
                        <option value="seminarios-presenciales">Seminarios Presenciales</option>
                        <option value="congresos">Congresos</option>
                        <option value="promociones">Promociones</option>
                    </select><br>

                    <label for="year_publication_program_field">Año:</label>
                    <input 
                        type="number" 
                        id="year_publication_program_field" 
                        name="year-publication-program"
                        min="2000"
                        max= <?php echo $current_year; ?>
                        required
                    ><br>
                    
                    <label for="code_program_field">Código:</label>
                    <input type="text" id="code_program_field" name="code-program" required><br>
                    
                    <label for="title_program_field">Título:</label>
                    <input type="text" id="title_program_field" name="title-program" required><br>
                    
                    <label for="image_program_field">Imagen URL:</label>
                    <input type="text" id="image_program_field" name="image-program" required><br>
                    
                    <label for="url_program_field">URL:</label>
                    <input type="text" id="url_program_field" name="url-program" required><br>
                    
                    <label for="active_program_field">Activo:</label>
                    <input type="checkbox" id="active_program_field" name="active-program"><br>
                    
                    <label for="updated_program_field">Actualizado:</label>
                    <input type="checkbox" id="updated_program_field" name="updated-program"><br>
                    
                    <button type="submit">Añadir Programa</button>
                </form>
            </section>

            <section class="gica-academic-program__card">
                <h2 class="gica-academic-program__card-title">Programas Académicos Añadidos</h2>
                <?php
                $programs = get_option('gica_academic_programs', array());
                if (!is_array($programs)) {
                    $programs = array();
                }
                ?>
                <table class="wp-list-table widefat striped">
                    <thead>
                        <tr>
                            <th>Categoría</th>
                            <th>Año</th>
                            <th>Código</th>
                            <th>Título</th>
                            <th>Imagen</th>
                            <th>URL</th>
                            <th>Activo</th>
                            <th>Actualizado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($programs as $category => $years): ?>
                            <?php foreach ($years as $year => $program_list): ?>
                                <?php foreach ($program_list as $program): ?>
                                    <tr>
                                        <td><?php echo esc_html($category); ?></td>
                                        <td><?php echo esc_html($year); ?></td>
                                        <td><?php echo esc_html($program['code']); ?></td>
                                        <td><?php echo esc_html($program['title']); ?></td>
                                        <td><img src="<?php echo esc_url($program['image']); ?>" width="50"></td>
                                        <td><a href="<?php echo esc_url($program['url']); ?>" target="_blank">Ver</a></td>
                                        <td><?php echo $program['active'] ? 'Sí' : 'No'; ?></td>
                                        <td><?php echo $program['updated'] ? 'Sí' : 'No'; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>


            <?php include plugin_dir_path(__FILE__) . 'partials/pa-gica-actions.php'; ?>

            <?php include plugin_dir_path(__FILE__) . 'partials/pa-gica-footer.php'; ?>
        </div>
        <?php
    }

    public function handle_form_submission() {
        if (!current_user_can('manage_options')) {
            wp_die('No tienes permisos suficientes para añadir programas académicos.');
        }
    
        check_admin_referer('add_academic_program_nonce');
    
        $category_program_field = sanitize_text_field($_POST['category-program']);
        $year_publication_program_field = intval($_POST['year-publication-program']);
        $code_program_field = sanitize_text_field($_POST['code-program']);
        $title_program_field = sanitize_text_field($_POST['title-program']);
        $image_program_field = esc_url_raw($_POST['image-program']);
        $url_program_field = esc_url_raw($_POST['url-program']);
        $active_program_field = isset($_POST['active-program']);
        $updated_program_field = isset($_POST['updated-program']);
    
        $programs = get_option('gica_academic_programs', array());
        if (!is_array($programs)) {
            $programs = array();
        }

        if (!isset($programs[$category_program_field])) {
            $programs[$category_program_field] = array();
        }

        if (!isset($programs[$category_program_field][$year_publication_program_field])) {
            $programs[$category_program_field][$year_publication_program_field] = array();
        }
        
        $programs[$category_program_field][$year_publication_program_field][] = array(
            'code' => $code_program_field,
            'title' => $title_program_field,
            'image' => $image_program_field,
            'url' => $url_program_field,
            'active' => $active_program_field,
            'updated' => $updated_program_field,
        );

        update_option('gica_academic_programs', $programs);
    
        wp_redirect(admin_url('admin.php?page=gica-add-academic-program&status=success'));
        exit;
    }
    

}

new GICA_Add_Academic_Program();