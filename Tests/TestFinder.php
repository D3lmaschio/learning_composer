<?php

namespace D3lmaschio\CourseFinder\Tests;

use D3lmaschio\CourseFinder\Finder;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\DomCrawler\Crawler;

class TestFinder extends TestCase
{
    private $httpClientMock;
    private $url = 'url-teste';

    protected function setUp(): void
    {
        $html = <<<FIM
        <html>
            <body>
                <span class="card-curso__nome">Test Course 1</span>
                <span class="card-curso__nome">Test Course 2</span>
                <span class="card-curso__nome">Test Course 3</span>
            </body>
        </html>
        FIM;

        $stream = $this->createMock(StreamInterface::class);
        $stream
            ->expects($this->once())
            ->method('__toString')
            ->willReturn($html);

        $response = $this->createMock(ResponseInterface::class);
        $response
            ->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $httpClient = $this
            ->createMock(ClientInterface::class);
        $httpClient
            ->expects($this->once())
            ->method('request')
            ->with('GET', $this->url)
            ->willReturn($response);

        $this->httpClientMock = $httpClient;
    }

    public function testFinderMustReturnCourse(): void
    {
        $crawler = new Crawler();
        $finder = new Finder($this->httpClientMock, $crawler);
        $courses = $finder->find($this->url);

        $this->assertCount(3, $courses);
        $this->assertEquals('Test Course 1', $courses[0]->textContent);
        $this->assertEquals('Test Course 2', $courses[1]->textContent);
        $this->assertEquals('Test Course 3', $courses[2]->textContent);

    }

}