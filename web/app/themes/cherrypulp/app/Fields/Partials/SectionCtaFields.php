<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class SectionCtaFields extends Partial
{
    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $sectionCtaFields = new FieldsBuilder('section_cta_fields');
        $sectionCtaFields
            ->addImage('image', [
                'return_format' => 'url',
                'preview_size' => 'thumbnail',
            ])
            ->addText('title', [
                'default_value' => 'Ready to dive in? Start your free trial today.',
            ])
            ->addWysiwyg('content', [
                'default_value' => '<p>Ac euismod vel sit maecenas id pellentesque eu sed consectetur.</p><p>Malesuada adipiscing sagittis vel nulla nec.</p>',
                'delay' => 1,
                'media_upload' => 0,
                'tabs' => 'all',
                'toolbar' => 'basic',
            ])
            ->addRepeater('actions', [
                'layout' => 'block',
                'wpml_cf_preferences' => 1,
            ])
                ->addText('classes')
                ->addText('title')
                ->addUrl('url')
            ->endRepeater();

        return $sectionCtaFields;
    }
}
