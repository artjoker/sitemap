<?php
    return [
        /**
         * prefix to configurate url to sitemap
         */
        'route_prefix' => env('BACKEND_URL', 'backend'),

        /**
         * config for route prefix
         */
        'route_as' => 'backend.',

        /**
         * driver for sitemap.xml
         */
        'filesystem_driver' => 'public',

        /**
         * routes middleware
         */
        'route_middleware' => ['web'],

        /**
         * to use feature your model have to use trait Sitemap
         * or release method getUrls where you return array with prepared URL's for siteMap
         */
        'dynamic_url_classes' => [

        ],

        // Route names for siteMap
        'static_routes' => [

        ],

        /**
         * enable multi-language urls
         */
        'enable_locales' => false,

        /**
         * Hide default locale in url from app.locale config
         */
        'hide_default_locale' => false,

        /**
         * locales to multi-language urls
         */
        'locales' => [
            'en',
        ],

        /**
         * how many pages will be in one file
         */
        'sitemap_count' => 40000,

        /**
         * How many items to take at a time when loading urls in the database
         */
        'model_load_job_chunk' => 100,

        /**
         * Command to generate SiteMap
         */
        'sitemap_generate_command' => 'sitemap:generate',

        /**
         * Jobs priority
         */
        'jobs_priority' => 'default',
    ];
