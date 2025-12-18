<?php
namespace App\Fixtures;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Log1x\AcfComposer\Composer;
use Roots\Acorn\Application;
use StoutLogic\AcfBuilder\FieldsBuilder;


class PostType extends Composer
{
    /**
     * The page option field groups.
     *
     * @var \StoutLogic\AcfBuilder\FieldsBuilder|array
     */
    protected $options;

    /**
     * Generated options_id.
     * @var string
     */
    public static $settingsId;

    /**
     * The post type menu name.
     *
     * @var string
     */
    public $name;

    /**
     * The post type singular form.
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
     * The post type slug.
     *
     * @var string
     */
    public $slug = null;

    /**
     * The custom post menu icon.
     *
     * @var string
     */
    public $icon = 'dashicons-admin-page';

    /**
     * Disable Gutenberg editor for this post type.
     * @var bool
     */
    public $disableGutenberg = false;

    /**
     * (Can this post_type be exported.
     * @var bool (default: true)
     */
    public $can_export = true;

    /**
     * An array of the capabilities for this post type.
     * @var array (default: [])
     */
    public $capabilities = [];

    /**
     * The string to use to build the read, edit, and delete capabilities.
     * @var string (default: 'page')
     */
    public $capability_type = 'page';

    /**
     * Whether to exclude posts with this post type from front end search results.
     * @var bool (default: false)
     */
    public $exclude_from_search = false;

    /**
     * Enables post type archives.
     * @var bool (default: true)
     */
    public $has_archive = true;

    /**
     * Whether the post type is hierarchical (e.g. page).
     * @var bool (default: false)
     */
    public $hierarchical = false;

    /**
     * An array of labels for this post type.
     * @var array (default: [])
     */
    public $labels = [];

    /**
     * The position in the menu order the post type should appear.
     * @var int (default: 0)
     */
    public $menu_position = 5;

    /**
     * Post updated messages.
     * @var array (default: [])
     */
    public $messages = [];

    /**
     * Whether a post type is intended for use publicly either via the admin interface or by front-end users.
     * @var bool (default: true)
     */
    public $public = true;

    /**
     * Whether queries can be performed on the front end for the post type as part of parse_request().
     * @var bool (default: true)
     */
    public $publicly_queryable = true;

    /**
     * To change the base url of REST API route.
     * @var string|null (default: null)
     */
    public $rest_base = null;

    /**
     * REST API Controller class name. Default is 'WP_REST_Posts_Controller'.
     * @var string|null (default: null)
     */
    public $rest_controller_class = null;

    /**
     * Triggers the handling of rewrites for this post type. To prevent rewrite, set to false.
     * @var array (default: [])
     */
    public $rewrite = [];

    /**
     * Makes this post type available via the admin bar.
     * @var bool (default: true)
     */
    public $show_in_admin_bar = true;

    /**
     * Where to show the post type in the admin menu.
     * @var bool (default: true)
     */
    public $show_in_menu = true;

    /**
     * Whether post_type is available for selection in navigation menus.
     * @var bool (default: true)
     */
    public $show_in_nav_menus = true;

    /**
     * Whether to include the post type in the REST API. Set this to true for the post type to be available in the block editor.
     * @var bool (default: true)
     */
    public $show_in_rest = true;

    /**
     * Whether to generate and allow a UI for managing this post type in the admin.
     * @var bool (default: true)
     */
    public $show_ui = true;

    /**
     * Core feature(s) the post type supports. Serves as an alias for calling add_post_type_support() directly.
     * @var string[] (default: ['author','comments','custom-fields','editor','excerpt','post-formats','revisions','thumbnail','title','trackbacks'])
     */
    public $supports = [
        'author',
        'comments',
        'custom-fields',
        'editor',
        'excerpt',
        'post-formats',
        'revisions',
        'thumbnail',
        'title',
        'trackbacks',
    ];

    /**
     * An array of taxonomy identifiers that will be registered for the post type.
     * @var array (default: [])
     */
    public $taxonomies = [];

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->options = is_a($this->options = $this->options(), FieldsBuilder::class)
            ? $this->options->build()
            : $this->options;

        if (empty($this->slug)) {
            $this->slug = Str::slug($this->name);
        }

        self::$settingsId = $this->getSettingsId();
    }

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

        if (empty($this->rest_base)) {
            $this->rest_base = $this->slug;
        }

        if (empty($this->rest_baserest_controller_class)) {
            $this->rest_baserest_controller_class = 'WP_REST_Posts_Controller';
        }

        if (empty($this->rewrite)) {
            $this->rewrite = ['slug' => $this->slug];
        }

        if (!Arr::has($this->fields, 'location.0.0')) {
            Arr::set($this->fields, 'location.0.0', [
                'param' => 'post_type',
                'operator' => '==',
                'value' => $this->slug,
            ]);
        }

        $this->register(function () {
            $defaultLabels = [
                'add_new' => __('Add New'),
                'add_new_item' => __('Add New :SingularName'),
                'all_items' => __('All :Name'),
                'archives' => __(':SingularName Archives'),
                'attributes' => __(':SingularName Attributes'),
                'edit_item' => __('Edit :SingularName'),
                'featured_image' => __('Featured Image'),
                'filter_items_list' => __('Filter items list'),
                'insert_into_item' => __('Insert into item'),
                'items_list' => __(':Name list'),
                'items_list_navigation' => __(':Name list navigation'),
                'menu_name' => __(':Name'),
                'name' => _x(':Name', 'Post Type General Name'),
                'name_admin_bar' => _x(':SingularName', 'Add New on Toolbar'),
                'new_item' => __('New :SingularName'),
                'not_found' => __('Not found'),
                'not_found_in_trash' => __('Not found in Trash'),
                'parent_item_colon' => __('Parent :SingularName:'),
                'remove_featured_image' => __('Remove featured image'),
                'search_items' => __('Search :SingularName'),
                'set_featured_image' => __('Set featured image'),
                'singular_name' => _x(':SingularName', 'Post Type Singular Name'),
                'update_item' => __('Update :SingularName'),
                'uploaded_to_this_item' => __('Uploaded to this item'),
                'use_featured_image' => __('Use as featured image'),
                'view_item' => __('View :SingularName'),
                'view_items' => __('View :Name'),
            ];
            $this->labels = collect($defaultLabels)
                ->map(function ($label) {
                    return $this->replaceNames($label);
                })
                ->merge($this->labels);

            /**
             * Register a custom post type.
             * @see https://developer.wordpress.org/reference/functions/register_post_type/
             */
            register_post_type($this->slug, [
                'can_export' => $this->can_export,
                'capability_type' => $this->capability_type,
                'capabilities' => $this->capabilities,
                'description' => $this->description,
                'exclude_from_search' => $this->exclude_from_search,
                'has_archive' => $this->has_archive,
                'hierarchical' => $this->hierarchical,
                'label' => $this->labels['name'],
                'labels' => $this->labels,
                'menu_icon' => $this->icon,
                'menu_position' => $this->menu_position,
                'public' => $this->public,
                'publicly_queryable' => $this->publicly_queryable,
                'rest_base' => $this->rest_base,
                'rest_controller_class' => $this->rest_controller_class,
                'rewrite' => $this->rewrite,
                'show_in_admin_bar' => $this->show_in_admin_bar,
                'show_in_menu' => $this->show_in_menu,
                'show_in_nav_menus' => $this->show_in_nav_menus,
                'show_in_rest' => $this->show_in_rest,
                'show_ui' => $this->show_ui,
                'supports' => $this->supports,
                'taxonomies' => $this->taxonomies,
            ]);

            if ($this->disableGutenberg) {
                add_filter('use_block_editor_for_post_type', function ($is_enabled, $post_type) {
                    if ($post_type === $this->slug) {
                        return false;
                    }

                    return $is_enabled;
                }, 10, 2);
            }

            /**
             * Create an options page for the custom post type.
             * @see https://www.advancedcustomfields.com/resources/acf_add_options_page/
             */
            if (!empty($this->options)) {
                $parent = acf_add_options_page([
                    'menu_title' => $this->labels['name'] . ' Settings',
                    'page_title' => $this->labels['name'] . ' Settings',
                    'parent_slug' => 'edit.php?post_type=' . $this->slug,
                    'post_id' => self::$settingsId, // @note - this will be used to retrieve values
                ]);

                if (!Arr::has($this->options, 'location.0.0')) {
                    Arr::set($this->options, 'location.0.0', [
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => $parent['menu_slug'],
                    ]);
                }

                acf_add_local_field_group($this->build($this->options));
            }

            /**
             * Sets the post updated messages for the custom post type.
             * @see https://developer.wordpress.org/reference/hooks/post_updated_messages/
             */
            add_filter('post_updated_messages', function ($messages) {
                global $post;
                $permalink = esc_url(get_permalink($post));

                $defaultMessages = [
                    sprintf(__(':SingularName updated. <a target="_blank" href="%s">View :name</a>'), esc_url($permalink)),
                    __('Custom field updated.'),
                    __('Custom field deleted.'),
                    __(':SingularName updated.'),
                    // translators: %s: date and time of the revision
                    isset($_GET['revision']) ? sprintf(__(':SingularName restored to revision from %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
                    // translators: %s: post permalink
                    sprintf(__(':SingularName published. <a href="%s">View :name</a>'), esc_url($permalink)),
                    __(':SingularName saved.'),
                    // translators: %s: post permalink
                    sprintf(__(':SingularName submitted. <a target="_blank" href="%s">Preview :name</a>'), esc_url(add_query_arg('preview', 'true', $permalink))),
                    // translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink
                    sprintf(__(':SingularName scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview :name</a>'), date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url($permalink)),
                    // translators: %s: post permalink
                    sprintf(__(':SingularName draft updated. <a target="_blank" href="%s">Preview :name</a>'), esc_url(add_query_arg('preview', 'true', $permalink))),
                ];

                $messages[$this->name] = collect($defaultMessages)
                    ->map(function ($message) {
                        return $this->replaceNames($message);
                    })
                    ->merge($this->messages)
                    ->prepend('');

                return $messages;
            });
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
     * Get options ID.
     * @return string
     */
    private function getSettingsId()
    {
        // @note - WPML need a custom and unique reference for page options.
        if (defined('ICL_LANGUAGE_CODE')) {
            return $this->slug . '_settings_' . ICL_LANGUAGE_CODE;
        }

        return $this->slug . '_settings';
    }

    /**
     * The custom post options page field group.
     *
     * @return array|FieldsBuilder
     */
    public function options()
    {
        return [];
    }

    public function register($callback = null)
    {
        if (empty($this->fields)) {
            return;
        }

        // @note - we set a custom priority of 1 to allow retrieving all post types from get_post_types method.
        add_filter('init', function () use ($callback) {
            if ($callback) {
                $callback();
            }

            acf_add_local_field_group(
                $this->build($this->fields)
            );
        }, 1);
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
