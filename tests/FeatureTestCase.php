<?php

namespace Tests;

use Filterable\FilterableServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class FeatureTestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [FilterableServiceProvider::class];
    }
}
