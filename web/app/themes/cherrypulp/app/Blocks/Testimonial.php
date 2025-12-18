<?php

namespace App\Blocks;

use App\Fields\Partials\TestimonyFields;
use Log1x\AcfComposer\Block;
use function Roots\app;

class Testimonial extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Testimonial';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'A simple Testimonial block.';

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
    public $icon = 'format-quote';

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
    public $styles = [];

    /**
     * The block preview example data.
     *
     * @var array
     */
    public $example = [
        'align' => 'left',
        'logo' => 'https://tailwindui.com/img/logos/tuple-logo-indigo-300.svg',
        'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
        'quote' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo expedita voluptas culpa sapiente alias molestiae. Numquam corrupti in laborum sed rerum et corporis.',
        'role' => 'CEO, Workcation',
        'title' => 'Joseph Rodriguez',
        'type' => 'avatar',
    ];

    /**
     * Data to be passed to the block before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'image' => $this->image(),
            'logo' => $this->logo(),
            'quote' => $this->quote(),
            'options' => $this->options(),
            'role' => $this->role(),
            'title' => $this->title(),
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
        return (new TestimonyFields(app()))->fields()->build();
    }

    /**
     * Return the items field.
     *
     * @return array
     */
    public function image()
    {
        if ($post = get_field('testimony')) {
            return get_the_post_thumbnail_url($post->ID);
        }

        if ($this->preview) {
            return get_field('image') ?: $this->example['image'];
        }

        return get_field('image');
    }

    /**
     * Return the items field.
     *
     * @return array
     */
    public function logo()
    {
        if ($post = get_field('testimony')) {
            $logoId = get_field('logo', $post->ID);

            if (!$logoId) {
                return null;
            }

            return [
                'alt' => get_post_meta($logoId, '_wp_attachment_image_alt', true),
                'title' => get_the_title($logoId),
                'url' => wp_get_attachment_image_url($logoId, 'thumbnail'),
            ];
        }

        if ($this->preview) {
            return get_field('logo') ?: $this->example['logo'];
        }

        return get_field('logo');
    }

    /**
     * Return the items field.
     *
     * @return array
     */
    public function quote()
    {
        if ($post = get_field('testimony')) {
            return $post->post_content;
        }

        if ($this->preview) {
            return get_field('quote') ?: $this->example['quote'];
        }

        return get_field('quote');
    }

    /**
     * Return the items field.
     *
     * @return array
     */
    public function options()
    {
        return [
            'align' => get_field('align') ?: $this->example['align'],
        ];
    }

    /**
     * Return the items field.
     *
     * @return array
     */
    public function role()
    {
        if ($post = get_field('testimony')) {
            return get_field('role', $post->ID);
        }

        if ($this->preview) {
            return get_field('role') ?: $this->example['role'];
        }

        return get_field('role');
    }

    /**
     * Return the items field.
     *
     * @return array
     */
    public function title()
    {
        if ($post = get_field('testimony')) {
            return get_the_title($post->ID);
        }

        if ($this->preview) {
            return get_field('title') ?: $this->example['title'];
        }

        return get_field('title');
    }

    /**
     * Return the items field.
     *
     * @return array
     */
    public function type()
    {
        if ($this->preview) {
            return get_field('type') ?: $this->example['type'];
        }

        return get_field('type');
    }
}
