<?php

use Drs\DrsItem;

namespace Drs;

class DrsRepo {
  
  private $baseUrl;

  private $getMediaMethod;

  public function  getMedia($item, $solr){
    $url = $this->baseUrl . $item->pid  . $this->getMediaMethod;
    //Test to see if 
    $headers = get_headers($url, 1);
    if ($headers[0] == 'HTTP/1.1 200 OK'){
      $xml = simplexml_load_file($url);
      $results = $xml -> results -> result;

      $item -> media = array();
      foreach($results as $doc){
        foreach ($doc->member->attributes() as $k => $v){
          $mediaPid = str_replace('info:fedora/', '', $v);
          $mediaItem = new DrsItem($mediaPid, $solr);
          $mediaMethodUrl  = $this -> baseUrl . $mediaItem -> pid . '/methods?format=xml';
          $mediaMethodXML = simplexml_load_file($mediaMethodUrl);
          d($mediaMethodXML);
          foreach($mediaMethodXML -> sDef[0] -> methods as $method){
            d($method);
            foreach($method-> attributes() as $key => $value){
              array_push($mediaItem->methods, $value);
            }
          }

          array_push($item->media, $mediaItem);
        }  
      }
      return $item;
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