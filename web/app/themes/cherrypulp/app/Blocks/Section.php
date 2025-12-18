<?php

namespace App\Blocks;

use App\Fields\Partials\SectionFields;
use Log1x\AcfComposer\Block;
use function Roots\app;

class Section extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Section';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'A simple Section block.';

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
    public $icon = 'editor-insertmore';

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
        'color' => true,
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
        'tag' => 'section',
    ];

    /**
     * Data to be passed to the block before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'tag' => $this->tag(),
        ];
    }

    /**
     * The block field group.
     *
     * @return array
     */
    public function fields()
    {
        return (new SectionFields(app()))->fields()->build();
    }

    /**
     * Return the items field.
     *
     * @return array
     */
    public function tag()
    {
        if ($this->preview) {
            return get_field('tag') ?: $this->example['tag'];
        }

        return get_field('tag') ?: 'div';
    }
}
