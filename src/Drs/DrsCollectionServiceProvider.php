<?php

namespace Drs;

use Silex\Application;
use Silex\ServiceProviderInterface;


class DrsCollectionServiceProvider implements ServiceProviderInterface{
   public function register(Application $app)
    {
        $app['hello'] = $app->protect(function ($name) use ($app) {
            $default = $app['hello.default_name'] ? $app['hello.default_name'] : '';
            $name = $name ?: $default;

            return 'Hello '.$app->escape($name);
        });
    }

    public function boot(Application $app)
    {
    }
}


