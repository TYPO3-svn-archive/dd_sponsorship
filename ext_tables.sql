#
# Table structure for table 'tx_ddsponsorship_domain_model_sponsorshipkonfiguration'
#
CREATE TABLE tx_ddsponsorship_domain_model_sponsorshipkonfiguration (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	pate_id int(11) DEFAULT '0' NOT NULL,
	paten_kind_id int(11) DEFAULT '0' NOT NULL,
	email varchar(255) DEFAULT '' NOT NULL,
	mail_url varchar(255) DEFAULT '' NOT NULL,
	page_details_uid int(11) DEFAULT '0' NOT NULL,
	page_profil_uid int(11) DEFAULT '0' NOT NULL,
	page_profil_real_uid int(11) DEFAULT '0' NOT NULL,
	page_verwaltung_uid int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);
#
# Table structure for table 'tx_ddsponsorship_domain_model_sponsorshiplink'
#
CREATE TABLE tx_ddsponsorship_domain_model_sponsorshiplink (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	pate int(11) DEFAULT '0' NOT NULL,
	paten_kind int(11) DEFAULT '0' NOT NULL,
	status int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (

	sponsorship_expectations_kind text NOT NULL,
	sponsorship_expectations_pate text NOT NULL,
	sponsorship_expected_time text NOT NULL,
	sponsorship_anzahl_paten int(11) DEFAULT '0' NOT NULL,
	sponsorship_anon tinyint(1) unsigned DEFAULT '0' NOT NULL,
	sponsorship_area_job tinyint(1) unsigned DEFAULT '0' NOT NULL,
	sponsorship_area_study tinyint(1) unsigned DEFAULT '0' NOT NULL,
	sponsorship_area_inernship tinyint(1) unsigned DEFAULT '0' NOT NULL,
	sponsorship_area_network tinyint(1) unsigned DEFAULT '0' NOT NULL,
	sponsorship_area_general tinyint(1) unsigned DEFAULT '0' NOT NULL,
	sponsorship_area_personal tinyint(1) unsigned DEFAULT '0' NOT NULL,
	sponsorship_area_feedback tinyint(1) unsigned DEFAULT '0' NOT NULL,
	sponsorship_area_companies tinyint(1) unsigned DEFAULT '0' NOT NULL,

);


