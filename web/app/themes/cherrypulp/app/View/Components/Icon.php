<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class Icon extends Component
{
    /**
     * @var mixed|string
     */
    public $classes;

    /**
     * @var mixed|string
     */
    public $tag;

    /**
     * @var mixed|string
     */
    public $name;

    /**
     * @var mixed|string
     */
    public $type;

    /**
     * Create a new component instance.
     *
     * @param string $classes
     * @param null   $name
     * @param null   $path
     * @param string $tag
     * @param string $type
     */
    public function __construct($classes = '', $name = null, $path = null, $tag = 'i', string $type = 'solid')
    {
        if (is_array($classes)) {
            $classes = implode(' ', $classes);
        }

        $this->classes = $classes;

        if ($path) {
            [$iconName, $iconType] = explode('.', $path);
            $this->name = $iconName ?? $name;
            $this->type = $iconType ?? $type;
        } else {
            $this->name = $name;
            $this->type = $type ?? 'solid';
        }

        $this->tag = $tag;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return $this->view('components.icon');
    }
}
