<?php
namespace App\Taxonomies;

use App\Fixtures\Taxonomy;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ActivityTypes extends Taxonomy
{
    /**
     * The taxonomy menu name.
     *
     * @var string
     */
    public $name = 'Activity Types';

    /**
     * The taxonomy singular form.
     *
     * @var string
     */
    public $singularName = 'Activity Type';

    /**
     * The taxonomy description.
     *
     * @var string
     */
    public $description = 'A simple Activity Types taxonomy.';

    /**
     * The taxonomy post types.
     *
     * @var string
     */
    public $types = [
        'post',
        'activities',
        'places',
    ];

    /**
     * The taxonomy default terms.
     * @see https://developer.wordpress.org/referefnce/functions/wp_insert_term/
     * @var string
     */
    public $defaultTerms = [];

    /**
     * Whether the taxonomy is hierarchical.
     * @var bool (default: false)
     */
    public $hierarchical = true;

    /**
     * The custom post field group.
     *
     * @return array|FieldsBuilder
     */
    public function fields()
    {
        $activityTypesFields = new FieldsBuilder('activity_types_fields');
        $activityTypesFields
            ->addImage('image', [
                'return_format' => 'id',
                'preview_size' => 'thumbnail',
            ]);

        return $activityTypesFields;
    }
}
