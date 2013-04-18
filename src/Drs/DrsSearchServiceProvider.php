<?php

namespace Drs;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Solarium;




class DrsSearchServiceProvider implements ServiceProviderInterface{
   public function register(Application $app)
    {
        $app['solr'] = $app->share(function () use ($app) {
             $client = new Solarium\Client($app['solr.conf']);
             return $client;
        });
        
    }

    public function boot(Application $app)
    {

    }
}
