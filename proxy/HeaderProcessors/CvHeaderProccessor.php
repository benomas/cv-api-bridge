<?php

namespace Proxy\HeaderProccessors;

class CvHeaderProccessor extends \Proxy\HeaderProccessors\BaseHeaderProccessor{

  public function build(){
    $headers = [];

    $httpAccept      = $_SERVER['HTTP_ACCEPT']??null;
    $httpContentType = $_SERVER['HTTP_CONTENT_TYPE']??null;
    $httpUserAgent   = $_SERVER['HTTP_USER_AGENT']??null;
    $httpHost        = $_SERVER['HTTP_HOST']??null;

    if($httpAccept)
      $headers['HTTP_ACCEPT'] = $this->setHttpAccept($httpAccept)->getHttpAccept();

    if($httpContentType)
      $headers['HTTP_CONTENT_TYPE'] = $this->setHttpContentType($httpContentType)->getHttpContentType();

    if($httpUserAgent)
      $headers['HTTP_USER_AGENT'] = $this->setHttpUserAgent($httpUserAgent)->getHttpUserAgent();

    if($httpHost)
      $headers['HTTP_HOST'] = $this->setHttpHost($httpHost)->getHttpHost();

    return $this->setHeaders($headers);
  }
}