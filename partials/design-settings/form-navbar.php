<section class="gica-academic-program__card">
    <h2 class="gica-academic-program__card-title">Navbar</h2>

    <form method="post" action="options.php" class="navbar__form">
        <?php settings_fields('gica_design_navbar_options'); ?>
        <?php do_settings_sections('gica_design_navbar_options'); ?>
        <table class="navbar__table">
            <tr class="navbar__table-row">
                <th class="navbar__table-label" style="text-align: center;"><label for="btn_nav_active">Botón activo</label></th>
                <th class="navbar__table-label" style="text-align: center;"><label for="btn_nav_primary_color">Color Primario</label></th>
                <th class="navbar__table-label" style="text-align: center;"><label for="btn_nav_secondary_color">Color Secundario</label></th>
                <th class="navbar__table-label" style="text-align: center;"><label for="btn_nav_text_color">Color del Texto</label></th>
            </tr>
            <tr class="navbar__table-row" style="text-align: center;">
                <td class="navbar__table-input">
                    <input type="color" id="btn_nav_active" name="gica_design_navbar[btn-nav-active]" value="<?php echo esc_attr($design_navbar['btn-nav-active']); ?>" class="navbar__input--color">
                </td>
                <td class="navbar__table-input">
                    <input type="color" id="btn_nav_primary_color" name="gica_design_navbar[btn-nav-primary-color]" value="<?php echo esc_attr($design_navbar['btn-nav-primary-color']); ?>" class="navbar__input--color">
                </td>
                <td class="navbar__table-input">
                    <input type="color" id="btn_nav_secondary_color" name="gica_design_navbar[btn-nav-secondary-color]" value="<?php echo esc_attr($design_navbar['btn-nav-secondary-color']); ?>" class="navbar__input--color">
                </td>
                <td class="navbar__table-input">
                    <input type="color" id="btn_nav_text_color" name="gica_design_navbar[btn-nav-text-color]" value="<?php echo esc_attr($design_navbar['btn-nav-text-color']); ?>" class="navbar__input--color">
                </td>
            </tr>
            <tr class="navbar__table-row">
                <th class="navbar__table-label" style="text-align: center;"><label for="gap_navbar_temp">Separación entre botones</label></th>
                <th class="navbar__table-label" style="text-align: center;"><label for="margin_bottom_navbar_temp">Margin Inferior</label></th>
                <th class="navbar__table-label" style="text-align: center;"><label for="border_radius_navbar_temp">Border Radius</label></th>
                <th class="navbar__table-label" style="text-align: center;"><label for="font_size_navbar_temp">Text Size</label></th>
            </tr>
            <tr class="navbar__table-row">
                <td class="navbar__table-input">
                    <div class="navbar__size-input-group" style="gap:0px;">
                        <input
                            type="number"
                            id="gap_navbar_temp"
                            class="navbar__input--number"
                            step="0.1"
                            min="0"
                            value="<?php echo esc_attr($this->extract_size_value($design_navbar['gap-navbar'])); ?>">

                        <select class="navbar__unit-select ">
                            <option value="px" <?php selected($this->extract_size_unit($design_navbar['gap-navbar']), 'px'); ?>>px</option>
                            <option value="rem" <?php selected($this->extract_size_unit($design_navbar['gap-navbar']), 'rem'); ?>>rem</option>
                        </select>

                        <input type="hidden"
                            name="gica_design_navbar[gap-navbar]"
                            id="gap_navbar_real"
                            value="<?php echo esc_attr($design_navbar['gap-navbar']); ?>">
                    </div>
                </td>
                <td class="navbar__table-input">
                    <div class="navbar__size-input-group" style="gap:0px;">
                        <input
                            type="number"
                            id="margin_bottom_navbar_temp"
                            class="navbar__input--number"
                            step="0.1"
                            min="0.1"
                            value="<?php echo esc_attr($this->extract_size_value($design_navbar['margin-bottom-navbar'])); ?>">

                        <select class="navbar__unit-select ">
                            <option value="px" <?php selected($this->extract_size_unit($design_navbar['margin-bottom-navbar']), 'px'); ?>>px</option>
                            <option value="rem" <?php selected($this->extract_size_unit($design_navbar['margin-bottom-navbar']), 'rem'); ?>>rem</option>
                        </select>

                        <input type="hidden"
                            name="gica_design_navbar[margin-bottom-navbar]"
                            id="margin_bottom_navbar_real"
                            value="<?php echo esc_attr($design_navbar['margin-bottom-navbar']); ?>">
                    </div>
                </td>
                <td class="navbar__table-input">
                    <div class="navbar__size-input-group" style="gap:0px;">
                        <input
                            type="number"
                            id="border_radius_navbar_temp"
                            class="navbar__input--number"
                            step="0.1"
                            min="0.1"
                            value="<?php echo esc_attr($this->extract_size_value($design_navbar['border-radius-navbar'])); ?>">

                        <select class="navbar__unit-select ">
                            <option value="px" <?php selected($this->extract_size_unit($design_navbar['border-radius-navbar']), 'px'); ?>>px</option>
                            <option value="rem" <?php selected($this->extract_size_unit($design_navbar['border-radius-navbar']), 'rem'); ?>>rem</option>
                        </select>

                        <input type="hidden"
                            name="gica_design_navbar[border-radius-navbar]"
                            id="border_radius_navbar_real"
                            value="<?php echo esc_attr($design_navbar['border-radius-navbar']); ?>">
                    </div>
                </td>
                <td class="navbar__table-input">
                    <div class="navbar__size-input-group" style="gap:0px;">
                        <input
                            type="number"
                            id="font_size_navbar_temp"
                            class="navbar__input--number"
                            step="0.1"
                            min="0"
                            value="<?php echo esc_attr($this->extract_size_value($design_navbar['font-size-navbar'])); ?>">

                        <select class="navbar__unit-select ">
                            <option value="px" <?php selected($this->extract_size_unit($design_navbar['font-size-navbar']), 'px'); ?>>px</option>
                            <option value="rem" <?php selected($this->extract_size_unit($design_navbar['font-size-navbar']), 'rem'); ?>>rem</option>
                        </select>

                        <input type="hidden"
                            name="gica_design_navbar[font-size-navbar]"
                            id="font_size_navbar_real"
                            value="<?php echo esc_attr($design_navbar['font-size-navbar']); ?>">
                    </div>
                </td>
            </tr>
            <tr class="navbar__table-row">
                <th class="navbar__table-label" style="text-align: center;"><label for="font_weight_navbar">Grosor del Texto</label></th>
                <td class="navbar__table-input" colspan="3">
                    <select id="font_weight_navbar" name="gica_design_navbar[font-weight-navbar]" class="navbar__input--select">
                        <option value="300" <?php selected($design_navbar['font-weight-navbar'], '300'); ?>>Light (300)</option>
                        <option value="400" <?php selected($design_navbar['font-weight-navbar'], '400'); ?>>Normal (400)</option>
                        <option value="500" <?php selected($design_navbar['font-weight-navbar'], '500'); ?>>Medium (500)</option>
                        <option value="600" <?php selected($design_navbar['font-weight-navbar'], '600'); ?>>Semi-bold (600)</option>
                        <option value="700" <?php selected($design_navbar['font-weight-navbar'], '700'); ?>>Bold (700)</option>
                        <option value="800" <?php selected($design_navbar['font-weight-navbar'], '800'); ?>>Extra-bold (800)</option>
                        <option value="900" <?php selected($design_navbar['font-weight-navbar'], '900'); ?>>Black (900)</option>
                    </select>
                </td>
            </tr>
        </table>

        <table class="navbar__responsive-table">
            <tr class="navbar__table-row">
                <th class="navbar__table-label" style="text-align: center;"><label>xl</label></th>
                <th class="navbar__table-label" style="text-align: center;"><label>lg</label></th>
                <th class="navbar__table-label" style="text-align: center;"><label>md</label></th>
                <th class="navbar__table-label" style="text-align: center;"><label>sm</label></th>
            </tr>
            <tr class="navbar__responsive-header">
                <th class="navbar__responsive-title"><span class="navbar__icon navbar__icon--desktop"></span></th>
                <th class="navbar__responsive-title"><span class="navbar__icon navbar__icon--desktop"></span></th>
                <th class="navbar__responsive-title"><span class="navbar__icon navbar__icon--tablet"></span></th>
                <th class="navbar__responsive-title"><span class="navbar__icon navbar__icon--mobile"></span></th>
            </tr>

            <tr class="navbar__responsive-row">
                <td class="navbar__responsive-input">
                    <input type="text" name="gica_design_navbar[grid-columns-navbar-escritorio-xl]" value="<?php echo esc_attr($design_navbar['grid-columns-navbar-escritorio-xl']); ?>" class="navbar__input--text">
                </td>
                <td class="navbar__responsive-input">
                    <input type="text" name="gica_design_navbar[grid-columns-navbar-escritorio-lg]" value="<?php echo esc_attr($design_navbar['grid-columns-navbar-escritorio-lg']); ?>" class="navbar__input--text">
                </td>
                <td class="navbar__responsive-input">
                    <input type="text" name="gica_design_navbar[grid-columns-navbar-tablet]" value="<?php echo esc_attr($design_navbar['grid-columns-navbar-tablet']); ?>" class="navbar__input--text">
                </td>
                <td class="navbar__responsive-input">
                    <input type="text" name="gica_design_navbar[grid-columns-navbar-mobile]" value="<?php echo esc_attr($design_navbar['grid-columns-navbar-mobile']); ?>" class="navbar__input--text">
                </td>
            </tr>
        </table>

        <div class="navbar__actions">
            <input type="hidden" name="gica_design_navbar[reset]" value="0" />
            <?php submit_button('Guardar Cambios', 'primary', 'submit', false, ['class' => 'navbar__button navbar__button--primary']); ?>
            <button type="submit" name="gica_design_navbar[reset-default-navbar]" value="1" class="navbar__button navbar__button--secondary">Restablecer a Valores Predeterminados</button>
        </div>
    </form>
</section>