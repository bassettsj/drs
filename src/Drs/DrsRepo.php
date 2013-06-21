<?php

use Drs\DrsItem;

namespace Drs;

class DrsRepo {
  
  protected $baseUrl;

  protected $getMediaMethod;
  
  /**
   * Queries the Fedora Repository for the media streams to serve the users. Each fedora media stream is a new instance of the 
   * @param  DrsItem $item The parent item to look for media streams on.
   * @param  Solarium\Client $solr Solarium client to communicate to the Solr index.
   * @return DrsItem       The parent item with an associative array of all the DrsItemClasses for each one.
   */
  public function  getMedia($item, $solr){
    $url = $this->baseUrl . $item->getPid()  . $this->getMediaMethod;
    //Test to see if we were able to find the server!
    $headers = get_headers($url, 1);
    if ($headers[0] == 'HTTP/1.1 200 OK'){
      $xml = simplexml_load_file($url);
      $results = $xml -> results -> result;

      $item -> media = array();
      foreach($results as $doc){
        foreach ($doc->member->attributes() as $k => $v){
          $mediaPid = str_replace('info:fedora/', '', $v);
          $mediaItem = new DrsItem($mediaPid, $solr);
          $mediaItem -> mediaMethodsUrl = $this -> baseUrl . $mediaItem -> getPid() . '/methods?format=xml';
          
          //Simple XML Items
          $xml = simplexml_load_file($mediaItem -> mediaMethodsUrl);
          $mediaItem -> mediaType = (string)$xml->sDef['pid'];
    

          $mediaItem -> mediaMethods = array();
          foreach ($xml->sDef->method as $method){
             $mediaItem->mediaMethods[(string)$method['name']] = (string) ($this -> baseUrl . $mediaItem -> getPid() .'/methods/'. $mediaItem->mediaType . '/'.(string)$method['name']);
          }



         $item->media[$mediaItem->mediaType] = $mediaItem;
        }  
      }
      return $item;
    }
    else{
      return False;
    }
    
  }

  public function buildDrsItem($pid){
    $DrsItem = new DrsItem($pid);
    


    return $DrsItem;
  }


  public function __construct($config){
    foreach($config as $key => $value){
      $this->$key = $value;
    }
  }


}