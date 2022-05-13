<?php

namespace Intelliants\LaravelSitemap\Commands;

use Illuminate\Console\Command;
use Intelliants\LaravelSitemap\LaravelSitemap;

class SitemapGenerationCommand extends Command
{
    protected $signature = 'sitemap {engine?}';
    protected $description = 'Generate/update the sitemap.xml file';


    public function handle(LaravelSitemap $sitemap)
    {
        $sitemap
            ->setConsole($this)
            ->generate($this->argument('engine'));
    }
}
