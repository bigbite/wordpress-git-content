<?php


return [

    /**
     * The Herbert version constraint.
     */
    'constraint' => '~0.9.13',

    /**
     * Auto-load all required files.
     */
    'requires' => [
        __DIR__ . '/app/metaboxes.php',
        __DIR__ . '/app/filters.php'
    ],

    /**
     * Activate
     */
    'activators' => [
        __DIR__ . '/app/activate.php'
    ],

    /**
     * The panels to auto-load.
     */
    'panels' => [
        'GitContent' => __DIR__ . '/app/panels.php'
    ],

    /**
     * The view paths to register.
     *
     * E.G: 'GitContent' => __DIR__ . '/views'
     * can be referenced via @GitContent/
     * when rendering a view in twig.
     */
    'views' => [
        'GitContent' => __DIR__ . '/resources/views'
    ],

    /**
     * The view globals.
     */
    'viewGlobals' => [

    ],

    /**
     * The asset path.
     */
    'assets' => '/resources/assets/'

];
