<?php

/** @var \Pimple $container */
$container = $GLOBALS['container'];

$container['bootstrap.page-layout'] = $container->share(function(Pimple $container) {
	global $objPage;

	if($objPage !== null) {
		return \LayoutModel::findByPk($objPage->layout);
	}

	return null;
});