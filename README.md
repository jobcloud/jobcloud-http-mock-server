# jobcloud-http-mock-server

[![Total Downloads](https://poser.pugx.org/jobcloud/jobcloud-http-mock-server/downloads.png)](https://packagist.org/packages/jobcloud/jobcloud-http-mock-server)
[![Monthly Downloads](https://poser.pugx.org/jobcloud/jobcloud-http-mock-server/d/monthly)](https://packagist.org/packages/jobcloud/jobcloud-http-mock-server)
[![Latest Stable Version](https://poser.pugx.org/jobcloud/jobcloud-http-mock-server/v/stable.png)](https://packagist.org/packages/jobcloud/jobcloud-http-mock-server)
[![Latest Unstable Version](https://poser.pugx.org/jobcloud/jobcloud-http-mock-server/v/unstable)](https://packagist.org/packages/jobcloud/jobcloud-http-mock-server)

## Description

A minimal http mock server.

## Requirements

 * php: ^7.1
 * react/event-loop: >=0.4,
 * react/http: ^0.8.4,
 * symfony/process: "^3.4|^4.2"

## Installation

Through [Composer](http://getcomposer.org) as [jobcloud/jobcloud-http-mock-server][1].

## Usage

```php
<?php

declare(strict_types=1);

namespace MyProject\Tests;

use Jobcloud\HttpMockServer\HttpMockServer;
use Jobcloud\HttpMockServer\Response;
use PHPUnit\Framework\TestCase;

class MyTest extends TestCase
{
    public function testSomthingWithHttpCalls()
    {
        $httpMockServer = new HttpMockServer();
        $httpMockServer->run(8080, [
            Response::create()
                ->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->withBody('{"id":1, "email":"john.doe@jobcloud.ch"}'),
        ]);

        file_get_contents(
            'http://localhost:8080/',
            false,
            stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'header' => 'Content-Type: application/json',
                    'content' => json_encode(['email' => 'john.doe@jobcloud.ch']),
                ],
            ])
        );
    }
}
```

## Copyright

Jobcloud AG 2019

[1]: https://packagist.org/packages/jobcloud/jobcloud-http-mock-server
