<?php

namespace Proxy\HeaderProccessors;

class CvHeaderProccessor extends \Proxy\HeaderProccessors\BaseHeaderProccessor{

  public function build(){
    return $this->setHttpAccept($_SERVER['HTTP_ACCEPT']??'application\/json')
      ->setHttpContentType($_SERVER['HTTP_CONTENT_TYPE']??'application\/json')
      ->setHttpUserAgent($_SERVER['HTTP_USER_AGENT']??'fake')
      ->setHttpHost($_SERVER['HTTP_HOST']??'localhost');
  }
}