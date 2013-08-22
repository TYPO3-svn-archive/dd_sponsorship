<?php
/**
 * Database configurations for tx_ddsponsorship_domain_model_sponsorshiplink
 *
 * @author duda|design GbR
 * @version 1.0
 *
 */
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_ddsponsorship_domain_model_user'] = array(
	'ctrl' => $TCA['tx_ddsponsorship_domain_model_user']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sponsorship_expectations_kind, sponsorship_expectations_pate, sponsorship_anzahl_paten',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, sponsorship_expectations_kind, sponsorship_expectations_pate, sponsorship_anzahl_paten,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(

	    'sponsorship_expectations_kind' => array(
	        'exclude' => 0,
	        'label'   => 'Erwartungen Patenkind',
	        'config' => array(
	          'type' => 'textarea',
	          'size' => 20,
	          'eval' => 'trim',
            )
        ),
	
	    'sponsorship_expectations_pate' => array(
    	    'exclude' => 0,
	        'label'   => 'Erwartungen Pate',
	        'config' => array(
	          'type' => 'textarea',
	          'size' => 20,
	          'eval' => 'trim',
			)
        ),
        
	    'sponsorship_anzahl_paten' => array(
        'exclude' => 0,
        'label'   => 'Anzahl Patenkinder',
        'config' => array(
          'type' => 'select',
          'items' => array('0','1','2','3'),
          'default' => '0',
          'size' => 1,
          'maxitems' => '1',
            )
        ),

    'sponsorship_anon' => array(
        'exclude' => 0,
        'label'   => 'anon?',
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
	),
);

?>