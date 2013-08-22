<?php
/**
 * Processing of database query
 *
 * @author duda|design GbR
 * @version 1.0
 *
 */
class Tx_DdSponsorship_Domain_Repository_SponsorshipLinkRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * Get all sponsors or a specific
	 *
	 * @param integer $uid  user ID
	 * @return array
	 */
	public function getPaten($uid) {

		$uid = $this -> niceString($uid);

		if (!empty($uid) && ctype_digit($uid)) {
			$where = " WHERE s1.pate = '$uid'";
		}
		$query = $this -> createQuery();
		$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
		$query -> statement("SELECT u1.username AS pate, u2.username AS patenkind, s1.uid, s1.status, s1.tstamp 
							FROM tx_ddsponsorship_domain_model_sponsorshiplink s1 
							INNER JOIN fe_users u1 ON s1.pate = u1.uid 
							INNER JOIN fe_users u2 ON s1.paten_kind = u2.uid" . $where);
		return $query -> execute();
	}

	/**
	 * Add a new connection
	 *
	 * @param integer $pate sponsor ID
	 * @param integer $patenkind sponsored child ID
	 * @param integer $status stat ID
	 * @return integer last query ID
	 */
	public function addConnection($pate, $patenkind, $status) {

		$pate = $this -> niceString($pate);
		$patenkind = $this -> niceString($patenkind);
		$status = $this -> niceString($status);

		$time = time();
		$query = $this -> createQuery();
		$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
		$query -> statement("INSERT INTO tx_ddsponsorship_domain_model_sponsorshiplink (pate, paten_kind, status, tstamp) VALUES ('$pate', '$patenkind', '$status', '$time')");
		$query -> execute();

		$query = $this -> createQuery();
		$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
		$query -> statement("SELECT DISTINCT LAST_INSERT_ID() as last FROM tx_ddsponsorship_domain_model_sponsorshiplink");
		$array = $query -> execute();
		return $array[0]['last'];
	}

	/**
	 * Delete a connection
	 *
	 * @param integer uid cnnection ID
	 * @param integer $pate sponsor ID
	 * @param integer $patenkind sponsored child ID
	 * @return void
	 */
	public function deleteConnection($uid, $pate = null, $patenkind = null) {
		return $this -> changeState($uid, 4, $pate, $patenkind);
	}

	/**
	 * Change user stat to sponsor or sponsored child
	 *
	 * @param integer $uid  connection ID
	 * @param integer $status stat ID
	 * @param integer $pate sponsor ID
	 * @param integer $patenkind sponsored child ID
	 * @return void
	 */
	public function changeState($uid, $status, $pate = null, $patenkind = null) {
		$uid = $this -> niceString($uid);
		$status = $this -> niceString($status);
		$pate = $this -> niceString($pate);
		$patenkind = $this -> niceString($patenkind);

		$qArray = array();
		!empty($uid) ? array_push($qArray, "`uid` = '$uid'") : false;
		!empty($pate) ? array_push($qArray, "`pate` = '$pate'") : false;
		!empty($patenkind) ? array_push($qArray, "`paten_kind` = '$patenkind'") : false;

		$andDelete = $status == 4 ? ", `deleted` = '1'" : ", `deleted` = '0'";

		$query = $this -> createQuery();
		$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
		$query -> statement("UPDATE tx_ddsponsorship_domain_model_sponsorshiplink SET `status`='$status' " . $andDelete . " WHERE " . implode(" AND ", $qArray) . " LIMIT 1");
		return $query -> execute();
	}

	/**
	 * Get group ID from one user
	 *
	 * @param integer $id users ID
	 * @return array
	 */
	public function getGroupById($id) {

		$id = $this -> niceString($id);
		$query = $this -> createQuery();
		$query -> getQuerySettings() -> setReturnRawQueryResult(TRUE);
		$query -> statement("SELECT usergroup FROM fe_users WHERE uid = '$id'");
		return $query -> execute();
	}

	/**
	 * To make a string safe
	 *
	 * @param string $string
	 * @return string
	 */
	public function niceString($string) {
		return trim(mysql_real_escape_string(strip_tags(htmlentities($string))));
	}

}
?>
