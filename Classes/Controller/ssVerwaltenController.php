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
 * Change stats of connected peopels
 *
 * @author duda|design GbR
 * @version 1.0
 *
 */
class Tx_DdSponsorship_Controller_ssVerwaltenController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * sponsorshipKonfigurationRepository
	 *
	 * @var Tx_DdSponsorship_Domain_Repository_SponsorshipLinkRepository
	 */
	protected $sponsorshipLinkRepository;

	/**
	 * Sending informations into form
	 *
	 * @param array $ms Contains error messages
	 * @return void
	 */
	public function indexAction(array $ms = NULL) {

		//Löscht den aktuellen Cache
		$this -> cacheService -> clearPageCache($pidList);

		//Ruft Verbindungen zwischen Paten und Patenkinder auf
		$this -> sponsorshipLinkRepository = t3lib_div::makeInstance('Tx_DdSponsorship_Domain_Repository_SponsorshipLinkRepository');
		$paten = $this -> sponsorshipLinkRepository -> getPaten(null);
		$this -> view -> assign('entry', $paten);
		
		//Fehlermeldungen ausgeben.
		if (!is_null($ms[done])) {
			$this -> view -> assign('done_msg', $ms[done]);
		}
	}

	/**
	 * Change stats after click
	 *
	 * @return void
	 */
	public function statusAction() {

		//Ruft Verbindungen zwischen Paten und Patenkinder auf
		$this -> sponsorshipLinkRepository = t3lib_div::makeInstance('Tx_DdSponsorship_Domain_Repository_SponsorshipLinkRepository');
		$paten = $this -> sponsorshipLinkRepository -> getPaten(null);

		//Status ändern und Datensatz löschen
		if ($this -> request -> hasArgument('getUid') && $this -> request -> hasArgument('getStatus')) {
			$getUid = $this -> request -> getArgument('getUid');
			$getStatus = $this -> request -> getArgument('getStatus');

			//Beenden
			if ($getStatus == "0") {
				$this -> sponsorshipLinkRepository -> changeState($getUid, 0);
			}
			//Aktivieren
			if ($getStatus == "1") {
				$this -> sponsorshipLinkRepository -> changeState($getUid, 1);
			}
			//Wartezustand
			if ($getStatus == "2") {
				$this -> sponsorshipLinkRepository -> changeState($getUid, 2);
			}
			//Abgelehnt
			if ($getStatus == "3") {
				$this -> sponsorshipLinkRepository -> changeState($getUid, 3);
			}
			//Löschen
			if ($getStatus == "4") {
				$this -> sponsorshipLinkRepository -> deleteConnection($getUid);
			}

			//Meldungen generieren
			$ms = Tx_Extbase_Utility_Localization::translate(verwalten_doneMS, DdSponsorship);

		}
		$ms = array("done" => $ms);
		$this -> redirect('index', 'ssVerwalten', NULL, array('ms' => $ms));
	}

}
?>