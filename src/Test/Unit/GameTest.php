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

	public function testIsRecommended_With5_ReturnsTrue() {
		$game = $this->getMock('Game', ['getAverageScore']);
		/*$game = $this->getMockBuilder('Game')
			->setMethods(['getAverageScore'])
			->getMock();
		*/
		$game->expects($this->any())
			->method('getAverageScore')
			->will($this->returnValue(5));
		$this->assertTrue($game->isRecommended());
	}

	public function testAverageScore_WithoutRatings_ReturnsNull() {
		$game = new Game();
		$game->setRatings([]);
		$this->assertNull($game->getAverageScore());
	}

	public function testAverageScore_With6And8_Returns7() {
		$rating1 = $this->getMock('Rating', ['getScore']);
		$rating1->expects($this->once())
			->method('getScore')
			->will($this->returnValue(6));

		$rating2 = $this->getMock('Rating', ['getScore']);
		$rating2->expects($this->once())
			->method('getScore')
			->will($this->returnValue(8));

		$game = $this->getMock('Game', ['getRatings']);
		$game->expects($this->any())
			->method('getRatings')
			->will($this->returnValue([$rating1, $rating2]));

		$this->assertEquals(7, $game->getAverageScore());
	}

	/**
	* @expectedException NotFoundException
	*/
/*	public function testGetInexistentGame() {
		$repo = new GameRepository();
		$repo->findGameById(999);
	}*/
}