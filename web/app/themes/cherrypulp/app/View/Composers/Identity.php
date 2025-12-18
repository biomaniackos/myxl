<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use function App\get_navigation_items;

class Identity extends Composer
{
    /**
     * List of views served by this composer.
     * @var array
     */
    protected static $views = [
        'partials.header-navigation',
        'partials.footer-identity',
    ];

    /**
     * Data to be passed to view before rendering, but after merging.
     * @return array
     */
    public function with()
    {
        return [
            'identity' => $this->identity(),
        ];
    }

    /**
     * Social links.
     */
    public function identity()
    {
        $defaults = [
            'description' => null,
            'favicon' => null,
            'logo' => null,
            'logo-dark' => null,
        ];

        if ($identity = get_field('identity', 'option')) {
            return array_merge($defaults, $identity);
        }

        return $defaults;
    }
}
