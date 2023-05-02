<?php

	class ModelExtensionModulearidiuscallback extends Model {

	public function addOrder($data) {
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "aridiuscallback SET contact = '" . $this->db->escape($data['contact']) . "',firstname = '" . $this->db->escape($data['firstname']) . "',email = '" . $this->db->escape($data['email']) . "',time_in = '" . $this->db->escape($data['timein']) . "',time_off = '" . $this->db->escape($data['timeoff']) . "',date_added = NOW() ,comment = '" . $this->db->escape($data['comment']) . "'");

		$order_id = $this->db->getLastId();

		return $order_id;
	}
}
