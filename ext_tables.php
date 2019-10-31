<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$tempColumns = Array (
	'tx_pobdir_directory' => Array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:pobdir/locallang_db.php:fe_users.tx_pobdir_directory',		
		'config' => Array (
			'type' => 'check',
			'default' => 1,
		)
	),
);


t3lib_div::loadTCA('fe_users');
t3lib_extMgm::addTCAcolumns('fe_users',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('fe_users','tx_pobdir_directory;;;;1-1-1');


t3lib_extMgm::allowTableOnStandardPages('tx_pobdir_entry');

$TCA['tx_pobdir_entry'] = Array (
	'ctrl' => Array (
		'title' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry',		
		'label' => 'name',	
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY name',	
		'delete' => 'deleted',	
		'enablecolumns' => Array (		
			'disabled' => 'hidden',	
			'starttime' => 'starttime',	
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_pobdir_entry.gif',
	),
	'feInterface' => Array (
		'fe_admin_fieldList' => 'hidden, starttime, endtime, name, street, zip, city, tel, fax, email, www, profile, image, category, belongsto, do_not_filter, mindestaufenthalt, pdf_info',
	)
);


t3lib_extMgm::allowTableOnStandardPages('tx_pobdir_category');

$TCA['tx_pobdir_category'] = Array (
	'ctrl' => Array (
		'title' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_category',		
		'label' => 'name',	
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY sorting',	
		'delete' => 'deleted',	
		'enablecolumns' => Array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_pobdir_category.gif',
	),
	'feInterface' => Array (
		'fe_admin_fieldList' => 'hidden, name',
	)
);

                                         
t3lib_extMgm::allowTableOnStandardPages('tx_pobdir_ad');

$TCA['tx_pobdir_ad'] = Array (
	'ctrl' => Array (
		'title' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_ad',		
		'label' => 'name',	
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY name',	
		'delete' => 'deleted',
    'enablecolumns' => Array (		
			'disabled' => 'hidden',
		),	
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_pobdir_entry.gif',
	),
	'feInterface' => Array (
		'fe_admin_fieldList' => 'name, ad',
	)
);

t3lib_extMgm::allowTableOnStandardPages('tx_pobdir_feature');

$TCA['tx_pobdir_feature'] = Array (
	'ctrl' => Array (
		'title' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_feature',		
		'label' => 'name',	
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY name',	
		'delete' => 'deleted',
    'enablecolumns' => Array (		
			'disabled' => 'hidden',
		),	
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_pobdir_entry.gif',
	),
	'feInterface' => Array (
		'fe_admin_fieldList' => 'hidden, name, pikto, title',
	)
);

t3lib_extMgm::allowTableOnStandardPages('tx_pobdir_sperrzeiten');

$TCA['tx_pobdir_sperrzeiten'] = Array (
	'ctrl' => Array (
		'title' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_sperrzeiten',		
		'label' => 'name',	
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY entry_uid',	
		'delete' => 'deleted',
    'enablecolumns' => Array (		
			'disabled' => 'hidden',
		),	
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_pobdir_entry.gif',
	),
	'feInterface' => Array (
		'fe_admin_fieldList' => 'entry_uid,deleted,gesperrt_von,gesperrt_bis',
	)
);


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(Array('LLL:EXT:pobdir/locallang_db.php:tt_content.list_type', $_EXTKEY.'_pi1'),'list_type');


if (TYPO3_MODE=='BE')	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_pobdir_pi1_wizicon'] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_pobdir_pi1_wizicon.php';

