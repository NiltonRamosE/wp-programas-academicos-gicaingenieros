<?php
/**
 * Plugin Name: Dashboard de Programas Académicos - GicaIngenieros
 * Description: Muestra programas académicos organizados por categoría y año, con filtros y un gráfico.
 * Version: 1.0.1
 * Author: Nilton Ramos Encarnacion
 * Author URI: https://niltonramosencarnacion.vercel.app/
 * License: GPL2
 */

// Incluir configuración de colores
require_once plugin_dir_path(__FILE__) . 'pa-gica-color-settings.php';
require_once plugin_dir_path(__FILE__) . 'pa-gica-shortcodes.php';
require_once plugin_dir_path(__FILE__) . 'pa-gica-enqueue.php';

// Evita el acceso directo al archivo
if (!defined('ABSPATH')) {
    exit;
}

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
}
add_action('admin_menu', 'gica_register_main_menu');

function gica_render_main_page() {
    ?>
    <div class="wrap gica-dashboard">
        <header class="gica-dashboard__header">
            <h1 class="gica-dashboard__title">Dashboard de Programas Académicos</h1>
            <p class="gica-dashboard__subtitle">Administra y muestra tus programas académicos de manera profesional</p>
        </header>

        <section class="gica-dashboard__section">
            <h2 class="gica-dashboard__section-title">📌 Cómo usar el plugin</h2>
            <ul class="gica-dashboard__list">
                <li class="gica-dashboard__list-item">Usa el shortcode <code class="gica-dashboard__code">[programas_academicos]</code> en cualquier página o entrada</li>
                <li class="gica-dashboard__list-item">Edita los archivos JSON en la carpeta <code class="gica-dashboard__code">/assets/</code> para modificar los programas</li>
                <li class="gica-dashboard__list-item">Los programas se agrupan automáticamente por categoría y año</li>
                <li class="gica-dashboard__list-item">Personaliza los colores desde el menú <strong>Colores GICA</strong></li>
            </ul>
        </section>

        <section class="gica-dashboard__section">
            <h2 class="gica-dashboard__section-title">📁 Archivos disponibles</h2>
            <ul class="gica-dashboard__list">
                <li class="gica-dashboard__list-item"><code class="gica-dashboard__code">programas-virtuales.json</code></li>
                <li class="gica-dashboard__list-item"><code class="gica-dashboard__code">seminarios-virtuales.json</code></li>
                <li class="gica-dashboard__list-item"><code class="gica-dashboard__code">cursos-en-vivo.json</code></li>
                <li class="gica-dashboard__list-item"><code class="gica-dashboard__code">seminarios-presenciales.json</code></li>
                <li class="gica-dashboard__list-item"><code class="gica-dashboard__code">congresos.json</code></li>
                <li class="gica-dashboard__list-item"><code class="gica-dashboard__code">promociones.json</code></li>
            </ul>
        </section>

        <section class="gica-dashboard__section">
            <h2 class="gica-dashboard__section-title">💡 Ejemplo visual</h2>
            <div class="gica-dashboard__visual">
                <img src="https://www.gicaingenieros.com/email/images/img-gica-2.jpg" alt="Ejemplo visual del plugin">
            </div>
            <p>Así se verá el bloque generado por el shortcode en tu sitio web.</p>
        </section>

        <footer class="gica-dashboard__footer">
            <p>Plugin desarrollado por <a href="https://niltonramosencarnacion.vercel.app/" target="_blank">Nilton Ramos Encarnación</a></p>
            <p>Versión 1.1.0 | Licencia GPL2</p>
        </footer>
    </div>
    <?php
}
