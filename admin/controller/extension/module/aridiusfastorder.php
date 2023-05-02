<?php
class ControllerExtensionModuleAridiusfastorder extends Controller {
	
	private $error = array();

	public function index() {

		$this->load->language('extension/module/aridiusfastorder');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_aridiusfastorder', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
		  			if (isset($this->request->post['apply'])) {
			$this->response->redirect($this->url->link('extension/module/aridiusfastorder', 'user_token=' . $this->session->data['user_token'], true));
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
			'href' => $this->url->link('extension/module/aridiusfastorder', 'user_token=' . $this->session->data['user_token'], true)
		);
	

	    $data['action'] = $this->url->link('extension/module/aridiusfastorder', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
		

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('aridiusfastorder', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
		  			if (isset($this->request->post['apply'])) {
			$this->response->redirect($this->url->link('extension/module/aridiusfastorder', 'user_token=' . $this->session->data['user_token'], true));
            } else {
	        $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true));
            }
		}

		$this->load->language('extension/module/aridiusfastorder');
		
		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->post['module_aridiusfastorder_descriptionshow'])) {
			$data['module_aridiusfastorder_descriptionshow'] = $this->request->post['module_aridiusfastorder_descriptionshow'];
		} else {
			$data['module_aridiusfastorder_descriptionshow'] = $this->config->get('module_aridiusfastorder_descriptionshow');
		}

		if (isset($this->request->post['module_aridiusfastorder_adddescriptionshow'])) {
			$data['module_aridiusfastorder_adddescriptionshow'] = $this->request->post['module_aridiusfastorder_adddescriptionshow'];
		} else {
			$data['module_aridiusfastorder_adddescriptionshow'] = $this->config->get('module_aridiusfastorder_adddescriptionshow');
		}

		if (isset($this->request->post['module_aridiusfastorder_description2'])) {
			$data['module_aridiusfastorder_description2'] = $this->request->post['module_aridiusfastorder_description2'];
		} else {
			$data['module_aridiusfastorder_description2'] = $this->config->get('module_aridiusfastorder_description2');
		}
		
		if (isset($this->request->post['module_aridiusfastorder_img'])) {
			$data['module_aridiusfastorder_img'] = $this->request->post['module_aridiusfastorder_img'];
		} else {
			$data['module_aridiusfastorder_img'] = $this->config->get('module_aridiusfastorder_img');
		}
		
		if (isset($this->request->post['module_aridiusfastorder_price'])) {
			$data['module_aridiusfastorder_price'] = $this->request->post['module_aridiusfastorder_price'];
		} else {
			$data['module_aridiusfastorder_price'] = $this->config->get('module_aridiusfastorder_price');
		}	
		
		if (isset($this->request->post['module_aridiusfastorder_quantity'])) {
			$data['module_aridiusfastorder_quantity'] = $this->request->post['module_aridiusfastorder_quantity'];
		} else {
			$data['module_aridiusfastorder_quantity'] = $this->config->get('module_aridiusfastorder_quantity');
		}
		
		if (isset($this->request->post['module_aridiusfastorder_firstnameshow'])) {
			$data['module_aridiusfastorder_firstnameshow'] = $this->request->post['module_aridiusfastorder_firstnameshow'];
		} else {
			$data['module_aridiusfastorder_firstnameshow'] = $this->config->get('module_aridiusfastorder_firstnameshow');
		}
		
		if (isset($this->request->post['module_aridiusfastorder_firstnamevalid'])) {
			$data['module_aridiusfastorder_firstnamevalid'] = $this->request->post['module_aridiusfastorder_firstnamevalid'];
		} else {
			$data['module_aridiusfastorder_firstnamevalid'] = $this->config->get('module_aridiusfastorder_firstnamevalid');
		}
		
		if (isset($this->request->post['module_aridiusfastorder_mask'])) {
			$data['module_aridiusfastorder_mask'] = $this->request->post['module_aridiusfastorder_mask'];
		} else {
			$data['module_aridiusfastorder_mask'] = $this->config->get('module_aridiusfastorder_mask');
		}
		
		if (isset($this->request->post['module_aridiusfastorder_placeholderfirstname'])) {
			$data['module_aridiusfastorder_placeholderfirstname'] = $this->request->post['module_aridiusfastorder_placeholderfirstname'];
		} else {
			$data['module_aridiusfastorder_placeholderfirstname'] = $this->config->get('module_aridiusfastorder_placeholderfirstname');
		}
		
		if (isset($this->request->post['module_aridiusfastorder_placeholdertell'])) {
			$data['module_aridiusfastorder_placeholdertell'] = $this->request->post['module_aridiusfastorder_placeholdertell'];
		} else {
			$data['module_aridiusfastorder_placeholdertell'] = $this->config->get('module_aridiusfastorder_placeholdertell');
		}
		
		if (isset($this->request->post['module_aridiusfastorder_emailshow'])) {
			$data['module_aridiusfastorder_emailshow'] = $this->request->post['module_aridiusfastorder_emailshow'];
		} else {
			$data['module_aridiusfastorder_emailshow'] = $this->config->get('module_aridiusfastorder_emailshow');
		}
		
		if (isset($this->request->post['module_aridiusfastorder_emailvalid'])) {
			$data['module_aridiusfastorder_emailvalid'] = $this->request->post['module_aridiusfastorder_emailvalid'];
		} else {
			$data['module_aridiusfastorder_emailvalid'] = $this->config->get('module_aridiusfastorder_emailvalid');
		}
		
		if (isset($this->request->post['module_aridiusfastorder_placeholderemail'])) {
			$data['module_aridiusfastorder_placeholderemail'] = $this->request->post['module_aridiusfastorder_placeholderemail'];
		} else {
			$data['module_aridiusfastorder_placeholderemail'] = $this->config->get('module_aridiusfastorder_placeholderemail');
		}
		
		if (isset($this->request->post['module_aridiusfastorder_commentshow'])) {
			$data['module_aridiusfastorder_commentshow'] = $this->request->post['module_aridiusfastorder_commentshow'];
		} else {
			$data['module_aridiusfastorder_commentshow'] = $this->config->get('module_aridiusfastorder_commentshow');
		}
		
		if (isset($this->request->post['module_aridiusfastorder_placeholdercomment'])) {
			$data['module_aridiusfastorder_placeholdercomment'] = $this->request->post['module_aridiusfastorder_placeholdercomment'];
		} else {
			$data['module_aridiusfastorder_placeholdercomment'] = $this->config->get('module_aridiusfastorder_placeholdercomment');
		}
		
		if (isset($this->request->post['module_aridiusfastorder_description'])) {
			$data['module_aridiusfastorder_description'] = $this->request->post['module_aridiusfastorder_description'];
		} else {
			$data['module_aridiusfastorder_description'] = $this->config->get('module_aridiusfastorder_description');
		}
		
		if (isset($this->request->post['module_aridiusfastorder_imgw'])) {
			$data['module_aridiusfastorder_imgw'] = $this->request->post['module_aridiusfastorder_imgw'];
		} elseif ($this->config->get('module_aridiusfastorder_imgw')) {
			$data['module_aridiusfastorder_imgw'] = $this->config->get('module_aridiusfastorder_imgw');
		} else {
			$data['module_aridiusfastorder_imgw'] = 150;
		}
		
		if (isset($this->request->post['module_aridiusfastorder_imgh'])) {
			$data['module_aridiusfastorder_imgh'] = $this->request->post['module_aridiusfastorder_imgh'];
		} elseif ($this->config->get('module_aridiusfastorder_imgh')) {
			$data['module_aridiusfastorder_imgh'] = $this->config->get('module_aridiusfastorder_imgh');
		} else {
			$data['module_aridiusfastorder_imgh'] = 150;
		}
		
		if (isset($this->request->post['module_aridiusfastorder_descchar'])) {
			$data['module_aridiusfastorder_descchar'] = $this->request->post['module_aridiusfastorder_descchar'];
		} elseif ($this->config->get('module_aridiusfastorder_descchar')) {
			$data['module_aridiusfastorder_descchar'] = $this->config->get('module_aridiusfastorder_descchar');
		} else {
			$data['module_aridiusfastorder_descchar'] = 190;
		}
		
		if (isset($this->request->post['module_aridiusfastorder_order_status_id'])) {
			$data['module_aridiusfastorder_order_status_id'] = $this->request->post['module_aridiusfastorder_order_status_id'];
		} else {
			$data['module_aridiusfastorder_order_status_id'] = $this->config->get('module_aridiusfastorder_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();		
		
		if (isset($this->request->post['module_aridiusfastorder_status'])) {
			$data['module_aridiusfastorder_status'] = $this->request->post['module_aridiusfastorder_status'];
		} else {
			$data['module_aridiusfastorder_status'] = $this->config->get('module_aridiusfastorder_status');
		}

		$this->response->setOutput($this->load->view('extension/module/aridiusfastorder', $data));
	}

	private function validate() {
		
		if (!$this->user->hasPermission('modify', 'extension/module/aridiusfastorder')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function install($data) {
		$this->load->model('catalog/aridiusfastorder');
		$this->load->model('setting/setting');
		$this->model_catalog_aridiusfastorder->install();
	}

	public function uninstall() {
		$this->load->model('catalog/aridiusfastorder');
		$this->load->model('setting/setting');
	}
	
}
