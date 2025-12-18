<?php
/**
 * Configuration overrides for WP_ENV === 'development'
 */

use Roots\WPConfig\Config;
use function Env\env;

Config::define('SAVEQUERIES', true);
Config::define('WP_DEBUG', true);
Config::define('WP_DEBUG_DISPLAY', true);
Config::define('WP_DEBUG_LOG', env('WP_DEBUG_LOG') ?? true);
Config::define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
Config::define('SCRIPT_DEBUG', true);
Config::define('DISALLOW_INDEXING', true);

ini_set('display_errors', '1');

// Enable plugin and theme updates and installation from the admin
Config::define('DISALLOW_FILE_MODS', false);

/**
 * WPML configuration
 * @note Disable plugin from printing styles and js we are going to handle all that ourselves.
 */
Config::define('ICL_DONT_LOAD_NAVIGATION_CSS', true);
Config::define('ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true);
Config::define('ICL_DONT_LOAD_LANGUAGES_JS', true);
