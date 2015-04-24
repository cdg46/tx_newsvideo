<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2012 Yann Bogdanovic <thomas.dudzak@gmx.net>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   48: class tx_newsvideo_pi1 extends tslib_pibase
 *   64:     function extraItemMarkerProcessor($markerArray, $row, $conf, &$pObj)
 *   88:     function renderVideoInCode($news_content)
 *  120:     function main(&$content, $conf)
 *
 * TOTAL FUNCTIONS: 3
 *
 */

require_once(PATH_tslib . 'class.tslib_pibase.php' );
require_once(PATH_tslib . 'class.tslib_content.php');

/**
 * Plugin 'Intext video for tt_news, tt_content' for the 'tx_newsvideo' extension.
 *
 * @author    Yann Bogdanovic <support@cdgfpt46.fr>
 * @package    TYPO3
 * @subpackage    tx_newsvideo
 */
class tx_newsvideo_pi1 extends tslib_pibase {
    var $prefixId      = 'tx_newsvideo_pi1';        // Same as class name
    var $scriptRelPath = 'pi1/class.tx_newsvideo_pi1.php';    // Path to this script relative to the extension dir.
    var $extKey        = 'tx_newsvideo';    // The extension key.
    var $pi_checkCHash = true;
    var $cachePath = 'typo3temp/tx_newsvideo/';
    var $content;   // HTML code of the page
    var $conf;  // TypoScript Configuration for theis extension
    
    var $width;
    var $height;

    /**
     * The extraItemMarkerProcessor function from tt_news
     *
     * @param    [type]        $markerArray: ...
     * @param    [type]        $row: ...
     * @param    [type]        $conf: ...
     * @param    [type]        $pObj: ...
     * @return    video        code into tt_news :)
     */
    function extraItemMarkerProcessor($markerArray, $row, $conf, &$pObj) {
        $this->conf = $conf;

        $this->cObj = t3lib_div::makeInstance("tslib_cObj");
        $this->width  = $row['tx_newsvideo_width']  ? $row['tx_newsvideo_width']  : $conf['newsvideo.']['width'];
        $this->height = $row['tx_newsvideo_height'] ? $row['tx_newsvideo_height'] : $conf['newsvideo.']['height'];
        $templateSource = $conf['newsvideo.']['templateFile'] ? $conf['newsvideo.']['templateFile'] : 'EXT:tx_newsvideo/tx_newsvideo.tmpl';

        $this->templateCode = $this->cObj->fileResource($templateSource);
        if (empty($this->templateCode)) {
            return $markerArray;
        }
        $markerArray['###NEWS_SUBHEADER###'] = $this->renderVideoInCode($markerArray['###NEWS_SUBHEADER###']);
        $markerArray['###NEWS_CONTENT###']   = $this->renderVideoInCode($markerArray['###NEWS_CONTENT###']  );

        return $markerArray;
    }

    /**
     * Render Video in Code: Renders Video in Text
     *
     * @param    [type]        $news_content: ...
     * @return    video        code
     */
    function renderVideoInCode($news_content, $fromMain = false, $width = 500, $height = 303) {
        preg_match_all('/\/\/VIDEO:(.*)\/\//', $news_content, $MarkersFound);
        $content = $MarkersFound[1];

        foreach($content as $tag) {
        if ($fromMain)
        {
        $tag = preg_split('/\/\//', $tag);
        $tag = $tag[0];
//        $content = $MarkersFound[1];
//        $tag = $tag[0];
           
        }
            $value = explode(':', $tag, 2);
            $templateSubpart = $this->cObj->getSubpart($this->templateCode, '###'.strtoupper($value[0]).'###');

            if (!empty($templateSubpart) AND $value[1]) {
                $sizes = explode(':',$value[1]);
                if($sizes[1] AND $sizes[2]) {
                    $markerArray['###VIDEO_ID###'] = $sizes[0];
                    $markerArray['###WIDTH###']    = $sizes[1];
                    $markerArray['###HEIGHT###']   = $sizes[2];
                } else {
                    $markerArray['###VIDEO_ID###'] = $value[1];
                    $markerArray['###WIDTH###']    = $this->width  ? $this->width  : $width;
                    $markerArray['###HEIGHT###']   = $this->height ? $this->height : $height;
                }

                $movie = $this->cObj->substituteMarkerArrayCached($templateSubpart, $markerArray, array(), array());

                $news_content = str_replace('//VIDEO:'.$tag.'//',$movie,$news_content);
            } else {
                $news_content = str_replace('//VIDEO:'.$tag.'//','',$news_content);
            }
        }

        return $news_content;
    }

    function main(&$content, $conf) {
        $this->content = & $content;
        $this->conf = $conf;

        $this->cObj   = t3lib_div::makeInstance("tslib_cObj");
        $templateSource = $conf['newsvideo.']['templateFile'] ? $conf['newsvideo.']['templateFile'] : 'EXT:tx_newsvideo/tx_newsvideo.tmpl';
        //var_dump($width . ' : ' . $height);
        $this->templateCode = $this->cObj->fileResource($templateSource);
        if (empty($this->templateCode)) {
            return $markerArray;
        }
        $this->content = $this->renderVideoInCode($this->content, true);
    }
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ttnews_codehighlight/pi1/class.tx_ttnewscodehighlight_pi1.php'])    {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ttnews_codehighlight/pi1/class.tx_ttnewscodehighlight_pi1.php']);
}
?>
