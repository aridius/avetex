<?php
class ControllerExtensionModuleAridiusLivesearch extends Controller {
	
	private $error = array();

	   public function index() {

		$this->load->language('extension/module/aridius_livesearch');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_aridius_livesearch', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
		if (isset($this->request->post['apply'])) {
			$this->response->redirect($this->url->link('extension/module/aridius_livesearch', 'user_token=' . $this->session->data['user_token'], true));
        } else {
	        $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }
		}
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['aridius_livesearch_width'])) {
		$data['error_aridius_livesearch_width'] = $this->error['aridius_livesearch_width'];
		} else {
		$data['error_aridius_livesearch_width'] = '';
		}

		if (isset($this->error['aridius_livesearch_height'])) {
		$data['error_aridius_livesearch_height'] = $this->error['aridius_livesearch_height'];
		} else {
		$data['error_aridius_livesearch_height'] = '';
		}

		if (isset($this->error['aridius_livesearch_limit'])) {
		$data['error_aridius_livesearch_limit'] = $this->error['aridius_livesearch_limit'];
		} else {
		$data['error_aridius_livesearch_limit'] = '';
		}
		
		if (isset($this->error['aridius_livesearch_symbol'])) {
		$data['error_aridius_livesearch_symbol'] = $this->error['aridius_livesearch_symbol'];
		} else {
		$data['error_aridius_livesearch_symbol'] = '';
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
			'href' => $this->url->link('extension/module/aridius_livesearch', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/aridius_livesearch', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->post['module_aridius_livesearch_status'])) {
			$data['module_aridius_livesearch_status'] = $this->request->post['module_aridius_livesearch_status'];
		} else {
			$data['module_aridius_livesearch_status'] = $this->config->get('module_aridius_livesearch_status');
		}

		if (isset($this->request->post['module_aridius_livesearch_width'])) {
			$data['module_aridius_livesearch_width'] = $this->request->post['module_aridius_livesearch_width'];
		} elseif ($this->config->get('module_aridius_livesearch_width')) {
			$data['module_aridius_livesearch_width'] = $this->config->get('module_aridius_livesearch_width');
		} else {
			$data['module_aridius_livesearch_width'] = 40;
		}

		if (isset($this->request->post['module_aridius_livesearch_height'])) {
			$data['module_aridius_livesearch_height'] = $this->request->post['module_aridius_livesearch_height'];
		} elseif ($this->config->get('module_aridius_livesearch_height')) {
			$data['module_aridius_livesearch_height'] = $this->config->get('module_aridius_livesearch_height');
		} else {
			$data['module_aridius_livesearch_height'] = 40;
		}
		
		if (isset($this->request->post['module_aridius_livesearch_limit'])) {
			$data['module_aridius_livesearch_limit'] = $this->request->post['module_aridius_livesearch_limit'];
		} elseif ($this->config->get('module_aridius_livesearch_limit')) {
			$data['module_aridius_livesearch_limit'] = $this->config->get('module_aridius_livesearch_limit');
		} else {
			$data['module_aridius_livesearch_limit'] = 5;
		}
		
		if (isset($this->request->post['module_aridius_livesearch_symbol'])) {
			$data['module_aridius_livesearch_symbol'] = $this->request->post['module_aridius_livesearch_symbol'];
		} elseif ($this->config->get('module_aridius_livesearch_symbol')) {
			$data['module_aridius_livesearch_symbol'] = $this->config->get('module_aridius_livesearch_symbol');
		} else {
			$data['module_aridius_livesearch_symbol'] = 1;
		}

		if (isset($this->request->post['module_aridius_livesearch_livesearch_model'])) {
			$data['module_aridius_livesearch_livesearch_model'] = $this->request->post['module_aridius_livesearch_livesearch_model'];
		} else {
			$data['module_aridius_livesearch_livesearch_model'] = $this->config->get('module_aridius_livesearch_livesearch_model');
		}
		
		if (isset($this->request->post['module_aridius_livesearch_description'])) {
			$data['module_aridius_livesearch_description'] = $this->request->post['module_aridius_livesearch_description'];
		} else {
			$data['module_aridius_livesearch_description'] = $this->config->get('module_aridius_livesearch_description');
		}
		
		if (isset($this->request->post['module_aridius_livesearch_sku'])) {
			$data['module_aridius_livesearch_sku'] = $this->request->post['module_aridius_livesearch_sku'];
		} else {
			$data['module_aridius_livesearch_sku'] = $this->config->get('module_aridius_livesearch_sku');
		}
	
	   if (isset($this->request->post['module_aridius_livesearch_tag'])) {
			$data['module_aridius_livesearch_tag'] = $this->request->post['module_aridius_livesearch_tag'];
		} else {
			$data['module_aridius_livesearch_tag'] = $this->config->get('module_aridius_livesearch_tag');
		}
		
	   if (isset($this->request->post['module_aridius_livesearch_img'])) {
			$data['module_aridius_livesearch_img'] = $this->request->post['module_aridius_livesearch_img'];
		} else {
			$data['module_aridius_livesearch_img'] = $this->config->get('module_aridius_livesearch_img');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/aridius_livesearch', $data));
		}

	protected function validate() {
		
		if (!$this->user->hasPermission('modify', 'extension/module/aridius_livesearch')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['module_aridius_livesearch_width']) {
		$this->error['module_aridius_livesearch_width'] = $this->language->get('error_module_aridius_livesearch_width');
		}

		if (!$this->request->post['module_aridius_livesearch_height']) {
		$this->error['module_aridius_livesearch_height'] = $this->language->get('error_module_aridius_livesearch_height');
		}
		
		if (!$this->request->post['module_aridius_livesearch_limit']) {
		$this->error['module_aridius_livesearch_limit'] = $this->language->get('error_module_aridius_livesearch_limit');
		}
		
	    if (!$this->request->post['module_aridius_livesearch_symbol']) {
		$this->error['module_aridius_livesearch_symbol'] = $this->language->get('error_module_aridius_livesearch_symbol');
		}
		
		return !$this->error;
	}
		}