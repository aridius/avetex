<?php

class ModelExtensionModuleAridiusLikes extends Model
{
    public function addLikes($review_id, $ip, $name_btn)   {

        $this->db->query("INSERT IGNORE  INTO `" . DB_PREFIX . "aridius_like_rew` SET `review_id` = ' " . (int)$review_id . "' , `" . $this->db->escape($name_btn) . "` = '1' , `ip` = '" . $this->db->escape($ip) . "'");
    
	}

    public function checkLikes($review_id, $ip, $name_btn) {
    
        $check = $this->db->query("SELECT * FROM `" . DB_PREFIX . "aridius_like_rew` WHERE `review_id` = '" . (int)$review_id . "' AND `ip` = '" . $this->db->escape($ip) . "' AND `" . $this->db->escape($name_btn) . "`= '1' ");

        return $check->num_rows;
    }

    public function checkLikesOpposite($review_id, $ip, $name_btn) {
    
        $check_opposite = $this->db->query("SELECT * FROM `" . DB_PREFIX . "aridius_like_rew` WHERE `review_id` = '" . (int)$review_id . "' AND `ip` = '" . $this->db->escape($ip) . "' AND `" . $this->db->escape($name_btn) . "`= '1' ");

        return $check_opposite->num_rows;
    }

    public function deleteLikes($review_id, $ip, $name_btn)  {
   
        $this->db->query("DELETE FROM `" . DB_PREFIX . "aridius_like_rew` WHERE `review_id`='" . (int)$review_id . "' AND `ip`='" . $this->db->escape($ip) . "' AND `" . $this->db->escape($name_btn) . "`= '1' ");
    }

    public function sumLikes($review_id)  {
   
        $query = $this->db->query("SELECT SUM(likes), SUM(dislikes) FROM `" . DB_PREFIX . "aridius_like_rew` WHERE `review_id`='" . (int)$review_id . "' ");
        return $query->rows;
    }
}