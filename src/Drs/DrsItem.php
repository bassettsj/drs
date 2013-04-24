<?php

namespace Drs;

class DrsItem {
  //String id.
  public $pid;
  


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
  

}