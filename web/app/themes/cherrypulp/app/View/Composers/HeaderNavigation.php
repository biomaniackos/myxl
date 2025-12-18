<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use function App\get_navigation_items;

class HeaderNavigation extends Composer
{
    /**
     * List of views served by this composer.
     * @var array
     */
    protected static $views = [
        'partials.header-navigation',
    ];

    /**
     * Data to be passed to view before rendering, but after merging.
     * @return array
     */
    public function with()
    {
        return [
            'primary_navigation' => $this->getNavigation('primary_navigation'),
            'secondary_navigation' => $this->getNavigation('secondary_navigation'),
        ];
    }

    /**
     * Navigation links.
     */
    public function getNavigation($name)
    {
        if (has_nav_menu($name)) {
            return collect(get_navigation_items($name))->map(function ($item) {
                return $item->to_array();
            })->toArray();
        }

        return null;
    }
}
