<?php
/***************************************************************
*  Copyright notice
*  
*  (c) 2003 Nico Ueckermann (info@ueckermann.de)
*  All rights reserved
*  
*  Modified by Rainer Leo (office@workfile.de)
*
*  This script is part of the Typo3 project. The Typo3 project is 
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
 * Plugin 'Directory' for the 'tx_pobdir' extension.
 *
 * @author	Nico Ueckermann <info@ueckermann.de> 
 */


// jetzt per autoload !!
//require_once(PATH_tslib."class.tslib_pibase.php");
//require_once(PATH_t3lib."class.t3lib_basicfilefunc.php");

// typo3_src-6.2.3/typo3/sysext/cms/tslib/class.tslib_pibase.php

// typo3_src-6.2.3/typo3/sysext/core/Classes/Database/DatabaseConnection.php

// find . -type f -exec grep -Il "Leider wurde kein Treffer zu Ihrer Suche gefunden." {} \;
// ./diessen.de/2014/typo3temp/llxml/php_ab37000a51.de.utf-8.cache
// ./diessen.de/2014/typo3temp/Cache/Data/l10n/5fd45e4e7b659ffbfed37eaa99659a97

/*

Parent Class Name: 
TYPO3\CMS\Frontend\Plugin\AbstractPlugin

Parent Class Location:
/home/www/doc/19521/dcp195210019/diessen.de/typo3_src-6.2.3/typo3/sysext/frontend/Classes/Plugin/AbstractPlugin.php

*/


class tx_pobdir_pi1 extends tslib_pibase {
	
  var $extKey = "pobdir";	// The extension key.
  
  var $collation = 'UTF-8'; 
  
  var $prefixId = "tx_pobdir_pi1";		// Same as class name
  
  var $extHome = "/typo3conf/ext/pobdir/";
	
  var $scriptRelPath = "pi1/class.tx_pobdir_pi1.php";	// Path to this script relative to the extension dir.
 
  
  var $search_default = "Suchbegriff";
    
  var $map = "map.gif";
  
  var $kategorien = array();
  var $piktos = array();
  var $ausstattung = array();
  
  var $dbg = 1;
  
  function getKategorien() { 
    
    $ressource  = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
      'uid, name',                        // SELECT
      'tx_pobdir_category',               // FROM
      '',                                 // WHERE
      '',                                 // GROUP BY
      'sorting',                          // ORDER BY
      ''                                  // LIMIT
    );
    
    $rows = array();
    
    while($z = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($ressource)) {
      $this->kategorien[] = $z;
    }
      
  }
  
  function getKategorie($uid) {
    foreach( $this->kategorien as $kat ) {
      if ( $kat['uid'] == $uid ) return $kat['name'];
    }
  }
  
  
  function getPiktonames() {   
    
    $ressource  = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
      'uid, pikto, title',               // SELECT
      'tx_pobdir_feature',               // FROM
      '',                                // WHERE
      '',                                // GROUP BY
      'uid',                             // ORDER BY
      ''                                 // LIMIT
    );
    
    $z = array();
    
    while($z = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($ressource)) {
      $this->piktos[] = $z;
    }
      
  }
  
  function getPiktoFileName($num) {
    foreach( $this->piktos as $pikto ) {
      if ( $pikto['uid'] == $num ) return $pikto['pikto'];
    }     
  }
  
  function getPiktoInfo($num) {   
    foreach( $this->piktos as $pikto ) {
      if ( $pikto['uid'] == $num ) return $pikto['title'];
    }  
  }
  
  function getPathToPiktos() {
    return $this->extHome."piktos/";
  }
  
  function getPiktoImg($num) {   
  
    return "<img src='".$this->getPathToPiktos().$this->getPiktoFileName($num)."' title='".$this->getPiktoInfo($num)."' border='0' width='26' style='margin-right:2px;margin-top:2px;'>";
  }
  
  function getStarsImg($num) {
      
    $num = (int)$num;
    
    if ( $num < 1 || $num > 5 ) return;
    
    $html = "";
    
    $i = 1;
    
    while ( $i <= $num ) {
    
      $html .= "<img src='".$this->getPathToPiktos() . "dtv_stern.jpg' border='0' width='15' style='margin-bottom:2px;'>";
      $i++;
    }
    
    return $html;
  
  }
  
	
	function getPiktos($csv) {
	
	  $html = "";
	
	  if ( strpos($csv, ',') ) {
    
      $features = explode(',',$csv);
      
      if ( is_array($features) ) {
      
        sort($features);
      
        $i = 1;
        foreach ( $features as $feature ) {
          
          $html .= $this->getPiktoImg($feature);
          
          if ( $i == 6 ) {
          
            $html .= "<br />";
            $i = 1;
          
          }
          else $i++;
        }    
           
      
      }
      
      else {
      
        $features = substr($features,0,strpos($csv, ','));
        $html = "kein array ==> " .$features;
      
      }
    
    }
    
    else {
    
      $html = $this->getPiktoImg($csv);    
    
    }
  
    return $html;
  
  }


  function makeErweitereSuche() {
  
    $this->getPiktonames();
  
    $html = "
    <tr id='erweiterte_suche' class='pobdir_hidden'>
    <td colspan='7' align='center'>
    <hr class='pobdir_grad' />
    <h3>Erweitere Suche mit Ausstattungsmerkmalen</h3>
    <div style='text-align:center; font-size: 0.8em'>Nach der Auswahl bitte oben auf Suchen klicken, um die gew&uuml;nschten Unterk&uuml;nfte zu finden.</div>
    <table style='margin-top: 20px;margin-bottom: 20px;'>
      <tr>";
    
    $i = 1;
    $n = 1;
    foreach($this->piktos as $pikto) {
    
      $info = '';
      $info = $this->getPiktoInfo($n);
      
      if ( !$info ) {
        $n++;
        continue;
      }     
      
    
      if ( $i == 3 ) {
        $html .= "
      </tr>
      <tr>";
        $i = 1;
      }
      
      if ( array_key_exists('filter_ausstattung', $this->piVars)) {
        $checked = in_array($n, $this->piVars['filter_ausstattung']) ? " checked" : "";
      }
      else $checked = "";
      
      $html .= "
        <td><div style='width: 30px'>&nbsp;</div></td>
        <td><input type='checkbox' name='tx_pobdir_pi1[filter_ausstattung][]' value='".$n."'".$checked."></td>
        <td>".$this->getPiktoImg($n)."</td>
        <td>".$this->getPiktoInfo($n)."</td>";
    
      $n++;
      $i++;
    }
    
    $html .= "
      </tr>
    </table>
    </td>
    </tr>";
    
    return $html;
  
  }

	/**
	 * Hauptfunktion zur Ausgabe des Verzeichnisses
	 */
	function main( $content, $conf )	{
	
	  /*
    if ( isset($_REQUEST['tx_pobdir_neu']) && $_REQUEST['tx_pobdir_neu'] == '1' ) {
	  
	    $GLOBALS['TSFE']->fe_user->setKey('ses', 'filter_ausstattung', null);
	    
      if ( isset($_REQUEST['filter_ausstattung']) ) {
      
        $GLOBALS['TSFE']->fe_user->setKey('ses', 'filter_ausstattung', $_REQUEST['filter_ausstattung']);
        $GLOBALS["TSFE"]->storeSessionData();
      
      }
	  
	  }
	  
	  $this->piVars['filter_ausstattung'] = $GLOBALS['TSFE']->fe_user->getKey('ses','filter_ausstattung');

	  */
		  
    if ( $this->dbg == 10 ) {
    
      echo "DOCUMENT_ROOT = [".$_SERVER['DOCUMENT_ROOT']."]<br />";
	
      $object = new ReflectionClass('tx_pobdir_pi1');

      echo 'Parent Class Name: <br>';
      echo $object->getParentClass()->getName();
  
      echo '<br>Parent Class Location: <br>';
      echo $object->getParentClass()->getFileName();
   
    }
	
	  //print_r($GLOBALS['TYPO3_DB']);
	

	  //echo "content = " . $content ."<br />";
	  //echo "conf = " . print_r($conf) ."<br />";
	
  	$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		
		$this->getKategorien();
		$this->getPiktonames();
		
		//echo "<b>main()</b><br />";print_r($this->piVars); echo "<br />";echo "<b>main() /EOF</b><br />";
		//echo "pikto[1]=". $this->piVars['pikto[1]']."<br />";
    //echo "pikto_3=".$this->piktos[3]."<br />"; 
		
    $this->pi_loadLL(); // Loads local-language values by looking for a "locallang.php" file in the plugin class directory ($this->scriptRelPath) and if found includes it.
        
    //print_r($this->LOCAL_LANG);
    
    
		//Default-Values
		$this->internal['currentTable'] = 'tx_pobdir_entry';

		//delete sword
		if ( $this->piVars['modifier'] == 'all' ) 
      $this->piVars['sword'] = "";
    
    //print_r($this->piVars); 
    
    //echo "Template = [".$this->conf["pobdir_templateFile"]."]<br />";
		
		//Template parsen
		$this->listTemplateCode = $this->cObj->fileResource($this->conf["pobdir_templateFile"]);  // cObj ==> The backReference to the mother cObj object set at call time
		$this->listheader = $this->cObj->getSubpart($this->listTemplateCode, "###LISTHEADER###");
    $this->top = $this->cObj->getSubpart($this->listTemplateCode, "###TOPVIEW###");
		$this->bottom = $this->cObj->getSubpart($this->listTemplateCode, "###BOTTOMVIEW###");
		$this->eintrag = $this->cObj->getSubpart($this->listTemplateCode, "###LISTVIEW###");
		$this->nono = $this->cObj->getSubpart($this->listTemplateCode, "###NOVIEW###");
		$this->detail = $this->cObj->getSubpart($this->listTemplateCode, "###SINGLEVIEW###");
		
		switch($this->piVars['mode'])	{
			
			case "detail":		
				
        $content = $this->makeDetail($this->piVars['value']);
				$content .= $this->makeEditLink(edit,$this->piVars['value']);
			  break;
			
      
      case "enter":
				
        $content = $this->makeForm(enter,$this->piVars['modifier']);
			  break;
			
      
      case "edit":
			
      	$content = $this->makeForm(edit,$this->piVars['modifier'],$this->piVars['value']);
			  break;
			
      
      default: //"liste" 

				$content = $this->makeTop(); // #5
			
      	switch($this->piVars['modifier'])	{
					
          case "zip":
						
            $content .= $this->makeliste('zip',$this->piVars['value']);
					  break;
					  
				  
          case "city":
						
            $content .= $this->makeliste('city',$this->piVars['value']);
					  break;
					
          
          case "search":
					
          	$this->piVars['sword'] = $this->piVars['value'] ? $this->piVars['value'] : $this->piVars['sword']; 
          	$content .= $this->makeliste('search',$this->piVars['sword']);
          	//$this->piVars['sword'] = $_GET['tx_pobdir_pi1[value]'];
						//$content .= $this->makeliste('search',$_GET['tx_pobdir_pi1[value]']);
            
            unset($this->piVars['showfree_anreise']);
            unset($this->piVars['showfree_abreise']);					
					  break;
					
          
          case "cat":
						$content .= $this->makeliste('cat',$this->piVars['value']);
					  break;
					
					case "cap":
						$content .= $this->makeliste('cap',$this->piVars['value']);
					  break;
					  
					case "free":
						$content .= $this->makeliste('free',$this->piVars['value']);
					  break; 
					  
          
          default: //"abc"
						
            switch($this->piVars['value'])	{
						
            	case "":
						
            
            	case "all":
						
            		$content .= $this->makeliste('abc',all);
						   	break;
							
              
              default:
								$content .= $this->makeliste('abc',$this->piVars['value'],$this->piVars['pointer']);
							  break;
						}
					
          break;
				}
				
				$content .= $this->makeBottom($this->piVars['modifier'],$this->piVars['value']);
				$content .= $this->makeEditLink(enter);
				
			break;		
			
		}
		
	  return $this->pi_wrapInBaseClass($content);	
	}
	
	
  function makeEditLink($action,$id="")	{

		switch($action)	{
		
			case "enter":
			 
       	$content = ($GLOBALS['TSFE']->fe_user->user[tx_pobdir_directory]) ? '<table cellpadding="7" cellspacing="0" border="0" width="100%"><tr><td align="right">'.$this->makeLink($this->pi_getLL("your_entry"),enter,"","","0").'</td></tr></table>' : "";
			  break;
			
      
      case "edit":
			
      	$res  = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
          'belongsto',               // SELECT
          'tx_pobdir_entry',         // FROM
          'uid = '.$id,              // WHERE
          '',                        // GROUP BY
          '',                        // ORDER BY
          ''                         // LIMIT
        );

				$row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
				$content = ($GLOBALS['TSFE']->fe_user->user[tx_pobdir_directory] && $GLOBALS['TSFE']->fe_user->user[uid]==$row[belongsto]) ? '<table cellpadding="7" cellspacing="0" border="0" width="100%"><tr><td align="right">'.$this->makeLink($this->pi_getLL("edit_your_entry"),edit,"first",$id,"0").'</td></tr></table>' : "";
				
			  break;
		}
	
    return $content;
	}
	
	
  function makeDetail($id)	{
    
    $result = $GLOBALS['TYPO3_DB']->exec_INSERTquery(
      'tx_pobdir_clicks',
      array(
        'uid'     => $id,
        'visitor' => $_SERVER['REMOTE_ADDR']        
      )
    );
    
		$pidList = $this->pi_getPidList($this->conf["pidList"],$this->conf["recursive"]);
	  
    $ressource  = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
      '*',               // SELECT
      'tx_pobdir_entry',               // FROM
      "pid IN (".$pidList.")"." ".$this->cObj->enableFields(tx_pobdir_entry)." AND uid = ".$id,                                // WHERE
      '',                                // GROUP BY
      'uid',                             // ORDER BY
      ''                                 // LIMIT
    );
    
    $row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($ressource);			                           
		
    $markerArray["###NAME###"] = $row['stars'] > 0 
    ? $this->getStarsImg($row['stars']) . "<br />" . htmlentities($row['name'], ENT_QUOTES, $this->collation)
    : htmlentities($row['name'], ENT_QUOTES, $this->collation);
  
		$markerArray["###PROFILE###"] = nl2br(htmlentities($row['profile'], ENT_QUOTES, $this->collation));
		$markerArray["###STRASSE###"] = htmlentities($row['street'], ENT_QUOTES, $this->collation);
		$markerArray["###PLZ###"] = htmlentities($row['zip'], ENT_QUOTES, $this->collation);
		$markerArray["###ORT###"] = htmlentities($row['city'], ENT_QUOTES, $this->collation);
		
		
		//$markerArray["###MAP###"] = "<a rel='lightbox[myImageSet]' href='".$this->getPathToPiktos().$this->map."'>Lageplan: ".$row['map']."</a>";
		$markerArray["###MAP###"] = "<a href='https://www.google.de/maps/place/".urlencode($row['street']).",+".$row['zip']."+".urlencode($row['city'])."' target='_new'>Routenplaner</a>";
		
		
		$markerArray["###BESCHREIBUNG###"] = htmlentities($row['description'], ENT_QUOTES, $this->collation);
		$markerArray["###AUSSTATTUNG###"] = htmlentities($row['features'], ENT_QUOTES, $this->collation);
		$markerArray["###PRICE###"] = htmlentities($row['price']);
		$markerArray["###PREISINFO###"] = htmlentities($row['priceinfo'], ENT_QUOTES, $this->collation);
		$markerArray["###PIKTOS###"] = "TEST"; //$row['features']; //$this->getPiktos($row['features']);
		
		$fon   = ($row['tel']) ? $this->pi_getLL("tel").": ".$row['tel']."<br />" : "";
		$fax   = ($row['fax']) ? $this->pi_getLL("fax").": ".$row['fax']."<br />" : "";
		$mobil = ($row['mobil']) ? $this->pi_getLL("mobil").": ".$row['mobil']."<br />" : "";
    
    $markerArray["###TEL###"] = $fon.$fax.$mobil;
		
    
    $markerArray["###WWW###"] = ($row['www']) ? "<a href='http://".$row['www']."' target='_blank'>".$row['www']."</a>" : "";
		//$markerArray["###EMAIL###"] =($row['email']) ? "<a href=\"javascript:popupWindow('".$this->extHome."pi1/contact.php',400,400);\">".$row['email']."</a>" : "";
		
    $mailto = $row['email'];                                                              
    
    //$markerArray["###EMAIL###"] =($row['email']) ? "<a href=mailto:".$mailto."?subject=".str_replace(' ', '%20', $this->pi_getLL('email_subject'))."&body=".str_replace(' ', '%20', $this->pi_getLL('email_body')).">".$row['email']."</a>" : "";
    
    $markerArray["###EMAIL###"] = "<a style='cursor:pointer; color:#4A8FCA;' onclick=\"popupWindow('http://".$_SERVER['SERVER_NAME']."/kontakt.php?v=".$row['uid']."', 600, 700);\">Buchungsanfrage</a>";		
		$markerArray["###BESCHREIBUNG###"] = nl2br(htmlentities($row['description'], ENT_QUOTES, $this->collation));
    $markerArray["###AUSSTATTUNG###"] = htmlentities($row['features'], ENT_QUOTES, $this->collation);
 	  $markerArray["###PRICE###"] = nl2br(htmlentities($row['price'], ENT_QUOTES, $this->collation));
	  $markerArray["###PREISINFO###"] = nl2br(htmlentities($row['priceinfo'], ENT_QUOTES, $this->collation));
	  $markerArray["###PIKTOS###"] = $this->getPiktos($row['features']);
	  $markerArray["###KATEGORIE###"] = $this->getKategorie($row['category']);
	  
	  $text_personen = $row['capacity'] > 1 
	  ? " f&uuml;r ".$row['capacity']." Personen"
	  : " f&uuml;r 1 Person";
    $markerArray["###PERSONEN###"] = $text_personen;
	  
	  
	  $markerArray["###WERBUNG###"] = $this->getWerbung($row['ads']);
	  
	  
    //$markerArray["###ZURUECK###"] = '<a href="javascript:history.back()">'.$this->pi_getLL("back").'</a>';
    //$markerArray["###ZURUECK###"] = $this->makeDetailBackLink($this->piVars['sword']);
    
    //$markerArray["###DRUCKEN###"] = "<a href='index.php?id=2&type=98'>DRUCKEN</a>";
	  //$markerArray["###DRUCKEN###"] = "<span><input type='button' value='".$this->pi_getLL('print')."' onclick='javascript:window.print()' style='display:inline'></span>";
	  
    $form = $this->piVars['sword'] ? true : false;
    $markerArray["###FOOTER###"] =  $this->makeDetailFooter($form);
			
		//Bilder einfügen
    $bilder = explode(",",$row['image']);
    $anz = count($bilder);
    
    $n = 0;        
    foreach($bilder as $bild){

      $n++;
      $index = "###BILD_".$n."###";
      $h = $n == 1 ? '130' : '100';
                                                              
      $markerArray[$index] = $this->getImageGallery($bild, $this->conf, $h);

    }
    
      
    for ( $i = $anz+1 ; $i <= 5 ; $i++ ) {
      
      $index = "###BILD_".$i."###";                                                        
      $markerArray[$index] = "";
      
    }
    
		$over['detail'] = "";		
    
    $content = $this->cObj->substituteMarkerArrayCached($this->detail,$markerArray,array(),array());
    
	  $js = '
	  <script language="JavaScript" type="text/JavaScript">
		<!--     		
    function popupWindow(url, w, h) {
      var parameter="";
      var breite = screen.availWidth;
      var hoehe = screen.availHeight;
      var fensterbreite = w;
      var fensterhoehe = h;
      var pos_x = (breite/2)-(fensterbreite/2);
      var pos_y = (hoehe/2)-(fensterhoehe/2);
      parameter  = "width=" + fensterbreite + ",height=" + fensterhoehe + ",";
      parameter += "left=" + pos_x + ",top=" + pos_y;
      parameter += "resizable=yes,scrollbars=no,status=no,";
      parameter += "menubar=no,toolbar=no,location=no,directories=no";
      var Fenster = window.open(url,"PopUp",parameter);
      if (Fenster) Fenster.focus();
    }
    //-->
		</script>';
    
    return $js.$content;
	}
	
	
  
  function getWerbung($ads) {
              
    $html = "";
    
    foreach(explode(",",$ads) as $werbung){

      $html .= "<div class='pobdir-ad'>".$this->getWerbetext($werbung)."</div>";

    }
    
    return $html;
	
	
  }
  
  function getWerbetext($id) {
    
    $ressource  = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
      'ad',                        // SELECT
      'tx_pobdir_ad',              // FROM
      'uid = '. intval($id),       // WHERE
      '',                          // GROUP BY
      '',                          // ORDER BY
      ''                           // LIMIT
    );
    
    $data = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($ressource);
    return $data['ad'];
  
  }
	
	  
  function makeTop()	{
	    
    $markerArray["###ALLE###"] = "<span style='margin-right:20px;'>".$this->makeButtonShowAll()."</span>";
    
    $markerArray["###FREIE###"] = "<span style='margin-right:20px;'>".$this->makeButtonShowFree()."</span>";
    
    $markerArray["###PERSONEN###"] = $this->makeSelectPersonen();
    $markerArray["###SELECTED_PERSONEN###"] = $this->piVars['cap'];
    
    
    $markerArray["###SELECTED_ANREISE###"] = isset($this->piVars['showfree_anreise']) && $this->piVars['showfree_anreise']
    ? $this->piVars['showfree_anreise']
    : '';
    
    
    $markerArray["###SELECTED_ABREISE###"] = isset($this->piVars['showfree_abreise']) && $this->piVars['showfree_abreise']
    ? $this->piVars['showfree_abreise']
    : '';
    
    //$markerArray["###ABISZ###"] = $this->makeABC('tx_pobdir_entry','name',$this->piVars['value']);
		
    $markerArray["###KATEGORIE###"] = $this->makeJumper($this->piVars['modifier'],$this->piVars['value']); 
    $markerArray["###SELECTED_KATEGORIE###"] = $this->piVars['cat'];
    
    $markerArray["###FILTER_ORT###"] = $this->makeSelectOrt($this->piVars['modifier'],$this->piVars['value']);
    
    $markerArray["###ZIPCODE###"] = $this->makePLZ($this->piVars['modifier'],$this->piVars['value']); 
		
    $markerArray["###SUCHE###"] = $this->makeSearchbox($this->piVars['value']);
    
    $markerArray["###ERWEITERTE_SUCHE###"] = $this->makeErweitereSuche();
    
       
    
		
    $content = $this->cObj->substituteMarkerArrayCached($this->top,$markerArray,array(),array());
		
	  return $content;
	}
	
	function makeliste($modifier,$value)	{
    
    //echo $this->makeListQuery($modifier,$value)."<br />";
 
    $ressource = $this->makeListQuery($modifier,$value);

		$zaehler = 0;
		
    while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($ressource))	{
		
		  if ( $zaehler == 0 ) {
        $markerArray["###TBL_BG_CLASS###"] = "pobdir-bg_1"; 
        $zaehler = 1;
      } elseif ( $zaehler == 1 ) { 
        $markerArray["###TBL_BG_CLASS###"] = "pobdir-bg_2";  
        $zaehler = 0;
      }
			
      $over['detail'] = $row['uid']; 
					 
      $name = $row['stars'] > 0 
      ? $this->getStarsImg($row['stars']) . "<br />" . htmlentities($row['name'], ENT_QUOTES, $this->collation)
      : htmlentities($row['name'], ENT_QUOTES, $this->collation);
      
      $markerArray["###NAME###"] = $row['detail'] == '1'
      ? $this->makeLink($name,'detail',$modifier,$row['uid'],1,$pointer)
      : $name;
      
      
      //$markerArray["###NAME###"] = ($row['www']) ? '<a href="'.$row['www'].'" target="_blank">'.$name.'</a>' : '<font color="'.$this->conf['inactive'].'">'.$name.'</font>';
			$markerArray["###PROFILE###"] = nl2br(htmlentities($row['profile'], ENT_QUOTES, $this->collation));
			
			
			//$markerArray["###MAP###"] = $row['map']."<br />".$this->getImage($this->map,$this->conf,20);
			//$markerArray["###MAP###"] = "<a rel='lightbox[myImageSet]' href='".$this->getPathToPiktos().$this->map."'>".$row['map']."</a>";			
			$markerArray["###MAP###"] = "";
		  $markerArray["###BESCHREIBUNG###"] = nl2br(htmlentities($row['description'], ENT_QUOTES, $this->collation));
		  $markerArray["###AUSSTATTUNG###"] = htmlentities($row['features'], ENT_QUOTES, $this->collation);
		  $markerArray["###PRICE###"] = nl2br(htmlentities($row['price'], ENT_QUOTES, $this->collation));
		  $markerArray["###PREISINFO###"] = nl2br(htmlentities($row['priceinfo'], ENT_QUOTES, $this->collation));
		  $markerArray["###PIKTOS###"] = $this->getPiktos($row['features']);
     
      $markerArray["###STRASSE###"] = htmlentities($row['street'], ENT_QUOTES, $this->collation)."&nbsp;";
			$markerArray["###PLZ###"] = htmlentities($row['zip'], ENT_QUOTES, $this->collation);
			$markerArray["###ORT###"] = htmlentities($row['city'], ENT_QUOTES, $this->collation)."&nbsp;";
			$markerArray["###TEL###"] = ($row['tel']) ? $this->pi_getLL("tel").": ".$row[tel] : "";
			$markerArray["###FAX###"] = ($row['fax']) ? $this->pi_getLL("fax").": ".$row[fax] : "";		
			
			$fon   = ($row['tel']) ? $this->pi_getLL("tel").": ".$row['tel']."<br />" : "";
  		$fax   = ($row['fax']) ? $this->pi_getLL("fax").": ".$row['fax']."<br />" : "";
  		//$mobil = ($row['mobil'] && $row['detail'] == '1') ? $this->pi_getLL("mobil").": ".$row['mobil']."<br />" : "";
  		$mobil = $row['mobil'] ? $this->pi_getLL("mobil").": ".$row['mobil']."<br />" : "";
      
      $markerArray["###TEL###"] = $fon.$mobil;
      
      $markerArray["###WWW###"] = ($row['www'] && $row['detail'] == '1') ? '<a href="http://'.$row[www].'" target="_blank">'.$this->pi_getLL("www").'</a>' : '<font color="'.$this->conf[pobdir_inactive].'"></font>';
      
      //$markerArray["###EMAIL###"] =($row['email']) ? "<a href=mailto:".$row['email']."?subject=".str_replace(' ', '%20', $this->pi_getLL('email_subject'))."&body=".str_replace(' ', '%20', $this->pi_getLL('email_body')).">E-Mail</a>" : "";
			$markerArray["###EMAIL###"] = "<a style='cursor:pointer; color:#4A8FCA;' onclick=\"popupCenterWindow('https://www.diessen.de/kontakt.php?v=".$row['uid']."', 600, 700);\">Buchungsanfrage</a>";
			
			$markerArray["###DETAILS###"] = $this->makeLink($this->pi_getLL('details'),'detail',$modifier,$row[uid],1,$pointer);
			
			$markerArray["###KATEGORIE###"] = $this->getKategorie($row['category']);
			
			$text_personen = $row['capacity'] > 1 
  	  ? " f&uuml;r max. ".$row['capacity']." Personen"
  	  : " f&uuml;r 1 Person";
      $markerArray["###PERSONEN###"] = $text_personen;
      
            
      //Bild einfügen
  		$n = 0;
      foreach(explode(",",$row['image']) as $k => $i){
  
         $n++;
         $index = "###BILD_".$n."###";                                                  
         
         
         if ( $n == 1 ) {                                                      
           $markerArray[$index] = $this->makeLink($this->getImage($i,$this->conf, 90, false),'detail',$modifier,$row['uid'],1,$pointer);         
         }
         else {
           $markerArray[$index] = $this->getImage($i,$this->conf, 90);
         }
         
  
      }
		  
      $over['detail'] = "";

			
      // $this->cObj->substituteMarkerArrayCached($template, $markerArray, $subparts, $wrappedSubparts);
      $content .= $this->cObj->substituteMarkerArrayCached($this->eintrag,$markerArray,array(),array());
			
      $liste_anzeigen = 1;
		}
		
    $markerArray["###SORRY###"] = $this->pi_getLL("sorry");
    
    //$markerArray["###SORRY###"] = $GLOBALS['TSFE']->config['config']['language'];
		
    $content = $liste_anzeigen 
    ? $this->makeListheader() . $content 
    : $this->cObj->substituteMarkerArrayCached($this->nono,$markerArray,array(),array());
	
	  return $content;
	}
	
	
  
  function makeListheader() {
        
    $markerArray["###SPALTE_1###"] = $this->pi_getLL("listheader_1");
    $markerArray["###SPALTE_2###"] = $this->pi_getLL("listheader_2");
    $markerArray["###SPALTE_3###"] = $this->pi_getLL("listheader_3");
    $markerArray["###SPALTE_4###"] = $this->pi_getLL("listheader_4");
    
    return $this->cObj->substituteMarkerArrayCached($this->listheader,$markerArray,array(),array());
  
  }
	
	function makeBottom($modifier,$value)	{
	
		$markerArray["###SEITEN###"] = $this->make123($modifier,$value);
		$content = $this->cObj->substituteMarkerArrayCached($this->bottom,$markerArray,array(),array());
		
	return $content;
	}


	
	
	/**
	 * Erzeugen der Buchstabenleiste in Abhängigkeit von den vorkommenden Buchstaben, 
	 * des aktuellen Buchstabens und des Anzeigemodus (Normal, Suche, Kategorie)
	 */
	
  function makeABC($table,$column,$value)	{
		
    echo "----".$value."---";
		
    $alphabet=array(A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z);
		
    $value == (in_array($value,$alphabet)) ? "all" : $value;

		$pidlist = $this->pi_getPidlist($this->conf["pidlist"],$this->conf["recursive"]);

    $res  = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
      $column,                            // SELECT
      $table,                             // FROM
      "pid IN (".$pidlist.")"." ".$this->cObj->enableFields($table),  // WHERE
      '',                                 // GROUP BY
      '',                                 // ORDER BY
      ''                                  // LIMIT
    );
		
		while($tempo = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))	{
			$abisz[]=str_replace (array("Ä", "Ö", "Ü"), array("A", "O", "U"), strtoupper($tempo[$column]{0}));
		}
		$abisz[none]=1;


		
		for($i=0;$i<sizeof($alphabet);$i++)	{

			if(in_array($alphabet[$i],$abisz))	{
				$buchstabenleiste .= ($value==$alphabet[$i]) ? '<font color="'.$this->conf[pobdir_active].'">'.$alphabet[$i].'</font>'.' ' : $this->makeLink($alphabet[$i],liste,abc,$alphabet[$i]).' ';
			}
			else	{
				$buchstabenleiste .= '<font color="'.$this->conf[pobdir_inactive].'">'.$alphabet[$i].'</font>'.' ';
			}
		}
		
    $buchstabenleiste .= ($value==all) ? '<font color="'.$this->conf[pobdir_active].'">'.$this->pi_getLL("all").'</font>' : $this->makeLink($this->pi_getLL("all"),liste,abc,all);

	  
    return $buchstabenleiste;
	
  }

	
	
	      // makeLink('',      'liste', 'city', $tempo['city'], $cache=1, $pointer=0)  
  function makeLink( $string, $mode, $modifier, $value = "", $cache = 1, $pointer = 0, $city = "", $cat = "", $cap = 1 )	{
		
		$over = array(
      "mode" => $mode, 
      "modifier" => $modifier, 
      "value" => $value, 
      "pointer" => $pointer,
      "city" => $city,
      "cat" => $cat,
      "cap" => $cap
    );
		
    $link = ($string) 
    ?	$this->pi_linkTP_keepPIvars($string, $over, $cache) 
    : $this->pi_linkTP_keepPIvars_url($over, $cache);
    
    //echo "link=[".$link."]<br />";	

  	return $link;
	}	
	
	
	
	/**
	 * Erzeugen der Seitenleiste in Abhängigkeit von aktueller Seite und zu übergebender Variable
	 */	
	
	function make123($modifier,$value)	{
    
    $ressource = $this->makeListQuery($modifier, $value, 1, true);
				
    $anzahl = $GLOBALS['TYPO3_DB']->sql_num_rows($ressource);
    
  
		$pages = ceil($anzahl/$this->conf["pobdir_itemsPerPage"]);
	
	  $seitenleiste = $this->pi_getLL("page");
	  
	  if ( $pages > 1 && $this->piVars['pointer'] > 0 )
      $seitenleiste = $this->makeLink('<b>&laquo;&laquo;</b>&nbsp;&nbsp;&nbsp;', 'liste', $modifier, $value, 1, $this->piVars['pointer']-1, $this->piVars['city'], $this->piVars['cat'], $this->piVars['cap']); 
			
    for ( $i = 0 ; $i < $pages ; $i++ )	{
				
      $j = $i + 1;
		  #$urlParameters[tx_pobdir_pi1][page]=$i;

			$seitenleiste .= ($this->piVars[pointer]==$i) 
      ? " <span style='padding:4px; border:1px solid blue; color: ".$this->conf[pobdir_active]."'>".$j."</span>" 
      : " ".$this->makeLink($j, 'liste', $modifier, $value, 1, $i, $this->piVars['city'], $this->piVars['cat'], $this->piVars['cap']);
 		}
		
    if ( $pages > 1 && ($this->piVars['pointer']+1) < $pages )
      $seitenleiste .= $this->makeLink('&nbsp;&nbsp;&nbsp;<b>&raquo;&raquo;</b>', 'liste', $modifier, $value, 1, $this->piVars['pointer']+1, $this->piVars['city'], $this->piVars['cat'], $this->piVars['cap']);
  	
    return $seitenleiste;
	}
	
	/**
	 * Erzeugen der Query
	 */		
	function makeListQuery($modifier, $value, $count = 0, $no_limit = false)	{
	
	  $this->internal["orderBy"]           = "stars DESC, name ASC";
		$this->internal["orderByList"]       = "stars DESC, name ASC";
		$this->internal["searchFieldList"]   = "name, profile, street, city, www";
		#$this->internal["currentTable"]     = "tx_pobdir_entry";
		$this->internal["results_at_a_time"] = $this->conf["pobdir_itemsPerPage"];


		switch($modifier)	{

			case "search":
				
        $this->internal["searchFieldlist"] = "name, profile, street, city, www";
				$this->piVars['sword'] = $value;				
			  break;          
			
			default:
			
			  $this->piVars['sword'] = "";
				
        if ($this->piVars['cat'])  $addWhere .= " AND category = ".$this->piVars['cat'];
        
        $max_in_cat = $this->getMaxPersonenInKategorie($this->piVars['cat']);
        
        $anz_personen = $this->piVars['cap'] > $max_in_cat
        ? $max_in_cat : $this->piVars['cap'];
                
        if ($this->piVars['cap'])  $addWhere .= " AND capacity >= ".$anz_personen;
        if ($this->piVars['city']) $addWhere .= " AND city = '".$this->piVars['city']."'";	
			  
		}
		
    
    //$query1 = $this->pi_list_query($this->internal['currentTable'], $count, $addWhere, "", "", "name", "");
    
    //echo "<br />".$query1."<br />";
    
    $offset = ($this->piVars['pointer']) * $this->conf["pobdir_itemsPerPage"];
    
    if ( $modifier == "search" ) {
      
      $addWhere = " AND (";
      
      $i = 0;
      foreach(explode(',', $this->internal["searchFieldlist"]) as $col) {
        
        if ( $i > 0 ) $addWhere .= " OR ";
        
        $addWhere .= "LOWER(".$col.") LIKE LOWER('%".$this->piVars['sword']."%')";
        
        $i++;
      
      }
      
      $addWhere .= ")";
      
    }
    
    $anreise_abreise = false;
    
    if ( isset($this->piVars['showfree_anreise']) && $this->piVars['showfree_anreise'] ) {
      if ( isset($this->piVars['showfree_abreise']) && $this->piVars['showfree_abreise'] ) {
        $anreise_abreise = true;
      }
    }
    
    if ( $anreise_abreise ) {
      
      /* erster und letzter Tag voll gesperrt
      
      $addWhere .= " 
      AND uid NOT IN (
        SELECT entry_uid 
        FROM tx_pobdir_sperrzeiten 
        WHERE '".$this->dbDate($this->piVars['showfree_anreise'])."' BETWEEN gesperrt_von AND gesperrt_bis
        OR '".$this->dbDate($this->piVars['showfree_abreise'])."' BETWEEN gesperrt_von AND gesperrt_bis
        OR gesperrt_von BETWEEN '".$this->dbDate($this->piVars['showfree_anreise'])."' AND '".$this->dbDate($this->piVars['showfree_abreise'])."'
        OR gesperrt_bis BETWEEN '".$this->dbDate($this->piVars['showfree_anreise'])."' AND '".$this->dbDate($this->piVars['showfree_abreise'])."' 
      )";
      
                   
      $addWhere .= "
      AND uid NOT IN ( 
        SELECT entry_uid 
        FROM tx_pobdir_sperrzeiten 
        WHERE
        (
          (
                '".$this->dbDate($this->piVars['showfree_anreise'])."' > DATE_FORMAT(FROM_UNIXTIME(gesperrt_von) , '%Y-%m-%d') AND '".$this->dbDate($this->piVars['showfree_anreise'])."' < DATE_FORMAT(FROM_UNIXTIME(gesperrt_bis) , '%Y-%m-%d') 
             OR '".$this->dbDate($this->piVars['showfree_abreise'])."' > DATE_FORMAT(FROM_UNIXTIME(gesperrt_von) , '%Y-%m-%d') AND '".$this->dbDate($this->piVars['showfree_abreise'])."' < DATE_FORMAT(FROM_UNIXTIME(gesperrt_bis) , '%Y-%m-%d') 
             OR DATE_FORMAT(FROM_UNIXTIME(gesperrt_von) , '%Y-%m-%d') > '".$this->dbDate($this->piVars['showfree_anreise'])."' AND DATE_FORMAT(FROM_UNIXTIME(gesperrt_von) , '%Y-%m-%d') < '".$this->dbDate($this->piVars['showfree_abreise'])."' 
             OR DATE_FORMAT(FROM_UNIXTIME(gesperrt_bis) , '%Y-%m-%d') > '".$this->dbDate($this->piVars['showfree_anreise'])."' AND DATE_FORMAT(FROM_UNIXTIME(gesperrt_bis) , '%Y-%m-%d') < '".$this->dbDate($this->piVars['showfree_abreise'])."'
          ) 
          OR (
                '".$this->dbDate($this->piVars['showfree_anreise'])."' = DATE_FORMAT(FROM_UNIXTIME(gesperrt_von) , '%Y-%m-%d') 
            AND '".$this->dbDate($this->piVars['showfree_abreise'])."' = DATE_FORMAT(FROM_UNIXTIME(gesperrt_bis) , '%Y-%m-%d')
          )  
        )
        AND deleted = 0
      )";
      */ 
      
      $addWhere .= "
      AND uid NOT IN ( 
        SELECT entry_uid 
        FROM tx_pobdir_sperrzeiten 
        WHERE
        (
          (
                '".$this->dbDate($this->piVars['showfree_anreise'])."' > gesperrt_von AND '".$this->dbDate($this->piVars['showfree_anreise'])."' < gesperrt_bis 
             OR '".$this->dbDate($this->piVars['showfree_abreise'])."' > gesperrt_von AND '".$this->dbDate($this->piVars['showfree_abreise'])."' < gesperrt_bis 
             OR gesperrt_von > '".$this->dbDate($this->piVars['showfree_anreise'])."' AND gesperrt_von < '".$this->dbDate($this->piVars['showfree_abreise'])."' 
             OR gesperrt_bis > '".$this->dbDate($this->piVars['showfree_anreise'])."' AND gesperrt_bis < '".$this->dbDate($this->piVars['showfree_abreise'])."'
          ) 
          OR (
                '".$this->dbDate($this->piVars['showfree_anreise'])."' = gesperrt_von 
            AND '".$this->dbDate($this->piVars['showfree_abreise'])."' = gesperrt_bis
          )  
        )
        AND deleted = 0
      )";   
      
    }
        
    if ( $this->piVars['filter_ausstattung'] ) {
      
      foreach ( $this->piVars['filter_ausstattung'] as $filter_ausstattung ) {
        
        $addWhere .= "
        AND (
          LEFT(features,".(strlen($filter_ausstattung)+1).") = '".$filter_ausstattung.",'
          OR RIGHT(features,".(strlen($filter_ausstattung)+1).") = ',".$filter_ausstattung."'
          OR features LIKE '%,".$filter_ausstattung.",%'
        )";
      
      }
    
    }
    
    $pidList = $this->pi_getPidList($this->conf["pidList"], $this->conf["recursive"]);
    
      
	  /* Zum Testen der kompletten Query 
       
       /typo3_src-6.2.3/typo3/sysext/core/Classes/Database\DatabaseConnection.php
       
       Zeile 98: public $explainOutput = 2;
       
    */
    $ressource  = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
      "*",                     // SELECT
      "tx_pobdir_v_entry",     // FROM
      "pid IN (".$pidList.") AND deleted = 0 AND hidden = 0" . $addWhere, // WHERE
      "",                                             // GROUP BY
      "cat_sorting, stars DESC, name ASC",                            // ORDER BY
      $no_limit ? "" : $offset.",".$this->conf["pobdir_itemsPerPage"]  // LIMIT
    );

	  //echo "<br />".$addWhere."<br />";
	  
	  //echo "R=[".$_REQUEST['filter_ausstattung']."]<br />";
    //echo "A=[".$_SESSION['filter_ausstattung']."]<br />";
	
	  return $ressource;
	}
	
	function dbDate($date = "") {
    if($date && !is_a($date, 'stdClass') ) {
      if ( strpos($date,".") ) {
        $dat = explode(".", $date);
        if(@checkdate($dat[1],$dat[0],$dat[2])) {
          return sprintf ("%04d-%02d-%02d", $dat[2], $dat[1], $dat[0]);
        } else return false;
      } else if ( strpos($date,"-") ) {
        $dat = explode("-", $date);
        if ( @checkdate($dat[1], $dat[2], $dat[0]) ) {
          return sprintf ("%04d-%02d-%02d", $dat[0], $dat[1], $dat[2]);
        } else return false;
      }
    } else {
      return sprintf ("%04d-%02d-%02d", strftime("%Y"), strftime("%m"), strftime("%d"));
    }
  }


  function deDate( $date = "" ) {
    if ( $date ) {
      if ( strpos($date,":") ) {
        $date = explode(" ", $date);
        $dat = explode("-", $date[0]);
      } else $dat = explode("-", $date);
      if ( @checkdate($dat[1], $dat[2], $dat[0]) ) {
        return sprintf ("%02d.%02d.%04d", $dat[2], $dat[1], $dat[0]);
      } else return false;
    } else {
      return sprintf ("%02d.%02d.%04d", strftime("%d"), strftime("%m"), strftime("%Y"));
    }
  }
	
	
	function makeDetailBackLink($search)	{
		
		if( $this->piVars['modifier'] == 'search' ) {
      
      $code = "<span style='width:100px;'><form method='post' action='".$this->makeLink('','liste','search','',0)."'><input type='hidden' name='tx_pobdir_pi1[value]' value='".$value."'><input style='margin-right:30px; display:inline;' type='submit' value='".$this->pi_getLL("back")."'></form></span>";
    }
    
    else {
      $code = "<input style='margin-right:30px; display:inline;' type='button' value='".$this->pi_getLL('back')."' onclick='javascript:history.back()'>";    
    } 
                                            
		
	
	  return $code;
	}
	
	function makeDetailFooter($form = false) {
	
    
    if ( $form ) {
    
     
      $html = "
      456
      <form method='post' action='".$this->makeLink('','liste','search','',0)."'>
      <table border='0'>
      <tr>
        <td align='center'>
          <input type='submit' style='width:80px;margin-right:10px;' value='".$this->pi_getLL('back')."'>
          <input type='hidden' name='tx_pobdir_pi1[value]' value='".$value."'>
          <input type='button' style='width:80px;' value='".$this->pi_getLL('print')."' onclick='javascript:window.print()' style='display:inline'>
        </td>
      </tr>
      </table>
      </form>";
    }
    
    else {
    
      $html = "
      <table width='600' border='0'>
      <tr>
        <td align='center'>
          <input type='button' style='width:80px;margin-right:10px;' value='".$this->pi_getLL('back')."' onclick='javascript:history.back()'>
          <input type='button' style='width:80px;' value='".$this->pi_getLL('print')."' onclick='javascript:window.print()'>
        </td>
      </tr>
      </table>";
    
    }
    
    return $html;
    
  }
	
	
  function makeSearchbox($search)	{
		
		#$this->piVars[sword] = $search;
    
    $value = $this->piVars['modifier'] == 'search' ? $search : $this->search_default; 

		$code = '<form name="suchwort" method="post" action="'.$this->makeLink("","liste","search","",0).'">
             <input type="text" name="tx_pobdir_pi1[value]" onfocus="this.value=\'\'"';
					
		$code .= 	' value="'.$value.'"';
					
		$code .= ($this->piVars['modifier'] == 'search') ? ' style="color: '.$this->conf['pobdir_active'].';font-size: 10px;"' : ' style="font-size: 10px;"';		 
					
		$code .= '></form>';
	
	  return $code;
	}
	
	
	function makeButtonShowAll()	{

		$code = "<input type='button' value='".$this->pi_getLL("showall")."' onclick=\"self.location.href='".$GLOBALS['TSFE']->baseUrl.$this->makeLink('','liste','all')."'\" class='tx_pobdir-pi1-small'>";
	
	  return $code;
	}   
	
	
  function makeButtonShowFree()	{

		$code = "<input type='button' value='".$this->pi_getLL("showfree")."' onclick='frm_showfree_submit();' class='tx_pobdir-pi1-small'>";
	
	  return $code;
	} 
	
	
	function makeJumper($modifier,$value)	{
		
		$pidlist = $this->pi_getPidlist($this->conf["pidlist"],$this->conf["recursive"]);  
    
    $res  = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
      "DISTINCT tx_pobdir_category.name AS name, tx_pobdir_category.uid AS id",                        // SELECT
      "tx_pobdir_entry, tx_pobdir_category",               // FROM
      "tx_pobdir_entry.pid IN (".$pidlist.")"." ".$this->cObj->enableFields(tx_pobdir_entry)." AND tx_pobdir_category.uid = tx_pobdir_entry.category",                                 // WHERE
      '',                                 // GROUP BY
      'sorting',                          // ORDER BY
      ''                                  // LIMIT
    );
    
    $tempo = array();
        
    $select = $this->piVars['cat']; 
		

		while($tempo = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
                                        
      $entries .= "<option value='".$GLOBALS['TSFE']->baseUrl.$this->makeLink('', 'liste', 'cat', $tempo['id'], $cache=1, $pointer=0, '', $tempo['id'], $this->piVars['cap'])."'";
      $entries .= ($tempo['id'] == $select) ? " selected style='color: ".$this->conf['pobdir_active'].";'" : "";
      $entries .= ">".$tempo['name']."</option>";

		}
				
		$code="
		
		<script language=\"JavaScript\" type=\"text/JavaScript\">
		<!--
		function MM_jumpMenu(targ,selObj,restore){ 
  		eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
  		if (restore) selObj.selectedIndex=0;
		}
		//-->
		</script>

		<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><form name=\"form1\">
  		<tr>
   		<td><select name=\"cat\" id=\"kategorie\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"tx_pobdir-pi1-small\">
		<option value=\"".$this->pi_linkTP_keepPIvars_url("",1)."\">".$this->pi_getLL("category")."</option>".$entries."
  		</select></td>
  		</tr></form></table>
		
		";
	
	
	
	  return $code;
	}
	
	/**
	 * @deprecated	
	 */	
	function makePLZ($modifier,$value)	{
		
		/*
    
    #$class = ($modifier==zip) ? myformactive : myform; 
		$pidlist = $this->pi_getPidlist($this->conf["pidlist"],$this->conf["recursive"]);

		$query = "SELECT DISTINCT zip FROM tx_pobdir_entry WHERE tx_pobdir_entry.pid IN (".$pidlist.")"." ".$this->cObj->enableFields(tx_pobdir_entry)." ORDER BY zip";
		$res = mysql(TYPO3_db,$query);
		
		while($tempo = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))	{
			$entries .= '<option value="'.$this->makeLink("",liste,zip,$tempo[zip],$cache=1,$pointer=0).'"';
			$entries .= ($tempo['zip']==$value&&$modifier==zip) ? ' selected style="color: '.$this->conf[pobdir_active].'"' : "";
			$entries .= '>'.$tempo[zip].'</option>';
		}
		
		$code="
		
		<script language=\"JavaScript\" type=\"text/JavaScript\">
		<!--
		function MM_jumpMenu(targ,selObj,restore){ 
  		eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
  		if (restore) selObj.selectedIndex=0;
		}
		//-->
		</script>

		<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><form name=\"form1\">
  		<tr>
   		<td><select name=\"menu1\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"tx_pobdir-pi1-small\">
		<option value=\"".$this->pi_linkTP_keepPIvars_url("",1)."\">".$this->pi_getLL("zip")."</option>".$entries."
  		</select></td>
  		</tr></form></table>
		
		";
	
	  return $code;
	  
	  */
	
	}
	
	/**
	 * @deprecated
	 */   	
  function makeSelectOrt($modifier,$value)	{
		
		 
		/*          
		$pidlist = $this->pi_getPidlist($this->conf["pidlist"],$this->conf["recursive"]);

		$query = "SELECT DISTINCT city 
              FROM tx_pobdir_entry 
              WHERE tx_pobdir_entry.pid 
              IN (".$pidlist.")"." ".$this->cObj->enableFields(tx_pobdir_entry)." 
              ORDER BY city";
              
		$res = mysql(TYPO3_db,$query);
		

		while($tempo = mysql_fetch_assoc($res))	{

			//print_r($this->piVars); echo "<br />";
      
      $entries .= "<option value='".$this->makeLink('', 'liste', 'city', $tempo['city'], $cache=1, $pointer=0, $tempo['city'], $this->piVars['cat'])."'";
			
      $entries .= ($tempo['city'] == $this->piVars['city']) ? " selected style='color: ".$this->conf['pobdir_active']."'" : "";
			
      $entries .= ">".$tempo['city']."</option>";

		}
		
		$code="		
		<script language=\"JavaScript\" type=\"text/JavaScript\">
		<!--
		function MM_jumpMenu(targ,selObj,restore){ 
  		eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
  		if (restore) selObj.selectedIndex=0;
		}
		//-->
		</script>

    <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  		<tr>
   		<td>
        <select name=\"cap\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"tx_pobdir-pi1-small\">
		      <option value=\"".$this->pi_linkTP_keepPIvars_url("",1)."\">".$this->pi_getLL("city")."</option>".$entries."
  		  </select>
      </td>
  		</tr>
    </table>";
	
	  return $code;
	  */
	
	}
	
	
	function getMaxPersonenInKategorie($catid = null) {
	
	  $pidlist = $this->pi_getPidlist($this->conf["pidlist"],$this->conf["recursive"]);
	
	  $querycat = $catid 
    ? " AND tx_pobdir_entry.category = ".$this->piVars['cat']
    : "";    
    
    $res  = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
      "MAX(capacity) AS capacity",        // SELECT
      "tx_pobdir_entry",                  // FROM
      "tx_pobdir_entry.pid IN (".$pidlist.")"." ".$this->cObj->enableFields(tx_pobdir_entry) .$querycat,  // WHERE
      '',                                 // GROUP BY
      '',                                 // ORDER BY
      ''                                  // LIMIT
    );
    
		$data = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
		
		return $data['capacity'];
	
  }
	
	
	function makeSelectPersonen()	{
		
		 
		$max = $this->getMaxPersonenInKategorie($this->piVars['cat']);
	
		$select = $this->piVars['cap'] > $max ? $max : $this->piVars['cap'];
  
    for ( $i = 2 ; $i <= $max ; $i++ ) {

      $entries .= "<option value='".$GLOBALS['TSFE']->baseUrl.$this->makeLink('', 'liste', 'cap', $i, $cache=1, $pointer=0, '', $this->piVars['cat'], $i)."'";
			
      $entries .= ($i == $select) ? " selected style='color: ".$this->conf['pobdir_active']."'" : "";
			
      $entries .= ">".$i."</option>";

		}
	
		
		$code="		
		<script language=\"JavaScript\" type=\"text/JavaScript\">
		<!--
		function MM_jumpMenu(targ,selObj,restore){ 
  		eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
  		if (restore) selObj.selectedIndex=0;
		}
		//-->
		</script>

    <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  		<tr>
   		<td>
        <select name=\"menu1\" id=\"anz_personen\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"tx_pobdir-pi1-small\">
		      <option value=\"".$this->pi_linkTP_keepPIvars_url("",1)."\">".$this->pi_getLL("capacity")."</option>".$entries."
  		  </select>
      </td>
  		</tr>
    </table>";
	
	  return $code;
	
	}
	
	
	function getImage($image,$conf, $w=120,$lightbox=true)	{
	  
    $this->conf = $conf;
	  $imageConfig = $this->conf["image."];
		$imageConfig["file"] = "uploads/tx_pobdir/".$image;
		
	  $html = $lightbox
    ? "<a rel='lightbox[myImageSet]' href='".$imageConfig['file']."'><img src='".$imageConfig['file']."' alt='' width='".$w."' border='0' /></a>"
    : "<img src='".$imageConfig['file']."' alt='' width='".$w."' border='0' />";
	  
    return $html;
	}
	
	function getImageGallery($image, $conf, $h='120') {
	    
    $this->conf = $conf;
	  $imageConfig = $this->conf["image."];
		$imageConfig["file"] = "uploads/tx_pobdir/".$image;
			
		//print_r(getimagesize($imageConfig["file"])). "<br />";
		
		$html = "<a rel='lightbox[myImageSet]' href='".$imageConfig['file']."'><img class='pobdir-img' src='".$imageConfig['file']."' alt='' height='".$h."' border='0' /></a>";
 
    return $html; 	

  }
	
	function makeError($string)	{
		$this->fehler=1;
		return '<font color="red">'.$string.'</font>';
	}

	function makeForm($mode="enter",$modifier="first",$id="")	{	
	
		//Formular bauen			
		$this->listeTemplateCode = $this->cObj->fileResource($this->conf["pobdir_templateFile"]);
		$this->enter = $this->cObj->getSubpart($this->listeTemplateCode, "###ENTERVIEW###");
		$markerArray["###ACTION###"] = $this->pi_getPageLink($GLOBALS[TSFE]->page[uid])."&no_cache=1";
		$markerArray["###ERROR###"] = "";
		$markerArray["###DOTTED###"] = $this->pi_classParam("dotted");
		$markerArray["###SMALL###"] = $this->pi_classParam("small");
		$markerArray["###YOURENTRY###"] = $this->pi_getLL("yourentry");
		$markerArray["###NAME###"] = $this->pi_getLL("name");				
		$markerArray["###STREET###"] = $this->pi_getLL("street");
		$markerArray["###ZIP###"] = $this->pi_getLL("zip");
		$markerArray["###CITY###"] = $this->pi_getLL("city");
		$markerArray["###TEL###"] = $this->pi_getLL("tel");
		$markerArray["###FAX###"] = $this->pi_getLL("fax");
		$markerArray["###EMAIL###"] = $this->pi_getLL("email");
		$markerArray["###YOURENTRY###"] = $this->pi_getLL("your_entry");
		$markerArray["###WWW###"] = $this->pi_getLL("www");
		$markerArray["###IMAGE###"] = $this->pi_getLL("image");
		$markerArray["###PROFILE###"] = $this->pi_getLL("profile");
		$markerArray["###SUBMIT###"] = $this->pi_getLL("submit");
		$markerArray["###CATEGORY###"] = $this->pi_getLL("category");
		$markerArray["###SELECT###"] = $this->makeCategory($this->piVars[category]);
		
		switch($mode)	{
			case "enter":
				$hidden[mode]=enter;
				$hidden[modifier]=submit;
				switch($modifier)	{
					case "submit":
						$markerArray = $this->evalForm($markerArray);
						if(!$this->fehler)	{
							$image=$this->storeImage();					
							$goto = $this->storeDB($image);
							$success = $this->makeSuccess($goto);
						}
						else	{
							$markerArray["###NAMEV###"] = $this->piVars[name];				
							$markerArray["###STREETV###"] = $this->piVars[street];
							$markerArray["###ZIPV###"] = $this->piVars[zip];
							$markerArray["###CITYV###"] = $this->piVars[city];
							$markerArray["###TELV###"] = $this->piVars[tel];
							$markerArray["###FAXV###"] = $this->piVars[fax];
							$markerArray["###EMAILV###"] = $this->piVars[email];
							$markerArray["###WWWV###"] = $this->piVars[www];
							$markerArray["###PROFILEV###"] = $this->piVars[profile];					
						}
					break;
					default:
						$markerArray["###NAMEV###"] = "";				
						$markerArray["###STREETV###"] = "";
						$markerArray["###ZIPV###"] = "";
						$markerArray["###CITYV###"] = "";
						$markerArray["###TELV###"] = "";
						$markerArray["###FAXV###"] = "";
						$markerArray["###EMAILV###"] = "";
						$markerArray["###WWWV###"] = "";
						$markerArray["###PROFILEV###"] = "";
					break;
				}

			
			break;
			case "edit";
				$markerArray["###IMAGE###"] = $this->pi_getLL("new_image");
				$markerArray["###SUBMIT###"] = $this->pi_getLL("edit_delete");
				$markerArray["###HIDDEN###"] = '<input name="tx_pobdir_pi1[delete]" type="checkbox" id="tx_pobdir_pi1[delete]" value="1">'.$this->pi_getLL("delete").'&nbsp;&nbsp;&nbsp;';
				
				$hidden[mode]=edit;
				$hidden[modifier]=submit;
				$hidden[value]=$id;
				switch($modifier)	{
					case "submit";
						if($this->piVars[delete])	{
							$this->deleteFromDB($id);
							$success = $this->makeSuccess($goto);
						}
						else	{
							$markerArray = $this->evalForm($markerArray);
							if(!$this->fehler)	{
								$image=$this->storeImage();					
								$goto = $this->updateDB($image,$id);
								$success = $this->makeSuccess($goto);
							
							}
							else	{
								$markerArray["###NAMEV###"] = $this->piVars[name];				
								$markerArray["###STREETV###"] = $this->piVars[street];
								$markerArray["###ZIPV###"] = $this->piVars[zip];
								$markerArray["###CITYV###"] = $this->piVars[city];
								$markerArray["###TELV###"] = $this->piVars[tel];
								$markerArray["###FAXV###"] = $this->piVars[fax];
								$markerArray["###EMAILV###"] = $this->piVars[email];
								$markerArray["###WWWV###"] = $this->piVars[www];
								$markerArray["###PROFILEV###"] = $this->piVars[profile];	
							}
						}
					break;
					default:
						//Get Data from DB
						$pidlist = $this->pi_getPidlist($this->conf["pidlist"],$this->conf["recursive"]);
						$query = "SELECT * FROM tx_pobdir_entry WHERE pid IN (".$pidlist.")"." ".$this->cObj->enableFields(tx_pobdir_entry)." AND uid = ".$id;
						$res = mysql(TYPO3_db,$query);
						$row = mysql_fetch_assoc($res);
						
						//Assign Data to Fields
						$markerArray["###NAMEV###"] = $row[name];				
						$markerArray["###STREETV###"] = $row[street];
						$markerArray["###ZIPV###"] = $row[zip];
						$markerArray["###CITYV###"] = $row[city];
						$markerArray["###TELV###"] = $row[tel];
						$markerArray["###FAXV###"] = $row[fax];
						$markerArray["###EMAILV###"] = $row[email];
						$markerArray["###WWWV###"] = $row[www];
						$markerArray["###PROFILEV###"] = $row[profile];
						$markerArray["###SELECT###"] = $this->makeCategory($row[category]);
						
					break;
				}
		}
		$markerArray["###HIDDEN###"] .= $this->makeHidden($hidden);




	
		$return = (!$success) ? $this->cObj->substituteMarkerArrayCached($this->enter,$markerArray,array(),array()) : $success;
	
	return $return;	
	}	
	
	function makeHidden($hidden)	{
		while(list($key,$value) = each($hidden))	{
			$code .= '<input type="hidden" name="tx_pobdir_pi1['.$key.']" value="'.$value.'">';
		}
	return $code;
	}
	
	#function makeErrorForm()	{
				//Nach Submit Fehlercheck
		#$markerArray = ($this->piVars[submit]) ? $this->evalForm($markerArray) : $markerArray;
	#return $markerArray;
	#}
	
	function evalForm($markerArray)	{
	
		$markerArray["###NAME###"] = ($this->piVars[name]) ? $markerArray["###NAME###"] : $this->makeError($markerArray["###NAME###"]);			
		$markerArray["###STREET###"] = ($this->piVars[street]) ? $markerArray["###STREET###"] : $this->makeError($markerArray["###STREET###"]);	
		$markerArray["###ZIP###"] = (preg_match("([0-9]{5})",$this->piVars[zip])) ? $markerArray["###ZIP###"] : $this->makeError($markerArray["###ZIP###"]);
		$markerArray["###CITY###"] = ($this->piVars[city]) ? $markerArray["###CITY###"] : $this->makeError($markerArray["###CITY###"]);
		$markerArray["###EMAIL###"] = (preg_match("(^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$)",$this->piVars[email])) ? $markerArray["###EMAIL###"] : $this->makeError($markerArray["###EMAIL###"]);
		$markerArray["###WWW###"] = (preg_match("/^(http:|ftp:\/\/).*(\.+).*/i",$this->piVars[www])) ? $markerArray["###WWW###"] : $this->makeError($markerArray["###WWW###"]);
		$markerArray["###ERROR###"] = ($this->fehler) ? "<font color=red>".$this->pi_getLL("error")."</font><br><br>" : "";
		$markerArray["###IMAGE###"] = ($this->evalImage()!=error) ? $markerArray["###IMAGE###"] : $this->makeError($markerArray["###IMAGE###"]);	
		$markerArray["###CATEGORY###"] = ($this->piVars[category]) ? $markerArray["###CATEGORY###"] : $this->makeError($markerArray["###CATEGORY###"]);	


#debug($this->evalImage());
		
	return $markerArray;
	}
	
	function evalImage()	{
		//Bildtyp checken
		$bildtypen = array("gif","jpg","png");
		
		//Bild vorhanden?
		if($this->piVars[image]!=none)	{
		
			@$typ = getimagesize($this->piVars[image]);
			if($typ[2]!= 1 && $typ[2]!= 2 && $typ[2]!= 3 || $GLOBALS[tx_pobdir_pi1_size][image]>210000)	{
				$type=error;
			}
			else	{
				$type=$bildtypen["$typ[2]"];
			}
		}
		else	{
			$type=none;
		}
		
		
	return $type;
	}
	
	function storeDB($image)	{
	
		$query='INSERT INTO tx_pobdir_entry (pid,tstamp,crdate,cruser_id,name,street,zip,city,tel,fax,email,www,profile,image,category,belongsto) 
				VALUES ("'.$GLOBALS["TSFE"]->page[uid].'","'.time().'","'.time().'",1,"'.$this->piVars[name].'","'.$this->piVars[street].'","'.$this->piVars[zip].'","'.$this->piVars[city].'","'.$this->piVars[tel].'","'.$this->piVars[fax].'","'.$this->piVars[email].'","'.$this->piVars[www].'","'.strip_tags($this->piVars[profile]).'","'.$image.'","'.$this->piVars[category].'","'.$GLOBALS['TSFE']->fe_user->user[ses_userid].'")';
		$res = mysql(TYPO3_db,$query);
		
		$id=mysql_insert_id();
		
		$res = mysql (TYPO3_db, "DELETE FROM cache_pages WHERE page_id = ".$GLOBALS["TSFE"]->page[uid]);
	
	return $id;
	}
	
	function updateDB($image,$id)	{
	
		$query =	"UPDATE tx_pobdir_entry SET 
					name = '".$this->piVars[name]."',
					street = '".$this->piVars[street]."',
					city = '".$this->piVars[city]."',
					tel = '".$this->piVars[tel]."',
					fax = '".$this->piVars[fax]."',
					email = '".$this->piVars[email]."',
					www = '".$this->piVars[www]."',
					profile = '".strip_tags($this->piVars[profile])."',";
					
		$query .= ($image) ? "image = '".$image."'," : "";
				
		$query .=	"category = '".$this->piVars[category]."'
					WHERE uid = '".$id."'";
		
		$res = mysql(TYPO3_db,$query);
		$res = mysql (TYPO3_db, "DELETE FROM cache_pages WHERE page_id = ".$GLOBALS["TSFE"]->page[uid]);
	}
	
	function deleteFromDB($id)	{
		$query = "DELETE FROM tx_pobdir_entry WHERE uid = $id";
		$res = mysql(TYPO3_db,$query);
		$res = mysql (TYPO3_db, "DELETE FROM cache_pages WHERE page_id = ".$GLOBALS["TSFE"]->page[uid]);
	}
	
	function storeImage()	{

		if($GLOBALS[HTTP_POST_FILES][tx_pobdir_pi1][name][image])	{

			$this->fileFunc = t3lib_div::makeInstance("t3lib_basicFileFunctions");
			$sauber = $this->fileFunc->cleanFileName($GLOBALS[HTTP_POST_FILES][tx_pobdir_pi1][name][image]); 
			$unique = $this->fileFunc->getUniqueName($sauber,PATH_site.$TYPO3_LOADED_EXT[$key]["siteRelPath"]."uploads/tx_pobdir/");
			move_uploaded_file($this->piVars[image],$unique);		
		}
		$return = pathinfo($unique);

	return $return[basename];
	
	}
	
	function makeCategory($id)	{
		
		$pidlist = $this->pi_getPidlist($this->conf["pidlist"],$this->conf["recursive"]);
    
    $query = "SELECT uid, name 
              FROM tx_pobdir_category 
              WHERE pid IN (".$pidlist.")"." ".$this->cObj->enableFields(tx_pobdir_category)." 
              ORDER BY sorting, name";
              
		$res = mysql(TYPO3_db,$query);
		
		while($tempo = mysql_fetch_assoc($res))	{

			$entries .= '<option value="'.$tempo[uid].'"';
			$entries .= ($tempo[uid]==$id) ? " selected" : "";
			$entries .= '>'.$tempo[name].'</option>';
		}
		
		$code='
		<select name="tx_pobdir_pi1[category]" class="tx_pobdir-pi1-small">
		<option value="">'.$this->pi_getLL("category").'</option>
		'.$entries.'
  		</select>
		';
	  
    return $code;
    
	}

	function makeSuccess($goto)	{
		
		$success = $this->cObj->getSubpart($this->listeTemplateCode, "###SUCCESSVIEW###");
		$markerArray["###DOTTED###"] = $this->pi_classParam("dotted");
		$markerArray["###SMALL###"] = $this->pi_classParam("small");
		$url[tx_pobdir_pi1][detail]=$goto;
		#pi_linkTP ($str, $urlParameters=array(), $cache=0)
		unset($this->piVars);
		$markerArray["###BACK###"] = $this->makeLink($this->pi_getLL("back"),liste,abc,all);
		$markerArray["###THANKS###"] =$this->pi_getLL("thanks");
		$markerArray["###YOURENTRY###"] =$this->pi_getLL("yourentry");
		
		$success = $this->cObj->substituteMarkerArrayCached($success,$markerArray,array(),array());	
		
	  return $success;
	  
	}

}



if (defined("TYPO3_MODE") && $TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/pobdir/pi1/class.tx_pobdir_pi1.php"])	{
	//include_once($TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/pobdir/pi1/class.tx_pobdir_pi1.php"]);
}
?>