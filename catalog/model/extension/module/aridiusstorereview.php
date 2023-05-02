<?php
class ModelExtensionModuleAridiusStoreReview extends Model {

    public function addReview($data)  {

        $this->db->query("INSERT INTO " . DB_PREFIX . "aridius_review_store SET author = '" . $this->db->escape($data['name']) . "', customer_id = '" . (int)$this->customer->getId() . "',  text = '" . $this->db->escape($data['text']) . "', rating = '" . (int)$data['rating'] . "',parent = '" . (int)$data['parent'] . "', date_added = NOW()");
        
		$review_id = $this->db->getLastId();

		if ($this->config->get('aridius_store_review_mail')!=1) {
            $this->load->language('extension/module/aridius_store_review');
            $subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
            $message = $this->language->get('text_waiting') . "\n";
            $message .= sprintf($this->language->get('text_reviewer'), html_entity_decode($data['name'], ENT_QUOTES, 'UTF-8')) . "\n";
            $message .= sprintf($this->language->get('text_rating'), $data['rating']) . "\n";
            $message .= $this->language->get('text_review') . "\n";
            $message .= html_entity_decode($data['text'], ENT_QUOTES, 'UTF-8') . "\n\n";
            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
            $mail->setTo($this->config->get('config_email'));
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
            $mail->setSubject($subject);
            $mail->setText($message);
            $mail->send();
			
		    // Send to additional alert emails
			$emails = explode(',', $this->config->get('config_alert_email'));
	
			foreach ($emails as $email) {
				if ($email && preg_match($this->config->get('config_mail_regexp'), $email)) {
				    $mail->setTo($email);
					$mail->send();
				}
			}
        }
    }
    public function getReviewsById($start = 0, $limit = 20,$parent=0) {
		
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 20;
		}
    
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aridius_review_store where parent=".(int)$parent." AND status = '1' ORDER BY date_added DESC LIMIT " . (int)$start . "," . (int)$limit);
        return $query->rows;
    }
	
	 public function getReviewsById2($parent=0) {

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aridius_review_store where parent=".(int)$parent." AND status = '1'");
        return $query->rows;
    }	

    public function getTotalReview() {
  
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "aridius_review_store WHERE parent=0 AND status = '1'");
        return $query->row['total'];
    }

    public function getTotalReviewAverage() {
    
        $query = $this->db->query("SELECT AVG(rating) AS OrderAverage FROM " . DB_PREFIX . "aridius_review_store WHERE parent=0 AND status = '1'" );
        return $query->row['OrderAverage'];
    }
}