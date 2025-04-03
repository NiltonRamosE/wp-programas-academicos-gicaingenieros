<?php
/**
 * Plugin Name: Dashboard de Programas Académicos - GicaIngenieros
 * Description: Muestra programas académicos organizados por categoría y año, con filtros y un gráfico.
 * Version: 1.1.0
 * Author: Nilton Ramos Encarnacion
 * Author URI: https://niltonramosencarnacion.vercel.app/
 * License: GPL2
 */

// Evita el acceso directo al archivo
if (!defined('ABSPATH')) {
    exit;
}

// Registrar el Custom Post Type "Programas Académicos"
function gica_registrar_cpt_programas() {
    $labels = array(
        'name'               => 'Programas Académicos',
        'singular_name'      => 'Programa Académico',
        'menu_name'          => 'Programas Académicos',
        'add_new_item'       => 'Agregar Nuevo Programa',
        'edit_item'          => 'Editar Programa',
        'new_item'           => 'Nuevo Programa',
        'all_items'          => 'Todos los Programas',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'supports'           => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'rewrite'            => array('slug' => 'programas-academicos'),
    );

    register_post_type('programas_academicos', $args);
}
add_action('init', 'gica_registrar_cpt_programas');

function gica_registrar_taxonomia_programa_academico() {
    $args = array(
        'label'        => 'Programas Académicos',
        'rewrite'      => array('slug' => 'pato-car'),
        'hierarchical' => false,
    );
    register_taxonomy('programa_academico', 'programas_academicos', $args);
}
add_action('init', 'gica_registrar_taxonomia_programa_academico');

// Registrar taxonomía "Estado de Programa"
function gica_registrar_taxonomia_estado() {
    $args = array(
        'label'        => 'Estados',
        'rewrite'      => array('slug' => 'estado-programa'),
        'hierarchical' => false,
    );
    register_taxonomy('estado_programa', 'programas_academicos', $args);
}
add_action('init', 'gica_registrar_taxonomia_estado');

// Encolar estilos del plugin
function gica_enqueue_styles() {
    wp_enqueue_style('gica-programas-style', plugin_dir_url(__FILE__) . 'assets/style.css');
}
add_action('wp_enqueue_scripts', 'gica_enqueue_styles');

// Shortcode para mostrar programas con filtros
function gica_mostrar_programas($atts) {
    ob_start();

    // Rutas a los archivos JSON
    $json_files = [
        'programas-virtuales' => plugin_dir_path(__FILE__) . 'assets/programas-virtuales.json',
        'seminarios-virtuales' => plugin_dir_path(__FILE__) . 'assets/seminarios-virtuales.json',
        'cursos-en-vivo' => plugin_dir_path(__FILE__) . 'assets/cursos-en-vivo.json',
        'seminarios-presenciales' => plugin_dir_path(__FILE__) . 'assets/seminarios-presenciales.json',
        'congresos' => plugin_dir_path(__FILE__) . 'assets/congresos.json',
        'promociones' => plugin_dir_path(__FILE__) . 'assets/promociones.json',
    ];

    // Leer y decodificar los archivos JSON
    $data_programs = [];
    foreach ($json_files as $key => $file_path) {
        $json_content = file_get_contents($file_path);
        $data_programs[$key] = json_decode($json_content, true);
    }

    // Verificar si la decodificación fue exitosa
    if (json_last_error() === JSON_ERROR_NONE) {
        ?>
        <div class="programas-academicos-container">
            <nav class="programas-academicos-nav">
                <?php foreach (array_keys($data_programs) as $category) : ?>
                    <button class="pa-nav__btn" data-program-category="<?php echo $category; ?>">
                        <?php echo strtoupper(str_replace('-', ' ', $category)); ?>
                    </button>
                <?php endforeach; ?>
            </nav>
            <?php foreach ($data_programs as $category => $programs) : ?>
                <section class="programas-academicos-section" id="<?php echo $category; ?>" style="display: <?php echo $category === 'programas-virtuales' ? 'block' : 'none'; ?>;">
                    <h2><?php echo ucwords(str_replace('-', ' ', $category)); ?></h2>
                    <div class="pa-filter">
                        <div class="pa-filter__year">
                            <?php foreach (array_keys($programs) as $year) : ?>
                                <button class="pa-filter__btn-year" data-year="<?php echo $year; ?>"><?php echo $year; ?></button>
                            <?php endforeach; ?>
                        </div>
                        <div class="pa-filter__state">
                            <button class="pa-filter__btn-state" data-state="all">Todos</button>
                            <button class="pa-filter__btn-state" data-state="active">Activos</button>
                            <button class="pa-filter__btn-state" data-state="inactive">Inactivos</button>
                            <button class="pa-filter__btn-state" data-state="updated">Actualizados</button>
                        </div>
                    </div>
                    <div class="program-list-container">
                        <?php
                        $items_per_page = 6;
                        $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                        $start_index = ($current_page - 1) * $items_per_page;
                        $end_index = $start_index + $items_per_page;
                        $item_count = 0;

                        foreach ($programs as $year => $items) {
                            foreach ($items as $programa) {
                                if ($item_count >= $start_index && $item_count < $end_index) {
                                    $statusClass = $programa['active'] ? 'active' : 'inactive';
                                    $hasUpdated = $programa['updated'];
                                    $hasStatus = true;
                                    ?>
                                    <div class="program-item" data-year="<?php echo $year; ?>" data-active="<?php echo $programa['active'] ? 'true' : 'false'; ?>" data-updated="<?php echo $programa['updated'] ? 'true' : 'false'; ?>">
                                        <?php if($hasUpdated && !$hasStatus) { ?>
                                            <span class="status-badge updated-left">Actualizado</span>
                                        <?php } ?>
                                        
                                        <div class="status-badges-container">
                                            <?php if($hasStatus) { ?>
                                                <span class="status-badge <?php echo $statusClass; ?>">
                                                    <?php echo $programa['active'] ? 'Activo' : 'Inactivo'; ?>
                                                </span>
                                            <?php } ?>
                                            
                                            <?php if($hasUpdated && $hasStatus) { ?>
                                                <span class="status-badge updated">Actualizado</span>
                                            <?php } ?>
                                        </div>
                                        
                                        <a href="<?php echo $programa['url']; ?>" target="_blank">
                                            <img src="<?php echo $programa['image']; ?>" alt="<?php echo $programa['title']; ?>">
                                        </a>
                                        <h3><?php echo $programa['title']; ?></h3>
                                        <p><?php echo $programa['code']; ?></p>
                                    </div>
                                    <?php
                                }
                                $item_count++;
                            }
                        }
                        ?>
                    </div>
                    <div class="pagination">
                        <?php
                        $total_items = $item_count;
                        $total_pages = ceil($total_items / $items_per_page);
                        $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                        if ($total_pages > 1) {
                            // Botón Anterior (opcional)
                            if ($current_page > 1) {
                                echo "<a href='?page=".($current_page-1)."' class='page-link prev'>&laquo; Anterior</a>";
                            }

                            // Números de página
                            for ($i = 1; $i <= $total_pages; $i++) {
                                $active_class = ($i == $current_page) ? 'active' : '';
                                echo "<a href='?page={$i}' class='page-link {$active_class}'>{$i}</a>";
                            }

                            // Botón Siguiente (opcional)
                            if ($current_page < $total_pages) {
                                echo "<a href='?page=".($current_page+1)."' class='page-link next'>Siguiente &raquo;</a>";
                            }
                        }
                        ?>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>

        <script>
        document.addEventListener("DOMContentLoaded", function () {
            const navButtons = document.querySelectorAll('.pa-nav__btn');
            const buttonsYear = document.querySelectorAll('.pa-filter__btn-year');
            const buttonsEstado = document.querySelectorAll('.pa-filter__btn-state');
            const programasSections = document.querySelectorAll('.programas-academicos-section');

            navButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const programCategory = this.getAttribute('data-program-category');
                    programasSections.forEach(section => {
                        section.style.display = section.id === programCategory ? 'block' : 'none';
                    });
                });
            });

            buttonsYear.forEach(button => {
                button.addEventListener('click', function () {
                    const year = this.getAttribute('data-year');
                    filtrarProgramas(year, obtenerEstadoSeleccionado());
                });
            });

            buttonsEstado.forEach(button => {
                button.addEventListener('click', function () {
                    const estado = this.getAttribute('data-state');
                    filtrarProgramas(getSelectedYear(), estado);
                });
            });

            function filtrarProgramas(year, estado) {
                const programas = document.querySelectorAll('.programa');
                programas.forEach(programa => {
                    const programYear = programa.getAttribute('data-year');
                    const programaActive = programa.getAttribute('data-active') === 'true';
                    const programaUpdated = programa.getAttribute('data-updated') === 'true';

                    let mostrar = true;
                    if (year && programYear !== year) mostrar = false;
                    if (estado === 'active' && !programaActive) mostrar = false;
                    if (estado === 'updated' && !programaUpdated) mostrar = false;

                    programa.style.display = mostrar ? 'block' : 'none';
                });
            }

            function getSelectedYear() {
                const yearActive = document.querySelector('.pa-filter__btn-year.active');
                return yearActive ? yearActive.getAttribute('data-year') : null;
            }

            function obtenerEstadoSeleccionado() {
                const estadoActivo = document.querySelector('.pa-filter__btn-state.active');
                return estadoActivo ? estadoActivo.getAttribute('data-state') : 'all';
            }
        });
        </script>
        <?php
    } else {
        echo "<p>Error al leer los archivos JSON.</p>";
    }

    return ob_get_clean();
}
add_shortcode('programas_academicos', 'gica_mostrar_programas');
