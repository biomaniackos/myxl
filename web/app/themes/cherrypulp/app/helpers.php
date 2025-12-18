<?php
namespace App;

/**
 * Theme helpers.
 */

/**
 * Add an AJAX endpoint.
 *
 * @param        $name
 * @param        $callback
 * @param string $logged
 *
 *@example
 *     add_ajax('something', function ($params) {
 *         return wp_send_json(['message' => 'ok!']);
 *     });
 */
function add_ajax($name, $callback, string $logged = 'both')
{
    $callback = function () use ($callback, $name) {
        if (empty($_POST) || !wp_verify_nonce($_POST['__wpnonce'], '__wpnonce')) {
            wp_send_json([
                'success' => false,
                'message' => 'Security check failed (' . $name . ').',
            ], 400);
        }

        $params = array_merge([], $_POST);
        // remove unnecessary variables
        $params = array_diff($params, ['__wpnonce', 'action']);

        if (is_callable($callback)) {
            return $callback($params);
        }

        wp_send_json([
            'success' => true,
            'data' => null,
        ]);
    };

    if ($logged === false || $logged === 'no' || $logged === 'both') {
        add_action('wp_ajax_nopriv_' . $name, $callback);
    }

    if ($logged === true || $logged === 'yes' || $logged === 'both') {
        add_action('wp_ajax_' . $name, $callback);
    }
}

/**
 * Display a notice in admin.
 * @param        $message
 * @param string $type
 * @see https://developer.wordpress.org/reference/hooks/admin_notices/
 */
function admin_notice($message, $type = 'info')
{
    $notice = '<div class="notice notice-' . esc_attr($type) . '">' . $message . '</div>';
    add_action('admin_notice', function () use ($notice) {
        echo $notice;
    });
}

/**
 * @param        $attachmentId
 * @param string $size
 * @param array  $defaults
 *
 * @return array
 */
function get_image($attachmentId, $size = 'thumbnail', $defaults = [])
{
    $defaults = array_merge([
        'alt' => null,
        'title' => null,
        'url' => null,
    ], $defaults);

    $image = [
        'alt' => get_post_meta($attachmentId, '_wp_attachment_image_alt', true),
        'link' => variadic(wp_get_attachment_image_src($attachmentId, 'big')),
        'title' => get_the_title($attachmentId),
        'url' => wp_make_link_relative(variadic(wp_get_attachment_image_src($attachmentId, $size))),
    ];

    if (!$image['alt']) {
        $image['alt'] = $defaults['alt'] ?? $image['title'] ?? $defaults['title'];
    }

    if (!$image['link']) {
        $image['link'] = $defaults['link'];
    }

    if (!$image['title']) {
        $image['title'] = $defaults['title'];
    }

    if (!$image['url']) {
        $image['url'] = $defaults['url'];
    }

    return $image;
}

function build_tree_recursively(array &$nav, $parentId = 0)
{
    $branch = [];

    foreach ($nav as &$navItem) {
        if ($navItem->menu_item_parent == $parentId && $navItem instanceof \WP_Post) {
            $children = build_tree_recursively($nav, $navItem->ID);

            if ($children) {
                $navItem->children = $children;
            }

            // @note - add acf eventually
            $navItem->fields = get_fields($navItem);

            $branch[$navItem->menu_order] = $navItem;
            unset($navItem);
        }
    }

    return $branch;
}

/**
 * Return nav items for a given navigation name.
 * @param      $menu_name
 * @param bool $outputTree If true, output as hierarchical tree.
 *
 * @return array
 */
function get_navigation_items($menu_name, $outputTree = true)
{
    $locations = get_nav_menu_locations();
    $items = wp_get_nav_menu_items($locations[$menu_name]);

    if ($outputTree) {
        return build_tree_recursively($items);
    }

    return $items;
}

/**
 * Retrieve an image to represent an url on the fly
 * @param       $url Path to the image
 * @param array $args
 *     width  => Optional, Width of image result, Use on default the settings values
 *     height => Optional, Height of image
 *     crop   => Optional, Whether to crop image or resize. | default is FALSE
 *     retina => Optional boolean for creating images that are double the width and height. | default is FALSE
 *     single => Optional, true for single url on return $image, false for Array | default is TRUE
 *
 * @return array|false|string|\WP_Error Array with url, width, height
 */
function resize_image($url, $args = [])
{
    if (strpos($url, home_url()) === false) {
        return new \WP_Error('wrong_url', __('Image is not on the home url.'), $url);
    }

    if (empty($url['height']) === false) {
        return new \WP_Error('no_height', __('Height is not specified.'), $url);
    }

    $defaults = [
        'crop' => null,
        'force' => false,
        'height' => null,
        'retina' => false,
        'single' => true,
        'url' => $url,
        'width' => false,
    ];

    $args = wp_parse_args($args, apply_filters('resize_image_args', $defaults));

    // Allow for different retina sizes
    $args['retina'] = $args['retina'] ? ($args['retina'] === true ? 2 : $args['retina']) : 1;

    // validate inputs, set to integer
    $args['width']  = (int) ($args['width'] * $args['retina']);
    $args['height'] = (int) ($args['height'] * $args['retina']);

    // set var for original image
    $original = [
        'width' => null,
        'height' => null,
    ];

    // set var for the noun, the result of new image
    $noun = [
        'width' => null,
        'height' => null,
        'url' => null,
        'file' => null,
        'path' => null,
    ];

    /**
     * define upload path & dir
     *
     * wp_upload_dir -- On success, the returned array will have many indices:
     * 'path'    - base directory and sub directory or full path to upload directory.
     * 'url'     - base url and sub directory or absolute URL to upload directory.
     * 'subdir'  - sub directory if uploads use year/month folders option is on.
     * 'basedir' - path without subdir.
     * 'baseurl' - URL path without subdir.
     * 'error'   - set to false.
     */
    $upload_info = wp_upload_dir();
    $upload_dir = $upload_info['basedir'];
    $upload_url = $upload_info['baseurl'];

    // define path of image
    $rel_path = str_replace($upload_url, '', $args['url']);
    $img_path = $upload_dir . $rel_path;

    // check if img path exists, and is an image indeed
    if (!file_exists($img_path) || !getimagesize($img_path)) {
        return false;
    }

    // get image info
    $info = pathinfo($img_path);
    $ext  = $info['extension'];
    [$original['width'], $original['height']] = getimagesize($img_path);

    // get image size after cropping
    $dimensions = image_resize_dimensions(
        $original['width'],
        $original['height'],
        $args['width'],
        $args['height'],
        $args['crop']
    );
    $noun['weight'] = $dimensions[4] ?? $args['width'];
    $noun['height'] = $dimensions[5] ?? $args['height'];

    // use this to check if cropped image already exists, so we can return that instead
    $suffix = "{$noun['weight']}x{$noun['height']}";
    $noun['path'] = str_replace('.' . $ext, '', $rel_path);
    $noun['file'] = "{$upload_dir}{$noun['path']}-{$suffix}.{$ext}";

    // if orig size is smaller
    if ($args['width'] >= $original['width'] && !$args['force']) {
        // can't resize, so return original url
        $noun['url'] = $args['url'];
        $noun['weight'] = $original['width'];
        $noun['height'] = $original['height'];
    } else {
        //else check if cache exists
        if (!file_exists($noun['file']) || !getimagesize($noun['file'])) {
            // else resize and return the new resized image url
            $image = wp_get_image_editor($img_path);

            if (!is_wp_error($image)) {
                $image->resize($args['width'], $args['height'], $args['crop']);
                $image->save($noun['file']);
            }
        }

        $noun['url'] = "{$upload_url}{$noun['path']}-{$suffix}.{$ext}";
    }

    // return the output
    if ($args['single']) {
        //str return
        $image = $noun['url'];
    } else {
        //array return
        $image = [
            $noun['url'],
            $noun['weight'],
            $noun['height'],
        ];
    }

    return $image;
}

/**
 * @param $value
 *
 * @return mixed
 */
function variadic($value)
{
    if (is_array($value)) {
        return $value[0];
    }

    return $value;
}
