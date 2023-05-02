<?php
class ControllerExtensionModuleAridiusPopupmail extends Controller {
	
	public function index() {
	
		$data['language_id'] = $this->config->get('config_language_id');
		$data['aridius_popupmail_time'] = $this->config->get('module_aridius_popupmail_time');
		$data['aridius_popupmail_pl'] = $this->config->get('module_aridius_popupmail_pl');
		$data['aridius_popupmail_placeholder'] = $this->config->get('module_aridius_popupmail_placeholder');
		$data['aridius_popupmail_day'] = $this->config->get('module_aridius_popupmail_day');
		$data['aridius_popupmail_delay'] = $this->config->get('module_aridius_popupmail_delay');
        $data['aridius_popupmaildes_status'] = $this->config->get('module_aridius_popupmaildes_status');
		
		$data['aridius_popupmail_img'] = html_entity_decode($this->config->get('module_aridius_popupmail_img')[$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		$data['aridius_popupmail_description'] = html_entity_decode($this->config->get('module_aridius_popupmail_description')[$this->config->get('config_language_id')], ENT_QUOTES,'UTF-8');
	
		return $this->load->view('extension/module/aridius_popupmail', $data);
	}

		public function add_email() {

		$this->load->model('extension/module/aridiusletters');
		$this->load->language('extension/module/aridius_letters');

		$json = array();
	    $json['success_email'] = $this->language->get('success_emailpopup');
		$compare_email = $this->request->post['email'];

		if ((utf8_strlen($compare_email) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $compare_email)) {
			$json['error']['email'] = $this->language->get('error_email');
		} 
		
		if ($this->model_extension_module_aridiusletters->compareEmail($compare_email)) {
			$json['error']['compare_email'] = $this->language->get('error_compare_email');
		}
		
		if (!isset($json['error'])) {
			
		    $json['success'] = $this->language->get('text_success');
			$json['message'] = $this->model_extension_module_aridiusletters->addsubScribes($this->request->post);

			    $subject = $this->config->get('module_aridius_popupmail_subject')[(int)$this->config->get('config_language_id')];
				$message = $this->config->get('module_aridius_popupmail_message')[(int)$this->config->get('config_language_id')];

					$mail = new Mail($this->config->get('config_mail_engine'));
					$mail->protocol = $this->config->get('config_mail_protocol');
					$mail->parameter = $this->config->get('config_mail_parameter');
					$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
					$mail->smtp_username = $this->config->get('config_mail_smtp_username');
					$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
					$mail->smtp_port = $this->config->get('config_mail_smtp_port');
					$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
				    $mail->setTo($this->request->post['email']);
					$mail->setFrom($this->config->get('config_email'));
					$mail->setSender($this->config->get('config_name'));
					$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
					$mail->setHtml(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
					$mail->send();

		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}

