<?php

require_once dirname( __FILE__ ) . '/lib/shortcake-bakery/shortcake-bakery.php';
require_once dirname( __FILE__ ) . '/lib/shortcode-ui/shortcode-ui.php';
require_once dirname( __FILE__ ) . '/lib/image-shortcake/image-shortcake.php';

add_action( 'wp_enqueue_scripts', 'twentyfifteen_parent_theme_enqueue_styles' );

function twentyfifteen_parent_theme_enqueue_styles() {
    wp_enqueue_style( 'twentyfifteen-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( '-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('twentyfifteen-style')
    );

}

add_action( 'init', function() {
    /**
     * Register your shortcode as you would normally.
     * This is a simple example for a pullquote with a citation.
     */
    add_shortcode( 'pullquote', function( $attr, $content = '' ) {
        $attr = wp_parse_args( $attr, array(
            'source' => ''
        ) );
        ob_start();
        ?>

        <section class="pullquote">
            <?php echo esc_html( $content ); ?><br/>
            <?php if ( ! empty( $attr['source'] ) ) : ?>
                <cite><em><?php echo esc_html( $attr['source'] ); ?></em></cite>
            <?php endif; ?>
        </section>

        <?php
        return ob_get_clean();
    } );
    /**
     * Register a UI for the Shortcode.
     * Pass the shortcode tag (string)
     * and an array or args.
     */
    shortcode_ui_register_for_shortcode(
        'pullquote',
        array(
            // Display label. String. Required.
            'label' => 'Pullquote',
            // Icon/image for shortcode. Optional. src or dashicons-$icon. Defaults to carrot.
            'listItemImage' => 'dashicons-editor-quote',
            // Available shortcode attributes and default values. Required. Array.
            // Attribute model expects 'attr', 'type' and 'label'
            // Supported field types: text, checkbox, textarea, radio, select, email, url, number, and date.
            'attrs' => array(
                array(
                    'label' => 'Quote',
                    'attr'  => 'content',
                    'type'  => 'textarea',
                ),
                array(
                    'label'       => 'Cite',
                    'attr'        => 'source',
                    'type'        => 'text',
                    'placeholder' => 'Firstname Lastname',
                    'description' => 'Optional',
                ),
            ),
        )
    );
} );