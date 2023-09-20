<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use GuzzleHttp\Psr7\LazyOpenStream;

class DemoController {
    public function inicio(Request $request, Response $response, $args) {
        $newStream = new LazyOpenStream('demo.html', 'r');
        $newResponse = $response->withBody($newStream);
        return $newResponse;
    }
}