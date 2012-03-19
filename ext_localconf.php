<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'RealtynumberSearch',
	array(
		'Search' => 'realtynumber',
	),
	// non-cacheable actions
	array(
		'Search' => 'realtynumber',
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
		'Search' => 'quick',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'DirectSearch',
	array(
		'Search' => 'direct',
	),
	// non-cacheable actions
	array(
		'Search' => 'direct',
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
		'Search' => 'detail',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'SearchResults',
	array(
		'Realty' => 'list, reset, paginate, order',
	),
	// non-cacheable actions
	array(
		'Realty' => 'list, reset, paginate, order',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'RealtyDetail',
	array(
		'Realty' => 'show, showPosition',
	),
	// non-cacheable actions
	array(
		'Realty' => '',
	)
);
?>