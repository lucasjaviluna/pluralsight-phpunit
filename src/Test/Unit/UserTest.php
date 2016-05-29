<?php

require __DIR__ . '/../../Entity/User.php';

class UserTest extends PHPUnit_Framework_TestCase
{
	public function testGenreCompatibility_With8And6_Returns7() {
		$rating1 = $this->getMock('Rating', ['getScore']);
		$rating1->expects($this->any())
			->method('getScore')
			->will($this->returnValue(6));

		$rating2 = $this->getMock('Rating', ['getScore']);
		$rating2->expects($this->any())
			->method('getScore')
			->will($this->returnValue(8));

		$user = $this->getMock('User', ['findRatingsByGenre']);
		$user->expects($this->any())
			->method('findRatingsByGenre')
			->will($this->returnValue([$rating1, $rating2]));

		$this->assertEquals(7, $user->getGenreCompatibility('zombies'));
	}

	public function testRatingsByGenre_With1ZombieAnd1Shooter_Returns1Zombie() {
		$zombiesGame = $this->getMock('Game', ['getGenreCode']);
		$zombiesGame->expects($this->any())
			->method('getGenreCode')
			->will($this->returnValue('zombies'));

		$shooterGame = $this->getMock('Game', ['getGenreCode']);
		$shooterGame->expects($this->any())
			->method('getGenreCode')
			->will($this->returnValue('shooter'));

		$rating1 = $this->getMock('Rating', ['getGame']);
		$rating1->expects($this->any())
			->method('getGame')
			->will($this->returnValue($zombiesGame));

		$rating2 = $this->getMock('Rating', ['getGame']);
		$rating2->expects($this->any())
			->method('getGame')
			->will($this->returnValue($shooterGame));

		$user = $this->getMock('User', ['getRatings']);
		$user->expects($this->any())
			->method('getRatings')
			->will($this->returnValue([$rating1, $rating2]));

		$ratings = $user->findRatingsByGenre('zombies');
		$this->assertCount(1, $ratings);
		foreach ($ratings as $rating) {
			$this->assertEquals('zombies', $rating->getGame()->getGenreCode());
		}
	}
}