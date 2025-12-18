<?php

namespace App\Options;

use Log1x\AcfComposer\Options as Field;
use Roots\Acorn\Application;
use StoutLogic\AcfBuilder\FieldsBuilder;
use function Roots\add_actions;

/**
 * @note use `wp user set-role 1 developer` to set you role
 */
class DeveloperSettings extends Field
{
    /**
     * The option page menu name.
     *
     * @var string
     */
    public $name = 'Developer Settings';

    /**
     * The option page document title.
     *
     * @var string
     */
    public $title = 'Developer Settings';

    /**
     * The option page permission capability.
     * @var string
     */
    public $capability = 'do_anything';

    /**
     * The option page menu position.
     *
     * @var int
     */
    public $position = 900;

    /**
     * The post ID to save and load values from.
     *
     * @var string|int
     */
    public $post = 'developer_option';

    public function __construct(Application $app)
    {
        parent::__construct($app);

        add_action('init', [$this, 'modifyFields'], 10);
        add_actions(['after_setup_theme', 'activated_plugin', 'deactivated_plugin'], [$this, 'setupDeveloperRole'], 999);
        add_action('admin_bar_menu', [$this, 'disableBarMenuItems'], 999);
        add_actions(['wp_dashboard_setup', 'wp_user_dashboard_setup'], [$this, 'disableDashboardWidgets'], 999);
        add_filter('use_block_editor_for_post_type', [$this, 'disableGutenberg'], 999, 2);
        add_action('admin_menu', [$this, 'disableMenuItems'], 999);
        add_action('init', [$this, 'disableUpdatesNotices'], 999);
    }

    /**
     * Remove dashboard widgets.
     * @note - use `global $wp_meta_boxes;` to show all dashboard widgets
     */
    public function disableDashboardWidgets()
    {
        if (!current_user_can('do_anything')) {
            $fields = get_fields('developer_option');

            if (isset($fields['hidden_dashboard_widgets'])) {
                global $wp_meta_boxes;

                foreach ($fields['hidden_dashboard_widgets'] as $widget) {
                    $args = explode('/', $widget);

                    if (count($args) > 2) {
                        if (isset($wp_meta_boxes[$args[0]][$args[1]]['core'][$args[2]])) {
                            unset($wp_meta_boxes[$args[0]][$args[1]]['core'][$args[2]]);
                        }
                    } else {
                        remove_action($args[0], $args[1]);
                    }
                }
            }
        }
    }

    /**
     * Remove admin bar items accordingly to the hidden_menu_items.
     * @param $wp_admin_bar
     */
    public function disableBarMenuItems($wp_admin_bar)
    {
        if (!current_user_can('do_anything')) {
            $fields = get_fields('developer_option');

            if (isset($fields['hidden_menu_items'])) {
                if (in_array('index.php/update-core.php', $fields['hidden_menu_items'])) {
                    $wp_admin_bar->remove_node('updates');
                }

                if (in_array('edit-comments.php', $fields['hidden_menu_items'])) {
                    $wp_admin_bar->remove_node('comments');
                }

                $hasCustomize = collect($fields['hidden_menu_items'])->first(function ($value) {
                    return str_contains($value, 'themes.php/customize.php?return=');
                });

                if ($hasCustomize) {
                    $wp_admin_bar->remove_node('customize');
                }
            }
        }
    }

    /**
     * Disable Gutenberg editor except for select ones.
     * @param $is_enabled
     * @param $post_type
     *
     * @return false
     */
    public function disableGutenberg($is_enabled, $post_type)
    {
        $fields = get_fields('developer_option');

        if ($fields && $fields['classic_editor'] && !in_array($post_type, $fields['except'], true)) {
            return false;
        }

        return $is_enabled;
    }

    /**
     * Remove selected menu items from admin menu when non-developer.
     */
    public function disableMenuItems()
    {
        if (!current_user_can('do_anything')) {
            $fields = get_fields('developer_option');

            if (isset($fields['hidden_menu_items'])) {
                foreach ($fields['hidden_menu_items'] as $page) {
                    $args = explode('/', $page);

                    if (count($args) > 1) {
                        remove_submenu_page($args[0], $args[1]);
                    } else {
                        remove_menu_page($args[0]);
                    }
                }
            }
        }
    }

    /**
     * Disable updates notice and emails for non-developer.
     */
    public function disableUpdatesNotices()
    {
        if (current_user_can('do_anything')) {
            return;
        }

        $fields = get_fields('developer_option');

        if ($fields && isset($fields['updates_notices']) && $fields['updates_notices']) {
            // Disable auto-update email notifications for plugins.
            add_filter('auto_plugin_update_send_email', '__return_false');

            // Disable auto-update email notifications for themes.
            add_filter('auto_theme_update_send_email', '__return_false');

            // Disable the wordpress plugin update notifications.
            remove_action('load-update-core.php', 'wp_update_plugins');
            add_filter('pre_site_transient_update_plugins', '__return_null');

            // Disable the wordpress theme update notifications
            remove_action('load-update-core.php', 'wp_update_themes');
            add_filter('pre_site_transient_update_themes', '__return_null');

            // Disable the wordpress core update notifications
            add_action('after_setup_theme', function () {
                if (!current_user_can('update_core')) {
                    return;
                }

                add_filter('pre_option_update_core', '__return_null');
                add_filter('pre_site_transient_update_core', '__return_null');
            });
        }
    }

    /**
     * The option page field group.
     *
     * @return array|FieldsBuilder
     */
    public function fields()
    {
        $developerSettings = new FieldsBuilder('developer_settings');

        $developerSettings
            ->addTab('Admin Interface');

        $developerSettings
            ->addTrueFalse('classic_editor', [
                'instructions' => 'Disable Gutenberg editor for all or specific post types.',
                'ui' => 1,
            ]);

        $developerSettings
            ->addSelect('except', [
                'allow_null' => 1,
                // @note - 'choices' will be updated on 'init' to gather all custom post types (see 'modifyFields' method below)
                'choices' => [],
                'instructions' => 'Disable Gutenberg editor except for those types.',
                'multiple' => 1,
                'ui' => 1,
            ])
            ->conditional('classic_editor', '==', 1);

        $developerSettings
            ->addTrueFalse('updates_notices', [
                'instructions' => 'Disable WordPress update notification for non-developer.',
                'ui' => 1,
            ]);

        $dashboardWidgetsChoices = [
            // @note - "context/screen/id" => "label"
            'welcome_panel/wp_welcome_panel' => 'Welcome Panel',
            'try_gutenberg_panel/wp_try_gutenberg_panel' => 'Try Gutenberg',
            'dashboard/side/dashboard_primary' => 'WordPress.com Blog',
            'dashboard/side/dashboard_quick_press' => 'Quick Press widget',
            'dashboard/side/dashboard_recent_drafts' => 'Recent Drafts',
            'dashboard/side/dashboard_secondary' => 'Other WordPress News',
            'dashboard/normal/dashboard_plugins' => 'Plugins',
            'dashboard/normal/dashboard_site_health' => 'Site Health',
            'dashboard/normal/dashboard_right_now' => 'Right Now',
            'dashboard/normal/dashboard_incoming_links' => 'Incoming Links',
            'dashboard/normal/dashboard_recent_comments' => 'Recent Comments',
            'dashboard/normal/dashboard_activity' => 'Activity',
        ];

        $menuItemsChoices = [
            // @note - "page/subpage" => "label"
            'edit.php' => 'posts',
            'edit-comments.php' => 'comments',
            'upload.php' => 'media',
            'plugins.php' => 'plugins',
            'tools.php' => 'tools',
            'users.php' => 'users',
            'themes.php' => 'appearance',
            'themes.php/themes.php' => 'appearance/themes',
            'themes.php/' . add_query_arg('return', urlencode(remove_query_arg(wp_removable_query_args(), wp_unslash($_SERVER['REQUEST_URI']))), 'customize.php') => 'appearance/customize',
            'themes.php/nav-menus.php' => 'appearance/nav-menus',
            'themes.php/theme-editor.php' => 'appearance/theme-editor',
            'themes.php/widgets.php' => 'appearance/widgets',
            'index.php' => 'dashboard',
            'index.php/update-core.php' => 'dashboard/updates',
            'options-general.php' => 'settings',
            'options-general.php/options-general.php' => 'settings/general',
            'options-general.php/options-discussion.php' => 'settings/discussion',
            'options-general.php/options-media.php' => 'settings/media',
            'options-general.php/options-permalink.php' => 'settings/permalinks',
            'options-general.php/options-privacy.php' => 'settings/privacy',
            'options-general.php/options-reading.php' => 'settings/reading',
            'options-general.php/options-writing.php' => 'settings/writing',
            'edit.php?post_type=acf-field-group' => 'plugins/custom-fields',
        ];

        if (is_plugin_active('gravity-forms/gravityforms.php')) {
            $menuItemsChoices['gf_edit_forms'] = 'plugins/gravity-forms';
            $menuItemsChoices['gf_edit_forms/gf_new_form'] = 'plugins/gravity-forms/new-form';
            $menuItemsChoices['gf_edit_forms/gf_entries'] = 'plugins/gravity-forms/entries';
            $menuItemsChoices['gf_edit_forms/gf_settings'] = 'plugins/gravity-forms/settings';
            $menuItemsChoices['gf_edit_forms/gf_export'] = 'plugins/gravity-forms/export';
            $menuItemsChoices['gf_edit_forms/gf_addons'] = 'plugins/gravity-forms/addons';
            $menuItemsChoices['gf_edit_forms/gf_system_status'] = 'plugins/gravity-forms/system_status';
            $menuItemsChoices['gf_edit_forms/gf_help'] = 'plugins/gravity-forms/help';
            $dashboardWidgetsChoices['dashboard/normal/rg_forms_dashboard'] = 'Gravity Forms';
        }

        if (is_plugin_active('wordpress-seo/wp-seo.php') || class_exists('WPSEO_Options')) {
            $dashboardWidgetsChoices['dashboard/normal/wpseo-dashboard-overview'] = 'Yoast SEO Posts Overview';
        }

        if (is_plugin_active('wpml-multilingual-cms/sitepress.php')) {
            $menuItemsChoices['WPML'] = 'plugins/wpml';
            $dashboardWidgetsChoices['dashboard/normal/icl_dashboard_widget'] = 'Multi Language Plugins';
        }

        $developerSettings
            ->addSelect('hidden_menu_items', [
                'allow_null' => 1,
                'choices' => $menuItemsChoices,
                'instructions' => 'Select menu items that will be hidden for non-developer.',
                'multiple' => 1,
                'ui' => 1,
            ]);

        $developerSettings
            ->addSelect('hidden_dashboard_widgets', [
                'allow_null' => 1,
                'choices' => $dashboardWidgetsChoices,
                'instructions' => 'Select dashboard items that will be hidden for non-developer.',
                'multiple' => 1,
                'ui' => 1,
            ]);

        return $developerSettings;
    }

    /**
     * Update fields settings on 'init'.
     * @throws \StoutLogic\AcfBuilder\FieldNotFoundException
     */
    public function modifyFields()
    {
        $developerSettings = $this->fields();
        $developerSettings->modifyField('except', [
            // @note - doing this here ensure that we gather all registered custom post types
            'choices' => collect(get_post_types(['public' => true], 'objects'))
                ->pluck('label', 'name')
                ->except(['acf-field', 'acf-field-group', 'wp_stream_alerts', 'wp_area', 'attachment'])
                ->all(),
        ]);

        $this->fields = $developerSettings->build();
        $this->compose();
    }

    /**
     * Allow to check for developer capability
     * @note - use `wp user set-role 1 developer`
     * @example
     * if (current_user_can('do_anything')) {
     *     // do something...
     * }
     */
    public function setupDeveloperRole()
    {
        $wp_roles = wp_roles();
        $administrator = $wp_roles->get_role('administrator');

        if (!$wp_roles->is_role('developer')) {
            $wp_roles->add_role('developer', 'Developer', $administrator->capabilities);
        }

        $developer = $wp_roles->get_role('developer');

        if (count(array_diff_key($administrator->capabilities, $developer->capabilities))) {
            foreach ($administrator->capabilities as $capability => $status) {
                $developer->add_cap($capability, $status);
            }
        }

        // @note - fix a case where developer cannot see the GF menu item.
        if (is_plugin_active('gravity-forms/gravityforms.php') && !array_key_exists('gravityforms_create_form', $developer->capabilities)) {
            $gravityFormsCapabilities = [
                'gravityforms_create_form' => true,
                'gravityforms_delete_forms' => true,
                'gravityforms_edit_forms' => true,
                'gravityforms_preview_forms' => true,
                'gravityforms_view_entries' => true,
                'gravityforms_edit_entries' => true,
                'gravityforms_delete_entries' => true,
                'gravityforms_view_entry_notes' => true,
                'gravityforms_edit_entry_notes' => true,
                'gravityforms_export_entries' => true,
                'gravityforms_view_settings' => true,
                'gravityforms_edit_settings' => true,
                'gravityforms_view_updates' => true,
                'gravityforms_view_addons' => true,
                'gravityforms_system_status' => true,
                'gravityforms_uninstall' => true,
                'gravityforms_logging' => true,
                'gravityforms_api_settings' => true,
            ];
            foreach ($gravityFormsCapabilities as $capability => $status) {
                $developer->add_cap($capability, $status);
            }
        }

        if (!array_key_exists('do_anything', $developer->capabilities)) {
            $developer->add_cap('do_anything', true);
        }
    }
}
