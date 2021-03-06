<?php

namespace Proxy;

class Api{
  protected $httpMethod;
  protected $uri;
  protected $headers;
  protected $authorizationToken;
  protected $serverName;
  protected $mode;
  protected $apiRootPath;
  protected $requestPath;
  protected $requestQueryString;
  protected $apiProxiedRootPath;
  protected $headerProccesorInstance;
  protected $bearerToken;

  protected $headersProccesors = [
    'cv-mode'=>'Proxy\HeaderProccessors\CvHeaderProccessor',
    'cv-elementor-web-hook-mode'=>'Proxy\HeaderProccessors\CvHeaderProccessor'
  ];

  public function __construct(){
    $this->loadApiRootPath()
      ->loadRequestQueryString()
      ->loadRequestPath()
      ->fixMode()
      ->fixRequestPath()
      ->loadHeaderProccesorInstance()
      ->loadBearerToken()
      ->loadApiProxiedRootPath()
      ->loadMethod()
      ->setHeaders($this->getHeaderProccesorInstance()->getHeaders());
  }
// [Specific Logic]
  public function builder(){

  }

  public function loadApiRootPath(){
    $apiRootPath = preg_replace('/(.*)\/(.+)\.php/', '$1', $_SERVER['DOCUMENT_URI'] ?? $_SERVER['SCRIPT_NAME']??'/');
    
    return $this->setApiRootPath($apiRootPath);
  }

  public function loadRequestQueryString(){
    $segments = explode('?', $_SERVER['REQUEST_URI']);
    
    return $this->setRequestQueryString($segments[1]??'');
  }

  public function loadRequestPath(){
    $requestPath = str_replace("?{$this->getRequestQueryString()}", '', $_SERVER['REQUEST_URI']??'');
    $requestPath = str_replace($this->getApiRootPath(), '',$requestPath);
    $requestPath = preg_replace('/(.+)?\?(.*)/', '$2', $requestPath??'');
    
    return $this->setRequestPath($requestPath);
  }

  public function fixRequestPath(){
    $requestPath = preg_replace("/^\/(.+?)(\/.+)/", '$2', $this->getRequestPath()??'');
    
    return $this->setRequestPath($requestPath);
  }

  public function fixMode(){
    $segments = explode('/', $this->getRequestPath());
    
    return $this->setMode($segments[1]??'');
  }

  public function loadHeaderProccesorInstance (){
    $headerProccesorClass    = $this->getHeadersProccesors()[$this->getMode()??'cv-mode'];
    $headerProccesorInstance = new $headerProccesorClass();
    $headerProccesorInstance->build();

    return $this->setHeaderProccesorInstance($headerProccesorInstance);
  }

  public function loadBearerToken(){
    if(file_exists(__DIR__.'/../.env')){
      $env =  json_decode(file_get_contents(__DIR__.'/../.env'),1);
      return $this->setBearerToken($env['bearerToken']??'');
    }

    return $this;
  }

  public function loadApiProxiedRootPath(){
    if(file_exists(__DIR__.'/../.env')){
      $env =  json_decode(file_get_contents(__DIR__.'/../.env'),1);
      return $this->setApiProxiedRootPath($env['apiUrl']??'');
    }

    return $this;
  }

  public function loadMethod(){
    return $this->setHttpMethod($_SERVER['REQUEST_METHOD']??'GET');
  }
// [End Specific Logic]

// [Getters]
  public function getHttpMethod(){
    return $this->httpMethod??null;
  }

  public function getUri(){
    return $this->uri??null;
  }

  public function getHeaders(){
    return $this->headers??null;
  }

  public function getAuthorizationToken(){
    return $this->authorizationToken??null;
  }

  public function getServerName(){
    return $this->serverName??null;
  }

  public function getMode(){
    return $this->mode??null;
  }

  public function getApiRootPath(){
    return $this->apiRootPath??null;
  }

  public function getRequestPath(){
    return $this->requestPath??null;
  }

  public function getRequestQueryString(){
    return $this->requestQueryString??null;
  }

  public function getApiProxiedRootPath(){
    return $this->apiProxiedRootPath??null;
  }

  public function getHeaderProccesorInstance(){
    return $this->headerProccesorInstance??null;
  }

  public function getHeadersProccesors(){
    return $this->headersProccesors??null;
  }

  public function getBearerToken(){
    return $this->bearerToken??null;
  }
// [End Getters]

// [Setters]
  public function setHttpMethod($httpMethod=null){
    $this->httpMethod = $httpMethod??null;
    
    return $this;
  }

  public function setUri($uri=null){
    $this->uri = $uri??null;

    return $this;
  }

  public function setHeaders($headers=null){
    $this->headers = $headers??null;

    return $this;
  }

  public function setAuthorizationToken($authorizationToken=null){
    $this->authorizationToken = $authorizationToken??null;

    return $this;
  }

  public function setServerName($serverName=null){
    $this->serverName = $serverName??null;

    return $this;
  }

  public function setMode($mode=null){
    $this->mode = $mode??null;

    return $this;
  }

  public function setApiRootPath($apiRootPath=null){
    $this->apiRootPath = $apiRootPath??null;

    return $this;
  }

  public function setRequestPath($requestPath=null){
    $this->requestPath = $requestPath??null;

    return $this;
  }

  public function setRequestQueryString($requestQueryString=null){
    $this->requestQueryString = $requestQueryString??null;

    return $this;
  }

  public function setApiProxiedRootPath($apiProxiedRootPath=null){
    $this->apiProxiedRootPath = $apiProxiedRootPath??null;
    
    return $this;
  }

  public function setHeaderProccesorInstance($headerProccesorInstance=null){
    $this->headerProccesorInstance = $headerProccesorInstance??null;

    return $this;
  }

  public function setHeadersProccesors($headersProccesors=null){
    $this->headersProccesors = $headersProccesors??null;

    return $this;
  }

  public function setBearerToken($bearerToken=null){
    $this->bearerToken = $bearerToken??null;

    return $this;
  }
  // [End Setters]
}