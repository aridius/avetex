<?php
class ControllerExtensionModuleAridiusReviewCategory extends Controller {
	
	private $error = array();

	public function index() {
		
		$this->load->language('extension/module/aridius_review_category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_aridius_review_category', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
			$this->response->redirect($this->url->link('extension/module/aridius_review_category', 'user_token=' . $this->session->data['user_token'], true));
            } else {
	        $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
            }
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['aridius_review_category_chars'])) {
			$data['error_headline_chars'] = $this->error['aridius_review_category_chars'];
		} else {
			$data['error_headline_chars'] = '';
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

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/aridius_review_category', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/aridius_review_category', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}
		
		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/aridius_review_category', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/aridius_review_category', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->post['module_aridius_review_category_chars'])) {
			$data['module_aridius_review_category_chars'] = $this->request->post['module_aridius_review_category_chars'];
		} elseif ($this->config->get('module_aridius_review_category_chars')) {
			$data['module_aridius_review_category_chars'] = $this->config->get('module_aridius_review_category_chars');
		} else {
			$data['module_aridius_review_category_chars'] = 160;
		}
		
		if (isset($this->request->post['module_aridius_review_category_limit'])) {
			$data['module_aridius_review_category_limit'] = $this->request->post['module_aridius_review_category_limit'];
		} elseif ($this->config->get('module_aridius_review_category_limit')) {
			$data['module_aridius_review_category_limit'] = $this->config->get('module_aridius_review_category_limit');
		} else {
		$data['module_aridius_review_category_limit'] = 3;
		}
		
		if (isset($this->request->post['module_aridius_review_category_autoplay'])) {
			$data['module_aridius_review_category_autoplay'] = $this->request->post['module_aridius_review_category_autoplay'];
		} elseif ($this->config->get('module_aridius_review_category_autoplay')) {
			$data['module_aridius_review_category_autoplay'] = $this->config->get('module_aridius_review_category_autoplay');
		} else {
		$data['module_aridius_review_category_autoplay'] = 4000;
		}

		if (isset($this->request->post['module_aridius_review_category_autoplayon'])) {
			$data['module_aridius_review_category_autoplayon'] = $this->request->post['module_aridius_review_category_autoplayon'];
		} elseif ($this->config->get('module_aridius_review_category_autoplayon')) {
			$data['module_aridius_review_category_autoplayon'] = $this->config->get('module_aridius_review_category_autoplayon');
		} else {
		$data['module_aridius_review_category_autoplayon'] = 0;
		}

		if (isset($this->request->post['module_aridius_review_category_items'])) {
			$data['module_aridius_review_category_items'] = $this->request->post['module_aridius_review_category_items'];
		} elseif ($this->config->get('module_aridius_review_category_items')) {
			$data['module_aridius_review_category_items'] = $this->config->get('module_aridius_review_category_items');
		} else {
		$data['module_aridius_review_category_items'] = 2;
		}
		
		if (isset($this->request->post['module_aridius_review_category_rew_speed'])) {
			$data['module_aridius_review_category_rew_speed'] = $this->request->post['module_aridius_review_category_rew_speed'];
		} elseif ($this->config->get('module_aridius_review_category_rew_speed')) {
			$data['module_aridius_review_category_rew_speed'] = $this->config->get('module_aridius_review_category_rew_speed');
		} else {
		$data['module_aridius_review_category_rew_speed'] = 4000;
		}

		if (isset($this->request->post['module_aridius_review_category_navigation'])) {
			$data['module_aridius_review_category_navigation'] = $this->request->post['module_aridius_review_category_navigation'];
		} elseif ($this->config->get('module_aridius_review_category_navigation')) {
			$data['module_aridius_review_category_navigation'] = $this->config->get('module_aridius_review_category_navigation');
		} else {
		$data['module_aridius_review_category_navigation'] = 0;
		}

		if (isset($this->request->post['module_aridius_review_category_date'])) {
			$data['module_aridius_review_category_date'] = $this->request->post['module_aridius_review_category_date'];
		} elseif ($this->config->get('module_aridius_review_category_date')) {
			$data['module_aridius_review_category_date'] = $this->config->get('module_aridius_review_category_date');
		} else {
		$data['module_aridius_review_category_date'] = 0;
		}

		if (isset($this->request->post['module_aridius_review_category_stop'])) {
			$data['module_aridius_review_category_stop'] = $this->request->post['module_aridius_review_category_stop'];
		} elseif ($this->config->get('module_aridius_review_category_stop')) {
			$data['module_aridius_review_category_stop'] = $this->config->get('module_aridius_review_category_stop');
		} else {
		$data['module_aridius_review_category_stop'] = 0;
		}	

		if (isset($this->request->post['module_aridius_review_category_status'])) {
			$data['module_aridius_review_category_status'] = $this->request->post['module_aridius_review_category_status'];
		} else {
			$data['module_aridius_review_category_status'] = $this->config->get('module_aridius_review_category_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/aridius_review_category', $data));
	}

	protected function validate() {
		
		if (!$this->user->hasPermission('modify', 'extension/module/aridius_review_category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['module_aridius_review_category_chars']) {
			$this->error['aridius_review_category_chars'] = $this->language->get('error_headline_chars');
		}

		return !$this->error;
	}
}