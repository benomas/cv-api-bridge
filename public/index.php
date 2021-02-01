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
      'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzIiwianRpIjoiZjVhNDBlYTIxZTYxMTNjM2I4NWZhNDY4OGQ1YzFiYjQ1MTM0ZGY5NDVjZjBiOTM0OWUxMTk5YjAxNjg0MmE4MmUxZTg3YzYxNTY3ZmFlMjkiLCJpYXQiOiIxNjEyMTkzMjM4LjA3MTMwMyIsIm5iZiI6IjE2MTIxOTMyMzguMDcxMzA3IiwiZXhwIjoiMTYxMjI3OTYzOC4wNDQyNTMiLCJzdWIiOiI0Iiwic2NvcGVzIjpbXX0.uCbf9KKaVTn7-fYIb8y-0AKvwl_jnTwCDIDcEtFGEFUm5MPtE1DAlc0BCRK8v3H_ABcgyYiGwuFDjPfWbaZaRIzDsYNnGZOso8xJH4TcRCwcjHAKFQ_r7qmmys88x_eMpGs0pwau7qlxErhhdVkQMATXLi4-OicUyxnV0urPgit28DBr7FpoZctqUwll5_gbtmOCthwu1YfXlMskfxIjQymywJd-DM1PieiOJm3ACdJabRvdum0ZOnMVzhJ-YgiRwhTmTxrxvTA9WK0DGsDrEGwrMkGmfVQ1xX3nkPxhKtXlSq8RMPAQMikZbHX0IXK3CPsAKa03Q7iaiarItk3NiXp3t5KSS_K5pztHoBIHcHFjNBT0Kfki1BAux2cf8LmNuulcac_RcHkEZlxI8if1WM6UQF30nSUXhgimloIu-O1LL6QqL1fCqRPC_SGvTgtoxA9-0MAxo31IwOo0Dg4UfsNYgWY4nMLnVwk77aV8ziL40Xdvbsf9wXSHa_xPKXCecyBRlWJ4E9oq7dr-LnZcFDUPCCllnHznH0F8ooSNR9mQ6Qppnh9jM2y3DLjQlMZJU41ur9IIJWAzzbPKuac8WD8BOQuxSCmKEAHQnppH2rjL9nzlEnIguK7vw2A7iX3frcICOY5MuTVgKDWbTYigAY_vzA2Vcv-kdEBNADomMr0'
    ] 
  ]
);

foreach($response->getHeaders() as $header=>$value)
  if($header !== 'Access-Control-Allow-Origin')
    header("$header: $value[0]");

$body = $response->getBody();
echo "[$body]";