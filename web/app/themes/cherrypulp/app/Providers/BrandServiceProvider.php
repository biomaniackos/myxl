<?php

namespace App\Providers;

use Roots\Acorn\ServiceProvider;
use function Roots\add_actions;

class BrandServiceProvider extends ServiceProvider
{
    /**
     * Add "designed and developed..." to admin footer.
     */
    public function adminFooter()
    {
        ?>
        <style>
            .cp-footer {float: left;line-height: 20px;}
            .cp-footer span {
                animation: pulse 5s linear infinite;
                color: #FE5151;
                display: inline-block;
                font-weight: bold;
            }
            .cp-footer a {color: var(--wp-admin-theme-color);font-weight: bold;text-decoration: none;}
            .cp-footer a:hover, .cp-footer a:focus {color: var(--wp-admin-theme-color);}
            @keyframes pulse {
                0% {color: #FE5151;transform: scale(0.9);}
                20% {color: #eebebd;transform: scale(1);}
                40% {color: #FE5151;transform: scale(0.9);}
                60% {color: #eebebd;transform: scale(1.1);}
                80% {color: #eebebd;transform: scale(0.9);}
                100% {color: #FE5151;transform: scale(0.9);}
            }
        </style>
        <?php
        return '<div class="cp-footer">Made with <span>&#x2764;</span> by <a href="https://www.cherrypulp.com" target="_blank">Cherry Pulp</a></div>';
    }

    // Create custom admin bar menu
    public function createMenu()
    {
        global $wp_admin_bar;
        $wp_admin_bar->add_node([
            'href' => '/',
            'id' => 'cherrypulp',
            'title' => '<span class="cp-icon"><img src="https://www.cherrypulp.com/shared/cherrypulp-icon.png" alt="Cherry Pulp" title="Cherry Pulp" style="display: inline-block; margin-right: 5px; margin-top: -4px; vertical-align: middle;" /></span>',
        ]);
        $wp_admin_bar->add_node([
            'href' => 'https://www.cherrypulp.com/',
            'id' => 'cherrypulp-home',
            'meta' => ['target' => '_blank'],
            'parent' => 'cherrypulp',
            'title' => __('Homepage'),
        ]);
    }

    /**
     * Replace login screen logo
     */
    public function loginLogo()
    {
        ?>
        <style>
            body.login {background: #101aff;}
            body.login #nav a, body.login #backtoblog a {color: #eebebd;}
            body.login #nav a:hover, body.login #backtoblog a:hover {
                color: #eebebd;
                text-decoration: underline;
            }
            body.login div#login h1 a {
                background-image: url(https://www.cherrypulp.com/shared/cherrypulp-logo-color.svg);
                background-repeat: no-repeat;
                background-size: auto;
                width: 300px;
            }
            body.login.wp-core-ui .button-primary {
                background-color: var(--wp-admin-theme-color);
                border-color: var(--wp-admin-theme-color);
            }
        </style>
        <?php
    }

    /**
     * Replace login logo title
     * @return string
     */
    public function loginLogoHeaderText()
    {
        return 'Powered by Cherry Pulp';
    }

    /**
     * Replace login screen logo link
     */
    public function loginLogoUrl($url)
    {
        return 'https://www.cherrypulp.com/';
    }

    /**
     * Replace login screen logo
     */
    public function menuCustomLogo()
    {
        ?>
        <style>
            .components-button.edit-post-fullscreen-mode-close.has-icon {background-color: var(--wp-admin-theme-color);}
            .components-button.edit-post-fullscreen-mode-close.has-icon:focus,
            .components-button.edit-post-fullscreen-mode-close.has-icon:hover {background-color: var(--wp-admin-theme-color-darker-10);}
            .components-button.edit-post-fullscreen-mode-close.has-icon::before {box-shadow: none;}
        </style>
        <?php
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        add_action('admin_bar_menu', [$this, 'createMenu'], 1);
        add_action('admin_bar_menu', [$this, 'removeWPLogo'], 999);
        add_action('login_enqueue_scripts', [$this, 'loginLogo']);
        add_action('wp_before_admin_bar_render', [$this, 'menuCustomLogo']);
        add_actions(['admin_head', 'login_head'], [$this, 'themeCSSVariables'], 1);
        add_filter('admin_footer_text', [$this, 'adminFooter'], 11);
        add_filter('login_headertext', [$this, 'loginLogoHeaderText']);
        add_filter('login_headerurl', [$this, 'loginLogoUrl']);
    }

    /**
     * Remove WordPress admin bar menu
     */
    public function removeWPLogo($wp_admin_bar)
    {
        $wp_admin_bar->remove_node('wp-logo');
    }

    public function themeCSSVariables()
    {
        // @see https://www.color-hex.com/color/101aff
        ?>
        <style>
            :root {
                --wp-admin-theme-color: #101aff;
                --wp-admin-theme-color-darker-10: #0c14cc;
                --wp-admin-theme-color-darker-20: #090f99;
            }
        </style>
        <?php
    }
}
