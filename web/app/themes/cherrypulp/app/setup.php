<?php

/**
 * Theme setup.
 */

namespace App;

use function Roots\app;
use function Roots\asset;

/**
 * Register the theme assets.
 *
 * @return void
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('sage/vendor.js', asset('scripts/vendor.js')->uri(), ['jquery'], null, true);
    wp_enqueue_script('sage/app.js', asset('scripts/app.js')->uri(), ['sage/vendor.js'], null, true);

    wp_add_inline_script('sage/vendor.js', asset('scripts/manifest.js')->contents(), 'before');

    // Load fontawesome script for SVG
    wp_enqueue_script('fontawesome', '//pro.fontawesome.com/releases/v5.15.4/js/all.js', [], null, false);
    add_filter('script_loader_tag', function ($tag, $handle) {
        if ($handle === 'fontawesome') {
            return str_replace('src', 'defer integrity="sha384-8nTbev/iV1sg3ESYOAkRPRDMDa5s0sknqroAe9z4DiM+WDr1i/VKi5xLWsn87Car" crossorigin="anonymous" src', $tag);
        }

        return $tag;
    }, 10, 2);

    // Load custom fonts
    wp_enqueue_style('font-sans', '//fonts.googleapis.com/css2?family=Roboto:ital,wght@0,500;0,700;1,500;1,700&display=swap', false, null);

    // share data with JavaScript
    wp_localize_script('sage/app.js', '__app', app('javascript')->all());

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_enqueue_style('sage/app.css', asset('styles/app.css')->uri(), false, null);
}, 100);

add_action('admin_enqueue_scripts', function () {
    wp_enqueue_script('sage/vendor.js', asset('scripts/vendor.js')->uri(), ['jquery'], null, true);
    wp_enqueue_script('sage/admin.js', asset('scripts/admin.js')->uri(), ['sage/vendor.js'], null, true);

    wp_add_inline_script('sage/vendor.js', asset('scripts/manifest.js')->contents(), 'before');
});

/**
 * Register the theme assets with the block editor.
 *
 * @return void
 */
add_action('enqueue_block_editor_assets', function () {
    if ($manifest = asset('scripts/manifest.asset.php')->load()) {
        wp_enqueue_script('sage/vendor.js', asset('scripts/vendor.js')->uri(), ...array_values($manifest));
        wp_enqueue_script('sage/editor.js', asset('scripts/editor.js')->uri(), ['sage/vendor.js'], null, true);

        wp_add_inline_script('sage/vendor.js', asset('scripts/manifest.js')->contents(), 'before');
    }

    // Load fontawesome script for SVG
    wp_enqueue_script('fontawesome', '//pro.fontawesome.com/releases/v5.15.4/js/all.js', [], null, false);
    add_filter('script_loader_tag', function ($tag, $handle) {
        if ($handle === 'fontawesome') {
            return str_replace('src', 'defer integrity="sha384-8nTbev/iV1sg3ESYOAkRPRDMDa5s0sknqroAe9z4DiM+WDr1i/VKi5xLWsn87Car" crossorigin="anonymous" src', $tag);
        }

        return $tag;
    }, 10, 2);

    wp_enqueue_style('sage/editor.css', asset('styles/editor.css')->uri(), false, null);
}, 100);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from the Soil plugin if activated.
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil', [
        'clean-up',
        'nav-walker',
        'nice-search',
        'relative-urls'
    ]);

    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Register the navigation menus.
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
        'footer_navigation' => __('Footer Navigation', 'sage'),
        'footer_secondary_navigation' => __('Secondary Footer Navigation', 'sage'),
    ]);

    /**
     * Register the editor color palette.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-color-palettes
     */
    add_theme_support('editor-color-palette', [
        [
            'name' => esc_attr__('primary', 'sage'),
            'slug' => 'primary',
            'color' => '#A78BFA',
        ],
        [
            'name' => esc_attr__('secondary', 'sage'),
            'slug' => 'secondary',
            'color' => '#EC4899',
        ],
        [
            'name' => esc_attr__('dark', 'sage'),
            'slug' => 'dark',
            'color' => '#111827',
        ],
        [
            'name' => esc_attr__('light', 'sage'),
            'slug' => 'light',
            'color' => '#fff',
        ],
        [
            'name' => esc_attr__('gray', 'sage'),
            'slug' => 'gray',
            'color' => '#9CA3AF',
        ],
        [
            'name' => esc_attr__('danger', 'sage'),
            'slug' => 'danger',
            'color' => '#ef4445',
        ],
        [
            'name' => esc_attr__('info', 'sage'),
            'slug' => 'info',
            'color' => '#93C5FD',
        ],
        [
            'name' => esc_attr__('success', 'sage'),
            'slug' => 'success',
            'color' => '#34D399',
        ],
        [
            'name' => esc_attr__('warning', 'sage'),
            'slug' => 'warning',
            'color' => '#f59e0b',
        ],
    ]);

    /**
     * Register the editor color gradient presets.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-gradient-presets
     */
    add_theme_support('editor-gradient-presets', []);

    /**
     * Register the editor font sizes.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-font-sizes
     */
    add_theme_support('editor-font-sizes', []);

    /**
     * Register relative length units in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#support-custom-units
     */
    add_theme_support('custom-units');

    /**
     * Enable support for custom line heights in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#supporting-custom-line-heights
     */
    add_theme_support('custom-line-height');

    /**
     * Enable support for custom block spacing control in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#spacing-control
     */
    add_theme_support('custom-spacing');

    /**
     * Disable custom colors in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-colors-in-block-color-palettes
     */
    add_theme_support('disable-custom-colors');

    /**
     * Disable custom color gradients in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-gradients
     */
    add_theme_support('disable-custom-gradients');

    /**
     * Disable custom font sizes in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-font-sizes
     */
    add_theme_support('disable-custom-font-sizes');

    /**
     * Disable the default block patterns.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable wide alignment support.
     * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#wide-alignment
     */
    add_theme_support('align-wide');

    /**
     * Enable responsive embed support.
     * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style'
    ]);

    /**
     * Enable selective refresh for widgets in customizer.
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Enable custom logo
     * @link https://developer.wordpress.org/themes/functionality/custom-logo/
     */
    add_theme_support('custom-logo', [
        'flex-width' => true,
        'header-text' => [
            'site-title',
            'site-description',
        ],
        'height' => 100,
        'unlink-homepage-logo' => true,
        'width' => 350,
    ]);

    /**
     * Register some image sizes
     */
    add_image_size('menu-thumbnail', 550, 309, true); // 16/9

    /**
     * Stem/Plugins
     * @see https://gitlab.com/cherrypulp/components/stem-plugins
     */
    add_theme_support('stem-clean-up');
    add_theme_support('stem-disable-customizer');
    add_theme_support('stem-disable-emoji');
    add_theme_support('stem-disable-trackbacks');
    add_theme_support('stem-nice-search');

    // Disable Gutenberg Editor for Widgets since it throw an error.
    // @see https://wordpress.org/support/topic/error-in-widgets-with-new-wordpress-version-5-8-wp_enqueue_script-and-wp/
    remove_theme_support('widgets-block-editor');

    /**
     * Woocomerce
     */
    //add_theme_support('woocommerce');
    //add_theme_support('wc-product-gallery-zoom');
    //add_theme_support('wc-product-gallery-lightbox');
    //add_theme_support('wc-product-gallery-slider');
}, 20);

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ];

    register_sidebar([
        'id' => 'sidebar-primary',
        'name' => __('Primary', 'sage'),
    ] + $config);

    register_sidebar([
        'id' => 'sidebar-footer',
        'name' => __('Footer', 'sage'),
    ] + $config);

    // Unregister default Widgets
    /*global $wp_widget_factory;

    $widgets = array_keys($wp_widget_factory->widgets);

    foreach ($widgets as $widget) {
        unregister_widget($widget);
    }*/
});
