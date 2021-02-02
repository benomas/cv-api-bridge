<?php

require __DIR__.'/../vendor/autoload.php';
$proxyApi = new \Proxy\Api();
$client   = new GuzzleHttp\Client();
$headers  = $proxyApi->getHeaders();

$headers['Authorization'] = $proxyApi->getBearerToken();

$options = ['headers'=> $headers];

if($proxyApi->getHttpMethod() === 'POST'){
  $postdata = json_decode(file_get_contents("php://input"),1);
  $options  = ['form_params'=> $postdata ?? []];
}

try {
  $response = $client->request(
    $proxyApi->getHttpMethod(), 
    "{$proxyApi->getApiProxiedRootPath()}{$proxyApi->getRequestPath()}?{$proxyApi->getRequestQueryString()}",
    $options
  );
}catch (\GuzzleHttp\Exception\ClientException $e) {
  $response = $e->getResponse();
}

$preventIncomapitbleHeaders = [
  'Server',
  //'Content-Type',
  'Transfer-Encoding',
  //'Connection',
  'X-Powered-By',
  //'Cache-Control',
  //'Date',
  //'X-RateLimit-Limit',
  //'X-RateLimit-Remaining',
  'Access-Control-Allow-Origin',
  'Vary',
  //'Access-Control-Allow-Credentials'
];

foreach(array_filter($response->getHeaders(),function($header) use($preventIncomapitbleHeaders){
  return !in_array($header,$preventIncomapitbleHeaders);
}, ARRAY_FILTER_USE_KEY) as $header=>$value)
  header("$header: $value[0]");

http_response_code($response->getStatusCode());

$body = $response->getBody();
echo $body;