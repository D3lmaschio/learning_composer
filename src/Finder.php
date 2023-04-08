<?php

namespace D3lmaschio\CourseFinder;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Finder
{
    public function __construct(private ClientInterface $httpClient, private Crawler $crawler)
    {
    }

    /**
     * Returns an String Array with the found elements.
     *
     * @param string $url
     * @return array
     */
    public function find(string $url): array
    {
        $response = $this->httpClient->request('GET', $url);
        $this->crawler->addHtmlContent((string) $response->getBody());
        $courses = $this->crawler->filter('span.card-curso__nome')->getIterator();

        return $courses->getArrayCopy();
    }
}
