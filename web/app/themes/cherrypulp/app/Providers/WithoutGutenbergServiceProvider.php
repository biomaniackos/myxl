<?php

namespace App\Providers;

use App\Blocks\Banner;
use App\Blocks\LogoCloud;
use Roots\Acorn\ServiceProvider;
use StoutLogic\AcfBuilder\FieldsBuilder;

class WithoutGutenbergServiceProvider extends ServiceProvider
{
    public $components = [
        'banner' => Banner::class,
        'logo-cloud' => LogoCloud::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        add_action('acf/init', [$this, 'setupAcfComponent']);
    }

    public function isGutenbergDisabled($post_type)
    {
        $fields = get_fields('developer_option');

        return $fields && $fields['classic_editor'] && !in_array($post_type, $fields['except']);
    }

    public function setupAcfComponent()
    {
        $types = array_merge([
            'post',
            'page',
        ], get_post_types([
            'public'   => true,
            '_builtin' => false,
        ], 'names', 'and'));

        foreach ($types as $type) {
            if ($this->isGutenbergDisabled(($type))) {
                $template_page = new FieldsBuilder('template_' . $type, [
                    'hide_on_screen' => ['the_content'],
                    'position' => 'acf_after_title',
                ]);
                $flexible = $template_page
                    ->addFlexibleContent('sections');

                foreach ($this->components as $name => $component) {
                    $flexible = $flexible
                        ->addLayout(($component)::acf());
                }

                $template_page->setLocation('post_type', '==', $type);

                acf_add_local_field_group($template_page->build());
            }
        }
    }
}
