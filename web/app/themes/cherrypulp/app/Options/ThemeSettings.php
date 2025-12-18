<?php

namespace App\Options;

use Log1x\AcfComposer\Options as Field;
use Roots\Acorn\Application;
use StoutLogic\AcfBuilder\FieldsBuilder;
use function App\resize_image;

class ThemeSettings extends Field
{
    /**
     * The option page menu name.
     *
     * @var string
     */
    public $name = 'Theme Settings';

    /**
     * The option page document title.
     *
     * @var string
     */
    public $title = 'Theme Settings';

    /**
     * The option page menu position.
     *
     * @var int
     */
    public $position = 500;

    /**
     * Redirect to the first child page if one exists.
     *
     * @var boolean
     */
    public $redirect = false;

    public function __construct(Application $app)
    {
        parent::__construct($app);

        // @note - WPML need a custom and unique reference for page options.
        if (defined('ICL_LANGUAGE_CODE')) {
            $this->post .= '_' . ICL_LANGUAGE_CODE;
        }

        add_action('admin_menu', [$this, 'addSubmenuPageIframe']);
        // add_action('wp_head', [$this, 'setupFavicon'], 1);
    }

    /**
     * The option page field group.
     *
     * @return array
     */
    public function fields()
    {
        $identity = new FieldsBuilder('identity');
        $identity
            ->addGroup('identity', ['wpml_cf_preferences' => 1])
                ->addImage('logo', [
                    'preview_size' => 'thumbnail',
                    'return_format' => 'id',
                ])
                ->addImage('favicon', [
                    'instructions' => 'Only PNG min. 180x180',
                    'mime_types' => 'png',
                    'preview_size' => 'thumbnail',
                    'return_format' => 'url',
                ])
                ->addWysiwyg('description')
            ->endGroup();

        $menuSocial = new FieldsBuilder('menu_social');
        $menuSocial
            ->addRepeater('social_networks', [
                'layout' => 'block',
                'max' => 10,
                'wpml_cf_preferences' => 1,
            ])
                ->addSelect('network', [
                    'choices' => [
                        'behance',
                        'codepen',
                        'delicious',
                        'deviantart',
                        'digg',
                        'dribbble',
                        'facebook',
                        'flicker',
                        'foursquare',
                        'github',
                        'glide',
                        'google-plus',
                        'instagram',
                        'linkedin',
                        'medium',
                        'meetup',
                        'pinterest',
                        'quora',
                        'skype',
                        'slack',
                        'snapchat',
                        'soundcloud',
                        'spotify',
                        'tiktok',
                        'tripadvisor',
                        'tumblr',
                        'twitter',
                        'viadeo',
                        'vimeo',
                        'vine',
                        'whatsapp',
                        'yelp',
                        'youtube',
                    ],
                    'required' => true,
                ])
                ->addText('title')
                ->addUrl('link', ['required' => true])
            ->endRepeater();

        $themeSettings = new FieldsBuilder('theme_settings');
        $themeSettings
            ->addTab('Identity')
                ->addFields($identity)
            ->addTab('Social')
                ->addFields($menuSocial);

        return $themeSettings->build();
    }

    public function addSubmenuPageIframe()
    {
        // Set second options page
        $parent = acf_add_options_sub_page([
            'page_title' => 'Cherry Pulp',
            'menu_title' => 'Cherry Pulp',
            'parent_slug' => $this->slug,
        ]);

        // Replace options page with the content of our callback
        add_submenu_page(
            $parent['menu_slug'],
            'Cherry Pulp',
            'Cherry Pulp',
            'manage_options',
            $parent['menu_slug'],
            function () {
                echo '<style>#wpcontent {padding-left: 0 !important;} #wpbody-content {padding-bottom: 40px;} #wpbody-content iframe {display: block !important;}</style>';
                echo '<style>iframe[name="cherry-pulp-' . date('YmdHis') . '"] {position: absolute;top: 0;}</style>';
                echo '<script>function fullHeight(element) { element.height = document.body.scrollHeight; }</script>';
                echo '<iframe src="https://www.cherrypulp.com" name="cherry-pulp-' . date('YmdHis') . '" height="100%" width="100%" frameborder="0" onLoad="fullHeight(this);"></iframe>';
            }
        );
    }

    /**
     * Setup our Favicons from theme options.
     */
    public function setupFavicon()
    {
        $identify = get_field('identity', 'option');

        if (!$identify || !$identify['favicon']) {
            return;
        }
        ?>
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo resize_image(
            $identify['favicon'], ['force' => true, 'height' => 180, 'width' => 180]
        ) ?>" />
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo resize_image(
            $identify['favicon'], ['force' => true, 'height' => 32, 'width' => 32]
        ) ?>" />
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo resize_image(
            $identify['favicon'], ['force' => true, 'height' => 16, 'width' => 16]
        ) ?>" />
        <?php
    }
}
