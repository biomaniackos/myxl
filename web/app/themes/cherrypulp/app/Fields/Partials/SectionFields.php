<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class SectionFields extends Partial
{
    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $sectionFields = new FieldsBuilder('section_fields');
        $sectionFields
            ->addSelect('item', [
                'choices' => [
                    'article',
                    'aside',
                    'footer',
                    'header',
                    'section',
                ],
                'default_value' => 'section',
            ]);

        return $sectionFields;
    }
}
