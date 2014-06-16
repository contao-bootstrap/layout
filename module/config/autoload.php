<?php

\TemplateLoader::addFiles(array(
	'block_jumbotron' => 'system/modules/bootstrap-layout/templates',
));

if(version_compare(VERSION, '3.3', '<')) {
	\TemplateLoader::addFiles(array(
		'fe_bootstrap' => 'system/modules/bootstrap-layout/templates/3.2' ,
		'block_section' => 'system/modules/bootstrap-layout/templates/layout',
		'block_sections' => 'system/modules/bootstrap-layout/templates/layout',
	));
}
else {
	\TemplateLoader::addFile('fe_bootstrap', 'system/modules/bootstrap-layout/templates/3.3');
}