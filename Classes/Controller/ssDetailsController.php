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
 * View sponsors and sponsored child. Further some functions for request processed.
 *
 * @author duda|design GbR
 * @version 1.0
 *
 */
class Tx_DdSponsorship_Controller_ssDetailsController extends Tx_Extbase_MVC_Controller_ActionController {

	private $sponsorshipKonfigurationRepository;
	private $sponsorshipLinkRepository;
	private $config;
	private $sponsorInfo;
	private $childInfo;
	private $baseUrl;

	public function __construct() {
		$this -> baseUrl = $GLOBALS['TSFE'] -> baseUrl;
		$this -> sponsorshipKonfigurationRepository = t3lib_div::makeInstance('Tx_DdSponsorship_Domain_Repository_SponsorshipKonfigurationRepository');
		$this -> sponsorshipLinkRepository = t3lib_div::makeInstance('Tx_DdSponsorship_Domain_Repository_SponsorshipLinkRepository');
		$this -> config = $this -> sponsorshipKonfigurationRepository -> getConfig();
	}

	/**
	 * Contains informations about sponsors and sponsored child
	 * Contains error messages
	 * Send e-mails
	 *
	 * @param array $ms Contains error messages
	 * @return void
	 */
	public function indexAction(array $ms = NULL) {

		print_r($this -> baseUrl);

		//Cache leeren
		$this -> cacheService -> clearPageCache($pidList);

		//Ruft die aktuelle Session User ID auf.
		$uid = $GLOBALS['TSFE'] -> fe_user -> user[uid];

		// normal call
		if ($this -> request -> hasArgument('uid')) {
			$p_id = $this -> request -> getArgument('uid');
			$this -> view -> assign('akID', $p_id);
			$p_id = $p_id / 1373;
		}
		// call after request
		if ($this -> request -> hasArgument('akID')) {
			$p_id = $this -> request -> getArgument('akID');
			$p_id = $p_id / 1373;
			$click = "1";
		}
		if ($this -> request -> hasArgument('anfrage_ms')) {
			$anfrage_ms = $this -> request -> getArgument('anfrage_ms');
		}

		$this -> sponsorInfo = $this -> sponsorshipKonfigurationRepository -> getUserInfo($p_id);
		$this -> childInfo = $this -> sponsorshipKonfigurationRepository -> getUserInfo($uid);

		//Holt sich alle Datensätze aus der Config Tabelle
		$prufId = $this -> sponsorInfo[0][fuid];
		$this -> view -> assign('prufId', $prufId);
		$this -> view -> assign('profil_id', $this -> config[0][page_profil_uid]);

		//Profil ist Pate oder Patenkind
		if ($this -> sponsorshipKonfigurationRepository -> isPate($p_id)) {
			$this -> view -> assign('pate_profil', "1");
		} elseif ($this -> sponsorshipKonfigurationRepository -> isPatenkind($p_id)) {
			$this -> view -> assign('patenkind_profil', "1");
		}

		//User ist Pate oder Patenkind
		$isPate = $this -> sponsorshipKonfigurationRepository -> getAllePaten($uid);
		if ($this -> sponsorshipKonfigurationRepository -> isPate($uid)) {
			$this -> view -> assign('pate', "1");
		}
		if ($this -> sponsorshipKonfigurationRepository -> isPatenkind($uid)) {
			$this -> view -> assign('patenkind', "1");
		}

		if ($uid == $p_id) {
			$this -> view -> assign('own', "1");
		} else {

			if (strlen($anfrage_ms) > 500) {
				$this -> view -> assign('check', "text");
			} else {

				// Prüfen ob User im Patenprogramm und selbst Pate ist
				if ($this -> sponsorshipKonfigurationRepository -> isPate($p_id)) {
					$this -> view -> assign('isPate', '');
				}

				// Überprüfung der Anfrage-Voraussetzungen
				$check = "success";

				// Die Maximale an verfügbaren Patenkinder Plätze ist erreicht
				if ($this -> sponsorshipKonfigurationRepository -> getAnzahlPatenkinder($p_id) >= $this -> sponsorInfo[0][sponsorship_anzahl_paten]) {
					$this -> view -> assign('check', Tx_Extbase_Utility_Localization::translate(page_profil_details_error_max, DdSponsorship));
					$check = "max";
				}

				// Ist bereits in einer Patenschaft
				if ($this -> sponsorshipKonfigurationRepository -> connectionIsActive(null, null, $uid)) {
					$this -> view -> assign('check', Tx_Extbase_Utility_Localization::translate(page_profil_details_error_already_anfrage, DdSponsorship));
					$check = "active";
				}
				// Hat bereits eine aktive oder eine laufende anfrage
				if ($this -> sponsorshipKonfigurationRepository -> connectionIsPending(null, null, $uid)) {
					$this -> view -> assign('check', Tx_Extbase_Utility_Localization::translate(page_profil_details_error_already, DdSponsorship));
					$check = "pending";
				}
				// Profil wurde nicht ausgefüllt
				if ($this -> childInfo[0][sponsorship_expectations_kind] == "") {
					$this -> view -> assign('check', Tx_Extbase_Utility_Localization::translate(page_profil_details_error_profil, DdSponsorship));
					$check = "empty";
				}

				// Eine Anfrage kann stattfinden.
				if ($check == "success") {
					$this -> view -> assign('check', '');
				}

				// Button wurde gedrückt
				if ($click != "" && $check == "success") {

					// Fügt die neue Anfrage hinzug.
					$last = $this -> sponsorshipLinkRepository -> addConnection($p_id, $uid, '2');

					$this -> view -> assign('check', Tx_Extbase_Utility_Localization::translate(page_profil_details_error_ok, DdSponsorship));

					// E-Mail senden
					$replyto = $this -> childInfo[0][email];
					$betreff = Tx_Extbase_Utility_Localization::translate(email_anfrage_anfrage, DdSponsorship);
					$inhalt = $anfrage_ms;
					$an = $this -> sponsorInfo[0][email];

					$this -> StuffController = t3lib_div::makeInstance('Tx_DdSponsorship_Controller_StuffController');
					$renderer = $this -> StuffController -> getPlainTextEmailRenderer('anfrage', null);

					//E-Mail Inhalt generieren.
					$renderer -> assign('vorname_an', $this -> sponsorInfo[0][first_name]);
					$renderer -> assign('userMS', $inhalt);
					$renderer -> assign('pate_vorname', $this -> childInfo[0][first_name]);
					$renderer -> assign('pate_nachname', $this -> childInfo[0][last_name]);
					$renderer -> assign('pate_email', $this -> childInfo[0][email]);
					$renderer -> assign('pate_phone', $this -> childInfo[0][telephone]);
					$renderer -> assign('pate_city', $this -> childInfo[0][city]);
					$renderer -> assign('pate_erwartung', $this -> childInfo[0][sponsorship_expectations_kind]);
					$renderer -> assign('details_id', $this -> config[0][page_details_uid]);
					$renderer -> assign('verwalten_id', $this -> config[0][page_verwaltung_uid]);
					$renderer -> assign('anid', $last);
					$renderer -> assign('abid', $last);
					$renderer -> assign('uid', $this -> childInfo[0][fuid] * 1373);
					$renderer -> assign('baseUrl', $this -> baseUrl);

					$message = $renderer -> render();

					$this -> StuffController -> sendMail($an, $betreff, $message, $replyto);
				}
			}
		}
		$this -> view -> assign('entry', $this -> sponsorInfo);

		// Vor und Zurück Infos
		$this -> view -> assign('details_uid', $this -> config[0][page_details_uid]);
		$vor = $this -> sponsorshipKonfigurationRepository -> getNextSponsor($p_id, $uid);
		$this -> view -> assign('vor', $vor[0][fuid] * 1373);
		$zurueck = $this -> sponsorshipKonfigurationRepository -> getPrevSponsor($p_id, $uid);
		$this -> view -> assign('zurueck', $zurueck[0][fuid] * 1373);
		$this -> view -> assign('vorUndZurueck', !is_null($vor[0][fuid]) && !is_null($zurueck[0][fuid]));
	}

	/**
	 * Contains error messages
	 *
	 * @return void
	 */
	public function submitAction() {
		$done = "1";
		//Meldungen generieren
		$ms = array("ms" => $done, "er" => $error);
		$this -> redirect('index', 'ssDetails', NULL, array('ms' => $ms));
	}

}
?>
