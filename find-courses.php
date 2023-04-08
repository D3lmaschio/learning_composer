<?php

require 'vendor/autoload.php';

Helper::help_1();
Helper::help_2();

method_1();
method_2();

use Alura\CourseFinder\Finder;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

$client = new Client(['base_uri' => 'https://www.alura.com.br/']);
$crawler = new Crawler();

$finder = new Finder($client, $crawler);
$courses = $finder->find('/cursos-online-programacao/php');

foreach ($courses as $course) {
    echo $course->textContent . PHP_EOL;
}