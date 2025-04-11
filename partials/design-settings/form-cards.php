<section class="gica-academic-program__card">
    <h2 class="gica-academic-program__card-title">Cards</h2>

    <form method="post" action="options.php" class="cards__form">
        <?php settings_fields('gica_design_cards_options'); ?>
        <?php do_settings_sections('gica_design_cards_options'); ?>
        <table class="cards__table">
            <tr class="cards__table-row">
                <th class="cards__table-label" style="text-align: center;"><label for="border_radius_card_cards_temp">Border Radius</label></th>
                <th class="cards__table-label" style="text-align: center;"><label for="title_color_card">Color del título</label></th>
                <th class="cards__table-label" style="text-align: center;"><label for="subtitle_color_card">Color del Subtítulo</label></th>
                <th class="cards__table-label" style="text-align: center;"><label for="title_font_size_card_cards_temp">Title Text Size</label></th>
            </tr>
            <tr class="cards__table-row" style="text-align: center;">
                <td class="cards__table-input" data-label="Border Radius">
                    <div class="cards__size-input-group" style="gap:0px;">
                        <input
                            type="number"
                            id="border_radius_card_cards_temp"
                            class="cards__input--number"
                            step="0.1"
                            min="0"
                            max="250"
                            value="<?php echo esc_attr($this->extract_size_value($design_cards['border-radius-card'])); ?>"
                            required
                        >

                        <select class="cards__unit-select" required>
                            <option value="px" <?php selected($this->extract_size_unit($design_cards['border-radius-card']), 'px'); ?>>px</option>
                            <option value="rem" <?php selected($this->extract_size_unit($design_cards['border-radius-card']), 'rem'); ?>>rem</option>
                        </select>

                        <input 
                            type="hidden"
                            name="gica_design_cards[border-radius-card]"
                            id="border_radius_card_cards_real"
                            value="<?php echo esc_attr($design_cards['border-radius-card']); ?>"
                            required
                        >
                    </div>
                </td>

                <td class="cards__table-input" data-label="Color del título">
                    <input type="color" id="title_color_card" name="gica_design_cards[title-color-card]" value="<?php echo esc_attr($design_cards['title-color-card']); ?>" class="cards__input--color" required>
                </td>

                <td class="cards__table-input" data-label="Color del Subtítulo">
                    <input type="color" id="subtitle_color_card" name="gica_design_cards[subtitle-color-card]" value="<?php echo esc_attr($design_cards['subtitle-color-card']); ?>" class="cards__input--color" required>
                </td>

                <td class="cards__table-input" data-label="Title Text Size">
                    <div class="cards__size-input-group" style="gap:0px;">
                        <input
                            type="number"
                            id="title_font_size_card_cards_temp"
                            class="cards__input--number"
                            step="0.5"
                            min="1"
                            max="50"
                            value="<?php echo esc_attr($this->extract_size_value($design_cards['title-font-size-card'])); ?>"
                            required
                        >

                        <select class="cards__unit-select" required>
                            <option value="px" <?php selected($this->extract_size_unit($design_cards['title-font-size-card']), 'px'); ?>>px</option>
                            <option value="rem" <?php selected($this->extract_size_unit($design_cards['title-font-size-card']), 'rem'); ?>>rem</option>
                        </select>

                        <input 
                            type="hidden"
                            name="gica_design_cards[title-font-size-card]"
                            id="title_font_size_card_cards_real"
                            value="<?php echo esc_attr($design_cards['title-font-size-card']); ?>"
                            required
                        >
                    </div>
                </td>
            </tr>
            <tr class="cards__table-row">
                <th class="cards__table-label" style="text-align: center;"><label for="subtitle_font_size_card_cards_temp">Subtitle Text Size</label></th>
                <th class="cards__table-label" style="text-align: center;"><label for="badge_state_active_card">Color de Estado Activo</label></th>
                <th class="cards__table-label" style="text-align: center;"><label for="badge_state_inactive_card">Color de Estado Inactivo</label></th>
                <th class="cards__table-label" style="text-align: center;"><label for="badge_state_updated_card">Color de Estado Actualizado</label></th>
            </tr>
            <tr class="cards__table-row" style="text-align: center;">
                <td class="cards__table-input" data-label="Subtitle Text Size">
                    <div class="cards__size-input-group" style="gap:0px;">
                        <input
                            type="number"
                            id="subtitle_font_size_card_cards_temp"
                            class="cards__input--number"
                            step="0.5"
                            min="1"
                            max="50"
                            value="<?php echo esc_attr($this->extract_size_value($design_cards['subtitle-font-size-card'])); ?>"
                            required
                        >

                        <select class="cards__unit-select" required>
                            <option value="px" <?php selected($this->extract_size_unit($design_cards['subtitle-font-size-card']), 'px'); ?>>px</option>
                            <option value="rem" <?php selected($this->extract_size_unit($design_cards['subtitle-font-size-card']), 'rem'); ?>>rem</option>
                        </select>

                        <input 
                            type="hidden"
                            name="gica_design_cards[subtitle-font-size-card]"
                            id="subtitle_font_size_card_cards_real"
                            value="<?php echo esc_attr($design_cards['subtitle-font-size-card']); ?>"
                            required
                        >
                    </div>
                </td>

                <td class="cards__table-input" data-label="Color de Estado Activo">
                    <input type="color" id="badge_state_active_card" name="gica_design_cards[badge-state-active-card]" value="<?php echo esc_attr($design_cards['badge-state-active-card']); ?>" class="cards__input--color" required>
                </td>

                <td class="cards__table-input" data-label="Color de Estado Inactivo">
                    <input type="color" id="badge_state_inactive_card" name="gica_design_cards[badge-state-inactive-card]" value="<?php echo esc_attr($design_cards['badge-state-inactive-card']); ?>" class="cards__input--color" required>
                </td>

                <td class="cards__table-input" data-label="GColor de Estado Actualizado">
                    <input type="color" id="badge_state_updated_card" name="gica_design_cards[badge-state-updated-card]" value="<?php echo esc_attr($design_cards['badge-state-updated-card']); ?>" class="cards__input--color" required>
                </td>
            </tr>
            <tr class="cards__table-row">
                <th class="cards__table-label" style="text-align: center;"><label for="title_font_weight_card">Grosor del Texto</label></th>
                <td class="cards__table-input" data-label="Grosor del Texto" colspan="3">
                    <select id="title_font_weight_card" name="gica_design_cards[title-font-weight-card]" class="cards__input--select" required>
                        <option value="300" <?php selected($design_cards['title-font-weight-card'], '300'); ?>>Light (300)</option>
                        <option value="400" <?php selected($design_cards['title-font-weight-card'], '400'); ?>>Normal (400)</option>
                        <option value="500" <?php selected($design_cards['title-font-weight-card'], '500'); ?>>Medium (500)</option>
                        <option value="600" <?php selected($design_cards['title-font-weight-card'], '600'); ?>>Semi-bold (600)</option>
                        <option value="700" <?php selected($design_cards['title-font-weight-card'], '700'); ?>>Bold (700)</option>
                        <option value="800" <?php selected($design_cards['title-font-weight-card'], '800'); ?>>Extra-bold (800)</option>
                        <option value="900" <?php selected($design_cards['title-font-weight-card'], '900'); ?>>Black (900)</option>
                    </select>
                </td>
            </tr>
        </table>
        

        <div class="cards__actions">
            <input type="hidden" name="gica_design_cards[reset]" value="0" />
            <?php submit_button('Guardar Cambios', 'primary', 'submit', false, ['class' => 'cards__button cards__button--primary']); ?>
            <button type="submit" name="gica_design_cards[reset-default-cards]" value="1" class="cards__button cards__button--secondary">Restablecer a Valores Predeterminados</button>
        </div>
    </form>
</section>