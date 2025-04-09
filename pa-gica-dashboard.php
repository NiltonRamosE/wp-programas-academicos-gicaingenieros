<?php
/**
 * Plugin Name: Dashboard de Programas Académicos - GicaIngenieros
 * Description: Muestra programas académicos organizados por categoría y año, con filtros y un gráfico.
 * Version: 1.1.1
 * Author: Nilton Ramos Encarnacion
 * Author URI: https://niltonramosencarnacion.vercel.app/
 * License: GPL2
 */

// Evita el acceso directo al archivo
if (!defined('ABSPATH')) {
    exit;
}

$plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
define('GICA_PLUGIN_VERSION', $plugin_data['Version']);

function gica_register_main_menu() {
    add_menu_page(
        'Dashboard de Programas Académicos',
        'Programas Académicos',
        'manage_options',
        'gica-dashboard',
        'gica_render_main_page',
        'dashicons-welcome-learn-more',
        20
    );

    add_submenu_page(
        'gica-dashboard',
        'Dashboard',
        'Dashboard',
        'manage_options',
        'gica-dashboard',
        'gica_render_main_page',
        0
    );
}
add_action('admin_menu', 'gica_register_main_menu');

require_once plugin_dir_path(__FILE__) . 'pa-gica-enqueue.php';
require_once plugin_dir_path(__FILE__) . 'pa-gica-design-settings.php';
require_once plugin_dir_path(__FILE__) . 'pa-gica-add-academic-program.php';
require_once plugin_dir_path(__FILE__) . 'pa-gica-shortcodes.php';


function gica_render_main_page() {
    $json_files = [
        'programas-virtuales' => plugin_dir_path(__FILE__) . 'assets/json/programas-virtuales.json',
        'seminarios-virtuales' => plugin_dir_path(__FILE__) . 'assets/json/seminarios-virtuales.json',
        'cursos-en-vivo' => plugin_dir_path(__FILE__) . 'assets/json/cursos-en-vivo.json',
        'seminarios-presenciales' => plugin_dir_path(__FILE__) . 'assets/json/seminarios-presenciales.json',
        'congresos' => plugin_dir_path(__FILE__) . 'assets/json/congresos.json',
        'promociones' => plugin_dir_path(__FILE__) . 'assets/json/promociones.json',
    ];

    $programs_count = [];
    $filter_count = ['categories' => 0, 'years' => []];
    $state_count = ['active' => 0, 'inactive' => 0, 'outdated' => 0];

    foreach ($json_files as $category => $file_path) {
        $json_content = file_get_contents($file_path);
        $programs = json_decode($json_content, true);

        $programs_count[$category] = 0;
        foreach ($programs as $year => $items) {
            $programs_count[$category] += count($items);

            if (!in_array($year, $filter_count['years'])) {
                $filter_count['years'][] = $year;
            }

            foreach ($items as $program) {
                if ($program['active']) {
                    $state_count['active']++;
                } else {
                    $state_count['inactive']++;
                }
                if (isset($program['updated']) && !$program['updated']) {
                    $state_count['outdated']++;
                }
            }
        }

        $filter_count['categories']++;
    }

    $filter_count['years'] = count($filter_count['years']);

    wp_localize_script('gica-dashboard-chart', 'gicaChartData', array(
        'states' => $state_count,
        'colors' => array(
            'active' => '#27ae60',
            'inactive' => '#e74c3c',
            'outdated' => '#f39c12'
        )
    ));

    $title_gica = "Dashboard GicaIngenieros";
    $redirect_page = 'admin.php?page=gica-design-settings';
    $redirect_page_name = "Personalizar Diseño";
    $third_option_name = "Exportar Datos";
    ?>
    <div class="wrap gica-academic-program">
        <?php include plugin_dir_path(__FILE__) . 'partials/pa-gica-header.php'; ?>

        <div class="gica-dashboard__grid">
            <section class="gica-academic-program__card gica-dashboard__card--summary">
                <h2 class="gica-academic-program__card-title">Resumen General</h2>
                <div class="gica-dashboard__stats">
                    <div class="gica-dashboard__stat">
                        <span class="gica-dashboard__stat-number"><?php echo array_sum($programs_count); ?></span>
                        <span class="gica-dashboard__stat-label">Programas Totales</span>
                    </div>
                    <div class="gica-dashboard__stat">
                        <span class="gica-dashboard__stat-number"><?php echo $filter_count['categories']; ?></span>
                        <span class="gica-dashboard__stat-label">Categorías</span>
                    </div>
                    <div class="gica-dashboard__stat">
                        <span class="gica-dashboard__stat-number"><?php echo $filter_count['years']; ?></span>
                        <span class="gica-dashboard__stat-label">Años</span>
                    </div>
                </div>
            </section>

            <section class="gica-academic-program__card gica-dashboard__card--shortcode">
                <h2 class="gica-academic-program__card-title">Cómo Implementar</h2>
                <div class="gica-dashboard__code-block">
                    <code class="gica-dashboard__code">[programas_academicos]</code>
                    <button class="gica-dashboard__copy-btn" data-clipboard-text="[programas_academicos]">
                        Copiar Shortcode
                    </button>
                </div>
                <p class="gica-dashboard__card-text">Incrusta este shortcode en cualquier página o entrada para mostrar los programas.</p>
            </section>
        </div>

        <section class="gica-academic-program__card gica-dashboard__card--categories">
            <h2 class="gica-academic-program__card-title">Distribución por Categoría</h2>
            <div class="gica-dashboard__categories">
                <?php foreach ($programs_count as $category => $count): ?>
                <div class="gica-dashboard__category">
                    <h3 class="gica-dashboard__category-title"><?php echo ucfirst(str_replace('-', ' ', $category)); ?></h3>
                    <div class="gica-dashboard__progress">
                        <div class="gica-dashboard__progress-bar" style="width: <?php echo ($count/max($programs_count))*100; ?>%"></div>
                    </div>
                    <span class="gica-dashboard__category-count"><?php echo $count; ?> programas</span>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="gica-academic-program__card gica-dashboard__card--states">
            <h2 class="gica-academic-program__card-title">Distribución por Estados</h2>
            <div class="gica-dashboard__chart-wrapper">
                <div class="gica-dashboard__chart-container">
                    <canvas id="gicaStatesChart"></canvas>
                </div>
                <div class="gica-dashboard__chart-legend"></div>
            </div>
            <div class="gica-dashboard__chart-total">
                Total: <?php echo array_sum($state_count) - $state_count['outdated']; ?> programas
            </div>
        </section>

        <?php include plugin_dir_path(__FILE__) . 'partials/pa-gica-actions.php'; ?>

        <?php include plugin_dir_path(__FILE__) . 'partials/pa-gica-footer.php'; ?>
    </div>

    <?php
}
