<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class LogoCloud extends Component
{
    public static $types = [
        'grid',
        'line',
    ];

    /**
     * @var array|string
     */
    public $classes;

    /**
     * @var array
     */
    public $items;

    /**
     * @var mixed|string
     */
    public $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($classes = null, array $items = [], $type = 'grid')
    {
        if (is_array($classes)) {
            $classes = implode(' ', $classes);
        }

        $this->classes = $classes;
        $this->items = $items;
        $this->type = in_array($type, self::$types, true) ? $type : 'grid';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return $this->view('components.logo-cloud');
    }
}
