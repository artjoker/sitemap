<?php


namespace Artjoker\Sitemap\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Sitemap extends Model
{
    public $timestamps = false;
    protected $table = 'sitemap';
    protected $fillable = ['alias', 'priority', 'lastmod', 'model', 'changefreq', 'is_active', 'is_loaded', 'order'];

    public static $changefreq = [
        'always',
        'hourly',
        'daily',
        'weekly',
        'monthly',
        'yearly',
        'never',
    ];

    public function scopeOnlyActive($query)
    {
        return $query->whereIsActive(true);
    }

    public function getChangefreqAttribute($value)
    {
        if (is_null($value)) {
            return Arr::first(self::$changefreq);
        }
        return in_array($value, self::$changefreq) ? $value : reset(self::$changefreq);
    }

}
