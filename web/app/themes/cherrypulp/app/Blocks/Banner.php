<?php

namespace App\Blocks;

use App\Fields\Partials\BannerFields;
use Log1x\AcfComposer\Block;
use function Roots\app;

class Banner extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Banner';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'A simple Banner from Tailwind UI (https://tailwindui.com/components/marketing/elements/banners).';

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
    public $icon = 'megaphone';

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
        'mode' => false,
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
        'actions' => [],
        'closable' => false,
        'message' => 'This banner as a message to tell!',
        'type' => 'info',
    ];

    /**
     * Data to be passed to the block before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'actions' => $this->actions(),
            'closable' => $this->closable(),
            'message' => $this->message(),
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
        return (new BannerFields(app()))->fields()->build();
    }

    public function actions()
    {
        if ($this->preview) {
            return get_field('actions') ?: $this->example['actions'];
        }

        return get_field('actions');
    }

    public function closable()
    {
        if ($this->preview) {
            return get_field('closable') ?: $this->example['closable'];
        }

        return get_field('closable');
    }

    public function message()
    {
        if ($this->preview) {
            return get_field('message') ?: $this->example['message'];
        }

        return get_field('message');
    }

    public function type()
    {
        if ($this->preview) {
            return get_field('type') ?: $this->example['type'];
        }

        return get_field('type');
    }
}
