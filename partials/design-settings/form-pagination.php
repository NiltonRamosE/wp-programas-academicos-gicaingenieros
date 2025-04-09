<section class="gica-design-settings__card">
    <h2 class="gica-design-settings__card-title">Paginación</h2>

    <form method="post" action="options.php" class="pagination__form">
        <?php settings_fields('gica_design_pagination_options'); ?>
        <?php do_settings_sections('gica_design_pagination_options'); ?>
        <table class="pagination__table">
            <tr class="pagination__table-row">
                <th class="pagination__table-label" style="text-align: center;"><label for="pagination_gap_pagination_temp">Separación</label></th>
                <th class="pagination__table-label" style="text-align: center;"><label for="pagination_border_radius">Border Radius</label></th>
                <th class="pagination__table-label" style="text-align: center;"><label for="pagination_border_radius_prev_next_pagination_temp">Border Radius Prev Next</label></th>
                <th class="pagination__table-label" style="text-align: center;"><label for="pagination_bg">Background Color</label></th>
            </tr>
            <tr class="pagination__table-row" style="text-align: center;">
                <td class="pagination__table-input">
                    <div class="pagination__size-input-group" style="gap:0px;">
                        <input
                            type="number"
                            id="pagination_gap_pagination_temp"
                            class="pagination__input--number"
                            step="0.1"
                            min="0"
                            value="<?php echo esc_attr($this->extract_size_value($design_pagination['pagination-gap'])); ?>">

                        <select class="pagination__unit-select ">
                            <option value="px" <?php selected($this->extract_size_unit($design_pagination['pagination-gap']), 'px'); ?>>px</option>
                            <option value="rem" <?php selected($this->extract_size_unit($design_pagination['pagination-gap']), 'rem'); ?>>rem</option>
                        </select>

                        <input type="hidden"
                            name="gica_design_pagination[pagination-gap]"
                            id="pagination_gap_pagination_real"
                            value="<?php echo esc_attr($design_pagination['pagination-gap']); ?>">
                    </div>
                </td>

                <td class="pagination__responsive-input">
                    <input type="text" name="gica_design_pagination[pagination-border-radius]" value="<?php echo esc_attr($design_pagination['pagination-border-radius']); ?>" class="pagination__input--text">
                </td>

                <td class="pagination__table-input">
                    <div class="pagination__size-input-group" style="gap:0px;">
                        <input
                            type="number"
                            id="pagination_border_radius_prev_next_pagination_temp"
                            class="pagination__input--number"
                            step="0.1"
                            min="0"
                            value="<?php echo esc_attr($this->extract_size_value($design_pagination['pagination-border-radius-prev-next'])); ?>">

                        <select class="pagination__unit-select ">
                            <option value="px" <?php selected($this->extract_size_unit($design_pagination['pagination-border-radius-prev-next']), 'px'); ?>>px</option>
                            <option value="rem" <?php selected($this->extract_size_unit($design_pagination['pagination-border-radius-prev-next']), 'rem'); ?>>rem</option>
                        </select>

                        <input type="hidden"
                            name="gica_design_pagination[pagination-border-radius-prev-next]"
                            id="pagination_border_radius_prev_next_pagination_real"
                            value="<?php echo esc_attr($design_pagination['pagination-border-radius-prev-next']); ?>">
                    </div>
                </td>
                <td class="pagination__table-input">
                    <input type="color" id="pagination_bg" name="gica_design_pagination[pagination-bg]" value="<?php echo esc_attr($design_pagination['pagination-bg']); ?>" class="pagination__input--color">
                </td>
            </tr>
            <tr class="pagination__table-row">
                <th class="pagination__table-label" style="text-align: center;"><label for="pagination_bg_hover">Background Hover</label></th>
                <th class="pagination__table-label" style="text-align: center;"><label for="pagination_bg_hover_active">Background Active</label></th>
                <th class="pagination__table-label" style="text-align: center;"><label for="pagination_text_color">Color del Texto</label></th>
                <th class="pagination__table-label" style="text-align: center;"><label for="pagination_text_color_active">Color del Texto Active</label></th>
            </tr>
            <tr class="pagination__table-row" style="text-align: center;">
                <td class="pagination__table-input">
                    <input type="color" id="pagination_bg_hover" name="gica_design_pagination[pagination-bg-hover]" value="<?php echo esc_attr($design_pagination['pagination-bg-hover']); ?>" class="pagination__input--color">
                </td>
                <td class="pagination__table-input">
                    <input type="color" id="pagination_bg_hover_active" name="gica_design_pagination[pagination-bg-hover-active]" value="<?php echo esc_attr($design_pagination['pagination-bg-hover-active']); ?>" class="pagination__input--color">
                </td>
                <td class="pagination__table-input">
                    <input type="color" id="pagination_text_color" name="gica_design_pagination[pagination-text-color]" value="<?php echo esc_attr($design_pagination['pagination-text-color']); ?>" class="pagination__input--color">
                </td>
                <td class="pagination__table-input">
                    <input type="color" id="pagination_text_color_active" name="gica_design_pagination[pagination-text-color-active]" value="<?php echo esc_attr($design_pagination['pagination-text-color-active']); ?>" class="pagination__input--color">
                </td>
            </tr>
            <tr class="pagination__table-row">
                <th class="pagination__table-label" style="text-align: center;"><label for="pagination_font_weight">Grosor del Texto</label></th>
                <td class="pagination__table-input" colspan="3">
                    <select id="pagination_font_weight" name="gica_design_pagination[pagination-font-weight]" class="pagination__input--select">
                        <option value="300" <?php selected($design_pagination['pagination-font-weight'], '300'); ?>>Light (300)</option>
                        <option value="400" <?php selected($design_pagination['pagination-font-weight'], '400'); ?>>Normal (400)</option>
                        <option value="500" <?php selected($design_pagination['pagination-font-weight'], '500'); ?>>Medium (500)</option>
                        <option value="600" <?php selected($design_pagination['pagination-font-weight'], '600'); ?>>Semi-bold (600)</option>
                        <option value="700" <?php selected($design_pagination['pagination-font-weight'], '700'); ?>>Bold (700)</option>
                        <option value="800" <?php selected($design_pagination['pagination-font-weight'], '800'); ?>>Extra-bold (800)</option>
                        <option value="900" <?php selected($design_pagination['pagination-font-weight'], '900'); ?>>Black (900)</option>
                    </select>
                </td>
            </tr>
        </table>
        

        <div class="pagination__actions">
            <input type="hidden" name="gica_design_pagination[reset]" value="0" />
            <?php submit_button('Guardar Cambios', 'primary', 'submit', false, ['class' => 'pagination__button pagination__button--primary']); ?>
            <button type="submit" name="gica_design_pagination[reset-default-pagination]" value="1" class="pagination__button pagination__button--secondary">Restablecer a Valores Predeterminados</button>
        </div>
    </form>
</section>