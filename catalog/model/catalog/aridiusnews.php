<?php
class ModelCatalogAridiusNews extends Model {

	public function updateViewed($aridius_news_id) { 
	
		$this->db->query("UPDATE " . DB_PREFIX . "aridius_news SET viewed = (viewed + 1) WHERE aridius_news_id = '" . (int)$aridius_news_id . "'");
	}

	public function getaridius_newsStory($aridius_news_id) {
		
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "aridius_news n LEFT JOIN " . DB_PREFIX . "aridius_news_description nd ON (n.aridius_news_id = nd.aridius_news_id) LEFT JOIN " . DB_PREFIX . "aridius_news_to_store n2s ON (n.aridius_news_id = n2s.aridius_news_id) WHERE n.aridius_news_id = '" . (int)$aridius_news_id . "' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND n.status = '1'");

		return $query->row;
	}

	public function getaridius_news($data) {
		
		$sql = "SELECT * FROM " . DB_PREFIX . "aridius_news n LEFT JOIN " . DB_PREFIX . "aridius_news_description nd ON (n.aridius_news_id = nd.aridius_news_id) LEFT JOIN " . DB_PREFIX . "aridius_news_to_store n2s ON (n.aridius_news_id = n2s.aridius_news_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND n.status = '1' ORDER BY n.sort_order, n.date_added DESC";
		
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
	public function getaridius_newsShort($limit) {
		
		$aridius_news_data = $this->cache->get('aridius_news.short.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$limit);

		if (!$aridius_news_data) {
			$aridius_news_data = array();

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aridius_news n LEFT JOIN " . DB_PREFIX . "aridius_news_description nd ON (n.aridius_news_id = nd.aridius_news_id) LEFT JOIN " . DB_PREFIX . "aridius_news_to_store n2s ON (n.aridius_news_id = n2s.aridius_news_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND n.status = '1'  ORDER BY n.sort_order, n.date_added DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$aridius_news_data[$result['aridius_news_id']] = $this->getaridius_newsStory($result['aridius_news_id']);
			}

			$this->cache->set('aridius_news.short.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$limit, $aridius_news_data);
		}

		return $aridius_news_data;
	}
	
	public function getProductRelated($aridius_news_id) {
		
		$product_data = array();

		$query = $this->db->query("SELECT nr.product_id FROM " . DB_PREFIX . "aridius_news_product_related nr LEFT JOIN " . DB_PREFIX . "product p ON (nr.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (nr.product_id = p2s.product_id) WHERE nr.aridius_news_id = '" . (int)$aridius_news_id . "' AND p.status = '1' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		$this->load->model('catalog/product');
		foreach ($query->rows as $result) { 
			$product_data[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
		}
		
		return $product_data;
	}

	public function getaridius_newsRelated($aridius_news_id) {

		$aridius_news_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aridius_news n LEFT JOIN " . DB_PREFIX . "aridius_news_description nd ON (n.aridius_news_id = nd.aridius_news_id) LEFT JOIN " . DB_PREFIX . "aridius_news_to_store n2s ON (n.aridius_news_id = n2s.aridius_news_id) LEFT JOIN " . DB_PREFIX . "aridius_news_related nr ON (n.aridius_news_id = nr.related_aridius_news_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND n.status = '1' AND n.sort_order <> '-1' AND nr.aridius_news_id = '" . (int)$aridius_news_id. "' ORDER BY n.sort_order");			

		return $query->rows;
	}	

	public function getTotalaridius_news() {
		
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "aridius_news n LEFT JOIN " . DB_PREFIX . "aridius_news_to_store n2s ON (n.aridius_news_id = n2s.aridius_news_id) WHERE n2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND n.status = '1'");

		if ($query->row) {
			return $query->row['total'];
		} else {
			return false;
		}
	}
}
