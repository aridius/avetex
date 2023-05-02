<?php
class ControllerExtensionModuleAridiusFaq extends Controller {

	public function index() {

		$this->load->language('extension/module/aridius_faq');

		$data['language_id'] = $this->config->get('config_language_id');
		$data['aridius_faq_status'] = $this->config->get('module_aridius_faq_status');
		$data['aridius_faq_name'] = $this->config->get('module_aridius_faq_name');

		$aridius_faq_top_links = $this->config->get('module_aridius_faq_top_links');

		$data['faq_tabs'] = array();

		if(isset($aridius_faq_top_links) && is_array($aridius_faq_top_links)) foreach ($aridius_faq_top_links as $faq_tabs) {
			$data['faq_tabs'][] = array(
			'title' 			=> $faq_tabs['title'],
			'faicons_faq' 		=> $faq_tabs['faicons_faq'],
			'description' 		=> html_entity_decode($faq_tabs['description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8')
			);
		}

		return $this->load->view('extension/module/aridius_faq', $data);

	}
}