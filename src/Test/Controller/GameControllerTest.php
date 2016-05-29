<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use Goutte\Client;

class GameControllerTest extends PHPUnit_Framework_TestCase
{
	public function testIndex_HasUl() {
		$client = new Client();
		$response = $client->request('GET', 'http://localhost:8000/web');
		$this->assertCount(6, $response->filter('ul > li'));
	}

	public function testAddRating_WithGet_HasEmptyForm() {
		$client = new Client();
		$response = $client->request('GET', 'http://localhost:8000/web/add-rating.php?game=1');

		$this->assertCount(1, $response->filter('form'));
		$this->assertEquals('', $response->filter('form input[name=score]')->attr('value'));
	}

	public function testAddRating_WithPost_IsRedirect() {
		$client = new \GuzzleHttp\Client();
		$response = $client->request('POST', 
			'http://localhost:8000/web/add-rating.php?game=1',
			[
				'allow_redirects' => false,
				'form_params' => ['score' => 5]
			]
		);

		$this->assertEquals(302, $response->getStatusCode());
		$this->assertEquals('/web/add-rating.php?game=1', $response->getHeaderLine('Location'));

		$pdo = new PDO('mysql:host=localhost;dbname=gamebook_test', 'root', null);
		$statement = $pdo->prepare('SELECT * FROM rating');
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);

		$this->assertCount(1, $result);
		$this->assertEquals(['user_id' => 1, 'game_id' => 1, 'score' => 5], $result[0]);
	}
}
/*
use GuzzleHttp\Client;

class GameControllerTest extends PHPUnit_Framework_TestCase
{
	public function testIndex_HasUl() {
		$client = new Client();
		$response = $client->request('GET', 'http://localhost:8000/web');
		$this->assertRegexp('/<ul>/', $response->getBody()->getContents());
	}
	
}
*/