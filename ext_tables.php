<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$tempColumns = array (
	'tx_newsvideo_ratio' => array (
		'exclude' => 0,		
		'label' => 'LLL:EXT:tx_newsvideo/locallang_db.xml:tx_newsvideo_ratio',		
		'config' => array (
			'type' => 'input',
			'size' => 5,
			'eval' => 'text',
		)
	),
);

t3lib_div::loadTCA('tt_news');
t3lib_extMgm::addTCAcolumns('tt_news',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('tt_news','tx_newsvideo_ratio;;;;');
t3lib_div::loadTCA('tx_news');
t3lib_extMgm::addTCAcolumns('tx_news',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('tx_news','tx_newsvideo_ratio;;;;');
?>
