<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class LogoCloudFields extends Partial
{
    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $logoCloudFields = new FieldsBuilder('logo_cloud_fields');
        $logoCloudFields
            ->addRepeater('items', [
                'layout' => 'block',
                'wpml_cf_preferences' => 1,
            ])
                ->addImage('image', [
                    'return_format' => 'array',
                    'preview_size' => 'thumbnail',
                ])
                ->addUrl('link')
            ->endRepeater()
            ->addSelect('type', [
                'choices' => \App\View\Components\LogoCloud::$types,
                'default_value' => 'grid',
            ]);

        return $logoCloudFields;
    }
}
