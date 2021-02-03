<?php

require __DIR__.'/../vendor/autoload.php';
$proxyApi = new \Proxy\Api();
$client   = new GuzzleHttp\Client();
$headers  = $proxyApi->getHeaders();

$headers['Authorization'] = $proxyApi->getBearerToken();

$options = ['headers'=> $headers];

if($proxyApi->getHttpMethod() === 'POST'){
  $options['form_params']=[];

  if($proxyApi->getMode() === 'cv-mode')
    $options['form_params'] = json_decode(file_get_contents("php://input"),1);

  if($proxyApi->getMode() === 'cv-elementor-web-hook-mode'){
    foreach($_POST as $field=>$value)
      $options['form_params'][str_replace('No_Label_','',$field)] = $value;

    $options['form_params']['source'] = $_POST['form_name']??'undefined';
  }
  //file_put_contents('test.txt',json_encode($options['form_params']));
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