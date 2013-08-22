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
 * Configure the extension.
 *
 * @author duda|design GbR
 * @version 1.0
 *
 */
class Tx_DdSponsorship_Controller_SponsorshipKonfigurationController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * sponsorshipKonfigurationRepository
	 *
	 * @var Tx_DdSponsorship_Domain_Repository_SponsorshipKonfigurationRepository
	 */
	protected $sponsorshipKonfigurationRepository;

	/**
	 * Sends data to template file.
	 *
	 * @param array $ms contains error messages
	 * @return void
	 */
	public function indexAction(array $ms = NULL) {

		// Holt sich alle Datensätze aus der Config Tabelle
		$this -> sponsorshipKonfigurationRepository = t3lib_div::makeInstance('Tx_DdSponsorship_Domain_Repository_SponsorshipKonfigurationRepository');
		$getConfig = $this -> sponsorshipKonfigurationRepository -> getConfig();

		// Daten werden ans Template übergeben
		$this -> view -> assign('pate_id', $getConfig[0][pate_id]);
		$this -> view -> assign('pate_kind_id', $getConfig[0][paten_kind_id]);
		$this -> view -> assign('email', $getConfig[0][email]);
		$this -> view -> assign('page_details_uid', $getConfig[0][page_details_uid]);
		$this -> view -> assign('page_profil_uid', $getConfig[0][page_profil_uid]);
		$this -> view -> assign('mail_url', $getConfig[0][mail_url]);
		$this -> view -> assign('page_verwaltung_uid', $getConfig[0][page_verwaltung_uid]);
		$this -> view -> assign('page_profil_real_uid', $getConfig[0][page_profil_real_uid]);

		// Default-Pfad der E-Mail Template
		if ($getConfig[0][mail_url] == "") {
			$this -> view -> assign('mail_url', 'typo3conf/ext/dd_sponsorship/Resources/Mails/');
		}
		
		// Fehlermeldungen ausgeben.
		if ($ms[ms] != "") {
			$this -> view -> assign('done_msg', Tx_Extbase_Utility_Localization::translate(config_done, DdSponsorship));
		}
		if ($ms[er] != "") {
			$this -> view -> assign('error_msg', Tx_Extbase_Utility_Localization::translate(config_error, DdSponsorship));
		}
	}

	/**
	 * Process after sending the submit button.
	 *
	 * @param array $global Contains some informations from the from. Sending informations, after submit, to indexAction.
	 * @return void
	 */
	public function submitAction(array $global = NULL) {

		//Validierung
		if (!ctype_digit($global[pateId]) || !ctype_digit($global[patenKindId]) || $global[email] == "" || strlen($global[email] > 150 || !ctype_digit($global[page_details_uid]) || !ctype_digit($global[page_profil_uid]) || !ctype_digit($global[page_verwaltung_uid])|| !ctype_digit($global[page_profil_real_uid]))) {
			$error = "1";
		}
		//Speichern
		else {
			$done = "1";
			$this -> sponsorshipKonfigurationRepository = t3lib_div::makeInstance('Tx_DdSponsorship_Domain_Repository_SponsorshipKonfigurationRepository');
			$this -> sponsorshipKonfigurationRepository -> setConfig($global);
		}
		//Meldungen generieren
		$ms = array("ms" => $done, "er" => $error);
		$this -> redirect('index', 'SponsorshipKonfiguration', NULL, array('ms' => $ms));
	}

}
?>