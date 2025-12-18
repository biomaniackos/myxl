<?php
namespace App\PostTypes;

use App\Fixtures\PostType;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Modals extends PostType
{
    /**
     * The post type menu name.
     *
     * @var string
     */
    public $name = 'Modals';

    /**
     * The post type singular form.
     *
     * @var string
     */
    public $singularName = 'Modal';

    /**
     * The post type description.
     *
     * @var string
     */
    public $description = 'A simple Modals post type.';

    /**
     * The post type icon.
     *
     * @var string
     */
    public $icon = 'dashicons-align-center';

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

    /**
     * The custom post field group.
     *
     * @return array|FieldsBuilder
     */
    public function fields()
    {
        $modalsFields = new FieldsBuilder('modals', [
            'hide_on_screen' => [
                'permalink',
                'slug',
            ],
        ]);
        $modalsFields
            ->addTrueFalse('closable', [
                'instructions' => 'Add a cross icon to close the modal.',
                'default_value' => 0,
                'ui' => 0,
            ])
            ->addFlexibleContent('actions', [
                'instructions' => 'Add button(s) on footer.',
                'wpml_cf_preferences' => 1,
            ])
            ->addLayout('close')
                ->addText('label')
            ->addLayout('link')
                ->addText('label')
                ->addUrl('url');

        return $modalsFields;
    }

    /**
     * The custom post options page field group.
     *
     * @return array|FieldsBuilder
     */
    public function options()
    {
        $modalsSettings = new FieldsBuilder('modals_settings');
        $modalsSettings->addText('title');
        return $modalsSettings;
    }
}
