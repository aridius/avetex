<?php
class ModelCatalogAridiusReviewNews extends Model {
	
	public function addReviewNews($data) {
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "aridius_review_news SET author = '" . $this->db->escape($data['author']) . "', news_id  = '" . (int)$data['news_id'] . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', date_added = '" . $this->db->escape($data['date_added']) . "', status = '" . (int)$data['status'] . "'");

		$review_id  = $this->db->getLastId();
		
		$this->cache->delete('news');

		return $review_id ;
	}

	public function editReviewNews($review_id, $data) {
		
	    $this->db->query("UPDATE " . DB_PREFIX . "aridius_review_news SET author = '" . $this->db->escape($data['author']) . "', news_id = '" . (int)$data['news_id'] . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', date_added = '" . $this->db->escape($data['date_added']) . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE review_id = '" . (int)$review_id . "'");

		$this->cache->delete('news');
	}

	public function deleteReviewNews($review_id) {
		
        $this->db->query("DELETE FROM " . DB_PREFIX . "aridius_review_news WHERE review_id = '" . (int) $review_id . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aridius_review_news WHERE parent_id = '" . (int)$review_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteReviewNews($result['review_id']);
		}
	}

	public function getReviewNews($review_id ) {

	$query = $this->db->query("SELECT DISTINCT *, (SELECT pd.title FROM " . DB_PREFIX . "aridius_news_description pd WHERE pd.aridius_news_id  = r.news_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS news FROM " . DB_PREFIX . "aridius_review_news r WHERE r.review_id = '" . (int)$review_id . "'");

		return $query->row;
	}

	
	public function getReviewsNews($data = array()) {
		
		$sql = "SELECT r.review_id, pd.title, r.author, r.status, r.date_added FROM " . DB_PREFIX . "aridius_review_news r LEFT JOIN " . DB_PREFIX . "aridius_news_description pd ON (r.news_id = pd.aridius_news_id ) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		

		if (!empty($data['filter_news'])) {
			$sql .= " AND pd.title LIKE '" . $this->db->escape($data['filter_news']) . "%'";
		}
		
		
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
			'pd.title',
			'author',
			'status',
			'date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY review_id ";
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

	public function getTotalReviewsNews($data = array()) {
		
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "aridius_review_news r LEFT JOIN " . DB_PREFIX . "aridius_news_description pd ON (r.news_id = pd.aridius_news_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_news'])) {
			$sql .= " AND pd.title LIKE '" . $this->db->escape($data['filter_news']) . "%'";
		}

		if (!empty($data['filter_author'])) {
			$sql .= " AND r.author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
}