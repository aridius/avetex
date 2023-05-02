<?php

class ModelExtensionModuleAridiusundersell extends Model {

	public function addOrder($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "aridiusundersell SET contact = '" . $this->db->escape($data['contact']) . "',firstname = '" . $this->db->escape($data['firstname']) . "',quantity = '" . $this->db->escape($data['quantity']) . "',email = '" . $this->db->escape($data['email']) . "',comment = '" . $this->db->escape($data['comment']) . "',link = '" . $this->db->escape($data['link']) . "',product_id = '" . (int) $data['product_id'] . "', product_name = '" . $this->db->escape($data['product_name']) . "', format_option = '" . $this->db->escape($data['format_option']) . "', total = '" . (float) $data['total'] . "', date_added = NOW(), currency_id = '" . (int) $data['currency_id'] . "', currency_code = '" . $this->db->escape($data['currency_code']) . "', currency_value = '" . (float) $this->db->escape($data['currency_value']) . "'");

		$order_id = $this->db->getLastId();

		return $order_id;
	}
}
