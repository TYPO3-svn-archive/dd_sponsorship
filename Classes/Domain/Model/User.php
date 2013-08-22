<?php

/**
 *
 */
class Tx_DdSponsorship_Domain_Model_User extends Tx_Extbase_Domain_Model_FrontendUser {

	protected $sponsorship_expectations_kind;
	protected $sponsorship_expectations_pate;
	protected $sponsorship_anzahl_paten;
	protected $sponsorship_anon;
	protected $sponsorship_area_job;
	protected $sponsorship_area_study;
	protected $sponsorship_area_inernship;
	protected $sponsorship_area_network;
	protected $sponsorship_area_general;
	protected $sponsorship_area_personal;
	protected $sponsorship_area_feedback;
	protected $sponsorship_area_companies;

	public function getSponsorship_expectations_kind() {
		return $this -> sponsorship_expectations_kind;
	}

	public function getSponsorship_expectations_pate() {
		return $this -> sponsorship_expectations_pate;
	}

	public function getSponsorship_anzahl_paten() {
		return $this -> sponsorship_anzahl_paten;
	}

	public function getSponsorship_anon() {
		return $this -> sponsorship_anon;
	}

	public function getSponsorship_area_job() {
		return $this -> sponsorship_area_job;
	}

	public function getSponsorship_area_study() {
		return $this -> sponsorship_area_study;
	}

	public function getSponsorship_area_inernship() {
		return $this -> sponsorship_area_inernship;
	}

	public function getSponsorship_area_network() {
		return $this -> sponsorship_area_network;
	}

	public function getSponsorship_area_general() {
		return $this -> sponsorship_area_general;
	}

	public function getSponsorship_area_personal() {
		return $this -> sponsorship_area_personal;
	}

	public function getSponsorship_area_feedback() {
		return $this -> sponsorship_area_feedback;
	}
	
	public function getSponsorship_area_companies() {
		return $this -> sponsorship_area_companies;
	}

	public function setSponsorship_expectations_kind($x) {
		$this -> sponsorship_expectations_kind = $x;
	}

	public function setSponsorship_expectations_pate($x) {
		$this -> sponsorship_expectations_pate = $x;
	}

	public function setSponsorship_anzahl_paten($x) {
		$this -> sponsorship_anzahl_paten = $x;
	}

	public function setSponsorship_anon($x) {
		$this -> sponsorship_anon = $x;
	}

	public function setSponsorship_area_job($x) {
		$this -> sponsorship_area_job = $x;
	}

	public function setSponsorship_area_study($x) {
		$this -> sponsorship_area_study = $x;
	}

	public function setSponsorship_area_inernship($x) {
		$this -> sponsorship_area_inernship = $x;
	}

	public function setSponsorship_area_network($x) {
		$this -> sponsorship_area_network = $x;
	}

	public function setSponsorship_area_general($x) {
		$this -> sponsorship_area_general = $x;
	}

	public function setSponsorship_area_personal($x) {
		$this -> sponsorship_area_personal = $x;
	}

	public function setSponsorship_area_feedback($x) {
		$this -> sponsorship_area_feedback = $x;
	}

	public function setSponsorship_area_companies($x) {
		$this -> sponsorship_area_companies = $x;
	}
}
?>