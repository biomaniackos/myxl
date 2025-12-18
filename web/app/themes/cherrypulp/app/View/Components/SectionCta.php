<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class SectionCta extends Component
{
    public static $defaultOptions = [
        'actions' => [],
        'style' => 'normal', // or 'toast'
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
    public $content;

    /**
     * @var string
     */
    public $image;

    /**
     * @var array
     */
    public $options = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $content = null, $image = null, $classes = '', array $options = [])
    {
        if (is_array($classes)) {
            $classes = implode(' ', $classes);
        }

        $this->options = collect(self::$defaultOptions)
            ->merge($options)
            ->toArray();

        if ($this->options['style'] === 'rounded') {
            $classes .= ' rounded-lg shadow-xl';
        }

        $this->classes = $classes;
        $this->content = $content;
        $this->image = $image;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return $this->view('components.section-cta');
    }
}
