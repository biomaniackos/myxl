<?php

namespace App\View\Composers;

use App\PostTypes\Modals;
use Roots\Acorn\View\Composer;
use Roots\Acorn\View\Composers\Concerns\AcfFields;

class ModalsSingle extends Composer
{
    use AcfFields;

    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.content-single-modal',
        'single-modal',
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
        return get_fields(Modals::$settingsId);
    }
}
