<?php

namespace Drs;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Drs\DrsRepo;




class DrsRepoServiceProvider implements ServiceProviderInterface{
   public function register(Application $app)
    {
        $app['drs.repo'] = $app->share(function () use ($app) {
           $repo = new DrsRepo($app['drs.repo.config']);
           return $repo;
        });
        
    }

    public function boot(Application $app)
    {

    }
}
