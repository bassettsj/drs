<?php

use Drs\DrsItem;

namespace Drs;

class DrsRepo {
  
  private $baseUrl;

  private $getMedia;

  public function  getMedia($item){
    $url = $this->baseUrl . $item->pid  . $this->getMedia;
    //Test to see if 
    $headers = get_headers($url, 1);
    if ($headers[0] == 'HTTP/1.1 200 OK'){
      $xml = simplexml_load_file($url);
      return $xml->results;
    }
    else{
      return False;
    }
    
  }


  public function __construct($config){
    foreach($config as $key => $value){
      $this->$key = $value;
    }
  }


}