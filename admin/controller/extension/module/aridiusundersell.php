<?php
class ControllerExtensionModuleAridiusundersell extends Controller {
	
	private $error = array();

	public function index() {

		$this->load->language('extension/module/aridiusundersell');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		
	   if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_aridiusundersell', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

		if (isset($this->request->post['apply'])) {
			$this->response->redirect($this->url->link('extension/module/aridiusundersell', 'user_token=' . $this->session->data['user_token'], true));
            } else {
	        $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
            }
	
		}

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['heading_title'] = $this->language->get('heading_title');
		
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
			'href' => $this->url->link('extension/module/aridiusundersell', 'user_token=' . $this->session->data['user_token'], true)
		);
		
		$data['aridiusundersell'] = $this->url->link('catalog/aridiusundersell', 'user_token=' . $this->session->data['user_token'], true);
		
		$data['action'] = $this->url->link('extension/module/aridiusundersell', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
		
		$this->load->language('extension/module/aridiusundersell');
		
		$data['user_token'] = $this->session->data['user_token'];
	
		if (isset($this->request->post['module_aridiusundersell_descriptionshow'])) {
			$data['module_aridiusundersell_descriptionshow'] = $this->request->post['module_aridiusundersell_descriptionshow'];
		} else {
			$data['module_aridiusundersell_descriptionshow'] = $this->config->get('module_aridiusundersell_descriptionshow');
		}

		if (isset($this->request->post['module_aridiusundersell_adddescriptionshow'])) {
			$data['module_aridiusundersell_adddescriptionshow'] = $this->request->post['module_aridiusundersell_adddescriptionshow'];
		} else {
			$data['module_aridiusundersell_adddescriptionshow'] = $this->config->get('module_aridiusundersell_adddescriptionshow');
		}

		if (isset($this->request->post['module_aridiusundersell_description2'])) {
			$data['module_aridiusundersell_description2'] = $this->request->post['module_aridiusundersell_description2'];
		} else {
			$data['module_aridiusundersell_description2'] = $this->config->get('module_aridiusundersell_description2');
		}
		
		if (isset($this->request->post['module_aridiusundersell_img'])) {
			$data['module_aridiusundersell_img'] = $this->request->post['module_aridiusundersell_img'];
		} else {
			$data['module_aridiusundersell_img'] = $this->config->get('module_aridiusundersell_img');
		}
		
		if (isset($this->request->post['module_aridiusundersell_price'])) {
			$data['module_aridiusundersell_price'] = $this->request->post['module_aridiusundersell_price'];
		} else {
			$data['module_aridiusundersell_price'] = $this->config->get('module_aridiusundersell_price');
		}	
		
		if (isset($this->request->post['module_aridiusundersell_quantity'])) {
			$data['module_aridiusundersell_quantity'] = $this->request->post['module_aridiusundersell_quantity'];
		} else {
			$data['module_aridiusundersell_quantity'] = $this->config->get('module_aridiusundersell_quantity');
		}
		
		if (isset($this->request->post['module_aridiusundersell_firstnameshow'])) {
			$data['module_aridiusundersell_firstnameshow'] = $this->request->post['module_aridiusundersell_firstnameshow'];
		} else {
			$data['module_aridiusundersell_firstnameshow'] = $this->config->get('module_aridiusundersell_firstnameshow');
		}
		if (isset($this->request->post['module_aridiusundersell_firstnamevalid'])) {
			$data['module_aridiusundersell_firstnamevalid'] = $this->request->post['module_aridiusundersell_firstnamevalid'];
		} else {
			$data['module_aridiusundersell_firstnamevalid'] = $this->config->get('module_aridiusundersell_firstnamevalid');
		}
		
		if (isset($this->request->post['module_aridiusundersell_mask'])) {
			$data['module_aridiusundersell_mask'] = $this->request->post['module_aridiusundersell_mask'];
		} else {
			$data['module_aridiusundersell_mask'] = $this->config->get('module_aridiusundersell_mask');
		}
		
		if (isset($this->request->post['module_aridiusundersell_placeholderfirstname'])) {
			$data['module_aridiusundersell_placeholderfirstname'] = $this->request->post['module_aridiusundersell_placeholderfirstname'];
		} else {
			$data['module_aridiusundersell_placeholderfirstname'] = $this->config->get('module_aridiusundersell_placeholderfirstname');
		}
		
		if (isset($this->request->post['module_aridiusundersell_placeholdertell'])) {
			$data['module_aridiusundersell_placeholdertell'] = $this->request->post['module_aridiusundersell_placeholdertell'];
		} else {
			$data['module_aridiusundersell_placeholdertell'] = $this->config->get('module_aridiusundersell_placeholdertell');
		}
		
		if (isset($this->request->post['module_aridiusundersell_emailshow'])) {
			$data['module_aridiusundersell_emailshow'] = $this->request->post['module_aridiusundersell_emailshow'];
		} else {
			$data['module_aridiusundersell_emailshow'] = $this->config->get('module_aridiusundersell_emailshow');
		}
		
		if (isset($this->request->post['module_aridiusundersell_emailvalid'])) {
			$data['module_aridiusundersell_emailvalid'] = $this->request->post['module_aridiusundersell_emailvalid'];
		} else {
			$data['module_aridiusundersell_emailvalid'] = $this->config->get('module_aridiusundersell_emailvalid');
		}
		
		if (isset($this->request->post['module_aridiusundersell_placeholderemail'])) {
			$data['module_aridiusundersell_placeholderemail'] = $this->request->post['module_aridiusundersell_placeholderemail'];
		} else {
			$data['module_aridiusundersell_placeholderemail'] = $this->config->get('module_aridiusundersell_placeholderemail');
		}
		
		if (isset($this->request->post['module_aridiusundersell_commentshow'])) {
			$data['module_aridiusundersell_commentshow'] = $this->request->post['module_aridiusundersell_commentshow'];
		} else {
			$data['module_aridiusundersell_commentshow'] = $this->config->get('module_aridiusundersell_commentshow');
		}
		
		
	
		if (isset($this->request->post['module_aridiusundersell_placeholdercomment'])) {
			$data['module_aridiusundersell_placeholdercomment'] = $this->request->post['module_aridiusundersell_placeholdercomment'];
		} else {
			$data['module_aridiusundersell_placeholdercomment'] = $this->config->get('module_aridiusundersell_placeholdercomment');
		}
		
	
		if (isset($this->request->post['module_aridiusundersell_description'])) {
			$data['module_aridiusundersell_description'] = $this->request->post['module_aridiusundersell_description'];
		} else {
			$data['module_aridiusundersell_description'] = $this->config->get('module_aridiusundersell_description');
		}
		
		if (isset($this->request->post['module_aridiusundersell_imgw'])) {
			$data['module_aridiusundersell_imgw'] = $this->request->post['module_aridiusundersell_imgw'];
		} elseif ($this->config->get('module_aridiusundersell_imgw')) {
			$data['module_aridiusundersell_imgw'] = $this->config->get('module_aridiusundersell_imgw');
		} else {
			$data['module_aridiusundersell_imgw'] = 150;
		}
		
		if (isset($this->request->post['module_aridiusundersell_imgh'])) {
			$data['module_aridiusundersell_imgh'] = $this->request->post['module_aridiusundersell_imgh'];
		} elseif ($this->config->get('module_aridiusundersell_imgh')) {
			$data['module_aridiusundersell_imgh'] = $this->config->get('module_aridiusundersell_imgh');
		} else {
			$data['module_aridiusundersell_imgh'] = 150;
		}
		
		if (isset($this->request->post['module_aridiusundersell_descchar'])) {
			$data['module_aridiusundersell_descchar'] = $this->request->post['module_aridiusundersell_descchar'];
		} elseif ($this->config->get('module_aridiusundersell_descchar')) {
			$data['module_aridiusundersell_descchar'] = $this->config->get('module_aridiusundersell_descchar');
		} else {
			$data['module_aridiusundersell_descchar'] = 190;
		}
		
		if (isset($this->request->post['module_aridiusundersell_status'])) {
			$data['module_status'] = $this->request->post['module_aridiusundersell_status'];
		} else {
			$data['module_status'] = $this->config->get('module_aridiusundersell_status');
		}
		
		$this->response->setOutput($this->load->view('extension/module/aridiusundersell', $data));
	}

	private function validate() {
		
		if (!$this->user->hasPermission('modify', 'extension/module/aridiusundersell')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function install() {
		
		$this->load->model('catalog/aridiusundersell');
		$this->load->model('setting/setting');
		$this->model_catalog_aridiusundersell->install();
	}

	public function uninstall() {
		
		$this->load->model('catalog/aridiusundersell');
		$this->load->model('setting/setting');
	}
	
}
