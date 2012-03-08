<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'RealtynumberSearch',
	'LLL:EXT:justimmo/Resources/Private/Language/locallang.xml:realtynumber_search'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'QuickSearch',
	'LLL:EXT:justimmo/Resources/Private/Language/locallang.xml:quick_search'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'DetailSearch',
	'LLL:EXT:justimmo/Resources/Private/Language/locallang.xml:detail_search'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'DirectLinks',
	'LLL:EXT:justimmo/Resources/Private/Language/locallang.xml:direct_links'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'SearchResults',
	'LLL:EXT:justimmo/Resources/Private/Language/locallang.xml:search_results'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'RealtyDetail',
	'LLL:EXT:justimmo/Resources/Private/Language/locallang.xml:realty_detail'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'justimmo.at Real estate plugin');

t3lib_extMgm::addLLrefForTCAdescr('tx_justimmo_domain_model_realty', 'EXT:justimmo/Resources/Private/Language/locallang_csh_tx_justimmo_domain_model_realty.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_justimmo_domain_model_realty');
$TCA['tx_justimmo_domain_model_realty'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:justimmo/Resources/Private/Language/locallang_db.xml:tx_justimmo_domain_model_realty',
		'label' => 'uid',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Realty.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_justimmo_domain_model_realty.gif'
	),
);

?>