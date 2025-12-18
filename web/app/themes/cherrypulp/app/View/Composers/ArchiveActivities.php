<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use App\PostTypes\Activities;

class ArchiveActivities extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'archive-activities',
        'taxonomy-activity-types',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function override()
    {
        return [
            'options' => $this->options(),
            // 'posts' => $this->posts(),
            'activities' => $this->activities(),
        ];
    }

    public function options()
    {
        if ($options = get_fields(Activities::$settingsId)) {
            return $options;
        }

        return [];
    }

    public function posts()
    {
        global $posts;

        if (!empty($posts)) {
            return collect($posts)
                ->map(function ($item) {
                    $item->fields = get_fields($item->ID);
                    return $item;
                })
                ->toArray();
        }
        
        return [];
    }

    public function activities()
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
