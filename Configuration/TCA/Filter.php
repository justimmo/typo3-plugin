<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_justimmo_domain_model_filter'] = array(
	'ctrl' => $TCA['tx_justimmo_domain_model_filter']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, objektnummer, kauf, miete, objektart_id, preis_von, preis_bis, zimmer_von, zimmer_bis, wohnflaeche_von, wohnflaeche_bis, plz_von, plz_bis, ort, land_id, bundesland_id, region',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, objektnummer, kauf, miete, objektart_id, preis_von, preis_bis, zimmer_von, zimmer_bis, wohnflaeche_von, wohnflaeche_bis, plz_von, plz_bis, ort, land_id, bundesland_id, region,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_justimmo_domain_model_filter',
				'foreign_table_where' => 'AND tx_justimmo_domain_model_filter.pid=###CURRENT_PID### AND tx_justimmo_domain_model_filter.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'objektnummer' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:justimmo/Resources/Private/Language/locallang_db.xml:tx_justimmo_domain_model_filter.objektnummer',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'kauf' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:justimmo/Resources/Private/Language/locallang_db.xml:tx_justimmo_domain_model_filter.kauf',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'miete' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:justimmo/Resources/Private/Language/locallang_db.xml:tx_justimmo_domain_model_filter.miete',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'objektart_id' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:justimmo/Resources/Private/Language/locallang_db.xml:tx_justimmo_domain_model_filter.objektart_id',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('-- Label --', 0),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'preis_von' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:justimmo/Resources/Private/Language/locallang_db.xml:tx_justimmo_domain_model_filter.preis_von',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			),
		),
		'preis_bis' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:justimmo/Resources/Private/Language/locallang_db.xml:tx_justimmo_domain_model_filter.preis_bis',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			),
		),
		'zimmer_von' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:justimmo/Resources/Private/Language/locallang_db.xml:tx_justimmo_domain_model_filter.zimmer_von',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'zimmer_bis' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:justimmo/Resources/Private/Language/locallang_db.xml:tx_justimmo_domain_model_filter.zimmer_bis',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'wohnflaeche_von' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:justimmo/Resources/Private/Language/locallang_db.xml:tx_justimmo_domain_model_filter.wohnflaeche_von',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'wohnflaeche_bis' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:justimmo/Resources/Private/Language/locallang_db.xml:tx_justimmo_domain_model_filter.wohnflaeche_bis',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'plz_von' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:justimmo/Resources/Private/Language/locallang_db.xml:tx_justimmo_domain_model_filter.plz_von',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'plz_bis' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:justimmo/Resources/Private/Language/locallang_db.xml:tx_justimmo_domain_model_filter.plz_bis',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'ort' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:justimmo/Resources/Private/Language/locallang_db.xml:tx_justimmo_domain_model_filter.ort',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'land_id' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:justimmo/Resources/Private/Language/locallang_db.xml:tx_justimmo_domain_model_filter.land_id',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'bundesland_id' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:justimmo/Resources/Private/Language/locallang_db.xml:tx_justimmo_domain_model_filter.bundesland_id',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'region' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:justimmo/Resources/Private/Language/locallang_db.xml:tx_justimmo_domain_model_filter.region',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('-- Label --', 0),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
	),
);

?>