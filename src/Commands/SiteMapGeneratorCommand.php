<?php

namespace Artjoker\Sitemap\Commands;

use App;
use Artjoker\Sitemap\Models\Sitemap;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Storage;

class SiteMapGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap.xml file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Throwable
     */
    public function handle()
    {
        $pages = Sitemap::select(['alias', 'lastmod', 'priority', 'changefreq'])->onlyActive();

        $sitemap = '';
        $currentCount = 0;
        $siteMapsCount = 0;
        $pagesCount = $pages->count();
        $bar = $this->output->createProgressBar($pagesCount);
        $separateSiteMap = false;
        $sitemapCounter = (config('sitemap.enable_locales') && count(config('sitemap.locales')) > 0) ?  count(config('sitemap.locales')) : 1;

        if ($pagesCount > config('sitemap.sitemap_count')) {
            $separateSiteMap = true;
            $separatedSiteMap = '';
        }

        $bar->start();
        $pages->chunk(100, function ($pages) use ($bar, &$sitemap, &$currentCount, &$separatedSiteMap, &$siteMapsCount, $sitemapCounter) {
            foreach ($pages as $page) {
                $page = $page->toArray();
                $sitemap = $this->_getLinkXml($page, $sitemap);
                $currentCount += $sitemapCounter;

                if ($currentCount >= config('sitemap.sitemap_count')) {
                    $fileName = 'sitemap' . ($siteMapsCount + 1) . '.xml';

                    Storage::disk(config('sitemap.filesystem_driver', 'public'))
                        ->put($fileName, '<?xml version="1.0" encoding="UTF-8"?>'.
                            view('sitemap::sitemap', [
                                'sitemap' => $sitemap,
                                'locale' => config('app.locale'),
                            ])->render());

                    $separatedSiteMap .= view('sitemap::sitemap_section', [
                        'sitemapUrl' => url('/') . '/' . $fileName,
                        'lastMod' => Carbon::now()->toDateTimeString(),
                    ])->render();
                    $sitemap = '';
                    $siteMapsCount++;
                }

                $bar->advance();
            }
        });

        if ($separateSiteMap) {
            $sitemap = $separatedSiteMap;
        }

        $bar->finish();
        $this->info("\n");
        Storage::disk(config('sitemap.filesystem_driver', 'public'))
            ->put('sitemap.xml', '<?xml version="1.0" encoding="UTF-8"?>'.
                view('sitemap::sitemap', [
                    'sitemap' => $sitemap,
                    'locale' => config('app.locale'),
                ])->render());

    }

    private function _getLinkXml($page, $sitemap)
    {
        if (config('sitemap.enable_locales') && count(config('sitemap.locales')) > 0) {
            foreach (config('sitemap.locales') as $lang) {
                $data = [
                    'alias' => (config('sitemap.hide_default_locale') && config('app.locale') == $lang) ? $page['alias'] : str_replace(url('/'), url('/') . '/' . $lang, $page['alias']),
                    'lastmod' => $page['lastmod'],
                    'priority' => $page['priority'],
                    'changefreq' => $page['changefreq'],
                ];
                $sitemap .= view('sitemap::url', $data)->render();
            }
        } else {
            $sitemap .= view('sitemap::url', $page)->render();
        }

        return $sitemap;
    }
}
