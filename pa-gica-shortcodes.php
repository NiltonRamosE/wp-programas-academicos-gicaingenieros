<?php

function gica_mostrar_programas($atts) {
    ob_start();

    $json_files = [
        'programas-virtuales' => plugin_dir_path(__FILE__) . 'assets/json/programas-virtuales.json',
        'seminarios-virtuales' => plugin_dir_path(__FILE__) . 'assets/json/seminarios-virtuales.json',
        'cursos-en-vivo' => plugin_dir_path(__FILE__) . 'assets/json/cursos-en-vivo.json',
        'seminarios-presenciales' => plugin_dir_path(__FILE__) . 'assets/json/seminarios-presenciales.json',
        'congresos' => plugin_dir_path(__FILE__) . 'assets/json/congresos.json',
        'promociones' => plugin_dir_path(__FILE__) . 'assets/json/promociones.json',
    ];

    $data_programs = [];
    foreach ($json_files as $key => $file_path) {
        $json_content = file_get_contents($file_path);
        $data_programs[$key] = json_decode($json_content, true);
    }

    if (json_last_error() === JSON_ERROR_NONE) {
        ?>
        <div class="programas-academicos-container">
            <img src="https://www.gicaingenieros.com/email/images/img-gica-2.jpg" alt="gica-fondo-email">
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