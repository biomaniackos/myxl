<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class Pagination extends Component
{
    /**
     * @var string|null
     */
    public $base;

    /**
     * @var string|null
     */
    public $previous;

    /**
     * @var string|null
     */
    public $next;

    /**
     * @var string|null
     */
    public $current;

    /**
     * @var string|null
     */
    public $max;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($base = null, $previous = null, $next = null, $current = 1, $max = 10)
    {
        $this->base = rtrim($base, '/');
        $this->previous = $previous;
        $this->next = $next;
        $this->current = $current;
        $this->max = $max;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return $this->view('components.pagination');
    }
}
