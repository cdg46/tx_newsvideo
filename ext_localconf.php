<?php
if (!defined ('TYPO3_MODE')) {
     die ('Access denied.');
}

t3lib_extMgm::addPItoST43($_EXTKEY, 'pi1/class.tx_newsvideo_pi1.php', '_pi1', '', 1);
 
    $TYPO3_CONF_VARS['EXTCONF']['tt_news']['extraItemMarkerHook'][] =  'EXT:tx_newsvideo/pi1/class.tx_newsvideo_pi1.php:tx_newsvideo_pi1';
    $TYPO3_CONF_VARS['EXTCONF']['tx_news']['extraItemMarkerHook'][] =  'EXT:tx_newsvideo/pi1/class.tx_newsvideo_pi1.php:tx_newsvideo_pi1';

#####################################################
## Hook for HTML-modification on the page   #########
#####################################################
// hook is called after Caching! 
// => for modification of pages with COA_/USER_INT objects. 
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = 'EXT:tx_newsvideo/class.tx_newsvideo_fehook.php:&tx_newsvideo_fehook->intPages';
// hook is called before Caching!
// => for modification of pages on their way in the cache.
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][] = 'EXT:tx_newsvideo/class.tx_newsvideo_fehook.php:&tx_newsvideo_fehook->noIntPages';
?>
