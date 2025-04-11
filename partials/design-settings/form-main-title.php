<section class="gica-academic-program__card">
    <h2 class="gica-academic-program__card-title">Título principal</h2>

    <form method="post" action="options.php" class="main-title__form">
        <?php settings_fields('gica_design_title_options'); ?>
        <?php do_settings_sections('gica_design_title_options'); ?>
        <table class="main-title__table">
            <tr class="main-title__table-row">
                <th class="main-title__table-label"><label for="title_color">Color del Título</label></th>
                <td class="main-title__table-input" data-label="Color del Título">
                    <input type="color" id="title_color" name="gica_design_title[title-color]" value="<?php echo esc_attr($design_title['title-color']); ?>" class="main-title__input--color" required>
                </td>
                <th class="main-title__table-label"><label for="text_title_size_min_temp">Min Text Size </label></th>
                <td class="main-title__table-input" data-label="Min Text Size">
                    <div class="main-title__size-input-group">
                        <input
                            type="number"
                            id="text_title_size_min_temp"
                            class="main-title__input--number"
                            step="0.1"
                            min="0.1"
                            max="3.5"
                            value="<?php echo esc_attr($this->extract_size_value($design_title['text-title-size-min'])); ?>"
                            required
                        >

                        <select class="main-title__unit-select" required>
                            <option value="px" <?php selected($this->extract_size_unit($design_title['text-title-size-min']), 'px'); ?>>px</option>
                            <option value="rem" <?php selected($this->extract_size_unit($design_title['text-title-size-min']), 'rem'); ?>>rem</option>
                        </select>

                        <input 
                            type="hidden"
                            name="gica_design_title[text-title-size-min]"
                            id="text_title_size_min_real"
                            value="<?php echo esc_attr($design_title['text-title-size-min']); ?>"
                            required
                        >
                    </div>
                </td>
            </tr>

            <tr class="main-title__table-row">
                <th class="main-title__table-label"><label for="line_title_color">Color de la Línea</label></th>
                <td class="main-title__table-input" data-label="Color de la Línea">
                    <input type="color" id="line_title_color" name="gica_design_title[line-title-color]" value="<?php echo esc_attr($design_title['line-title-color']); ?>" class="main-title__input--color" required>
                </td>
                <th class="main-title__table-label"><label for="text_title_size_max_temp">Max Text Size</label></th>
                <td class="main-title__table-input" data-label="Max Text Size">
                    <div class="main-title__size-input-group">
                        <input
                            type="number"
                            id="text_title_size_max_temp"
                            class="main-title__input--number"
                            step="0.1"
                            min="0.1"
                            max="3.5"
                            value="<?php echo esc_attr($this->extract_size_value($design_title['text-title-size-max'])); ?>"
                            required
                        >

                        <select class="main-title__unit-select" required>
                            <option value="px" <?php selected($this->extract_size_unit($design_title['text-title-size-max']), 'px'); ?>>px</option>
                            <option value="rem" <?php selected($this->extract_size_unit($design_title['text-title-size-max']), 'rem'); ?>>rem</option>
                        </select>

                        <input 
                            type="hidden"
                            name="gica_design_title[text-title-size-max]"
                            id="text_title_size_max_real"
                            value="<?php echo esc_attr($design_title['text-title-size-max']); ?>"
                            required
                        >
                    </div>
                </td>
            </tr>

            <tr class="main-title__table-row">
                <th class="main-title__table-label"><label for="text_title_weight">Grosor del Texto</label></th>
                <td class="main-title__table-input" colspan="3" data-label="Grosor del Texto">
                    <select id="text_title_weight" name="gica_design_title[text-title-weight]" class="main-title__input--select" required>
                        <option value="300" <?php selected($design_title['text-title-weight'], '300'); ?>>Light (300)</option>
                        <option value="400" <?php selected($design_title['text-title-weight'], '400'); ?>>Normal (400)</option>
                        <option value="500" <?php selected($design_title['text-title-weight'], '500'); ?>>Medium (500)</option>
                        <option value="600" <?php selected($design_title['text-title-weight'], '600'); ?>>Semi-bold (600)</option>
                        <option value="700" <?php selected($design_title['text-title-weight'], '700'); ?>>Bold (700)</option>
                        <option value="800" <?php selected($design_title['text-title-weight'], '800'); ?>>Extra-bold (800)</option>
                        <option value="900" <?php selected($design_title['text-title-weight'], '900'); ?>>Black (900)</option>
                    </select>
                </td>
            </tr>
        </table>

        <table class="main-title__responsive-table">
            <tr class="main-title__responsive-header">
                <th class="main-title__responsive-title">Ancho de la Línea</th>
                <th class="main-title__responsive-title">Normal</th>
                <th class="main-title__responsive-title">Hover</th>
            </tr>

            <!-- Desktop -->
            <tr class="main-title__responsive-row">
                <td class="main-title__responsive-icon">
                    <span class="main-title__icon main-title__icon--desktop"></span>
                </td>
                <td class="main-title__responsive-input">
                    <input type="text" name="gica_design_title[width-title-line-base]" value="<?php echo esc_attr($design_title['width-title-line-base']); ?>" class="main-title__input--text" required>
                </td>
                <td class="main-title__responsive-input">
                    <input type="text" name="gica_design_title[width-title-line-hover-base]" value="<?php echo esc_attr($design_title['width-title-line-hover-base']); ?>" class="main-title__input--text" required>
                </td>
            </tr>

            <!-- Tablet -->
            <tr class="main-title__responsive-row">
                <td class="main-title__responsive-icon">
                    <span class="main-title__icon main-title__icon--tablet"></span>
                </td>
                <td class="main-title__responsive-input">
                    <input type="text" name="gica_design_title[width-title-line-tablet]" value="<?php echo esc_attr($design_title['width-title-line-tablet']); ?>" class="main-title__input--text" required>
                </td>
                <td class="main-title__responsive-input">
                    <input type="text" name="gica_design_title[width-title-line-hover-tablet]" value="<?php echo esc_attr($design_title['width-title-line-hover-tablet']); ?>" class="main-title__input--text" required>
                </td>
            </tr>

            <!-- Mobile -->
            <tr class="main-title__responsive-row">
                <td class="main-title__responsive-icon">
                    <span class="main-title__icon main-title__icon--mobile"></span>
                </td>
                <td class="main-title__responsive-input">
                    <input type="text" name="gica_design_title[width-title-line-mobile]" value="<?php echo esc_attr($design_title['width-title-line-mobile']); ?>" class="main-title__input--text" required>
                </td>
                <td class="main-title__responsive-input">
                    <input type="text" name="gica_design_title[width-title-line-hover-mobile]" value="<?php echo esc_attr($design_title['width-title-line-hover-mobile']); ?>" class="main-title__input--text" required>
                </td>
            </tr>
        </table>

        <div class="main-title__actions">
            <input type="hidden" name="gica_design_title[reset]" value="0" />
            <?php submit_button('Guardar Cambios', 'primary', 'submit', false, ['class' => 'main-title__button main-title__button--primary']); ?>
            <button type="submit" name="gica_design_title[reset-default-title]" value="1" class="main-title__button main-title__button--secondary">Restablecer a Valores Predeterminados</button>
        </div>
    </form>
</section>