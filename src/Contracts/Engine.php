<?php

namespace Intelliants\LaravelSitemap\Contracts;

interface Engine
{
    public function collect(): \Generator;
}
