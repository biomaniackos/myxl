<?php

namespace App\Fields;

use App\Fields\Partials\HeroIconsFields;
use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;
use function Roots\app;

class TemplateCustomFields extends Field
{
    /**
     * The field group.
     *
     * @return array
     */
    public function fields()
    {
        $templateCustom = new FieldsBuilder('template_custom');

        $templateCustom
            ->setGroupConfig('hide_on_screen', ['the_content'])
            ->setLocation('page_template', '==', 'template-custom.blade.php');

        $templateCustom
            ->addImage('image', [
                'return_format' => 'id',
                'preview_size' => 'thumbnail',
            ])
            ->addPostObject('page', [
                'return_format' => 'id',
                'multiple' => 1,
                'post_type' => 'page',
            ])
            ->addFile('video', ['return_format' => 'id'])
            ->addFields((new HeroIconsFields(app()))->fields());

        return $templateCustom->build();
    }
}
