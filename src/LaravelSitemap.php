<?php

namespace Intelliants\LaravelSitemap;

use Illuminate\Console\Command;

class LaravelSitemap
{
    protected Writer $writer;
    protected ?Command $console;


    public function __construct(Writer $writer)
    {
        $this->writer = $writer;
    }

    public function setConsole(Command $console): self
    {
        $this->console = $console;

        return $this;
    }

    public function generate(string $engine = null): void
    {
        $sitemaps = [];

        foreach ($this->engines as $engineKey => $engineClass) {
            if (is_null($engine) || $engine == $engineKey) {
                if ($this->console) {
                    $this->console->line(sprintf('Generating %s sitemap', $engineKey));
                }

                $sitemaps = array_merge($sitemaps, $this->generateForEngine($engineKey, new $engineClass));
            }
        }

        $this->generateRootFile($sitemaps);
    }

    protected function generateForEngine(string $engineKey, Contracts\Engine $engineClass): array
    {
        return $this->writer->writeChunkFile($engineKey, $engineClass);
    }

    protected function generateRootFile(array $chunks): void
    {
        $this->writer->writeRootFile($chunks);
    }
}
