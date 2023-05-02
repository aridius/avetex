<?php
class ControllerExtensionModuleAridiusPopuptext extends Controller {
	
	private $error = array();

	public function index() {
		
		$this->load->language('extension/module/aridius_popuptext');

	    $this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
				
		$this->load->model('setting/module');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('aridius_popuptext', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

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

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/aridius_popuptext', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/aridius_popuptext', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/aridius_popuptext', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/aridius_popuptext', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}
		
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

	    if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}

		if (isset($this->request->post['aridius_popuptext_time'])) {
			$data['aridius_popuptext_time'] = $this->request->post['aridius_popuptext_time'];
		} elseif (!empty($module_info)) {
			$data['aridius_popuptext_time'] = $module_info['aridius_popuptext_time'];
		} else {
			$data['aridius_popuptext_time'] = '';
		}
		
		if (isset($this->request->post['aridius_popuptext_delay'])) {
			$data['aridius_popuptext_delay'] = $this->request->post['aridius_popuptext_delay'];
		} elseif (!empty($module_info)) {
			$data['aridius_popuptext_delay'] = $module_info['aridius_popuptext_delay'];
		} else {
			$data['aridius_popuptext_delay'] = '';
		}
		
		if (isset($this->request->post['aridius_popuptext_day'])) {
			$data['aridius_popuptext_day'] = $this->request->post['aridius_popuptext_day'];
		} elseif (!empty($module_info)) {
			$data['aridius_popuptext_day'] = $module_info['aridius_popuptext_day'];
		} else {
			$data['aridius_popuptext_day'] = '';
		}
		
		if (isset($this->request->post['aridius_popuptext_description'])) {
			$data['aridius_popuptext_description'] = $this->request->post['aridius_popuptext_description'];
		} elseif (!empty($module_info)) {
			$data['aridius_popuptext_description'] = $module_info['aridius_popuptext_description'];
		} else {
			$data['aridius_popuptext_description'] = '';
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/aridius_popuptext', $data));
		}
	
	protected function validate() {

		if (!$this->user->hasPermission('modify', 'extension/module/aridius_popuptext')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
	
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		return !$this->error;
	}
}