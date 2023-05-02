<?php
class ControllerExtensionModuleAridiusPopupmail extends Controller {
	
	private $error = array();

	public function index() {
		
		$this->load->language('extension/module/aridius_popupmail');
		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
        
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_aridius_popupmail', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

	   //CKEditor


		$data['user_token'] = $this->session->data['user_token'];
		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
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
			'href' => $this->url->link('extension/module/aridius_popupmail', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/aridius_popupmail', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
		
		if (isset($this->request->post['module_aridius_popupmail_pl'])) {
			$data['module_aridius_popupmail_pl'] = $this->request->post['module_aridius_popupmail_pl'];
		} else {
			$data['module_aridius_popupmail_pl'] = $this->config->get('module_aridius_popupmail_pl');
		}
		
		if (isset($this->request->post['module_aridius_popupmail_placeholder'])) {
			$data['module_aridius_popupmail_placeholder'] = $this->request->post['module_aridius_popupmail_placeholder'];
		} else {
			$data['module_aridius_popupmail_placeholder'] = $this->config->get('module_aridius_popupmail_placeholder');
		}
		
		if (isset($this->request->post['module_aridius_popupmail_status'])) {
			$data['module_aridius_popupmail_status'] = $this->request->post['module_aridius_popupmail_status'];
		} else {
			$data['module_aridius_popupmail_status'] = $this->config->get('module_aridius_popupmail_status');
		}

		if (isset($this->request->post['module_aridius_popupmail_time'])) {
			$data['module_aridius_popupmail_time'] = $this->request->post['module_aridius_popupmail_time'];
		} else {
			$data['module_aridius_popupmail_time'] = $this->config->get('module_aridius_popupmail_time');
		}
		
		if (isset($this->request->post['module_aridius_popupmail_message'])) {
			$data['module_aridius_popupmail_message'] = $this->request->post['module_aridius_popupmail_message'];
		} else {
			$data['module_aridius_popupmail_message'] = $this->config->get('module_aridius_popupmail_message');
		}
		
		if (isset($this->request->post['module_aridius_popupmail_subject'])) {
			$data['module_aridius_popupmail_subject'] = $this->request->post['module_aridius_popupmail_subject'];
		} else {
			$data['module_aridius_popupmail_subject'] = $this->config->get('module_aridius_popupmail_subject');
		}
		
		if (isset($this->request->post['module_aridius_popupmail_img'])) {
			$data['module_aridius_popupmail_img'] = $this->request->post['module_aridius_popupmail_img'];
		} else {
			$data['module_aridius_popupmail_img'] = $this->config->get('module_aridius_popupmail_img');
		}
		
		if (isset($this->request->post['module_aridius_popupmail_delay'])) {
			$data['module_aridius_popupmail_delay'] = $this->request->post['module_aridius_popupmail_delay'];
		} else {
			$data['module_aridius_popupmail_delay'] = $this->config->get('module_aridius_popupmail_delay');
		}
		
		if (isset($this->request->post['module_aridius_popupmail_day'])) {
			$data['module_aridius_popupmail_day'] = $this->request->post['module_aridius_popupmail_day'];
		} else {
			$data['module_aridius_popupmail_day'] = $this->config->get('module_aridius_popupmail_day');
		}
		
		if (isset($this->request->post['module_aridius_popupmaildes_status'])) {
			$data['module_aridius_popupmaildes_status'] = $this->request->post['module_aridius_popupmaildes_status'];
		} else {
			$data['module_aridius_popupmaildes_status'] = $this->config->get('module_aridius_popupmaildes_status');
		}
		
		if (isset($this->request->post['module_aridius_popupmail_description'])) {
			$data['module_aridius_popupmail_description'] = $this->request->post['module_aridius_popupmail_description'];
		} else {
			$data['module_aridius_popupmail_description'] = $this->config->get('module_aridius_popupmail_description');
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('extension/module/aridius_popupmail', $data));
		}
	
	protected function validate() {

		if (!$this->user->hasPermission('modify', 'extension/module/aridius_popupmail')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}