<!DOCTYPE html>
<html lang="en" class="no-js">
<head>

	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="dns-prefetch" href="//www.google-analytics.com">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="canonical" href="<?php echo html($page->url()) ?>" />
	<?php if($page->isHomepage()): ?>
		<title><?= $site->title()->html() ?></title>
	<?php else: ?>
		<title><?= $page->title()->html() ?> | <?= $site->title()->html() ?></title>
	<?php endif ?>
	<?php if($page->isHomepage()): ?>
		<meta name="description" content="<?= $site->description()->html() ?>">
	<?php else: ?>
		<meta name="DC.Title" content="<?= $page->title()->html() ?>" />
		<?php if(isset($description)): ?>
			<meta name="description" content="<?= $description ?>">
			<meta name="DC.Description" content="<?= $description ?>"/ >
			<meta property="og:description" content="<?= $description ?>" />
		<?php elseif(!$page->text()->empty()): ?>
			<meta name="description" content="">
			<meta name="DC.Description" content=""/ >
			<meta property="og:description" content="" />
		<?php else: ?>
			<meta name="description" content="">
			<meta name="DC.Description" content=""/ >
			<meta property="og:description" content="" />
		<?php endif ?>
	<?php endif ?>
	<meta name="robots" content="index,follow" />
	<meta name="keywords" content="<?= $site->keywords()->html() ?>">
	<?php if($page->isHomepage()): ?>
		<meta itemprop="name" content="<?= $site->title()->html() ?>">
		<meta property="og:title" content="<?= $site->title()->html() ?>" />
	<?php else: ?>
		<meta itemprop="name" content="<?= $page->title()->html() ?> | <?= $site->title()->html() ?>">
		<meta property="og:title" content="<?= $page->title()->html() ?> | <?= $site->title()->html() ?>" />
	<?php endif ?>
	<meta property="og:type" content="website" />
	<meta property="og:url" content="<?= html($page->url()) ?>" />
	<?php if($page->content()->name() == "project"): ?>
		<?php if (!$page->featured()->empty()): ?>
			<meta property="og:image" content="<?= resizeOnDemand($page->image($page->featured()), 1200) ?>"/>
		<?php endif ?>
	<?php else: ?>
		<?php if(!$site->ogimage()->empty()): ?>
			<meta property="og:image" content="<?= $site->ogimage()->toFile()->width(1200)->url() ?>"/>
		<?php endif ?>
	<?php endif ?>

	<meta itemprop="description" content="<?= $site->description()->html() ?>">
	<!-- <link rel="shortcut icon" href="<?php //url('assets/images/favicon.ico') ?>">
	<link rel="icon" href="<?php //url('assets/images/favicon.ico') ?>" type="image/x-icon"> -->

	<?php 
	echo css('assets/css/build/build.min.css');
	echo js('assets/js/vendor/modernizr.min.js');
	?>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?= url('assets/js/vendor/jquery.min.js') ?>">\x3C/script>')</script>

	<?php if(!$site->customcss()->empty()): ?>
		<style type="text/css">
			<?php echo $site->customcss()->html() ?>
		</style>
	<?php endif ?>

</head>

<body class="<?= $bodyClass ?><?php e($page->isHomepage(),' intro') ?>">

<div id="outdated">
	<div class="inner">
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser.
	<br>Please <a href="http://outdatedbrowser.com" target="_blank">upgrade your browser</a> to improve your experience.</p>
	</div>
</div>

<div class="loader">
</div>

<div id="intro">
	<div class="slider-intro">
		<?php $idx = 0 ?>
		<?php foreach ($site->homepage()->featured()->toStructure()->shuffle() as $key => $image): ?>
			<?php $image = $image->toFile(); ?>
				<div class="slide">
					<div class="content">
						<img class="lazyimg lazyload lazypreload" src="<?= resizeOnDemand($image, 1200) ?>" width="100%" height="auto" />
					</div>
				</div>
		<?php $idx++ ?>
		<?php endforeach ?>
	</div>
</div>

<div id="main">

<?php $positions = ['left','center','right'] ?>

<header>
	<div id="back"><a href="<?= $site->url() ?>" data-target="projects"></a></div>
	<div id="site-title">
		<a href="<?= $site->url() ?>" data-target="projects" event-target="intro-change">
			<?= $site->title()->html() ?>
		</a>
	</div>
	<div class="menu-item <?= $positions[array_rand($positions)] ?>" event-target="intro-change">
		<a href="<?= $site->url() ?>" data-target="projects">
			<?= $site->homepage()->title()->html() ?>
		</a>
	</div>
	<?php if($menuPage && $menuPage->isNotEmpty()): ?>
	<div class="menu-item <?= $positions[array_rand($positions)] ?>">
		<a href="<?= $menuPage->url() ?>" data-target="default">
			<?= $menuPage->title()->html() ?>
		</a>
	</div>
	<?php endif ?>
	<?php if($site->daily()->isNotEmpty()): ?>
	<div class="menu-item <?= $positions[array_rand($positions)] ?>">
		<a href="<?= $site->daily() ?>" target="_blank" rel="nofollow">
			Daily
		</a>
	</div>
	<?php endif ?>
</header>

<div id="categories">
	<?php foreach ($categories->flip() as $key => $category): ?>
		<div class="category" data-category="<?= $category->uid() ?>">
			<div data-category="<?= $category->uid() ?>"><?= $category->title()->html() ?></div>
		</div>
	<?php endforeach ?>
</div>

<div id="container">