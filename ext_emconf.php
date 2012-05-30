<?php

########################################################################
# Extension Manager/Repository config file for ext "justimmo".
#
# Auto generated 30-05-2012 09:48
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'justimmo.at Real estate plugin',
	'description' => 'Allows querying the justimmo.at API. It provides a search interface, list and detail view.',
	'category' => 'plugin',
	'author' => 'Thomas Juhnke',
	'author_email' => 'tommy@van-tomas.de',
	'author_company' => 'B&G Consulting & Commerce GmbH <office@bgcc.at>',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '0.0.0',
	'constraints' => array(
		'depends' => array(
			'extbase' => '1.3.0',
			'fluid' => '1.3.0',
			'static_info_tables' => '2.3.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:76:{s:21:"ExtensionBuilder.json";s:4:"1e03";s:6:"README";s:4:"72f1";s:12:"ext_icon.gif";s:4:"7290";s:17:"ext_localconf.php";s:4:"dcec";s:14:"ext_tables.php";s:4:"36a1";s:14:"ext_tables.sql";s:4:"d41d";s:39:"Classes/Controller/RealtyController.php";s:4:"e919";s:39:"Classes/Controller/SearchController.php";s:4:"aae8";s:58:"Classes/Core/ViewHelper/JustimmoGeoViewHelperInterface.php";s:4:"8243";s:63:"Classes/Core/ViewHelper/StaticInfoTablesViewHelperInterface.php";s:4:"a42f";s:31:"Classes/Domain/Model/Filter.php";s:4:"49ef";s:30:"Classes/Domain/Model/Order.php";s:4:"6f78";s:31:"Classes/Domain/Model/Realty.php";s:4:"8542";s:46:"Classes/Domain/Repository/RealtyRepository.php";s:4:"adae";s:44:"Classes/Domain/Validator/FilterValidator.php";s:4:"8e98";s:43:"Classes/MVC/Controller/ActionController.php";s:4:"6f14";s:38:"Classes/Service/JustimmoApiService.php";s:4:"412d";s:50:"Classes/Service/StaticInfoTablesApiInitService.php";s:4:"4139";s:31:"Classes/Service/UserService.php";s:4:"4554";s:44:"Classes/Utility/RealurlAutoconfiguration.php";s:4:"0eb7";s:39:"Classes/ViewHelpers/PagerViewHelper.php";s:4:"de08";s:61:"Classes/ViewHelpers/JustimmoGeo/SelectCountriesViewHelper.php";s:4:"4c44";s:64:"Classes/ViewHelpers/JustimmoGeo/SelectSubDivisionsViewHelper.php";s:4:"8c67";s:59:"Classes/ViewHelpers/StaticInfoTables/InfoNameViewHelper.php";s:4:"9db3";s:66:"Classes/ViewHelpers/StaticInfoTables/SelectCountriesViewHelper.php";s:4:"31fe";s:44:"Configuration/ExtensionBuilder/settings.yaml";s:4:"a9d7";s:38:"Configuration/TypoScript/constants.txt";s:4:"5538";s:34:"Configuration/TypoScript/setup.txt";s:4:"52df";s:40:"Resources/Private/Language/locallang.xml";s:4:"4052";s:76:"Resources/Private/Language/locallang_csh_tx_justimmo_domain_model_filter.xml";s:4:"5953";s:76:"Resources/Private/Language/locallang_csh_tx_justimmo_domain_model_realty.xml";s:4:"b87d";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"10a9";s:38:"Resources/Private/Layouts/Default.html";s:4:"9b0c";s:42:"Resources/Private/Partials/FormErrors.html";s:4:"004e";s:55:"Resources/Private/Partials/Realty/DetailNavigation.html";s:4:"d7de";s:51:"Resources/Private/Partials/Realty/ListControls.html";s:4:"ed10";s:44:"Resources/Private/Partials/Realty/Pager.html";s:4:"7553";s:49:"Resources/Private/Partials/Realty/Properties.html";s:4:"feb6";s:44:"Resources/Private/Templates/Realty/List.html";s:4:"3eb9";s:45:"Resources/Private/Templates/Realty/Order.html";s:4:"a9b7";s:48:"Resources/Private/Templates/Realty/Paginate.html";s:4:"a9b7";s:44:"Resources/Private/Templates/Realty/Show.html";s:4:"fc03";s:46:"Resources/Private/Templates/Search/Detail.html";s:4:"9197";s:45:"Resources/Private/Templates/Search/Quick.html";s:4:"61a0";s:52:"Resources/Private/Templates/Search/Realtynumber.html";s:4:"b87b";s:38:"Resources/Public/Css/bootstrap.min.css";s:4:"1abf";s:32:"Resources/Public/Css/default.css";s:4:"1723";s:31:"Resources/Public/Css/detail.css";s:4:"9864";s:29:"Resources/Public/Css/list.css";s:4:"e049";s:38:"Resources/Public/Css/search_detail.css";s:4:"d507";s:37:"Resources/Public/Css/search_quick.css";s:4:"e1b1";s:36:"Resources/Public/Icons/asc_arrow.gif";s:4:"fe07";s:37:"Resources/Public/Icons/desc_arrow.gif";s:4:"b35b";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:58:"Resources/Public/Icons/tx_justimmo_domain_model_filter.gif";s:4:"4e5b";s:58:"Resources/Public/Icons/tx_justimmo_domain_model_realty.gif";s:4:"905a";s:34:"Resources/Public/Js/google_maps.js";s:4:"862b";s:36:"Resources/Public/Js/search_detail.js";s:4:"32c0";s:46:"Tests/Unit/Controller/FilterControllerTest.php";s:4:"05e6";s:46:"Tests/Unit/Controller/RealtyControllerTest.php";s:4:"94b4";s:38:"Tests/Unit/Domain/Model/FilterTest.php";s:4:"2f9f";s:38:"Tests/Unit/Domain/Model/RealtyTest.php";s:4:"577f";s:14:"doc/fig001.png";s:4:"fd5d";s:14:"doc/fig002.png";s:4:"f17f";s:14:"doc/fig003.png";s:4:"5926";s:14:"doc/fig004.png";s:4:"3541";s:14:"doc/fig005.png";s:4:"7f21";s:14:"doc/fig006.png";s:4:"5365";s:14:"doc/fig007.png";s:4:"a080";s:14:"doc/fig008.png";s:4:"6638";s:14:"doc/fig009.png";s:4:"c5d4";s:14:"doc/fig010.png";s:4:"0709";s:14:"doc/fig011.png";s:4:"a1db";s:14:"doc/fig012.png";s:4:"7682";s:14:"doc/manual.pdf";s:4:"f175";s:14:"doc/manual.sxw";s:4:"a25a";}',
);

?>