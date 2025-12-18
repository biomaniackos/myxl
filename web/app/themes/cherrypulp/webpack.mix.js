const mix = require('laravel-mix');
require('@tinypixelco/laravel-mix-wp-blocks');

// load main dotenv
require('dotenv').config({ path: '/../../../../.env' });

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Sage application. By default, we are compiling the Sass file
 | for your application, as well as bundling up your JS files.
 |
 */

mix
    .setPublicPath('./public')
    .browserSync(process.env.WP_HOME)
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /\.(postcss)$/,
                    use: [
                        'vue-style-loader',
                        { loader: 'css-loader', options: { importLoaders: 1 } },
                        'postcss-loader',
                    ],
                },
            ],
        },
    });

mix
    .postCss('resources/styles/app.css', 'styles')
    .postCss('resources/styles/editor.css', 'styles')
    .options({ processCssUrls: false });

mix
    .js('resources/scripts/app.js', 'scripts')
    .vue({ runtimeOnly: false })
    .js('resources/scripts/admin.js', 'scripts')
    .js('resources/scripts/customizer.js', 'scripts')
    .blocks('resources/scripts/editor.js', 'scripts', {
        // @see https://github.com/roots/sage/issues/2474
        disableRegenerator: true,
    })
    .autoload({ jquery: [ '$', 'window.jQuery' ] })
    .extract();

mix
    .copyDirectory('resources/images', 'public/images')
    .copyDirectory('resources/fonts', 'public/fonts');

mix
    .sourceMaps()
    .version();
