<section class="gica-academic-program__card">
    <h2 class="gica-academic-program__card-title">Añadir Categoría de Programa Académico</h2>
    <form id="add-program-form" method="post" action="admin-post.php" class="add-program__form">
        <input type="hidden" name="action" value="add_category_program">
        <?php wp_nonce_field('add_category_program_nonce'); ?>

        <div class="add-program__form-group">
            <label for="slug_program_field" class="add-program__form-label">Slug (sin caracteres especiales):</label>
            <input type="text" id="slug_program_field" name="slug-program" class="add-program__form-input" placeholder="Ejemplo: cursos-en-vivo" required>
        </div>
        <div class="add-program__form-group">
            <button type="submit" class="add-program__form-submit add-program__action-btn add-program__action-btn--primary">Añadir Categoría</button>
        </div>
    </form>
</section>