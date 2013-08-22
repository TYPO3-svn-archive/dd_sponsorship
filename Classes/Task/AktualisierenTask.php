<?php
/**
 * Check and change stats
 *
 * @author duda|design GbR
 * @version 1.0
 *
 */
class Tx_DdSponsorship_Scheduler_Aktualisieren_AktualisierenTask extends tx_scheduler_Task {

	/**
	 * sponsorshipKonfigurationRepository
	 *
	 * @var Tx_DdSponsorship_Domain_Repository_SponsorshipLinkRepository
	 */
	protected $sponsorshipLinkRepository;

	/**
	 * @return boolean Returns TRUE on successful execution, FALSE on error
	 */
	public function execute() {

		$this -> sponsorshipKonfigurationRepository = t3lib_div::makeInstance('Tx_DdSponsorship_Domain_Repository_SponsorshipKonfigurationRepository');
		$this -> sponsorshipLinkRepository = t3lib_div::makeInstance('Tx_DdSponsorship_Domain_Repository_SponsorshipLinkRepository');
		
		$getAllePatenkinder = $this -> sponsorshipKonfigurationRepository -> getAllePatenkinder(null);
		$getConfig = $this -> sponsorshipKonfigurationRepository -> getConfig();

		foreach ($getAllePatenkinder as $key) {

			$this -> sponsorshipKonfigurationRepository -> DeleteUser($key[fuid]);
			$add = $this -> sponsorshipKonfigurationRepository -> AddUser($key[fuid]);
			if ($add == "Pate") {
	
				$this -> StuffController = t3lib_div::makeInstance('Tx_DdSponsorship_Controller_StuffController');
				
				$pate = $this -> sponsorshipKonfigurationRepository -> getPateFromKind(null, $key[fuid], null);
				$paten_kind = $this -> sponsorshipKonfigurationRepository -> getUserInfo($key[fuid]);

				$pate_first = $pate[0][username];
				$pate_email = $pate[0][email];
				$paten_kind_first = $paten_kind[0][username];
				$paten_kind_email = $paten_kind[0][email];

				//E-Mail an User selbst
				$renderer = $this -> StuffController -> getPlainTextEmailRenderer('status', true);
				//E-Mail Inhalt generieren.
				$renderer -> assign('vorname_an', $paten_kind_first);
				$message = $renderer -> render();
				$betreff = Tx_Extbase_Utility_Localization::translate(email_change_patenkind, DdSponsorship);
				
				$this -> StuffController -> sendMail($paten_kind_email, $betreff, $message);

				if ($pate[0][uid]) {
					
					//E-Mail an Pate falls vorhanden
					$renderer = $this -> StuffController -> getPlainTextEmailRenderer('status_pate', true);

					//E-Mail Inhalt generieren.
					$renderer -> assign('vorname_an', $pate_first);
					$renderer -> assign('patenKind_vorname', $paten_kind_first);
					$message = $renderer -> render();
					$betreff = Tx_Extbase_Utility_Localization::translate(email_change_pate, DdSponsorship);

					$this -> StuffController -> sendMail($pate_email, $betreff, $message);
				}
			}
		}
		return true;
	}
}
?>