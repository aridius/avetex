<?php
class ControllerExtensionModuleAridiusletters extends Controller {
	
	public function index() {
	
		   $this->load->language('module/aridius_letters');
		
		   $data['language_id'] = $this->config->get('config_language_id');
		   $data['aridius_letters_pl'] = $this->config->get('module_aridius_letters_pl');
		   $data['aridius_letters_title'] = $this->config->get('module_aridius_letters_title');
		   $data['aridius_letters_placeholder'] = $this->config->get('module_aridius_letters_placeholder');
           $data['aridius_lettersdes_status'] = $this->config->get('module_aridius_lettersdes_status');
		   $data['aridius_letters_description'] = html_entity_decode ($this->config->get('module_aridius_letters_description')[$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');

		return $this->load->view('extension/module/aridius_letters', $data);
	}
	
	public function add_email() {
	
		$this->load->model('extension/module/aridiusletters');
		$this->load->language('extension/module/aridius_letters');

		$json = array();
	    $json['success_email'] = $this->language->get('success_email');
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
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
