<?php

class ModelExtensionModuleOrderInStock extends Model
{

    public function CheckOrder($data, $language_id) {
        $query = $this->db->query("SELECT os.name FROM " . DB_PREFIX . "order o LEFT JOIN " . DB_PREFIX . "order_status os ON (o.order_status_id = os.order_status_id) WHERE os.language_id ='" . $language_id . "' AND o.email LIKE '" . $data['track_email'] . "' AND o.order_id ='" . $data['track_order_number'] . "'");
        return $query->row['name'];
    }
	
}