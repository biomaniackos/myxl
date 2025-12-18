<?php

namespace App\Fields\Partials;

use App\View\Components\Testimony;
use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class TestimonyFields extends Partial
{
    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $testimonyFields = new FieldsBuilder('testimony_fields');
        $testimonyFields
            ->addPostObject('testimony', [
                'allow_null' => 1,
                'instructions' => 'Choose a testimony or fill the other fields below.',
                'label' => 'Testimony Post',
                'post_type' => ['testimonies'],
                'wpml_cf_preferences' => 1,
            ])
            ->addWysiwyg('quote', [
                'conditional_logic' => [
                    [
                        [
                            'field' => 'testimony',
                            'operator' => '==empty',
                        ],
                    ],
                ],
                'toolbar' => 'full',
            ])
            ->addText('title', [
                'conditional_logic' => [
                    [
                        [
                            'field' => 'testimony',
                            'operator' => '==empty',
                        ],
                    ],
                ],
            ])
            ->addText('role', [
                'conditional_logic' => [
                    [
                        [
                            'field' => 'testimony',
                            'operator' => '==empty',
                        ],
                    ],
                ],
            ])
            ->addImage('image', [
                'conditional_logic' => [
                    [
                        [
                            'field' => 'testimony',
                            'operator' => '==empty',
                        ],
                    ],
                ],
                'return_format' => 'url',
            ])
            ->addSelect('type', [
                'choices' => Testimony::$types,
                'default_value' => Testimony::$types[0],
            ])
            ->addSelect('align', [
                'choices' => [
                    'left' => 'Left',
                    'right' => 'Right',
                ],
                'conditional_logic' => [
                    [
                        [
                            'field' => 'type',
                            'operator' => '==',
                            'value' => 'avatar',
                        ],
                    ],
                ],
                'default_value' => 'right',
            ]);

        return $testimonyFields;
    }
}
