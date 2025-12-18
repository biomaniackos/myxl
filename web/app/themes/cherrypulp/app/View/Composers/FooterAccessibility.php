<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use function App\get_navigation_items;

class FooterAccessibility extends Composer
{
    /**
     * List of views served by this composer.
     * @var array
     */
    protected static $views = [
        'partials.footer',
        'partials.footer-accessibility',
        'partials.footer-copyright',
    ];

    /**
     * Data to be passed to view before rendering, but after merging.
     * @return array
     */
    public function with()
    {
        return [
            'menu_items' => $this->menuItems(),
            'menu_languages' => $this->menuLanguages(),
            'privacy_items' => $this->privacyItems(),
        ];
    }

    /**
     * Social privacy.
     */
    public function privacyItems()
    {
        if (has_nav_menu('privacy_navigation')) {
            return get_navigation_items('privacy_navigation');
        }

        return null;
    }

    /**
     * Social links.
     */
    public function menuItems()
    {
        if (has_nav_menu('footer_navigation')) {
            return get_navigation_items('footer_navigation');
        }

        return null;
    }

    public function menuLanguages()
    {
        if (is_plugin_active('wpml-multilingual-cms/sitepress.php')) {
            $languages = collect(apply_filters('wpml_active_languages', null, []));

            return [
                'active' => $languages->where('active', 1)->first(),
                'languages' => $languages->where('active', 0)->toArray(),
            ];
        }

        return null;
    }
}
