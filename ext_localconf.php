<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'RealtynumberSearch',
	array(
		'Search' => 'realtynumber, save, reset',
	),
	// non-cacheable actions
	array(
		'Search' => 'realtynumber, save, reset',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'QuickSearch',
	array(
		'Search' => 'quick, save, reset',
	),
	// non-cacheable actions
	array(
		'Search' => 'quick, save, reset',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'DetailSearch',
	array(
		'Search' => 'detail, save, reset',
	),
	// non-cacheable actions
	array(
		'Search' => 'detail, save, reset',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'GeoFilterUpdateXHR',
	array(
		'Search' => 'updateSubdivisions,updateRegions'
	),
	array(
		'Search' => 'updateSubdivisions,updateRegions'
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'SearchResults',
	array(
		'Realty' => 'list, paginate, order',
	),
	// non-cacheable actions
	array(
		'Realty' => 'list, paginate, order',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'RealtyDetail',
	array(
		'Realty' => 'show, expose',
	),
	// non-cacheable actions
	array(
	)
);

$realurlAutoconfigurationHook = 'EXT:justimmo/Classes/Utility/RealurlAutoconfiguration.php:Tx_Justimmo_Utility_RealurlAutoconfiguration->addJustimmoConfig';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration']['justimmo'] = $realurlAutoconfigurationHook;
?>