<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use WP_Query;

class ArchivePost extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'index',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function override()
    {
        return [
            'posts_query' => $this->posts(),
            'activities' => $this->activities(),
            'filters' => $this->filters(),
        ];
    }

    public function filters()
    {
        if (isset($_GET['filters'])) {
            $filters = $_GET['filters'];
            return explode(',', $filters);
        }
        return [];
    }

    public function posts()
    {
        global $wp_query;
        $paged = $wp_query->query_vars['paged'] ?? 0;

        if (isset($_GET['filters']) && !empty($_GET['filters'])) {

            $filters = $_GET['filters'];
            $values = explode(',', $filters);

            return new WP_Query([
                'post_type' => 'post',
                'numberposts' => -1,
                'orderby' => 'date',
                'order' => 'DESC',
                'paged' => $paged,
                'tax_query' => [
                    [
                        'taxonomy' => 'activity-types',
                        'field' => 'slug',
                        'terms' => $values,
                    ],
                ],
            ]);
        }

        return new WP_Query([
            'post_type' => 'post',
            'numberposts' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
            'paged' => $paged,
        ]);
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