<?php

namespace Drs;


use Silex\Application;
use Silex\ServiceProviderInterface;
use Drs\SearchServiceProvider;


/**
 * Class definition for DRS items.
 */


class DrsItem {

  //String id.
  public $pid;
  
  // CRUD
  private $create;
  private $read;
  private $update;
  private $delete;

  //Abstract
  public $abstract;

  //Collection ID
  public $colid;

  //Desposit Date
  public $depositDate;

  //Deposit Year
  public $depositYear;

  //Genres
  public $genre;
  
  //Identifiers
  public $identifiers;

  //last modified;
  public $lastModified;

  //Owner ID
  public $ownerID;

  //Publishing Place
  public $pubPlace;

  //Publisher
  public $publisher;

  //Subject
  public $subject;

  //title
  public $title;

  //type
  public $type;

  //Thumbnail
  public $thumbnail;

  //Lowres Image;
  public $lowres;

  public $mods;

  public function __construct(){
    
  }
}


/**
 *  Class definition for service provider interface.
 */


class DrsItemServiceProvider implements ServiceProviderInterface {
   public function register(Application $app)
    {
        $app['drsitem'] = $app->share(function () use ($app) {
             $item = new DrsItem();
             return $item;
        });
        
    }

    public function boot(Application $app)
    {

    }
}