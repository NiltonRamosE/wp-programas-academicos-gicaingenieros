<section class="gica-academic-program__card">
    <h2 class="gica-academic-program__card-title">Filtros</h2>

    <form method="post" action="options.php" class="filters__form">
        <?php settings_fields('gica_design_filters_options'); ?>
        <?php do_settings_sections('gica_design_filters_options'); ?>
        <table class="filters__table">
            <tr class="filters__table-row">
                <th class="filters__table-label" style="text-align: center; font-weight:bold; font-size:16px;"><label>Sección General</label></th>
                <th class="filters__table-label" style="text-align: center;"><label for="border_container_section">Borde</label></th>
                <th class="filters__table-label" style="text-align: center;"><label for="padding_container_section_filters_temp">Padding</label></th>
                <th class="filters__table-label" style="text-align: center;"><label for="margin_top_container_section_filters_temp">Margin-top</label></th>
            </tr>
            <tr class="filters__table-row" style="text-align: center;">
                <td class="filters__table-input"></td>
                <td class="filters__table-input">
                    <input type="color" id="border_container_section" name="gica_design_filters[border-container-section]" value="<?php echo esc_attr($design_filters['border-container-section']); ?>" class="filters__input--color" required>
                </td>
                <td class="filters__table-input">
                    <div class="filters__size-input-group" style="gap:0px;">
                        <input
                            type="number"
                            id="padding_container_section_filters_temp"
                            class="filters__input--number"
                            step="0.1"
                            min="0"
                            max="20"
                            value="<?php echo esc_attr($this->extract_size_value($design_filters['padding-container-section'])); ?>"
                            required
                        >

                        <select class="filters__unit-select" required>
                            <option value="px" <?php selected($this->extract_size_unit($design_filters['padding-container-section']), 'px'); ?>>px</option>
                            <option value="rem" <?php selected($this->extract_size_unit($design_filters['padding-container-section']), 'rem'); ?>>rem</option>
                        </select>

                        <input 
                            type="hidden"
                            name="gica_design_filters[padding-container-section]"
                            id="padding_container_section_filters_real"
                            value="<?php echo esc_attr($design_filters['padding-container-section']); ?>"
                            required
                        >
                    </div>
                </td>
                <td class="filters__table-input">
                    <div class="filters__size-input-group" style="gap:0px;">
                        <input
                            type="number"
                            id="margin_top_container_section_filters_temp"
                            class="filters__input--number"
                            step="1"
                            min="0"
                            max="200"
                            value="<?php echo esc_attr($this->extract_size_value($design_filters['margin-top-container-section'])); ?>"
                            required
                        >

                        <select class="filters__unit-select" required>
                            <option value="px" <?php selected($this->extract_size_unit($design_filters['margin-top-container-section']), 'px'); ?>>px</option>
                            <option value="rem" <?php selected($this->extract_size_unit($design_filters['margin-top-container-section']), 'rem'); ?>>rem</option>
                        </select>

                        <input 
                            type="hidden"
                            name="gica_design_filters[margin-top-container-section]"
                            id="margin_top_container_section_filters_real"
                            value="<?php echo esc_attr($design_filters['margin-top-container-section']); ?>"
                            required
                        >
                    </div>
                </td>
            </tr>
        </table>
        <table class="filters__table">
            <tr class="filters__table-row">
                <th class="filters__table-label" style="text-align: center; font-weight:bold; font-size:16px;"><label>Contenido</label></th>
                <th class="filters__table-label" style="text-align: center;"><label for="margin_bottom_container_filter_filters_temp">Margin Bottom</label></th>
                <th class="filters__table-label" style="text-align: center;"><label for="gap_filter_year_filters_temp">Separación de botones</label></th>
                <th class="filters__table-label" style="text-align: center;"><label for="min_width_filter_year_filters_temp">Min width button</label></th>
            </tr>
            <tr class="filters__table-row" style="text-align: center;">
                <td class="filters__table-input"></td>
                <td class="filters__table-input">
                    <div class="filters__size-input-group" style="gap:0px;">
                        <input
                            type="number"
                            id="margin_bottom_container_filter_filters_temp"
                            class="filters__input--number"
                            step="1"
                            min="0"
                            max="200"
                            value="<?php echo esc_attr($this->extract_size_value($design_filters['margin-bottom-container-filter'])); ?>"
                            required
                        >

                        <select class="filters__unit-select" required>
                            <option value="px" <?php selected($this->extract_size_unit($design_filters['margin-bottom-container-filter']), 'px'); ?>>px</option>
                            <option value="rem" <?php selected($this->extract_size_unit($design_filters['margin-bottom-container-filter']), 'rem'); ?>>rem</option>
                        </select>

                        <input 
                            type="hidden"
                            name="gica_design_filters[margin-bottom-container-filter]"
                            id="margin_bottom_container_filter_filters_real"
                            value="<?php echo esc_attr($design_filters['margin-bottom-container-filter']); ?>"
                            required
                        >
                    </div>
                </td>
                <td class="filters__table-input">
                    <div class="filters__size-input-group" style="gap:0px;">
                        <input
                            type="number"
                            id="gap_filter_year_filters_temp"
                            class="filters__input--number"
                            step="0.5"
                            min="0"
                            max="200"
                            value="<?php echo esc_attr($this->extract_size_value($design_filters['gap-filter-year'])); ?>"
                            required
                        >

                        <select class="filters__unit-select" required>
                            <option value="px" <?php selected($this->extract_size_unit($design_filters['gap-filter-year']), 'px'); ?>>px</option>
                            <option value="rem" <?php selected($this->extract_size_unit($design_filters['gap-filter-year']), 'rem'); ?>>rem</option>
                        </select>

                        <input 
                            type="hidden"
                            name="gica_design_filters[gap-filter-year]"
                            id="gap_filter_year_filters_real"
                            value="<?php echo esc_attr($design_filters['gap-filter-year']); ?>"
                            required
                        >
                    </div>
                </td>
                <td class="filters__table-input">
                    <div class="filters__size-input-group" style="gap:0px;">
                        <input
                            type="number"
                            id="min_width_filter_year_filters_temp"
                            class="filters__input--number"
                            step="1"
                            min="50"
                            max="200"
                            value="<?php echo esc_attr($this->extract_size_value($design_filters['min-width-filter-year'])); ?>"
                            required
                        >

                        <select class="filters__unit-select" required>
                            <option value="px" <?php selected($this->extract_size_unit($design_filters['min-width-filter-year']), 'px'); ?>>px</option>
                            <option value="rem" <?php selected($this->extract_size_unit($design_filters['min-width-filter-year']), 'rem'); ?>>rem</option>
                        </select>

                        <input 
                            type="hidden"
                            name="gica_design_filters[min-width-filter-year]"
                            id="min_width_filter_year_filters_real"
                            value="<?php echo esc_attr($design_filters['min-width-filter-year']); ?>"
                            required
                        >
                    </div>
                </td>
            </tr>
            
            <tr class="filters__table-row">
                <th class="filters__table-label" style="text-align: center; font-weight:bold; font-size:16px;"><label>Componentes</label></th>
                <th class="filters__table-label" style="text-align: center;"><label for="border_radius_filter_year_filters_temp">Border Radius</label></th>
                <th class="filters__table-label" style="text-align: center;"><label for="font_size_filter_year_filters_temp">Text Size</label></th>
                <th class="filters__table-label" style="text-align: center;"><label for="filter_color">Color del Texto</label></th>
            </tr>

            <tr class="filters__table-row" style="text-align: center;">
                <td class="filters__table-input"></td>
                <td class="filters__table-input">
                    <div class="filters__size-input-group" style="gap:0px;">
                        <input
                            type="number"
                            id="border_radius_filter_year_filters_temp"
                            class="filters__input--number"
                            step="0.1"
                            min="0"
                            max="25"
                            value="<?php echo esc_attr($this->extract_size_value($design_filters['border-radius-filter-year'])); ?>"
                            required
                        >

                        <select class="filters__unit-select" required>
                            <option value="px" <?php selected($this->extract_size_unit($design_filters['border-radius-filter-year']), 'px'); ?>>px</option>
                            <option value="rem" <?php selected($this->extract_size_unit($design_filters['border-radius-filter-year']), 'rem'); ?>>rem</option>
                        </select>

                        <input 
                            type="hidden"
                            name="gica_design_filters[border-radius-filter-year]"
                            id="border_radius_filter_year_filters_real"
                            value="<?php echo esc_attr($design_filters['border-radius-filter-year']); ?>"
                            required
                        >
                    </div>
                </td>
                <td class="filters__table-input">
                    <div class="filters__size-input-group" style="gap:0px;">
                        <input
                            type="number"
                            id="font_size_filter_year_filters_temp"
                            class="filters__input--number"
                            step="1"
                            min="1"
                            max="200"
                            value="<?php echo esc_attr($this->extract_size_value($design_filters['font-size-filter-year'])); ?>"
                            required
                        >

                        <select class="filters__unit-select" required>
                            <option value="px" <?php selected($this->extract_size_unit($design_filters['font-size-filter-year']), 'px'); ?>>px</option>
                            <option value="rem" <?php selected($this->extract_size_unit($design_filters['font-size-filter-year']), 'rem'); ?>>rem</option>
                        </select>

                        <input 
                            type="hidden"
                            name="gica_design_filters[font-size-filter-year]"
                            id="font_size_filter_year_filters_real"
                            value="<?php echo esc_attr($design_filters['font-size-filter-year']); ?>"
                            required
                        >
                    </div>
                </td>
                <td class="filters__table-input">
                    <input type="color" id="filter_color" name="gica_design_filters[filter-color]" value="<?php echo esc_attr($design_filters['filter-color']); ?>" class="filters__input--color" required>
                </td>
            </tr>

            <tr class="filters__table-row">
                <th class="filters__table-label" style="text-align: center;"><label for="filter_primary_color">Color Primario</label></th>
                <th class="filters__table-label" style="text-align: center;"><label for="filter_secondary_color">Color Secundario</label></th>
                <th class="filters__table-label" style="text-align: center;"><label for="filter_hover_color">Hover Color</label></th>
                <th class="filters__table-label" style="text-align: center;"><label for="filter_bg_color">Background Color</label></th>
            </tr>
            <tr class="filters__table-row" style="text-align: center;">
                <td class="filters__table-input">
                    <input type="color" id="filter_primary_color" name="gica_design_filters[filter-primary-color]" value="<?php echo esc_attr($design_filters['filter-primary-color']); ?>" class="filters__input--color" required>
                </td>
                <td class="filters__table-input">
                    <input type="color" id="filter_secondary_color" name="gica_design_filters[filter-secondary-color]" value="<?php echo esc_attr($design_filters['filter-secondary-color']); ?>" class="filters__input--color" required>
                </td>
                <td class="filters__table-input">
                    <input type="color" id="filter_hover_color" name="gica_design_filters[filter-hover-color]" value="<?php echo esc_attr($design_filters['filter-hover-color']); ?>" class="filters__input--color" required>
                </td>
                <td class="filters__table-input">
                    <input type="color" id="filter_bg_color" name="gica_design_filters[filter-bg-color]" value="<?php echo esc_attr($design_filters['filter-bg-color']); ?>" class="filters__input--color" required>
                </td>
            </tr>

            <tr class="filters__table-row">
                <th class="filters__table-label" style="text-align: center;"><label for="font_weight_filter_year">Grosor del Texto</label></th>
                <td class="filters__table-input" colspan="3">
                    <select id="font_weight_filter_year" name="gica_design_filters[font-weight-filter-year]" class="filters__input--select" required>
                        <option value="300" <?php selected($design_filters['font-weight-filter-year'], '300'); ?>>Light (300)</option>
                        <option value="400" <?php selected($design_filters['font-weight-filter-year'], '400'); ?>>Normal (400)</option>
                        <option value="500" <?php selected($design_filters['font-weight-filter-year'], '500'); ?>>Medium (500)</option>
                        <option value="600" <?php selected($design_filters['font-weight-filter-year'], '600'); ?>>Semi-bold (600)</option>
                        <option value="700" <?php selected($design_filters['font-weight-filter-year'], '700'); ?>>Bold (700)</option>
                        <option value="800" <?php selected($design_filters['font-weight-filter-year'], '800'); ?>>Extra-bold (800)</option>
                        <option value="900" <?php selected($design_filters['font-weight-filter-year'], '900'); ?>>Black (900)</option>
                    </select>
                </td>
            </tr>
        </table>

        <div class="filters__actions">
            <input type="hidden" name="gica_design_filters[reset]" value="0" />
            <?php submit_button('Guardar Cambios', 'primary', 'submit', false, ['class' => 'filters__button filters__button--primary']); ?>
            <button type="submit" name="gica_design_filters[reset-default-filters]" value="1" class="filters__button filters__button--secondary">Restablecer a Valores Predeterminados</button>
        </div>
    </form>
</section>