<?php
class ModelCatalogAridiusMenu extends Model {

public function addCategory($data) {
		
		$query = $this->db->query("SELECT MAX(sort_order) AS position FROM " . DB_PREFIX . "aridiusmenu");
		$sort_order = (int)$query->row['position'] + 1;
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "aridiusmenu SET  sort_order = '" . (int)$sort_order . "', stickers = '" . (int)$data['stickers'] . "', columnn = '" . (int)$data['columnn'] . "', top = '" . (int)$data['top'] . "', parent_id = '0'");

		$aridiusmenu_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "aridiusmenu SET image = '" . $this->db->escape($data['image']) . "' WHERE aridiusmenu_id = '" . (int)$aridiusmenu_id . "'");
		}
		
		if (isset($data['image_menu_ico'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "aridiusmenu SET image_menu_ico = '" . $this->db->escape($data['image_menu_ico']) . "' WHERE aridiusmenu_id = '" . (int)$aridiusmenu_id . "'");
		}

		foreach ($data['information_menu'] as $language_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "aridiusmenu_description SET aridiusmenu_id = '" . (int)$aridiusmenu_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', url = '" . $this->db->escape($value['url']) . "'");
		}
}

public function sortOrderCategory($menu,$parent_id){
		$i = 0;
		foreach($menu as $val){
			
			$this->db->query("UPDATE " . DB_PREFIX . "aridiusmenu SET sort_order = '" . $i . "', parent_id='" . $parent_id . "' WHERE aridiusmenu_id='" . $val['id'] . "'");
			if(isset($val['children'])){
				$this->sortOrderCategory($val['children'],$val['id']);
			}
			$i++;
		}
		
		return true;
}

public function updateCategory($data) { 

		$this->db->query("DELETE FROM " . DB_PREFIX . "aridiusmenu_description WHERE aridiusmenu_id='" . $data['aridiusmenu_id'] . "'");	
			
		$this->db->query("UPDATE " . DB_PREFIX . "aridiusmenu SET  stickers = '" . (int)$data['stickerst'] . "', columnn = '" . (int)$data['columnnt'] . "', top = '" . (int)$data['topt'] . "' WHERE aridiusmenu_id = '" . (int)$data['aridiusmenu_id'] . "'");

		
		if (isset($data['imaget'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "aridiusmenu SET image = '" . $this->db->escape($data['imaget']) . "' WHERE aridiusmenu_id = '" . (int)$data['aridiusmenu_id'] . "'");
		}
		
		if (isset($data['image_menu_icot'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "aridiusmenu SET image_menu_ico = '" . $this->db->escape($data['image_menu_icot']) . "' WHERE aridiusmenu_id = '" . (int)$data['aridiusmenu_id'] . "'");
		}			

			foreach ($data['menu']['information_menut'] as $language_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "aridiusmenu_description SET aridiusmenu_id = '" . (int)$data['aridiusmenu_id'] . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', url = '" . $this->db->escape($value['url']) . "'");
				
			}
}

public function deleteCategory($aridiusmenu_id) { 
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aridiusmenu WHERE parent_id='" . $aridiusmenu_id . "'");
			if($query->rows){
				foreach($query->rows as $val){
					$this->db->query("UPDATE " . DB_PREFIX . "aridiusmenu SET parent_id='0' WHERE aridiusmenu_id='" . $val['aridiusmenu_id'] . "'");
				}
			}
			$this->db->query("DELETE FROM " . DB_PREFIX . "aridiusmenu_description WHERE aridiusmenu_id='" . $aridiusmenu_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "aridiusmenu WHERE aridiusmenu_id='" . $aridiusmenu_id . "'");

}

public function deleteCategoryall() { 
			$this->db->query("DELETE FROM " . DB_PREFIX . "aridiusmenu_description");
			$this->db->query("DELETE FROM " . DB_PREFIX . "aridiusmenu");
}

public function copyCategoryall() { 
	  $this->db->query("DELETE FROM " . DB_PREFIX . "aridiusmenu_description");
	  $this->db->query("DELETE FROM " . DB_PREFIX . "aridiusmenu");
	$this->db->query("INSERT " . DB_PREFIX . "aridiusmenu (aridiusmenu_id, parent_id, sort_order, columnn, top, image, image_menu_ico, stickers) SELECT category_id, parent_id, sort_order, `column`, `top`, image, image_menu_ico, stickers FROM " . DB_PREFIX . "category");
	$this->db->query("INSERT " . DB_PREFIX . "aridiusmenu_description (aridiusmenu_id, language_id, name) SELECT category_id, language_id, name FROM " . DB_PREFIX . "category_description");
	$this->db->query("UPDATE " . DB_PREFIX . "aridiusmenu_description ad LEFT JOIN " . DB_PREFIX . "seo_url ua ON ad.aridiusmenu_id = SUBSTRING_INDEX(ua.query, '=', -1) AND ad.language_id = ua.language_id SET ad.url = ua.keyword");
	}

	public function getMenu() { 
			$sql = "SELECT * FROM " . DB_PREFIX . "aridiusmenu i LEFT JOIN " . DB_PREFIX . "aridiusmenu_description id ON (i.aridiusmenu_id = id.aridiusmenu_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY sort_order ASC";
			$query = $this->db->query($sql);
			
			return $query->rows;
	}

	public function getcustommenuDesc() {
			$data = array();

			$name = array();

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aridiusmenu_description AS md LEFT JOIN " . DB_PREFIX . "aridiusmenu AS m  ON m.aridiusmenu_id = md.aridiusmenu_id ");

			foreach ($query->rows as $result) {
				if (!empty($result['name'])) {
					$name[$result['aridiusmenu_id']] = $result['name'];
				}
				if (empty($result['name']) and !empty($name[$result['aridiusmenu_id']])) {
					$result['name'] = $name[$result['aridiusmenu_id']];
				}

				$data[$result['aridiusmenu_id']][$result['language_id']] = $result;
			}

			return $data;
		}
	}
