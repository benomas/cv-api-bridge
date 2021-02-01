<?php

namespace Proxy\HeaderProccessors;

class BaseHeaderProccessor{
  protected $httpAccept;
  protected $httpContentType;
  protected $httpUserAgent;
  protected $httpHost;
  protected $headers;

  public function  __construct(){
  }

// [Specific Logic]
// [End Specific Logic]

// [Getters]
  public function getHttpAccept(){
    return $this->httpAccept??null;
  }

  public function getHttpContentType(){
    return $this->httpContentType??null;
  }

  public function getHttpUserAgent(){
    return $this->httpUserAgent??null;
  }

  public function getHttpHost(){
    return $this->httpHost??null;
  }

  public function getHeaders(){
    return $this->headers??null;
  }
// [End Getters]

// [Setters]
  public function setHttpAccept($httpAccept=null){
    $this->httpAccept = $httpAccept??null;

    return $this;
  }

  public function setHttpContentType($httpContentType=null){
    $this->httpContentType = $httpContentType??null;

    return $this;
  }

  public function setHttpUserAgent($httpUserAgent=null){
    $this->httpUserAgent = $httpUserAgent??null;

    return $this;
  }

  public function setHttpHost($httpHost=null){
    $this->httpHost = $httpHost??null;

    return $this;
  }

  public function setHeaders($headers=null){
    $this->headers = $headers??null;
    
    return $this;
  }
// [End Setters]
}