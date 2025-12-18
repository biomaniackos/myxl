<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class MenuSocial extends Composer
{
    /**
     * List of views served by this composer.
     * @var array
     */
    protected static $views = [
        'partials.menu-social',
    ];

    /**
     * Data to be passed to view before rendering, but after merging.
     * @return array
     */
    public function with()
    {
        return [
            'social_networks' => $this->social(),
        ];
    }

    /**
     * Social links.
     */
    public function social()
    {
        return get_field('social_networks', 'option');
    }
}
