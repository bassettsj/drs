<?php

namespace Drs;

class DrsItem {
  
  /**
   * PID is the Unique ID for the Fedora Object.
   * @var string
   */
  protected $pid = '';
  
  /**
   * Dublin Core Record
   * @var null
   */
  protected $DC = null;


  /**
   * Creat permissions
   * @var array
   */
  protected $create = array();
  

  /**
   * Read permissions
   * @var array
   */
  protected $read = array();

  /**
   * Update permisssiosn 
   * @var array
   */
  protected $update = array();

  /**
   * Delete premissions
   * @var array
   */
  protected $delete = array();



  /**
   * Public function to return the pid string.
   * @return string PID returned, unique ID for Item.
   */
  
  public function getPid(){
    return $this->pid;
  }

  /**
   * Sets the objects pid
   * @param String $pid unique ID for the object.
   */
  
  public function setPid($pid){
    if(!is_string($pid)){
      trigger_error("$pid must be a string",E_USER_ERROR);
    }
    else{
      $this->pid = $pid;
    }

  }

  /**
   * Building the construct object for DRS items when they are created.
   * @param string $pid  unique string in the DRS fedora repository.
   * @param object $solr Solarium item class.
   */
  public function __construct($pid){ //$solr){
    $this->pid = $pid;
    // $query = $solr->createSelect();
    // $query->setQuery('pid:"'.$pid.'"');
    // $query->setRows(1);
    // $result = $solr -> select($query);
    // $doc = $result -> getDocuments();
    // foreach($doc[0] as $key => $value){
    //   $this->$key = $value;
    // }
  }

  /**
   * Permission check on the object
   * @param  string $permission The CRUD permission to check for the object.
   * @param  string $identities The identity strings that are allowed to preform the CRUD operation.
   * @return boolean             If they can perform that action.
   */
  public function permcheck($permission, $identities){
    $permission = strtolower($permission);
    $permarray = array('create','read','update','delete');
    if (!in_array($permission, $permarray)){
      return False;
    }
    else{
      if(in_array($identities,$this->$permission)){
        return True;
      }
      else{
        return False;
      }
    }
  }
}