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
        add_action('admin_post_add_category_program', array($this, 'handle_form_category'));
        add_action('wp_ajax_delete_academic_program', array($this, 'delete_academic_program'));
        add_action('wp_ajax_delete_category_program', array($this, 'delete_category_program'));
        add_action('admin_post_export_academic_programs', array($this, 'export_academic_programs'));
        add_action('admin_post_import_academic_programs', array($this, 'import_academic_programs'));
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
        register_setting(
            'gica_category_programs_options_group',
            'gica_category_programs'
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

        $title_gica = "Nuevo Programa Académico GicaIngenieros";
        $redirect_page = 'admin.php?page=gica-dashboard';
        $redirect_page_name = "Ir al Dashboard";
        $third_option_redirect_page = 'admin-post.php?action=export_academic_programs';
        $third_option_name = "Exportar archivo JSON";

        $fourth_option_name_add_program = "Importar JSON de programas";

        $programs = get_option('gica_academic_programs', array());
        if (!is_array($programs)) {
            $programs = array();
        }

        ?>
        <div class="wrap gica-academic-program">
            <?php include plugin_dir_path(__FILE__) . 'partials/pa-gica-header.php'; ?>

            <?php include plugin_dir_path(__FILE__) . 'partials/add-program/form-add-category.php'; ?>

            <?php include plugin_dir_path(__FILE__) . 'partials/add-program/ap-table-categories.php'; ?>

            <?php include plugin_dir_path(__FILE__) . 'partials/add-program/form-add-program.php'; ?>

            <?php include plugin_dir_path(__FILE__) . 'partials/add-program/ap-table-programs.php'; ?>

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
            'code' => strtoupper($code_program_field),
            'title' => strtoupper($title_program_field),
            'image' => $image_program_field,
            'url' => $url_program_field,
            'active' => $active_program_field,
            'updated' => $updated_program_field,
        );

        update_option('gica_academic_programs', $programs);
    
        wp_redirect(admin_url('admin.php?page=gica-add-academic-program&status=success'));
        exit;
    }

    public function handle_form_category() {
        if (!current_user_can('manage_options')) {
            wp_die('No tienes permisos suficientes para añadir categorías.');
        }
    
        check_admin_referer('add_category_program_nonce');
    
        $slug_program_field = sanitize_text_field($_POST['slug-program']);

        $slug = strtolower(str_replace(' ', '-', $slug_program_field));
        $category = ucwords(str_replace('-', ' ', $slug));

        $categories = get_option('gica_category_programs', array());

        if (!is_array($categories)) {
            $categories = array();
        }

        $categories[] = array(
            'slug' => $slug,
            'category' => $category,
        );

        update_option('gica_category_programs', $categories);
    
        wp_redirect(admin_url('admin.php?page=gica-add-academic-program&status=success'));
        exit;
    }

    public function delete_academic_program() {
        check_ajax_referer('delete_academic_program_nonce');

        $category = sanitize_text_field($_POST['category']);
        $year = intval($_POST['year']);
        $index = intval($_POST['index']);

        $programs = get_option('gica_academic_programs', array());

        if (isset($programs[$category][$year][$index])) {
            unset($programs[$category][$year][$index]);

            if (empty($programs[$category][$year])) {
                unset($programs[$category][$year]);
            }

            if (empty($programs[$category])) {
                unset($programs[$category]);
            }

            update_option('gica_academic_programs', $programs);
            wp_send_json_success();
        } else {
            wp_send_json_error('Programa no encontrado.');
        }
    }

    public function delete_category_program() {
        check_ajax_referer('delete_category_program_nonce');

        $index = $_POST['index'];

        $categories = get_option('gica_category_programs', array());

        if (isset($categories[$index])) {
            unset($categories[$index]);

            update_option('gica_category_programs', $categories);
            wp_send_json_success();
        } else {
            wp_send_json_error('Categoría no encontrado.');
        }
    }

    public function export_academic_programs() {
        if (!current_user_can('manage_options')) {
            wp_die('No tienes permisos suficientes.');
        }
    
        $programs = get_option('gica_academic_programs', array());
    
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="programas-academicos.json"');
        header('Pragma: no-cache');
        header('Expires: 0');
    
        echo json_encode($programs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function import_academic_programs() {
        if (!current_user_can('manage_options')) {
            wp_die('No tienes permisos suficientes.');
        }
    
        check_admin_referer('import_academic_programs_nonce');
    
        if (!isset($_FILES['import_json']) || $_FILES['import_json']['error'] !== UPLOAD_ERR_OK) {
            wp_die('Error al subir el archivo.');
        }
    
        $file = $_FILES['import_json']['tmp_name'];
        $content = file_get_contents($file);
        $imported_data = json_decode($content, true);
    
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($imported_data)) {
            wp_die('El archivo no contiene un JSON válido.');
        }
    
        $existing_programs = get_option('gica_academic_programs', array());
        $existing_categories = get_option('gica_category_programs', array());

        foreach ($imported_data as $category => $years) {
            $slug = sanitize_title($category);
            $category_name = ucwords(str_replace('-', ' ', $category));
            if (!in_array($slug, array_column($existing_categories, 'slug'))) {
                $existing_categories[] = array(
                    'slug' => $slug,
                    'category' => $category_name,
                );
            }
            foreach ($years as $year => $programs) {
                if (!isset($existing_programs[$category][$year])) {
                    $existing_programs[$category][$year] = array();
                }
    
                foreach ($programs as $program) {
                    if (!in_array($program, $existing_programs[$category][$year], true)) {
                        $existing_programs[$category][$year][] = $program;
                    }
                }
            }
        }
    
        update_option('gica_academic_programs', $existing_programs);
        update_option('gica_category_programs', $existing_categories);

        wp_redirect(admin_url('admin.php?page=gica-add-academic-program&status=imported'));
        exit;
    }
    
}

new GICA_Add_Academic_Program();