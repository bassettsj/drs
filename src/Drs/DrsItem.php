<?php

namespace Drs;

class DrsItem {
  //String id.
  public $pid;
  

  /**
   * Building the construct object for DRS items when they are created.
   * @param string $pid  unique string in the DRS fedora repository.
   * @param object $solr Solarium item class.
   */
  public function __construct($pid, $solr){
    $this->pid = $pid;
    $query = $solr->createSelect();
    $query->setQuery('pid:"'.$pid.'"');
    $query->setRows(1);
    $result = $solr -> select($query);
    $doc = $result -> getDocuments();
    foreach($doc[0] as $key => $value){
      $this->$key = $value;
    }
  }

  /**
   * Permission check on the object
   * @param  string $permission The CRUD permission to check for the object.
   * @param  string $identities The identity strings that are allowed to preform the CRUD operation.
   * @return boolean             If they can perform that action.
   */
  public function permission_check($permission, $identities){
    $permission = strtolower($permission);
    $permarray = array('create','read','update','delete');
    if (!in_array($permission, $permarray)){
      return False;
    }
    else{
      if($identities,$this->permission){
        return True;
      }
      else{
        return False;
      }
    }
    

  }

}