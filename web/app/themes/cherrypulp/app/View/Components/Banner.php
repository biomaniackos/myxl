<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class Banner extends Component
{
    public static $defaultOptions = [
        'actions' => [],
        'closable' => true,
        'icon' => null,
        'style' => 'bar', // or 'toast'
    ];
    public static $types = [
        'danger' => 'bomb',
        'dark' => 'quote-left',
        'info' => 'info-circle',
        'light' => 'quote-left',
        'primary' => 'quote-left',
        'success' => 'check-circle',
        'warning' => 'exclamation-triangle',
    ];

    /**
     * The alert type.
     *
     * @var string
     */
    public $type;

    /**
     * The alert message.
     *
     * @var string
     */
    public $message;

    /**
     * @var array
     */
    public $options = [];

    /**
     * Create a new component instance.
     *
     * @param string $message
     * @param string $type
     * @param array  $options
     */
    public function __construct($message = '', $type = 'info', array $options = [])
    {
        $this->message = $message;
        $this->type = array_key_exists($type, self::$types) ? $type : 'primary';
        $this->options = collect(self::$defaultOptions)
            ->merge([ 'icon' => self::$types[$this->type] ])
            ->merge($options)
            ->toArray();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return $this->view('components.banner');
    }
}
