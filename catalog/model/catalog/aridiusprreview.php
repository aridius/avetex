<?php
class ModelCatalogAridiusPrReview extends Model {
	
	public function getLastReviews($limit) {
		
		$query = $this->db->query("SELECT r.rating, r.author, r.text, p.product_id, pd.name, p.image, r.date_added FROM " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "product p ON (r.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.date_available <= NOW() AND p.status = '1' AND r.status = '1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY r.date_added DESC LIMIT " . (int)$limit);
		
		return $query->rows;
	}
	
	public function getTotalReviews() {
		$query = $this->db->query("SELECT COUNT(DISTINCT op.product_id) AS total FROM " . DB_PREFIX . "review op LEFT JOIN `" . DB_PREFIX . "product` o ON (op.product_id = o.product_id) LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;
		}
	}
}
