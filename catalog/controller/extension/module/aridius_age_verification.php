<?php
class ControllerExtensionModuleAridiusAgeVerification extends Controller {
	
	public function index($setting) {

		$data['aridius_age_verification_description'] = html_entity_decode($setting['aridius_age_verification_description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
        $data['aridius_age_verification_description2'] = html_entity_decode($setting['aridius_age_verification_description2'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		return $this->load->view('extension/module/aridius_age_verification', $data);
		
	}
}

