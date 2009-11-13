<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$TCA['tx_takojqgalerie_images'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:tako_jq_galerie/locallang_db.xml:tx_takojqgalerie_images',		
		'label'     => 'uid',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_takojqgalerie_images.gif',
	),
);


t3lib_div::loadTCA('tt_content');
//$TCA['tt_content']['types'][$_EXTKEY . '_pi1']['showitem'] = 'CType;;4;button;1-1-1, header;;3;;2-2-2';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1']='pi_flexform'; 
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1'] ='layout,select_key,pages';
t3lib_extMgm::addPlugin(Array('LLL:EXT:/locallang_db.php:tt_content.list_type_pi1', $_EXTKEY.'_pi1'),'list_type');
t3lib_extMgm::addStaticFile($_EXTKEY,"pi1/static/","A Sample Flexform Plugin");
t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_pi1', 'FILE:EXT:'.$_EXTKEY.'/flexform_ds_pi1.xml');            // new!
if (TYPO3_MODE=="BE")   $TBE_MODULES_EXT["xMOD_db_new_content_el"]["addElClasses"]["tx_takoqype_pi1_wizicon"] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_takoqype_pi1_wizicon.php';


/*
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:tako_jq_galerie/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_takojqgalerie_pi1_wizicon'] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_takojqgalerie_pi1_wizicon.php';
}

$TCA['tx_takojqgalerie_images'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:tako_jq_galerie/locallang_db.xml:tx_takojqgalerie_images',		
		'label'     => 'uid',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_takojqgalerie_images.gif',
	),
);

$TCA['tt_content']['types'][$_EXTKEY.'_pi1']['showitem']='header;;3;;2-2-2,pi_flexform;;;;1-1-1'; // new!

$TCA['tt_content']['columns']['pi_flexform']['config']['ds'][','.$_EXTKEY.'_pi1'] = 'FILE:EXT:'.$_EXTKEY.'/flexform_ds_pi1.xml'; // new! 
*/

include_once(t3lib_extMgm::extPath($_EXTKEY).'lib/class.tx_takojqgalerie_tca.php');
?>