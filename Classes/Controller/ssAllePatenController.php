<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 * Show all sponsors.
 *
 * @author duda|design GbR
 * @version 1.0
 *
 */
class Tx_DdSponsorship_Controller_ssAllePatenController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * Sends all data from database to the template file.
	 *
	 * @return void
	 */
	public function indexAction() {

		//Cache leeren
		$this -> cacheService -> clearPageCache($pidList);
		
		//Ruft die aktuelle Session User ID auf.
		$uid = $GLOBALS['TSFE'] -> fe_user -> user[uid];
		

		//Ruft alle Mitglieder auf, die der Gruppe Paten angehören.
		$this -> sponsorshipKonfigurationRepository = t3lib_div::makeInstance('Tx_DdSponsorship_Domain_Repository_SponsorshipKonfigurationRepository');
		$getAllePaten = $this -> sponsorshipKonfigurationRepository -> getVerfuegbarePaten($uid);

		//Konfigurationswerte
		$getConfig = $this -> sponsorshipKonfigurationRepository -> getConfig();
		$detailsId = $getConfig[0][page_details_uid];
		$pagination = $getConfig[0][pagination];

		//Übergibt Daten ans Template
		$this -> view -> assign('entry', $getAllePaten);
		$this -> view -> assign('url', $detailsId);
	}

}
?>