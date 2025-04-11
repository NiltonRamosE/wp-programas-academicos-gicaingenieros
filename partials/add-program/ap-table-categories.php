<section class="gica-academic-program__card">
    <h2 class="gica-academic-program__card-title">Categorías Añadidos</h2>
    <?php
    $categories = get_option('gica_category_programs', array());
    if (!is_array($categories)) {
        $categories = array();
    }

    ?>

    <table class="add-program__table">
        <thead class="add-program__table-head">
            <tr class="add-program__table-row">
                <th class="add-program__table-header">Categoría</th>
                <th class="add-program__table-header">Slug</th>
                <th class="add-program__table-header">Acciones</th>
            </tr>
        </thead>
        <tbody class="add-program__table-body">
            <?php
            foreach ($categories as $index => $category):
            ?>
                <tr class="add-program__table-row">
                    <td class="add-program__table-cell" data-label="Categoría"><?php echo esc_html($category['category']); ?></td>
                    <td class="add-program__table-cell" data-label="Slug"><?php echo esc_html($category['slug']); ?></td>
                    <td class="add-program__table-cell add-program__table-cell--actions" data-label="Acciones">
                        <div class="add-program__action-buttons">
                            <a href="#" class="add-program__action-btn add-program__action-btn--delete delete-category" data-index="<?php echo esc_attr($index); ?>">Eliminar</a>
                        </div>
                    </td>
                </tr>
            <?php
            endforeach;
            ?>
        </tbody>
    </table>
</section>