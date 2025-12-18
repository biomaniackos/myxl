<?php
// @see https://github.com/soberwp/intervention

return [
    //'application' => [],
    'wp-admin.all' => [],
    'wp-admin.all-not-administrator' => [
        'appearance.customize' => 'dashboard',
        'appearance.theme-editor' => 'dashboard',
        'appearance.themes' => 'dashboard',
        'plugins.plugin-editor' => 'plugins',
        'tools.export' => 'dashboard',
        'tools.import' => 'dashboard',
    ],
    'wp-admin.administrator' => [],
    'wp-admin.editor' => [],
];
