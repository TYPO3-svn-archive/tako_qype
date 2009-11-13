<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Sebastian Felix Schwarz <schwarz@takomat.com>
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
 * Hint: use extdeveval to insert/update function index above.
 */

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Qype List' for the 'tako_qype' extension.
 *
 * @author	Sebastian Felix Schwarz <schwarz@takomat.com>
 * @package	TYPO3
 * @subpackage	tx_takoqype
 */
class tx_takoqype_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_takoqype_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_takoqype_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'tako_qype';	// The extension key.
	var $pi_checkCHash = true;
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		
		$this->pi_initPIflexForm(); // Init and get the flexform data of the plugin
		$this->lConf = array(); // Setup our storage array..
		// Assign the flexform data to a local variable for easier access
		$this->extPath = substr(t3lib_extMgm::extPath($this->extKey), strlen(PATH_site));
		
		
		$this->getPluginConfig();
		$this->getData();
		
		$content = $this->renderTemplate(); 
	
		return $this->pi_wrapInBaseClass($content);
	}
	function getPluginConfig(){
		$piFlexForm = $this->cObj->data['pi_flexform'];
		$this->place = $this->pi_getFFvalue($this->cObj->data['pi_flexform'],'place','sDEF');
		$this->customer_key = $this->pi_getFFvalue($this->cObj->data['pi_flexform'],'key','sDEF');
		$this->maxItems = $this->pi_getFFvalue($this->cObj->data['pi_flexform'],'maxItem','sDEF');
		$this->sorting = $this->pi_getFFvalue($this->cObj->data['pi_flexform'],'SORT','sDEF');
		$this->starsShown = $this->pi_getFFvalue($this->cObj->data['pi_flexform'],'SHOW5STARS','sDEF');
		$this->rating = array();
		$this->text = array();
		$this->name = array();
		
	}
	function getData(){
		$xml = "http://api.qype.com/v1/places/".$this->place."/reviews/de?consumer_key=".$this->customer_key;
		
		
		$all_api_call = file_get_contents($xml);
		$xml = new SimpleXMLElement($all_api_call); 
		$i=0;
		$this->items = 0;
		foreach($xml->review as $review) {
			//t3lib_div::debug($i,'$review');
			$this->rating[$i] = $review->rating;
			$text = $review->xpath("content[@type='xhtml']");
			$this->text[$i] = $text;
			$name = $review->xpath("link[@rel='http://schemas.qype.com/user']");
			$this->name[$i] = $name[0]->attributes()->title;
			$this->items++;
			$i++;
		}
		
		
	}
	function renderTemplate(){
		$this->template=$this->cObj->fileResource('EXT:tako_qype/template.html');  
		
		 #unser Subpart
        $subpart=$this->cObj->getSubpart($this->template,'###LISTVIEW###'); 
        #eine einzelne Reihe
        $singlerow=$this->cObj->getSubpart($subpart,'###ROW###'); 
		$items = count($rating);
		//t3lib_div::debug($items,'$items');
		
		
		//t3lib_div::debug($this->sorting,'sorting');
		if($this->sorting == 0){
			
			if($this->items > $this->maxItems){
				$max = $this->items - $this->maxItems;
			}else{
				$max = 0;
				//t3lib_div::debug($max,'$max');
			}
			//t3lib_div::debug($max,'$max');
			//t3lib_div::debug($this->items,'$$this->items');
			for($i=$this->items;$i>$max;$i--){
				$img = '<img src="'.$this->extPath.'/res/star.png" width="15" height="14" />';
				$star = "";
				$counter = intval($this->rating[$i-1]);
				//t3lib_div::debug($counter,'$counter');
				for($s=0;$s<$counter;$s++){
					$star .= $img;
				
				}
				//t3lib_div::debug($this->starsShown,'$this->starsShown');
				if($this->starsShown >0){
					$img = '<img src="'.$this->extPath.'/res/star_disabled.png" width="15" height="14" />';
					if($counter < 5){
						//t3lib_div::debug($counter,'$counter im if');
						for($s=$counter;$s < 5;$s++){
							$star .= $img;
						}	
					}
				}
				$markerArray['###RATING###']=$star;
				$markerArray['###NAME###']=$this->name[$i-1];
				$markerArray['###TEXT###']=$this->text[$i-1];
				$liste .= $this->cObj->substituteMarkerArrayCached($singlerow,$markerArray); 			
			}	
			
		}else{
			
			if($this->items > $this->maxItems){
				$max = $this->maxItems;
			}else{
				$max = $this->items;
				//t3lib_div::debug($max,'$max');
			}
			
			for($i=0;$i<$max;$i++){
				$img = '<img src="'.$this->extPath.'/res/star.png" width="15" height="14" />';
				$star = "";
				$counter = intval($this->rating[$i]);
				
				for($s=0;$s<$counter;$s++){
					$star .= $img;
				
				}
				if($this->starsShown >0){
					$img = '<img src="'.$this->extPath.'/res/star_disabled.png" width="15" height="14" />';
					if($counter < 5){
						for($s=$counter;$s <= 5;$s++){
							$star .= $img;
						}	
					}
				}
				$markerArray['###RATING###']=$star;
				$markerArray['###NAME###']=$this->name[$i];
				$markerArray['###TEXT###']=$this->text[$i];
				$liste .= $this->cObj->substituteMarkerArrayCached($singlerow,$markerArray); 			
			}	
		}
				
		$subpartArray['###ROW###']=$liste;
		return $this->cObj->substituteMarkerArrayCached($subpart,$markerArray,$subpartArray,array()); 
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tako_qype/pi1/class.tx_takoqype_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tako_qype/pi1/class.tx_takoqype_pi1.php']);
}

?>