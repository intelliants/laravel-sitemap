<?php

namespace Intelliants\LaravelSitemap\Traits;

use Intelliants\LaravelSitemap\Record;

trait AddsRecordsToSitemap
{
    public static function collectSitemapRecords(): \Generator
    {
        $records = static::cursor()
            ->filter(fn (self $model) => $model->shouldBeAddedToSitemap());

        foreach ($records as $model) {
            yield Record::factory($model->getSitemapUrl(), $model->getSitemapLastModified(), $model->getSitemapPriority());
        }
    }

    public function shouldBeAddedToSitemap(): bool
    {
        return true;
    }

    public function getSitemapLastModified(): ?string
    {
        return null;
    }

    public function getSitemapPriority(): ?int
    {
        return null;
    }
}
