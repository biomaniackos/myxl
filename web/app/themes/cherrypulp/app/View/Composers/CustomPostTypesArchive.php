<?php

namespace App\View\Composers;

use App\PostTypes\Testimonies;
use Roots\Acorn\View\Composer;

class CustomPostTypesArchive extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'archive-testimonies',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function override()
    {
        return [
            'header_image' => $this->headerImage(),
            'title' => $this->title(),
        ];
    }

    public function headerImage()
    {
        if ($image = get_field('header_image', Testimonies::$settingsId)) {
            return $image['url'];
        }

        return null;
    }

    public function title()
    {
        if ($title = get_field('title', Testimonies::$settingsId)) {
            return $title;
        }

        return get_the_title();
    }
}
