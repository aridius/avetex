<?php
class ModelCommonAridiusletters extends Model {
	
    public function install()  {
	  
		$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "aridius_letters (
				  email_id int(11) NOT NULL AUTO_INCREMENT,
				  email_user varchar(96) NOT NULL,
				  email_date date NOT NULL,
				  PRIMARY KEY (`email_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
	}

	public function deleteAridiusnewsletters($email_id) {

		$this->db->query("DELETE FROM " . DB_PREFIX . "aridius_letters WHERE email_id = '" . (int)$email_id . "'");
	    $this->db->query("DELETE FROM " . DB_PREFIX . "aridius_letters WHERE email_user = '" . (int)$email_id . "'"); 
		$this->db->query("DELETE FROM " . DB_PREFIX . "aridius_letters WHERE email_date = '" . (int)$email_id . "'"); 
		$this->cache->delete('aridius_letters');

	}
			
	public function getMails($data = array()) {

	    $sql = "SELECT * FROM " . DB_PREFIX . "aridius_letters";

		if (isset($data['filter_email_id']) && !is_null($data['filter_email_id'])) {
			$sql .= " WHERE email_id = '" . (int) $data['filter_email_id'] . "'";
		} else {
			$sql .= " WHERE email_id > '0'";
		}

		if (!empty($data['filter_email_user'])) {
			$sql .= " AND email_user LIKE '%" . $this->db->escape($data['filter_email_user']) . "%'";
		}

		if (!empty($data['filter_email_date'])) {
			$sql .= " AND DATE(email_date) = DATE('" . $this->db->escape($data['filter_email_date']) . "')";
		}
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY email_id";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

		if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
			
	public function getTotalMails($data = array()) {
		
	    $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "aridius_letters";

		$query = $this->db->query($sql);

		return $query->row['total'];
	}	
}