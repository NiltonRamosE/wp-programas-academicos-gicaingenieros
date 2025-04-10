<section class="gica-academic-program__card">
    <h2 class="gica-academic-program__card-title">Programas Académicos Añadidos</h2>
    <?php
    $programs = get_option('gica_academic_programs', array());
    if (!is_array($programs)) {
        $programs = array();
    }

    $items_per_page = 6;

    $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;

    $start_index = ($current_page - 1) * $items_per_page;
    $end_index = $start_index + $items_per_page;

    $total_programs = 0;
    foreach ($programs as $category => $years) {
        foreach ($years as $year => $program_list) {
            $total_programs += count($program_list);
        }
    }

    $total_pages = ceil($total_programs / $items_per_page);
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
            <?php
            $current_index = 0;
            foreach ($programs as $category => $years):
                foreach ($years as $year => $program_list):
                    foreach ($program_list as $index => $program):
                        if ($current_index >= $start_index && $current_index < $end_index):
            ?>
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
            <?php
                        endif;
                        $current_index++;
                    endforeach;
                endforeach;
            endforeach;
            ?>
        </tbody>
    </table>
    <?php
    echo "<pre>";
    echo print_r($programs);
    echo "</pre>";
    ?>
    <?php if ($total_pages > 1): ?>
        <div class="add-program__pagination">
            <?php if ($current_page > 1): ?>
                <a href="<?php echo add_query_arg('paged', $current_page - 1); ?>" class="add-program__pagination-link add-program__pagination-link--prev">&laquo; Anterior</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $current_page): ?>
                    <span class="add-program__pagination-item add-program__pagination-item--current"><?php echo $i; ?></span>
                <?php else: ?>
                    <a href="<?php echo add_query_arg('paged', $i); ?>" class="add-program__pagination-link"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages): ?>
                <a href="<?php echo add_query_arg('paged', $current_page + 1); ?>" class="add-program__pagination-link add-program__pagination-link--next">Siguiente &raquo;</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>