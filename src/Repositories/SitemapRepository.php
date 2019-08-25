<?php

namespace Artjoker\Sitemap\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Artjoker\Sitemap\Models\Sitemap;
use Illuminate\Http\Request;

class SitemapRepository
{
    protected $request;
    public $pages = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->pages = config('sitemap.static_routes');
    }

    public function store(Sitemap $sitemap)
    {
        $sitemap->alias = $this->request->alias;
        $sitemap->lastmod = Carbon::parse($this->request->lastmod);
        $sitemap->priority = $this->request->priority;
        $sitemap->changefreq = $this->request->changefreq;
        $sitemap->is_active = isset($this->request->is_active);
        $sitemap->order = (isset($this->request->order)) ? $this->request->order : Sitemap::all()->count() + 1;
        $sitemap->save();

        return $sitemap;
    }

    /**
     * Return all values related to given model in alphabetical order
     *
     * @param $model
     *
     * @return array
     */
    public function getEntities($model)
    {
        $result = [];
        $model::onlyActive()
            ->wherehas('translations', function ($query) {
                return $query
                    ->where('name', 'like', '%' . request('search') . '%')
                    ->orderBy('name');
            })
            ->get()
            ->sortBy(function ($item) {
                return $item->name;
            })
            ->map(function ($item) use (&$result) {
                $result[$item->id] = $item->name;
            });

        return $result;
    }
}
