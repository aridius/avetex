<?php
class ModelCatalogAridiusMenu extends Model {
		
	public function getCategories($parent_id = 0) {

       $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aridiusmenu i LEFT JOIN " . DB_PREFIX . "aridiusmenu_description id ON (i.aridiusmenu_id = id.aridiusmenu_id) WHERE i.parent_id = '" . (int)$parent_id . "' AND id.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY sort_order ASC");

    return $query->rows;

     }
}