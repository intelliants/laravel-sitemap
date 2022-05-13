<?php

namespace Intelliants\LaravelSitemap;

class Writer
{
    const ROOT_HEADER = '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    const ROOT_FOOTER = '</sitemapindex>';

    const HEADER = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">';
    const FOOTER = '</urlset>';


    public function writeRootFile(array $chunks): void
    {
        $fh = fopen(self::getPath() . self::getName(), 'w');

        fwrite($fh, self::ROOT_HEADER);

        foreach ($chunks as $chunkName) {
            $line = sprintf(
                '<sitemap><loc>%s</loc><lastmod>%s</lastmod></sitemap>',
                config('app.url') . '/' . $chunkName,
                now()->format('Y-m-d')
            );

            fwrite($fh, $line);
        }

        fwrite($fh, self::ROOT_FOOTER);
        fclose($fh);
    }

    public function writeChunkFile(string $fileName, Contracts\Engine $engine): array
    {
        $files = [];
        foreach (config('translatable.locales') as $locale => $localeTitle) {
            $files[] = $this->writeLocalizedChunkFile($fileName, $locale, $engine);
        }

        return $files;
    }

    protected function writeLocalizedChunkFile(string $fileName, string $locale, Contracts\Engine $engine)
    {
        $path = self::getPath();

        if (!file_exists($path)) {
            mkdir($path);
        }

        $name = self::getName($fileName, $locale);

        $fh = fopen($path . '/' . $name, 'w');

        fwrite($fh, self::HEADER);

        foreach ($engine->collect() as $record) {
            fwrite($fh, $this->flattenRecord($record, $locale));
        }

        fwrite($fh, self::FOOTER);
        fclose($fh);

        return $name;
    }

    protected function flattenRecord(Record $record, string $locale): string
    {
        // do we need to implement it via true-XML solution?
        $result = '<url><loc>' . $record->getUrl($locale) . '</loc>';

        if ($value = $record->getLastModified()) {
            $result.= '<lastmod>' . $value . '</lastmod>';
        }

        if ($value = $record->getPriority()) {
            $result.= '<priority>' . $value . '</priority>';
        }

        return $result . '</url>';
    }


    protected static function getPath(): string
    {
        return rtrim(storage_path('sitemap'), '/') . '/';
    }

    protected static function getName(string $chunk = null, string $locale = null): string
    {
        $fileName = 'sitemap';

        if ($chunk && $locale) {
            $fileName = 'sitemap-' . $chunk . '-' . $locale;
        }

        return $fileName . '.xml';
    }
}
