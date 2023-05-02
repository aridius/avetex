<?php
class ModelCatalogAridiusfastorder extends Model {

	public function deleteOrder($order_id) {
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "aridiusfastorder WHERE order_id = '" . (int) $order_id . "'");
	}

	public function editOrder($order_id, $data) {
		
		$this->db->query("UPDATE `" . DB_PREFIX . "aridiusfastorder` SET firstname = '" . $this->db->escape($data['firstname']) . "',status = '" . $this->db->escape($data['status']) . "',email = '" . $this->db->escape($data['email']) . "',comment_manager = '" . $this->db->escape($data['comment_manager']) . "',contact = '" . $data['contact'] . "' WHERE order_id = '" . (int)$order_id . "'");
	}
	
	public function getOrder($order_id) {
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aridiusfastorder WHERE order_id = '" . (int)$order_id . "'");
		
		return $query->row;
	}

	public function getOrders($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "aridiusfastorder";

		if (isset($data['filter_order_id']) && !is_null($data['filter_order_id'])) {
			$sql .= " WHERE order_id = '" . (int) $data['filter_order_id'] . "'";
		} else {
			$sql .= " WHERE order_id > '0'";
		}

		if (!empty($data['filter_contact'])) {
			$sql .= " AND contact LIKE '%" . $this->db->escape($data['filter_contact']) . "%'";
		}
			if (!empty($data['filter_email'])) {
			$sql .= " AND email LIKE '%" . $this->db->escape($data['filter_email']) . "%'";
		}
		if (!empty($data['filter_status'])) {
			$sql .= " AND status LIKE '%" . $this->db->escape($data['filter_status']) . "%'";
		}
		
		if (!empty($data['filter_firstname'])) {
			$sql .= " AND firstname LIKE '%" . $this->db->escape($data['filter_firstname']) . "%'";
		}

		if (!empty($data['filter_product_name'])) {
			$sql .= " AND product_name LIKE '%" . $this->db->escape($data['filter_product_name']) . "%'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_total'])) {
			$sql .= " AND total = '" . (float) $data['filter_total'] . "'";
		}

		$sort_data = array(
			'order_id',
			'status',
			'email',
			'contact',
			'firstname',
			'product_name',
			'total',
			'date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY order_id";
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

	public function getTotalOrders() {
		
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "aridiusfastorder");

		return $query->row['total'];
	}   

	public function getTotalOrder() {
	
        $query = $this->db->query("SELECT COUNT(status) AS total FROM " . DB_PREFIX . "aridiusfastorder WHERE status = '" . (int)0 . "'" );

		return $query->row['total'];
	}

	public function tableExists() {
		
		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "aridiusfastorder'");

		return $query->num_rows;
	}

	public function install() {
		
		$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "aridiusfastorder (
			order_id int(11) NOT NULL AUTO_INCREMENT,
			product_id int(11) NOT NULL,
			product_option_value_id int(11) NOT NULL,
			contact varchar(96) NOT NULL,
			firstname varchar(96) NOT NULL,
			email varchar(96) NOT NULL,
			comment text NOT NULL,
			comment_manager text NOT NULL,
			product_name varchar(255) NOT NULL,
			quantity int(4) NOT NULL,
			status tinyint(1) NOT NULL,
			format_option varchar(255) NOT NULL,
			total decimal(15,4) NOT NULL DEFAULT '0.0000',
			date_added datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			currency_id int(11) NOT NULL,
			currency_code varchar(3) NOT NULL,
			currency_value decimal(15,8) NOT NULL DEFAULT '1.00000000',
			PRIMARY KEY (order_id)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
	}
}
