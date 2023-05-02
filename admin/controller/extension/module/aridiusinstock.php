<?php
class ControllerExtensionModuleAridiusinstock extends Controller {
	
	private $error = array();

	public function index() {
		
		$this->load->language('extension/module/aridiusinstock');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_aridiusinstock', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
						if (isset($this->request->post['apply'])) {
			$this->response->redirect($this->url->link('extension/module/aridiusinstock', 'user_token=' . $this->session->data['user_token'], true));
            } else {
	        $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
            }
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		
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
			'href' => $this->url->link('extension/module/aridiusinstock', 'user_token=' . $this->session->data['user_token'], true)
		);
		
		$data['aridiusinstock'] = $this->url->link('catalog/aridiusinstock', 'user_token=' . $this->session->data['user_token'], true);
		$data['action'] = $this->url->link('extension/module/aridiusinstock', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		$this->load->language('extension/module/aridiusinstock');
	
		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->post['module_aridiusinstock_descriptionshow'])) {
			$data['module_aridiusinstock_descriptionshow'] = $this->request->post['module_aridiusinstock_descriptionshow'];
		} else {
			$data['module_aridiusinstock_descriptionshow'] = $this->config->get('module_aridiusinstock_descriptionshow');
		}

		if (isset($this->request->post['module_aridiusinstock_adddescriptionshow'])) {
			$data['module_aridiusinstock_adddescriptionshow'] = $this->request->post['module_aridiusinstock_adddescriptionshow'];
		} else {
			$data['module_aridiusinstock_adddescriptionshow'] = $this->config->get('module_aridiusinstock_adddescriptionshow');
		}
		
	    if (isset($this->request->post['module_aridiusinstock_description2'])) {
			$data['module_aridiusinstock_description2'] = $this->request->post['module_aridiusinstock_description2'];
		} else {
			$data['module_aridiusinstock_description2'] = $this->config->get('module_aridiusinstock_description2');
		}
		
		if (isset($this->request->post['module_aridiusinstock_img'])) {
			$data['module_aridiusinstock_img'] = $this->request->post['module_aridiusinstock_img'];
		} else {
			$data['module_aridiusinstock_img'] = $this->config->get('module_aridiusinstock_img');
		}

		if (isset($this->request->post['module_aridiusinstock_firstnameshow'])) {
			$data['module_aridiusinstock_firstnameshow'] = $this->request->post['module_aridiusinstock_firstnameshow'];
		} else {
			$data['module_aridiusinstock_firstnameshow'] = $this->config->get('module_aridiusinstock_firstnameshow');
		}
		
		if (isset($this->request->post['module_aridiusinstock_firstnamevalid'])) {
			$data['module_aridiusinstock_firstnamevalid'] = $this->request->post['module_aridiusinstock_firstnamevalid'];
		} else {
			$data['module_aridiusinstock_firstnamevalid'] = $this->config->get('module_aridiusinstock_firstnamevalid');
		}
		
		if (isset($this->request->post['module_aridiusinstock_mask'])) {
			$data['module_aridiusinstock_mask'] = $this->request->post['module_aridiusinstock_mask'];
		} else {
			$data['module_aridiusinstock_mask'] = $this->config->get('module_aridiusinstock_mask');
		}
		
		if (isset($this->request->post['module_aridiusinstock_placeholderfirstname'])) {
			$data['module_aridiusinstock_placeholderfirstname'] = $this->request->post['module_aridiusinstock_placeholderfirstname'];
		} else {
			$data['module_aridiusinstock_placeholderfirstname'] = $this->config->get('module_aridiusinstock_placeholderfirstname');
		}
		
		if (isset($this->request->post['module_aridiusinstock_tellshow'])) {
			$data['module_aridiusinstock_tellshow'] = $this->request->post['module_aridiusinstock_tellshow'];
		} else {
			$data['module_aridiusinstock_tellshow'] = $this->config->get('module_aridiusinstock_tellshow');
		}
		
		if (isset($this->request->post['module_aridiusinstock_tellvalid'])) {
			$data['module_aridiusinstock_tellvalid'] = $this->request->post['module_aridiusinstock_tellvalid'];
		} else {
			$data['module_aridiusinstock_tellvalid'] = $this->config->get('module_aridiusinstock_tellvalid');
		}
		
		if (isset($this->request->post['module_aridiusinstock_placeholdertell'])) {
			$data['module_aridiusinstock_placeholdertell'] = $this->request->post['module_aridiusinstock_placeholdertell'];
		} else {
			$data['module_aridiusinstock_placeholdertell'] = $this->config->get('module_aridiusinstock_placeholdertell');
		}
		
		if (isset($this->request->post['module_aridiusinstock_emailshow'])) {
			$data['module_aridiusinstock_emailshow'] = $this->request->post['module_aridiusinstock_emailshow'];
		} else {
			$data['module_aridiusinstock_emailshow'] = $this->config->get('module_aridiusinstock_emailshow');
		}
		
		if (isset($this->request->post['module_aridiusinstock_emailvalid'])) {
			$data['module_aridiusinstock_emailvalid'] = $this->request->post['module_aridiusinstock_emailvalid'];
		} else {
			$data['module_aridiusinstock_emailvalid'] = $this->config->get('module_aridiusinstock_emailvalid');
		}
		
		if (isset($this->request->post['module_aridiusinstock_placeholderemail'])) {
			$data['module_aridiusinstock_placeholderemail'] = $this->request->post['module_aridiusinstock_placeholderemail'];
		} else {
			$data['module_aridiusinstock_placeholderemail'] = $this->config->get('module_aridiusinstock_placeholderemail');
		}

		if (isset($this->request->post['module_aridiusinstock_description'])) {
			$data['module_aridiusinstock_description'] = $this->request->post['module_aridiusinstock_description'];
		} else {
			$data['module_aridiusinstock_description'] = $this->config->get('module_aridiusinstock_description');
		}

		if (isset($this->request->post['module_aridiusinstock_mail_send'])) {
			$data['module_aridiusinstock_mail_send'] = $this->request->post['module_aridiusinstock_mail_send'];
		} else {
			$data['module_aridiusinstock_mail_send'] = $this->config->get('module_aridiusinstock_mail_send');
		}

		if (isset($this->request->post['module_aridiusinstock_imgw'])) {
			$data['module_aridiusinstock_imgw'] = $this->request->post['module_aridiusinstock_imgw'];
		} elseif ($this->config->get('module_aridiusinstock_imgw')) {
			$data['module_aridiusinstock_imgw'] = $this->config->get('module_aridiusinstock_imgw');
		} else {
			$data['module_aridiusinstock_imgw'] = 150;
		}

		if (isset($this->request->post['module_aridiusinstock_imgh'])) {
			$data['module_aridiusinstock_imgh'] = $this->request->post['module_aridiusinstock_imgh'];
		} elseif ($this->config->get('module_aridiusinstock_imgh')) {
			$data['module_aridiusinstock_imgh'] = $this->config->get('module_aridiusinstock_imgh');
		} else {
			$data['module_aridiusinstock_imgh'] = 150;
		}

		if (isset($this->request->post['module_aridiusinstock_descchar'])) {
			$data['module_aridiusinstock_descchar'] = $this->request->post['module_aridiusinstock_descchar'];
		} elseif ($this->config->get('module_aridiusinstock_descchar')) {
			$data['module_aridiusinstock_descchar'] = $this->config->get('module_aridiusinstock_descchar');
		} else {
			$data['module_aridiusinstock_descchar'] = 190;
		}
		
		if (isset($this->request->post['module_aridiusinstock_status'])) {
			$data['module_aridiusinstock_status'] = $this->request->post['module_aridiusinstock_status'];
		} else {
			$data['module_aridiusinstock_status'] = $this->config->get('module_aridiusinstock_status');
		}
		
		$this->response->setOutput($this->load->view('extension/module/aridiusinstock', $data));
	}


	private function validate() {
		
		if (!$this->user->hasPermission('modify', 'extension/module/aridiusinstock')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function install() {
		
		$this->load->model('catalog/aridiusinstock');
		$this->load->model('setting/setting');
		$this->model_catalog_aridiusinstock->install();

	}

	public function uninstall() {
		
		$this->load->model('catalog/aridiusinstock');
		$this->load->model('setting/setting');
		$this->model_setting_setting->deleteSetting('aridiusinstock');
	}
	
}

