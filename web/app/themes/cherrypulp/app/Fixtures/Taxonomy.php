<?php

namespace App\Fixtures;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Log1x\AcfComposer\Composer;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Taxonomy extends Composer
{
    /**
     * The taxonomy menu name.
     *
     * @var string
     */
    public $name;

    /**
     * The taxonomy singular form.
     *
     * @var string
     */
    public $singularName = '';

    /**
     * The custom post description.
     *
     * @var string
     */
    public $description = '';

    /**
     * The taxonomy slug.
     *
     * @var string
     */
    public $slug = null;

    /**
     * The taxonomy post types.
     *
     * @var string
     */
    public $types = [];

    /**
     * The taxonomy default terms.
     * @see https://developer.wordpress.org/reference/functions/wp_insert_term/
     * @var string
     */
    public $defaultTerms = [];

    // @see https://developer.wordpress.org/reference/functions/register_taxonomy/
    /**
     * Array of capabilities for this taxonomy.
     * @var array (default: [])
     */
    public $capabilities = [];

    /**
     * Whether the taxonomy is hierarchical.
     * @var bool (default: false)
     */
    public $hierarchical = false;

    /**
     * An array of labels for this taxonomy.
     * @var array (default: [])
     */
    public $labels = [];

    /**
     * The messages to be displayed.
     * @var array (default: [])
     */
    public $messages = [];

    /**
     * Whether a taxonomy is intended for use publicly either via the admin interface or by front-end users.
     * @var bool (default: true)
     */
    public $public = true;

    /**
     * Whether the taxonomy is publicly queryable.
     * @var bool (default: true)
     */
    public $publicly_queryable = true;

    /**
     * Where to show the taxonomy in the admin menu.
     * @var bool (default: true)
     */
    public $show_in_menu = true;

    /**
     * Makes this taxonomy available for selection in navigation menus.
     * @var bool (default: true)
     */
    public $show_in_nav_menus = true;

    /**
     * Whether to include the taxonomy in the REST API.
     * @var bool (default: true)
     */
    public $show_in_rest = true;

    /**
     * Whether to generate a default UI for managing this taxonomy.
     * @var bool (default: true)
     */
    public $show_ui = true;

    /**
     * Compose and register the defined field groups with ACF.
     *
     * @return void
     */
    public function compose()
    {
        if (empty($this->name)) {
            return;
        }

        if (empty($this->slug)) {
            $this->slug = Str::slug($this->name);
        }

        if (!Arr::has($this->fields, 'location.0.0')) {
            Arr::set($this->fields, 'location.0.0', [
                'param' => 'taxonomy',
                'operator' => '==',
                'value' => $this->slug,
            ]);
        }

        $this->register(function () {
            $defaultLabels = [
                'add_new_item' => __('Add New'),
                'add_or_remove_items' => __('Add or remove'),
                'all_items' => __('All :Name'),
                'back_to_items' => __('&larr; Back to :Name'),
                'choose_from_most_used' => __('Choose from the most used :name'),
                'edit_item' => __('Edit :Name'),
                'items_list' => __(':Name list'),
                'items_list_navigation' => __(':Name list navigation'),
                'menu_name' => __(':Name'),
                'most_used' => _x('Most Used', 'medium'),
                'name' => __(':Name'),
                'new_item_name' => __('New :Name'),
                'no_terms' => __('No item'),
                'not_found' => __('No item found.'),
                'parent_item' => __('Parent :Name'),
                'parent_item_colon' => __('Parent :Name:'),
                'popular_items' => __('Popular Media'),
                'search_items' => __('Search Media'),
                'separate_items_with_commas' => __('Separate item with commas'),
                'singular_name' => _x(':Name', 'taxonomy general name'),
                'update_item' => __('Update :Name'),
                'view_item' => __('View :Name'),
            ];
            $this->labels = collect($defaultLabels)
                ->map(function ($label) {
                    return $this->replaceNames($label);
                })
                ->merge($this->labels);

            // @see https://developer.wordpress.org/reference/functions/register_taxonomy/
            register_taxonomy($this->slug, $this->types, [
                'capabilities' => $this->capabilities,
                'description' => $this->description,
                'hierarchical' => $this->hierarchical,
                'label' => $this->labels['name'],
                'labels' => $this->labels,
                'public' => $this->public,
                'publicly_queryable' => $this->publicly_queryable,
                'show_in_menu' => $this->show_in_menu,
                'show_in_nav_menus' => $this->show_in_nav_menus,
                'show_in_rest' => $this->show_in_rest,
                'show_ui' => $this->show_ui,
            ]);

            // @see https://developer.wordpress.org/reference/hooks/term_updated_messages/
            add_filter('term_updated_messages', function () {
                $defaultMessages = [
                    __(':SingularName added.'),
                    __(':SingularName deleted.'),
                    __(':SingularName updated.'),
                    __(':SingularName not added.'),
                    __(':SingularName not updated.'),
                    __(':SingularName deleted.'),
                ];

                $this->messages = collect($defaultMessages)
                    ->map(function ($message) {
                        return $this->replaceNames($message);
                    })
                    ->merge($this->messages)
                    ->prepend('');
            });

            // create terms inside our taxonomy
            foreach ($this->defaultTerms as $term) {
                if (!term_exists($term['name'], $this->slug)) {
                    if (empty($term['description'])) {
                        $term['description'] = '';
                    }

                    if (empty($term['parent'])) {
                        $term['parent'] = null;
                    }

                    if (empty($term['slug'])) {
                        $term['slug'] = Str::slug($term['name']);
                    }

                    // @see https://developer.wordpress.org/reference/functions/wp_insert_term/
                    wp_insert_term($term['name'], $this->slug, [
                        'description' => $term['description'],
                        'parent' => $term['parent'],
                        'slug' => $term['slug'],
                    ]);
                }
            }
        });
    }

    /**
     * The custom post field group.
     *
     * @return array|FieldsBuilder
     */
    public function fields()
    {
        return [];
    }

    /**
     * Replace names inside stub.
     * @param $stub
     * @return array|string|string[]
     */
    protected function replaceNames($stub)
    {
        return str_replace(
            [':singularName', ':name', ':SingularName', ':Name'],
            [strtolower($this->singularName), strtolower($this->name), ucfirst($this->singularName), ucfirst($this->name)],
            $stub
        );
    }
}
