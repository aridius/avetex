<?php
class ModelCatalogAridiusStorereview extends Model {
	
	public function addReview($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "aridius_review_store SET author = '" . $this->db->escape($data['author']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', date_added = '" . $this->db->escape($data['date_added']) . "', status = '" . (int)$data['status'] . "'");

		$review_id = $this->db->getLastId();

		return $review_id;
	}

	public function editReview($review_id, $data) {

	    $this->db->query("UPDATE " . DB_PREFIX . "aridius_review_store SET author = '" . $this->db->escape($data['author']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', date_added = '" . $this->db->escape($data['date_added']) . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE review_id = '" . (int)$review_id . "'");

	}
	
	public function deleteReview($review_id) {
		
        $this->db->query("DELETE FROM " . DB_PREFIX . "aridius_review_store WHERE review_id = '" . (int) $review_id . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aridius_review_store WHERE parent = '" . (int)$review_id . "'");

		foreach ($query->rows as $result) {
			
			$this->deleteReview($result['review_id']);
		}
	}

	public function getReview($review_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aridius_review_store WHERE review_id = '" . (int)$review_id . "'");
		
		return $query->row;
	}
	
	public function getReviews($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "aridius_review_store WHERE 1=1";

		if (!empty($data['filter_author'])) {
			$sql .= " AND author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$sort_data = array(
			'pd.name',
			'author',
			'rating',
			'status',
			'date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY review_id";
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

			$sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalReviews() {
		
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "aridius_review_store");

		return $query->row['total'];
	}   
}