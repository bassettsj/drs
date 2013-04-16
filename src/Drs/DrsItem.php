<?php

namespace Drs;

use Silex\application;

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

  public function __construct($pid){
    $this->pid = $pid;
  }
}