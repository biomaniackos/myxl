<?php

namespace App\Blocks;

use App\Fields\Partials\LogoCloudFields;
use Log1x\AcfComposer\Block;
use function Roots\app;

class LogoCloud extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Logo Cloud';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'A simple Logo Cloud from Tailwind UI (https://tailwindui.com/components/marketing/sections/logo-clouds)';

    /**
     * The block category.
     *
     * @var string
     */
    public $category = 'styleguide';

    /**
     * The block icon.
     *
     * @var string|array
     */
    public $icon = 'ellipsis';

    /**
     * The block keywords.
     *
     * @var array
     */
    public $keywords = [];

    /**
     * The block post type allow list.
     *
     * @var array
     */
    public $post_types = [];

    /**
     * The parent block type allow list.
     *
     * @var array
     */
    public $parent = [];

    /**
     * The default block mode.
     *
     * @var string
     */
    public $mode = 'preview';

    /**
     * The default block alignment.
     *
     * @var string
     */
    public $align = '';

    /**
     * The default block text alignment.
     *
     * @var string
     */
    public $align_text = '';

    /**
     * The default block content alignment.
     *
     * @var string
     */
    public $align_content = '';

    /**
     * The supported block features.
     *
     * @var array
     */
    public $supports = [
        'align' => true,
        'align_text' => false,
        'align_content' => false,
        'full_height' => false,
        'anchor' => false,
        'mode' => true,
        'multiple' => true,
        'jsx' => false,
    ];

    /**
     * The block styles.
     *
     * @var array
     */
    public $styles = [];

    /**
     * The block preview example data.
     *
     * @var array
     */
    public $example = [
        'items' => [
            [
                'image' => [
                    'alt' => 'Tuple',
                    'url' => 'https://tailwindui.com/img/logos/tuple-logo-gray-400.svg',
                ],
                'link' => '',
            ],
            [
                'image' => [
                    'alt' => 'Mirage',
                    'url' => 'https://tailwindui.com/img/logos/mirage-logo-gray-400.svg',
                ],
                'link' => '',
            ],
            [
                'image' => [
                    'alt' => 'StaticKit',
                    'url' => 'https://tailwindui.com/img/logos/statickit-logo-gray-400.svg',
                ],
                'link' => '',
            ],
            [
                'image' => [
                    'alt' => 'Transistor',
                    'url' => 'https://tailwindui.com/img/logos/transistor-logo-gray-400.svg',
                ],
                'link' => '',
            ],
            [
                'image' => [
                    'alt' => 'Workcation',
                    'url' => 'https://tailwindui.com/img/logos/workcation-logo-gray-400.svg',
                ],
                'link' => '',
            ],
            [
                'image' => [
                    'alt' => 'Statamic',
                    'url' => 'https://tailwindui.com/img/logos/statamic-logo-gray-400.svg',
                ],
                'link' => '',
            ],
        ],
        'type' => 'grid',
    ];

    /**
     * Data to be passed to the block before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'items' => $this->items(),
            'type' => $this->type(),
        ];
    }

    /**
     * The block field group.
     *
     * @return array
     */
    public function fields()
    {
        return (new LogoCloudFields(app()))->fields()->build();
    }

    /**
     * Return the items field.
     *
     * @return array
     */
    public function items()
    {
        if ($this->preview) {
            return get_field('items') ?: $this->example['items'];
        }

        return get_field('items') ?: [];
    }

    public function type()
    {
        if ($this->preview) {
            return get_field('type') ?: $this->example['type'];
        }

        return get_field('type');
    }
}
