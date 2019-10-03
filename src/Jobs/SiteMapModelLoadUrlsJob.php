<?php

namespace Artjoker\Sitemap\Jobs;

use Artjoker\Sitemap\Models\Sitemap;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Artisan;

class SiteMapModelLoadUrlsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $modelName;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($modelName)
    {
        self::onQueue(config('sitemap.jobs_priority', 'default'));

        $this->modelName = $modelName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $currentCount = Sitemap::count();

        $this->modelName::sitemap()->chunk(config('sitemap.model_load_job_chunk', 100), function ($items) use (&$currentCount) {
            foreach ($items as $item) {
                if (method_exists($item, 'getUrl')) {
                    $modelUrls = $item->getUrl();
                    $currentCount++;
                    Sitemap::updateOrCreate(['alias' => $modelUrls, 'model' => $this->modelName, 'order' => $currentCount, 'is_loaded' => 1]);
                }
            }
        });
    }
}
