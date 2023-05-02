<?php
class ControllerExtensionModuleAridiusTextHome extends Controller {
	private $error = array();

	public function index() {

	    $this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
				
		$this->load->language('extension/module/aridius_text_home');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_aridius_text_home', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

						
			if (isset($this->request->post['apply'])) {
			$this->response->redirect($this->url->link('extension/module/aridius_text_home', 'user_token=' . $this->session->data['user_token'], true));
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
			'href' => $this->url->link('extension/module/aridius_text_home', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/aridius_text_home', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->post['module_aridius_text_home_status'])) {
			$data['module_aridius_text_home_status'] = $this->request->post['module_aridius_text_home_status'];
		} else {
			$data['module_aridius_text_home_status'] = $this->config->get('module_aridius_text_home_status');
		}
		
		if (isset($this->request->post['module_aridius_text_home_description'])) {
			$data['module_aridius_text_home_description'] = $this->request->post['module_aridius_text_home_description'];
		} else {
			$data['module_aridius_text_home_description'] = $this->config->get('module_aridius_text_home_description');
		}
		
		if (isset($this->request->post['module_aridius_text_home_limit'])) {
			$data['module_aridius_text_home_limit'] = $this->request->post['module_aridius_text_home_limit'];
		} elseif ($this->config->has('module_aridius_text_home_limit')) {
			$data['module_aridius_text_home_limit'] = $this->config->get('module_aridius_text_home_limit');
		} else {
			$data['module_aridius_text_home_limit'] = '2200';
		}
		
		if (isset($this->request->post['module_aridius_text_home_height'])) {
			$data['module_aridius_text_home_height'] = $this->request->post['module_aridius_text_home_height'];
		} elseif ($this->config->has('module_aridius_text_home_height')) {
			$data['module_aridius_text_home_height'] = $this->config->get('module_aridius_text_home_height');
		} else {
			$data['module_aridius_text_home_height'] = '150';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/aridius_text_home', $data));
		
	}

	protected function validate() {
		
		if (!$this->user->hasPermission('modify', 'extension/module/aridius_letters')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

}