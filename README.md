<p align="center">
  <a href="https://roots.io/bedrock/">
    <img alt="Bedrock" src="https://cdn.roots.io/app/uploads/logo-bedrock.svg" height="100">
  </a>
</p>

> **A modern WordPress stack** Built with ❤️


## Requirements
- PHP 7.1
- [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos)
- [WP CLI](https://wp-cli.org/fr/#installation)

---

## Installation

1. Download or clone this repository (do not forget to remove `.git` directory).
2. Edit `composer.json` to add/remove plugins.
3. Fill your `.env.example` file with your local development settings.
4. Run `composer install`.
5. Run `composer run-script setup`.

This script will:
- generate salts
- install CherryPulp theme composer dependencies
- install WordPress (via WP CLI)
- activate theme
- open the website in browser


---

## Working on your project

If we inspect the folder structure you can see how Bedrock organizes the files:
```bash
├── config/
│   ├── application.php
│   └── environments/
│       ├── development.php
│       ├── production.php
│       └── staging.php
├── env.sh
├── scripts/
│   └── CherryPulp/
│       └── PostInstall.php
├── vendor/
├── web/
│   ├── app/
│   │   ├── mu-plugins/
│   │   ├── plugins/
│   │   ├── themes/
│   │   └── uploads/
│   ├── wp/
│   └── wp-config.php
```

- `config`: this is where you configure WordPress.
    - `config/application.php`: this file contains the usual WordPress configuration and is intended to include base settings that are common to all environments.
    - `config/environments/*`: these contain environment-specific settings. For example in production it disables errors output.
- `scripts`: this is where custom commands or scripts can be stored.
- `vendor`: dependencies managed by Composer will be installed there, except WordPress plugins and themes; if you inspect the `composer.json` file you’ll see that these kind of packages will be moved in `web/app/{mu-plugins,plugins,themes}/`.
- `web`: files included in this directory are publicly available
    - `web/app`: this is the old wp-content folder.
    - `web/wp`: the whole WordPress package.
    - `web/wp-config.php`: this file is well-known, but in Bedrock it acts as a loader (it loads settings from the config directory).


### Configuration and environment variables

Remember that environment-specific files (`config/environment/*.php`) are required before the main (`config/application.php`). This means that you can’t override settings. Say that you have the same configuration for development and staging but a different one for production. 
You can:

- define it in every environment file (`development.php`, `staging.php`, `production.php`, etc).
- put it in the `.env` file and define it in the main application (`application.php`) file.

```dotenv
# @note - Use "DATABASE_URL" with Gandi (ex. 'mysql://user:password@localhost:3306/db_name')
DB_NAME='database_name'
DB_USER='database_user'
DB_PASSWORD='database_password'

WP_ENV='development'
WP_HOME='http://example.com'
WP_SITEURL="${WP_HOME}/wp"

# Admin (used with WP CLI)
WP_TITLE='A website made with love'
WP_USER='private'
WP_PASSWORD='strong_password'
WP_EMAIL='private@cherrypulp.com'
```


### Plugins

If your plugin is available in the official plugin registry, you can install using Composer and [WordPress Packagist](https://wpackagist.org/), which is a Composer repository that mirrors WordPress’ official plugin and theme registry.

Bedrock already added wpackagist’s repository, so installing a plugin is just a matter of running the following command to install the latest version:

```bash
composer require wpackagist-plugin/<name>
git add composer.json composer.lock
git commit -m 'Install <name> plugin'
```

Plugins are prefixed with `wpackagist-plugin/` so the plugin Memberful WP becomes `wpackagist-plugin/memberful-wp`.

Now we have the plugin in place, we can enable it. Head over the WordPress admin page or once again use [WP-CLI](http://wp-cli.org/):

```bash
wp plugin activate memberful-wp
```
This time we don’t need the `wpackagist-plugin` prefix, as WordPress doesn’t know about Composer.

### Bundled Plugins

#### Must Use (autoloaded)

These plugins are installed via composer inside `web/app/mu-plugins/` and activated by default.

- [ACF Content Analysis for Yoast SEO](https://fr.wordpress.org/plugins/acf-content-analysis-for-yoast-seo/)
- [Admin Columns Pro - Addon Advanced Custom Fields](https://www.admincolumns.com/advanced-custom-fields-integration/)
- [Admin Columns Pro - Addon Yoast SEO](https://www.admincolumns.com/yoast-seo/)
- [Admin Columns Pro](https://docs.admincolumns.com/)
- [Advanced Custom Fields Pro](https://www.advancedcustomfields.com/resources/)
- [Advanced Editor Tools (previously TinyMCE Advanced)](https://wordpress.org/plugins/tinymce-advanced/)
- [Better Search Replace](https://wordpress.org/plugins/better-search-replace/)
- [Classic Editor](https://wordpress.org/plugins/classic-editor/)
- [Disable Comments – Remove Comments & Protect From Spam](https://wordpress.org/plugins/disable-comments/)
- [Duplicate Page](https://wordpress.org/plugins/duplicate-page/)
- [Imsanity](https://wordpress.org/plugins/imsanity/)
- [ManageWP Worker](https://wordpress.org/plugins/worker/)
- [Simple Page Ordering](https://wordpress.org/plugins/simple-page-ordering/)
- [SVG Support](https://wordpress.org/plugins/svg-support/)
- [WP Rocket](https://docs.wp-rocket.me/)
- [WP Term Order](https://wordpress.org/plugins/wp-term-order/)
- [Yoast SEO](https://wordpress.org/plugins/wordpress-seo/)

### Others

These plugins are installed via composer inside `web/app/plugins/` and activated via `wp plugin activate --all`.

- [Admin Columns Pro - Addon Gravity Forms](https://www.admincolumns.com/gravity-forms/)
- [Advanced Custom Fields Multilingual](https://wpml.org/documentation/related-projects/translate-sites-built-with-acf/)
- [CMS Navigation](https://wpml.org/documentation/getting-started-guide/site-navigation/)
- [Gravity Forms Multilingual](https://wpml.org/documentation/related-projects/gravity-forms-multilingual/)
- [Gravity Forms](https://docs.gravityforms.com/)
- [Intervention](https://github.com/soberwp/intervention)
- [Media Translation](https://wpml.org/documentation/getting-started-guide/media-translation/)
- [Sticky Links](https://wpml.org/documentation/getting-started-guide/sticky-links/)
- [String Translation](https://wpml.org/documentation/getting-started-guide/string-translation/)
- [WPML Multilingual CMS](https://wpml.org/documentation/getting-started-guide/)

### Suggestions
- [Gravity Forms CLI](https://wordpress.org/plugins/gravityformscli/)


### Bundled Libraries

- [stoutlogic/acf-builder](https://github.com/StoutLogic/acf-builder)
- [log1x/acf-editor-palette](https://github.com/Log1x/acf-editor-palette)

### Others documentation

- [Blade](https://laravel.com/docs/7.x/blade)
- [WP CLI](https://wp-cli.org/fr/)


## Upgrading Wordpress

You can edit the `composer.json` file and run composer install or you can just issue the following command (where `x.x.x` is the version you need):

```bash
composer require roots/wordpress x.x.x
```

## Upgrading plugins

Upgrading plugins is similar to upgrading WordPress: if you used Composer to install them, use Composer to upgrade them.

You can run `composer require wpackagist-plugin/<name> <version>` to upgrade a given plugin to a specific version or, even better, use composer update to update every package to their latest version that satisfies the constraints set in the `composer.json` file.
