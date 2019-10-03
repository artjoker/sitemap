<?php


namespace Artjoker\Sitemap\Traits;


trait Sitemap
{
    public function scopeSitemap($query)
    {
        return $query;
    }

    public function getUrl() : string
    {
        return $this->getBaseUrl() . '/' . $this->{$this->getAlias()};
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
