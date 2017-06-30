<?php snippet('header') ?>

<div id="page-content" class="projects">

	<div class="categories top">
		<?php foreach ($categories->flip() as $key => $category): ?>
			<div class="category active" data-category="<?= $category->uid() ?>">
				<?= $category->title()->html() ?>
			</div>
		<?php endforeach ?>
	</div>

	<div class="categories behind">
		<?php foreach ($categories->flip() as $key => $category): ?>
			<div class="category" data-category="<?= $category->uid() ?>">
				<?= $category->title()->html() ?>
			</div>
		<?php endforeach ?>
	</div>

	<div id="projects">

	<?php $positions = ['top','middle','bottom']; ?>

	<?php foreach ($categories as $key => $category): ?>

		<?php $projects = $category->children()->visible(); ?>

		<div class="category-grid" data-category="<?= $category->uid() ?>">

		<?php foreach ($projects as $key => $project): ?>

			<?php if($project->featured()->isNotEmpty()): ?>

				<?php 
				$featured = $project->featured()->toFile();
				$title = $project->title()->html();
				if ($project->subtitle()->isNotEmpty()) {
					$title .= '<span class="divider"></span>'.$project->subtitle()->html();
				}
				$position = $project->position();
				if ($position == 'pos-random') {
					$position = 'pos-'.$positions[array_rand($positions)];
				}
				?>

				<div class="project-item <?= $featured->orientation() ?> <?= $project->itemsize() ?> <?= $position ?>">

				<a href="<?= $project->url() ?>" data-target="<?= $project->category() ?>-project">

					<div class="project-image">
						<img 
						class="lazyimg lazyload" 
						src="<?= resizeOnDemand($featured, 600) ?>" 
						data-src="<?= resizeOnDemand($featured, 1300) ?>" 
						alt="<?= $project->title()->html().' - © '.$site->title()->html() ?>" 
						width="100%" height="auto" />
						<div class="item-marquee" data-speed="0.5" data-pausable="true">
							<span><?= $title ?></span>
						</div>
					</div>
					<div class="item-infos">
						<?= $title ?>
					</div>

				</a>
					
				</div>

			<?php endif ?>

		<?php endforeach ?>

		</div>

	<?php endforeach ?>

	</div>

</div>

<?php snippet('footer') ?>