<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Ssverwaltung',
	array(
		'ssVerwaltung' => 'index',
	),
	// non-cacheable actions
	array(
		'SponsorshipKonfiguration' => '',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Ssallepaten',
	array(
		'ssAllePaten' => 'index',
	),
	// non-cacheable actions
	array(
		'SponsorshipKonfiguration' => '',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Sseintreten',
	array(
		'ssEintreten' => 'index, submit',
	),
	// non-cacheable actions
	array(
		'SponsorshipKonfiguration' => '',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Ssdetails',
	array(
		'ssDetails' => 'index, submit',
	),
	// non-cacheable actions
	array(
		'SponsorshipKonfiguration' => '',
	)
); 

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Ssprofil',
	array(
		'ssProfil' => 'index, submit',
	),
	// non-cacheable actions
	array(
		'SponsorshipKonfiguration' => '',
	)
);
Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'User',
	array(
		'User' => 'list',
	),
	// non-cacheable actions
	array(
		'User' => 'list',
	)
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Tx_DdSponsorship_Scheduler_Aktualisieren_AktualisierenTask'] = array(
	'extension'        => $_EXTKEY,
	'title'            => 'Aktualisiert die Patenschaft Beziehungen',
	'description'      => 'Sucht und aktualisiert alle Patenkinder, die ihren Abschluss bereits abgeschlossen haben.'
);

?>