<?php

namespace Drs;

use Silex\Application;


class DrsUserCollection {
  private $name = "My Collection";
  private $owner;
  private $id;
  private $drsItems = array();
  
  /**
   * Construct function
   * @param string  $name     Human name for the collection of items.
   * @param DrsUser $owner    The user object.
   * @param array   $drsItems An arrary of DrsItem objects representing the streams from fedora.
   */
  public function __construct($name, DrsUser $owner, array $drsItems){
    $this->name = $name;
    $this->owner = $owner;
    foreach($drsItems as $DrsItem){
      $this->addDrsItem($DrsItem);
    }
    $this->id = uniqid($name,true);
  }

  public function addDrsItem(DrsItem $drsItem){
    if (in_array($drsItem, $this->drsItems)){
      return;
    }
    else{
      $this->drsItems[$drsItem->pid] = $drsItem;
    }
  }


  public function getDrsItem($id){
    if (array_key_exists($id, $this->drsItems)){
      return $this->drsItems[$id];
    }
    else{
      trigger_error("Given $id was not in thie DrsUserCollection.",E_USER_ERROR);
    }
  }

}