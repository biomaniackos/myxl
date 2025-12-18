<?php
namespace App\PostTypes;

use App\Fixtures\PostType;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Activities extends PostType
{
    /**
     * The post type menu name.
     *
     * @var string
     */
    public $name = 'Activities';

    /**
     * The post type plural form.
     *
     * @var string
     */
    public $singularName = 'Activity';

    /**
     * The post type description.
     *
     * @var string
     */
    public $description = 'A simple Activities post type.';

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
        // 'author',
        'editor',
        'thumbnail',
        'title',
    ];

    /**
     * The custom post options page field group.
     *
     * @return array|FieldsBuilder
     */
    public function options()
    {
        $activitiesSettings = new FieldsBuilder('activities_settings');
        $activitiesSettings->addWysiwyg('title', [
            'media_upload' => 0,
            'instructions' => "Utilisé les balises <strong> pour surligner votre texte
            <br>
            <br>
            1) sélectionner votre mot
            <br>
            2) cliquer sur [ b ]
            <br>",
            'tabs' => 'visual',
            'toolbar' => 'very_simple',
        ]);
        return $activitiesSettings;
    }
}
