<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use Roots\Acorn\View\Composers\Concerns\AcfFields;

class Post extends Composer
{
    use AcfFields;

    /**
     * List of views served by this composer.
     * @var array
     */
    protected static $views = [
        'partials.page-header',
        'partials.content',
        'partials.content-*',
    ];

    /**
     * Data to be passed to view before rendering, but after merging.
     * @return array
     */
    public function with()
    {
        return [
            'description' => $this->description(),
            'featuredImage' => $this->featuredImage(),
            'featuredPosts' => $this->featuredPosts(),
            'title' => $this->title(),
        ];
    }

    /**
     * Returns the post excerpt for a post, description for terms and acf based description for archives.
     * @return string
     */
    public function description()
    {
        if (is_archive()) {
            $type = get_queried_object()->name;
            $description = get_field($type . '_description', 'options');

            if ($description) {
                return $description;
            }
        }

        return get_the_excerpt();
    }

    /**
     * Return a featured image.
     * @return mixed
     */
    public function featuredImage()
    {
        return get_field('featured_image', get_queried_object());
    }

    /**
     * Return featured posts.
     * @return array
     */
    public function featuredPosts()
    {
        if (is_archive()) {
            $type = get_queried_object()->name;
            $items = get_field($type . '_featured_posts', 'options');

            if ($items === null) {
                return [];
            }

            return $items;
        }

        if (is_single()) {
            return [get_post()];
        }

        return [];
    }

    /**
     * Returns the post title.
     * @return string
     */
    public function title()
    {
        if ($this->view->name() !== 'partials.page-header') {
            return get_the_title();
        }

        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }

            return __('Latest Posts', 'sage');
        }

        if (is_archive()) {
            return get_the_archive_title();
        }

        if (is_search()) {
            return sprintf(
            /* translators: %s is replaced with the search query */
                __('Search Results for %s', 'sage'),
                get_search_query()
            );
        }

        if (is_404()) {
            return __('Not Found', 'sage');
        }

        return get_the_title();
    }
}
