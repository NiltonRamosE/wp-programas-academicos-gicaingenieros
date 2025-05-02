<?php
/**
 * GICA Design CSS Helper
 * Encargado de generar CSS dinámico basado en opciones de diseño
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Salir si se accede directamente
}

class GICA_Design_CSS_Helper {

    /**
     * Genera e inyecta CSS dinámico basado en opciones almacenadas en la base de datos
     *
     * @param array  $defaults    Valores por defecto de diseño.
     * @param string $option_name Nombre de la opción en la base de datos.
     * @param array  $vars        Lista de claves (variables CSS) a procesar.
     * @param string $handle      Identificador único para el inline style.
     */
    public static function generate_dynamic_css( $defaults, $option_name, $vars, $handle ) {
        $design_data = get_option( $option_name, array() );
        $design_data = wp_parse_args( $design_data, $defaults );

        $css = ":root {\n";
        foreach ( $vars as $key ) {
            if ( isset( $design_data[ $key ] ) ) {
                $value = esc_html( $design_data[ $key ] );
                $css .= "--$key: $value;\n";
            }
        }
        $css .= "}\n";

        wp_register_style( $handle, false);
        wp_enqueue_style( $handle );
        wp_add_inline_style( $handle, $css );
    }
}
