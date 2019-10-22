<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "pobdir".
 *
 * Auto generated 30-07-2014 16:51
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'pobdir',
	'description' => 'Adds a pobdir-directory to the page.',
	'category' => 'plugin',
	'shy' => 0,
	'dependencies' => 'cms',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => 0,
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => 'fe_users',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author' => 'POB',
	'author_email' => 'info@pob.com',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'version' => '1.0.0',
	'_md5_values_when_last_written' => 'a:20:{s:12:"ext_icon.gif";s:4:"c4ea";s:17:"ext_localconf.php";s:4:"8e23";s:14:"ext_tables.php";s:4:"b832";s:14:"ext_tables.sql";s:4:"2287";s:28:"ext_typoscript_constants.txt";s:4:"557a";s:28:"ext_typoscript_editorcfg.txt";s:4:"5ff4";s:24:"ext_typoscript_setup.txt";s:4:"812e";s:35:"icon_tx_pobdir_category.gif";s:4:"dc05";s:32:"icon_tx_pobdir_entry.gif";s:4:"475a";s:13:"locallang.php";s:4:"364c";s:16:"locallang_db.php";s:4:"7710";s:7:"tca.php";s:4:"2904";s:19:"doc/wizard_form.dat";s:4:"302f";s:20:"doc/wizard_form.html";s:4:"b7bc";s:14:"pi1/ce_wiz.gif";s:4:"8b5f";s:35:"pi1/class.tx_pobdir_pi1.php";s:4:"e431";s:43:"pi1/class.tx_pobdir_pi1_wizicon.php";s:4:"352a";s:13:"pi1/clear.gif";s:4:"cc11";s:17:"pi1/locallang.php";s:4:"59cb";s:16:"pi1/template.htm";s:4:"ecdd";}',
	'constraints' => 
	array (
		'depends' => 
		array (
			'cms' => '',
			'php' => '3.0.0-0.0.0',
			'typo3' => '3.5.0-0.0.0',
		),
		'conflicts' => 
		array (
		),
		'suggests' => 
		array (
		),
	),
	'suggests' => 
	array (
	),
);

?>