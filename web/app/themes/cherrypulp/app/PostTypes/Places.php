<?php
namespace App\PostTypes;

use App\Fixtures\PostType;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Places extends PostType
{
    /**
     * The post type menu name.
     *
     * @var string
     */
    public $name = 'Places';

    /**
     * The post type plural form.
     *
     * @var string
     */
    public $singularName = 'Place';

    /**
     * The post type description.
     *
     * @var string
     */
    public $description = 'A simple Place post type.';

    /**
     * The post type icon.
     *
     * @var string
     */
    public $icon = 'dashicons-admin-page';

    /**
     * The post type supports.
     *
     * @var string[]
     */
    public $supports = [
        'editor',
        'thumbnail',
        'title',
    ];
}
