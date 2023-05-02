<?php
	class ModelExtensionModuleAridiusinstock extends Model {

	public function addOrder($data) {
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "aridiusinstock SET contact = '" . $this->db->escape($data['contact']) . "',firstname = '" . $this->db->escape($data['firstname']) . "',email = '" . $this->db->escape($data['email']) . "',product_id = '" . (int) $data['product_id'] . "', product_name = '" . $this->db->escape($data['product_name']) . "', date_added = NOW() ");

		$order_id = $this->db->getLastId();

		return $order_id;
	}
}
