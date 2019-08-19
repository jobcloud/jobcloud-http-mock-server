<?php

declare(strict_types=1);

namespace Jobcloud\Tests\HttpMockServer;

use Jobcloud\HttpMockServer\HttpMockServer;
use Jobcloud\HttpMockServer\Response;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Jobcloud\HttpMockServer\HttpMockServer
 *
 * @internal
 */
final class HttpMockServerTest extends TestCase
{
    public function testRun(): void
    {
        $httpMockServer = new HttpMockServer();

        $httpMockServer->run(8080, [
            Response::create()
                ->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->withBody('{"id":1, "email":"john.doe@jobcloud.ch"}'),
        ]);

        $output = file_get_contents('http://localhost:8080/', false, stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => json_encode(['email' => 'john.doe@jobcloud.ch']),
            ],
        ]));

        self::assertSame('{"id":1, "email":"john.doe@jobcloud.ch"}', $output);

        self::assertSame('HTTP/1.0 200 OK', $http_response_header[0]);
        self::assertSame('Content-Type: application/json', $http_response_header[1]);
    }
}
