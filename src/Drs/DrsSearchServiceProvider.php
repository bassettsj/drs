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
        $app['solr.results'] = $app->share(function($resultset) use ($app){
            $docset = $resultset -> getDocuments();
            
            $docArray = array();
            foreach ($docset as $document){
            $docArray[] = $document->fields();
            }

            return $docArray;
        });
        
    }

    public function boot(Application $app)
    {
    }
}
