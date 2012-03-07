<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Quicksearch',
	array(
		'Search' => 'quick',
	),
	// non-cacheable actions
	array(
		// non-cacheable because of (probably) dynamic countries/regions
		'Search' => 'quick',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Detailsearch',
	array(
		'Search' => 'detail',
	),
	// non-cacheable actions
	array(
		// non-cacheable becase of (probably) dynamic countries/regions
		'Search' => 'detail',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Directlinks',
	array(
		'Search' => 'direct',
	),
	// non-cacheable actions
	array(
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'List',
	array(
		'Search' => 'list',
	),
	// non-cacheable actions
	array(
		// a search result is always non-cached!
		'Search' => 'list',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Detail',
	array(
		'Realty' => 'show',
	),
	// non-cacheable actions
	array(
	)
);

?>