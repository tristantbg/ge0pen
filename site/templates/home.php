<?php snippet('header') ?>

<div id="page-content" class="projects">

	<div id="projects">

	<?php $positions = ['top','middle','bottom']; ?>

	


	<?php foreach ($categories as $key => $category): ?>

		<?php $projects = $category->children()->visible(); ?>

		<div id="grid-<?= $category->uid() ?>" class="category-grid" data-category="<?= $category->uid() ?>">

		<?php foreach ($projects as $key => $project): ?>

			<?php if($project->featured()->isNotEmpty()): ?>

				<?php 
				$featured = $project->featured()->toFile();
				$title = $project->title()->html();
				if ($project->subtitle()->isNotEmpty()) {
					$title .= '<span class="divider"></span>'.$project->subtitle()->html();
				}
				$titleEscape = $project->title()->escape();
				if ($project->subtitle()->isNotEmpty()) {
					$titleEscape .= '<span class=&quot;divider&quot;></span>'.$project->subtitle()->escape();
				}
				$position = $project->position();
				if ($position == 'pos-random') {
					$position = 'pos-'.$positions[array_rand($positions)];
				}
				$size = $project->size();
				if ($size == 'random') {
					$size = 'size-'.rand(1,3);
				}
				$srcset = '';
				for ($i = 500; $i <= 2000; $i += 500) $srcset .= resizeOnDemand($featured, $i) . ' ' . $i . 'w,';
				?>

				<div class="project-item <?= $featured->orientation() ?> <?= 'size-'.$size ?> <?= $position ?>">

				<a href="<?= $project->url() ?>" data-target="project">

					<div class="project-image" data-id="<?= $project->uid() ?>" data-marquee="<?= $titleEscape ?>">
						<img 
						class="lazyimg lazyload lazypreload" 
						src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" 
						src="<?= resizeOnDemand($featured, 100) ?>" 
						data-src="<?= resizeOnDemand($featured, 1500) ?>" 
						data-srcset="<?= $srcset ?>" 
						data-sizes="auto" 
						data-optimumx="1.5" 
						alt="<?= $project->title()->html().' - © '.$site->title()->html() ?>" 
						width="100%" height="auto" />
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