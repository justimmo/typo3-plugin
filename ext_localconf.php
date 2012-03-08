<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'RealtynumberSearch',
	array(
		'Search' => 'realtynumber'
	),
	// non-cacheable actions
	array(
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'QuickSearch',
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
	'DetailSearch',
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
	'DirectLinks',
	array(
		'Search' => 'direct',
	),
	// non-cacheable actions
	array(
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'SearchResults',
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
	'RealtyDetail',
	array(
		'Realty' => 'show',
	),
	// non-cacheable actions
	array(
	)
);

?>