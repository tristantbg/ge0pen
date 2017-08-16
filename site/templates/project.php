<?php snippet('header') ?>

<div id="page-content" class="project <?= $page->category() ?>">
	
	<div class="slider">
	
	<?php $idx = 0 ?>
	<?php $duo = false ?>

	<?php foreach ($images as $key => $image): ?>
		
		<?php if(!$duo): ?>

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
					echo '<video class="js-player" poster="'.$poster.'" width="100%" height="100%" controls="false" loop><source src=' . $image->videoexternal() . ' type="video/mp4"></video>';
				}
				else if ($image->videofile()->isNotEmpty()) {
					echo '<video class="js-player" poster="'.$poster.'" width="100%" height="100%" controls="false" loop><source src=' . $image->videofile()->toFile()->url() . ' type="video/mp4"></video>';
				} else {
					$url = $image->videolink();
					// $headers = get_headers('https://www.youtube.com/oembed?format=json&url=http://www.youtube.com/watch?v=' . $url);
					// if(is_array($headers) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$headers[0]) : false) {
					// // is youtube
					// 	$videoID = $url;
					// 	echo '<div class="js-player" data-type="youtube" data-video-id="' . $videoID  . '"></div>';
					// } else {
					// // should be vimeo
					// 	$videoID = $url;
					// 	echo '<div class="js-player" data-type="vimeo" data-video-id="' . $videoID  . '"></div>';
					// }
					if ($image->vendor() == "youtube") {
						echo '<div class="js-player" data-type="youtube" data-video-id="' . $url  . '"></div>';
					} else {
						echo '<div class="js-player" data-type="vimeo" data-video-id="' . $url  . '"></div>';
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
				<?php if($image->duo()->bool()): ?>
					<?php $imageduo = $images->get($idx+1)->toFile() ?>
					<?php if($imageduo): ?>
					<?php $duo = true ?>
					<img class="lazyimg" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-flickity-lazyload="<?= resizeOnDemand($imageduo, 1500, true) ?>" alt="<?= $title.' - © '.$site->title()->html() ?>" height="100%" width="auto" />
					<noscript>
						<img src="<?= resizeOnDemand($imageduo, 1500) ?>" alt="<?= $title.' - © '.$site->title()->html() ?>" height="100%" width="auto" />
					</noscript>
					<?php endif ?>
				<?php endif ?>
				
			</div>
		<?php endif ?>

		</div>

		<?php else: ?>
		<?php $duo = false ?>
		<?php endif ?>

	<?php $idx++ ?>
	<?php endforeach ?>

	</div>
	
	<div class="overview-nav">
		<div class="top-bar" event-target="overview">
			<div class="job-title"><?= $page->jobtitle()->html() ?></div>
			<div class="project-title"><?= $formattedtitle ?></div>
			<div class="overview"></div>
		</div>
		<div class="slider-nav">
			<?php $idx = 0 ?>
			<?php $duo = false ?>
			<?php foreach ($images as $key => $image): ?>

			<?php if(!$duo): ?>

			<?php $image = $image->toFile(); ?>
			<div class="slide">
				<img class="lazyimg lazyload lazypreload" src="<?= thumb($image, array('height' => 300))->url() ?>" height="100%" width="auto" />
				<?php if($image->duo()->bool()): ?>
					<?php $imageduo = $images->get($idx+1)->toFile() ?>
					<?php if($imageduo): ?>
					<?php $duo = true ?>
					<img class="lazyimg lazyload lazypreload" src="<?= thumb($imageduo, array('height' => 300))->url() ?>" height="100%" width="auto" />
					<?php endif ?>
				<?php endif ?>
			</div>
			
			<?php else: ?>
			<?php $duo = false ?>
			<?php endif ?>

			<?php $idx++ ?>
			<?php endforeach ?>

		</div>
	</div>

</div>

<?php snippet('footer') ?>