<?php
 require_once __DIR__. '/../src/Repository/GameRepository.php';

 $repo = new GameRepository();
 $games = $repo->findByUserId(1);

 # Install Composer
 //curl -sS https://getcomposer.org/installer | php

 //You can add Guzzle HTTP Client PHP as a dependency using the composer.phar CLI:
 //php composer.phar require guzzlehttp/guzzle:~6.0

 //Install Goutte (Crawler API PHP)
 //composer require fabpot/goutte
?>

<ul>
<?php foreach ($games as $game): ?>
	<li>
		<?php echo $game->getTitle(); ?> <br>
		<?php echo $game->getAverageScore(); ?> <br>
		<img src="<?php echo $game->getImagePath(); ?>">
	</li>
<?php endforeach ?>
</ul>