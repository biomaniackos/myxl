<?php

/**
 * Theme filters.
 */

namespace App;

use Illuminate\Support\Str;
use function Roots\asset;

/**
 * Remove accents from upload files.
 */
add_filter('sanitize_file_name', 'remove_accents');


/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

// Adds preloading to web font files in the Sage manifest.
// @see https://developer.mozilla.org/en-US/docs/Web/HTML/Link_types/preload
add_filter('wp_head', function () {
    echo collect(
        json_decode(asset('mix-manifest.json')->contents())
    )->keys()->filter(function ($item) {
        return Str::endsWith($item, ['.otf', '.eot', '.woff', '.woff2', '.ttf']);
    })->map(function ($item) {
        // Return asset uri without versioning query string
        return sprintf(
            '<link rel="preload" href="%s" as="font" crossorigin>',
            substr(asset($item)->uri(), 0, strpos(asset($item)->uri(), '?id='))
        );
    })->implode("\n");
});
