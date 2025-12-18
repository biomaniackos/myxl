<?php

namespace App\Providers;

use Roots\Acorn\ServiceProvider;
use StoutLogic\AcfBuilder\FieldsBuilder;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        add_action('acf/init', [$this, 'setupMenuCustomFields']);
        add_action('wp_dashboard_setup', [$this, 'setupDashboardWidget']);
    }

    /**
     * Example of a custom dashboard widget.
     * @throws \StoutLogic\AcfBuilder\FieldNameCollisionException
     * @see https://www.advancedcustomfields.com/resources/acf_form/
     * @see https://developer.wordpress.org/reference/functions/wp_add_dashboard_widget/
     */
    public function setupDashboardWidget()
    {
        $widget_id = 'custom_dashboard_widget';
        $dashboard_widget = new FieldsBuilder($widget_id);
        $dashboard_widget
            ->addText('title')
            ->setLocation('post', '==', $widget_id);

        acf_add_local_field_group($dashboard_widget->build());

        wp_add_dashboard_widget($widget_id, 'Custom Dashboard Widget', function () use ($widget_id) {
            ?>
            <div class="default-container">
                <div class="column"><?php acf_form(['post_id' => $widget_id]); ?></div>
            </div>
            <?php
        });
    }

    /**
     * Add ACF to use with menu items.
     * @throws \StoutLogic\AcfBuilder\FieldNameCollisionException
     */
    public function setupMenuCustomFields()
    {
        include_once(dirname(__DIR__) . '/Fixtures/ACFMenuDepthLocation.php');

        $menu_item = new FieldsBuilder('menu_item');
        $menu_item
            ->addSelect('item_type', [
                'choices' => [
                    'link',
                    'flyout_block' => 'block (only in flyout columns)',
                ],
                'default_value' => ['link'],
            ])
            // only in flyout-columns
            ->addText('cta', [
                'default_value' => __('Learn more'),
            ])
            ->conditional('item_type', '==', 'flyout_column')
            ->setLocation('nav_menu_item', '==', 'location/primary_navigation')
                ->and('nav_menu_item_depth', '>', 0);

        acf_add_local_field_group($menu_item->build());

        $menu_submenu_item = new FieldsBuilder('menu_submenu_item');
        $menu_submenu_item
            ->addSelect('item_type', [
                'choices' => [
                    'dropout' => 'dropout',
                    'flyout_columns' => 'flyout columns',
                ],
                'default_value' => ['dropout'],
            ])

            ->setLocation('nav_menu_item', '==', 'location/primary_navigation')
                ->and('nav_menu_item_depth', '==', 0);

        acf_add_local_field_group($menu_submenu_item->build());
    }
}
