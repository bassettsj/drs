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

  public function greet(){
    return "Hello I am {$this->cn} {$this->sn}";
  }

}