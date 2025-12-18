<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class Testimony extends Component
{
    public static $defaultOptions = [
        'align' => 'left', // or 'right'
    ];
    public static $types = [
        'avatar',
        'centered',
    ];

    /**
     * @var array|string
     */
    public $classes;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $role;

    /**
     * @var string
     */
    public $quote;

    /**
     * @var string
     */
    public $image;

    /**
     * @var string
     */
    public $logo;

    /**
     * @var string
     */
    public $type = 'avatar';

    /**
     * @var array
     */
    public $options = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $quote = null, $image = null, $logo = null, $role = null, $classes = '', $type = 'avatar', $options = [])
    {
        if (is_array($classes)) {
            $classes = implode(' ', $classes);
        }

        $this->classes = $classes;
        $this->quote = $quote;
        $this->image = $image;
        $this->logo = $logo;
        $this->options = collect(self::$defaultOptions)
            ->merge($options)
            ->toArray();
        $this->role = $role;
        $this->title = $title;
        $this->type = in_array($type, self::$types, true) ? $type : 'grid';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return $this->view('components.testimony');
    }
}
