<?php

declare(strict_types=1);

namespace Jobcloud\Tests\HttpMockServer;

use Jobcloud\HttpMockServer\Response;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Jobcloud\HttpMockServer\Response
 *
 * @internal
 */
final class ResponseTest extends TestCase
{
    public function testCreate(): void
    {
        $response = Response::create();

        self::assertSame(200, $response->getStatus());
        self::assertSame([], $response->getHeaders());
        self::assertSame('', $response->getBody());
    }

    public function testWithStatus(): void
    {
        $response = Response::create();

        $responseWithStatus = $response->withStatus(204);

        self::assertSame(200, $response->getStatus());
        self::assertSame([], $response->getHeaders());
        self::assertSame('', $response->getBody());

        self::assertSame(204, $responseWithStatus->getStatus());
        self::assertSame([], $responseWithStatus->getHeaders());
        self::assertSame('', $responseWithStatus->getBody());
    }

    public function testWithHeader(): void
    {
        $response = Response::create();

        $responseWithHeader1 = $response->withHeader('Content-Type', 'application/json');
        $responseWithHeader2 = $responseWithHeader1->withHeader('Accept', 'application/json');

        self::assertSame(200, $response->getStatus());
        self::assertSame([], $response->getHeaders());
        self::assertSame('', $response->getBody());

        self::assertSame(200, $responseWithHeader1->getStatus());
        self::assertSame(['Content-Type' => 'application/json'], $responseWithHeader1->getHeaders());
        self::assertSame('', $responseWithHeader1->getBody());

        self::assertSame(200, $responseWithHeader2->getStatus());
        self::assertSame(
            ['Content-Type' => 'application/json', 'Accept' => 'application/json'],
            $responseWithHeader2->getHeaders()
        );
        self::assertSame('', $responseWithHeader2->getBody());
    }

    public function testWithBody(): void
    {
        $response = Response::create();

        $responseWithBody = $response->withBody('{"email":"john.doe@jobcloud.ch"}');

        self::assertSame(200, $response->getStatus());
        self::assertSame([], $response->getHeaders());
        self::assertSame('', $response->getBody());

        self::assertSame(200, $responseWithBody->getStatus());
        self::assertSame([], $responseWithBody->getHeaders());
        self::assertSame('{"email":"john.doe@jobcloud.ch"}', $responseWithBody->getBody());
    }

    public function testJsonSerialize(): void
    {
        $response = Response::create()
            ->withStatus(422)
            ->withHeader('Content-Type', 'application/error+json')
            ->withBody('{"error":"There is an errro"}')
        ;

        self::assertSame([
            'status' => 422,
            'headers' => ['Content-Type' => 'application/error+json'],
            'body' => '{"error":"There is an errro"}',
        ], $response->jsonSerialize());
    }

    public function testCreateFromArray(): void
    {
        $response = Response::createFromArray([
            'status' => 422,
            'headers' => ['Content-Type' => 'application/error+json'],
            'body' => '{"error":"There is an errro"}',
        ]);

        self::assertSame(422, $response->getStatus());
        self::assertSame(['Content-Type' => 'application/error+json'], $response->getHeaders());
        self::assertSame('{"error":"There is an errro"}', $response->getBody());
    }
}
