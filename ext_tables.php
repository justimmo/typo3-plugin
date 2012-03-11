<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'RealtynumberSearch',
	'LLL:EXT:justimmo/Resources/Private/Language/locallang.xml:plugin.name.realtynumber_search'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'QuickSearch',
	'LLL:EXT:justimmo/Resources/Private/Language/locallang.xml:plugin.name.quick_search'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'DirectSearch',
	'LLL:EXT:justimmo/Resources/Private/Language/locallang.xml:plugin.name.direct_links'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'DetailSearch',
	'LLL:EXT:justimmo/Resources/Private/Language/locallang.xml:plugin.name.detail_search'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'SearchResults',
	'LLL:EXT:justimmo/Resources/Private/Language/locallang.xml:plugin.name.search_results'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'RealtyDetail',
	'LLL:EXT:justimmo/Resources/Private/Language/locallang.xml:plugin.name.realty_detail'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'justimmo.at Real estate plugin');
?>