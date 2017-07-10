<?php

return function ($site, $pages, $page) {
	$categories = $pages->visible()->filterBy('template', 'projects');
	$menuPage = $site->menupage()->toPage();
	$title = $page->title()->html();
	$subtitle = $page->subtitle();
	$formattedtitle = $title;
	if ($page->subtitle()->isNotEmpty()) {
		$formattedtitle .= '<span class="divider"></span>'.$page->subtitle()->html();
	}
	

	return array(
	'categories' => $categories,
	'menuPage' => $menuPage,
	'bodyClass' => 'project',
	'title' => $title,
	'formattedtitle' => $formattedtitle,
	'subtitle' => $subtitle->html(),
	'images' => $page->medias()->toStructure()
	);
}

?>
