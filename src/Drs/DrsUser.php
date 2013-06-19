<?php

namespace Drs;

use Silex\Application;

class DrsUser {

  private $department;
  private $departmentDesc;
  private $school;
  private $schoolDesc;
  private $cn;
  private $eppn;
  private $givenName;
  private $grouper;
  private $ismemberof;
  private $neuEduNUID;
  private $sn;
  private $unscopedAffiliation;
  
  private $savedCollections = array();
  private $Vars = array();


  public function getSavedcollections(){
    return $this->savedCollections;
  }
  

  public function addUserCollection(DrsUserCollection $DrsUserCollection){
    if (array_key_exists($DrsUserCollection->getName(), $this->savedCollections)){
      trigger_error("Name already in use!",E_USER_ERROR);
    }
    else{
      $this->savedCollections[$DrsUserCollection ->getName()] = $DrsUserCollection;
    }
  }
  public function __toString(){
    $stub = "$this->cn";
    return $stub;
  }






  public function __construct($department, $departmentDesc, $school, $schoolDesc, $cn, $eppn, $givenName, $grouper, $ismemberof, $neuEduNUID, $sn, $unscopedAffiliation){
    $this-> department =  $department;
    $this-> departmentDesc =  $departmentDesc;
    $this-> school =  $school;
    $this-> schoolDesc =  $schoolDesc;
    $this-> cn =  $cn;
    $this-> eppn =  $eppn;
    $this-> givenName =  $givenName;
    $this-> grouper =  $grouper;
    $this-> ismemberof =  $ismemberof;
    $this-> neuEduNUID =  $neuEduNUID;
    $this-> sn =  $sn;
    $this-> unscopedAffiliation =  $unscopedAffiliation;
  }

}