<?php
class ModelCatalogAridiusSize extends Model {

	public function getSizeProduct($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aridius_size_product sp LEFT JOIN " . DB_PREFIX . "aridius_size s ON (sp.aridius_size_id = s.aridius_size_id) LEFT JOIN " . DB_PREFIX . "aridius_size_description sd ON(s.aridius_size_id=sd.aridius_size_id) WHERE sp.aridius_size_id = s.aridius_size_id AND sd.language_id = '". (int)$this->config->get('config_language_id') ."' AND sp.product_id = '". (int)$product_id ."' AND s.status = '1' GROUP BY s.aridius_size_id");
		
		return $query->row;
	}
	
	public function getSizeCategory($product_id) {
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aridius_size_category sp LEFT JOIN " . DB_PREFIX . "aridius_size s ON (sp.aridius_size_id = s.aridius_size_id) LEFT JOIN " . DB_PREFIX . "aridius_size_description sd ON(s.aridius_size_id=sd.aridius_size_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON(sp.category_id=p2c.category_id) WHERE sp.aridius_size_id = s.aridius_size_id AND sd.language_id = '". (int)$this->config->get('config_language_id') ."' AND sp.category_id=p2c.category_id AND p2c.product_id = '". (int)$product_id ."' AND s.status = '1' GROUP BY s.aridius_size_id");
		
		return $query->row;
	}

}
