# Laravel SiteMap

It's a package for Laravel that implements site map functionality.

## Installing

```
composer require artjoker/sitemap
```

After updating composer, add the service provider to the providers array in `config/app.php`

```
Artjoker\Sitemap\Providers\SiteMapServiceProvider::class
```

Publish migrations and css-styles:

```
php artisan vendor:publish --tag=sitemap-migrations
php artisan vendor:publish --tag=sitemap-styles
```

## Optional Features

```
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
         * Command to generate SiteMap
         */
        'sitemap_generate_command' => 'sitemap:generate',

        /**
         * Jobs priority
         */
        'jobs_priority' => 'default',
```

## How to use?

```
<?php

class Pages extends Model
{
    use Sitemap;
}
```

You can specify column name and base Url. Just add parameter to your model:

```
    public $columnName = 'alias';

    public $baseUrl = null;
```

Or override the methods:

```
    public function getUrls() : array
    {
        return $urls;
    }

    public function makeUrl($baseUrl, $item) : string
    {
        return $url
    }
```

To upload URLs to the database you can use the interface button by the link: {yourAppUrl}/backend/sitemap
or use command:

```
    php artisan sitemap:load:urls 
```

When you need to rewrite the URLs of a specific model, you can use the option --model=App/Models/Pages

```
    php artisan sitemap:load:urls --model=App/Models/Pages
```

To create a sitemap, use the command:

```
    php artisan sitemap:generate
```

Or you can use the interface button.

## What we can publish?

```
php artisan vendor:publish --tag=sitemap-config
php artisan vendor:publish --tag=sitemap-lang
php artisan vendor:publish --tag=sitemap-migrations
php artisan vendor:publish --tag=sitemap-styles
php artisan vendor:publish --tag=sitemap-views
```

### Instructions

Other configuration instructions are in the configuration file.
