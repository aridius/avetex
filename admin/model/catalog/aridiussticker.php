<?php
	class ModelCatalogAridiusSticker extends Model {

	public function addSticker($data) {
		
	$this->db->query("INSERT INTO `" . DB_PREFIX . "aridius_sticker` SET  sort_order = '" . (int)$data['sort_order'] . "', color = '" . $data['color'] . "', background = '" . $data['background'] . "'");

	$sticker_id = $this->db->getLastId();

	foreach ($data['aridius_sticker_description'] as $language_id => $aridius_sticker_description) {
	$this->db->query("INSERT INTO " . DB_PREFIX . "aridius_sticker_description SET language_id = '" . (int)$language_id . "', sticker_id = '" . (int)$sticker_id . "', name = '" . $this->db->escape($aridius_sticker_description['name']) . "'");
	}

	return $sticker_id;

	}

	public function editSticker($sticker_id, $data) {
		
	$this->db->query("UPDATE " . DB_PREFIX . "aridius_sticker SET sort_order = '" . (int)$data['sort_order'] . "', color = '" . $data['color'] . "', background = '" . $data['background'] . "'  WHERE sticker_id = '" . (int)$sticker_id . "'");

	$this->db->query("DELETE FROM " . DB_PREFIX . "aridius_sticker_description WHERE sticker_id = '" . (int)$sticker_id . "'");

	foreach ($data['aridius_sticker_description'] as $language_id => $aridius_sticker_description) {
	$this->db->query("INSERT INTO " . DB_PREFIX . "aridius_sticker_description SET language_id = '" . (int)$language_id . "', sticker_id = '" . (int)$sticker_id . "', name = '" . $this->db->escape($aridius_sticker_description['name']) . "'");
	}

	}

	public function deleteSticker($sticker_id) {
		
	$this->db->query("DELETE FROM `" . DB_PREFIX . "aridius_sticker` WHERE sticker_id = '" . (int)$sticker_id . "'");
	$this->db->query("DELETE FROM " . DB_PREFIX . "aridius_sticker_description WHERE sticker_id = '" . (int)$sticker_id . "'");

	}

	public function getSticker($sticker_id) {

	$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "aridius_sticker` s LEFT JOIN " . DB_PREFIX . "aridius_sticker_description sd ON (s.sticker_id = sd.sticker_id) WHERE s.sticker_id = '" . (int)$sticker_id . "' AND sd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

	return $query->row;
	}

	public function getStickerValue($data = array()) {

	$sql = "SELECT * FROM " . DB_PREFIX . "aridius_sticker ass LEFT JOIN " . DB_PREFIX . "aridius_sticker_description asd ON (ass.sticker_id = asd.sticker_id) WHERE asd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

	$sort_data = array(
	'asd.name',
	'ass.sort_order'
	);

	if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
	$sql .= " ORDER BY " . $data['sort'];
	} else {
	$sql .= " ORDER BY asd.name";
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
	$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
	}

	$query = $this->db->query($sql);

	return $query->rows;
	}

	public function getStickerDescriptions($sticker_id) {
		
	$sticker_data = array();

	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aridius_sticker_description WHERE sticker_id = '" . (int)$sticker_id . "'");

	foreach ($query->rows as $result) {
	$sticker_data[$result['language_id']] = array(
	'name'        => $result['name'],
	);
	}

	return $sticker_data;

	}

	public function getTotalStickers() {
		
	$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "aridius_sticker`");

	return $query->row['total'];

	}
	}