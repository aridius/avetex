<?php
class ControllerExtensionModuleAridiusqckview extends Controller {
	
	private $error = array(); 
	
	public function index() {  
	
	    $this->load->language('extension/module/aridius_qckview');  
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
				$this->model_setting_setting->editSetting('module_aridius_qckview', $this->request->post);
				$this->session->data['success'] = $this->language->get('text_success');
				if (isset($this->request->post['apply'])) {
				$this->response->redirect($this->url->link('extension/module/aridius_qckview', 'user_token=' . $this->session->data['user_token'], true));
				} else {
				$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
				}
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}
		

		$data['error_warning'] = (isset($this->error['warning'])) ? $this->error['warning'] : '';

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
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
				'href' => $this->url->link('extension/module/aridius_qckview', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/aridius_qckview', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}
		
		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/aridius_qckview', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/aridius_qckview', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		

		if (isset($this->request->post['module_aridius_qckview_status'])) {
			$data['module_aridius_qckview_status'] = $this->request->post['module_aridius_qckview_status'];
		} else {
			$data['module_aridius_qckview_status'] = $this->config->get('module_aridius_qckview_status');
		}
		
		if (isset($this->request->post['module_aridius_qckview_tab_description'])) {
		$data['module_aridius_qckview_tab_description'] = $this->request->post['module_aridius_qckview_tab_description'];
		} else {
		$data['module_aridius_qckview_tab_description'] = $this->config->get('module_aridius_qckview_tab_description');       
		}   
		
		if (isset($this->request->post['module_aridius_qckview_tab_character'])) {
		$data['module_aridius_qckview_tab_character'] = $this->request->post['module_aridius_qckview_tab_character'];
		} else {
		$data['module_aridius_qckview_tab_character'] = $this->config->get('module_aridius_qckview_tab_character');       
		}   
		
		if (isset($this->request->post['module_aridius_qckview_tab_reviews'])) {
		$data['module_aridius_qckview_tab_reviews'] = $this->request->post['module_aridius_qckview_tab_reviews'];
		} else {
		$data['module_aridius_qckview_tab_reviews'] = $this->config->get('module_aridius_qckview_tab_reviews');       
		}   
		
		if (isset($this->request->post['module_aridius_qckview_tab_additional'])) {
		$data['module_aridius_qckview_tab_additional'] = $this->request->post['module_aridius_qckview_tab_additional'];
		} else {
		$data['module_aridius_qckview_tab_additional'] = $this->config->get('module_aridius_qckview_tab_additional');       
		}   

		$this->response->setOutput($this->load->view('extension/module/aridius_qckview', $data));
	}

	private function validate() {
		
		if (!$this->user->hasPermission('modify', 'extension/module/aridius_qckview')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
}
