<?php

class ModelCatalogAridiusinstocksend extends Model {
	
	public function notifyProduct($product_id, $data){
	
			$this->language->load('catalog/aridiusinstock');
		$this->load->model('catalog/product');
		$product = $this->model_catalog_product->getProduct($product_id);

		if ($product['quantity'] == '0' && $data['quantity'] > 0) {
		  if ($this->config->get('module_aridiusinstock_status')== 1) {
			
			$emails = array();
			
			if ($this->config->get('module_aridiusinstock_mail_send')== 1) {
			$emails = $this->db->query("SELECT email FROM " . DB_PREFIX . "aridiusinstock WHERE product_id = '" . (int) $product_id . "' AND status = 0 ");	
			} else {
			$emails = $this->db->query("SELECT email FROM " . DB_PREFIX . "aridiusinstock WHERE product_id = '" . (int) $product_id . "' AND email != ''");
			}
				$email_subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));
				$email_text = '' . $product['name'] . ''. "\n <br>";
				$email_text .= HTTP_CATALOG . 'index.php?route=product/product&product_id=' . $product_id . "\n <br>";
			    foreach ($emails->rows as $email) {
				
				$mail = new Mail($this->config->get('config_mail_engine'));
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
			    $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
				$mail->setTo($email);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($this->config->get('config_name'));
				$mail->setSubject($email_subject);
				$mail->setHtml($email_text);
				$mail->send();
			}
		
			$this->removeProductId($product_id);
		}
	  }
	}
	
	public function removeProductId($product_id){
		
	    if ($this->config->get('module_aridiusinstock_mail_send')== 1) {
		$this->db->query("UPDATE " . DB_PREFIX . "aridiusinstock SET status = 1 WHERE product_id = '" . (int) $product_id . "'");
		} else {
		$this->db->query("DELETE FROM " . DB_PREFIX . "aridiusinstock WHERE product_id = '" . (int) $product_id . "' AND email != '' ");
		}
	}
}