<?php

namespace App\View\Composers;

use App\PostTypes\Testimonies;
use Roots\Acorn\View\Composer;
use Roots\Acorn\View\Composers\Concerns\AcfFields;

class TestimoniesSingle extends Composer
{
    use AcfFields;

    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.content-single-testimony',
        'single-testimony',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function override()
    {
        return [
            'fields' => $this->fields(),
            'settings' => $this->settings(),
        ];
    }

    public function settings()
    {
        return get_fields(Testimonies::$settingsId);
    }
}
