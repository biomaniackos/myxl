<?php
namespace App\PostTypes;

use App\Fixtures\PostType;
use Roots\Acorn\Application;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Emails extends PostType
{
    /**
     * The post type menu name.
     *
     * @var string
     */
    public $name = 'Emails';

    /**
     * The post type singular form.
     *
     * @var string
     */
    public $singularName = 'Email';

    /**
     * The post type description.
     *
     * @var string
     */
    public $description = 'A simple Emails post type.';

    /**
     * The post type icon.
     *
     * @var string
     */
    public $icon = 'dashicons-email-alt';

    /**
     * The post type supports.
     *
     * @var string[]
     */
    public $supports = [
        'author',
        'editor',
        'thumbnail',
        'title',
    ];

    /**
     * The post type taxonomies.
     *
     * @var string[]
     */
    public $taxonomies = ['communication_types'];

    /**
     * Disable Gutenberg editor for this post type.
     * @var bool
     */
    public $disableGutenberg = true;

    public function __construct(Application $app)
    {
        parent::__construct($app);

        // Disable Yoast
        add_action('add_meta_boxes', function () {
            remove_meta_box('wpseo_meta', $this->slug, 'normal');
        }, 100);
    }

    /**
     * The custom post field group.
     *
     * @return array|FieldsBuilder
     */
    public function fields()
    {
        $emailsFields = new FieldsBuilder('emails_fields');
        $emailsFields
            ->addImage('image', [
                'return_format' => 'id',
                'preview_size' => 'thumbnail',
            ]);

        return $emailsFields;
    }

    /**
     * The custom post options page field group.
     *
     * @return array|FieldsBuilder
     */
    public function options()
    {
        $emailsSettings = new FieldsBuilder('emails_settings');
        $emailsSettings->addText('title');
        return $emailsSettings;
    }
}
