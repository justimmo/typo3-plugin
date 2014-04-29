<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "justimmo".
 *
 * Auto generated 01-09-2013 21:39
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'justimmo.at Real estate plugin',
	'description' => 'Allows querying the justimmo.at API. It provides a search interface, list and detail view.',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '1.0.8',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Thomas Juhnke',
	'author_email' => 'tommy@van-tomas.de',
	'author_company' => 'B&G Consulting & Commerce GmbH <office@bgcc.at>',
	'CGLcompliance' => NULL,
	'CGLcompliance_note' => NULL,
	'constraints' => 
	array (
		'depends' => 
		array (
			'extbase' => '1.3.0',
			'fluid' => '1.3.0',
			'static_info_tables' => '2.3.0',
			'typo3' => '4.5.0-6.2.1',
		),
		'conflicts' => '',
		'suggests' => 
		array (
		),
	),
);

?>
