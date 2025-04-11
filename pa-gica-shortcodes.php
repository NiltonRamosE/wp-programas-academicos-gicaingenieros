<?php

function gica_mostrar_programas($atts) {
    ob_start();

    $programs_bd = get_option('gica_academic_programs', array());

    if (!empty($programs_bd)) {

        $first_category = key($programs_bd);
        ?>
        <div class="programas-academicos-container">
            <img src="https://www.gicaingenieros.com/email/images/img-gica-2.jpg" alt="gica-fondo-email">
            <h1 class="pa-title-main">PLANTILLAS DE PROGRAMAS ACADÉMICOS</h1>
            <nav class="programas-academicos-nav">
                <?php foreach (array_keys($programs_bd) as $category) : ?>
                    <button class="pa-nav__btn" data-program-category="<?php echo esc_attr($category); ?>">
                        <?php echo esc_html(strtoupper(str_replace('-', ' ', $category))); ?>
                    </button>
                <?php endforeach; ?>
            </nav>
            <?php foreach ($programs_bd as $category => $years) : ?>
                <section class="programas-academicos-section" id="<?php echo esc_attr($category); ?>" style="display: <?php echo $category === $first_category ? 'block' : 'none'; ?>;">
                    <h2><?php echo esc_html(ucwords(str_replace('-', ' ', $category))); ?></h2>
                    <div class="pa-filter">
                        <div class="pa-filter__year">
                            <?php foreach (array_keys($years) as $year) : ?>
                                <button class="pa-filter__btn-year" data-year="<?php echo esc_attr($year); ?>"><?php echo esc_html($year); ?></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="program-list-container">
                        <?php foreach ($years as $year => $items) :
                            foreach ($items as $programa) : 
                                
                                $statusClass = $programa['active'] ? 'active' : 'inactive';
                                $hasUpdated = $programa['updated'] ?? false;
                                $hasStatus = true;

                                ?>
                                <div class="program-item" 
                                     data-year="<?php echo esc_attr($year); ?>" 
                                     data-active="<?php echo $programa['active'] ? 'true' : 'false'; ?>" 
                                     data-updated="<?php echo $programa['updated'] ? 'true' : 'false'; ?>">

                                    <?php if($hasUpdated && !$hasStatus) : ?>
                                        <span class="status-badge updated-left">Actualizado</span>
                                    <?php endif; ?>
                                    <div class="status-badges-container">
                                        <?php if($hasStatus) { ?>
                                            <span class="status-badge <?php echo esc_attr($statusClass); ?>">
                                                <?php echo $programa['active'] ? 'Activo' : 'Inactivo'; ?>
                                            </span>
                                        <?php } ?>
                                        <?php if($hasUpdated && $hasStatus) { ?>
                                            <span class="status-badge updated">Actualizado</span>
                                        <?php } ?>
                                    </div>
                                    
                                    <a href="<?php echo esc_url($programa['url']); ?>" target="_blank">
                                        <img src="<?php echo esc_url($programa['image']); ?>" alt="<?php echo esc_attr($programa['title']); ?>">
                                    </a>
                                    <h3><?php echo esc_html($programa['title']); ?></h3>
                                    <p><?php echo esc_html($programa['code']); ?></p>
                                </div>
                                <?php 
                            endforeach;
                        endforeach; ?>
                    </div>
                    
                    <div class="pagination" id="pagination-<?php echo esc_attr($category); ?>"></div>
                </section>
            <?php endforeach; ?>
        </div>
        <?php
    } else {
        echo "<p>No hay programas disponibles.</p>";
    }

    return ob_get_clean();
}
add_shortcode('programas_academicos', 'gica_mostrar_programas');