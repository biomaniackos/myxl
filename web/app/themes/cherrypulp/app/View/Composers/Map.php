<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Map extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'template-map',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'places' => $this->places(),
            'actitiesType' => $this->actitiesType(),
        ];
    }

    public function places()
    {
        $places = get_posts([
            'post_type' => ['places', 'activities'],
            'numberposts' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
        ]);

        return $places;
    }

    public function actitiesType()
    {
        $activities = get_terms(array(
            'taxonomy' => 'activity-types',
            'hide_empty' => false,
        ));
        if (!empty($activities)) {
            return collect($activities)
                ->map(function ($item) {
                    $item->fields = get_fields($item->ID);
                    return $item;
                })
                ->toArray();
        }
        
        return [];
    }    
}
