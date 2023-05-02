<?php
class ControllerExtensionModuleAridiusFaq extends Controller {
	private $error = array();

	public function index() {

	    $this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
				
		$this->load->language('extension/module/aridius_faq');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_aridius_faq', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

						
			if (isset($this->request->post['apply'])) {
			$this->response->redirect($this->url->link('extension/module/aridius_faq', 'user_token=' . $this->session->data['user_token'], true));
            } else {
	        $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
            }
		}

		$data['user_token'] = $this->session->data['user_token'];
		
		if (isset($this->error['aridius_faq_name'])) {
			$data['error_name'] = $this->error['aridius_faq_name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/aridius_faq', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/aridius_faq', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->post['module_aridius_faq_status'])) {
			$data['module_aridius_faq_status'] = $this->request->post['module_aridius_faq_status'];
		} else {
			$data['module_aridius_faq_status'] = $this->config->get('module_aridius_faq_status');
		}
	
		$data['top_links'] = array();
		if (isset($this->request->post['module_aridius_faq_top_links'])) {
		  $data['top_links'] = $this->request->post['module_aridius_faq_top_links'];
		} elseif ($this->config->get('module_aridius_faq_top_links')) {
		  $data['top_links'] = $this->config->get('module_aridius_faq_top_links');
		}
	
		if (isset($this->request->post['module_aridius_faq_description2'])) {
			$data['module_aridius_faq_description2'] = $this->request->post['module_aridius_faq_description2'];
		} else {
			$data['module_aridius_faq_description2'] = $this->config->get('module_aridius_faq_description2');
		}
	
		if (isset($this->request->post['module_aridius_faq_description'])) {
			$data['module_aridius_faq_description'] = $this->request->post['module_aridius_faq_description'];
		} else {
			$data['module_aridius_faq_description'] = $this->config->get('module_aridius_faq_description');
		}
	
		if (isset($this->request->post['module_aridius_faq_name'])) {
			$data['module_aridius_faq_name'] = $this->request->post['module_aridius_faq_name'];
		} else {
			$data['module_aridius_faq_name'] = $this->config->get('module_aridius_faq_name');
		}
		
		if (isset($this->request->post['module_aridius_faq_meta_title'])) {
			$data['module_aridius_faq_meta_title'] = $this->request->post['module_aridius_faq_meta_title'];
		} else {
			$data['module_aridius_faq_meta_title'] = $this->config->get('module_aridius_faq_meta_title');
		}
		
		if (isset($this->request->post['module_aridius_faq_meta_description'])) {
			$data['module_aridius_faq_meta_description'] = $this->request->post['module_aridius_faq_meta_description'];
		} else {
			$data['module_aridius_faq_meta_description'] = $this->config->get('module_aridius_faq_meta_description');
		}
		
		if (isset($this->request->post['module_aridius_faq_meta_keyword'])) {
			$data['module_aridius_faq_meta_keyword'] = $this->request->post['module_aridius_faq_meta_keyword'];
		} else {
			$data['module_aridius_faq_meta_keyword'] = $this->config->get('module_aridius_faq_meta_keyword');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/aridius_faq', $data));
		
	}
	
	protected function validate() {

	if (!$this->user->hasPermission('modify', 'extension/module/aridius_faq')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}


	public function install() {
		
	    // seo
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		foreach ($languages as $language) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "seo_url` (query, keyword, language_id) VALUES ('information/aridius_faq', 'faq', '".(int)$language['language_id']."')");
        }
		
		// check aridius_faq layout name
		$sql = "SELECT layout_id FROM `" . DB_PREFIX . "layout` WHERE `name` LIKE 'Faq' LIMIT 1";

		$query_name = $this->db->query($sql);

		if ($query_name->num_rows == 0) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "layout` SET `name`= 'Faq'");
		}

		// check aridius_faq layout route by store
		$stores = array(0);

		$sql = "SELECT store_id FROM `" . DB_PREFIX . "store`";

		$query_store = $this->db->query($sql);

		foreach ($query_store->rows as $store) {
			$stores[] = $store['store_id'];
		}

		$newRoutes = array('information/aridius_faq');

		foreach ($newRoutes as $newRoute) {
			foreach ($stores as $store_id) {
				$sql = "SELECT layout_id FROM `" . DB_PREFIX . "layout_route` WHERE `store_id`= '" . (int)$store_id . "' AND `route` LIKE '" . $newRoute . "' LIMIT 1";

				$query = $this->db->query($sql);

				if ($query->num_rows == 0) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "layout_route` SET `layout_id`= (SELECT layout_id FROM `" . DB_PREFIX . "layout` WHERE `name` LIKE 'Faq' LIMIT 1), `store_id`='" . (int)$store_id . "', `route`='" . $newRoute . "'");
				}
			}
		}
	}
}