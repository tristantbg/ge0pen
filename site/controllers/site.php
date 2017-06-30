<?php

return function ($site, $pages, $page) {
	$menuPage = $site->menupage()->toPage();
	$categories = $pages->visible()->filterBy('template', 'projects');
	//$projects = $categories->grandChildren()->visible();
	$pTemplate = $page->intendedTemplate();
	$bodyClass = $pTemplate;
	return array(
	'menuPage' => $menuPage,
	'bodyClass' => $bodyClass,
	'categories' => $categories
	);
}

?>
