<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
//pluginssss
Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Ssverwaltung',
	'Patenschaften: Verwaltung'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Ssallepaten',
	'Patenschaften: Alle Paten im Überblick'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Sseintreten',
	'Patenschaften: Patenprogramm betreten '
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Ssdetails',
	'Patenschaften: Details'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Ssprofil',
	'Patenschaften: Mein Profil bearbeiten'
);

if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY,
		'tools',			// Make module a submodule of 'tools'
		'sskonfiguration',	// Submodule key
		'',					// Position
		array(
			'SponsorshipKonfiguration' => 'index, submit',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_sskonfiguration.xml',
		)
	);

	/**
	 * Registers a Backend Module
	 */
	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY,
		'web',				// Make module a submodule of 'web'
		'ssverwalten',		// Submodule key
		'',					// Position
		array(
			'ssVerwalten' => 'index, status',
			
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_ssverwalten.xml',
		)
	);

}

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Patenschaften');
t3lib_extMgm::addLLrefForTCAdescr('tx_ddsponsorship_domain_model_sponsorshipkonfiguration', 'EXT:dd_sponsorship/Resources/Private/Language/locallang_csh_tx_ddsponsorship_domain_model_sponsorshipkonfiguration.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_ddsponsorship_domain_model_sponsorshipkonfiguration');
$TCA['tx_ddsponsorship_domain_model_sponsorshipkonfiguration'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:dd_sponsorship/Resources/Private/Language/locallang_db.xml:tx_ddsponsorship_domain_model_sponsorshipkonfiguration',
		'label' => 'pate_id',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'pate_id,paten_kind_id,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/SponsorshipKonfiguration.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_ddsponsorship_domain_model_sponsorshipkonfiguration.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_ddsponsorship_domain_model_sponsorshiplink', 'EXT:dd_sponsorship/Resources/Private/Language/locallang_csh_tx_ddsponsorship_domain_model_sponsorshiplink.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_ddsponsorship_domain_model_sponsorshiplink');
$TCA['tx_ddsponsorship_domain_model_sponsorshiplink'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:dd_sponsorship/Resources/Private/Language/locallang_db.xml:tx_ddsponsorship_domain_model_sponsorshiplink',
		'label' => 'pate',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'pate,paten_kind,status,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/SponsorshipLink.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_ddsponsorship_domain_model_sponsorshiplink.gif'
	),
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Setup');

//**************************************************//
// USER | Erweiterung fe_users um Felder Patenprogramm
//**************************************************//
 
$tempCols = array(
	'sponsorship_expectations_kind' => array(
        'exclude' => 1,
        'label'   => 'Erwartungen Patenkind',
        'config' => array(
          'type' => 'text',
          'size' => 20,
          'eval' => 'trim',
            )
        ),


	'sponsorship_expected_time' => array(
			'exclude' => 1,
			'label'   => 'Geplanter Zeitaufwand',
			'config' => array(
			  'type' => 'text',
			  'size' => 20,
			  'eval' => 'trim',
				)
			),
			
	'sponsorship_expectations_pate' => array(
        'exclude' => 1,
        'label'   => 'Erwartungen Pate',
        'config' => array(
          'type' => 'text',
          'size' => 20,
          'eval' => 'trim',
            )
        ),
        
    'sponsorship_anzahl_paten' => array(
        'exclude' => 0,
        'label'   => 'Anzahl Patenkinder',
        'config' => array(
          'type' => 'radio',
          'items' => array(array('1','1'),array('2','2'),array('3','3')),
            )
        ),

    'sponsorship_anon' => array(
        'exclude' => 0,
        'label'   => 'Anonym',
        'config' => array(
          'type' => 'check',
          'default' => '0',
            )
        ),

    'sponsorship_area_job' => array(
        'exclude' => 0,
        'label'   => 'Berufseinstieg',
        'config' => array(
          'type' => 'check',
          'default' => '0',
            )
        ),

    'sponsorship_area_study' => array(
        'exclude' => 0,
        'label'   => 'Berufsbezogene Studiengestaltung',
        'config' => array(
          'type' => 'check',
          'default' => '0',
            )
        ),

    'sponsorship_area_inernship' => array(
        'exclude' => 0,
        'label'   => 'Suche nach Praktika',
        'config' => array(
          'type' => 'check',
          'default' => '0',
            )
        ),

    'sponsorship_area_network' => array(
        'exclude' => 0,
        'label'   => 'Kontakte & Beziehungen',
        'config' => array(
          'type' => 'check',
          'default' => '0',
            )
        ),

    'sponsorship_area_general' => array(
        'exclude' => 0,
        'label'   => 'allgemeine Themen',
        'config' => array(
          'type' => 'check',
          'default' => '0',
            )
        ),

    'sponsorship_area_personal' => array(
        'exclude' => 0,
        'label'   => 'persönliche Dinge',
        'config' => array(
          'type' => 'check',
          'default' => '0',
            )
        ),

    'sponsorship_area_feedback' => array(
        'exclude' => 0,
        'label'   => 'Feedback',
        'config' => array(
          'type' => 'check',
          'default' => '0',
            )
        ),

    'sponsorship_area_companies' => array(
        'exclude' => 0,
        'label'   => 'Hintergrundinfos',
        'config' => array(
          'type' => 'check',
          'default' => '0',
            )
        ),	
);

t3lib_div::loadTCA('fe_users');
t3lib_extMgm::addTCAcolumns('fe_users',$tempCols,1);
t3lib_extMgm::addToAllTCATypes('fe_users','--div--;Patenprogramm,sponsorship_expectations_kind;;;;1-1-1,sponsorship_expectations_pate,sponsorship_expected_time,sponsorship_anzahl_paten,sponsorship_anon,sponsorship_area_job,sponsorship_area_study,sponsorship_area_inernship,sponsorship_area_network,sponsorship_area_general,sponsorship_area_personal,sponsorship_area_feedback,sponsorship_area_companies');

?>
