<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "dd_sponsorship".
 *
 * Auto generated 20-08-2013 16:39
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Patenschaften',
	'description' => '',
	'category' => 'plugin',
	'author' => 'duda|design',
	'author_email' => 'support@dudadesign.de',
	'author_company' => 'duda|design GbR',
	'shy' => 'Patenschaftprogramm für TYPO3',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '3.1.1',
	'constraints' => array(
		'depends' => array(
			'extbase' => '1.3',
			'fluid' => '1.3',
			'typo3' => '4.5-6.1.99',
			'user_system' => '0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:63:{s:16:"ext_autoload.php";s:4:"d86f";s:21:"ext_conf_template.txt";s:4:"d41d";s:12:"ext_icon.gif";s:4:"e922";s:17:"ext_localconf.php";s:4:"1ef4";s:14:"ext_tables.php";s:4:"afbb";s:14:"ext_tables.sql";s:4:"a652";s:21:"ExtensionBuilder.json";s:4:"5bb8";s:57:"Classes/Controller/SponsorshipKonfigurationController.php";s:4:"2be1";s:44:"Classes/Controller/ssAllePatenController.php";s:4:"7250";s:42:"Classes/Controller/ssDetailsController.php";s:4:"4a83";s:44:"Classes/Controller/ssEintretenController.php";s:4:"ef8f";s:41:"Classes/Controller/ssProfilController.php";s:4:"9eb9";s:44:"Classes/Controller/ssVerwaltenController.php";s:4:"bc94";s:45:"Classes/Controller/ssVerwaltungController.php";s:4:"ca94";s:38:"Classes/Controller/StuffController.php";s:4:"be86";s:37:"Classes/Controller/UserController.php";s:4:"39c1";s:49:"Classes/Domain/Model/SponsorshipKonfiguration.php";s:4:"fb3b";s:40:"Classes/Domain/Model/SponsorshipLink.php";s:4:"b509";s:29:"Classes/Domain/Model/User.php";s:4:"621c";s:64:"Classes/Domain/Repository/SponsorshipKonfigurationRepository.php";s:4:"0321";s:55:"Classes/Domain/Repository/SponsorshipLinkRepository.php";s:4:"471a";s:44:"Classes/Domain/Repository/UserRepository.php";s:4:"2a51";s:34:"Classes/Task/AktualisierenTask.php";s:4:"fbed";s:44:"Configuration/ExtensionBuilder/settings.yaml";s:4:"068a";s:46:"Configuration/TCA/SponsorshipKonfiguration.php";s:4:"f17c";s:37:"Configuration/TCA/SponsorshipLink.php";s:4:"2415";s:26:"Configuration/TCA/User.php";s:4:"01d0";s:38:"Configuration/TypoScript/constants.txt";s:4:"052c";s:34:"Configuration/TypoScript/setup.txt";s:4:"a019";s:30:"Resources/Mails/abgelehnt.html";s:4:"2f92";s:28:"Resources/Mails/anfrage.html";s:4:"ba3c";s:31:"Resources/Mails/angenommen.html";s:4:"b0b1";s:27:"Resources/Mails/status.html";s:4:"3367";s:32:"Resources/Mails/status_pate.html";s:4:"d9cc";s:40:"Resources/Private/Language/locallang.xml";s:4:"da9a";s:99:"Resources/Private/Language/locallang_csh_tx_ddsponsorship_domain_model_sponsorshipkonfiguration.xml";s:4:"72ca";s:90:"Resources/Private/Language/locallang_csh_tx_ddsponsorship_domain_model_sponsorshiplink.xml";s:4:"4f3a";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"904b";s:56:"Resources/Private/Language/locallang_sskonfiguration.xml";s:4:"4c94";s:52:"Resources/Private/Language/locallang_ssverwalten.xml";s:4:"407c";s:63:"Resources/Private/Templates/SponsorshipKonfiguration/Index.html";s:4:"f0d1";s:42:"Resources/Private/Templates/User/List.html";s:4:"9225";s:50:"Resources/Private/Templates/ssAllePaten/Index.html";s:4:"3010";s:48:"Resources/Private/Templates/ssDetails/Index.html";s:4:"d9a5";s:50:"Resources/Private/Templates/ssEintreten/Index.html";s:4:"c4fe";s:47:"Resources/Private/Templates/ssProfil/Index.html";s:4:"92e6";s:50:"Resources/Private/Templates/ssVerwalten/Index.html";s:4:"0aaa";s:51:"Resources/Private/Templates/ssVerwaltung/Index.html";s:4:"2863";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:81:"Resources/Public/Icons/tx_ddsponsorship_domain_model_sponsorshipkonfiguration.gif";s:4:"4e5b";s:72:"Resources/Public/Icons/tx_ddsponsorship_domain_model_sponsorshiplink.gif";s:4:"4e5b";s:32:"Resources/Public/css/backend.css";s:4:"a0ae";s:30:"Resources/Public/css/style.css";s:4:"423a";s:43:"Resources/Public/js/jquery-migrate-1.0.0.js";s:4:"427a";s:45:"Resources/Public/js/jquery.tablesorter.min.js";s:4:"9f8e";s:47:"Resources/Public/js/jquery.tablesorter.pager.js";s:4:"bcdf";s:40:"Resources/Public/js/tx_dd_sponsorship.js";s:4:"0adb";s:64:"Tests/Unit/Controller/SponsorshipKonfigurationControllerTest.php";s:4:"2b7b";s:56:"Tests/Unit/Domain/Model/SponsorshipKonfigurationTest.php";s:4:"fff1";s:47:"Tests/Unit/Domain/Model/SponsorshipLinkTest.php";s:4:"9fed";s:14:"doc/manual.odt";s:4:"7c56";s:14:"doc/manual.pdf";s:4:"2302";s:14:"doc/manual.sxw";s:4:"e3a9";}',
);

?>