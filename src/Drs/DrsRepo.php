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
    $url = $this->baseUrl .'/objects/'. $item->getPid()  . $this->getMediaMethod;
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

  /**
   * Builds an instance of a DrsItem for the application to use.
   * @param  string $pid PID Object Identifier
   * @return Drs\DrsItem     Returns  a base DrsItem from the XML responses.
   */
  public function buildDrsItem($pid){
    $DrsItem = new DrsItem($pid);
    return $DrsItem;
  
    
    
  }
  /**
   * Test to see if the URL is reachable
   * @param  string $url URL string to test.
   * @return boolean       If it is reachable.
   */
  private function testHeaders($url){
    $headers = get_headers($url, 1);
    if ($headers['0'] !==  "HTTP/1.1 200 OK"){
      trigger_error('Unable to connect to the Fedora Repository'); 
      return False;
    }
    else{
      return True;
    }
  }

  public function buildDrsItemDc(DrsItem &$DrsItem){
    $DcUrl = $this->baseUrl . '/get/' . $DrsItem->getPid() . '/DC';
    if ($this->testHeaders($DcUrl)){
      $xml = simplexml_load_file($DcUrl);
      $DrsItem->setDC($xml);
      return $DrsItem;
    }
  }

  
  public function buildDrsObjectMethod(DrsItem $DrsItem){
    $methodUrl = $this->baseUrl . '/objects/' . $DrsItem->getPid() . '/methods?format=xml';
    if ($this->testHeaders($methodUrl)){
      $xml = simplexml_load_file($methodUrl);
      foreach($xml->sDef as $sDef){
        $sDefPid = (string) $sDef['pid'];
        $DrsItem->methods[$sDefPid] = array();
        foreach($sDef->method as $method){
          array_push($DrsItem->methods[$sDefPid], (string)$method['name']);
        }
      }
      return $DrsItem;
    }
  }




  public function __construct($config){
    foreach($config as $key => $value){
      $this->$key = $value;
    }
  }


}