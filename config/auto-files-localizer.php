<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Translation Path
    |--------------------------------------------------------------------------
    |
    | This option defines the directory where the translated files will be saved.
    | By default, it uses the 'resources/lang' directory of your Laravel app.
    |
    */
    'path' => default_languages_path(),

    /*
    |--------------------------------------------------------------------------
    | Extraction mode options
    |--------------------------------------------------------------------------
    |
    | 1- directories:
    |   This option determines what directories the translation scanner should scan.
    |
    | 2- patterns:
    |   This option determines what pattern of files the translation scanner should scan.
    |
    | 3- functions:
    |   This option determines functions or blade directives that the strings will be extracted from.
    |   You should add any custom defined functions or directives used for translation here.
    |
    */
    'extraction' => [
        'directories' => [
            'resources/views',
        ],
        'patterns' => [
            '*.php'
        ],
        'functions' => [
            '__',
            'trans',
            '@lang',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dynamic mode options
    |--------------------------------------------------------------------------
    |
    | 1- enabled (Auto Localizer Enabled):
    |   This option determines whether the auto localizer functionality is enabled.
    |   When set to true, the package will save translations automatically.
    |
    | 2- production (Production Mode):
    |   This option controls whether the auto localizer functionality is active in
    |   the production environment. If set to true, the functionality will work
    |   in all environments, including production.
    |
    */
    'dynamic' => [
        'enabled' => (bool) env('AUTO_LOCALIZER_ENABLED', false),
        'production' => false,
    ],
];
