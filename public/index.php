<?php

require __DIR__.'/../vendor/autoload.php';

$proxyApi = new \Proxy\Api();

$proxyApi->setApiProxiedRootPath('https://w-services.duckdns.org/api');

$client = new GuzzleHttp\Client();

$response = $client->request(
  'GET', 
  "{$proxyApi->getApiProxiedRootPath()}{$proxyApi->getRequestPath()}?{$proxyApi->getRequestQueryString()}",
  [
    'headers' => [
      'Content-Type'  => 'application/json',
      'Authorization' => $proxyApi->getBearerToken()
    ] 
  ]
);

foreach($response->getHeaders() as $header=>$value)
  if($header !== 'Access-Control-Allow-Origin')
    header("$header: $value[0]");

$body = $response->getBody();
echo $body;