<?php

namespace Drs;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Drs\DrsItem;




class DrsItemServiceProvider implements ServiceProviderInterface{
   public function register(Application $app)
    {
        $app['drs.build'] = $app->share(function ($pid) use ($app) {
            
        });
        
    }

    public function boot(Application $app)
    {

    }
}
