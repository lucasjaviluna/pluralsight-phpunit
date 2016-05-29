<?php

require __DIR__ . '/../../Entity/Game.php';

class GameTest extends PHPUnit_Framework_TestCase
{
	public function testImage_WithNull_ReturnPlaceholder() {
		$game = new Game();
		$game->setImagePath(null);
		$this->assertEquals('/images/placeholder.jpg', $game->getImagePath());
	}

	public function testImage_WithPath_ReturnPlaceholder() {
		$game = new Game();
		$game->setImagePath('/images/game.jpg');
		$this->assertEquals('/images/game.jpg', $game->getImagePath());
	}

	/*
	public function testIsRecommended_With5_ReturnsTrue() {
		$game = $this->getMock('Game', ['getAverageScore']);
		//$game = $this->getMockBuilder('Game')
		//	->setMethods(['getAverageScore'])
		//	->getMock();
		

		$game->expects($this->any())
			->method('getAverageScore')
			->will($this->returnValue(5));
		$this->assertTrue($game->isRecommended());
	}
	*/
	public function testAverageScore_WithoutRatings_ReturnsNull() {
		$game = new Game();
		$game->setRatings([]);
		$this->assertNull($game->getAverageScore());
	}

	public function testAverageScore_With6And8_Returns7() {
		$rating1 = $this->getMock('Rating', ['getScore']);
		$rating1->expects($this->any())
			->method('getScore')
			->will($this->returnValue(6));

		$rating2 = $this->getMock('Rating', ['getScore']);
		$rating2->expects($this->any())
			->method('getScore')
			->will($this->returnValue(8));

		$game = $this->getMock('Game', ['getRatings']);
		$game->expects($this->any())
			->method('getRatings')
			->will($this->returnValue([$rating1, $rating2]));

		$this->assertEquals(7, $game->getAverageScore());
	}

	public function testAverageScore_WithNullAnd5_Returns5() {
		$rating1 = $this->getMock('Rating', ['getScore']);
		$rating1->expects($this->any())
			->method('getScore')
			->will($this->returnValue(null));

		$rating2 = $this->getMock('Rating', ['getScore']);
		$rating2->expects($this->any())
			->method('getScore')
			->will($this->returnValue(5));

		$game = $this->getMock('Game', ['getRatings']);
		$game->expects($this->any())
			->method('getRatings')
			->will($this->returnValue([$rating1, $rating2]));

		$this->assertEquals(5, $game->getAverageScore());
	}

	public function testIsRecommended_WithCompatibility2AndScore10_ReturnsFalse() {
		$game = $this->getMock('Game', ['getAverageScore', 'getGenreCode']);
		$game->expects($this->any())
			->method('getAverageScore')
			->will($this->returnValue(10));

		$user = $this->getMock('User', ['getGenreCompatibility']);
		$user->expects($this->any())
			->method('getGenreCompatibility')
			->will($this->returnValue(2));

		$this->assertFalse($game->isRecommended($user));
	}

	public function testIsRecommended_WithCompatibility10AndScore10_ReturnsFalse() {
		$game = $this->getMock('Game', ['getAverageScore', 'getGenreCode']);
		$game->expects($this->any())
			->method('getAverageScore')
			->will($this->returnValue(10));

		$user = $this->getMock('User', ['getGenreCompatibility']);
		$user->expects($this->any())
			->method('getGenreCompatibility')
			->will($this->returnValue(10));

		$this->assertTrue($game->isRecommended($user));
	}

	/**
	* @expectedException NotFoundException
	*/
/*	public function testGetInexistentGame() {
		$repo = new GameRepository();
		$repo->findGameById(999);
	}*/
}