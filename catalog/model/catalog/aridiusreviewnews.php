<?php
class ModelCatalogAridiusReviewNews extends Model {
	
	public function addReviewNews($aridius_news_id, $data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "aridius_review_news SET author = '" . $this->db->escape($data['name']) . "', customer_id = '" . (int)$this->customer->getId() . "', news_id = '" . (int)$aridius_news_id . "', parent_id = '" . (int)$data['parent'] . "', text = '" . $this->db->escape($data['text']) . "', date_added = NOW()");

		$review_id = $this->db->getLastId();
		
		if ($this->config->get('aridius_news_mail')!=1) {
            $this->load->language('mail/aridius_review_news');
            $subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
            $message = $this->language->get('text_waiting') . "\n";
            $message .= sprintf($this->language->get('text_reviewer'), html_entity_decode($data['name'], ENT_QUOTES, 'UTF-8')) . "\n";
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

    public function getReviewsByNewsId($aridius_news_id, $start = 0, $limit = 20, $parent=0) {
		
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 20;
		}

		$query = $this->db->query("SELECT r.review_id,  r.parent_id, r.author, r.text, p.aridius_news_id , p.image, r.date_added FROM " . DB_PREFIX . "aridius_review_news r LEFT JOIN " . DB_PREFIX . "aridius_news p ON (r.news_id  = p.aridius_news_id) LEFT JOIN " . DB_PREFIX . "aridius_news_description pd ON (p.aridius_news_id = pd.aridius_news_id) WHERE p.aridius_news_id = '" . (int)$aridius_news_id . "' AND r.parent_id=".(int)$parent." AND p.status = '1' AND r.status = '1'  AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY r.date_added ASC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalReviewsByNewsId($aridius_news_id) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "aridius_review_news r LEFT JOIN " . DB_PREFIX . "aridius_news p ON (r.news_id  = p.aridius_news_id) LEFT JOIN " . DB_PREFIX . "aridius_news_description pd ON (p.aridius_news_id = pd.aridius_news_id) WHERE p.aridius_news_id = '" . (int)$aridius_news_id . "' AND parent_id=0 AND p.status = '1' AND r.status = '1'  AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row['total'];
	}
}