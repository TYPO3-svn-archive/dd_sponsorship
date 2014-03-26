<?php
/**
 * Processing of database query
 *
 * @author duda|design GbR
 * @version 1.0
 *
 */
class Tx_DdSponsorship_Domain_Repository_SponsorshipKonfigurationRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * Save the configuration
	 *
	 * @param array $data  Form datas
	 * @return void
	 */
	public function setConfig($data) {

		$pate = $this -> niceString($data[pateId]);
		$patenkind = $this -> niceString($data[patenKindId]);
		$email = $this -> niceString($data[email]);
		$page_details_uid = $this -> niceString($data[page_details_uid]);
		$page_profil_uid = $this -> niceString($data[page_profil_uid]);
		$page_profil_real_uid = $this -> niceString($data[page_profil_real_uid]);
		$mail_url = $this -> niceString($data[mail_url]);
		$page_verwaltung_uid = $this -> niceString($data[page_verwaltung_uid]);
		$pagination = $this -> niceString($data[pagination]);

		$query = $this -> createQuery();
		$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
		$query -> statement("INSERT INTO tx_ddsponsorship_domain_model_sponsorshipkonfiguration 
								(uid, pate_id, paten_kind_id, email, mail_url, page_details_uid, page_profil_uid, page_profil_real_uid, page_verwaltung_uid) 
							VALUES 
								('1', '$pate', '$patenkind', '$email', '$mail_url', '$page_details_uid', '$page_profil_uid', '$page_profil_real_uid', '$page_verwaltung_uid') 
							ON DUPLICATE KEY 
							UPDATE 
								pate_id = '$pate', 
								paten_kind_id = '$patenkind', 
								email = '$email', 
								mail_url = '$mail_url', 
								page_details_uid = '$page_details_uid', 
								page_profil_uid = '$page_profil_uid',
								page_profil_real_uid = '$page_profil_real_uid',
								page_verwaltung_uid = '$page_verwaltung_uid'
								;");
		return $query -> execute();
	}

	/**
	 * Get the configuration informations
	 *
	 * @return array
	 */
	public function getConfig() {

		$query = $this -> createQuery();
		$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
		$query -> statement("SELECT *
							FROM tx_ddsponsorship_domain_model_sponsorshipkonfiguration
							WHERE uid = '1'
							LIMIT 1");
		return $query -> execute();
	}

	/**
	 * Get user informations by ID
	 *
	 * @param integer $id
	 * @return array
	 */
	public function getUserInfo($id) {

		$id = $this -> niceString($id);

		$query = $this -> createQuery();
		$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
		$query -> statement("SELECT *, 
								s1.uid as fuid,
								u1.end_date as end1,
								u2.end_date as end2,
								u3.end_date as end3, 
								u4.study_course as course1,
								u5.study_course as course2,
								u6.study_course as course3, 
								u1.semester as semester1,
								u2.semester as semester2,
								u3.semester as semester3
							FROM fe_users  s1
							LEFT JOIN user_system_university_finished u1 ON s1.user_system_university_finished = u1.uid
							LEFT JOIN user_system_university_finished u2 ON s1.user_system_university_finished2 = u2.uid
							LEFT JOIN user_system_university_finished u3 ON s1.user_system_university_finished3 = u3.uid
							LEFT JOIN user_system_university_study_course u4 ON s1.user_system_university_study_course= u4.uid
							LEFT JOIN user_system_university_study_course u5 ON s1.user_system_university_study_course2= u5.uid
							LEFT JOIN user_system_university_study_course u6 ON s1.user_system_university_study_course3= u6.uid
							WHERE s1.uid = '$id' LIMIT 1");
		return $query -> execute();
	}
	
	public function getNextSponsor($sponsorId, $userId) {
		return $this -> getNextAndPrev("<", $sponsorId, $userId);
	}
	
	public function getPrevSponsor($sponsorId, $userId) {
		return $this -> getNextAndPrev(">", $sponsorId, $userId);
	}

	/**
	 * Get next User
	 *
	 * @param string $way
	 * @param integer $id user ID
	 * @return array
	 */
	public function getNextAndPrev($way, $sponsorId, $userId) {

		$getConfig = $this -> getConfig();
		$pate_id = $getConfig[0][pate_id];

		if ($way == "<") {
			$order = "DESC";
		} else {
			$order = "ASC";
		}

		return $this -> getVerfuegbarePaten($userId, "AND subq.uid " . $way . " $sponsorId ORDER BY subq.uid " . $order . " limit 0,1");
	}

	/**
	 * Update user informations by ID
	 *
	 * @param integer $uid userId
	 * @param array $data Form informations
	 * @return void
	 */
	public function UpdateUser($uid, $data) {

		$sponsorship_expectations_kind = $this -> niceString($data[sponsorship_expectations_kind]);
		$sponsorship_expectations_pate = $this -> niceString($data[sponsorship_expectations_pate]);
		$sponsorship_expected_time = $this -> niceString($data[sponsorship_expected_time]);
		$sponsorship_anzahl_paten = $this -> niceString($data[sponsorship_anzahl_paten]);
		$sponsorship_anon = $this -> niceString($data[sponsorship_anon]);
		$sponsorship_area_job = $this -> niceString($data[sponsorship_area_job]);
		$sponsorship_area_study = $this -> niceString($data[sponsorship_area_study]);
		$sponsorship_area_inernship = $this -> niceString($data[sponsorship_area_inernship]);
		$sponsorship_area_network = $this -> niceString($data[sponsorship_area_network]);
		$sponsorship_area_general = $this -> niceString($data[sponsorship_area_general]);
		$sponsorship_area_personal = $this -> niceString($data[sponsorship_area_personal]);
		$sponsorship_area_feedback = $this -> niceString($data[sponsorship_area_feedback]);
		$sponsorship_area_companies = $this -> niceString($data[sponsorship_area_companies]);
		$uid = $this -> niceString($uid);

		$query = $this -> createQuery();
		$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
		$query -> statement("UPDATE fe_users SET 
								 sponsorship_expectations_kind = '$sponsorship_expectations_kind',
								 sponsorship_expectations_pate = '$sponsorship_expectations_pate',
								 sponsorship_expected_time = '$sponsorship_expected_time',
								 sponsorship_anzahl_paten = '$sponsorship_anzahl_paten',
								 sponsorship_anon = '$sponsorship_anon',
								 sponsorship_area_job = '$sponsorship_area_job',
								 sponsorship_area_study = '$sponsorship_area_study',
								 sponsorship_area_inernship = '$sponsorship_area_inernship',
								 sponsorship_area_network = '$sponsorship_area_network',
								 sponsorship_area_general = '$sponsorship_area_general',
								 sponsorship_area_personal = '$sponsorship_area_personal',
								 sponsorship_area_feedback = '$sponsorship_area_feedback',
								 sponsorship_area_companies = '$sponsorship_area_companies'
							 WHERE uid = '$uid' LIMIT 1");
		return $query -> execute();
	}

	/**
	 * Get all sponsored child or one
	 *
	 * @param integer $uid userId
	 * @return array
	 */
	public function getAnzahlPatenkinder($id) {

		$id = $this -> niceString($id);

		$query = $this -> createQuery();
		$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
		$query -> statement("SELECT *
							FROM tx_ddsponsorship_domain_model_sponsorshiplink 
							INNER JOIN fe_users 
							ON fe_users.uid = tx_ddsponsorship_domain_model_sponsorshiplink.pate 
							WHERE tx_ddsponsorship_domain_model_sponsorshiplink.pate = '$id' 
							AND tx_ddsponsorship_domain_model_sponsorshiplink.deleted = 0
							AND (tx_ddsponsorship_domain_model_sponsorshiplink.status = '1' 
							OR tx_ddsponsorship_domain_model_sponsorshiplink.status = '2')");
		return count($query -> execute());

	}

	public function haveConnection($uid, $sponsor = null, $child = null) {
		$array = $this -> getConnection($uid, $sponsor, $child, 0);
		return !is_null($array[0]['uid']);
	}

	public function connectionIsEnded($uid, $sponsor = null, $child = null) {
		$array = $this -> getConnection($uid, $sponsor, $child, 0, 0);
		return !is_null($array[0]['uid']);
	}

	public function connectionIsRefused($uid, $sponsor = null, $child = null) {
		$array = $this -> getConnection($uid, $sponsor, $child, 0, 3);
		return !is_null($array[0]['uid']);
	}

	public function connectionIsActive($uid, $sponsor = null, $child = null) {
		$array = $this -> getConnection($uid, $sponsor, $child, 0, 1);
		return !is_null($array[0]['uid']);
	}

	public function connectionIsPending($uid, $sponsor = null, $child = null) {
		$array = $this -> getConnection($uid, $sponsor, $child, 0, 2);
		return !is_null($array[0]['uid']);
	}

	public function getActiveConnections($userId) {
		$temp = $this -> getConnection(null, $userId, null, 0, 1);
		array_push($temp, $this -> getConnection(null, null, $userId, 0, 1));
		return $temp;
	}

	public function getConnection($uid = null, $sponsor = null, $child = null, $deleted = null, $status = null) {

		$uid = $this -> niceString($uid);
		$sponsor = $this -> niceString($sponsor);
		$child = $this -> niceString($child);
		$deleted = $this -> niceString($deleted);
		$status = $this -> niceString($status);

		$qArray = array();
		!empty($uid) ? array_push($qArray, "uid = '$uid'") : false;
		!empty($sponsor) ? array_push($qArray, "pate = '$sponsor'") : false;
		!empty($child) ? array_push($qArray, "paten_kind = '$child'") : false;
		!empty($deleted) ? array_push($qArray, "deleted = '$deleted'") : false;
		!empty($status) ? array_push($qArray, "status = '$status'") : false;

		$query = $this -> createQuery();
		$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
		$query -> statement("SELECT * 
							FROM tx_ddsponsorship_domain_model_sponsorshiplink  
							WHERE " . implode(" AND ", $qArray));
		return $query -> execute();
	}

	public function getPateOfConnection($id) {
		$connection = $this -> getConnection($id);
		return $this -> getUserInfo($connection[0][pate]);
	}

	public function getPatenkindOfConnection($id) {
		$connection = $this -> getConnection($id);
		return $this -> getUserInfo($connection[0][paten_kind]);
	}

	public function getActiveSponsor($userId) {
		return $this -> getPate($userId, 1);
	}

	public function getPendingSponsor($userId) {
		return $this -> getPate($userId, 2);
	}

	public function getClosedSponsors($userId) {
		return $this -> getPate($userId, 0);
	}

	public function getActiveChildren($userId) {
		return $this -> getPatenkind($userId, 1);
	}

	public function getPendingChildren($userId) {
		return $this -> getPatenkind($userId, 2);
	}

	public function getClosedChildren($userId) {
		return $this -> getPatenkind($userId, 0);
	}

	/**
	 * Get sponsor users for sponsor child
	 *
	 * @param integer uid sponsored child ID
	 * @param integer $status stat of the connection
	 * @return array
	 */
	public function getPate($uid, $status = null) {
		return $this -> getPateFromKind(null, $uid, $status);
	}

	/**
	 * Get sponsor child users for sponsor
	 *
	 * @param integer uid sponsored ID
	 * @param integer $status stat of the connection
	 * @return array
	 */
	public function getPatenkind($uid, $status = null) {
		return $this -> getPateFromKind($uid, null, $status);
	}

	/**
	 * Get connections from sponsor and sponsorship
	 *
	 * @param integer $pate sponsor ID
	 * @param integer $kind sponsored child ID
	 * @param integer $status stat of the connection
	 * @return array
	 */
	public function getPateFromKind($pate, $kind, $status = null) {

		$pate = $this -> niceString($pate);
		$kind = $this -> niceString($kind);
		$status = $this -> niceString($status);
		
		if ($status != "") {
			$and = " AND tx_ddsponsorship_domain_model_sponsorshiplink.status = '$status'";
		}
		if (!empty($pate)) {
			$where = " AND tx_ddsponsorship_domain_model_sponsorshiplink.pate = '$pate'";
			$join = "paten_kind";
		}
		if (!empty($kind)) {
			$where = " AND tx_ddsponsorship_domain_model_sponsorshiplink.paten_kind = '$kind'";
			$join = "pate";
		}
		$query = $this -> createQuery();
		$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
		$query -> statement("SELECT *, 
								tx_ddsponsorship_domain_model_sponsorshiplink.status as p_status,
								tx_ddsponsorship_domain_model_sponsorshiplink.tstamp as p_tstamp,
								tx_ddsponsorship_domain_model_sponsorshiplink.uid as p_uid,  
								fe_users.uid as fe_uid
							FROM tx_ddsponsorship_domain_model_sponsorshiplink  
							INNER JOIN fe_users ON fe_users.uid = tx_ddsponsorship_domain_model_sponsorshiplink." . $join . "
							WHERE tx_ddsponsorship_domain_model_sponsorshiplink.deleted = '0' " . $where . " " . $and);
		return $query -> execute();
	}

	/**
	 * Get all sponsors or one
	 *
	 * @param integer $pate sponsor ID
	 * @return array
	 */
	public function getAllePaten($id) {

		$id = $this -> niceString($id);

		if (!is_null($id)) {
			$and = " AND s1.uid = '$id' LIMIT 1";
		}
		$getConfig = $this -> getConfig();
		$pate_id = $getConfig[0][pate_id];

		$query = $this -> createQuery();
		$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
		$query -> statement("SELECT  *,
								s1.uid as fuid,
								u4.study_course as course1,
								u5.study_course as course2,
								u6.study_course as course3, 
								u1.semester as semester1,
								u2.semester as semester2,
								u3.semester as semester3 
							FROM fe_users s1 
							LEFT JOIN user_system_university_finished u1     ON s1.user_system_university_finished = u1.uid
							LEFT JOIN user_system_university_finished u2     ON s1.user_system_university_finished2 = u2.uid
							LEFT JOIN user_system_university_finished u3     ON s1.user_system_university_finished3 = u3.uid
							LEFT JOIN user_system_university_study_course u4 ON s1.user_system_university_study_course= u4.uid
							LEFT JOIN user_system_university_study_course u5 ON s1.user_system_university_study_course2= u5.uid
							LEFT JOIN user_system_university_study_course u6 ON s1.user_system_university_study_course3= u6.uid
							WHERE FIND_IN_SET ('$pate_id',s1.usergroup) > 0" . $and);
		return $query -> execute();
	}

	/**
	 * Finds out if user id is in paten group
	 *
	 * @param integer $id user ID
	 * @return boolean
	 */
	public function isPate($id) {

		$id = $this -> niceString($id);

		$getConfig = $this -> getConfig();
		$sponsorGroupId = $getConfig[0][pate_id];

		return $this -> isInGroup($id, $sponsorGroupId);
	}

	/**
	 * Finds out if user id is in patenkinder group
	 *
	 * @param integer $id user ID
	 * @return boolean
	 */
	public function isPatenkind($id) {

		$id = $this -> niceString($id);

		$getConfig = $this -> getConfig();
		$childGroupId = $getConfig[0][paten_kind_id];

		return $this -> isInGroup($id, $childGroupId);
	}

	public function isInGroup($userId, $groupId) {
		$query = $this -> createQuery();
		$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
		$query -> statement("SELECT uid
							FROM fe_users 
							WHERE FIND_IN_SET ('$groupId',usergroup) > 0
							AND uid = '$userId'
							LIMIT 1");
		$array = $query -> execute();

		return !is_null($array[0][uid]);
	}

	/**
	 * Get all available sponsors
	 *
	 * @param integer $pate sponsor ID
	 * @return array
	 */
	public function getVerfuegbarePaten($user_id, $extend = null) {

		$id = $this -> niceString($user_id);

		$getConfig = $this -> getConfig();
		$pate_id = $getConfig[0][pate_id];

		$querystring = "SELECT
								subq.uid as fuid,
								subq.date_of_birth,
								subq.gender,
								subq.city,
								u4.study_course as course1,
								u5.study_course as course2,
								u6.study_course as course3, 
								u1.semester as semester1,
								u2.semester as semester2,
								u3.semester as semester3
							FROM (
								SELECT
									u.uid,
									u.date_of_birth,
									u.sponsorship_anzahl_paten,
									u.gender,
									u.city,
									u.user_system_university_finished,
									u.user_system_university_finished2,
									u.user_system_university_finished3,
									u.user_system_university_study_course,
									u.user_system_university_study_course2,
									u.user_system_university_study_course3,
									u.username,
									IFNULL(z.anzahl, 0) as anzahl
								FROM fe_users as u
								LEFT JOIN (
									SELECT
										f.uid,
										count(*) as anzahl
									FROM fe_users as f
									INNER JOIN tx_ddsponsorship_domain_model_sponsorshiplink as j ON j.pate = f.uid
									WHERE FIND_IN_SET ('$pate_id',usergroup) > 0
									AND j.deleted = 0
									AND j.status > 0
									GROUP BY f.uid
								) AS z ON (z.uid = u.uid)
								WHERE NOT EXISTS (
									SELECT 1
									FROM tx_ddsponsorship_domain_model_sponsorshiplink as k
									WHERE k.pate = u.uid
									AND k.paten_kind = '$id'
									AND k.deleted = 0
								)
								AND FIND_IN_SET ('$pate_id',usergroup) > 0
							) AS subq
							LEFT JOIN user_system_university_finished u1     ON subq.user_system_university_finished = u1.uid
							LEFT JOIN user_system_university_finished u2     ON subq.user_system_university_finished2 = u2.uid
							LEFT JOIN user_system_university_finished u3     ON subq.user_system_university_finished3 = u3.uid
							LEFT JOIN user_system_university_study_course u4 ON subq.user_system_university_study_course= u4.uid
							LEFT JOIN user_system_university_study_course u5 ON subq.user_system_university_study_course2= u5.uid
							LEFT JOIN user_system_university_study_course u6 ON subq.user_system_university_study_course3= u6.uid
							WHERE subq.anzahl < subq.sponsorship_anzahl_paten";

		if (!is_null($extend)) {
			$querystring .= " " . $extend;
		}

		$query = $this -> createQuery();
		$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
		$query -> statement($querystring);
		return $query -> execute();
	}

	/**
	 * Get all sponsor childs or one
	 *
	 * @param integer $id sponsor child ID
	 * @return array
	 */
	public function getAllePatenkinder($id) {

		$id = $this -> niceString($id);

		if (!empty($id)) {
			$and = " AND s1.uid = '$id' LIMIT 1";
		}
		$getConfig = $this -> getConfig();
		$patekind = $getConfig[0][paten_kind_id];

		$query = $this -> createQuery();
		$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
		$query -> statement("SELECT *,
								s1.uid as fuid,
								u4.study_course as course1,
								u5.study_course as course2,
								u6.study_course as course3, 
								u1.semester as semester1,
								u2.semester as semester2,
								u3.semester as semester3 
							FROM fe_users s1 
							LEFT JOIN user_system_university_finished u1 ON s1.user_system_university_finished = u1.uid
							LEFT JOIN user_system_university_finished u2 ON s1.user_system_university_finished2 = u2.uid
							LEFT JOIN user_system_university_finished u3 ON s1.user_system_university_finished3 = u3.uid
							LEFT JOIN user_system_university_study_course u4 ON s1.user_system_university_study_course= u4.uid
							LEFT JOIN user_system_university_study_course u5 ON s1.user_system_university_study_course2= u5.uid
							LEFT JOIN user_system_university_study_course u6 ON s1.user_system_university_study_course3= u6.uid
							WHERE FIND_IN_SET('$patekind',s1.usergroup) > 0 and s1.deleted=0" . $and);
		return $query -> execute();
	}

	/**
	 * Get group of an user
	 *
	 * @param integer $id user ID
	 * @return array
	 */
	public function getGroup($id) {

		$id = $this -> niceString($id);

		$query = $this -> createQuery();
		$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
		$query -> statement("SELECT usergroup
							FROM fe_users
							WHERE uid = '$id'
							LIMIT 1");
		return $query -> execute();
	}

	/**
	 * Get typ of an user
	 *
	 * @param integer $id user ID
	 * @return array
	 */
	public function getPatenTyp($id) {

		$id = $this -> niceString($id);

		$query = $this -> createQuery();
		$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
		$query -> statement("SELECT
								u1.end_date as end1,
								u2.end_date as end2,
								u3.end_date as end3
							FROM fe_users s1
							LEFT JOIN user_system_university_finished u1 ON s1.user_system_university_finished = u1.uid
							LEFT JOIN user_system_university_finished u2 ON s1.user_system_university_finished2 = u2.uid
							LEFT JOIN user_system_university_finished u3 ON s1.user_system_university_finished3 = u3.uid
							WHERE s1.uid = '$id'
							LIMIT 1");
		return $query -> execute();
	}

	/**
	 * Get some information about sponsor and sponsored child
	 *
	 * @param integer $pate sponsor ID
	 * @param integer $pate sponsored child ID
	 * @return array
	 */
	public function getInfoByPateAndPatenKind($pate, $patenkind) {

		$pate = $this -> niceString($pate);
		$patenkind = $this -> niceString($patenkind);

		$uid = empty($pate) ? $patenkind : $pate;

		$query = $this -> createQuery();
		$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
		$query -> statement("SELECT *
							FROM fe_users
							INNER JOIN tx_ddsponsorship_domain_model_sponsorshiplink ON fe_users.uid = tx_ddsponsorship_domain_model_sponsorshiplink.pate WHERE tx_ddsponsorship_domain_model_sponsorshiplink.uid = '$uid' and tx_ddsponsorship_domain_model_sponsorshiplink.deleted=0 LIMIT 1");
		return $query -> execute();
	}

	/**
	 * Verifies the presence of a user in the sponsorship program
	 *
	 * @param array $data group information of a given user
	 * @return boolean
	 */
	public function isInProgramm($data) {
		$isInProgramm = false;
		$data = $data[0][usergroup];

		$getConfig = $this -> getConfig();
		$pate_id = $getConfig[0][pate_id];
		$paten_kind_id = $getConfig[0][paten_kind_id];
		
		$data = explode(",", $data);
		for ($i = 0; count($data) > $i; $i++) {

			if ($data[$i] == $pate_id || $data[$i] == $paten_kind_id) {
				$isInProgramm = true;
			}
		}

		return $isInProgramm;
	}

	/**
	 * Add an user to the sponsorship program and decides if it is a sponsor or sponsor child.
	 *
	 * @param integer $id user ID
	 * @param boolean $noNews if True, then the network news creation is suppressed
	 * @return string
	 */
	public function AddUser($id, $noNews=false) {

		$getGroup = $this -> getGroup($id);
		$showGroup = $getGroup[0][usergroup];

		$getConfig = $this -> getConfig();
		$pate_id = $getConfig[0][pate_id];
		$paten_kind_id = $getConfig[0][paten_kind_id];

		//Hole Gruppendaten
		$IsInProgramm = $this -> IsInProgramm($getGroup);

		//Prüft ob er bereits im Patenprogramm gespeichert wurde
		if ($IsInProgramm == true) {
			return "NO";
		} else {
			$time = time();
			$getPatenTyp = $this -> getPatenTyp($id);
			$end1 = $getPatenTyp[0][end1];
			$end2 = $getPatenTyp[0][end2];
			$end3 = $getPatenTyp[0][end3];

			if ($end1 != "" || $end2 != "" || $end3 != "") {
				// Falls er bereits seinen Abschluss gemacht hat
				// alte Zeile. Hat auf alle Abschlüsse geschaut, es reicht aber der Erste: if ($time > $end1 && $time > $end2 && $time > $end3) {
				if ($time > $end1 ) {
					$new_group = $showGroup . "," . $pate_id;

					$query = $this -> createQuery();
					$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
					$query -> statement("UPDATE fe_users SET usergroup = '$new_group' WHERE uid = '$id' LIMIT 1");
					$query -> execute();
					if (!$noNews) { $this->CreateMessage($id); }
					return "Pate";

				} else {
					$new_group = $showGroup . "," . $paten_kind_id;

					$query = $this -> createQuery();
					$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
					$query -> statement("UPDATE fe_users SET usergroup = '$new_group' WHERE uid = '$id' LIMIT 1");
					$query -> execute();
					if (!$noNews) { $this->CreateMessage($id); }
					return "Patenkind";
				}
			} else {
				//Ist weder ein Student noch ein Absolvent
				return "ERROR";
			}
		}
	}

	
	/**
	 * Creates entry in network changes table (creates a dependency to network changes module)
	 *
	 * @param integer $id  user ID
	 * @return void
	 */
	private function CreateMessage($id) {
		$insert = array();
		$insert['changed_feuser_field'] = 'Patenprogramm';
		$insert['news_message'] = ' nimmt jetzt am Patenprogramm teil.' ;
		$insert['crdate'] = time();
		$insert['user_id'] = $id;
		return $GLOBALS['TYPO3_DB']->exec_INSERTquery(
				'tx_wmdbbanetworknews_changes',
				$insert
		);
	}
	
	/**
	 * Delete an user from the sponsorship program
	 *
	 * @param integer $id  user ID
	 * @return void
	 */
	public function DeleteUser($id) {

		$getGroup = $this -> getGroup($id);
		$showGroup = $getGroup[0][usergroup];

		$getConfig = $this -> getConfig();
		$pate_id = $getConfig[0][pate_id];
		$paten_kind_id = $getConfig[0][paten_kind_id];

		$data = explode(",", $showGroup);

		for ($i = 0; count($data) > $i; $i++) {

			if ($data[$i] != $pate_id && $data[$i] != $paten_kind_id) {
				$wert = $wert . $data[$i] . ",";
			}
		}
		$new_group = substr($wert, 0, -1);

		//UPDATE
		$query = $this -> createQuery();
		$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
		$query -> statement("UPDATE fe_users SET usergroup = '$new_group' WHERE uid = '$id' LIMIT 1");
		return $query -> execute();

	}

	/**
	 * To make a string safe
	 *
	 * @param string $string
	 * @return string
	 */
	public function niceString($string) {
		return trim(mysqli_real_escape_string(strip_tags(htmlentities($string))));
	}

}
?>
