<?php

require __DIR__.'/../vendor/autoload.php';

$proxyApi = new \Proxy\Api();

$proxyApi->setApiProxiedRootPath('https://w-services.duckdns.org/api');

$client = new GuzzleHttp\Client();

$headers = $proxyApi->getHeaders() ;
$headers['Authorization'] = $proxyApi->getBearerToken();

$response = $client->request(
  $proxyApi->getHttpMethod(), 
  "{$proxyApi->getApiProxiedRootPath()}{$proxyApi->getRequestPath()}?{$proxyApi->getRequestQueryString()}",
  [
    'headers' => $headers 
  ]
);

foreach($response->getHeaders() as $header=>$value)
  if($header !== 'Access-Control-Allow-Origin')
    header("$header: $value[0]");

$body = $response->getBody();
echo $body;