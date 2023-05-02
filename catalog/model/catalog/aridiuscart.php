<?php

class ModelCatalogAridiusCart extends Model {
	public function getRelatedCart($product_id) {
		$product_data = array();
		$limit = $this->config->get('theme_deluxe_cart_relprlimit');
		
		if (isset($product_id) && (int)$product_id > 0) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."product_related pr LEFT JOIN ".DB_PREFIX."product p ON (pr.related_id = p.product_id) LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pr.product_id = '".(int)$product_id."' AND p.status = '1' AND p.quantity  > '0' AND p.date_available <= NOW() AND p2s.store_id = '".(int)$this->config->get('config_store_id')."' LIMIT ".(int)$limit);
			foreach ($query->rows as $result) {
				$product_data[] = $result['related_id'];
			}
		}

	if ($this->config->get('theme_deluxe_relpr_auto')) {  
					$related_qt = $this->config->get('theme_deluxe_relqt'); 
					
					$num_related = $related_qt - count($product_data);
					if($num_related > 0)
					{    
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category p2c LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p2c.category_id IN (SELECT category_id FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "') AND p.product_id != '" . (int)$product_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY RAND() LIMIT 0," . $num_related); 
						
						foreach ($query->rows as $result) { 
								$product_data[] = $result['product_id'];
						}
					}
		
					$num_related = $related_qt - count($product_data);
					if($num_related > 0)
					{	
					
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.manufacturer_id IN (SELECT manufacturer_id FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "') AND p.product_id != '" . (int)$product_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY RAND() LIMIT 0," . $num_related); 
						
						foreach ($query->rows as $result)
								$product_data[] = $result['product_id'];
				    
						return $product_data;
					}
	}	
		return $product_data;
	}
}
?>