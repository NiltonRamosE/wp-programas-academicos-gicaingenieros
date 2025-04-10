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
                <form method="post" action="admin-post.php" class="add-program__form">
                    <input type="hidden" name="action" value="add_academic_program">
                    <?php wp_nonce_field('add_academic_program_nonce'); ?>

                    <div class="add-program__form-group">
                        <label for="category_program_field" class="add-program__form-label">Categoría:</label>
                        <select name="category-program" id="category_program_field" class="add-program__form-select">
                            <option value="programas-virtuales">Programas Virtuales</option>
                            <option value="seminarios-virtuales">Seminarios Virtuales</option>
                            <option value="cursos-en-vivo">Cursos en Vivo</option>
                            <option value="seminarios-presenciales">Seminarios Presenciales</option>
                            <option value="congresos">Congresos</option>
                            <option value="promociones">Promociones</option>
                        </select>
                    </div>

                    <div class="add-program__form-group">
                        <label for="year_publication_program_field" class="add-program__form-label">Año:</label>
                        <input 
                            type="number" 
                            id="year_publication_program_field" 
                            name="year-publication-program"
                            class="add-program__form-input"
                            min="2000"
                            max="<?php echo $current_year; ?>"
                            required
                        >
                    </div>
                    
                    <div class="add-program__form-group">
                        <label for="code_program_field" class="add-program__form-label">Código:</label>
                        <input type="text" id="code_program_field" name="code-program" class="add-program__form-input">
                    </div>
                    
                    <div class="add-program__form-group">
                        <label for="title_program_field" class="add-program__form-label">Título:</label>
                        <input type="text" id="title_program_field" name="title-program" class="add-program__form-input" required>
                    </div>
                    
                    <div class="add-program__form-group">
                        <label for="image_program_field" class="add-program__form-label">Imagen URL:</label>
                        <input type="text" id="image_program_field" name="image-program" class="add-program__form-input" required>
                    </div>
                    
                    <div class="add-program__form-group">
                        <label for="url_program_field" class="add-program__form-label">URL:</label>
                        <input type="text" id="url_program_field" name="url-program" class="add-program__form-input" required>
                    </div>
                    
                    <div class="add-program__form-group add-program__form-group--inline">
                        <label for="active_program_field" class="add-program__form-label add-program__form-label--checkbox">
                            <input type="checkbox" id="active_program_field" name="active-program" class="add-program__form-checkbox">
                            <span>Activo</span>
                        </label>
                    </div>
                    
                    <div class="add-program__form-group add-program__form-group--inline">
                        <label for="updated_program_field" class="add-program__form-label add-program__form-label--checkbox">
                            <input type="checkbox" id="updated_program_field" name="updated-program" class="add-program__form-checkbox">
                            <span>Actualizado</span>
                        </label>
                    </div>
                    
                    <button type="submit" class="add-program__form-submit add-program__action-btn add-program__action-btn--primary">Añadir Programa</button>
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
                <table class="add-program__table">
                    <thead class="add-program__table-head">
                        <tr class="add-program__table-row">
                            <th class="add-program__table-header">Categoría</th>
                            <th class="add-program__table-header">Año</th>
                            <th class="add-program__table-header">Código</th>
                            <th class="add-program__table-header">Imagen</th>
                            <th class="add-program__table-header">URL</th>
                            <th class="add-program__table-header">Activo</th>
                            <th class="add-program__table-header">Actualizado</th>
                            <th class="add-program__table-header">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="add-program__table-body">
                        <?php foreach ($programs as $category => $years): ?>
                            <?php foreach ($years as $year => $program_list): ?>
                                <?php foreach ($program_list as $index => $program): ?>
                                    <tr class="add-program__table-row">
                                        <td class="add-program__table-cell" data-label="Categoría"><?php echo esc_html(ucwords(str_replace('-', ' ', $category))); ?></td>
                                        <td class="add-program__table-cell" data-label="Año"><?php echo esc_html($year); ?></td>
                                        <td class="add-program__table-cell" data-label="Código"><?php echo esc_html($program['code']); ?></td>
                                        <td class="add-program__table-cell add-program__table-cell--image" data-label="Imagen">
                                            <img src="<?php echo esc_url($program['image']); ?>" class="add-program__table-image" alt="<?php echo esc_attr($program['title']); ?>">
                                        </td>
                                        <td class="add-program__table-cell" data-label="URL">
                                            <a href="<?php echo esc_url($program['url']); ?>" class="add-program__table-link" target="_blank">Ver</a>
                                        </td>
                                        <td class="add-program__table-cell add-program__table-cell--status" data-label="Activo">
                                            <span class="add-program__status-badge add-program__status-badge--<?php echo $program['active'] ? 'active' : 'inactive'; ?>">
                                                <?php echo $program['active'] ? 'Sí' : 'No'; ?>
                                            </span>
                                        </td>
                                        <td class="add-program__table-cell add-program__table-cell--status" data-label="Actualizado">
                                            <span class="add-program__status-badge add-program__status-badge--<?php echo $program['updated'] ? 'updated' : 'not-updated'; ?>">
                                                <?php echo $program['updated'] ? 'Sí' : 'No'; ?>
                                            </span>
                                        </td>
                                        <td class="add-program__table-cell add-program__table-cell--actions" data-label="Acciones">
                                            <div class="add-program__action-buttons">
                                                <a href="<?php echo admin_url('admin.php?page=gica-edit-academic-program&category=' . $category . '&year=' . $year . '&index=' . $index); ?>" class="add-program__action-btn add-program__action-btn--edit">Editar</a>
                                                <a href="#" class="add-program__action-btn add-program__action-btn--delete delete-program" data-category="<?php echo esc_attr($category); ?>" data-year="<?php echo esc_attr($year); ?>" data-index="<?php echo esc_attr($index); ?>">Eliminar</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>

            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    $('.delete-program').on('click', function(e) {
                        e.preventDefault();
                        var category = $(this).data('category');
                        var year = $(this).data('year');
                        var index = $(this).data('index');

                        if (confirm('¿Estás seguro de que deseas eliminar este programa?')) {
                            $.post(ajaxurl, {
                                action: 'delete_academic_program',
                                category: category,
                                year: year,
                                index: index,
                                _ajax_nonce: '<?php echo wp_create_nonce('delete_academic_program_nonce'); ?>'
                            }, function(response) {
                                if (response.success) {
                                    location.reload();
                                } else {
                                    alert('Ocurrió un error al eliminar el programa.');
                                }
                            });
                        }
                    });
                });
            </script>


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