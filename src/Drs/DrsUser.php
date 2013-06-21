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

  /**
   * Parsed the grouper string for identities.
   * @var array
   */
  private $identites = array();
  
  private $savedCollections = array();
  private $vars = array();


  public function getSavedcollections(){
    return $this->savedCollections;
  }
  

  public function addUserCollection(DrsUserCollection $DrsUserCollection){
      $this->savedCollections[$DrsUserCollection -> getUniqueID()] = $DrsUserCollection;
  }

  public function __toString(){
    $stub = "$this->cn";
    return $stub;
  }


  /**
   * Parse our the Grouper string sepereated by `;`, return an array of those string .
   * @param  string $grouper The grouper string
   * @return array           and array of identities for the DrsUser.
   */
  private function parseGrouper($grouper){
    $identitiesArray = preg_split("/[;]+/",$grouper);
    return $identitiesArray;
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
    $this->identities = $this->parseGrouper($grouper);
  }

}