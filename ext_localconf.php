<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Quicksearch',
	array(
		'Realty' => 'list, show',
		
	),
	// non-cacheable actions
	array(
		'Realty' => '',
		
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Detailsearch',
	array(
		'Realty' => 'list, show',
		
	),
	// non-cacheable actions
	array(
		'Realty' => '',
		
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Directlinks',
	array(
		'Realty' => 'list, show',
		
	),
	// non-cacheable actions
	array(
		'Realty' => '',
		
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'List',
	array(
		'Realty' => 'list, show',
		
	),
	// non-cacheable actions
	array(
		'Realty' => '',
		
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Detail',
	array(
		'Realty' => 'list, show',
		
	),
	// non-cacheable actions
	array(
		'Realty' => '',
		
	)
);

?>