<?php snippet('header') ?>

<div id="page-content" class="project <?= $page->category() ?>">
	
	<div class="slider">

	<?php foreach ($images as $key => $image): ?>

		<?php $image = $image->toFile(); ?>

		<div class="slide" 
		<?php if($image->caption()->isNotEmpty()): ?>
		data-caption="<?= $image->caption()->kt()->escape() ?>"
		<?php endif ?>
		>
		
		<?php if($image->videofile()->isNotEmpty() or $image->videolink()->isNotEmpty() or $image->videoexternal()->isNotEmpty()): ?>
			<div class="content video">
				<?php 
				$poster = resizeOnDemand($image,1500);
				if ($image->videoexternal()->isNotEmpty()) {
					// echo '<video class="js-player" poster="'.$poster.'" controls loop><source src="' . $image->videoexternal()  . '" type="video/mp4"></video>';
					echo '<video poster="'.$poster.'" width="100%" height="100%" controls="false" loop><source src=' . $image->videoexternal() . ' type="video/mp4"></video>';
				}
				else if ($image->videofile()->isNotEmpty()) {
					//echo '<video class="js-player" poster="'.$poster.'" controls loop><source src="' . $image->videofile()->toFile()->url()  . '" type="video/mp4"></video>';
					echo '<video poster="'.$poster.'" width="100%" height="100%" controls="false" loop><source src=' . $image->videofile()->toFile()->url() . ' type="video/mp4"></video>';
				} else {
					$url = $image->videolink();
					$headers = get_headers('https://www.youtube.com/oembed?format=json&url=http://www.youtube.com/watch?v=' . $url);
					if(is_array($headers) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$headers[0]) : false) {
					// is youtube
						$videoID = $url;
						echo '<div class="js-player" data-type="youtube" data-video-id="' . $videoID  . '"></div>';
					} else {
					// should be vimeo
						$videoID = $url;
						echo '<div class="js-player" data-type="vimeo" data-video-id="' . $videoID  . '"></div>';
					}
				}

				?>
			</div>
		<?php else: ?>
			<div class="content">
				<img class="lazyimg" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-flickity-lazyload="<?= resizeOnDemand($image, 1500, true) ?>" alt="<?= $title.' - © '.$site->title()->html() ?>" height="100%" width="auto" />
				<noscript>
					<img src="<?= resizeOnDemand($image, 1500) ?>" alt="<?= $title.' - © '.$site->title()->html() ?>" height="100%" width="auto" />
				</noscript>
			</div>
		<?php endif ?>

		</div>

	<?php endforeach ?>

	</div>
	
	<div id="project-description">
		<?= $description ?>
	</div>

	<div id="mouse-nav" class="<?php e($page->category() == 'print', 'back', 'play') ?>">
		<span class="arrow"></span>
		<span class="back"></span>
		<span class="play"></span>
		<span class="pause"></span>
	</div>

</div>

<?php snippet('footer') ?>