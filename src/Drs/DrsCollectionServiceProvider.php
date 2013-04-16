<?php

namespace Drs;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Drs\DrsCollection;

class DrsCollectionServiceProvider implements ServiceProviderInterface{
   public function register(Application $app)
    {
        $app['collection'] = $app->protect(function ($collection) use ($app) {
            $default = $app['collection.default'] ? $app['collection.default'] : 'neu:1';
            $collection = $collection ?: $default;

            return $collection;
        });
    }

    public function boot(Application $app)
    {
    }
}

