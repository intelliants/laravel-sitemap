<?php

namespace Intelliants\LaravelSitemap\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method void generate(string $engine = null)
 *
 * @see \Intelliants\LaravelSitemap\LaravelSitemap
 */
class LaravelSitemap extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravelsitemap';
    }
}
