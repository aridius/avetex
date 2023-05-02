<?php
class ModelToolLicense extends Model {
    public function init() {
        $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "license (
                        `key` varchar(3) CHARACTER SET utf8,
                        `value` text CHARACTER SET utf8,
                        primary key (`key`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=cp1251;");

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "license");
        if (!$query->num_rows) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "license (`key`) VALUES ('key');");
        }
    }

    public function addKey($key)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "license SET `value` = '" . $this->db->escape($key) . "' WHERE `key` = 'key'");
    }

    public function removeKey()
    {
        $this->db->query("UPDATE " . DB_PREFIX . "license SET `value` = NULL WHERE `key` = 'key'");
    }

    public function getKey() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "license WHERE `key` = 'key'");

        return $query->row['value'];
    }
}