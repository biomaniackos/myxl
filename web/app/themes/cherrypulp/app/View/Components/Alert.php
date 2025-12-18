<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class Alert extends Component
{

    public static $defaultOptions = [
        'actions' => [],
        'closable' => true,
        'icon' => null,
    ];

    /**
     * The alert types.
     *
     * @var array
     */
    public static $types = [
        'danger' => 'bomb',
        'info' => 'info-circle',
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
     * Create the component instance.
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
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return $this->view('components.alert');
    }
}
