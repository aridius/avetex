<?php
class ModelExtensionModuleAridiusletters extends Model {

	public function addsubScribes($data) {
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "aridius_letters(email_user,email_date) values ('". $this->db->escape($data['email']) ."','".date("Y-m-d")."')");
	}
		
	public function compareEmail($email) {
		
		$query = $this->db->query("SELECT email_user FROM " . DB_PREFIX . "aridius_letters where email_user = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	return $query->row;
	}	
}
		
