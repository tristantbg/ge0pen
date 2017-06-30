<?php

return function ($site, $pages, $page) {
	$menuPage = $site->menupage()->toPage();
	$title = $page->title()->html();
	$subtitle = $page->subtitle();
	

	return array(
	'menuPage' => $menuPage,
	'bodyClass' => 'project',
	'title' => $title,
	'subtitle' => $subtitle->html(),
	'images' => $page->medias()->toStructure()
	);
}

?>
