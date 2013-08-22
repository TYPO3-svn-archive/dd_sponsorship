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
 * Adiministraions of all connections
 *
 * @author duda|design GbR
 * @version 1.0
 *
 */
class Tx_DdSponsorship_Controller_ssVerwaltungController  extends Tx_Extbase_MVC_Controller_ActionController {

	private $uid;
	private $sponsorshipKonfigurationRepository;
	private $sponsorshipLinkRepository;
	private $stuffController;
	private $config;
	private $requestId;
	private $sponsorId;
	private $childId;
	private $action;
	private $viewNotEmpty = false;

	public function __construct() {
		$this -> uid = $GLOBALS['TSFE'] -> fe_user -> user[uid];
		$this -> sponsorshipKonfigurationRepository = t3lib_div::makeInstance('Tx_DdSponsorship_Domain_Repository_SponsorshipKonfigurationRepository');
		$this -> sponsorshipLinkRepository = t3lib_div::makeInstance('Tx_DdSponsorship_Domain_Repository_SponsorshipLinkRepository');
		$this -> stuffController = t3lib_div::makeInstance('Tx_DdSponsorship_Controller_StuffController');

		$this -> config = $this -> sponsorshipKonfigurationRepository -> getConfig();
		$this -> action = "view";
	}

	/**
	 * View active sponsor, sponsored child, requests and finished sponsor or sponsored child
	 * Send emails to sponsor an sponsored child after changing the stats
	 * Processed: accept and decline the requests.
	 *
	 * @param array $ms Contains error messages
	 * @return void
	 */
	public function indexAction() {

		$this -> cacheService -> clearPageCache($pidList);

		// angemeldeter Benutzer ist Patenkind
		if ($this -> sponsorshipKonfigurationRepository -> isPatenkind($this -> uid)) {

			// zurückziehen einer Anfrage
			if ($this -> request -> hasArgument('pid')) {
				$this -> requestId = $this -> request -> getArgument('pid');
				$this -> action = "revoke";
			} else {

				$activeSponsor = $this -> sponsorshipKonfigurationRepository -> getActiveSponsor($this -> uid);
				$this -> view -> assign('activeSponsor', $activeSponsor);
				$this -> view -> assign('activeSponsorCheck', count($activeSponsor) > 0);

				$pendingSponsor = $this -> sponsorshipKonfigurationRepository -> getPendingSponsor($this -> uid);
				$this -> view -> assign('pendingSponsor', $pendingSponsor);
				$this -> view -> assign('pendingSponsorCheck', count($pendingSponsor) > 0);

				$this -> viewNotEmpty = $this -> viewNotEmpty || count($activeSponsor) > 0 || count($pendingSponsor) > 0;
			}
		}

		// angemeldeter Nutzer ist Pate
		elseif ($this -> sponsorshipKonfigurationRepository -> isPate($this -> uid)) {

			$this -> view -> assign('isPate', '1');

			// annehmen der Anfrage durch den Paten
			if ($this -> request -> hasArgument('an')) {
				$this -> requestId = $this -> request -> getArgument('an');
				$this -> action = "accept";
			}

			// ablehnen der Anfrage durch den Paten
			elseif ($this -> request -> hasArgument('ab')) {
				$this -> requestId = $this -> request -> getArgument('ab');
				$this -> action = "refuse";
			} else {

				$activeChildren = $this -> sponsorshipKonfigurationRepository -> getActiveChildren($this -> uid);
				$this -> view -> assign('activeChildren', $activeChildren);
				$this -> view -> assign('activeChildrenCheck', count($activeChildren) > 0);

				$pendingChildren = $this -> sponsorshipKonfigurationRepository -> getPendingChildren($this -> uid);
				$this -> view -> assign('pendingChildren', $pendingChildren);
				$this -> view -> assign('pendingChildrenCheck', count($pendingChildren) > 0);

				$this -> viewNotEmpty = $this -> viewNotEmpty || count($activeChildren) > 0 || count($pendingChildren) > 0;
			}

		}

		if (isset($this -> requestId)) {

			// Anfrage ist bereits beantwortet
			if (!$this -> sponsorshipKonfigurationRepository -> connectionIsPending($this -> requestId)) {
				$this -> action = "answered";
			}

			$connection = $this -> sponsorshipKonfigurationRepository -> getConnection($this -> requestId);
			$this -> sponsorId = $connection[0]['pate'];
			$this -> childId = $connection[0]['paten_kind'];
		}

		switch ($this -> action) {
			case 'revoke' :
				// zurückziehen
				$this -> sponsorshipLinkRepository -> deleteConnection($this -> requestId, null, $this -> uid);
				$this -> view -> assign('ms', Tx_Extbase_Utility_Localization::translate(page_verwaltung_ms_back, DdSponsorship));
				break;
			case 'accept' :
				// annehmen
				$this -> sponsorshipLinkRepository -> changeState($this -> requestId, 1);
				$this -> view -> assign('ms', Tx_Extbase_Utility_Localization::translate(page_verwaltung_ms_angenommen, DdSponsorship));
				$subject = Tx_Extbase_Utility_Localization::translate(email_anfrage_angenommen, DdSponsorship);
				$this -> sendEmail($subject, 'angenommen');
				break;
			case 'refuse' :
				// ablehnen
				$this -> sponsorshipLinkRepository -> changeState($this -> requestId, 3);
				$this -> view -> assign('ms', Tx_Extbase_Utility_Localization::translate(page_verwaltung_ms_abgelehnt, DdSponsorship));
				$subject = Tx_Extbase_Utility_Localization::translate(email_anfrage_abgelehnt, DdSponsorship);
				$this -> sendEmail($subject, 'abgelehnt');
				break;
			case 'answered' :
				// bereits beantworted
				$this -> view -> assign('ms', Tx_Extbase_Utility_Localization::translate(page_verwaltung_ms_beantwortet, DdSponsorship));
				break;

			case 'view' :
				// normaler Seitenaufruf
				$this -> view -> assign('verwalten_url', $this -> config[0][page_verwaltung_uid]);
				$this -> view -> assign('details_url', $this -> config[0][page_details_uid]);
				$this -> view -> assign('profil_id', $this -> config[0][page_profil_real_uid]);

				$closedSponsors = $this -> sponsorshipKonfigurationRepository -> getClosedSponsors($this -> uid);
				$this -> view -> assign('closedSponsors', $closedSponsors);
				$this -> view -> assign('closedSponsorsCheck', count($closedSponsors) > 0);

				$closedChildren = $this -> sponsorshipKonfigurationRepository -> getClosedChildren($this -> uid);
				$this -> view -> assign('closedChildren', $closedChildren);
				$this -> view -> assign('closedChildrenCheck', count($closedChildren) > 0);

				$this -> viewNotEmpty = $this -> viewNotEmpty || count($closedSponsors) > 0 || count($closedChildren) > 0;

				// Hinweis zeigen, wenn die Ansicht leer ist
				if (!$this -> viewNotEmpty)
					$this -> view -> assign('ms', Tx_Extbase_Utility_Localization::translate(page_verwaltung_ms_leer, DdSponsorship));

				break;
			default :
				// nicht angemeldet
					$this -> view -> assign('ms', Tx_Extbase_Utility_Localization::translate(page_verwaltung_ms_abgemeldet, DdSponsorship));
				break;
		}

	}

	private function sendEmail($subject, $template) {

		$renderer = $this -> stuffController -> getPlainTextEmailRenderer($template, null);
		$an = $this -> sponsorshipKonfigurationRepository -> getPatenkindOfConnection($this -> requestId);
		$from = $this -> sponsorshipKonfigurationRepository -> getPateOfConnection($this -> requestId);

		// E-Mail Inhalt generieren.
		$renderer -> assign('vorname_an', $an[0][first_name]);
		$renderer -> assign('pate_vorname', $from[0][first_name]);
		$renderer -> assign('pate_nachname', $from[0][last_name]);
		$renderer -> assign('pate_email', $from[0][email]);
		$renderer -> assign('pate_phone', $from[0][telephone]);
		$message = $renderer -> render();

		// E-Mail senden
		$this -> stuffController -> sendMail($an[0][email], $subject, $message);
	}

}
?>
