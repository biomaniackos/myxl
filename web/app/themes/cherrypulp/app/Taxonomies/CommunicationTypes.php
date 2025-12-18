<?php
namespace App\Taxonomies;

use App\Fixtures\Taxonomy;
use StoutLogic\AcfBuilder\FieldsBuilder;

class CommunicationTypes extends Taxonomy
{
    /**
     * The taxonomy menu name.
     *
     * @var string
     */
    public $name = 'Communication Types';

    /**
     * The taxonomy singular form.
     *
     * @var string
     */
    public $singularName = 'Communication Type';

    /**
     * The taxonomy description.
     *
     * @var string
     */
    public $description = 'A simple Communication Types taxonomy.';

    /**
     * The taxonomy post types.
     *
     * @var string
     */
    public $types = ['emails'];

    /**
     * The taxonomy default terms.
     * @see https://developer.wordpress.org/reference/functions/wp_insert_term/
     * @var string
     */
    public $defaultTerms = [
        ['name' => 'Automation'],
        ['name' => 'Campaign'],
        ['name' => 'Transactional'],
    ];
}
