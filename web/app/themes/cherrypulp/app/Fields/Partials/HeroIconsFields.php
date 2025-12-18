<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class HeroIconsFields extends Partial
{
    /**
     * The default icon name.
     * @var string|null (default: null)
     */
    public $defaultIcon = null;

    /**
     * The default icon type.
     * @var string|null (default: null)
     */
    public $defaultIconType = null;

    /**
     * List of all available icon names.
     * @var string[]
     */
    public static $icons = [
        'academic-cap',
        'adjustments',
        'annotation',
        'archive',
        'arrow-circle-down',
        'arrow-circle-left',
        'arrow-circle-right',
        'arrow-circle-up',
        'arrow-down',
        'arrow-left',
        'arrow-narrow-down',
        'arrow-narrow-left',
        'arrow-narrow-right',
        'arrow-narrow-up',
        'arrow-right',
        'arrow-sm-down',
        'arrow-sm-left',
        'arrow-sm-right',
        'arrow-sm-up',
        'arrow-up',
        'arrows-expand',
        'at-symbol',
        'backspace',
        'badge-check',
        'ban',
        'beaker',
        'bell',
        'book-open',
        'bookmark-alt',
        'bookmark',
        'briefcase',
        'cake',
        'calculator',
        'calendar',
        'camera',
        'cash',
        'chart-bar',
        'chart-pie',
        'chart-square-bar',
        'chat-alt-2',
        'chat-alt',
        'chat',
        'check-circle',
        'check',
        'chevron-double-down',
        'chevron-double-left',
        'chevron-double-right',
        'chevron-double-up',
        'chevron-down',
        'chevron-left',
        'chevron-right',
        'chevron-up',
        'chip',
        'clipboard-check',
        'clipboard-copy',
        'clipboard-list',
        'clipboard',
        'clock',
        'cloud-download',
        'cloud-upload',
        'cloud',
        'code',
        'cog',
        'collection',
        'color-swatch',
        'credit-card',
        'cube-transparent',
        'cube',
        'currency-bangladeshi',
        'currency-dollar',
        'currency-euro',
        'currency-pound',
        'currency-rupee',
        'currency-yen',
        'cursor-click',
        'database',
        'desktop-computer',
        'device-mobile',
        'device-tablet',
        'document-add',
        'document-download',
        'document-duplicate',
        'document-remove',
        'document-report',
        'document-search',
        'document-text',
        'document',
        'dots-circle-horizontal',
        'dots-horizontal',
        'dots-vertical',
        'download',
        'duplicate',
        'emoji-happy',
        'emoji-sad',
        'exclamation-circle',
        'exclamation',
        'external-link',
        'eye-off',
        'eye',
        'fast-forward',
        'film',
        'filter',
        'finger-print',
        'fire',
        'flag',
        'folder-add',
        'folder-download',
        'folder-open',
        'folder-remove',
        'folder',
        'gift',
        'globe-alt',
        'globe',
        'hand',
        'hashtag',
        'heart',
        'home',
        'identification',
        'inbox-in',
        'inbox',
        'information-circle',
        'key',
        'library',
        'light-bulb',
        'lightning-bolt',
        'link',
        'location-marker',
        'lock-closed',
        'lock-open',
        'login',
        'logout',
        'mail-open',
        'mail',
        'map',
        'menu-alt-1',
        'menu-alt-2',
        'menu-alt-3',
        'menu-alt-4',
        'menu',
        'microphone',
        'minus-circle',
        'minus-sm',
        'minus',
        'moon',
        'music-note',
        'newspaper',
        'office-building',
        'paper-airplane',
        'paper-clip',
        'pause',
        'pencil-alt',
        'pencil',
        'phone-incoming',
        'phone-missed-call',
        'phone-outgoing',
        'phone',
        'photograph',
        'play',
        'plus-circle',
        'plus-sm',
        'plus',
        'presentation-chart-bar',
        'presentation-chart-line',
        'printer',
        'puzzle',
        'qrcode',
        'question-mark-circle',
        'receipt-refund',
        'receipt-tax',
        'refresh',
        'reply',
        'rewind',
        'rss',
        'save-as',
        'save',
        'scale',
        'scissors',
        'search-circle',
        'search',
        'selector',
        'server',
        'share',
        'shield-check',
        'shield-exclamation',
        'shopping-bag',
        'shopping-cart',
        'sort-ascending',
        'sort-descending',
        'sparkles',
        'speakerphone',
        'star',
        'status-offline',
        'status-online',
        'stop',
        'sun',
        'support',
        'switch-horizontal',
        'switch-vertical',
        'table',
        'tag',
        'template',
        'terminal',
        'thumb-down',
        'thumb-up',
        'ticket',
        'translate',
        'trash',
        'trending-down',
        'trending-up',
        'truck',
        'upload',
        'user-add',
        'user-circle',
        'user-group',
        'user-remove',
        'user',
        'users',
        'variable',
        'video-camera',
        'view-boards',
        'view-grid-add',
        'view-grid',
        'view-list',
        'volume-off',
        'volume-up',
        'wifi',
        'x-circle',
        'x',
        'zoom-in',
        'zoom-out',
    ];

    /**
     * List of available icon styles.
     * @var string[]
     */
    public static $types = [
        'solid',
        'outline',
    ];

    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $heroIconsFields = new FieldsBuilder('hero_icons_fields');
        $heroIconsFields
            ->addSelect('icon', [
                'choices' => self::$icons,
                'default_value' => $this->defaultIcon ?? self::$icons[0],
                'instructions' => 'See <a href="https://heroicons.com/" target="_blank">heroicons.com</a>',
                'ui' => 1,
            ])
            ->addSelect('icon_type', [
                'choices' => self::$types,
                'default_value' => self::$types[0],
                'ui' => 1,
            ]);

        return $heroIconsFields;
    }

    /**
     * Return the classname to be used with icomoon generated font.
     *
     * @param string $name
     * @param string $type (default: 'solid')
     *
     * @return string
     */
    public static function getFontClassName(string $name, string $type = 'solid')
    {
        return 'icon-' . $name . ($type === 'solid' ? '' : '-outline');
    }

    /**
     * Return the SVG from raw.githubusercontent.com.
     *
     * @param string $name
     * @param string $type
     * @param string $color
     * @return string|null
     */
    public static function getSvg(string $name, string $type = 'solid', string $color = 'white')
    {
        $icon = file_get_contents('https://raw.githubusercontent.com/tailwindlabs/heroicons/master/src/' . $type . '/' . $name . '.svg');

        if ($icon) {
            return str_replace(['currentColor', 'fill="#4A5568"', 'fill="#374151"'], [$color, 'fill="' . $color . '"', 'fill="' . $color . '"'], $icon);
            //return 'data:image/svg+xml;base64,' . base64_encode($icon);
        }

        return null;
    }

    /**
     * Set default icon name. Chainable.
     *
     * @param string $name
     * @return $this
     */
    public function withDefaultIcon(string $name)
    {
        $this->defaultIcon = $name;
        return $this;
    }

    /**
     * Set default icon type. Chainable.
     *
     * @param string $type
     * @return $this
     */
    public function withDefaultIconType(string $type)
    {
        $this->defaultIconType = $type;
        return $this;
    }
}
