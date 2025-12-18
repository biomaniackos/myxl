<?php

namespace App\Blocks;

use App\Fields\Partials\SectionCtaFields;
use Log1x\AcfComposer\Block;
use function Roots\app;

class SectionCta extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Section Cta';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'A simple Section Cta block from Tailwind UI (https://tailwindui.com/components/marketing/sections/cta-sections).';

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
    public $icon = 'align-wide';

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
        'jsx' => true,
    ];

    /**
     * The block styles.
     *
     * @var array
     */
    public $styles = [
        [
            'name' => 'normal',
            'label' => 'Normal',
            'isDefault' => true,
        ],
        [
            'name' => 'rounded',
            'label' => 'Rounded',
        ]
    ];

    /**
     * The block preview example data.
     *
     * @var array
     */
    public $example = [
        'actions' => [],
        'content' => '<p>Ac euismod vel sit maecenas id pellentesque eu sed consectetur.</p><p>Malesuada adipiscing sagittis vel nulla nec.</p>',
        'image' => 'https://images.unsplash.com/photo-1525130413817-d45c1d127c42?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1920&q=60&blend=6366F1&sat=-100&blend-mode=multiply',
        'title' => 'Ready to dive in? Start your free trial today.',
    ];

    /**
     * Data to be passed to the block before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'content' => $this->content(),
            'image' => $this->image(),
            'options' => $this->options(),
            'title' => $this->title(),
        ];
    }

    /**
     * The block field group.
     *
     * @return array
     */
    public function fields()
    {
        return (new SectionCtaFields(app()))->fields()->build();
    }

    public function actions()
    {
        if ($this->preview) {
            return get_field('actions') ?: $this->example['actions'];
        }

        return get_field('actions');
    }

    public function content()
    {
        if ($this->preview) {
            return get_field('content') ?: $this->example['content'];
        }

        return get_field('content');
    }

    public function image()
    {
        if ($this->preview) {
            return get_field('image') ?: $this->example['image'];
        }

        return get_field('image');
    }

    public function options()
    {
        $style = 'normal';

        if (strpos($this->classes, 'is-style-rounded') !== false) {
            $style = 'rounded';
        }

        return [
            'actions' => $this->actions(),
            'style' => $style,
        ];
    }

    public function title()
    {
        if ($this->preview) {
            return get_field('title') ?: $this->example['title'];
        }

        return get_field('title');
    }
}
