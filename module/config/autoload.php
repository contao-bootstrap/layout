<?php

\TemplateLoader::addFiles(array(
	'fe_bootstrap' => 'system/modules/bootstrap-layout/templates',
	'block_jumbotron' => 'system/modules/bootstrap-layout/templates',
));

if(version_compare(VERSION, '3.3', '<')) {
	\TemplateLoader::addFiles(array(
		'block_section' => 'system/modules/bootstrap-layout/templates/layout',
		'block_sections' => 'system/modules/bootstrap-layout/templates/layout',
	));
}