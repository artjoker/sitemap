<?php


namespace Artjoker\Sitemap\Traits;


trait Sitemap
{
    public function getUrls() : array
    {
        $baseUrl = $this->getBaseUrl();

        $urls = [];

        self::chunk(100, function ($items) use ($baseUrl, &$urls) {
            foreach ($items as $item) {
                $urls[] = $this->makeUrl($baseUrl, $item);
            }
        });

        return $urls;
    }

    public function makeUrl($baseUrl, $item) : string
    {
        return $baseUrl . '/' . $item->{$this->getAlias()};
    }

    public function getAlias()
    {
        return ($this->columnName) ? $this->columnName : 'alias';
    }

    public function getBaseUrl()
    {
        return ($this->baseUrl) ? $this->baseUrl : url('/');
    }
}
