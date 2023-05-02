<?php
	class ModelCatalogAridiusSize extends Model {
		
	public function addSize($data) {
	$this->db->query("INSERT INTO `" . DB_PREFIX . "aridius_size` SET  status = '" . (int)$data['status'] . "'");
	$aridius_size_id = $this->db->getLastId();
	foreach ($data['aridius_size_description'] as $language_id => $aridius_size_description) {
	$this->db->query("INSERT INTO " . DB_PREFIX . "aridius_size_description SET language_id = '" . (int)$language_id . "', aridius_size_id = '" . (int)$aridius_size_id . "', name = '" . $this->db->escape($aridius_size_description['name']) . "', description = '" . $this->db->escape($aridius_size_description['description']) . "'");
	}
			if(!empty($data['product'])) {
				foreach($data['product'] as $product_id) {
					$this->db->query("INSERT INTO ". DB_PREFIX ."aridius_size_product SET aridius_size_id = '" . (int)$aridius_size_id . "', product_id = '" . (int)$product_id . "'");
				}
			}
			if(!empty($data['product_category'])) {
				foreach($data['product_category'] as $category_id) {
					$this->db->query("INSERT INTO ". DB_PREFIX ."aridius_size_category SET aridius_size_id = '" . (int)$aridius_size_id . "', category_id = '" . (int)$category_id . "'");
				}
			}
	return $aridius_size_id;
	}

	public function editSize($aridius_size_id, $data) {
	$this->db->query("UPDATE " . DB_PREFIX . "aridius_size SET status = '" . (int)$data['status'] . "' WHERE aridius_size_id = '" . (int)$aridius_size_id . "'");
	$this->db->query("DELETE FROM " . DB_PREFIX . "aridius_size_description WHERE aridius_size_id = '" . (int)$aridius_size_id . "'");
	foreach ($data['aridius_size_description'] as $language_id => $aridius_size_description) {
	$this->db->query("INSERT INTO " . DB_PREFIX . "aridius_size_description SET language_id = '" . (int)$language_id . "', aridius_size_id = '" . (int)$aridius_size_id . "', name = '" . $this->db->escape($aridius_size_description['name']) . "', description = '" . $this->db->escape($aridius_size_description['description']) . "'");
	}
			$this->db->query("DELETE FROM " . DB_PREFIX . "aridius_size_product WHERE aridius_size_id = '" . (int)$aridius_size_id . "'");
			if(!empty($data['product'])) {
				foreach($data['product'] as $product_id) {
					$this->db->query("INSERT INTO ". DB_PREFIX ."aridius_size_product SET aridius_size_id = '" . (int)$aridius_size_id . "', product_id = '" . (int)$product_id . "'");
				}
			}
			$this->db->query("DELETE FROM " . DB_PREFIX . "aridius_size_product WHERE aridius_size_id = '" . (int)$aridius_size_id . "'");
			if(!empty($data['product'])) {
				foreach($data['product'] as $product_id) {
					$this->db->query("INSERT INTO ". DB_PREFIX ."aridius_size_product SET aridius_size_id = '" . (int)$aridius_size_id . "', product_id = '" . (int)$product_id . "'");
				}
			}
			$this->db->query("DELETE FROM " . DB_PREFIX . "aridius_size_category WHERE aridius_size_id = '" . (int)$aridius_size_id . "'");
			if(!empty($data['product_category'])) {
				foreach($data['product_category'] as $category_id) {
					$this->db->query("INSERT INTO ". DB_PREFIX ."aridius_size_category SET aridius_size_id = '" . (int)$aridius_size_id . "', category_id = '" . (int)$category_id . "'");
				}
			}
	}

	public function deleteSize($aridius_size_id) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "aridius_size WHERE aridius_size_id = '" . (int)$aridius_size_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "aridius_size_description WHERE aridius_size_id = '" . (int)$aridius_size_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "aridius_size_category WHERE aridius_size_id = '" . (int)$aridius_size_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "aridius_size_product WHERE aridius_size_id = '" . (int)$aridius_size_id . "'");
	}

	public function getSize($aridius_size_id) {
	$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "aridius_size` s LEFT JOIN " . DB_PREFIX . "aridius_size_description sd ON (s.aridius_size_id = sd.aridius_size_id) WHERE s.aridius_size_id = '" . (int)$aridius_size_id . "' AND sd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
	return $query->row;
	}

	public function getSizeValue($data = array()) {
	$sql = "SELECT * FROM " . DB_PREFIX . "aridius_size ass LEFT JOIN " . DB_PREFIX . "aridius_size_description asd ON (ass.aridius_size_id = asd.aridius_size_id) WHERE asd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
	$sort_data = array(
	'asd.name',
	'ass.sort_order'
	);
	if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
	$sql .= " ORDER BY " . $data['sort'];
	} else {
	$sql .= " ORDER BY asd.name";
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

	public function getSizeDescriptions($aridius_size_id) {
	$size_data = array();
	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aridius_size_description WHERE aridius_size_id = '" . (int)$aridius_size_id . "'");
	foreach ($query->rows as $result) {
	$size_data[$result['language_id']] = array(
	'name'        => $result['name'],
	'description'      => $result['description']
	);
	}
	return $size_data;
	}

	public function getProduct($aridius_size_id) {
			$query = $this->db->query("SELECT * FROM ". DB_PREFIX ."aridius_size_product WHERE aridius_size_id = '". $aridius_size_id ."'");
			$products_data = array();
			foreach($query->rows as $value) {
				$products_data[] = $value['product_id'];
			}
		 return $products_data;
	  }
	  
	public function getCategories($aridius_size_id) {
			$query = $this->db->query("SELECT * FROM ". DB_PREFIX ."aridius_size_category WHERE aridius_size_id ='". $aridius_size_id ."'");
			$categories_data = array();
			foreach($query->rows as $value) {
				$categories_data[] = $value['category_id'];
			}
		 return $categories_data;
	  }
	  
	public function getTotaSize() {
	$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "aridius_size`");
	return $query->row['total'];
	}
	}