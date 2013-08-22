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
 * Add peoples into the sponsorship program.
 *
 * @author duda|design GbR
 * @version 1.0
 *
 */
class Tx_DdSponsorship_Controller_ssEintretenController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * Show messages during a joining request.
	 *
	 * @param array $ms Contains error messages
	 * @return void
	 */
	public function indexAction(array $ms = NULL) {

		//Cache leeren
		$this -> cacheService -> clearPageCache($pidList);

		$info_text = Tx_Extbase_Utility_Localization::translate(eintreten_info_text, DdSponsorship);

		//Fehlermeldungen ausgeben.
		if ($ms[ms] == "ERROR") {
			$this -> view -> assign('ms', Tx_Extbase_Utility_Localization::translate(eintreten_errorMS_closed, DdSponsorship));
		}
		if ($ms[ms] == "NO") {
			$this -> view -> assign('ms', Tx_Extbase_Utility_Localization::translate(eintreten_errorMS_already, DdSponsorship));
		}
		if ($ms[ms] == "Pate") {
			$this -> view -> assign('ms', Tx_Extbase_Utility_Localization::translate(eintreten_MS_pate, DdSponsorship) . $info_text);
		}
		if ($ms[ms] == "Patenkind") {
			$this -> view -> assign('ms', Tx_Extbase_Utility_Localization::translate(eintreten_MS_patenkind, DdSponsorship) . $info_text);
		}
		
		//Holt sich alle Datensätze aus der Config Tabelle
		$this -> sponsorshipKonfigurationRepository = t3lib_div::makeInstance('Tx_DdSponsorship_Domain_Repository_SponsorshipKonfigurationRepository');
		$getConfig = $this -> sponsorshipKonfigurationRepository -> getConfig();
		$this -> view -> assign('profil_id', $getConfig[0][page_profil_uid]);
	}

	/**
	 * Triggered the requst form
	 *
	 * @return void
	 */
	public function submitAction() {

		//Ruft die User Session ID auf
		$uid = $GLOBALS['TSFE'] -> fe_user -> user[uid];

		//Fügt das Mitglied der Grupp Paten bzw. Patenkinder hinzu
		$this -> sponsorshipKonfigurationRepository = t3lib_div::makeInstance('Tx_DdSponsorship_Domain_Repository_SponsorshipKonfigurationRepository');
		$addUser = $this -> sponsorshipKonfigurationRepository -> AddUser($uid);

		$done = $addUser;

		//Meldungen generieren
		$ms = array("ms" => $done, "er" => $error);
		$this -> redirect('index', 'ssEintreten', NULL, array('ms' => $ms));
	}

}
?>