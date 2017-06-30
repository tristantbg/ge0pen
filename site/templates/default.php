<?php snippet('header') ?>

<div id="page-content" class="services">
	
	<?php if($page->text()->isNotEmpty()): ?>
	<div class="services-item c-services">
		<h2><?= $site->title()->html() ?></h2>
		<?= $page->text()->kt() ?>
	</div>
	<?php endif ?>

</div>

<?php snippet('footer') ?>