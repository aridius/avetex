<?php
class ControllerInformationAridiusFaq extends Controller {

	public function index() {

		$this->load->language('extension/module/aridius_faq');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
		'text' => $this->language->get('text_home'),
		'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
		'text' => $this->language->get('heading_title'),
		'href' => $this->url->link('information/aridius_faq')
		);

		if ($this->config->get('module_aridius_faq_meta_title')[(int)$this->config->get('config_language_id')]) {
			$this->document->setTitle($this->config->get('module_aridius_faq_meta_title')[(int)$this->config->get('config_language_id')]);
		} else {
			$this->document->setTitle($this->config->get('module_aridius_faq_name')[(int)$this->config->get('config_language_id')]);
		}

		$this->document->setDescription($this->config->get('module_aridius_faq_meta_description')[(int)$this->config->get('config_language_id')]);
		$this->document->setKeywords($this->config->get('module_aridius_faq_meta_keyword')[(int)$this->config->get('config_language_id')]);

		$data['language_id'] = $this->config->get('config_language_id');

		$data['aridius_faq_status'] = $this->config->get('module_aridius_faq_status');
		$data['aridius_faq_description'] = html_entity_decode($this->config->get('module_aridius_faq_description')[$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		$data['aridius_faq_description2'] = html_entity_decode($this->config->get('module_aridius_faq_description2')[$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');

		$aridius_faq_top_links = $this->config->get('module_aridius_faq_top_links');

		$data['faq_tabs'] = array();

		if(isset($aridius_faq_top_links) && is_array($aridius_faq_top_links)) foreach ($aridius_faq_top_links as $faq_tabs) {
			$data['faq_tabs'][] = array(
			'title' 			=> $faq_tabs['title'],
			'faicons_faq' 		=> $faq_tabs['faicons_faq'],
			'description' 		=> html_entity_decode($faq_tabs['description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8')
			);
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		 $this->response->setOutput($this->load->view('information/aridius_faq', $data));

	}
}
