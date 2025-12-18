<?php

namespace App\Providers;

use App\Fixtures\Composers\PostTypeComposer;
use App\Fixtures\Composers\TaxonomyComposer;
use Illuminate\Config\Repository;
use Roots\Acorn\ServiceProvider;


class BoilerplateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Autoload PostTypes directory
        $this->app->make('PostTypeComposer');

        // Autoload Taxonomies directory
        $this->app->make('TaxonomyComposer');

        // Expose commands to wp-cli
        $this->commands([
            \App\Console\Commands\PostTypeMakeCommand::class,
            \App\Console\Commands\TaxonomyMakeCommand::class,
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('PostTypeComposer', function () {
            return new PostTypeComposer($this->app);
        });

        $this->app->singleton('TaxonomyComposer', function () {
            return new TaxonomyComposer($this->app);
        });

        // Add a custom Gutenberg category
        add_action('block_categories_all', function ($categories) {
            return array_merge($categories, [
                [
                    'slug' => 'styleguide',
                    'title' => __('Styleguide'),
                ],
            ]);
        }, 10, 2);

        // Add a "debug-screens" to show breakpoints
        add_filter('body_class', function ($classes) {
            if (WP_ENV === 'development' || (isset($_GET['debug']) && $_GET['debug'] === 'responsive')) {
                $classes[] = 'debug-screens';
            }

            return $classes;
        });

        // Move Yoast SEO metabox to bottom if present
        add_filter('wpseo_metabox_prio', function () {
            return 'low';
        });

        $this->setupJavaScript();
    }

    /**
     * Add an object to collect and share data to JavaScript.
     */
    private function setupJavaScript()
    {
        $this->app->singleton('javascript', function () {
            return new Repository([]);
        });

        try {
            $share = $this->app->make('javascript');
            $share->set('ajax_url', admin_url('admin-ajax.php'));
            $share->set('theme_url', get_template_directory_uri());

            if (defined('ICL_LANGUAGE_CODE')) {
                $share->set('language', ICL_LANGUAGE_CODE);
            }
        } catch (\Exception $e) {
            if (current_user_can('do_anything')) {
                d('[BoilerplateServiceProvider->setupJavaScript]', $e->getMessage());
            }
        }
    }
}
