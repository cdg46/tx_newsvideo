<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$tempColumns = array (
	'tx_newsvideo_width' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:tx_newsvideo/locallang_db.xml:tt_news.tx_newsvideo_width',		
		'config' => array (
			'type' => 'input',
			'size' => 4,	
			'eval' => 'numeric',
		)
	),
	'tx_newsvideo_height' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:tx_newsvideo/locallang_db.xml:tt_news.tx_newsvideo_height',		
		'config' => array (
			'type' => 'input',
			'size' => 4,	
			'eval' => 'numeric',
		)
	),
);

t3lib_div::loadTCA('tt_news');
t3lib_extMgm::addTCAcolumns('tt_news',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('tt_news','tx_newsvideo_width;;;;1-1-1, tx_newsvideo_height');
?>
