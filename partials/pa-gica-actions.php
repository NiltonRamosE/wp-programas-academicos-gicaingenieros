<section class="gica-academic-program__card gica-academic-program__card--actions">
    <h2 class="gica-academic-program__card-title">Acciones Rápidas</h2>
    <div class="gica-academic-program__action-buttons">
        <a href="<?php echo admin_url($redirect_page); ?>" class="gica-academic-program__action-btn gica-academic-program__action-btn--primary">
            <?php echo $redirect_page_name; ?>
        </a>
        <a href="https://niltonramosencarnacion.vercel.app" target="_blank" class="gica-academic-program__action-btn gica-academic-program__action-btn--secondary">
            Ver Documentación
        </a>
        <a href="<?php echo admin_url($third_option_redirect_page); ?>" title="Exporta lo guardado en un archivo .json" class="gica-academic-program__action-btn gica-academic-program__action-btn--secondary">
            <span class="dashicons dashicons-download"></span> <?php echo $third_option_name; ?>
        </a>
        <?php if(isset($fourth_option_name_add_program)): ?>
            <form method="post" enctype="multipart/form-data" action="<?php echo admin_url('admin-post.php'); ?>">
                <?php wp_nonce_field('import_academic_programs_nonce'); ?>
                <input type="hidden" name="action" value="import_academic_programs">
                <input type="file" name="import_json" id="import_json" accept=".json" required>
                <label for="import_json" class="gica-academic-program__action-btn gica-academic-program__action-btn--secondary gica-academic-program__upload-file">
                    <span class="dashicons dashicons-update spin"></span> <?php echo $fourth_option_name_add_program; ?>
                </label>
                <button type="submit" class="gica-academic-program__action-btn gica-academic-program__action-btn--secondary gica-academic-program__submit-file">
                    Importar
                </button>
            </form>
        <?php endif; ?>
        <?php if(isset($fourth_option_name_design_settings)): ?>
            <form method="post" enctype="multipart/form-data" action="<?php echo admin_url('admin-post.php'); ?>">
                <?php wp_nonce_field('import_design_settings_nonce'); ?>
                <input type="hidden" name="action" value="import_design_settings">
                <input type="file" name="design_settings_file" id="design_settings_file" accept=".json" required>
                <label for="design_settings_file" class="gica-academic-program__action-btn gica-academic-program__action-btn--secondary gica-academic-program__upload-file">
                    <span class="dashicons dashicons-update spin"></span> <?php echo $fourth_option_name_design_settings; ?>
                </label>
                <button type="submit" class="gica-academic-program__action-btn gica-academic-program__action-btn--secondary gica-academic-program__submit-file">
                    Importar
                </button>
            </form>
        <?php endif; ?>
    </div>
</section>