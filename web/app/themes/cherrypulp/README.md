<p align="center">
  <a href="https://roots.io/sage/">
    <img alt="Sage" src="https://cdn.roots.io/app/uploads/logo-sage.svg" height="100">
  </a>
</p>

> **WordPress starter theme with a modern development workflow** Built with ❤️

## Requirements
- PHP 8.3
- [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos)
- [Yarn](https://yarnpkg.com/)
- [WP CLI](https://wp-cli.org/fr/#installation)

---

## Installation

1. Download or clone this repository (do not forget to remove `.git` directory).

2. Then install dependencies :

    ```bash
    composer install
    nvm use && yarn && yarn start
    ```

---

## Working on your project

If we inspect the folder structure you can see how Sage organizes the files:
```bash
├── app/
│   ├── Blocks/
│   ├── Console/
│   ├── Fields/
│   │   └── Partials/
│   ├── Options/
│   ├── PostTypes/
│   ├── Providers/
│   ├── Taxonomies/
│   ├── View/
│   │   ├── Components/
│   │   └── Composers/
│   ├── admin.php
│   ├── filters.php
│   ├── helpers.php
│   └── setup.php
├── bootstrap/
├── config/
│   └── app.php
├── public/
├── resources/
│   ├── fonts/
│   ├── images/
│   ├── scripts/
│   ├── styles/
│   └── views/
├── storage/
├── vendor/
```

- `app`: this is where all the business logic should be located.
    - `app/Blocks`: your Gutenberg Block definitions.
    - `app/Console`: you can create console command here.
    - `app/Fields`: your ACF Group definitions (an alternative to the declarations inside Blocks, Providers, etc).
    - `app/Fields/Partials`: these ACF Group definitions will not be automatically loaded.
    - `app/Options`: your options page definitions.
    - `app/PostTypes`: your custom post types definitions.
    - `app/Providers`: bootstrap anything you need via custom Service Providers.
    - `app/Taxonomies`: your custom taxonomies definitions.
    - `app/View/Components`: your components definitions.
    - `app/View/Composers`: your composers definitions.
- `config`: this is where third party config files will be located.
    - `config/app.php`: this is where you can add `providers`, `aliases`, etc. 
- `public`: these are public and generated from `resources`.
- `resources`: 
    - `resources/fonts`: this is where you put all your local fonts (will be copied inside public directory).
    - `resources/images`: this is where you put all your static images (will be copied inside public directory).
    - `resources/scripts`: this is where you put JavaScript (will be compiled inside public directory).
    - `resources/styles`: this is where you put CSS (will be compiled inside public directory).
    - `resources/views`: this is where you put template (using [Blade](https://laravel.com/docs/7.x/blade))
- `storage`: cache and logs are located here.
- `vendor`: dependencies managed by Composer will be installed there.


## Bundled Libraries

- [stoutlogic/acf-builder](https://github.com/StoutLogic/acf-builder/wiki)
- [log1x/acf-composer](https://github.com/Log1x/acf-composer)
- [log1x/sage-directives](https://log1x.github.io/sage-directives-docs/)

### Wordpress documentation

- [Dashicons](https://developer.wordpress.org/resource/dashicons/)
- [Heroicons](https://heroicons.com/)
- [Codex Plugin API/Action Reference](https://codex.wordpress.org/Plugin_API/Action_Reference)
- [Codex Plugin API/Filter Reference](https://codex.wordpress.org/Plugin_API/Filter_Reference)

### Others documentation

[Sage](https://roots.io/sage/) use [Laravel](https://laravel.com/docs/7.x/) under the hood, so you have plenty of cool things that you can use.

- [Laravel Blade](https://laravel.com/docs/7.x/blade)
- [Laravel Collection](https://laravel.com/docs/7.x/collections)

---

## Use cases

### Create a new page template

See [Creating Custom Page Templates for Global Use](https://developer.wordpress.org/themes/template-files-section/page-template-files/#creating-custom-page-templates-for-global-use) for more information.

> Note: "custom" is used below as the name of the template, do not forget to use your own.

1. Create a new file inside `resources/views` named `template-custom.blade.php`
2. On top of it, add the comment below:
    ```php
    {{--
    Template Name: Custom Template
    --}}
    ```
3. Create a new `TemplateCustomFields` class inside `app/Fields` via 
    ```bash
    wp acorn acf:fields TemplateNameFields
    ```
    Alternatively, you can put your ACF declarations inside the ThemeServiceProvider.


### Create a new component

See [Laravel Blade Components](https://laravel.com/docs/7.x/blade#components) for more information.

> Note: "CustomComponent" is used below as the name of the component, do not forget to use your own.

1. Create a new `CustomComponent` class inside `app/View/Component` via
    ```bash
    wp acorn make:component CustomComponent
    ```
   This will create 2 files : `app/View/Components/CustomComponent.php` and `resources/views/components/custom-component.blade.php`
2. Use it inside your template via 
    ```php
    <x-custom-component />
    ```
   and start your integration! ;-)

Component should be agnostic and not using Wordpress specific methods or objects.


### Create a new Gutenberg block

> Note: "CustomBlock" is used below as the name of the block (as "custom-block"), do not forget to use your own.

1. Create a new `CustomBlock` class inside `app/Blocks` via
    ````bash
    wp acorn acf:block CustomBlock
    ````
   This will create 2 files : `app/View/Blocks/CustomBlock.php` and `resources/views/block/custom-block.blade.php`
2. Add the block inside a page or post via the editor and start your integration! ;-)
