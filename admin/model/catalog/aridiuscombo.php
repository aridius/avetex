<?php
class ModelCatalogAridiusCombo extends Model {
	public function addaridiuscombo($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "aridiuscombo` SET product_id = '" . $this->db->escape($data['product_id']) . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "'");

		$aridiuscombo_id = $this->db->getLastId();

		foreach ($data['aridiuscombo_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "aridiuscombo_description SET aridiuscombo_id = '" . (int)$aridiuscombo_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		if (isset($data['aridiuscombo_value'])) {
			foreach ($data['aridiuscombo_value'] as $aridiuscombo_value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "aridiuscombo_value SET aridiuscombo_id = '" . (int)$aridiuscombo_id . "', product_id = '" . (int)$aridiuscombo_value['product_id'] . "', discount = '" . (float)$aridiuscombo_value['discount'] . "', sort_order = '" . (int)$aridiuscombo_value['sort_order'] . "'");

			}
		}

		return $aridiuscombo_id;
	}

	public function editaridiuscombo($aridiuscombo_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "aridiuscombo` SET product_id = '" . $this->db->escape($data['product_id']) . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "' WHERE aridiuscombo_id = '" . (int)$aridiuscombo_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "aridiuscombo_description WHERE aridiuscombo_id = '" . (int)$aridiuscombo_id . "'");

		foreach ($data['aridiuscombo_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "aridiuscombo_description SET aridiuscombo_id = '" . (int)$aridiuscombo_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "aridiuscombo_value WHERE aridiuscombo_id = '" . (int)$aridiuscombo_id . "'");

		if (isset($data['aridiuscombo_value'])) {
			foreach ($data['aridiuscombo_value'] as $aridiuscombo_value) {

					$this->db->query("INSERT INTO " . DB_PREFIX . "aridiuscombo_value SET aridiuscombo_value_id = '" . (int)$aridiuscombo_value['aridiuscombo_value_id'] . "',aridiuscombo_id = '" . (int)$aridiuscombo_id . "', product_id = '" . (int)$aridiuscombo_value['product_id'] . "', discount = '" . (float)$aridiuscombo_value['discount'] . "', sort_order = '" . (int)$aridiuscombo_value['sort_order'] . "'");
			}

		}
	}

	public function deletearidiuscombo($aridiuscombo_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "aridiuscombo` WHERE aridiuscombo_id = '" . (int)$aridiuscombo_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "aridiuscombo_description WHERE aridiuscombo_id = '" . (int)$aridiuscombo_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "aridiuscombo_value WHERE aridiuscombo_id = '" . (int)$aridiuscombo_id . "'");

	}

	public function getaridiuscombo($aridiuscombo_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "aridiuscombo` o LEFT JOIN " . DB_PREFIX . "aridiuscombo_description od ON (o.aridiuscombo_id = od.aridiuscombo_id) WHERE o.aridiuscombo_id = '" . (int)$aridiuscombo_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getaridiuscombos($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "aridiuscombo` o LEFT JOIN " . DB_PREFIX . "aridiuscombo_description od ON (o.aridiuscombo_id = od.aridiuscombo_id) WHERE od.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND od.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'od.name',
			'o.type',
			'o.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY od.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getaridiuscomboDescriptions($aridiuscombo_id) {
		$aridiuscombo_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aridiuscombo_description WHERE aridiuscombo_id = '" . (int)$aridiuscombo_id . "'");

		foreach ($query->rows as $result) {
			$aridiuscombo_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $aridiuscombo_data;
	}

	public function getaridiuscomboValue($aridiuscombo_value_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aridiuscombo_value WHERE aridiuscombo_value_id = '" . (int)$aridiuscombo_value_id . "'");

		return $query->row;
	}


	public function getaridiuscomboValueDescriptions($aridiuscombo_id) {
		$aridiuscombo_value_data = array();

		$aridiuscombo_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aridiuscombo_value WHERE aridiuscombo_id = '" . (int)$aridiuscombo_id . "' ORDER BY sort_order");

		foreach ($aridiuscombo_value_query->rows as $aridiuscombo_value) {

			$aridiuscombo_value_data[] = array(
				'aridiuscombo_value_id'          => $aridiuscombo_value['aridiuscombo_value_id'],
				'product_id'                    => $aridiuscombo_value['product_id'],
				'discount'                    => $aridiuscombo_value['discount'],
				'sort_order'               => $aridiuscombo_value['sort_order']
			);
		}

		return $aridiuscombo_value_data;
	}

	public function getTotalaridiuscombos() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "aridiuscombo`");

		return $query->row['total'];
	}
}