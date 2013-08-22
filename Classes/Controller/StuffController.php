<?php
/**
 * Stuff class
 *
 * @author duda|design GbR
 * @version 1.0
 * 
 */
class Tx_DdSponsorship_Controller_StuffController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * Returns an email renderer
	 *
	 * @param string $url
	 * @param string $templateName
	 * @param boolean $task
	 * @return Tx_Fluid_View_StandaloneView
	 * 
	 */
	public function getPlainTextEmailRenderer($templateName, $task) {

		$this -> sponsorshipKonfigurationRepository = t3lib_div::makeInstance('Tx_DdSponsorship_Domain_Repository_SponsorshipKonfigurationRepository');
		$getConfig = $this -> sponsorshipKonfigurationRepository -> getConfig();
		$url = $getConfig[0][mail_url];
		
		$emailView = t3lib_div::makeInstance('Tx_Fluid_View_StandaloneView', $this -> cObj);
		$emailView -> getRequest() -> setControllerExtensionName($this -> extKey);
		$emailView -> setFormat('html');
		
		if($task == true){
			$task = "../";
		}
		$templatePathAndFilename = $task.$url.$templateName . '.html';

		$emailView -> setTemplatePathAndFilename($templatePathAndFilename);
		$emailView -> assign('settings', $this -> settings);

		return $emailView;
	}
	
	/**
	 * Sends emails
	 *
	 * @param string $an
	 * @param string $betreff
	 * @param string $message
	 * @return void
	 * 
	 */
	public function sendMail($an, $betreff, $message, $replyto = null){

		$this -> sponsorshipKonfigurationRepository = t3lib_div::makeInstance('Tx_DdSponsorship_Domain_Repository_SponsorshipKonfigurationRepository');
		$getConfig = $this -> sponsorshipKonfigurationRepository -> getConfig();
		$von = $getConfig[0][email];
		
		$mail = t3lib_div::makeInstance('t3lib_mail_Message');
		$mail -> setTo($an);
		if (!is_null(replyto)) { $mail -> setReplyTo($replyto); }
		$mail -> setFrom($von);
		$mail -> setBcc($von);
		
		$mail -> setSubject($betreff);
		$mail -> setBody($message, 'text/html');
		$mail -> send();		
	}
}
?>
