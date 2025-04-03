<?php
/**
 * Plugin Name: Dashboard de Programas Académicos - GicaIngenieros
 * Description: Muestra programas académicos organizados por categoría y año, con filtros y un gráfico.
 * Version: 1.0.0
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

// Encolar el archivo JavaScript
function gica_enqueue_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('gica-pa-script-sections', plugin_dir_url(__FILE__) . 'assets/js/pa-sections.js', array('jquery'), null, true);
    wp_enqueue_script('gica-pa-script-filter-year', plugin_dir_url(__FILE__) . 'assets/js/pa-filter-year.js', array('jquery'), null, true);
    wp_enqueue_script('gica-pa-script-pagination', plugin_dir_url(__FILE__) . 'assets/js/pa-pagination.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'gica_enqueue_scripts');


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
            <img src="https://www.gicaingenieros.com/email/images/img-gica-2.jpg" alt="">
            <h1 class="pa-title-main">PLANTILLAS DE PROGRAMAS ACADÉMICOS</h1>
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
                        <!--
                        <div class="pa-filter__state">
                            <button class="pa-filter__btn-state" data-state="all">Todos</button>
                            <button class="pa-filter__btn-state" data-state="active">Activos</button>
                            <button class="pa-filter__btn-state" data-state="inactive">Inactivos</button>
                            <button class="pa-filter__btn-state" data-state="updated">Actualizados</button>
                        </div>
                        -->
                    </div>
                    <div class="program-list-container">
                        <?php foreach ($programs as $year => $items) :
                            foreach ($items as $programa) : 
                                
                                $statusClass = $programa['active'] ? 'active' : 'inactive';
                                $hasUpdated = $programa['updated'] ?? false;
                                $hasStatus = true;

                                ?>
                                <div class="program-item" 
                                     data-year="<?php echo $year; ?>" 
                                     data-active="<?php echo $programa['active'] ? 'true' : 'false'; ?>" 
                                     data-updated="<?php echo $programa['updated'] ? 'true' : 'false'; ?>">

                                    <?php if($hasUpdated && !$hasStatus) : ?>
                                        <span class="status-badge updated-left">Actualizado</span>
                                    <?php endif; ?>
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
                            endforeach;
                        endforeach; ?>
                    </div>
                    
                    <div class="pagination" id="pagination-<?php echo $category; ?>"></div>
                </section>
            <?php endforeach; ?>
        </div>
        <?php
    } else {
        echo "<p>Error al leer los archivos JSON.</p>";
    }

    return ob_get_clean();
}
add_shortcode('programas_academicos', 'gica_mostrar_programas');
