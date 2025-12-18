<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class BannerFields extends Partial
{
    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $bannerFields = new FieldsBuilder('banner_fields');
        $bannerFields
            ->addWysiwyg('message', [
                'default_value' => 'This banner as a message to tell!',
                'delay' => 1,
                'media_upload' => 0,
                'tabs' => 'all',
                'toolbar' => 'basic',
            ])
            ->addSelect('type', [
                'choices' => array_keys(\App\View\Components\Banner::$types),
                'default_value' => 'info',
            ])
            ->addRepeater('actions', [
                'layout' => 'block',
                'wpml_cf_preferences' => 1,
            ])
                ->addText('classes')
                ->addText('title')
                ->addUrl('url')
            ->endRepeater()
            ->addTrueFalse('closable', [
                'default_value' => 0,
            ]);

        return $bannerFields;
    }
}
