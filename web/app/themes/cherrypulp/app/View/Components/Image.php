<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class Image extends Component
{
    public static $aspectRatios
        = [
            '16:9' => 'padding-bottom: 56.25%',
            '4:3' => 'padding-bottom: 75%',
            '2:1' => 'padding-bottom: 50%',
            '1:1' => 'padding-bottom: 100%',
            'custom' => '',
        ];

    /**
     * @var mixed|string
     */
    public $classes;

    /**
     * @var bool
     */
    public $rounded;

    /**
     * @var string
     */
    public $aspectRatio;

    /**
     * @var null
     */
    public $srcsets;

    /**
     * @var string
     */
    public $sizes;

    /**
     * @var mixed|string
     */
    public $defaultImage;

    /**
     * @var null
     */
    public $image;

    /**
     * Create a new component instance.
     *
     * @param string $alt
     * @param string $classes
     * @param string $defaultImage
     * @param null   $image
     * @param string $imageAspectRatio
     * @param bool   $rounded
     * @param string $sizes
     * @param null   $srcsets
     */
    public function __construct(string $alt = '', $classes = '', string $defaultImage = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7', $image = null, string $imageAspectRatio = '16:9', bool $rounded = false, string $sizes = '(min-width: 768px) 40vw, 90vw', $srcsets = null)
    {
        if (is_array($classes)) {
            $classes = implode(' ', $classes);
        }

        $this->alt          = $alt;
        $this->aspectRatio  = array_key_exists($imageAspectRatio, self::$aspectRatios) ? self::$aspectRatios[$imageAspectRatio] : '';
        $this->classes      = $classes;
        $this->defaultImage = $defaultImage;
        $this->image        = $image;
        $this->rounded      = $rounded;
        $this->sizes        = $sizes;
        $this->srcsets      = $srcsets;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return $this->view('components.image');
    }
}
