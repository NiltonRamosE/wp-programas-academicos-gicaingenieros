<?php 
    $current_year = date("Y"); 
    $categories = get_option('gica_category_programs', array());
?>
<section class="gica-academic-program__card">
    <h2 class="gica-academic-program__card-title">Añadir Programa Académico</h2>
    <form id="add-program-form" method="post" action="admin-post.php" class="add-program__form">
        <input type="hidden" name="action" value="add_academic_program">
        <?php wp_nonce_field('add_academic_program_nonce'); ?>

        <div class="add-program__form-group">
            <label for="category_program_field" class="add-program__form-label">Categoría:</label>
            <select name="category-program" id="category_program_field" class="add-program__form-select">
            <?php foreach($categories as $category): ?>
                <option value="<?php echo $category['slug']; ?>"><?php echo $category['category']; ?></option>
            <?php endforeach; ?>
            </select>
        </div>

        <div class="add-program__form-group">
            <label for="year_publication_program_field" class="add-program__form-label">Año:</label>
            <input
                type="number"
                id="year_publication_program_field"
                name="year-publication-program"
                class="add-program__form-input"
                min="2019"
                max="<?php echo $current_year; ?>"
                required>
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