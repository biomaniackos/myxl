<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Single extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'single'
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'post' => get_post(),
            'related_posts' => $this->related_posts(),
        ];
    }

    public function related_posts()
    {
        $post = get_queried_object();
        $terms = get_the_terms($post->ID, 'activity-types');
        $term = null;
        if (is_array($terms) && count($terms)) {
            $term = $terms[0];
            $back['url'] = get_term_link($term);
            $back['title'] = 'Activité ' . $term->name;
        }

        $allTerms = get_terms('activity-types');
        $allTermsArr = [];
        foreach ($allTerms as $x => $value) {
            array_push($allTermsArr, $value->term_id);
        }

        if ($term) {
            return get_posts([
                'post_type' => 'post',
                'numberposts' => 2,
                'orderby' => 'date',
                'order' => 'DESC',
                'tax_query' => [
                    'relation' => 'OR',
                    [
                        'taxonomy' => 'activity-types',
                        'field' => 'term_id',
                        'terms' => $term->term_id,
                    ],
                    [
                        'taxonomy' => 'activity-types',
                        'field' => 'term_id',
                        'terms' => $allTermsArr,
                    ]
                ],
                'exclude' => $post->ID,
            ]);
        }

        return get_posts([
            'post_type' => 'post',
            'numberposts' => 2,
            'orderby' => 'date',
            'order' => 'DESC',
            'tax_query' => [
                [
                    'taxonomy' => 'activity-types',
                    'field' => 'term_id',
                    'terms' => $allTermsArr,
                ]
            ],
            'exclude' => $post->ID,
        ]);
    }
}
