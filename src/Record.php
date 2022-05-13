<?php

namespace Intelliants\LaravelSitemap;

class Record
{
    protected $url;
    protected $priority;
    protected $lastModified;


    public static function factory(string $url, string $lastModified = null, float $priority = null): self
    {
        return new self($url, $lastModified, $priority);
    }


    public function __construct(string $url = null, string $lastModified = null, float $priority = null)
    {
        $this->setUrl($url);
        $this->setLastModified($lastModified);
        $this->setPriority($priority);
    }


    public function setUrl(?string $url, string $locale = null): void
    {
        if (is_null($locale)) {
            $this->url = $url;
            return;
        }

        if (is_string($this->url)) {
            $this->url = [];
        }

        $this->url[$locale] = $url;
    }

    public function getUrl(string $locale = null): ?string
    {
        /*if (is_string($this->url)) {
            return LaravelLocalization::localizeUrl($this->url, $locale);
        }*/

        if ($locale && isset($this->url[$locale])) {
            return $this->url[$locale];
        }

        return collect($this->url)->filter()->first();
    }

    public function setPriority(?float $priority): void
    {
        if (!is_null($priority)) {
            $this->priority = $priority;
        }
    }

    public function getPriority(): ?string
    {
        return isset($this->priority) ? number_format($this->priority, 1, '.') : null;
    }

    public function setLastModified(?string $lastModified): void
    {
        if (!is_null($lastModified)) {
            $this->lastModified = strtotime($lastModified);
        }
    }

    public function getLastModified(): ?string
    {
        return isset($this->lastModified) ? date('Y-m-d', $this->lastModified) : null;
    }
}
