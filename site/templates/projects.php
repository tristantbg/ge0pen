<?php snippet('header') ?>

<div id="page-content" class="projects">

	<?php foreach ($projects as $key => $project): ?>

		<?php if($project->featured()->isNotEmpty()): ?>

		<?php $featured = $project->featured()->toFile() ?>

		<?php
		//Tag list
		$taglist = $project->tags();
		$separator = (count($taglist->split(',')) == 2 ? ' & ' : ', ');
		$tags = '';

		if ($taglist->isNotEmpty()) {
			foreach ($taglist->split(',') as $key => $tag) {
				if ($key > 0):
				{
					$tags .= $separator;
				}
				endif;
				$tags .= ucfirst($tag);
			}
		}
		?>

			<div class="project-item <?= $featured->orientation() ?> <?= $project->category() ?>">

			<a href="<?= $project->url() ?>" data-target="<?= $project->category() ?>-project">

				<div class="project-image">
					<img 
					class="lazyimg lazyload" 
					src="<?= $featured->width(600)->url() ?>" 
					data-src="<?= $featured->width(1300)->url() ?>" 
					alt="<?= $project->title()->html().' - © '.$site->title()->html() ?>" 
					width="100%" height="auto" />
					<?php if($project->category() == 'motion'): ?>
					<div class="item-infos motion-overlay">
						<div class="frame">
							<div class="frame"></div>
						</div>
						<div class="cross">
							<span></span>
							<span></span>
						</div>
					</div>
					<?php endif ?>
					<div class="item-infos top">
						<?= $project->title()->html() ?>
					</div>
					<div class="item-infos right">
						<?= $tags ?>
					</div>
					<div class="item-infos bottom">
						<?= $project->subtitle()->html() ?>
					</div>
					<div class="item-infos left">
						<?= $project->category()->html() ?>
					</div>
				</div>

			</a>
				
			</div>

		<?php endif ?>

	<?php endforeach ?>

	<?php if($projects->pagination()->hasPages()): ?>
	<!-- pagination -->
	<nav id="pagination">

	  <?php if($projects->pagination()->hasNextPage()): ?>
	  <a class="next" href="<?php echo $projects->pagination()->nextPageURL() ?>"><h2>Previous</h2></a>
	  <?php endif ?>

	  <?php if($projects->pagination()->hasPrevPage()): ?>
	  <a class="prev" href="<?php echo $projects->pagination()->prevPageURL() ?>"><h2>Next</h2></a>
	  <?php endif ?>

	</nav>
	<?php endif ?>

</div>

<?php snippet('footer') ?>